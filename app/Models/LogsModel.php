<?php namespace App\Models;

use CodeIgniter\Model;

class LogsModel extends Model
{
    protected $table = 'user_log';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $allowedFields = ['id','user_id','code','description','created_at','updated_at'];
}