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
			return redirect()->to('/');
			
		$data = [
			'menu' => 'Troli',
			'submenu' => 'Checkout',
			'parts' => $this->cartModel->getCart()->get(),
			'countParts' => $this->cartModel->getCart()->countAllResults(),
		];
		if ($data['countParts']==0){
			session()->setFlashdata('message', 'emptyCart');
		}
		return view('cart/index', $data);
    }
    
	public function add()
	{
		if (!session()->get('isLoggedIn')) 
			return redirect()->to('/');
			
		$part = $this->partsModel->getPart($this->request->getPost('id'))->get()->getRow();
		
		if ($part->qty<$this->request->getPost('order_qty')){
			session()->setFlashdata('message', 'outStock');
			if ($this->request->getPost('cart')=='cart'){return redirect()->to('/cart');}
			return redirect()->to('/');
		}

		$alreadyPart = $this->cartModel->getPart($this->request->getPost('id'))->get()->getRow();
		if (empty($alreadyPart)){
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

		if ($this->request->getPost('cart')=='cart'){return redirect()->to('/cart');}
		return redirect()->to('/');
	}

	public function update()
	{
		$part = $this->partsModel->getPart($this->request->getPost('id'))->get()->getRow();
		
		if ($part->qty<$this->request->getPost('order_qty')){
			session()->setFlashdata('message', 'outStock');
			return redirect()->to('/cart');
		}

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
		if ($this->request->getPost('everythingOk')=='OK'){
			$cart = $this->cartModel->getCart()->get()->getResult();
			// dd($cart);
			// if (!empty($cart)){
				$data = [
					'menu' => 'Pesanan',
					'submenu' => 'Checkout',
					'parts' => $this->cartModel->getCart()->get()
				];
				return view('cart/checkout', $data);
			}else{
				return redirect()->to('/cart');
			// }
		}
	}

	public function order()
	{
		date_default_timezone_set('asia/jakarta');

		$countOrder = $this->ordersModel->getOrder_Month()->countAllResults();
		$countAdd = $countOrder+1;
		$id = 'ORD'.date('ym-'). sprintf("%03s", $countAdd);
		$now =  date('Y-m-d');
		$totalBase = 0;
		$totalSell = 0;
		$total = 0;
		$partlist = "";

		$builder = $this->db->table('orders_parts');
		$cart = $this->cartModel->getCart()->get();
		foreach ($cart->getResult() as $row) { 
			$part = $this->partsModel->getPart($row->id)->get()->getRow();       
			$subTotalBase = $part->base_price * $row->order_qty;
			$subTotalSell = $part->high_price * $row->order_qty;
			$subTotal = $part->price * $row->order_qty;
			$totalBase = $totalBase + $subTotalBase;
			$totalSell = $totalSell + $subTotalSell;
			$total = $total + $subTotal;
			
			$builder->insert([
				'order_id' => $id,
				'part_id' => $part->id,
				'part_name' => $part->name,
				'part_description' => $part->description,
				'part_category' => $part->category,
				'order_qty' => $row->order_qty,
				'part_uom' => $part->uom,
				'part_price_base' => $part->base_price,
				'part_price_sell' => $part->high_price,
				'part_price_disc' => $part->discount,
				'part_price' => $part->price,
				'part_sloc' => $part->sloc,
				'subtotal' => $subTotal,
			]);

			$this->cartModel->getPart($part->id);
			$this->cartModel->delete();

			$partlist = $partlist . $part->description. "\r\n";
		}
		
		// dd($part);
		$discount_amount = $totalSell - $total;
		if ($discount_amount==0){
			$discount_percent = 0;
		}else{
			$discount_percent = ($discount_amount / $totalSell)*100;
		}
		$vat = $total * 0.10;
		$grandTotal = $total+$vat;
		$this->ordersModel->insert([
			'id' => $id,
			'date' => date('Y-m-d'),
			'total_base' => $totalBase,
			'total_sell' => $totalSell,
			'total' => $total,
			'discount_percent' => $discount_percent,
			'discount_amount' => $discount_amount,
			'vat_percent' => 10,
			'vat_amount' => $vat,
			'grandtotal' => $grandTotal,
			'user_id' => session()->get('id'),
			'user_name' => session()->get('name'),
			'user_email' => session()->get('email'),
			'user_phone' => session()->get('phone'),
			'user_company_id' => session()->get('companyId'),
			'user_group' => session()->get('group'),
			'status' => '1',
		]);
			
		$response = $this->client->post(
			'https://region01.krmpesan.com/api/v2/message/send-text',
			[
				'headers' => [
					'Content-Type' => 'application/json',
					'Accept' => 'application/json',
					'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
				],
				'json' => [
					'phone' => '6281324945151',
					// 'phone' => '6281311196988',
					'message' => "*ADA PESANAN BARU | NEO*" .
					"\r\n \r\nOrder ID : *" . $id . "*" .
					"\r\nNama : *" . session()->get('name') . "*" .
					"\r\nPerusahaan : *" . session()->get('companyId') . "*" .
					"\r\nPart" .
					"\r\n". $partlist .
					"\r\nEstimasi : *" . number_format($total, 0, '.', ',') . "*" .
					"\r\nSilahkan login di link berikut https://raisa.winteq-astra.com"
				],
			]
		);
		$body = $response->getBody();

		return redirect()->to('/order');
	}

	//--------------------------------------------------------------------

}
