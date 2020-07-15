<?php namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\CartModel;
use App\Models\PartsModel;
use App\Models\OrdersModel;

class Cart extends BaseController
{
	protected $db;
	protected $usersModel;
	protected $cartModel;
	protected $partsModel;
	protected $ordersModel;
	public function __construct()
    {
		// parent::__construct();
		$this->db = \Config\Database::connect();
		$this->usersModel = new UsersModel();
		$this->cartModel = new CartModel();
		$this->partsModel = new PartsModel();
		$this->ordersModel = new OrdersModel();
    }

	public function index()
	{
		if (!session()->get('isLoggedIn')) 
			return redirect()->to('auth/login');
			
		$data = [
			'menu' => 'Pesanan',
			'submenu' => 'Troli',
			'parts' => $this->cartModel->getCart()->get(),
			'countParts' => $this->cartModel->getCart()->countAllResults(),
		];
		return view('cart/index', $data);
    }
    
	public function add()
	{
		$alreadyPart = $this->cartModel->getPart($this->request->getPost('id'))->get()->getRow();
		if (empty($alreadyPart)){
			$part = $this->partsModel->getPart($this->request->getPost('id'))->get()->getRow();
			$this->cartModel->insert([
				'id' => $part->id,
				'name' => $part->name,
				'description' => $part->description,
				'category' => $part->category,
				'order_qty' => $this->request->getPost('order_qty'),
				'uom' => $part->uom,
				'sloc' => $part->sloc,
				'user_id' => session()->get('id'),
			]);
			session()->setFlashdata('message', 'addcart');
		}else{
			$this->cartModel->set('order_qty',$this->request->getPost('order_qty'));
			$this->cartModel->where('id',$this->request->getPost('id'));
			$this->cartModel->where('user_id',session()->get('id'));
			$this->cartModel->update();
			session()->setFlashdata('message', 'updatecart');
		}
		return redirect()->to('/');
	}

	public function update()
	{
		$this->cartModel->set('order_qty',$this->request->getPost('order_qty'));
		$this->cartModel->where('id',$this->request->getPost('id'));
		$this->cartModel->where('user_id',session()->get('id'));
		$this->cartModel->update();

		session()->setFlashdata('message', 'updatecart');
		return redirect()->to('/cart');
	}

	public function delete()
	{
		$this->cartModel->getPart($this->request->getPost('id'));
		$this->cartModel->delete();

		session()->setFlashdata('message', 'updatecart');
		return redirect()->to('/cart');
	}

	public function checkout()
	{
		$data = [
			'menu' => 'Pesanan',
			'submenu' => 'Checkout',
			'parts' => $this->cartModel->getCart()->get()
		];
		return view('cart/checkout', $data);
	}

	public function order()
	{
		date_default_timezone_set('asia/jakarta');

		$countOrder = $this->ordersModel->getOrder_Month()->countAllResults();
		$countAdd = $countOrder+1;
		$id = 'ORD'.date('-ym'). sprintf("%03s", $countAdd);
		$now =  date('Y-m-d');
		$total = 0;

		$builder = $this->db->table('orders_parts');
		$cart = $this->cartModel->getCart()->get();
		foreach ($cart->getResult() as $row) { 
			$part = $this->partsModel->getPart($row->id)->get()->getRow();       
			$subTotal = $part->price * $row->order_qty;
			$total = $total + $subTotal;
			
			$builder->insert([
				'order_id' => $id,
				'part_id' => $part->id,
				'part_name' => $part->name,
				'part_description' => $part->description,
				'part_category' => $part->category,
				'order_qty' => $row->order_qty,
				'part_uom' => $part->uom,
				'part_price' => $part->price,
				'part_sloc' => $part->sloc,
				'subtotal' => $subTotal,
			]);

			$this->cartModel->getPart($part->id);
			$this->cartModel->delete();
		}
		
		// dd($part);
		$vat = $total * 0.10;
		$grandTotal = $total+$vat;
		$this->ordersModel->insert([
			'id' => $id,
			'date' => date('Y-m-d'),
			'total' => $total,
			'discount_percent' => 0,
			'discount_amount' => 0,
			'vat_percent' => 10,
			'vat_amount' => $vat,
			'grandtotal' => $grandTotal,
			'user_id' => session()->get('id'),
			'user_fr' => session()->get('fr'),
			'status' => '1',
		]);
			
		return redirect()->to('/order');
	}

	//--------------------------------------------------------------------

}
