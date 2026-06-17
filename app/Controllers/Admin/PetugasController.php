<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class PetugasController extends BaseController
{
    public function index()
    {
        return view('admin/petugas', [
            'list' => (new UserModel())
                ->whereIn('role', ['petugas', 'admin'])
                ->where('deleted_at IS NULL')
                ->orderBy('created_at', 'DESC')
                ->findAll(),
        ]);
    }

    public function store()
    {
        $rules = [
            'nama'     => 'required|max_length[100]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to('/admin/petugas');
        }

        (new UserModel())->insert([
            'nama'     => strip_tags($this->request->getPost('nama')),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'petugas',
        ]);

        session()->setFlashdata('success', 'Akun petugas berhasil dibuat.');
        return redirect()->to('/admin/petugas');
    }

    public function delete(int $id)
    {
        $model = new UserModel();
        $user  = $model->find($id);

        if (!$user || $user['role'] !== 'petugas') {
            session()->setFlashdata('error', 'Akun tidak ditemukan.');
            return redirect()->to('/admin/petugas');
        }

        $model->delete($id);
        session()->setFlashdata('success', 'Akun petugas berhasil dihapus.');
        return redirect()->to('/admin/petugas');
    }

    public function changeRole(int $id)
    {
        $model = new UserModel();
        $user  = $model->find($id);

        if (!$user || !in_array($user['role'], ['petugas', 'admin'], true)) {
            session()->setFlashdata('error', 'Akun tidak ditemukan.');
            return redirect()->to('/admin/petugas');
        }

        if ((int) session()->get('user_id') === $id) {
            session()->setFlashdata('error', 'Tidak dapat mengubah role akun sendiri.');
            return redirect()->to('/admin/petugas');
        }

        $role = $this->request->getPost('role');
        if (!in_array($role, ['petugas', 'admin'], true)) {
            session()->setFlashdata('error', 'Role tidak valid.');
            return redirect()->to('/admin/petugas');
        }

        if ($user['role'] === 'admin' && $role !== 'admin') {
            $adminCount = $model->where('role', 'admin')->where('deleted_at IS NULL')->countAllResults();
            if ($adminCount <= 1) {
                session()->setFlashdata('error', 'Minimal harus ada satu admin.');
                return redirect()->to('/admin/petugas');
            }
        }

        $model->update($id, ['role' => $role]);
        session()->setFlashdata('success', 'Role akun berhasil diperbarui.');
        return redirect()->to('/admin/petugas');
    }

    public function resetPassword(int $id)
    {
        $model = new UserModel();
        $user  = $model->find($id);

        if (!$user || !in_array($user['role'], ['petugas', 'admin'], true)) {
            session()->setFlashdata('error', 'Akun tidak ditemukan.');
            return redirect()->to('/admin/petugas');
        }

        $password = $this->request->getPost('password');
        if (!$password || strlen($password) < 8) {
            session()->setFlashdata('error', 'Password minimal 8 karakter.');
            return redirect()->to('/admin/petugas');
        }

        $model->update($id, ['password' => password_hash($password, PASSWORD_DEFAULT)]);
        session()->setFlashdata('success', 'Password petugas berhasil direset.');
        return redirect()->to('/admin/petugas');
    }
}
