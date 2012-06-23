<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base extends CI_Controller {
	public $data = array();
	
	function __construct() {
		parent::__construct();
		$this->data['current_role'] = $this->session->userdata('role_name');
		$this->data["project_types"] = $this->types->get_types();
	}
	
	public function index()
	{
		//$this->load->view('home');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */