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
			return redirect()->to('/');

			if (empty($id)){
				$data = [
					'menu' => 'Pesanan',
					'submenu' => 'Request Quote',
					'orders' => $this->ordersModel->getOrder_Req()->get()
				];
				return view('orders/request-index', $data);
			}else{

				$this->ordersModel->where(['status' => '1']);
				$order = $this->ordersModel->where(['id' => $id])->get()->getRow();
				if (!empty($order)){

					$data = [
						'menu' => 'Pesanan',
						'submenu' => 'Request Quote',
						'orders' => $this->ordersModel->where(['id' => $id])->get()->getRow()
					];
		
					if ($params=='resume'){
						return view('orders/request-resume', $data);
					}elseif ($params=='quote'){
						return view('orders/request-quote', $data);
					}else{
						return redirect()->to('/order/request');
					}
				}else{
					return redirect()->to('/order/request');
				}
			}
		
	}

	public function update_price()
	{
		$builder = $this->db->table('orders_parts');

		$subtotal = $this->request->getPost('price_new')*$this->request->getPost('order_qty');
		$builder->set('part_price_sell',$this->request->getPost('price_sell'));
		$builder->set('part_price_disc',$this->request->getPost('discount'));
		$builder->set('part_price',$this->request->getPost('price_new'));
		$builder->set('subtotal',$subtotal);
		$builder->where('order_id',$this->request->getPost('order_id'));
		$builder->where('part_id',$this->request->getPost('part_id'));
		$builder->update();

		$totalSell = 0;
		$total = 0;
		$orderParts = $builder->where(['order_id' => $this->request->getPost('order_id')])->get();
		foreach ($orderParts->getResult() as $row) {       
			$subTotalSell = $row->part_price_sell * $row->order_qty;
			$subTotal = $row->part_price * $row->order_qty;
			$totalSell = $totalSell + $subTotalSell;
			$total = $total + $subTotal;
		}

		$discount_amount = $totalSell - $total;
		if ($discount_amount==0){
			$discount_percent = 0;
		}else{
			$discount_percent = ($discount_amount / $totalSell)*100;
		}
		$vat = $total * 0.10;
		$grandTotal = $total+$vat;

		$this->ordersModel->set('total_sell',$totalSell);
		$this->ordersModel->set('total',$total);
		$this->ordersModel->set('discount_percent',$discount_percent);
		$this->ordersModel->set('discount_amount',$discount_amount);
		$this->ordersModel->set('vat_amount',$vat);
		$this->ordersModel->set('grandtotal',$grandTotal);
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

		$totalSell = 0;
		$total = 0;
		$orderParts = $builder->where(['order_id' => $this->request->getPost('order_id')])->get();
		foreach ($orderParts->getResult() as $row) {       
			$subTotalSell = $row->part_price_sell * $row->order_qty;
			$subTotal = $row->part_price * $row->order_qty;
			$totalSell = $totalSell + $subTotalSell;
			$total = $total + $subTotal;
		}

		$discount_amount = $totalSell - $total;
		if ($discount_amount==0){
			$discount_percent = 0;
		}else{
			$discount_percent = ($discount_amount / $totalSell)*100;
		}
		$vat = $total * 0.10;
		$grandTotal = $total+$vat;

		$this->ordersModel->set('total_sell',$totalSell);
		$this->ordersModel->set('total',$total);
		$this->ordersModel->set('discount_percent',$discount_percent);
		$this->ordersModel->set('discount_amount',$discount_amount);
		$this->ordersModel->set('vat_amount',$vat);
		$this->ordersModel->set('grandtotal',$grandTotal);
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

	public function delivery()
	{
		$grandtotal = $this->request->getPost('total') + $this->request->getPost('vat') + $this->request->getPost('fee');

		$this->ordersModel->set('delivery_fee',$this->request->getPost('fee'));
		$this->ordersModel->set('grandtotal',$grandtotal);
		$this->ordersModel->where('id',$this->request->getPost('order_id'));
		$this->ordersModel->update();

		return redirect()->to('/order/request/resume/'.$this->request->getPost('order_id'));
	}

	public function upload()
	{
		if (empty($this->request->getFile('quoteFile'))){
			$file = $this->request->getFile('quoteFile');
			$file->move('assets/pdf/quotation');
		}else{
			$file = 'noquote';
		}

		dd($file);
	}

	public function submit($param = false)
	{
		if ($param=='quote'){
	
			$quoteFile = $this->request->getFile('quoteFile');
			$quoteFile->move('assets/pdf/quotation');
			
			$this->ordersModel->set('quote_id',$this->request->getPost('quoteId'));
			$this->ordersModel->set('quote_date',date('Y-m-d', strtotime($this->request->getPost('quoteDate'))));
			$this->ordersModel->set('quote_expired',date('Y-m-d', strtotime($this->request->getPost('quoteExpired'))));
			$this->ordersModel->set('quote_file',$quoteFile->getName());
			$this->ordersModel->set('sales_by',session()->get('name'));
			$this->ordersModel->set('sales_by_id',session()->get('id'));
			$this->ordersModel->set('sales_at',date('Y-m-d H:i:s'));
			$this->ordersModel->set('status','2');
			$this->ordersModel->where('id',$this->request->getPost('id'));
			$this->ordersModel->update();
	
			return redirect()->to('/order/request');
		}elseif ($param=='po'){
			
			$this->ordersModel->set('po_id',$this->request->getPost('poId'));
			$this->ordersModel->set('po_date',date('Y-m-d', strtotime($this->request->getPost('poDate'))));
			$this->ordersModel->set('po_receive_by',session()->get('name'));
			$this->ordersModel->set('po_receive_at',date('Y-m-d H:i:s'));
			$this->ordersModel->set('status','3');
			$this->ordersModel->where('id',$this->request->getPost('id'));
			$this->ordersModel->update();
	
			return redirect()->to('/order/receive');
		}elseif ($param=='dn'){
			
			$this->ordersModel->set('dn_id',$this->request->getPost('deliveryId'));
			$this->ordersModel->set('dn_date',date('Y-m-d', strtotime($this->request->getPost('deliveryDate'))));
			$this->ordersModel->set('shipping_by',session()->get('name'));
			$this->ordersModel->set('shipping_at',date('Y-m-d H:i:s'));
			$this->ordersModel->set('status','9');
			$this->ordersModel->where('id',$this->request->getPost('id'));
			$this->ordersModel->update();
	
			return redirect()->to('/order/shipping');
		}
	}
	
	public function quotation()
	{
		if (!session()->get('isLoggedIn')) 
			return redirect()->to('/');
			
		$data = [
			'menu' => 'Keranjang',
			'submenu' => 'Checkout',
		];
		return view('orders/quote', $data);
	}

	public function requote()
	{
		if (!session()->get('isLoggedIn')) 
			return redirect()->to('/');
			
			$this->ordersModel->set('status','1');
			$this->ordersModel->where('id',$this->request->getPost('order_id'));
			$this->ordersModel->update();
	
			return redirect()->to('/order/request/resume/'.$this->request->getPost('order_id'));
	}
	
	public function receive()
	{
		if (!session()->get('isLoggedIn')) 
			return redirect()->to('/');
			
		$data = [
			'menu' => 'Pesanan',
			'submenu' => 'Receive PO',
			'orders' => $this->ordersModel->where(['status' => '2'])->get()
		];
		return view('orders/po-receive-list', $data);
	}
	
	public function receiving($id)
	{
		if (!session()->get('isLoggedIn')) 
			return redirect()->to('/');
			
		$data = [
			'menu' => 'Pesanan',
			'submenu' => 'Receive PO',
			'orders' => $this->ordersModel->where(['id' => $id])->get()->getRow()
		];
		return view('orders/po-receive-process', $data);
	}
	
	public function shipping()
	{
		if (!session()->get('isLoggedIn')) 
			return redirect()->to('/');
			
		$data = [
			'menu' => 'Pesanan',
			'submenu' => 'Pengiriman',
			'orders' => $this->ordersModel->where(['status' => '3'])->get()
		];
		return view('orders/shipping-list', $data);
	}

	//--------------------------------------------------------------------

}