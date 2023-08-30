<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleDetailModel extends Model
{
    // Nama Tabel
    protected $table         = 'sale_detail';
    protected $allowedFields = ['sale_id', 'book_id', 'amount', 'price', 'discount', 'total_price'];
}
