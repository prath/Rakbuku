<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faqs extends CI_Controller {
	 
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
			'title' => 'F.A.Q',
			'menus' => array(
				'daftar_faq' => 'F.A.Qs',
				'tambah_faq' => 'Add F.A.Q'
			),
		);
		$this->load->view('admin/faqs/faqs', $this->data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */