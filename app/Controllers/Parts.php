<?php namespace App\Controllers;

use App\Models\PartsModel;

class Parts extends BaseController
{
	protected $partsModel;
	public function __construct()
    {
		// parent::__construct();
		$this->partsModel = new PartsModel();
    }

	public function index()
	{
		$data = [
			'menu' => 'Part',
			'submenu' => 'Wish Part',
		];
		return view('part/index', $data);
	}

	public function item($id)
	{
		$data = [
			'menu' => 'Komponen',
			'submenu' => '',
			'part' => $this->partsModel->getPart($id)->first()
		];
		return view('parts/item', $data);
	}
	
	public function part()
	{
		$output = array(
            "data" => $this->partsModel->getAll()
        );
        //output to json format
        echo json_encode($output);
	}
	
	public function favorite()
	{
		$data = [
			'menu' => 'Komponen',
			'submenu' => 'Favorit',
			'part' => $this->partsModel->getPart()
		];
		return view('parts/favorite', $data);
    }

	//--------------------------------------------------------------------

}
