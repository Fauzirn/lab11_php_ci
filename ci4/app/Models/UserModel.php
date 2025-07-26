<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users'; 
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'useremail', 'userpassword'];
    protected $useTimestamps = false;
    protected $returnType = 'array';
    protected $validationRules = [
        'username' => 'required|is_unique[user.username]',
        'email' => 'required|valid_email|is_unique[user.useremail]',
        'password' => 'required|min_length[6]',
    ];

}