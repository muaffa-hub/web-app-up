<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\CartModel;

class LoginController extends BaseController
{
    public function index()
    {
        if (session()->get('user_id')) {
            return $this->redirectByRole();
        }
        return view('auth/login');
    }

    public function process()
    {
        $throttler = service('throttler');
        if (!$throttler->check(md5($this->request->getIPAddress()), 5, MINUTE * 10)) {
            session()->setFlashdata('error', 'Terlalu banyak percobaan login. Coba lagi dalam 10 menit.');
            return redirect()->to('/login');
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to('/login')->withInput();
        }

        $userModel = new UserModel();
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'] ?? '')) {
            session()->setFlashdata('error', 'Email atau password salah.');
            return redirect()->to('/login')->withInput();
        }

        $this->createUserSession($user);
        $this->mergeGuestCart($user['id']);

        return $this->redirectByRole();
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function googleRedirect()
    {
        session()->setFlashdata('error', 'Google OAuth belum dikonfigurasi. Hubungi Admin.');
        return redirect()->to('/login');
    }

    public function googleCallback()
    {
        session()->setFlashdata('error', 'Google OAuth belum dikonfigurasi.');
        return redirect()->to('/login');
    }

    private function createUserSession(array $user): void
    {
        session()->set([
            'user_id'   => $user['id'],
            'nama'      => $user['nama'],
            'email'     => $user['email'],
            'role'      => $user['role'],
            'logged_in' => true,
        ]);
    }

    private function mergeGuestCart(int $userId): void
    {
        $guestCart = session()->get('guest_cart') ?? [];
        if (!empty($guestCart)) {
            (new CartModel())->mergeGuestCart($userId, $guestCart);
            session()->remove('guest_cart');
        }
    }

    private function redirectByRole()
    {
        return match(session()->get('role')) {
            'admin'   => redirect()->to('/admin/dashboard'),
            'petugas' => redirect()->to('/admin/orders'),
            default   => redirect()->to('/catalog'),
        };
    }
}
