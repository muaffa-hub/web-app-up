<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PrintPricingModel;

class PrintPricingController extends BaseController
{
    public function index()
    {
        return view('admin/print_pricing', [
            'pricings' => (new PrintPricingModel())->findAll(),
        ]);
    }

    public function update()
    {
        $pricings = $this->request->getPost('pricing');
        $model    = new PrintPricingModel();

        if ($pricings) {
            foreach ($pricings as $id => $harga) {
                $model->update((int)$id, ['harga_per_halaman' => (float)$harga]);
            }
        }

        session()->setFlashdata('success', 'Tarif print berhasil diperbarui.');
        return redirect()->to('/admin/print-pricing');
    }
}
