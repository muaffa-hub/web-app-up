<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\WishlistModel;

class WishlistController extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        return view('customer/wishlist', [
            'items' => (new WishlistModel())->getWithProducts($userId),
        ]);
    }

    public function toggle()
    {
        $productId = (int)$this->request->getPost('product_id');
        $userId    = session()->get('user_id');

        $wishlistModel = new WishlistModel();
        $existing = $wishlistModel->where('user_id', $userId)->where('product_id', $productId)->first();

        if ($existing) {
            $wishlistModel->delete($existing['id']);
            return $this->response->setJSON(['success' => true, 'wishlisted' => false]);
        }

        $wishlistModel->insert(['user_id' => $userId, 'product_id' => $productId]);
        return $this->response->setJSON(['success' => true, 'wishlisted' => true]);
    }
}
