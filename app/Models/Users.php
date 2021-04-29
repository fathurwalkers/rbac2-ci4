<?php

namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
    protected $table                = 'users';
    protected $primaryKey           = 'users_Id';

    public function register($data)
    {
        $query = $this->db->table($this->table)->insert($data);
        return $query ? true : false;
    }
 
    public function cek_login($email)
    {
        $query = $this->table($this->table)->where('users_Email', $email)->countAll();
        if ($query >  0) {
            $result = $this->table($this->table)->where('users_Email', $email)->limit(1)->get()->getRowArray();
        } else {
            $result = array();
        }
        return $result;
    }
}
