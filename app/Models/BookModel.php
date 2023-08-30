<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    // Nama Table
    protected $table          = 'book';
    // Atribut yang digunakan menjadi primary key
    protected $primaryKey     = 'book_id';
    // Atribut untuk menyimpan create_at dan updated_at
    protected $useTimestamps  = true;
    protected $allowedFields = [
        'title', 'slug', 'author', 'release_year', 'price', 'discount', 'stock', 'cover', 'book_category_id'
    ];

    protected $useSoftDeletes = true;

 public function getBook($slug = null)
 {
//     $quary = $this->table('book')
//         ->join('book_category', 'book_category_id')
//         ->where('deleted_at is null');

//     if ($slug == null) {
//         return $quary->get()->getResultArray();
//         return $quary->where(['slug' => $slug])->first();
//     }
// }
if ($slug === null) {
    $this->join('book_category', 'book_category_id')->where(['deleted_at' => null]);
    return $this->get()->getResultArray();
} else {
            $this->join('book_category', 'book_category_id');
    $this->where(['slug' => $slug]);
    return $this->first();
}
 }}
