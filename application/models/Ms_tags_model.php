<?php
class Ms_Tags_Model extends CI_Model 
{
	
	private $table = 'ms_tags';
	private $id    = 'tag_id';
	
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
		$this->db->order_by('tag_name', 'asc');
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
	
	function getbytags($param)
	{
		return $this->db->query("SELECT * FROM ".$this->table." WHERE tag_name IN ($param)");
	}
	
	function getbyq($param)
	{
		return $this->db->query("SELECT * FROM ".$this->table." WHERE tag_name LIKE '%$param%'");
	}
	
	function recount_tags()
	{
		return $this->db->query("UPDATE ".$this->table." 
								 SET tag_count = (SELECT COUNT(*) FROM posts_tag WHERE pt_id_tag = tag_id)");
	}
	
	function add_post_tag($item)
	{
		$this->db->insert('posts_tag', $item);
		return $this->db->insert_id();
	}
	
	function delete_post_tag($id)
	{
		$this->db->where('pt_id_post', $id);
		$this->db->delete('posts_tag');
	}
	
	function get_tag_bypost($id)
	{
		return $this->db->query("SELECT * FROM posts_tag 
								 LEFT JOIN ms_tags ON pt_id_tag = tag_id
								 WHERE pt_id_post = '$id'");
	}
}
?>