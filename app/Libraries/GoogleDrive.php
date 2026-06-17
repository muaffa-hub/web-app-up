<?php

namespace App\Libraries;

use App\Models\StoreInfoModel;

class GoogleDrive
{
    protected $config;
    protected ?array $store = null;

    public function __construct()
    {
        $this->config = config('GoogleDrive');
    }

    public function isConfigured(): bool
    {
        return $this->config->clientId !== '' && $this->config->clientSecret !== '';
    }

    public function isConnected(): bool
    {
        return $this->isConfigured() && !empty($this->store()['gdrive_refresh_token']);
    }

    public function connectedEmail(): ?string
    {
        return $this->store()['gdrive_email'] ?? null;
    }

    public function getAuthUrl(): string
    {
        $params = [
            'client_id'              => $this->config->clientId,
            'redirect_uri'           => $this->config->redirectUri(),
            'response_type'          => 'code',
            'scope'                  => 'https://www.googleapis.com/auth/drive.file https://www.googleapis.com/auth/userinfo.email',
            'access_type'            => 'offline',
            'prompt'                 => 'consent',
            'include_granted_scopes' => 'true',
        ];

        return 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
    }

    public function exchangeCode(string $code): bool
    {
        $res = $this->post('https://oauth2.googleapis.com/token', [
            'code'          => $code,
            'client_id'     => $this->config->clientId,
            'client_secret' => $this->config->clientSecret,
            'redirect_uri'  => $this->config->redirectUri(),
            'grant_type'    => 'authorization_code',
        ]);

        if (empty($res['refresh_token'])) {
            log_message('error', 'GoogleDrive exchangeCode gagal: ' . json_encode($res));
            return false;
        }

        $email = null;
        if (!empty($res['access_token'])) {
            $email = $this->fetchEmail($res['access_token']);
        }

        $model = new StoreInfoModel();
        $row   = $model->first();
        $model->update($row['id'], [
            'gdrive_refresh_token' => $res['refresh_token'],
            'gdrive_email'         => $email,
        ]);
        $this->store = null;

        return true;
    }

    public function disconnect(): void
    {
        $model = new StoreInfoModel();
        $row   = $model->first();
        $model->update($row['id'], ['gdrive_refresh_token' => null, 'gdrive_email' => null]);
        $this->store = null;
    }

    public function getAccessToken(): ?string
    {
        $refresh = $this->store()['gdrive_refresh_token'] ?? null;
        if (!$refresh) {
            return null;
        }

        $res = $this->post('https://oauth2.googleapis.com/token', [
            'client_id'     => $this->config->clientId,
            'client_secret' => $this->config->clientSecret,
            'refresh_token' => $refresh,
            'grant_type'    => 'refresh_token',
        ]);

        return $res['access_token'] ?? null;
    }

    public function uploadFile(string $localPath, string $name): ?array
    {
        if (!is_file($localPath)) {
            return null;
        }

        $token = $this->getAccessToken();
        if (!$token) {
            log_message('error', 'GoogleDrive uploadFile: tidak dapat access token.');
            return null;
        }

        $metadata = ['name' => $name];
        if ($this->config->folderId !== '') {
            $metadata['parents'] = [$this->config->folderId];
        }

        $boundary = 'fp_' . bin2hex(random_bytes(8));
        $mime     = mime_content_type($localPath) ?: 'application/octet-stream';

        $body  = "--{$boundary}\r\n";
        $body .= "Content-Type: application/json; charset=UTF-8\r\n\r\n";
        $body .= json_encode($metadata) . "\r\n";
        $body .= "--{$boundary}\r\n";
        $body .= "Content-Type: {$mime}\r\n\r\n";
        $body .= file_get_contents($localPath) . "\r\n";
        $body .= "--{$boundary}--";

        $ch = curl_init('https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart&fields=id,webViewLink');
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $body,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $token,
                'Content-Type: multipart/related; boundary=' . $boundary,
                'Content-Length: ' . strlen($body),
            ],
            CURLOPT_TIMEOUT => 120,
        ]);
        $out  = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $res = json_decode($out, true);
        if ($code < 200 || $code >= 300 || empty($res['id'])) {
            log_message('error', 'GoogleDrive uploadFile gagal (' . $code . '): ' . $out);
            return null;
        }

        return [
            'id'  => $res['id'],
            'url' => $res['webViewLink'] ?? ('https://drive.google.com/file/d/' . $res['id'] . '/view'),
        ];
    }

    protected function fetchEmail(string $accessToken): ?string
    {
        $ch = curl_init('https://www.googleapis.com/oauth2/v2/userinfo');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $accessToken],
            CURLOPT_TIMEOUT        => 20,
        ]);
        $out = curl_exec($ch);
        curl_close($ch);

        $res = json_decode($out, true);
        return $res['email'] ?? null;
    }

    protected function post(string $url, array $fields): array
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($fields),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
        ]);
        $out = curl_exec($ch);
        curl_close($ch);

        return json_decode($out, true) ?? [];
    }

    protected function store(): array
    {
        if ($this->store === null) {
            $this->store = (new StoreInfoModel())->first() ?? [];
        }
        return $this->store;
    }
}
