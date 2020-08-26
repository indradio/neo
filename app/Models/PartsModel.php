<?php namespace App\Models;

use CodeIgniter\Model;

class PartsModel extends Model
{
    protected $table = 'parts';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = 
        [
            'id',
            'name',
            'description',
            'category',
            'base_price',
            'high_price',
            'discount',
            'price',
            'photo',
        ];
    
    public function getAll(){
        return $this->findAll();
    }

    public function getPart($id = false){
        if ($id == false){
            return $this->findAll();
        }

        return $this->where(['id' => $id]);
    }

}
