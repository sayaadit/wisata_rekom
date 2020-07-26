<?php
class Media_Model extends CI_Model 
{
	
	private $table = 'media';
	private $id    = 'media_id';
	
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
	
	function check_url($url)
	{
		return $this->db->query("SELECT COUNT(*) as jml FROM ".$this->table." WHERE media_url LIKE '$url%'");
	}
	
	function get_media_page($page)
	{
		$limit = 40;
		$start = ($page-1)*$limit;
		
		return $this->db->query("SELECT SQL_CALC_FOUND_ROWS * FROM ".$this->table." LIMIT $start, ".($limit-1));
	}
	
	function get_media_count()
	{
		return $this->db->query("SELECT FOUND_ROWS() as jumlah");
	}
	
	function get_media_page2($page, $limit)
	{
		$start = ($page-1)*$limit;
		
		return $this->db->query("SELECT * FROM ".$this->table." LIMIT $start, ".($limit-1));
	}
}
?>