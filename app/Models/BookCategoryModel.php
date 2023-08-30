<?php 

namespace App\Models;

use CodeIgniter\Model;

class BookCategoryModel extends Model
{
    // Nama Table
    protected $table          = 'book_category';
    // Atribut yang digunakan menjadi primary key
    protected $primarykey     = 'book_category_id';
}
?>