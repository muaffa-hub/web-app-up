<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\CartModel;
use App\Models\ProductModel;

class CartController extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        $cartModel = new CartModel();
        $items = $userId ? $cartModel->getCartWithProducts($userId) : $this->getGuestCart();

        return view('customer/cart', ['items' => $items]);
    }

    public function add()
    {
        $productId = (int)$this->request->getPost('product_id');
        $qty       = max(1, (int)$this->request->getPost('qty'));

        $product = (new ProductModel())->find($productId);
        if (!$product || $product['stok'] <= 0) {
            return $this->response->setJSON(['success' => false, 'message' => 'Produk tidak tersedia.']);
        }

        $designPath = null;
        $designFile = $this->request->getFile('gambar_design');
        if ($designFile && $designFile->isValid() && !$designFile->hasMoved()) {
            $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
            if (in_array($designFile->getMimeType(), $allowedMimes) && $designFile->getSize() <= 5 * 1024 * 1024) {
                $savePath = WRITEPATH . 'uploads/designs/';
                if (!is_dir($savePath)) mkdir($savePath, 0777, true);
                $newName = bin2hex(random_bytes(16)) . '.' . $designFile->getClientExtension();
                $designFile->move($savePath, $newName);
                $designPath = $newName;
            }
        }

        $userId = session()->get('user_id');
        if ($userId) {
            $cartModel = new CartModel();
            $existing  = $cartModel->getItem($userId, $productId);
            if ($existing) {
                $updateData = ['qty' => min($existing['qty'] + $qty, $product['stok'])];
                if ($designPath) $updateData['gambar_design'] = $designPath;
                $cartModel->update($existing['id'], $updateData);
            } else {
                $cartModel->insert([
                    'user_id'       => $userId,
                    'product_id'    => $productId,
                    'qty'           => min($qty, $product['stok']),
                    'gambar_design' => $designPath,
                ]);
            }
            $count = $cartModel->countItems($userId);
        } else {
            $guestCart = session()->get('guest_cart') ?? [];
            $found = false;
            foreach ($guestCart as &$item) {
                if ($item['product_id'] === $productId) {
                    $item['qty'] = min($item['qty'] + $qty, $product['stok']);
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $guestCart[] = ['product_id' => $productId, 'qty' => min($qty, $product['stok'])];
            }
            session()->set('guest_cart', $guestCart);
            $count = count($guestCart);
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Produk ditambahkan ke keranjang.', 'count' => $count]);
    }

    public function update()
    {
        $cartId = (int)$this->request->getPost('cart_id');
        $qty    = max(1, (int)$this->request->getPost('qty'));

        $userId = session()->get('user_id');
        if (!$userId) {
            return $this->response->setJSON(['success' => false]);
        }

        $cartModel = new CartModel();
        $item = $cartModel->find($cartId);
        if (!$item || $item['user_id'] !== $userId) {
            return $this->response->setJSON(['success' => false]);
        }

        $product = (new ProductModel())->find($item['product_id']);
        $newQty = min($qty, $product['stok']);
        $cartModel->update($cartId, ['qty' => $newQty]);

        return $this->response->setJSON(['success' => true, 'qty' => $newQty]);
    }

    public function remove()
    {
        $cartId = (int)$this->request->getPost('cart_id');
        $userId = session()->get('user_id');

        if (!$userId) {
            return $this->response->setJSON(['success' => false]);
        }

        $cartModel = new CartModel();
        $item = $cartModel->find($cartId);
        if (!$item || $item['user_id'] !== $userId) {
            return $this->response->setJSON(['success' => false]);
        }

        $cartModel->delete($cartId);
        return $this->response->setJSON(['success' => true]);
    }

    private function getGuestCart(): array
    {
        $guestCart = session()->get('guest_cart') ?? [];
        if (empty($guestCart)) return [];

        $productModel = new ProductModel();
        $items = [];
        foreach ($guestCart as $item) {
            $product = $productModel->find($item['product_id']);
            if ($product) {
                $items[] = array_merge($item, [
                    'id'          => 'g_' . $item['product_id'],
                    'nama_produk' => $product['nama_produk'],
                    'harga'       => $product['harga'],
                    'stok'        => $product['stok'],
                    'foto_utama'  => null,
                ]);
            }
        }
        return $items;
    }
}
