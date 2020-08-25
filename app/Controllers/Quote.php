<?php namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\OrdersModel;
use App\Models\PartsModel;

class Quote extends BaseController
{
	protected $db;
	protected $usersModel;
	protected $ordersModel;
	protected $partsModel;
	public function __construct()
    {
		// parent::__construct();
		$this->db = \Config\Database::connect();
		$this->usersModel = new UsersModel();
		$this->ordersModel = new OrdersModel();
		$this->partsModel = new PartsModel();
    }

	public function index()
	{
		if (!session()->get('isLoggedIn')) 
			return redirect()->to('/');
			
		$data = [
			'menu' => 'Pesanan',
			'submenu' => 'Pesanan',
			'orders' => $this->ordersModel->getOrder_my()->get()
		];
		return view('orders/index', $data);
	}

	public function order($id)
	{
		if (!session()->get('isLoggedIn')) 
			return redirect()->to('/');
				 $this->ordersModel->where(['user_id' => session()->get('id')]);
				 $this->ordersModel->where(['status' => '2']);
		$order = $this->ordersModel->where(['id' => $id])->get()->getRow();
		if (empty($order)){
			return redirect()->to('/order');
		}
		
		$builder = $this->db->table('orders_parts');
		$query = $builder->where(['order_id' => $id])->get(); 
		$data = [
			'menu' => 'Pesanan',
			'submenu' => 'Pesanan',
			'order' => $this->ordersModel->getOrder($id)->get()->getRow(),
			'parts' => $query
		];
		
		return view('quote/index', $data);
	}

	//--------------------------------------------------------------------

}
