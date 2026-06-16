<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CouponModel;

class CouponController extends BaseController
{
    public function index()
    {
        return view('admin/coupons', [
            'coupons' => (new CouponModel())->orderBy('id', 'DESC')->findAll(),
        ]);
    }

    public function store()
    {
        $rules = [
            'kode_kupon' => 'required|max_length[50]|is_unique[coupons.kode_kupon]',
            'tipe'       => 'required|in_list[persen,nominal]',
            'potongan'   => 'required|decimal|greater_than[0]',
            'kuota'      => 'required|integer|greater_than[0]',
            'expired_at' => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to('/admin/coupons');
        }

        $kuota = (int)$this->request->getPost('kuota');
        (new CouponModel())->insert([
            'kode_kupon' => strtoupper($this->request->getPost('kode_kupon')),
            'tipe'       => $this->request->getPost('tipe'),
            'potongan'   => $this->request->getPost('potongan'),
            'kuota'      => $kuota,
            'sisa_kuota' => $kuota,
            'expired_at' => $this->request->getPost('expired_at'),
        ]);

        session()->setFlashdata('success', 'Kupon berhasil ditambahkan.');
        return redirect()->to('/admin/coupons');
    }

    public function edit(int $id)
    {
        $coupon = (new CouponModel())->find($id);
        if (!$coupon) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('admin/coupon_form', ['coupon' => $coupon]);
    }

    public function update(int $id)
    {
        $rules = [
            'tipe'       => 'required|in_list[persen,nominal]',
            'potongan'   => 'required|decimal|greater_than[0]',
            'kuota'      => 'required|integer|greater_than[0]',
            'expired_at' => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to('/admin/coupons/edit/' . $id);
        }

        $kuota = (int)$this->request->getPost('kuota');
        $coupon = (new CouponModel())->find($id);
        $usedCount = $coupon['kuota'] - $coupon['sisa_kuota'];
        $newSisa   = max(0, $kuota - $usedCount);

        (new CouponModel())->update($id, [
            'tipe'       => $this->request->getPost('tipe'),
            'potongan'   => $this->request->getPost('potongan'),
            'kuota'      => $kuota,
            'sisa_kuota' => $newSisa,
            'expired_at' => $this->request->getPost('expired_at'),
        ]);

        session()->setFlashdata('success', 'Kupon berhasil diperbarui.');
        return redirect()->to('/admin/coupons');
    }

    public function delete(int $id)
    {
        (new CouponModel())->delete($id);
        session()->setFlashdata('success', 'Kupon berhasil dihapus.');
        return redirect()->to('/admin/coupons');
    }
}
