<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\NotificationModel;

class ProfileController extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        return view('customer/profile', [
            'user' => (new UserModel())->find($userId),
        ]);
    }

    public function update()
    {
        $userId = session()->get('user_id');
        $rules = [
            'nama'         => 'required|max_length[100]',
            'no_whatsapp'  => 'permit_empty|max_length[20]',
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to('/customer/profile');
        }

        (new UserModel())->update($userId, [
            'nama'        => strip_tags($this->request->getPost('nama')),
            'no_whatsapp' => $this->request->getPost('no_whatsapp'),
        ]);

        session()->set('nama', strip_tags($this->request->getPost('nama')));
        session()->setFlashdata('success', 'Profil berhasil diperbarui.');
        return redirect()->to('/customer/profile');
    }

    public function changePassword()
    {
        $userId = session()->get('user_id');
        $user   = (new UserModel())->find($userId);

        if (!password_verify($this->request->getPost('current_password'), $user['password'] ?? '')) {
            session()->setFlashdata('error', 'Password saat ini tidak benar.');
            return redirect()->to('/customer/profile');
        }

        $rules = [
            'new_password'         => 'required|min_length[8]',
            'new_password_confirm' => 'required|matches[new_password]',
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to('/customer/profile');
        }

        (new UserModel())->update($userId, [
            'password' => password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT),
        ]);

        session()->setFlashdata('success', 'Password berhasil diubah.');
        return redirect()->to('/customer/profile');
    }

    public function notifications()
    {
        $userId = session()->get('user_id');
        $notifModel = new NotificationModel();
        $notifModel->markAllRead($userId);

        return view('customer/notifications', [
            'notifications' => $notifModel->getForUser($userId),
        ]);
    }

    public function markRead()
    {
        $userId = session()->get('user_id');
        (new NotificationModel())->markAllRead($userId);
        return $this->response->setJSON(['success' => true]);
    }
}
