<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\ReviewModel;
use App\Models\WishlistModel;
use App\Models\OrderModel;

class ProductController extends BaseController
{
    public function detail(int $id)
    {
        $productModel = new ProductModel();
        $product = $productModel->getDetailWithImages($id);

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $reviews     = (new ReviewModel())->getByProduct($id);
        $userId      = session()->get('user_id');
        $isWishlisted = false;
        $hasReviewed  = false;
        $hasBought    = false;

        if ($userId) {
            $isWishlisted = (new WishlistModel())->isWishlisted($userId, $id);
            $hasReviewed  = (new ReviewModel())->hasReviewed($userId, $id);

            $bought = $this->db->table('order_items oi')
                ->join('orders o', 'o.id = oi.order_id')
                ->where('oi.product_id', $id)
                ->where('o.user_id', $userId)
                ->where('o.status_pesanan', 'selesai')
                ->countAllResults();
            $hasBought = $bought > 0;
        }

        return view('customer/product_detail', [
            'product'      => $product,
            'reviews'      => $reviews,
            'isWishlisted' => $isWishlisted,
            'hasReviewed'  => $hasReviewed,
            'hasBought'    => $hasBought,
        ]);
    }
}
