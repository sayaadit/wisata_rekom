<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('Ms_Users_Model', 'dm', TRUE);
	}
	
	public function index()
	{
		$this->load->view('backend/login');
	}
	
	public function exe()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$pass 	  = substr(sha1(md5(md5($password))), 0, 50);
		
		$db = $this->dm->getlogin($username, $pass)->row();
		
		if (!empty($db)) 
		{ 
			$data = array('login' => TRUE, 'info_login' => $db, 'level_login' => $db->user_level);
			
			$this->session->set_userdata($data);
			
			redirect(y_url_admin());
		} 
		else 
		{
			$this->session->set_flashdata('errlog', true);
			redirect(y_url_admin().'/login');
		}
	}
	
	function logout()
	{
		$this->session->sess_destroy();
		redirect(y_url_admin().'/login');	
	}
	
	/**		FOR ADDITONAL FUNCTION
			Untuk Menambah function baru silahkan letakkan di bawah ini.
	**/
}

?>