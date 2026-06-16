<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AdminProfileController extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $user  = $model->find(session()->get('user_id'));

        return view('admin/admin_profile', [
            'pageTitle' => 'Profil Akun',
            'user'      => $user,
        ]);
    }

    public function updateEmail()
    {
        $model    = new UserModel();
        $userId   = session()->get('user_id');
        $user     = $model->find($userId);
        $newEmail = trim($this->request->getPost('email'));
        $password = $this->request->getPost('password');

        if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            session()->setFlashdata('error', 'Format email tidak valid.');
            return redirect()->to('/admin/profile');
        }

        if (!password_verify($password, $user['password'])) {
            session()->setFlashdata('error', 'Password salah. Konfirmasi password diperlukan untuk mengubah email.');
            return redirect()->to('/admin/profile');
        }

        $existing = $model->where('email', $newEmail)->where('id !=', $userId)->first();
        if ($existing) {
            session()->setFlashdata('error', 'Email sudah digunakan akun lain.');
            return redirect()->to('/admin/profile');
        }

        $model->update($userId, ['email' => $newEmail]);
        session()->set('email', $newEmail);

        session()->setFlashdata('success', 'Email berhasil diperbarui.');
        return redirect()->to('/admin/profile');
    }

    public function updatePassword()
    {
        $userId      = session()->get('user_id');
        $model       = new UserModel();
        $user        = $model->find($userId);
        $current     = $this->request->getPost('current_password');
        $newPass     = $this->request->getPost('new_password');
        $confirmPass = $this->request->getPost('confirm_password');

        if (!password_verify($current, $user['password'])) {
            session()->setFlashdata('error', 'Password saat ini salah.');
            return redirect()->to('/admin/profile');
        }

        if (strlen($newPass) < 8) {
            session()->setFlashdata('error', 'Password baru minimal 8 karakter.');
            return redirect()->to('/admin/profile');
        }

        if ($newPass !== $confirmPass) {
            session()->setFlashdata('error', 'Konfirmasi password tidak cocok.');
            return redirect()->to('/admin/profile');
        }

        $model->update($userId, ['password' => password_hash($newPass, PASSWORD_DEFAULT)]);

        session()->setFlashdata('success', 'Password berhasil diubah.');
        return redirect()->to('/admin/profile');
    }
}
