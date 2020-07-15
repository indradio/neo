<?php namespace App\Models;

use CodeIgniter\Model;

class OrdersModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $allowedFields = 
        [
            'id',
            'date',
            'total',
            'discount_percent',
            'discount_amount',
            'vat_percent',
            'vat_amount',
            'grandtotal',
            'uom',
            'user_id',
            'status',
            'created_at',
            'updated_at',
        ];

    public function getOrder($id = false){
        if ($id == false){
            return $this->findAll();
        }

        return $this->where(['id' => $id]);
    }

    public function getOrder_My(){
        return $this->where(['user_id' => session()->get('id')]);
    }

    public function getOrder_Req(){
        return $this->where(['status' => '1']);
    }

    public function getOrder_Month(){
               $this->where(['year(date)' => date('Y')]);
               $this->where(['month(date)' => date('m')]);
        return $this->where(['user_id' => session()->get('id')]);
    }

}
