<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\ProductImageModel;
use App\Models\CategoryModel;

class ProductAdminController extends BaseController
{
    public function index()
    {
        return view('admin/products', [
            'products' => (new ProductModel())->getWithCategory(null, null, null, false),
        ]);
    }

    public function create()
    {
        return view('admin/product_form', [
            'categories' => (new CategoryModel())->getActive(),
            'product'    => null,
        ]);
    }

    public function store()
    {
        $rules = [
            'nama_produk'  => 'required|max_length[200]',
            'category_id'  => 'required|integer',
            'harga'        => 'required|decimal',
            'stok'         => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to('/admin/products/create');
        }

        $productId = (new ProductModel())->insert([
            'category_id'  => $this->request->getPost('category_id'),
            'nama_produk'  => strip_tags($this->request->getPost('nama_produk')),
            'deskripsi'    => strip_tags($this->request->getPost('deskripsi') ?? '', '<h1><h2><h3><p><strong><em><u><s><ul><ol><li><blockquote><pre><code><a><br><span>'),
            'harga'        => $this->request->getPost('harga'),
            'stok'         => $this->request->getPost('stok'),
            'is_custom'    => $this->request->getPost('is_custom') ? 1 : 0,
        ]);

        $this->uploadProductImages($productId);

        session()->setFlashdata('success', 'Produk berhasil ditambahkan.');
        return redirect()->to('/admin/products');
    }

    public function edit(int $id)
    {
        $product = (new ProductModel())->getDetailWithImages($id, false);
        if (!$product) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        return view('admin/product_form', [
            'product'    => $product,
            'categories' => (new CategoryModel())->getActive(),
        ]);
    }

    public function update(int $id)
    {
        $rules = [
            'nama_produk' => 'required|max_length[200]',
            'category_id' => 'required|integer',
            'harga'       => 'required|decimal',
            'stok'        => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to('/admin/products/edit/' . $id);
        }

        (new ProductModel())->update($id, [
            'category_id' => $this->request->getPost('category_id'),
            'nama_produk' => strip_tags($this->request->getPost('nama_produk')),
            'deskripsi'   => strip_tags($this->request->getPost('deskripsi') ?? '', '<b><i><ul><li><p>'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
            'is_custom'   => $this->request->getPost('is_custom') ? 1 : 0,
        ]);

        $this->uploadProductImages($id);

        session()->setFlashdata('success', 'Produk berhasil diperbarui.');
        return redirect()->to('/admin/products');
    }

    public function uploadContentImage()
    {
        $file = $this->request->getFile('image');
        if (!$file || !$file->isValid()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'No file']);
        }

        $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (!in_array($file->getMimeType(), $allowed) || $file->getSize() > 5 * 1024 * 1024) {
            return $this->response->setStatusCode(422)->setJSON(['error' => 'Invalid file']);
        }

        $savePath = WRITEPATH . 'uploads/content/';
        if (!is_dir($savePath)) mkdir($savePath, 0777, true);

        $newName = bin2hex(random_bytes(16)) . '.' . $file->getClientExtension();
        $file->move($savePath, $newName);

        return $this->response->setJSON(['url' => base_url('content-image/' . $newName)]);
    }

    public function toggle(int $id)
    {
        $model   = new ProductModel();
        $product = $model->find($id);
        if ($product) {
            $model->update($id, ['is_tampil' => $product['is_tampil'] ? 0 : 1]);
        }
        return redirect()->to('/admin/products');
    }

    public function delete(int $id)
    {
        (new ProductModel())->delete($id);
        session()->setFlashdata('success', 'Produk berhasil dihapus.');
        return redirect()->to('/admin/products');
    }

    public function deleteImage(int $id)
    {
        $imageModel = new ProductImageModel();
        $image = $imageModel->find($id);
        if ($image) {
            $path = WRITEPATH . 'uploads/products/' . basename($image['file_path']);
            if (file_exists($path)) @unlink($path);
            $imageModel->delete($id);
        }
        return $this->response->setJSON(['success' => true]);
    }

    private function uploadProductImages(int $productId): void
    {
        $files = $this->request->getFileMultiple('foto_produk');
        if (!$files) return;

        $imageModel = new ProductImageModel();
        $urutan     = (int)$this->db->table('product_images')->where('product_id', $productId)->countAllResults();

        foreach ($files as $file) {
            if (!$file->isValid() || $file->hasMoved()) continue;

            $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
            if (!in_array($file->getMimeType(), $allowedMimes)) continue;
            if ($file->getSize() > 5 * 1024 * 1024) continue;

            $newName = bin2hex(random_bytes(16)) . '.' . $file->getClientExtension();
            $file->move(WRITEPATH . 'uploads/products/', $newName);
            $imageModel->insert([
                'product_id' => $productId,
                'file_path'  => $newName,
                'urutan'     => $urutan++,
            ]);
        }
    }
}
