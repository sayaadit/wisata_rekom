<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('Posts_Model', 'dm', TRUE);
		$this->load->model('Ms_Kategori_Model', '', TRUE);
		$this->load->model('Ms_Tags_Model', '', TRUE);
		$this->load->model('Common_Model', 'cm', TRUE);
		
		if (!$this->session->userdata('login')) redirect(y_url_admin().'/login');	
	}
	
	public function index()
	{
		$data['view'] 	= 'backend/gallery/index';
		$data['title']	= 'Gallery';		
		$data['icon']	= 'icon-images2';
		$data['add']	= true;
		
		$this->load->view('backend/tpl', $data);
	}
	
	public function form($id='')
	{
		$data['view'] 	= 'backend/gallery/form';
		$data['title']	= 'Gallery';		
		$data['icon']	= 'icon-images2';
		$data['body']	= 'sidebar-xs has-detached-right';
		
		$this->load->helper('form');
		
		$data['type'] = array_merge(array('' => 'Pilih Tipe Post'), $this->cm->form_post());
		
		if(empty($id))
		{
			$data['action']	= y_url_admin().'/gallery/insert';
			$data['edit']	= false;
		}
		else
		{
			$dbs = $this->dm->getbyid($id)->row();
			
			if(!empty($dbs))
			{
				$data['action']	= y_url_admin().'/gallery/update';
				$data['edit']	= true;
				$data['data']	= $dbs;
				$data['tag']	= $this->dm->get_tags($id)->row();
				$data['images']	= $this->dm->get_images($id)->result();
			}
			else
			{
				$data['action']	= y_url_admin().'/gallery/insert';
				$data['edit']	= false;
				$data['error']	= true;	
			}
		}
				
		$this->load->view('backend/tpl', $data);
	}
	
	public function json()
	{
		if(!$this->input->is_ajax_request()) return false;
		
		$columns = array(
			array( 'db' => 'post_date', 'dt' => 0 ),
			array( 'db' => 'user_title', 'dt' => 1 ),
			array( 'db' => 'user_type', 'dt' => 2 ),
			array( 'db' => 'user_status', 'dt' => 3 )
		);
		
		$this->datatables->set_cols($columns);
		$param	= $this->datatables->query();
		
		if(empty($param['where']))
			$param['where'] = " WHERE post_type = 'gallery' ";
		else
			$param['where'] .= " AND post_type = 'gallery' ";
		
		$result = $this->dm->dtquery($param)->result();
		$filter = $this->dm->dtfiltered();
		$total	= $this->dm->dtcount();
		$output = $this->datatables->output($total, $filter);
		
		foreach($result as $row)
		{
			if($row->post_status == 1)
				$btn = '<a href="javascript:publish('.$row->post_id.',0)" title="Unpublish"><span class="label label-danger label-table"><i class="fa fa-eye-slash"></i> Unpublish</span></a>';
			else
				$btn = '<a href="javascript:publish('.$row->post_id.',1)" title="Publish"><span class="label label-success label-table"><i class="fa fa-eye"></i> Publish</span></a>';
			
			$rows = array (
				date('Y/m/d H:i', strtotime($row->post_date)).'<br><span class="text-grey-300"><em><i class="fa fa-edit"></i> '.date('Y/m/d H:i', strtotime($row->post_modified)).'</em></span>',
				$row->post_title_id,
				$row->post_type,
				$row->post_status == 1 ? 'Publish' : 'Unpublish',
				'<a href="'.y_url_admin().'/gallery/form/'.$row->post_id.'" title="Edit Data"><span class="label label-primary label-table"><i class="fa fa-edit"></i> Edit</span></a> '.$btn
			);
			
			$output['data'][] = $rows;
		}
		
		echo json_encode( $output );
	}
	
	public function insert()
	{
		if(!$this->input->post('inp')) return false;
		
		$item = $this->input->post('inp');
		$item['post_modified'] 	= date('Y-m-d H:i:s');
		$item['post_date'] 		= date('Y-m-d H:i:s');
		$item['post_url'] 		= y_urlf($item['post_title_id']);
		$item['post_author'] 	= y_item_login('user_id');
		$item['post_status'] 	= '1';
		$item['post_type'] 		= 'gallery';
		
		$check_url = $this->dm->getby(array('post_url' => $item['post_url']))->result();
		if(count($check_url) > 0)
			$item['post_url'] .= '-'.count($check_url)+1;				
		
		$id = $this->dm->add($item);
		
		$tags = $this->input->post('tags');
		$this->tags_handler($id, $tags);	
		
		$images = $this->input->post('imgs');
		$this->images_handler($id, $images);
		
		redirect(y_url_admin().'/gallery/form/'.$id);
	}
	
	public function update()
	{
		if(!$this->input->post('inp')) return false;
		if(!$this->input->post('id')) return false;
		
		$item = $this->input->post('inp');
		$id   = $this->input->post('id');
		$item['post_modified'] 	= date('Y-m-d H:i:s');
		$item['post_url'] 		= y_urlf($item['post_title_id']);
		$item['post_author'] 	= y_item_login('user_id');
		
		$check_url = $this->dm->getby(array('post_url' => $item['post_url']))->result();
		if(count($check_url) > 0)
			$item['post_url'] .= '-'.count($check_url);
				
		$tags = $this->input->post('tags');
		$this->tags_handler($id, $tags);	
		
		$images = $this->input->post('gallery-images-pick');
		$this->images_handler($id, $images);
		
		$this->dm->edit($id, $item);
		
		redirect(y_url_admin().'/gallery/form/'.$id);
	}
	
	public function publish()
	{
		if(!$this->input->is_ajax_request()) return false;
		if(!$this->input->post('id')) return false;
		
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		
		$this->dm->edit($id, array('post_status' => $status));
		
		echo 'ok;';
	}
	
	/**		FOR ADDITONAL FUNCTION
			Untuk Menambah function baru silahkan letakkan di bawah ini.
	**/
	
	private function tags_handler($id_post, $tags_txt)
	{
		$tags = explode(',', $tags_txt);
		
		//get exsisting ms_tags in database
		$tags_txt_in = '';
		foreach($tags as $tag)
			$tags_txt_in .= "'$tag',";
		$tags_txt_in = substr($tags_txt_in,0,-1);
		
		$tags_db = $this->Ms_Tags_Model->getbytags($tags_txt_in)->result();
		$tags_db_array = array();
		foreach($tags_db as $tdb)
			$tags_db_array[$tdb->tag_name] = $tdb->tag_id;
			
		//delete exsisting post_tag in database
		$this->Ms_Tags_Model->delete_post_tag($id_post);
	
		//insert tags into database
		foreach($tags as $tag)
		{
			if(isset($tags_db_array[$tag]))
				$id = $tags_db_array[$tag];
			else							
				$id = $this->Ms_Tags_Model->add(array('tag_url' => y_urlf($tag), 'tag_name' => $tag));
			
			$this->Ms_Tags_Model->add_post_tag(array('pt_id_post' => $id_post, 'pt_id_tag' => $id));
		}
		
		//recount tags
		$this->Ms_Tags_Model->recount_tags();
	}
	
	private function images_handler($id_post, $images)
	{
		$items = '';
		foreach($images as $image)
			$items[] = array('pg_id_post' 	=> $id_post,
							 'pg_img'		=> $image);
		
		$this->dm->delete_post_gallery($id_post);
		$this->dm->add_post_gallery($items);
	}
}

?>