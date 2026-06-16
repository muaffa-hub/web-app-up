<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table         = 'notifications';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = ['user_id', 'order_id', 'pesan', 'is_read'];

    public function getUnreadCount(int $userId): int
    {
        return $this->where('user_id', $userId)->where('is_read', 0)->countAllResults();
    }

    public function getForUser(int $userId, int $limit = 20): array
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    public function markAllRead(int $userId): void
    {
        $this->where('user_id', $userId)->set('is_read', 1)->update();
    }

    public function notifyAdmins(int $orderId, string $pesan): void
    {
        $admins = (new UserModel())->getAdmins();
        foreach ($admins as $admin) {
            $this->insert([
                'user_id'  => $admin['id'],
                'order_id' => $orderId,
                'pesan'    => $pesan,
                'is_read'  => 0,
            ]);
        }
    }

    public function notifyUser(int $userId, int $orderId, string $pesan): void
    {
        $this->insert([
            'user_id'  => $userId,
            'order_id' => $orderId,
            'pesan'    => $pesan,
            'is_read'  => 0,
        ]);
    }
}
