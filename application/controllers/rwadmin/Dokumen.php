<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dokumen extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('Dokumen_Model', 'dm', TRUE);
		$this->load->model('Common_Model', 'cm', TRUE);
		
		if (!$this->session->userdata('login')) redirect(y_url_admin().'/login');	
	}
	
	public function index()
	{
		$data['view'] 	= 'backend/dokumen/index';
		$data['title']	= 'Dokumen';		
		$data['icon']	= 'icon-file-text';		
		$data['add']	= true;
		
		$this->load->view('backend/tpl', $data);
	}
	
	public function json()
	{
		if(!$this->input->is_ajax_request()) return false;
		
		$columns = array(
			array( 'db' => 'dok_title', 'dt' => 0 ),
			array( 'db' => 'dok_desc', 'dt' => 1 )
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
				$row->dok_title,
				$row->dok_desc,
				$row->dok_file,
				'<a href="javascript:edit('.$row->dok_id.')" title="Edit Data"><span class="label label-primary label-table"><i class="fa fa-edit"></i> Edit</span></a>
				<a href="javascript:del('.$row->dok_id.')" title="Delete Data"><span class="label label-danger label-table"><i class="fa fa-trash"></i> Hapus</span></a>'
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
		
		if (!empty($_FILES['file']['name'])) 
		{	
			$ext	= pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			$name	= str_replace('.'.$ext, '', $_FILES['file']['name']);
			$url  	= y_urlf($name);
			
			$new_name 		= $url.'.'.$ext; 
			$target_file 	= 'cdn/docs/'.$new_name;
			
			$config['file_name']	= $url;
			$config['upload_path']	= 'cdn/docs/';
			$config['allowed_types']= 'pdf|xls|xlsx|doc|docx|ppt|pptx|txt|zip|rar';
			$config['overwrite']	= true;

			$this->load->library('upload', $config);

			if ( $this->upload->do_upload('file') )
			{
				$ud = $this->upload->data();
				$item['dok_file'] = $ud['file_name'];
			}
			else
			{
				$return = array('status' => false,
								'error' => $this->upload->display_errors());
				echo json_encode($return);
				return false;	
			}
		}
			
		
		$this->dm->add($item);
		
		echo json_encode(array('status' => true));
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
		
		if (!empty($_FILES['file']['name'])) 
		{	
			$ext	= pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			$name	= str_replace('.'.$ext, '', $_FILES['file']['name']);
			$url  	= y_urlf($name);
			
			$new_name 		= $url.'.'.$ext; 
			$target_file 	= 'cdn/docs/'.$new_name;
			
			$config['file_name']	= $url;
			$config['upload_path']	= 'cdn/docs/';
			$config['allowed_types']= 'pdf|xls|xlsx|doc|docx|ppt|pptx|txt|zip|rar';
			$config['overwrite']	= true;

			$this->load->library('upload', $config);

			if ( $this->upload->do_upload('file') )
			{
				$ud = $this->upload->data();
				$item['dok_file'] = $ud['file_name'];
			}
			else
			{
				$return = array('status' => false,
								'error' => $this->upload->display_errors());
				echo json_encode($return);
				return false;	
			}
		}
		
		$this->dm->edit($id, $item);
		echo json_encode(array('status' => true));
	}
	
	public function delete()
	{
		if(!$this->input->is_ajax_request()) return false;
		if(!$this->input->post('id')) return false;
		
		$id = $this->input->post('id');
		$db	= $this->dm->getbyid($id)->row();
		
		if(!empty($db))
		{
			unlink(FCPATH.'cdn/docs/'.$db->dok_file);
			$this->dm->delete($db->dok_id);
		}
		
		echo 'ok;';
	}
	
	/**		FOR ADDITONAL FUNCTION
			Untuk Menambah function baru silahkan letakkan di bawah ini.
	**/
}

?>