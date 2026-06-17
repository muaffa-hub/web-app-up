<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class GoogleDrive extends BaseConfig
{
    public string $clientId     = '';
    public string $clientSecret = '';
    public string $folderId     = '';

    public function redirectUri(): string
    {
        return rtrim(base_url(), '/') . '/admin/drive/callback';
    }
}
