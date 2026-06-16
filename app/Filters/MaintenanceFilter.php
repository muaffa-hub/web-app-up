<?php

namespace App\Filters;

use App\Models\StoreInfoModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class MaintenanceFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->get('role') === 'admin') return;

        $type  = $arguments[0] ?? 'website';
        $store = (new StoreInfoModel())->getInfo();

        if (!empty($store["maintenance_{$type}"])) {
            return redirect()->to(base_url('maintenance?type=' . $type));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
