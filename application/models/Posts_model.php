<?php
class Posts_Model extends CI_Model 
{
	
	private $table = 'posts';
	private $id    = 'post_id';
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
	}
	
	// Query for new datatables purpose ;
	//--------------------------------------------------------------------------------------------------------------------------
	function dtquery($param)
	{
		return $this->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM ".$this->table." $param[where] $param[order] $param[limit]");
	}
	
	function dtfiltered()
	{
		$result = $this->db->query('SELECT FOUND_ROWS() as jumlah')->row();
		
		return $result->jumlah;
	}
	
	function dtcount()
	{
		return $this->db->count_all($this->table);
	}
	//--------------------------------------------------------------------------------------------------------------------------
	
	// Query for new datatables purpose ; Time Matrix
	//--------------------------------------------------------------------------------------------------------------------------
	function dtquery_tm($id)
	{
		return $this->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM 
								 posts_timematrix LEFT JOIN ".$this->table." ON pt_b = post_id
								 WHERE pt_a = '$id'
								 ORDER BY post_title_id ASC, pt_hari ASC");
	}
	
	function dtfiltered_tm()
	{
		$result = $this->db->query('SELECT FOUND_ROWS() as jumlah')->row();
		
		return $result->jumlah;
	}
	
	function dtcount_tm($id)
	{
		return $this->db->from('posts_timematrix')->where('pt_a',$id)->count_all_results();
	}
	//--------------------------------------------------------------------------------------------------------------------------
	
	function getall()
	{
		return $this->db->get($this->table);
	}
	
	function getbyquery($param)
	{
		return $this->db->query("SELECT * FROM ".$this->table." $param[where] $param[order] $param[limit]");
	}
	
	function countbyquery($param)
	{
		$result = $this->db->query("SELECT COUNT(".$this->id.") as jumlah FROM ".$this->view." $param[where]")->row();
		
		if(!empty($result))
			return $result->jumlah;
		else
			return 0;
	}
	
	function countall()
	{
		return $this->db->count_all($this->table);
	}
	
	function getby($item)
	{
		$this->db->where($item);
		return $this->db->get($this->table);
	}
	
	function getbyid($id)
	{
		$this->db->where($this->id, $id);
		return $this->db->get($this->table);
	}
	
	function add($item)
	{
		$this->db->insert($this->table, $item);
		return $this->db->insert_id();
	}
	
	function edit($id, $item)
	{
		$this->db->where($this->id, $id);
		$this->db->update($this->table, $item);
	}
	
	function delete($id)
	{
		$this->db->where($this->id, $id);
		$this->db->delete($this->table);
	}
	
	/**		FOR ADDITONAL FUNCTION
			Untuk Menambah function baru silahkan letakkan di bawah ini.
	**/
	
	function getmaxno()
	{
		$this->db->select_max('device_no', 'no');
		return $this->db->get($this->table);
	}
	
	function get_cats($id)
	{
		$this->db->where('pc_id_post', $id);
		return $this->db->get('posts_cat');
	}
	
	function get_tags($id)
	{
		return $this->db->query("SELECT GROUP_CONCAT(tag_name SEPARATOR ',') as tags 
								 FROM posts_tag LEFT JOIN ms_tags ON pt_id_tag = tag_id
								 WHERE pt_id_post = '$id'
								 GROUP BY pt_id_post");
	}
	
	function get_gallery($id)
	{
		$this->db->where('pg_id_post', $id);
		return $this->db->get('posts_gallery');
	}
	
	function add_post_gallery($item)
	{
		$this->db->insert_batch('posts_gallery', $item);
	}
	
	function delete_post_gallery($id)
	{
		$this->db->where('pg_id_post', $id);
		$this->db->delete('posts_gallery');
	}
	
	function get_images($id)
	{
		$this->db->where('pg_id_post', $id);
		return $this->db->get('posts_gallery');
	}
	
	function getby_cat_limit($cat, $limit, $start=0)
	{
		return $this->db->query("SELECT post_id, post_url, post_date, post_views, post_content_id, post_title_id, post_excerpt_id, post_img, cat_id, cat_name, cat_url, post_address
								 FROM posts_cat 
								 LEFT JOIN ".$this->table." ON pc_id_post = post_id
								 LEFT JOIN ms_category ON pc_id_cat = cat_id
								 WHERE pc_id_cat = '$cat'
								 GROUP BY post_id
								 ORDER BY post_date DESC
								 LIMIT $start, $limit");
	}
	
	function getby_type_limit($type, $limit, $start=0)
	{
		return $this->db->query("SELECT post_id, post_url, post_date, post_views, post_content_id, post_title_id, post_excerpt_id, post_img, post_address
								 FROM ".$this->table."
								 WHERE post_type = '$type'
								 GROUP BY post_id
								 ORDER BY post_date DESC
								 LIMIT $start, $limit");
	}
	
	function get_slider()
	{
		return $this->db->query("SELECT post_id, post_url, post_date, post_views, post_content_id, post_title_id, post_excerpt_id, post_img, cat_id, cat_name, cat_url, post_address, post_lat, post_long
								 FROM posts_cat 
								 LEFT JOIN ".$this->table." ON pc_id_post = post_id
								 LEFT JOIN ms_category ON pc_id_cat = cat_id
								 WHERE post_slider = '1'
								 GROUP BY post_id
								 ORDER BY post_date DESC
								 LIMIT 0,5");
	}
	
	function get_popular()
	{
		return $this->db->query("SELECT post_id, post_url, post_date, post_views, post_content_id, post_title_id, post_excerpt_id, post_img, post_address, post_lat, post_long,
									cat_id, cat_name, cat_url
								 FROM ".$this->table."
								 LEFT JOIN posts_cat ON pc_id_post = post_id
								 LEFT JOIN ms_category ON pc_id_cat = cat_id
								 WHERE post_type = 'location'
								 GROUP BY post_id
								 ORDER BY post_score DESC, post_date DESC
								 LIMIT 0,6");
	}	
	
	function get_all_limit($type, $limit, $start=0)
	{
		return $this->db->query("SELECT post_id, post_url, post_date, post_views, post_content_id, post_title_id, post_excerpt_id, post_img, cat_id, cat_name, cat_url, post_address
								 FROM ".$this->table."
								 LEFT JOIN posts_cat ON pc_id_post = post_id
								 LEFT JOIN ms_category ON pc_id_cat = cat_id
								 WHERE post_type = '$type'
								 GROUP BY post_id
								 ORDER BY post_date DESC
								 LIMIT $start, $limit");
	}
	
	function get_all_count($type)
	{
		return $this->db->query("SELECT COUNT(*) as jml FROM ".$this->table." WHERE post_type = '$type'");
	}
	
	function get_destination($cat, $limit, $start=0)
	{
		$where = "WHERE post_type = 'location'";
		if(!empty($cat))
			$where .= " AND pc_id_cat IN ($cat)";
		
		return $this->db->query("SELECT post_id, post_url, post_date, post_views, post_content_id, post_title_id, post_excerpt_id, post_img, post_address, post_rating,
									GROUP_CONCAT(pc_id_cat SEPARATOR ';') as cats
								 FROM posts_cat
								 LEFT JOIN ".$this->table." ON pc_id_post = post_id
								 $where
								 GROUP BY post_id
								 ORDER BY post_date DESC
								 LIMIT $start, $limit");
	}
	
	function get_destination_count($cat)
	{
		$where = "WHERE post_type = 'location'";
		if(!empty($cat))
			$where .= " AND pc_id_cat IN ($cat)";
			
		return $this->db->query("SELECT COUNT(DISTINCT post_id) as jml FROM posts_cat LEFT JOIN ".$this->table." ON pc_id_post = post_id $where");
	}
	
	function update_view($id)
	{
		$this->db->query("UPDATE posts SET post_views = post_views + 1
						  WHERE post_id = '$id'");
	}
	
	function get_hotel()
	{
		return $this->db->query("SELECT * FROM ".$this->table." WHERE post_type = 'hotel' ORDER BY post_title_id ASC");
	}
	
	function get_hotel_id($id)
	{
		return $this->db->query("SELECT * FROM ".$this->table." WHERE post_type = 'hotel' AND post_id = '$id'");
	}
	
	function get_location_in($locations)
	{
		return $this->db->query("SELECT post_id, post_title_id, post_lat, post_long, post_kunjungan_sec
								 FROM ".$this->table." 
								 WHERE post_type = 'location' AND post_id IN ($locations) 
								 ORDER BY post_id ASC");
	}
	
	function delete_timematrix($id)
	{
		return $this->db->query("DELETE FROM posts_timematrix
								 WHERE pt_a = '$id' OR pt_b = '$id'");
	}
	
	function delete_hotel_timematrix($id)
	{
		return $this->db->query("DELETE FROM posts_timematrix_hotel
								 WHERE pth_id_location = '$id'");
	}
	
	function delete_cat($id)
	{
		return $this->db->query("DELETE FROM posts_cat
								 WHERE pc_id_post = '$id'");
	}
}
?>