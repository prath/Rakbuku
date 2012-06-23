<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helps extends CI_Controller {
	 
	public $data;

	function __construct() {
		parent::__construct();
	}
	
	public function index()
	{
		/*
		* tentukan menu-menu sidebar ke dalam array $this->data['menu']
		*/
		$this->data['menu'] = array(
			'title' => 'Help',
			'menus' => array(
				'daftar_help' => 'Help',
				'tambah_help' => 'Add Help Content',
			),
		);
		$this->load->view('admin/helps/helps', $this->data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */