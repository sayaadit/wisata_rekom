<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recommender extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();	
		
		$this->load->model('Posts_Model', 'dm', TRUE);
		$this->load->model('Ms_Category_Model', '', TRUE);
		$this->load->model('Common_Model', '', TRUE);
	}

	public function index()
	{
		$data['view'] 	= 'frontend/recommender/index';
		$data['title']	= 'Recommender';		
		$data['icon']	= 'fa-home';
		
		$data['cats'] = $this->Ms_Category_Model->getall()->result();
		
		$this->load->view('frontend/tpl_rec', $data);
	}

	public function step2()
	{
		$locations = $this->input->get('dest');
		
		if(!empty($locations) && preg_match('/-/', $locations))
		{
			$locs = $this->dm->get_location_in(str_replace('-', ',', $locations))->result();		
			if(empty($locs))
				redirect('recommender');
		}
		else redirect('recommender');
		
		$data['view'] 	= 'frontend/recommender/step2';
		$data['title']	= 'Recommender';		
		$data['icon']	= 'fa-home';
		
		$this->load->helper('form');
		
		$hotels = $this->dm->get_hotel()->result();
		$data['hotel'][''] = 'Pilih Hotel';
		foreach($hotels as $hotel)
			$data['hotel'][$hotel->post_id] = $hotel->post_title_id;
			
		$data['locs'] = $locs;
		$data['algorithm'] = $this->Common_Model->form_algorithm();
		
		$this->load->view('frontend/tpl_rec', $data);
	}

	public function result()
	{
		$locations	= $this->input->get('dest');
		$idhotel	= $this->input->get('hotel');
		$visit		= $this->input->get('visit');
		$price		= $this->input->get('price');
		$rating		= $this->input->get('rating');
		$algorithm	= $this->input->get('algorithm');
		$error		= false;
		$etext		= '';
		
		$output 	= shell_exec("python application\list-based-sa-for-tsp/main.py");
		$rekomen	= json_decode($output);	
		// todo
		// 1. Run exec pyhton script
		// 1.1 Baca dari MySQL
		// 2. Disitu decode result hasil dari exec
		// 3. tambahkan variable ke data dari hasil decode
		
		if(!empty($locations) && preg_match('/-/', $locations))
		{
			$locs = $this->dm->get_location_in(str_replace('-', ',', $locations))->result();		
			if(empty($locs))
			{
				$error = true;
				$etext .= 'Parameter Destinasi Wisata tidak tersedia dalam database.<br>';
			}
		}
		else 
		{
			$error = true;
			$etext .= 'Parameter Destinasi Wisata tidak valid.<br>';
		}
		
		if(!empty($idhotel))
		{
			$hotel = $this->dm->get_hotel_id($idhotel)->row();		
			if(empty($hotel))
			{
				$error = true;
				$etext .= 'Parameter Hotel tidak tersedia dalam database.<br>';
			}
		}
		else
		{
			$error = true;
			$etext .= 'Parameter Hotel tidak valid.<br>';
		}
		
		if(empty($visit)) $visit = 1;
		if(empty($price)) $price = 1;
		if(empty($rating)) $rating = 1;
		
		if(!$error)
		{
			$param = array();
			
			foreach($locs as $loc)
				$param['idWisata'][] = array('id' => $loc->post_id);
			
			$param['idhotel'][] = $hotel->post_id;
			$param['degree'][] = (float) $visit;
			$param['degree'][] = (float) $price;
			$param['degree'][] = (float) $rating;
			
			// echo 'http://127.0.0.1:5000/dashboard/{"idWisata":[{"id":"1"},{"id":"5"},{"id":"9"}],"degree":[1,1,1],"idhotel":[33]}<br>';
			// echo 'http://127.0.0.1:5000/dashboard/'.json_encode($param);
			
			// $result = file_get_contents('http://127.0.0.1:5000/dashboard/'.json_encode($param));
			// $json = json_decode($result);
			
			// $d1 = $json->day1;
			// echo '<pre>';
			// print_r($json);
			// echo '</pre>';
			$result = $this->curl($this->config->item('urlapi').'/'.$algorithm.'/'.json_encode($param));
			print $result;

			if($result = $this->curl($this->config->item('urlapi').'/'.$algorithm.'/'.json_encode($param)))
			{
				$json = json_decode($result);
			
				if(!empty($json->day1->index))
				{
					$error = false;
				}
				else 
				{
					$error = true;
					$etext .= 'Tidak dapat ditemukan hasil rekomendasi yang optimum, silahkan cek kembali preferensi anda.<br>';					
				}
			}
			else 
			{
				$error = true;
				$etext .= 'Tidak dapat terhubung dengan server algoritma, silahkan ulangi kembali.<br>';
			}
		}
		else 
		{
			$error = true;
			$etext .= 'Note: Jangan merubah apapun pada URL. Tekan <strong>Kembali</strong> untuk memulai sesi yang baru.<br>';
		}
		
		if(!$error)
		{
			foreach($locs as $loc)
				$data['locs'][$loc->post_id] = $loc;
			
			$data['result'] = $json;
			$data['hotel'] 	= $hotel;	
			$data['error'] 	= false;
		}
		else
		{
			$data['error'] = true;
			$data['etext'] = $etext;	
		}
		
		$data['view'] 	= 'frontend/recommender/result';
		$data['title']	= 'Recommender';		
		$data['icon']	= 'fa-home';
		$data['output'] = $output;
		$data['solution'] = $rekomen->solution;
		$data['fitness'] = $rekomen->fitness;
		//Gak 
		
		$this->load->view('frontend/tpl_rec', $data);
	}

	public function result2()
	{
		$data['view'] = 'frontend/recommender/result2';
		$data['title']	= 'Recommender';		
		$data['icon']	= 'fa-home';
		
		$this->load->view('frontend/tpl_rec', $data);
	}
	
	public function get_destination()
	{
		if(!$this->input->is_ajax_request()) return false;
		if(!$this->input->post('page')) return false;
		
		$id   = $this->input->post('id');
		$id	  = str_replace('|', ',', trim($id));
		$page = $this->input->post('page');
				
		$page	= (int) $page; 
		$limit 	= 15;
		$start 	= $page > 0 ? $limit * ($page-1) : 0;
		$total 	= $this->dm->get_destination_count($id)->row()->jml;
		$dbs   	= $this->dm->get_destination($id, $limit, $start)->result();
		
		$cats = $this->Ms_Category_Model->getall()->result();
		$info = array();
		foreach($cats as $cat) $info[$cat->cat_id] = $cat;
		
		$data['id']	   = $id;
		$data['info']  = $info;
		$data['total'] = $total;
		$data['limit'] = $limit;
		$data['start'] = $start;
		$data['page']  = $page;
		$data['data']  = $dbs;
		
		echo $this->load->view('frontend/recommender/destination_list', $data, true);
	}
	
	private function curl($url)
	{
		//open connection
		$ch = curl_init();
	
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL,$url);
	
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,10); # timeout after 10 seconds, you can increase it
	   //curl_setopt($ch,CURLOPT_HEADER,false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  # Set curl to return the data instead of printing it to the browser.
		curl_setopt($ch, CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)"); # Some server may refuse your request if you dont pass user agent
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	
		//execute post
		$result = curl_exec($ch);
	
		//close connection
		curl_close($ch);
		return $result;	
	}
	
	public function x()
	{
		$data = $this->db->query("SELECT * FROM posts")->result();
		foreach($data as $row)
		{
			echo "UPDATE posts SET post_url = '".y_urlf($row->post_title_id)."', post_date = now(), post_modified = now() WHERE post_id = '".$row->post_id."';<br>";
			//$this->db->query("UPDATE posts SET post_url = '".y_urlf($row->post_id)."' WHERE post_id = '".$row->post_id."'");	
		}	
	}
}
