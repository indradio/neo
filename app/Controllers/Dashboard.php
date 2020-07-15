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
				
		$data = [
			'menu' => 'Dashboard',
			'submenu' => '',
			'newOrders' => $this->ordersModel->where(['status' => '1'])->get(),
			'countNewOrders' => $this->ordersModel->where(['status' => '1'])->countAllResults(),
		];
		if (session()->get('roleId')==991 or session()->get('roleId')==1){
			return view('dashboard/index', $data);
		}else{
			return view('dashboard/index-sales', $data);
		}
    }

	//--------------------------------------------------------------------

}
