<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ms_Category extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('Ms_Category_Model', 'dm', TRUE);
		$this->load->model('Common_Model', 'cm', TRUE);
		
		if (!$this->session->userdata('login')) redirect(y_url_admin().'/login');	
	}
	
	public function index()
	{
		$data['view'] 	= 'backend/ms_category/index';
		$data['title']	= 'Master Data Kategori';		
		$data['icon']	= 'icon-price-tags2';		
		$data['add']	= true;
		
		$this->load->helper('form');
		
		$this->load->view('backend/tpl', $data);
	}
	
	public function json()
	{
		if(!$this->input->is_ajax_request()) return false;
		
		$columns = array(
			array( 'db' => 'cat_name', 'dt' => 0 )
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
				$row->cat_name,
				'<a href="javascript:edit('.$row->cat_id.')" title="Edit Data"><span class="label label-primary label-table"><i class="fa fa-edit"></i> Edit</span></a>
				<a href="javascript:del('.$row->cat_id.', \''.$row->cat_name.'\')" title="Delete Data"><span class="label label-danger label-table"><i class="fa fa-trash"></i> Hapus</span></a>',
				$row->cat_id
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
		$item['cat_url'] = y_urlf($item['cat_name']);
		
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
		$item['cat_url'] = y_urlf($item['cat_name']);
		
		$this->dm->edit($id, $item);
		echo 'ok;';
	}
	
	public function delete()
	{
		if(!$this->input->is_ajax_request()) return false;
		if(!$this->input->post('id')) return false;
		
		$id = $this->input->post('id');
		$substitute = $this->input->post('substitute');
		
		$this->dm->substitute($id, $substitute);
		$this->dm->delete($id);
		
		echo 'ok;';
	}
	
	/**		FOR ADDITONAL FUNCTION
			Untuk Menambah function baru silahkan letakkan di bawah ini.
	**/
}

?>