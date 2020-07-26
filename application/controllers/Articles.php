<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Articles extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Posts_Model', 'dm', TRUE);
		$this->load->model('Ms_Category_Model', '', TRUE);	
	}

	public function index()
	{
		$data['view'] 		= 'frontend/articles/homepage';
				
		$data['last'] 		= $this->dm->getby_type_limit('location',10)->result();
		$data['popular'] 	= $this->dm->get_popular()->result();
		$data['body']		= 'home page-template page homepage global-block-template-1';
		$data['homepage']	= true;
		
		$this->load->view('frontend/tpl', $data);
	}
	
	public function places($page='1')
	{
		$type	= 'location';
		$page	= (int) $page;
		$total 	= $this->dm->get_all_count($type)->row()->jml; 
		$limit 	= 10;
		$start 	= $page > 0 ? $limit * ($page-1) : 0;
		
		$this->load->library('paging');
		$this->paging->items($total);
		$this->paging->limit($limit);
		$this->paging->urlFriendly();
		$this->paging->target(base_url().'places/%');
		$this->paging->currentPage($page);
		$this->paging->adjacents(3);
		
		$db   	 		= $this->dm->get_all_limit($type, $limit, $start)->result();
		
		$data['view']	= 'frontend/articles/category';
		$data['body']	= 'archive category global-block-template-1 td_category_template_2 td_category_top_posts_style_1';
		$data['data']	= $db;
		$data['title']	= 'Destinasi Wisata';
		$data['count']	= $total;
				
		$this->load->view('frontend/tpl', $data);
	}
	
	public function category($id='', $url='', $page='1')
	{
		if(empty($id) || empty($url)) redirect('');
		
		$info = $this->Ms_Category_Model->getbyid($id)->row();
		if(empty($info))
		{
			show_404();
			return false;	
		}
		
		//paging
		$page	= (int) $page;
		$total 	= $info->cat_count; 
		$limit 	= 15;
		$start 	= $page > 0 ? $limit * ($page-1) : 0;
		
		$this->load->library('paging');
		$this->paging->items($total);
		$this->paging->limit($limit);
		$this->paging->urlFriendly();
		$this->paging->target(base_url().'category/'.$info->cat_id.'/'.$info->cat_url.'/%');
		$this->paging->currentPage($page);
		$this->paging->adjacents(3);
		
		$db   	 		= $this->dm->getby_cat_limit($id, $limit, $start)->result();
		
		$data['view']	= 'frontend/articles/category';
		$data['body']	= 'archive category global-block-template-1 td_category_template_2 td_category_top_posts_style_1';
		$data['data']	= $db;
		$data['title']	= 'Kategori '.$info->cat_name;
		$data['count']	= $total;
				
		$this->load->view('frontend/tpl', $data);
	}
	
	function xx()
	{
		//$this->db->query("ALTER TABLE `posts` ADD `post_kunjungan_sec` INT(11) NOT NULL AFTER `post_kunjungan`;");
	}
	
	function x()
	{
		/*$dbs = $this->db->query("SELECT * FROM posts WHERE post_type = 'location'")->result();
		foreach($dbs as $db)
		{
			$str_time = $db->post_kunjungan;

			$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
			
			sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
			
			$time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
				
			$this->db->query("UPDATE posts SET post_kunjungan_sec = '".$time_seconds."' WHERE post_id = '".$db->post_id."'");
		}
		
		$dbs = $this->db->query("SELECT * FROM posts WHERE post_type = 'location'")->result();
		foreach($dbs as $db)
		{
			$seconds = $db->post_kunjungan_sec;
			
			if($seconds > 0)
			{
				$hours = floor($seconds / 3600);
				$mins = floor($seconds / 60 % 60);
				$secs = floor($seconds % 60);
				
				$timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
					
				echo "UPDATE posts SET post_kunjungan = '".$timeFormat."' WHERE post_id = '".$db->post_id."';<br>";
			}
		}*/
		
		/* CAT */
		/*$dbs = $this->db->query("SELECT * FROM posts")->result();
		foreach($dbs as $db)
		{
			$cats = explode(',', trim(str_replace(' ', '', $db->post_c)));
			foreach($cats as $cat)
				echo "INSERT INTO posts_cat VALUES ('','".$db->post_id."','$cat');<br>";
		}*/
		
		/* RECOUNT CAT */
		//UPDATE ms_category SET cat_count = (SELECT COUNT(*) FROM posts_cat WHERE pc_id_cat = cat_id)
		
		/* TAG */
		/*$dbs = $this->db->query("SELECT * FROM posts")->result();
		$tmp = array();
		foreach($dbs as $db)
		{
			$tags = explode(',', trim(str_replace(' ', '', $db->post_t)));
			foreach($tags as $tag)
			{
				if(!empty($tag) && !in_array($tag, $tmp))
				{
					$url = y_urlf($tag);
					echo "INSERT INTO ms_tags VALUES ('','$url','$tag','');<br>";
					$tmp[] = $tag;
				}
			}
			
			$tags = explode(',', trim(str_replace(' ', '', $db->post_t)));
			foreach($tags as $tag)
				echo "INSERT INTO posts_tag VALUES ('','".$db->post_id."','$tag');<br>";
		}*/
		
		/* URL */	
		/*$dbs = $this->db->query("SELECT * FROM posts")->result();
		foreach($dbs as $db)
		{
			$url = y_urlf($db->post_title_id);
			echo "UPDATE posts SET post_url = '$url' WHERE post_id = ".$db->post_id.";<br>";
		}*/
	}
}
