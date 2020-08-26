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
            'total_base',
            'total_sell',
            'total',
            'discount_percent',
            'discount_amount',
            'vat_percent',
            'vat_amount',
            'delivery_fee',
            'grandtotal',
            'uom',
            'user_id',
            'user_name',
            'user_email',
            'user_phone',
            'user_company_id',
            'user_group',
            'quote_id',
            'quote_date',
            'quote_expired',
            'quote_file',
            'sales_by',
            'sales_by_id',
            'sales_at',
            'po_id',
            'po_date',
            'po_receive_by',
            'po_receive_at',
            'dn_id',
            'dn_date',
            'shipping_by',
            'shipping_at',
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
        return $this->where(['month(date)' => date('m')]);
    
    }

}
