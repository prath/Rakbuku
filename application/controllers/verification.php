<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/project.php');

class Verification extends Project {

	public $names = array();
	
	function __construct() {
		parent::__construct();
		$this->data['types'] =  $this->types->get_types();
		$this->data['title'] = 'Invite Reviewer'; 
		$this->data["users"] = $this->user->get_users();
		
		$url = $this->uri->segment(2);
		$this->get_project_data($url);
		$this->laststate = $this->cek_state($this->dataproj[0]["project_id"]);
		if( $this->laststate !== "verification" ){
			$this->redirect_to_state_url($this->laststate, $url);
		}
	}
	//print_r($this->names);
	
	/**
	* ---------======@[ INDEX ]@======--------- 
	*/
	public function index() {
		if( !is_login($this->data['login']) || ( $this->input->post("project_state") == "" && ($this->laststate != $this->uri->segment( 1 )) ) ){
			show_404();
		}
		//$this->load->view("project/invite_reviewer", $this->data);
	}
	
	public function _remap($judul) {
		if( !is_login( $this->data['login'] ) ){
			show_404();
		}
		
		$par = array(
			"rb_projects" => array(
				"project_url" =>  $judul
			)
		);
		$this->data["project_data"] = $this->projects_model->get_projects($par);
		if( $this->data["project_data"] ) {
			$state = array(
				"rb_projects_state" => array(
					"project_id" =>  $this->data["project_data"][0]["project_id"]
				)
			);
			$this->data["state"] = $this->projects_model->get_projects_state($state);
			$prevstate_process = $this->data["state"][0]["project_state"];
			$this->data["type"] = $this->data["project_data"][0]["type_id"];
		
			$this->set_destination($this->data["type"], $prevstate_process);
		}
		
		if( is_array($this->data["project_data"]) ) {
			$this->load->view("project/verification", $this->data);
		} else {
			$method = str_replace(" ", "_", $judul);
			if( method_exists($this, $method) ) {
				call_user_func_array( array( $this,$method ), array());
			} else {
				if( $judul == "" ){
					call_user_func_array( array( $this,"index" ), array());	
				}
			}
		}
		
	}

}