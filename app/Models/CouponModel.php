<?php

namespace App\Models;

use CodeIgniter\Model;

class CouponModel extends Model
{
    protected $table         = 'coupons';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = ['kode_kupon', 'tipe', 'potongan', 'kuota', 'sisa_kuota', 'expired_at'];

    public function findByCode(string $code): ?array
    {
        return $this->where('kode_kupon', $code)->first();
    }

    public function isUsedByUser(int $couponId, int $userId): bool
    {
        return $this->db->table('coupon_usages')
            ->where('coupon_id', $couponId)
            ->where('user_id', $userId)
            ->countAllResults() > 0;
    }

    public function validateCoupon(string $code, int $userId, float $total): array
    {
        $coupon = $this->findByCode($code);
        if (!$coupon) {
            return ['valid' => false, 'message' => 'Kode kupon tidak ditemukan.'];
        }
        if ($coupon['sisa_kuota'] <= 0) {
            return ['valid' => false, 'message' => 'Kupon sudah habis kuota.'];
        }
        if (strtotime($coupon['expired_at']) < time()) {
            return ['valid' => false, 'message' => 'Kupon sudah kedaluwarsa.'];
        }
        if ($this->isUsedByUser($coupon['id'], $userId)) {
            return ['valid' => false, 'message' => 'Kamu sudah pernah menggunakan kupon ini.'];
        }
        $diskon = $coupon['tipe'] === 'persen'
            ? $total * ($coupon['potongan'] / 100)
            : (float)$coupon['potongan'];

        return ['valid' => true, 'coupon' => $coupon, 'diskon' => min($diskon, $total)];
    }
}
