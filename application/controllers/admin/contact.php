<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {
	 
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
			'title' => 'Contact',
			'menus' => array(
				'manage_contact' => 'Manage Contact Info',
				'manage_emails' => 'Manage Contact Emails',
			),
		);
		$this->load->view('admin/contact/contact', $this->data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */