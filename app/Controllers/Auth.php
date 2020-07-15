<?php namespace App\Controllers;

use App\Models\UsersModel;

class Auth extends BaseController
{
	protected $usersModel;
	public function __construct()
	{
		$this->usersModel = new UsersModel();
	}

	public function index()
	{
        if (session()->get('isLoggedIn')) {
			return redirect()->to('/dashboard');
		}else{
            return redirect()->to('auth/login');
        }
    }
    
    public function register()
	{
        $db = \Config\Database::connect();
        $builder = $db->table('company');
        $data = [
            'company' => $builder->get() 
        ];
		return view('auth/register', $data);
    }
	
	public function login()
	{
		return view('auth/login');
	}

	public function submit()
	{
		$email = $this->request->getPost('email');
        $password = $this->request->getPost('pswd');

		$user = $this->usersModel->where(['email'=>$email])->first();
		if (!empty($user)) {
            if (password_verify($password, $user['password'])) {
                $this->setUserSession($user);
                session()->setFlashdata('message', 'welcome');
				return redirect()->to('/dashboard');
            } else {
                // $this->session->set_flashdata('message', '<div class="alert alert-rose">
                // <strong>Login Gagal</strong>
                // <span>Maaf, Password yang kamu masukan salah.</span>
                // </div> </br>');
                return redirect()->to('login');
            }
        } else {
            // $this->session->set_flashdata('message', '<div class="alert alert-rose">
            // <strong>Login Gagal</strong>
            // <span>Maaf, NPK Kamu tidak ditemukan.</span>
            // </div> </br>');
            return redirect()->to('login');
        }
		
    }

    private function setUserSession($user){
        $data = [
            'id' => $user['id'],
            'username' => $user['username'],
            'name' => $user['name'],
            'email' => $user['email'],
            'phone' => $user['phone'],
            'companyId' => $user['company_id'],
            'group' => $user['group'],
            'roleId' => $user['role_id'],
            'isLoggedIn' => true
        ];
        session()->set($data);
    }

	public function logout()
	{
        session()->destroy();
		return redirect()->to('login');
    }
    


	//--------------------------------------------------------------------

}
