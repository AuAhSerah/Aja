<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryKomik extends Model
{
    protected $table = 'komik_category';
    protected $primaryKey = 'komik_category_id';
    protected $useTimestamps = true;
}
