<?php

namespace App\Models;

use CodeIgniter\Model;

class KomikModel extends Model
{
    protected $table         = 'komik';
    protected $primaryKey    = 'komik_id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'title', 'slug', 'author', 'release_year', 'price', 'stock', 'cover', 'komik_category_id', 'updated_at', 'created_at'
    ];

    public function getBook($slug = false)
    {
        $query = $this->table('komik')
            ->join('komik_category', 'komik_category_id');

        if ($slug == false)
            return $query->get()->getResultArray();
        return $query->where(['slug' => $slug])->first();
    }
}
