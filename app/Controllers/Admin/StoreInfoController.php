<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\StoreInfoModel;
use App\Libraries\GoogleDrive;

class StoreInfoController extends BaseController
{
    public function index()
    {
        $drive = new GoogleDrive();

        return view('admin/store_info', [
            'store'           => (new StoreInfoModel())->getInfo(),
            'driveConfigured' => $drive->isConfigured(),
            'driveConnected'  => $drive->isConnected(),
            'driveEmail'      => $drive->connectedEmail(),
        ]);
    }

    public function update()
    {
        $rules = [
            'jam_operasional' => 'required|max_length[200]',
            'lokasi'          => 'required|max_length[300]',
            'no_whatsapp'     => 'required|max_length[20]',
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to('/admin/store-info');
        }

        $model = new StoreInfoModel();
        $info  = $model->getInfo();

        $data = [
            'jam_operasional' => strip_tags($this->request->getPost('jam_operasional')),
            'lokasi'          => strip_tags($this->request->getPost('lokasi')),
            'no_whatsapp'     => $this->request->getPost('no_whatsapp'),
            'instagram'       => strip_tags($this->request->getPost('instagram') ?? ''),
        ];

        $info ? $model->update($info['id'], $data) : $model->insert($data);

        session()->setFlashdata('success', 'Informasi toko berhasil diperbarui.');
        return redirect()->to('/admin/store-info');
    }

    public function updateWelcome()
    {
        $model = new StoreInfoModel();
        $info  = $model->getInfo();

        $data = [
            'welcome_enabled' => $this->request->getPost('welcome_enabled') ? 1 : 0,
            'welcome_title'   => strip_tags($this->request->getPost('welcome_title') ?? ''),
            'welcome_message' => strip_tags($this->request->getPost('welcome_message') ?? ''),
        ];

        $info ? $model->update($info['id'], $data) : $model->insert($data);

        session()->setFlashdata('success', 'Pesan sambutan berhasil disimpan.');
        return redirect()->to('/admin/store-info');
    }
}
