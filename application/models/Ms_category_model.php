<?php
class Ms_Category_Model extends CI_Model 
{
	
	private $table = 'ms_category';
	private $id    = 'cat_id';
	
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
	
	function getall()
	{
		$this->db->order_by('cat_name', 'asc');
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
	
	function substitute($id, $substitute)
	{
		return $this->db->query("UPDATE posts_cat SET pc_id_cat = '$substitute' WHERE pc_id_cat = '$id'");
	}
	
	function add_post_cat($item)
	{
		$this->db->insert_batch('posts_cat', $item);
	}
	
	function delete_post_cat($id)
	{
		$this->db->where('pc_id_post', $id);
		$this->db->delete('posts_cat');	
	}
	
	function recount_cats()
	{
		return $this->db->query("UPDATE ".$this->table." 
								 SET cat_count = (SELECT COUNT(*) FROM posts_cat WHERE pc_id_cat = cat_id)");
	}
	
	function get_cat_bypost($id)
	{
		return $this->db->query("SELECT * FROM posts_cat 
								 LEFT JOIN ms_category ON pc_id_cat = cat_id
								 WHERE pc_id_post = '$id'
								 ORDER BY cat_count DESC");
	}
}
?>