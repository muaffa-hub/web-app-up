<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;

class PasswordController extends BaseController
{
    public function forgot()
    {
        return view('auth/forgot_password');
    }

    public function sendReset()
    {
        $email = $this->request->getPost('email');

        if (!$this->validate(['email' => 'required|valid_email'])) {
            session()->setFlashdata('error', 'Email tidak valid.');
            return redirect()->to('/forgot-password');
        }

        $userModel = new UserModel();
        $user = $userModel->findByEmail($email);

        if ($user) {
            $token = bin2hex(random_bytes(32));
            $this->db->table('password_resets')->insert([
                'email'      => $email,
                'token'      => $token,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            try {
                $emailService = service('email');
                $resetUrl = base_url('/reset-password/' . $token);
                $emailService->setTo($email);
                $emailService->setSubject('Reset Password - Unit Produksi Sekolah');
                $emailService->setMessage(view('emails/reset_password', ['resetUrl' => $resetUrl]));
                $emailService->setMailType('html');
                $emailService->send();
            } catch (\Exception $e) {
                log_message('error', 'Failed to send reset email: ' . $e->getMessage());
            }
        }

        session()->setFlashdata('success', 'Jika email terdaftar, link reset password telah dikirim.');
        return redirect()->to('/forgot-password');
    }

    public function reset(string $token)
    {
        $reset = $this->db->table('password_resets')
            ->where('token', $token)
            ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-1 hour')))
            ->get()->getRowArray();

        if (!$reset) {
            session()->setFlashdata('error', 'Link reset tidak valid atau sudah kedaluwarsa.');
            return redirect()->to('/forgot-password');
        }

        return view('auth/reset_password', ['token' => $token]);
    }

    public function processReset()
    {
        $token = $this->request->getPost('token');

        $rules = [
            'password'         => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to('/reset-password/' . $token);
        }

        $reset = $this->db->table('password_resets')
            ->where('token', $token)
            ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-1 hour')))
            ->get()->getRowArray();

        if (!$reset) {
            session()->setFlashdata('error', 'Link reset tidak valid atau sudah kedaluwarsa.');
            return redirect()->to('/forgot-password');
        }

        $userModel = new UserModel();
        $user = $userModel->findByEmail($reset['email']);

        if ($user) {
            $userModel->update($user['id'], [
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            ]);
        }

        $this->db->table('password_resets')->where('token', $token)->delete();

        session()->setFlashdata('success', 'Password berhasil diubah. Silakan login.');
        return redirect()->to('/login');
    }
}
