<?php namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\OrdersModel;
use App\Models\PartsModel;

class Order extends BaseController
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
			return redirect()->to('auth/login');
			
		$data = [
			'menu' => 'Pesanan',
			'submenu' => 'Pesanan',
			'orders' => $this->ordersModel->getOrder_my()->get()
		];
		return view('orders/index', $data);
	}

	public function all()
	{
		if (!session()->get('isLoggedIn')) 
			return redirect()->to('auth/login');
			
		$data = [
			'menu' => 'Pesanan',
			'submenu' => 'Pesanan',
			'orders' => $this->ordersModel->get()
		];
		return view('orders/index-sales', $data);
	}

	public function request($params = false, $id = '')
	{
		if (!session()->get('isLoggedIn')) 
			return redirect()->to('auth/login');
		
		if (empty($id)){
			$data = [
				'menu' => 'Pesanan',
				'submenu' => 'Pesanan Baru',
				'orders' => $this->ordersModel->getOrder_Req()->get()
			];
			return view('orders/request-index', $data);
		}else{
			$data = [
				'menu' => 'Pesanan',
				'submenu' => 'Pesanan Baru',
				'orders' => $this->ordersModel->where(['id' => $id])->get()->getRow()
			];

			if ($params=='resume'){
				return view('orders/request-resume', $data);
			}elseif ($params=='quote'){
				return view('orders/request-quote', $data);
			}else{
				return redirect()->to('/');
			}
		}
	}

	public function update_price()
	{
		$subtotal = $this->request->getPost('new_price')*$this->request->getPost('order_qty');
		$builder = $this->db->table('orders_parts');
		$builder->set('part_price',$this->request->getPost('new_price'));
		$builder->set('subtotal',$subtotal);
		$builder->where('order_id',$this->request->getPost('order_id'));
		$builder->where('part_id',$this->request->getPost('part_id'));
		$builder->update();

		$builder->selectSum('subtotal');
		$builder->where('order_id',$this->request->getPost('order_id'));
		$total = $builder->get()->getRow('subtotal');

		$disc_amount = $total * ($this->request->getPost('disc') / 100);
		$totalafterdisc = $total - $disc_amount;
		$vat_amount = $totalafterdisc * 0.10;
		$grandtotal = $totalafterdisc + $vat_amount;

		$this->ordersModel->set('total',$total);
		$this->ordersModel->set('discount_amount',$disc_amount);
		$this->ordersModel->set('vat_amount',$vat_amount);
		$this->ordersModel->set('grandtotal',$grandtotal);
		$this->ordersModel->where('id',$this->request->getPost('order_id'));
		$this->ordersModel->update();

		return redirect()->to('/order/request/resume/'.$this->request->getPost('order_id'));
	}

	public function update_qty()
	{
		$subtotal = $this->request->getPost('price')*$this->request->getPost('order_qty');
		$builder = $this->db->table('orders_parts');
		$builder->set('order_qty',$this->request->getPost('order_qty'));
		$builder->set('subtotal',$subtotal);
		$builder->where('order_id',$this->request->getPost('order_id'));
		$builder->where('part_id',$this->request->getPost('part_id'));
		$builder->update();

		$builder->selectSum('subtotal');
		$builder->where('order_id',$this->request->getPost('order_id'));
		$total = $builder->get()->getRow('subtotal');

		$disc_amount = $total * ($this->request->getPost('disc') / 100);
		$totalafterdisc = $total - $disc_amount;
		$vat_amount = $totalafterdisc * 0.10;
		$grandtotal = $totalafterdisc + $vat_amount;

		$this->ordersModel->set('total',$total);
		$this->ordersModel->set('discount_amount',$disc_amount);
		$this->ordersModel->set('vat_amount',$vat_amount);
		$this->ordersModel->set('grandtotal',$grandtotal);
		$this->ordersModel->where('id',$this->request->getPost('order_id'));
		$this->ordersModel->update();

		return redirect()->to('/order/request/resume/'.$this->request->getPost('order_id'));
	}
	
	public function delete_part()
	{
		$builder = $this->db->table('orders_parts');
		$builder->where('order_id',$this->request->getPost('order_id'));
		$builder->where('part_id',$this->request->getPost('part_id'));
		$builder->delete();

		$builder->selectSum('subtotal');
		$builder->where('order_id',$this->request->getPost('order_id'));
		$total = $builder->get()->getRow('subtotal');

		$disc_amount = $total * ($this->request->getPost('disc') / 100);
		$totalafterdisc = $total - $disc_amount;
		$vat_amount = $totalafterdisc * 0.10;
		$grandtotal = $totalafterdisc + $vat_amount;

		$this->ordersModel->set('total',$total);
		$this->ordersModel->set('discount_amount',$disc_amount);
		$this->ordersModel->set('vat_amount',$vat_amount);
		$this->ordersModel->set('grandtotal',$grandtotal);
		$this->ordersModel->where('id',$this->request->getPost('order_id'));
		$this->ordersModel->update();

		return redirect()->to('/order/request/resume/'.$this->request->getPost('order_id'));
	}

	public function discount()
	{
		$total = intval(preg_replace('(\D+)', '', $this->request->getPost('total')));
		$discount_amount = $total * ($this->request->getPost('discount_percent') / 100);
		$totalafterdisc = $total - $discount_amount;
		$vat_amount = $totalafterdisc * 0.10;
		$grandtotal = $totalafterdisc + $vat_amount;

		$this->ordersModel->set('discount_percent',$this->request->getPost('discount_percent'));
		$this->ordersModel->set('discount_amount',$discount_amount);
		$this->ordersModel->set('vat_amount',$vat_amount);
		$this->ordersModel->set('grandtotal',$grandtotal);
		$this->ordersModel->where('id',$this->request->getPost('id'));
		$this->ordersModel->update();

		return redirect()->to('/order/request/resume/'.$this->request->getPost('id'));
	}

	public function upload()
	{
		$file = $this->request->getFile('quoteFile');
		$file->move('assets/pdf/quotation');

		dd($file);
	}

	public function submit($param = false)
	{
		if ($param=='quote'){
			$file = $this->request->getFile('quoteFile');
			$file->move('assets/pdf/quotation');
		
			$this->ordersModel->set('quote_id',$this->request->getPost('quoteId'));
			$this->ordersModel->set('quote_create',$this->request->getPost('quoteCreate'));
			$this->ordersModel->set('quote_expired',$this->request->getPost('quoteExpired'));
			$this->ordersModel->set('quote_file',$this->request->getPost('quoteFile'));
			$this->ordersModel->where('id',$this->request->getPost('id'));
			$this->ordersModel->update();
	
			return redirect()->to('/order/request');
		}
	}
	
	public function quotation()
	{
		if (!session()->get('isLoggedIn')) 
			return redirect()->to('auth/login');
			
		$data = [
			'menu' => 'Keranjang',
			'submenu' => 'Checkout',
		];
		return view('orders/quote', $data);
    }

	//--------------------------------------------------------------------

}
