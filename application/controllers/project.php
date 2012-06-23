<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/base.php');

class Project extends Base {

	public $data = array();
	public $project_fw = array();
	public $rules = array();
	public $html = '';
	public $nexturl;
	public $laststate;
	public $projid;
	public $dataproj = array();
	public $defstates = array("upload_doc", "invite_reviewer", "review", "admin_review", "publish");
	 
	function __construct() {
		parent::__construct();
		$this->load->model('attachments_model', 'attach');
		$this->load->model('reviewers_model', 'reviewer');
		$this->data['login'] = $this->session->userdata('logged_in');
		$this->data['current_user'] = $this->session->userdata('current_user');
		$this->data['current_user_id'] = $this->session->userdata('user_id');
		$this->data['jur_id_user'] = $this->session->userdata('jur_id');
		$this->data['role_name'] = $this->session->userdata('role_name');
		$this->data["topics"] = $this->topics->get_topics();
		
		$url = $this->uri->segment(2);
		$this->get_project_data($url);
		
		$this->laststate = $this->cek_state($this->dataproj[0]["project_id"]);
		
	}
	
	public function index() {
		echo $url = $this->uri->segment(2);
		$this->laststate = $this->cek_state($this->dataproj[0]["project_id"]);
		$match = array_search($this->laststate, $this->defstates);
		if( $this->laststate !== "review" && $match ){
			$this->redirect_to_state_url($this->laststate, $url);
		}
	}
	
	/**
	* ---------======@[ SET DESTINATION ]@======--------- 
	* 
	* inti dari route step.
	*/
	protected function set_destination($type, $prevstate_process) {
		$par = array(
			"rb_projects_fw" => array(
				"type_id" => $type
			)
		);
		
		$this->data["fw"] = $this->projects_model->get_projects_fw($par);
		$this->project_fw = unserialize($this->data["fw"][0]["fw"]);
		$prevstate = array_search( $prevstate_process, $this->project_fw );
		$currentstate = $prevstate+1;
		if( !empty($this->project_fw[$currentstate]) ) {
			$this->data["state"] = $this->project_fw[$currentstate];
			$this->data["currenturl"] = $this->get_next_url( $this->data["state"] );
		}
		error_reporting(0);
		if($currentstate < 5) {
			$nextstate = $currentstate+1;
			$this->data["nextstate"] = $this->project_fw[$nextstate];
			$this->data["nexturl"] = $this->get_next_url( $this->data["nextstate"] );
		}
		
	}
	
	/**
	* ---------======@[ GET NEXT URL ]@======--------- 
	*/
	protected function get_next_url( $state ) {
		switch ($state) {
			case "pilih project" :
				break;
			case "isi form project baru" :
				$this->nexturl =  "upload_doc";
				break;
			case "undang reviewer/collaborator" :
				$this->nexturl =  "invite_reviewer";
				break;
			case "review/collaboration" :
				$this->nexturl =  "review";
				break;
			case "admin review" :
				$this->nexturl =  "admin_review";
				break;
			case "publikasikan project" :
				$this->nexturl =  "publish";
				break;
		}
		return $this->nexturl;
	}
	
	/**
	* ---------======@[ CEK CURRENT/RECORDED STATE ]@======--------- 
	*/
	protected function cek_state($projid) {
		$par = array(
			"rb_projects_state" => array(
				"project_id" => $projid
			)
		);
		$state = $this->projects_model->get_projects_state($par); 
		return $lasturl = $this->get_next_url($state[0]["project_state"]);
	}
	
	protected function redirect_to_state($state) {
		redirect("project/".$state, "refresh");
	}
	
	protected function redirect_to_state_url($state, $url) {
		if($state == "publish") {
			$st = "karya_tulis";
		} else {
			$st = $state;
		}
		redirect($st.'/'.$url, "refresh");
	}
	
	/**
	* ---------======@[ CEK PREV STATE ]@======--------- 
	*/
	protected function prev_state($type, $state_process) {
		$par = array(
			"rb_projects_fw" => array(
				"type_id" => $type
			)
		);
		
		$fw = $this->projects_model->get_projects_fw($par);
		$this->project_fw = unserialize($fw[0]["fw"]);
		$prevstate = array_search( $state_process, $this->project_fw );
		return $this->project_fw[$prevstate-1];
	}
	
	/**
	* ---------======@[ GET PROJECT DATA ]@======--------- 
	*/
	
	public function get_project_data($url){

		$par = array(
			"rb_projects" => array(
				"project_url" => $url
			)
		);
		
		$this->dataproj = $this->projects_model->get_projects($par);
				
	}
	
	public function select_jur() {
		$jurusan = $this->input->post("jurusan");
		
		$parjur = array(
			"rb_jurusan" => array(
				"jur_name" => $jurusan			
			)
		);
		
		$datajur = $this->jurusan->get_jurusan($parjur);
		$return["fakultas"] = $datajur[0]["fak_name"];
		
		echo json_encode($return);
		
	}
	
	
}