<?php namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $allowedFields = 
        [
            'id',
            'name',
            'email',
            'phone',
            'company_id',
            'group',
            'role_id',
            'is_active',
            'photo',
            'status',
            'password',
            'verify_by',
            'created_at',
            'updated_at',
        ];
    public function getUser($email){
        return $this->where(['email' => $email]);
    }

}
