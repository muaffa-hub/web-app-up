<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('user_id')) {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu.');
            return redirect()->to('/login');
        }

        if ($arguments && in_array('admin', $arguments)) {
            if (session()->get('role') !== 'admin') {
                session()->setFlashdata('error', 'Akses ditolak.');
                return redirect()->to('/');
            }
        }

        if ($arguments && in_array('petugas', $arguments)) {
            if (!in_array(session()->get('role'), ['admin', 'petugas'])) {
                session()->setFlashdata('error', 'Akses ditolak.');
                return redirect()->to('/login');
            }
        }

        if ($arguments && in_array('customer', $arguments)) {
            if (!in_array(session()->get('role'), ['customer', 'admin'])) {
                session()->setFlashdata('error', 'Akses ditolak.');
                return redirect()->to('/login');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
