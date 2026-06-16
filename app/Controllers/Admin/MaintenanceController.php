<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\StoreInfoModel;

class MaintenanceController extends BaseController
{
    public function index()
    {
        return view('admin/maintenance', [
            'pageTitle' => 'Maintenance',
            'store'     => (new StoreInfoModel())->getInfo() ?? [],
        ]);
    }

    public function update()
    {
        $model = new StoreInfoModel();
        $info  = $model->getInfo();

        $data = [
            'maintenance_website'     => $this->request->getPost('maintenance_website') ? 1 : 0,
            'maintenance_website_msg' => strip_tags($this->request->getPost('maintenance_website_msg') ?? ''),
            'maintenance_produk'      => $this->request->getPost('maintenance_produk') ? 1 : 0,
            'maintenance_produk_msg'  => strip_tags($this->request->getPost('maintenance_produk_msg') ?? ''),
            'maintenance_print'       => $this->request->getPost('maintenance_print') ? 1 : 0,
            'maintenance_print_msg'   => strip_tags($this->request->getPost('maintenance_print_msg') ?? ''),
        ];

        $info ? $model->update($info['id'], $data) : $model->insert($data);

        session()->setFlashdata('success', 'Pengaturan maintenance berhasil disimpan.');
        return redirect()->to('/admin/maintenance');
    }
}
