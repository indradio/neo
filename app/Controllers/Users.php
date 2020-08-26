<?php namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{
	protected $usersModel;

	public function __construct()
    {
		$this->usersModel = new UsersModel();
	}

	public function index()
	{
		$data = [
			'menu' => 'Customer',
			'submenu' => 'User',
			'users' => $this->usersModel->where(['group'=>'EXTERNAL'])->get(),
		];
		
		return view('users/index', $data);
	}
	
	public function register()
	{
        $alreadyUser = $this->usersModel->getUser($this->request->getPost('email'))->get()->getRow();
		if (empty($alreadyUser)){

			// $countUsers = $this->usersModel->where(['company_id' => $this->request->getPost('company_id')])->countAllResults();
			// $countAdd = $countUsers+1;
			// $id = $this->request->getPost('company_id'). sprintf("%03s", $countAdd);
			$id = 'CUST'. time();
			
			$this->usersModel->insert([
				'id' => $id,
				'name' => $this->request->getPost('name'),
				'email' => $this->request->getPost('email'),
				'phone' => $this->request->getPost('phone'),
				'photo' => 'default.jpg',
				'company_id' => $this->request->getPost('company_id'),
				'password' =>password_hash($this->request->getPost('pass_conf'), PASSWORD_DEFAULT),
				'status' => 'NEW',
				'group' => 'EXTERNAL',
				'role_id' => '991',
				'is_active' => '0'
				]);
				session()->setFlashdata('message', 'register');

				$response = $this->client->post(
					'https://region01.krmpesan.com/api/v2/message/send-text',
					[
						'headers' => [
							'Content-Type' => 'application/json',
							'Accept' => 'application/json',
							'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
						],
						'json' => [
							// 'phone' => '6281324945151',
							'phone' => '6281311196988',
							'message' => "*PENDAFTARAN USER BARU*" . 
							"\r\n \r\nID : *" . $id . "*" .
							"\r\nNama : *" . $this->request->getPost('name') . "*" .
							"\r\nEmail : *" . $this->request->getPost('email') . "*" .
							"\r\nPerusahaan : *" . $this->request->getPost('company_id') . "*" .
							"\r\n \r\nHarap segera diverifikasi."
						],
					]
				);
				$body = $response->getBody();

				$response = $this->client->post(
					'https://region01.krmpesan.com/api/v2/message/send-text',
					[
						'headers' => [
							'Content-Type' => 'application/json',
							'Accept' => 'application/json',
							'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
						],
						'json' => [
							'phone' => $this->request->getPost('phone'),
							'message' => "*TERIMAKASIH, PENDAFTARAN KAMU BERHASIL*" . 
							"\r\n \r\nPendaftaran kamu pada aplikasi NEO - Winteq Parts Center telah berhasil, akan segera kami verifikasi"
						],
					]
				);
				$body = $response->getBody();

			}else{
				session()->setFlashdata('message', 'alreadyRegister');
				// dd($alreadyUser);
			}
			
		return redirect()->to('/');
	}
	
	public function verify()
	{
		$this->usersModel->set('name',$this->request->getPost('name'));
		$this->usersModel->set('email',$this->request->getPost('email'));
		$this->usersModel->set('phone',$this->request->getPost('phone'));
		$this->usersModel->set('is_active','1');
		$this->usersModel->set('status','ACTIVE');
		$this->usersModel->set('verify_by',session()->get('name'));
		$this->usersModel->where('id',$this->request->getPost('id'));
		$this->usersModel->update();
		session()->setFlashdata('message', 'verifyUser');

		$response = $this->client->post(
			'https://region01.krmpesan.com/api/v2/message/send-text',
			[
				'headers' => [
					'Content-Type' => 'application/json',
					'Accept' => 'application/json',
					'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
				],
				'json' => [
					'phone' => $this->request->getPost('phone'),
					'message' => "*PENDAFTRAN KAMU TELAH DIVERIFIKASI*" . 
					"\r\n \r\nEmail : *" . $this->request->getPost('email') . "*" .
					"\r\nSilahkan login di link berikut https://raisa.winteq-astra.com"
				],
			]
		);
		$body = $response->getBody();

		return redirect()->to('/users');
	}

	public function profile()
	{
		// dd(session()->get('photo'));
		$data = [
			'menu' => '',
			'submenu' => '',
			'user' => $this->usersModel->where(['id'=>session()->get('id')])->first(),
		];
		
		return view('users/profile', $data);
	}

	public function update()
	{
		$this->usersModel->set('phone',$this->request->getPost('phone'));
		$this->usersModel->where('id',session()->get('id'));
		$this->usersModel->update();
		session()->setFlashdata('message', 'updateProfile');

		return redirect()->to('/users/profile/');
	}

	public function change_photo()
	{
		$filePhoto = $this->request->getFile('photo');

		if ($filePhoto->getError()==4){
			return redirect()->to('/users/profile/');
		}
			
		$namePhoto = $filePhoto->getRandomName();		
		$filePhoto->move('assets/img/faces', $namePhoto);

		if ($this->request->getPost('photo')!='default.jpg'){
			unlink('assets/img/faces/'.$this->request->getPost('photo'));
		}

		$this->usersModel->set('photo',$namePhoto);
		$this->usersModel->where('id',session()->get('id'));
		$this->usersModel->update();

		session()->set('photo', $namePhoto);
		session()->setFlashdata('message', 'updateProfile');

		// dd(session()->get('photo'));

		return redirect()->to('/users/profile/');
	}	

	public function user($id)
	{
		// dd(session()->get('photo'));
		$data = [
			'menu' => 'Customer',
			'submenu' => 'User',
			'user' => $this->usersModel->where(['id'=>$id])->first(),
		];
		
		return view('users/user-profile', $data);
	}

	public function new()
	{
		$newUser = $this->usersModel->where(['status'=>'NEW']);
		$newUser = $this->usersModel->where(['group'=>'EXTERNAL'])->get();

		$data = [
			'menu' => 'Customer',
			'submenu' => 'User Baru',
			'users' => $newUser,
		];
		
		return view('users/new-users', $data);
	}

	//--------------------------------------------------------------------

}
