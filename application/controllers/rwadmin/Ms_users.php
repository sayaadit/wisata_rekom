<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ms_users extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('Ms_Users_Model', 'dm', TRUE);
		$this->load->model('Common_Model', 'cm', TRUE);
		
		if (!$this->session->userdata('login')) redirect('login');		
	}
	
	public function index()
	{
		$data['view'] 	= 'ms_users/index';
		$data['title']	= 'Master Data Pengguna Aplikasi';		
		$data['icon']	= 'fa-users';
		
		$data['level'] = $this->cm->form_userlevel();
		
		$this->load->view('tpl', $data);
	}
	
	public function json()
	{
		if(!$this->input->is_ajax_request()) return false;
		
		$columns = array(
			array( 'db' => 'user_fullname',	'dt' => 0 ),
			array( 'db' => 'user_name',	'dt' => 1 )
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
				$row->user_fullname,
				$row->user_name,
				$this->cm->get('form_userlevel', $row->user_level),
				'<button onclick="edit('.$row->user_id.')" class="btn btn-xs btn-flat btn-primary" title="Edit Data"><i class="fa fa-edit"></i></button>
				<button type="button" onclick="del(\''.$row->user_id.'\')" class="btn btn-xs btn-flat bg-maroon" title="Hapus Data"><i class="fa fa-trash"></i></button>'
			);
			
			$output['data'][] = $rows;
		}
		
		echo json_encode( $output );
	}
	
	public function insert()
	{
		if(!$this->input->is_ajax_request()) return false;
		if(!$this->input->post('inp')) return false;
		
		$item = $this->input->post('inp');
		$item['user_password'] = substr(sha1(md5(md5($item['user_password']))), 0, 50);
		
		$this->dm->add($item);
		echo 'ok;';
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
		
		if(!empty($item['user_password']))
			$item['user_password'] = substr(sha1(md5(md5($item['user_password']))), 0, 50);
		
		$this->dm->edit($id, $item);
		echo 'ok;';
	}
	
	public function delete()
	{
		if(!$this->input->is_ajax_request()) return false;
		if(!$this->input->post('id')) return false;
		
		$id = $this->input->post('id');
		
		$this->dm->delete($id);
	}
	
	/**		FOR ADDITONAL FUNCTION
			Untuk Menambah function baru silahkan letakkan di bawah ini.
	**/
}

?>