<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\NotificationModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $orderModel   = new OrderModel();
        $productModel = new ProductModel();

        $pendingOrders  = count($orderModel->where('status_pesanan', 'pending')->findAll());
        $todayRevenue   = $this->getTodayRevenue();
        $monthRevenue   = $this->getMonthRevenue();
        $lowStockItems  = $productModel->getLowStock(5);
        $recentOrders   = $this->db->table('orders o')
            ->select('o.*, u.nama as nama_customer')
            ->join('users u', 'u.id = o.user_id', 'left')
            ->orderBy('o.created_at', 'DESC')
            ->limit(10)
            ->get()->getResultArray();

        return view('admin/dashboard', [
            'pendingOrders' => $pendingOrders,
            'todayRevenue'  => $todayRevenue,
            'monthRevenue'  => $monthRevenue,
            'lowStockItems' => $lowStockItems,
            'recentOrders'  => $recentOrders,
        ]);
    }

    public function notifications()
    {
        $userId = session()->get('user_id');
        $notifModel = new NotificationModel();
        $notifModel->markAllRead($userId);

        return view('admin/notifications', [
            'notifications' => $notifModel->getForUser($userId),
        ]);
    }

    public function markRead()
    {
        $userId = session()->get('user_id');
        (new NotificationModel())->markAllRead($userId);
        return $this->response->setJSON(['success' => true]);
    }

    private function getTodayRevenue(): float
    {
        $row = $this->db->table('orders')
            ->selectSum('total_bayar')
            ->where('status_pesanan', 'selesai')
            ->where('DATE(updated_at)', date('Y-m-d'))
            ->get()->getRowArray();
        return (float)($row['total_bayar'] ?? 0);
    }

    private function getMonthRevenue(): float
    {
        $row = $this->db->table('orders')
            ->selectSum('total_bayar')
            ->where('status_pesanan', 'selesai')
            ->where('MONTH(updated_at)', date('m'))
            ->where('YEAR(updated_at)', date('Y'))
            ->get()->getRowArray();
        return (float)($row['total_bayar'] ?? 0);
    }
}
