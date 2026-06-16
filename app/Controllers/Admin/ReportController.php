<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class ReportController extends BaseController
{
    public function index()
    {
        $month = $this->request->getGet('month') ?? date('Y-m');
        [$year, $monthNum] = explode('-', $month);

        $dailyRevenue  = $this->getDailyRevenue($year, $monthNum);
        $monthlyRevenue = $this->getMonthlyRevenue($year);
        $topProducts    = (new ProductModel())->getTopSelling(10);

        return view('admin/reports', [
            'dailyRevenue'   => $dailyRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'topProducts'    => $topProducts,
            'selectedMonth'  => $month,
        ]);
    }

    public function exportCsv()
    {
        $month = $this->request->getGet('month') ?? date('Y-m');
        [$year, $monthNum] = explode('-', $month);

        $orders = $this->db->table('orders o')
            ->select('o.invoice_code, u.nama as customer, o.tipe_pesanan, o.total_bayar, o.status_pesanan, o.created_at')
            ->join('users u', 'u.id = o.user_id', 'left')
            ->where('MONTH(o.created_at)', $monthNum)
            ->where('YEAR(o.created_at)', $year)
            ->orderBy('o.created_at', 'ASC')
            ->get()->getResultArray();

        $filename = 'laporan_' . $month . '.csv';
        $output   = fopen('php://output', 'w');
        fputcsv($output, ['Invoice', 'Customer', 'Tipe', 'Total', 'Status', 'Tanggal']);

        foreach ($orders as $row) {
            fputcsv($output, [
                $row['invoice_code'],
                $row['customer'],
                $row['tipe_pesanan'],
                $row['total_bayar'],
                $row['status_pesanan'],
                $row['created_at'],
            ]);
        }
        fclose($output);

        return $this->response
            ->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    private function getDailyRevenue(string $year, string $month): array
    {
        return $this->db->table('orders')
            ->select('DATE(updated_at) as tanggal, SUM(total_bayar) as total')
            ->where('status_pesanan', 'selesai')
            ->where('MONTH(updated_at)', $month)
            ->where('YEAR(updated_at)', $year)
            ->groupBy('DATE(updated_at)')
            ->orderBy('tanggal', 'ASC')
            ->get()->getResultArray();
    }

    private function getMonthlyRevenue(string $year): array
    {
        return $this->db->table('orders')
            ->select('MONTH(updated_at) as bulan, SUM(total_bayar) as total')
            ->where('status_pesanan', 'selesai')
            ->where('YEAR(updated_at)', $year)
            ->groupBy('MONTH(updated_at)')
            ->orderBy('bulan', 'ASC')
            ->get()->getResultArray();
    }
}
