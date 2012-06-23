<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/project.php');

class Karya_tulis extends Project {

	public $names = array();
	
	function __construct() {
		parent::__construct();
		$this->data['types'] =  $this->types->get_types();
		$this->data['title'] = 'Invite Reviewer'; 
		$this->data["users"] = $this->user->get_users();
		
		$url = $this->uri->segment(2);
		$this->get_project_data($url);
		$this->laststate = $this->cek_state($this->dataproj[0]["project_id"]);
		$match = array_search($this->laststate, $this->defstates);
		
		$this->data["site_settings"] = $this->site_settings_model->get_site_settings();
		
		if( $this->laststate !== "publish" && $match !== false ){
			$this->redirect_to_state_url($this->laststate, $url);
		}
	}
	//print_r($this->names);
	
	/**
	* ---------======@[ INDEX ]@======--------- 
	*/
	public function index() {
		
		//$this->load->view("project/invite_reviewer", $this->data);
	}
	
	public function _remap($judul) {
		$this->get_allproject_data($judul);
		if( is_array($this->data["project_data"]) ) {
			$this->load->view("published/karya_tulis", $this->data);
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
	
	
	public function get_allproject_data($judul) {
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
		}
		
		$par = array(
			"type_id" =>  $this->data["project_data"][0]["type_id"]
		);
		$this->data["type_name"] = $this->types->get_types($par);
		
		$usr = array(
			"rb_user" => array(
				"user_id" =>  $this->data["project_data"][0]["user_id"]
			)
		);
		$this->data["author"] = $this->user->get_users($usr);
		$this->data["author_name"] = get_user_name($this->data["author"]);
		$this->data["author_url"] = get_user_url( $this->data["author"] );
		$this->data["reviewers"] = unserialize( $this->data["project_data"][0]["project_reviewer"]);
		
		////
		$par = array(
			"rb_projects" => array(
				"project_parent" =>  $this->data["project_data"][0]["project_id"]
			)
		);
		$this->data["project_chapters"] = $this->projects_model->get_projects($par);
		if( !empty($this->data["project_chapters"]) ) {
			foreach( $this->data["project_chapters"] as $k => $v ) {
				$ver = array(
					"rb_versions" => array(
						"project_id" =>  $v["project_id"]
					)
				);
				$this->data["versionsmax"][$k] = $this->versions->get_versions($ver, "", NULL, NULL, 'MAX(version_number) as finalversion');
			}
		}
		
		if( !empty($this->data["versionsmax"]) ){
			foreach($this->data["versionsmax"] as $k => $v) {
			
				$ver2 = array(
					"rb_versions" => array(
						"version_number" =>  $v[0]["finalversion"],
						"project_id" =>  $this->data["project_chapters"][$k]["project_id"]
					)
				);
				$this->data["versions"][$k] = $this->versions->get_versions($ver2);
			}
		}
		
		if( !empty($this->data["versions"]) ){
			foreach($this->data["versions"] as $k => $v) {
			
				$attver = array(
					"rb_attachment_versions" => array(
						"version_id" =>  $v[0]["version_id"]
					)
				);
				$this->data["att_vers"][$k] = $this->attach->get_attachment_version($attver);
			}
		}
		
		if( !empty($this->data["att_vers"]) ){
			foreach($this->data["att_vers"] as $k => $v) {
			
				$att = array(
					"rb_attachment" => array(
						"attachment_id" =>  $v[0]["attachment_id"]
					)
				);
				$this->data["attachments"][$k] = $this->attach->get_attachments($att);
			}
		}
		
		
		
	}
	//buat fungsi untuk retrieve semua data si project berikut attachment. 

}