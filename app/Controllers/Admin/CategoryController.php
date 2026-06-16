<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    public function index()
    {
        return view('admin/categories', [
            'categories' => (new CategoryModel())->where('deleted_at IS NULL')->findAll(),
        ]);
    }

    public function store()
    {
        $rules = [
            'nama_kategori' => 'required|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to('/admin/categories');
        }

        $model = new CategoryModel();
        $nama  = strip_tags($this->request->getPost('nama_kategori'));
        $model->insert([
            'nama_kategori' => $nama,
            'slug'          => $model->generateSlug($nama),
            'is_active'     => (int)$this->request->getPost('is_active'),
        ]);

        session()->setFlashdata('success', 'Kategori berhasil ditambahkan.');
        return redirect()->to('/admin/categories');
    }

    public function edit(int $id)
    {
        $category = (new CategoryModel())->find($id);
        if (!$category) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        return view('admin/category_form', ['category' => $category]);
    }

    public function update(int $id)
    {
        $rules = ['nama_kategori' => 'required|max_length[100]'];
        if (!$this->validate($rules)) {
            session()->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to('/admin/categories/edit/' . $id);
        }

        $model = new CategoryModel();
        $nama  = strip_tags($this->request->getPost('nama_kategori'));
        $model->update($id, [
            'nama_kategori' => $nama,
            'slug'          => $model->generateSlug($nama),
            'is_active'     => (int)$this->request->getPost('is_active'),
        ]);

        session()->setFlashdata('success', 'Kategori berhasil diperbarui.');
        return redirect()->to('/admin/categories');
    }

    public function delete(int $id)
    {
        (new CategoryModel())->delete($id);
        session()->setFlashdata('success', 'Kategori berhasil dihapus.');
        return redirect()->to('/admin/categories');
    }
}
