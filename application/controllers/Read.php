<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Read extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('Posts_Model', 'dm', TRUE);
		$this->load->model('Ms_Category_Model', '', TRUE);
		$this->load->model('Ms_Tags_Model', '', TRUE);
		
		//if (!$this->session->userdata('login')) redirect('login');	
	}

	public function index($id='', $url='')
	{
		if(empty($id) || empty($url)) redirect('');
		
		$db = $this->dm->getbyid($id)->row();
		
		if(empty($db))
		{
			show_404();
			return false;	
		}
		
		$data['data'] = $db;
		$data['view']	= 'frontend/read/post';
		
		$cats = $this->Ms_Category_Model->get_cat_bypost($db->post_id)->result();
		$scat = '';
		foreach($cats as $cat)
			$scat .= "'".$cat->cat_id."',";
		$scat = substr($scat, 0, -1);
		
		$data['cats'] = $cats;
		
		$this->dm->update_view($id);
		
		//$data['seo_title'] 	 = !empty($db->post_seo_title) ? $db->post_seo_title : $db->post_title_id;
		//$data['seo_desc'] 	 = !empty($db->post_seo_desc) ? $db->post_seo_desc : $db->post_title_id;
		//$data['seo_keyword'] = !empty($db->post_seo_keyword) ? $db->post_seo_keyword : $db->post_title_id;
		
		/*if(!empty($db->post_img) && file_exists($db->post_img))
			$data['seo_images'] = $db->post_img;
		else
			$data['seo_images'] = 'cdn/default-image-fakultas-informatika-universitas-telkom.jpg';*/
		
		$this->load->view('frontend/tpl', $data);
	}
}
