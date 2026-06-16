<?php

namespace App\Models;

use CodeIgniter\Model;

class StoreInfoModel extends Model
{
    protected $table         = 'store_info';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'jam_operasional', 'lokasi', 'no_whatsapp', 'instagram',
        'maintenance_website', 'maintenance_website_msg',
        'maintenance_produk',  'maintenance_produk_msg',
        'maintenance_print',   'maintenance_print_msg',
        'welcome_enabled', 'welcome_title', 'welcome_message',
    ];

    public function getInfo(): ?array
    {
        return $this->first();
    }
}
