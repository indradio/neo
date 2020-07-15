<?php namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table = 'cart';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $allowedFields = ['id','name','description','category','order_qty','uom','user_id','created_at','updated_at','ai'];

    public function getAll(){
        return $this->findAll();
    }

    public function getCart(){
        return $this->where(['user_id' => session()->get('id')]);
    }

    public function getPart($id){
               $this->where(['id' => $id]);
        return $this->where(['user_id' => session()->get('id')]);
    }
}
