<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\StoreInfoModel;

class HomeController extends BaseController
{
    public function index()
    {
        $productModel  = new ProductModel();
        $categoryModel = new CategoryModel();
        $storeModel    = new StoreInfoModel();

        $featuredProducts = $productModel->getWithCategory(null, null, null);
        $featuredProducts = array_slice($featuredProducts, 0, 8);

        return view('home', [
            'title'      => 'Unit Produksi Sekolah — Belanja & Jasa Print',
            'products'   => $featuredProducts,
            'categories' => $categoryModel->getActive(),
            'store'      => $storeModel->getInfo(),
        ]);
    }
}
