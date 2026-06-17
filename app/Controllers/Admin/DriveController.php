<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\GoogleDrive;

class DriveController extends BaseController
{
    public function connect()
    {
        $drive = new GoogleDrive();

        if (!$drive->isConfigured()) {
            session()->setFlashdata('error', 'Kredensial Google Drive belum diatur di file .env.');
            return redirect()->to('/admin/store-info');
        }

        return redirect()->to($drive->getAuthUrl());
    }

    public function callback()
    {
        $drive = new GoogleDrive();
        $code  = $this->request->getGet('code');
        $error = $this->request->getGet('error');

        if ($error || !$code) {
            session()->setFlashdata('error', 'Koneksi Google Drive dibatalkan.');
            return redirect()->to('/admin/store-info');
        }

        if ($drive->exchangeCode($code)) {
            session()->setFlashdata('success', 'Google Drive berhasil terhubung.');
        } else {
            session()->setFlashdata('error', 'Gagal menghubungkan Google Drive. Pastikan kredensial benar dan coba lagi.');
        }

        return redirect()->to('/admin/store-info');
    }

    public function disconnect()
    {
        (new GoogleDrive())->disconnect();
        session()->setFlashdata('success', 'Google Drive telah diputus.');
        return redirect()->to('/admin/store-info');
    }
}
