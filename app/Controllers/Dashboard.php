<?php namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\OrdersModel;
use App\Models\PartsModel;

class Dashboard extends BaseController
{
	protected $usersModel;
	protected $ordersModel;
	protected $partsModel;

	public function __construct()
    {
		$this->usersModel = new UsersModel();
		$this->ordersModel = new OrdersModel();
		$this->partsModel = new PartsModel();
    }

	public function index()
	{
		// $response = $this->client->post(
		// 	'https://region01.krmpesan.com/api/v2/message/send-text',
		// 	[
		// 		'headers' => [
		// 			'Content-Type' => 'application/json',
		// 			'Accept' => 'application/json',
		// 			'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
		// 		],
		// 		'json' => [
		// 			'phone' => '081311196988',
		// 			'message' => "*INFORMASI LEMBUR HARI INI*" . 
		// 			"\r\n \r\nTanggal : *" . date('d M Y') . "*" .
					
		// 			"\r\n \r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
		// 		],
		// 	]
		// );
		// $body = $response->getBody();
				
		if (session()->get('roleId')==991 or session()->get('roleId')==1){
			$builder = $this->db->table('parts_favorite');
			$partsFav = $builder->where('user_id',session()->get('id'))->countAllResults();

			$this->ordersModel->where(['user_id' => session()->get('id')]);
			$onShip = $this->ordersModel->where(['status' => '4'])->countAllResults();

			$this->ordersModel->where(['user_id' => session()->get('id')]);
			$onPrepare = $this->ordersModel->where(['status' => '4'])->countAllResults();

			$this->ordersModel->where(['user_id' => session()->get('id')]);
			$newOrders = $this->ordersModel->where(['status' => '1'])->countAllResults();

			$this->ordersModel->where(['user_id' => session()->get('id')]);
			$activeQuote = $this->ordersModel->where(['status' => '2'])->countAllResults();

			$builder = $this->db->table('keyword');
			$keyword = $builder->where('id',rand(1,10))->get()->getRow();

			$data = [
				'menu' => 'Dashboard',
				'submenu' => '',
				'partsFav' => $partsFav,
				'onShip' => $onShip,
				'onPrepare' => $onPrepare,
				'newOrders' => $newOrders,
				'activeQuote' => $activeQuote,
				'keyword' => $keyword->keyword
			];
			return view('dashboard/index', $data);
		}else{
			$data = [
				'menu' => 'Dashboard',
				'submenu' => '',
				'newOrders' => $this->ordersModel->where(['status' => '1'])->get(),
				'poReceive' => $this->ordersModel->where(['status' => '2'])->get(),
				'shipping' => $this->ordersModel->where(['status' => '3'])->get(),
				'countNewOrders' => $this->ordersModel->where(['status' => '1'])->countAllResults(),
			];
			return view('dashboard/index-sales', $data);
		}
    }

	//--------------------------------------------------------------------

}
