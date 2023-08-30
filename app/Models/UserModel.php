<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // Nama Tabel //
    protected $table            = 'pengguna';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['firstname', 'lastname', 'role', 'user_name', 'user_email', 'user_password', 'user_created_at'];

    public function getUsers($id = false)
    {
        if ($id == false) {
            return $this->get()->getResultArray();
        } else {
            $this->where(['id' => $id]);
            return $this->first();
        }
    }
}
