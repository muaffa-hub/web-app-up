<?php

namespace App\Controllers;

use App\Models\StoreInfoModel;

class MaintenanceController extends BaseController
{
    public function index()
    {
        $type  = $this->request->getGet('type') ?? 'website';
        $store = (new StoreInfoModel())->getInfo();

        if (!in_array($type, ['website', 'produk', 'print'])) {
            $type = 'website';
        }

        if (empty($store["maintenance_{$type}"])) {
            return redirect()->to('/');
        }

        return view('maintenance', [
            'type'    => $type,
            'message' => $store["maintenance_{$type}_msg"] ?? '',
            'store'   => $store,
        ]);
    }
}
