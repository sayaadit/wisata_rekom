<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('Media_Model', 'dm', TRUE);
		$this->load->model('Common_Model', 'cm', TRUE);
		
		if (!$this->session->userdata('login')) redirect(y_url_admin().'/login');	
	}
	
	public function index()
	{
		$data['view'] 	= 'backend/media/index';
		$data['title']	= 'Media';		
		$data['icon']	= 'icon-image2';		
		$data['add']	= true;
		
		$this->load->view('backend/tpl', $data);
	}
	
	public function load()
	{
		if(!$this->input->is_ajax_request()) return false;
		if(!$this->input->post('page')) return false;
		
		$page = $this->input->post('page');
		
		$data['paged']	= $page;
		$data['data']	= $this->dm->get_media_page(1)->result();
		$data['count']	= $this->dm->get_media_count()->row()->jumlah;
		
		echo $this->load->view('backend/media/images', $data, TRUE);
	}
	
	public function json()
	{
		if(!$this->input->is_ajax_request()) return false;
		
		$columns = array(
			array( 'db' => 'cat_type', 'dt' => 0 ),
			array( 'db' => 'cat_name', 'dt' => 1 )
		);
		
		$this->datatables->set_cols($columns);
		$param	= $this->datatables->query();		
		$result = $this->dm->dtquery($param)->result();
		$filter = $this->dm->dtfiltered();
		$total	= $this->dm->dtcount();
		$output = $this->datatables->output($total, $filter);
		
		foreach($result as $row)
		{
			$rows = array (
				'',
				$row->media_name,
				'<a href="javascript:edit('.$row->cat_id.')" title="Edit Data"><span class="label label-primary label-table"><i class="fa fa-edit"></i> Edit</span></a>
				<a href="javascript:del('.$row->cat_id.', \''.$row->cat_name.'\')" title="Delete Data"><span class="label label-danger label-table"><i class="fa fa-trash"></i> Hapus</span></a>',
				$row->cat_id
			);
			
			$output['data'][] = $rows;
		}
		
		echo json_encode( $output );
	}
	
	public function insert()
	{ 
		if (!empty($_FILES['file']['name'])) 
		{	
			$item 	= array();
			$thumb 	= $this->config->item('thumb');
			$namext	= $_FILES['file']['name'];
			$ext	= pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			$name	= str_replace('.'.$ext, '', $namext);
			$url  	= y_urlf($name);
			
			$check_url = $this->dm->check_url($url)->row()->jml;
			if($check_url > 0)
			{
				$curl = $check_url+1;
				$name .= ' '.$curl;
				$url  .= '-'.$curl;
			}
			
			$path = 'cdn';
			if (!file_exists($path.'/'.date('Y')) && !is_dir($path.'/'.date('Y'))) {
				mkdir($path.'/'.date('Y'), 0777, TRUE);         
			}
			if (!file_exists($path.'/'.date('Y').'/'.date('m')) && !is_dir($path.'/'.date('Y').'/'.date('m'))) {
				mkdir($path.'/'.date('Y').'/'.date('m'), 0777, TRUE);         
			}
			
			$new_name 		= $url.'.'.$ext;
			$target_dir 	= $path.'/'.date('Y').'/'.date('m').'/'; 
			$target_file 	= $target_dir.$new_name;
			
			$config['file_name']	= $url;
			$config['upload_path']	= $target_dir;
			$config['allowed_types']= 'gif|jpg|png|bmp|svg|ico|pdf|xls|xlsx|doc|docx|ppt|pptx|txt|zip|rar';
			$config['overwrite']	= true;

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('file'))
			{
				$return = array('status' => false,
								'error' => $this->upload->display_errors());
				echo json_encode($return);
				return false;
			}			
			
			$data = $this->upload->data();
			$type = explode('/', $data['file_type']);
			
			if ($type[0] == 'image') 
			{
				$this->load->library('image_lib');
				
				if($data['image_width'] > 2000 || $data['image_width'] > 2000)
				{
					$config2['source_image'] 	= $data['full_path'];
					$config2['maintain_ratio'] 	= TRUE;
					$config2['image_library'] 	= 'gd2';
					$config2['thumb_marker'] 	= '';
					$config2['quality'] 		= '100%';
					
					if($data['image_height'] > $data['image_width'])
					{
						$config2['width'] 	= 0;
						$config2['height'] 	= 1300;
					}
					else
					{
						$config2['width'] 	= 1300;
						$config2['height'] 	= 0;
					}
					
					$this->image_lib->initialize($config2);
					$this->image_lib->fit();
					$this->image_lib->clear();
				}
				
				if(!empty($thumb))
				{				
					foreach($thumb as $th)
					{
						$config3['source_image'] 	= $target_dir.$new_name;
						$config3['new_image']		= $data['raw_name'].'-'.$th['width'].'x'.$th['height'].$data['file_ext'];
						$config3['image_library'] 	= 'gd2';
						$config3['quality'] 		= '100%';
						$config3['width'] 			= $th['width'];
						$config3['height'] 			= $th['height'];
						$config3['maintain_ratio'] 	= TRUE;
						
						if($nameth == 'medium')						
							$config3['master_dim'] 	= 'height';	
						else					
							$config3['master_dim'] 	= 'width';
						
						$this->image_lib->initialize($config3);
						$this->image_lib->fit();
						$this->image_lib->clear();
					}
				}
			}
			
			$item = array('media_date'	=> date('Y-m-d H:i:s'), 
						  'media_name'	=> $name, 
						  'media_url'	=> $data['raw_name'], 
						  'media_type'	=> $type[0], 
						  'media_mime'	=> $data['file_type'], 
						  'media_file'	=> $data['orig_name'], 
						  'media_ext'	=> $ext,
						  'media_path'	=> $target_dir,
						  'media_token'	=> $_POST['token_foto']);
						 
			$this->dm->add($item);
			
			$return = array('status' => true,
							'name'	 => $name);
							
			echo json_encode($return);
		}
	}
	
	public function edit()
	{
		if(!$this->input->post('id')) return false;
		
		echo json_encode($this->dm->getbyid($this->input->post('id'))->row());
	}
	
	public function update()
	{
		if(!$this->input->is_ajax_request()) return false;
		if(!$this->input->post('inp')) return false;
		
		$item = $this->input->post('inp');
		$id   = $this->input->post('id');
		$item['cat_url'] = y_urlf($item['cat_name']);
		
		$this->dm->edit($id, $item);
		echo 'ok;';
	}
	
	public function delete()
	{
		if(!$this->input->is_ajax_request()) return false;
		if(!$this->input->post('id')) return false;
		
		$id = $this->input->post('id');
		$db	= $this->dm->getbyid($id)->row();
		
		if(!empty($db))
		{
			$this->dm->delete($db->media_id);
			
			unlink(FCPATH.$db->media_path.$db->media_file);
			
			//thumb
			if ($db->media_type == 'image') 
			{
				$thumb 	= $this->config->item('thumb');
				if(!empty($thumb))
				{				
					foreach($thumb as $th)
					{
						$name = $db->media_url.'-'.$th['width'].'x'.$th['height'].'.'.$db->media_ext;
						unlink(FCPATH.$db->media_path.$name);
					}
				}
			}
		}
		
		echo 'ok;';
	}
	
	public function delete_token()
	{
		if(!$this->input->is_ajax_request()) return false;
		if(!$this->input->post('token')) return false;
		
		$token 	= $this->input->post('token');
		$db		= $this->dm->getby(array('media_token' => $token))->row();
		
		if(!empty($db))
		{
			$this->dm->delete($db->media_id);
			
			unlink(FCPATH.$db->media_path.$db->media_file);
			
			//thumb
			if ($db->media_type == 'image') 
			{
				$thumb 	= $this->config->item('thumb');
				if(!empty($thumb))
				{				
					foreach($thumb as $th)
					{
						$name = $db->media_url.'-'.$th['width'].'x'.$th['height'].'.'.$db->media_ext;
						unlink(FCPATH.$db->media_path.$name);
					}
				}
			}
		}
		
		echo 'ok;';
	}
	
	/**		FOR ADDITONAL FUNCTION
			Untuk Menambah function baru silahkan letakkan di bawah ini.
	**/	
	
	public function load_json()
	{
		if(!$this->input->is_ajax_request()) return false;
		if(!$this->input->post('page')) return false;
		
		$page = $this->input->post('page');
		$dbs  = $this->dm->get_media_page2($page, 30)->result();
		$json = array();
		
		if(!empty($dbs))
		{
			foreach($dbs as $db)
			{
				if ($db->media_type == 'image') 
				{
					$thumb 	= $this->config->item('thumb');
					$img = $db->media_path.$db->media_url.'-'.$thumb['thumbnail']['width'].'x'.$thumb['thumbnail']['height'].'.'.$db->media_ext;
				}
				else $img = $db->media_path.$db->media_file;
				
				$json['empty'] = false;
				$json['data'][]  = array( 'id' 	=> $db->media_id,
										'img' 	=> $img,
										'path'	=> $db->media_path,
										'url'	=> $db->media_url,
										'name' 	=> $db->media_name,
										'date' 	=> y_date_text($db->media_date),
										'res' 	=> '1000x1000',
										'type' 	=> $db->media_type,
										'ext'	=> $db->media_ext,
										'size'	=> '21 Mb');
			}
		}
		else
		{
			$json['empty'] = true;	
		}
		
		echo json_encode($json);
	}
	
	public function x()
	{
		$this->load->library('image_lib');
		$media = $this->db->query("SELECT * FROM media")->result();
		foreach($media as $m)
		{
			$ext	= pathinfo($m->media_file, PATHINFO_EXTENSION);
			$name	= str_replace('.'.$ext, '', $m->media_file);
			
			$config3['source_image'] 	= 'cdn/2017/09/'.$m->media_file;
			$config3['new_image']		= 'cdn/2017/09/'.$name.'-324x160.'.$ext;
			$config3['image_library'] 	= 'gd2';
			$config3['quality'] 		= '100%';
			$config3['width'] 			= 324;
			$config3['height'] 			= 160;
			$config3['maintain_ratio'] 	= TRUE;
			$config3['master_dim'] 		= 'height';
			
			$this->image_lib->initialize($config3);
			$this->image_lib->fit();
			$this->image_lib->clear();
		}
	}
}

?>