<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/project.php');

class Publish extends Project {

	public $names = array();
	
	function __construct() {
		parent::__construct();;
		
		redirect("karya_tulis/".$this->uri->segment(2), "refresh");
		
	}
	
	/**
	* ---------======@[ INDEX ]@======--------- 
	*/
	public function index() {
		
	}
	

}