<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table         = 'order_items';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = ['order_id', 'product_id', 'qty', 'harga_satuan', 'subtotal', 'gambar_design'];
}
