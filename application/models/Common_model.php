<?php
class Common_Model extends CI_Model {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
	}
	
	function form_post()
	{
		$array['location'] 	= 'Destinasi Wisata';
		$array['hotel']		= 'Hotel';
		
		return $array;
	}
	
	function form_algorithm()
	{
		$array['dashboard'] = 'Algoritma Kunang-Kunang';
		$array['sa']		= 'Algoritma Simulated Annealing';
		$array['ant']		= 'Algoritma Ant Colony';
		$array['lbsa']		= 'Algoritma List-Based Simulayed Annealing';
		
		return $array;
	}
	
	function get($fn, $id)
	{
		$array = $this->$fn();
		
		if(isset($array[$id]) && !empty($id)) return $array[$id];
		else return '';
	}
	
	function add_logs($mod, $act, $id)
	{
		$ci = get_instance();
		$ci->load->helper('ycode');
		
		$user = y_info_login();
		
		$this->db->query("INSERT INTO logs VALUES ('', NOW(), '$mod', '$act', '$id', '".$user->user_id."')");
	}
}
?>