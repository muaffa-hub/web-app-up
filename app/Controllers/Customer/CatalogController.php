<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\StoreInfoModel;

class CatalogController extends BaseController
{
    public function index()
    {
        $productModel  = new ProductModel();
        $categoryModel = new CategoryModel();

        $categoryId = $this->request->getGet('category');
        $search     = $this->request->getGet('q');
        $sort       = $this->request->getGet('sort');

        return view('customer/catalog', [
            'products'   => $productModel->getWithCategory($categoryId, $search, $sort),
            'categories' => $categoryModel->getActive(),
            'filters'    => ['category' => $categoryId, 'q' => $search, 'sort' => $sort],
        ]);
    }

    public function info()
    {
        return view('customer/info', [
            'store' => (new StoreInfoModel())->getInfo(),
        ]);
    }
}
