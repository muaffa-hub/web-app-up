<?php

namespace App\Controllers;

use App\Models\OrderModel;

class InvoiceController extends BaseController
{
    public function show(string $invoiceCode)
    {
        $orderModel = new OrderModel();
        $order      = $orderModel->getByInvoice($invoiceCode);

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $userId = session()->get('user_id');
        $role   = session()->get('role');

        if (!$userId || ($role !== 'admin' && $order['user_id'] !== $userId)) {
            session()->setFlashdata('error', 'Akses ditolak.');
            return redirect()->to('/login');
        }

        $detail = $orderModel->getDetailWithItems($order['id']);

        return view('invoice', ['order' => $detail]);
    }
}
