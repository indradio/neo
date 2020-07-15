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
			'menu' => 'Dashboard',
			'submenu' => '',
			'users' => $this->usersModel->where(['group'=>'EXTERNAL'])->get(),
		];
		
		return view('users/index', $data);
		
	}
	
	public function register()
	{
        $alreadyUser = $this->usersModel->getUser($this->request->getPost('email'))->get()->getRow();
		if (empty($alreadyUser)){

			$countUsers = $this->usersModel->where(['company_id' => $this->request->getPost('company_id')])->countAllResults();
			$countAdd = $countUsers+1;
			$id = $this->request->getPost('company_id'). sprintf("%03s", $countAdd);
			$this->usersModel->insert([
				'id' => $id,
				'name' => $this->request->getPost('name'),
				'email' => $this->request->getPost('email'),
				'phone' => $this->request->getPost('phone'),
				'photo' => 'default.jpg',
				'company_id' => $this->request->getPost('company_id'),
				'password' =>password_hash($this->request->getPost('phone'), PASSWORD_DEFAULT),
				'status' => 'NEW',
				'group' => 'EXTERNAL',
				'role_id' => '991',
				'is_active' => '0'
				]);
				// session()->setFlashdata('message', 'addcart');
		}else{
				dd($alreadyUser);
        }
        
		return redirect()->to('/register');
    }

	//--------------------------------------------------------------------

}
