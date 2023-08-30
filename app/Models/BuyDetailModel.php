<?php

namespace App\Models;

use CodeIgniter\Model;

class BuyDetailModel extends Model
{
    // Nama Tabel
    protected $table         = 'buy_detail';
    protected $allowedFields = ['buy_id', 'komik_id', 'amount', 'price', 'total_price'];
}
