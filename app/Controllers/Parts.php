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
			'submenu' => 'Semua Part',
			'keyword' => $this->request->getPost('mySearch'),
		];
		return view('parts/index', $data);
	}

	public function item($id)
	{
		$data = [
			'menu' => 'Part',
			'submenu' => '',
			'part' => $this->partsModel->getPart($id)->first()
		];
		if (empty($data['part'])){
			return view('parts/notfound', $data);
		}
		return view('parts/item', $data);
	}

	public function id($id)
	{
		$data = [
			'menu' => 'Part',
			'submenu' => '',
			'part' => $this->partsModel->getPart($id)->first()
		];
		if (empty($data['part'])){
			return view('parts/notfound', $data);
		}
		return view('parts/details', $data);
	}
	
	public function part()
	{
		$output = array(
            "data" => $this->partsModel->getAll()
        );
		//output to json format
        echo json_encode($output);
	}

	// public function partFav()
	// {
	// 			 $builder = $this->db->table('parts_favorite');
	// 	$parts = $builder->where('user_id',session()->get('id'));
		
	// 	$output = array(
    //         "data" => $parts->get()->getResult()
	// 	);
	// 	// dd($output);
    //     //output to json format
    //     echo json_encode($output);
	// }

	public function partFav()
	{
			   $builder = $this->db->table('parts_favorite');
		$fav = $builder->where('user_id',session()->get('id'))->get()->getResultArray();
		if(!empty($fav)){
			foreach ($fav as $row) {
				$builder = $this->db->table('parts');
				$part = $builder->where('id',$row['id'])->get()->getRow();
				if (empty($part)) {
					$soldout = 1;
					$output['data'][] = array(
						'id' => $row['id'],
						'name' => $row['name'],
						'description' => $row['description'],
						'photo' => 'soldout.jpg',
						'soldout' => $soldout
					);
				}else{
					$soldout = 0;
					$output['data'][] = array(
						'id' => $part->id,
						'name' => $part->name,
						'description' => $part->description,
						'category' => $part->category,
						'qty' => $part->qty,
						'uom' => $part->uom,
						'high_price' => $part->high_price,
						'price' => $part->price,
						'discount' => $part->discount,
						'photo' => $part->photo,
						'soldout' => $soldout
					);
				}
			}
		}else{
			$output['data'][] = array();
		}
        //output to json format
        echo json_encode($output);
	}

	// public function partFav_limit()
	// {
	// $builder = $this->db->table('parts_favorite');
	// $builder->limit(6);
	// $fav = $builder->where('user_id',session()->get('id'))->get()->getResultArray();
	// foreach ($fav as $row) {
	// 			$builder = $this->db->table('parts');
	// 	$part = $builder->where('id',$row['id'])->get()->getRow();
	// 	if (empty($part)) {
	// 	$soldout = 1;
	// 	$output['data'][] = array(
	// 		'id' => $row['id'],
	// 		'name' => $row['name'],
	// 		'description' => $row['description'],
	// 		'photo' => 'soldout.jpg',
	// 		'soldout' => $soldout
	// 	);
	// 	}else{
	// 		$soldout = 0;
	// 		$output['data'][] = array(
	// 			'id' => $part->id,
	// 			'name' => $part->name,
	// 			'description' => $part->description,
	// 			'category' => $part->category,
	// 			'qty' => $part->qty,
	// 			'uom' => $part->uom,
	// 			'high_price' => $part->high_price,
	// 			'price' => $part->price,
	// 			'discount' => $part->discount,
	// 			'photo' => $part->photo,
	// 			'soldout' => $soldout
	// 		);
	// 	}
	// }
	
	// //output to json format
	// echo json_encode($output);
	// }
	
	public function favorite()
	{
		$data = [
			'menu' => 'Part',
			'submenu' => 'Favorit',
			'part' => $this->partsModel->getPart()
		];
		return view('parts/favorite', $data);
	}
	
	public function add_favorite($id=false)
	{
		$part = $this->partsModel->getPart($id)->get()->getRow();

						$builder = $this->db->table('parts_favorite');
						$builder->where('id',$id);
		 $alreadyPart = $builder->where('user_id',session()->get('id'))->get()->getRow();

		if (empty($alreadyPart)){
			$builder->insert([
				'id' => $part->id,
				'name' => $part->name,
				'description' => $part->description,
				'category' => $part->category,
				'uom' => $part->uom,
				'sloc' => $part->sloc,
				'updated_at' => date('Y-m-d H:i:s'),
				'user_id' => session()->get('id'),
			]);
			session()->setFlashdata('message', 'addFav');
		}else{
			session()->setFlashdata('message', 'alreadyFav');
		}
		return redirect()->to('/');
	}

	public function modify()
	{
		$part = $this->partsModel->getPart($this->request->getPost('id'))->get()->getRow();

						$builder = $this->db->table('parts_updated');
		 $alreadyPart = $builder->where('id',$this->request->getPost('id'))->get()->getRow();

		if (empty($alreadyPart)){
			$builder->insert([
				'id' => $part->id,
				'name' => $part->name,
				'description' => $part->description,
				'category' => $this->request->getPost('category'),
				'high_price' => $this->request->getPost('high_price'),
				'discount' => $this->request->getPost('discount'),
				'price' => $this->request->getPost('price'),
				'updated_by' => session()->get('name'),
				'updated_at' => date('Y-m-d H:i:s'),
			]);

			$this->partsModel->set('category',$this->request->getPost('category'));
			$this->partsModel->set('high_price',$this->request->getPost('high_price'));
			$this->partsModel->set('discount',$this->request->getPost('discount'));
			$this->partsModel->set('price',$this->request->getPost('price'));
			$this->partsModel->where('id',$this->request->getPost('id'));
			$this->partsModel->update();

		}else{
			$builder->set('category',$this->request->getPost('category'));
			$builder->set('high_price',$this->request->getPost('high_price'));
			$builder->set('discount',$this->request->getPost('discount'));
			$builder->set('price',$this->request->getPost('price'));
			$builder->set('updated_by',session()->get('name'));
			$builder->set('updated_at',date('Y-m-d H:i:s'));
			$builder->where('id',$this->request->getPost('id'));
			$builder->update();

			$this->partsModel->set('category',$this->request->getPost('category'));
			$this->partsModel->set('high_price',$this->request->getPost('high_price'));
			$this->partsModel->set('discount',$this->request->getPost('discount'));
			$this->partsModel->set('price',$this->request->getPost('price'));
			$this->partsModel->where('id',$this->request->getPost('id'));
			$this->partsModel->update();
			
		}
		session()->setFlashdata('message', 'updatedPart');
		return redirect()->to('/parts/id/'.$this->request->getPost('id'));
	}

	public function change()
	{

		$builder = $this->db->table('parts_photo');
		$alreadyPart = $builder->where('id',$this->request->getPost('id_part'))->get()->getRow();
		// dd($alreadyPart);

		$filePhoto = $this->request->getFile('photo');

		if ($filePhoto->getError()==4){
			return redirect()->to('/parts/id/'.$this->request->getPost('id_part'));
		}
			
		$namePhoto = $filePhoto->getRandomName();		
		$filePhoto->move('assets/img/parts', $namePhoto);

		if (empty($alreadyPart)){
			$builder->insert([
				'id' => $this->request->getPost('id_part'),
				'name' => $this->request->getPost('name_part'),
				'photo' => $namePhoto,
				'updated_at' => date('Y-m-d H:i:s'),
			]);

			$this->partsModel->set('photo', $namePhoto);
			$this->partsModel->where('id',$this->request->getPost('id_part'));
			$this->partsModel->update();
		}else{
			unlink('assets/img/parts/'.$alreadyPart->photo);

			$builder->set('photo', $namePhoto);
			$builder->set('updated_at', date('Y-m-d H:i:s'));
			$builder->where('id',$this->request->getPost('id_part'));
			$builder->update();

			$this->partsModel->set('photo', $namePhoto);
			$this->partsModel->where('id',$this->request->getPost('id_part'));
			$this->partsModel->update();
		}

		return redirect()->to('/parts/id/'.$this->request->getPost('id_part'));
	}	
	
	
	public function remove_favorite()
{
		$builder = $this->db->table('parts_favorite');
		$builder->where('id',$this->request->getPost('id'));
		$builder->where('user_id',session()->get('id'));
		$builder->delete();

		session()->setFlashdata('message', 'removeFav');
		return redirect()->to('/parts/favorite');
    }

	//--------------------------------------------------------------------

}
