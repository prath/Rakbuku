<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/project.php');

class Admin_review extends Project {

	public $names = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('reviews_model', 'review');
		$this->data['types'] =  $this->types->get_types();
		$this->data['title'] = 'Invite Reviewer'; 
		$this->data["users"] = $this->user->get_users();
		$this->data["jurusan"] = $this->jurusan->get_jurusan();
		
		$url = $this->uri->segment(2);
		$this->get_project_data($url);
		$this->laststate = $this->cek_state($this->dataproj[0]["project_id"]);
		$match = array_search($this->laststate, $this->defstates);
		if( $this->laststate !== "admin_review" && $match !== false ){
			$this->redirect_to_state_url($this->laststate, $url);
		}
		
		
		$this->data["self_project"] = is_self_project( $this->dataproj[0]["user_id"], $this->data['current_user_id'] );
		
		$par = array(
			"rb_role" => array(
				"role_name" => "admin"
			)	
		);
		
		$admins = $this->user_model->get_users_w_roles($par, '', NULL, NULL, "rb_user.user_id");
		$admin_review_ids = array();
		foreach( $admins as $k => $v ) {
			array_push($admin_review_ids, $v["user_id"]);
		};
		
		$this->data["is_admin"] = is_admin($this->data['role_name']);
		
		if( !is_in_admin_review( $this->dataproj[0]["user_id"], $admin_review_ids, $this->data['current_user_id']) ) {
			show_404();
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
	
	public function _remap($judul, $act) {
		if( !is_login( $this->data['login'] ) ){
			show_404();
		}
		
		$par = array(
			"rb_projects" => array(
				"project_url" =>  $judul
			)
		);
		$this->data["project_data"] = $this->projects_model->get_projects($par);
		if(!empty($act)){
			$method = str_replace(" ", "_", $act[0]);
			if( method_exists($this, $method) ) {
				call_user_func_array( array( $this,$method ), array());
			} else {
				if( $judul == "" ){
					call_user_func_array( array( $this,"index" ), array());	
				}
			}
		} else {
		
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
				$this->get_type($this->data["project_data"][0]["type_id"]);
				$usr = array(
					"rb_user" => array(
						"user_id" =>  $this->data["project_data"][0]["user_id"]
					)
				);
				$this->data["author"] = $this->user->get_users($usr);
				$this->data["author_name"] = get_user_name($this->data["author"]);
				$this->data["author_url"] = get_user_url( $this->data["author"] );
				$this->get_reviewers( $this->data["project_data"][0]["project_reviewer"] );
				$this->get_chapters_file( $this->data["project_data"][0]["project_id"] );
				$this->get_reviews( $this->data["project_data"][0]["project_id"] );
				//$this->get_chapters_file()
				
				$this->load->view("project/admin_review", $this->data);
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
	
	public function send_comment(){
		
		 
		$datestring = "%Y-%m-%d %h:%i:%s";
		$time = time();
		$review_date = mdate($datestring, $time);
		
		//print_r($this->input->post());
		$par = array(
			"user_id" => $this->input->post("userid"),
			"admin_review_date" => $review_date,
			"admin_review_content" => $this->input->post("comment_content"),
			"project_id" => $this->input->post("projid"),
		);
		$sendreview = $this->review->add_admin_review($par);
		
		if( $sendreview ) {
			redirect("admin_review/".$this->input->post("projurl"), "refresh");
		}
		
	}
	
	
	
	/**
	* ---------======@[ GET REVIEWS ]@======--------- 
	*/
	private function get_reviews($projid){
		
		$par = array(
			"rb_admin_review" => array(
				"project_id" =>  $projid
			)
		);
		$this->data["admin_reviews"] = $this->review->get_admin_reviews($par);
		
		
		if( isset($this->data["admin_reviews"]) ){
			foreach($this->data["admin_reviews"] as $k => $v) {
				$par2 = array(
					"rb_user" => array(
						"user_id" =>  $v["user_id"]
					)
				);
				$this->data["commentor"][$k] = $this->user_model->get_users($par2);
				
				$name = get_user_name($this->data["commentor"][$k]);
				$this->data["commentor"][$k][0]["fullname"] = $name;
				
				if( isset($this->data["project_parent"][0]["project_id"]) && $this->data["project_parent"][0]["project_id"]){
					$projid = $this->data["project_parent"][0]["project_id"];
				}
				
				
			}
		}
	}
	
	public function get_type($projid) {
		$par = array(
			"type_id" =>  $projid
		);
		$this->data["types"] = $this->types->get_types($par);
	}
	
	/**
	* ---------======@[ GET REWIEWER ]@======--------- 
	*/
	private function get_reviewers($reviewers){
		
		$this->data["reviewers"] = $unseri = unserialize($reviewers);
		
	}
	
	/**
	* ---------======@[ GET CHAPTERS ]@======--------- 
	*/
	private function get_chapters($parent){
		
		$par = array(
			"rb_projects" => array(
				"project_parent" =>  $parent
			)
		);
		$this->data["project_chapters"] = $this->projects_model->get_projects($par);
		
	}
	
	/**
	* ---------======@[ GET CHAPTERS FILE ]@======--------- 
	*/
	private function get_chapters_file($parent){
		
		$par = array(
			"rb_projects" => array(
				"project_parent" =>  $parent
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
	
	/**
	* ---------======@[ publish form ]@======--------- 
	*/
	public function publish_project(){
		if (!$this->data["is_admin"]) {
			show_404();
		}
		$state = array(
			"rb_projects_state" => array(
				"project_id" =>  $this->data["project_data"][0]["project_id"]
			)
		);
		$this->data["state"] = $this->projects_model->get_projects_state($state);
		$prevstate_process = $this->data["state"][0]["project_state"];
		$this->data["type"] = $this->data["project_data"][0]["type_id"];
		$this->set_destination($this->data["type"], $prevstate_process);
		$this->load->view("project/publish_project_admin", $this->data);
	}
	
	/**
	* ---------======@[ go_publish ]@======--------- 
	*/
	public function go_publish(){
		
		//print_r($this->input->post());
		$parstate = array(
			"project_state" => $this->input->post( "project_state" ),
			"project_state_next_state" => NULL,
			"project_state_next_url" => NULL
		);
		$clausestate = array(
			"project_id" => $this->input->post( "project_id" )
		);
		
		$update_project_state = $this->projects_model->update_project_state($parstate, $clausestate);
		
		$upd_project = array(
			"project_status" => "publish"
		);
		$clause = array(
			"project_id" => $this->input->post("project_id")
		);
		$update_project = $this->projects_model->update_project($upd_project, $clause);
		
		redirect('karya_tulis/'.$this->input->post( "project_url" ), "refresh");
		
	}
	
	/**
	* ---------======@[ UPLOAD ]@======--------- 
	*/
	public function upload_other(){
		if (!$this->data["self_project"]) {
			show_404();
		}
		$this->get_chapters_file( $this->data["project_data"][0]["project_id"] );
		$this->load->view("project/form_upload_admin", $this->data);
	}
	
	public function save_upload(){
		if (!$this->data["self_project"]) {
			show_404();
		}
		$project_chaps_id = $this->input->post("project_chapter_id");
		$project_id = $this->input->post("project_id");
		
		
		print_r($project_chaps_id);
		
		$arrcountatt = 0;
		$file = 0;
		foreach( $_FILES as $k => $v ) {
			if($v["name"] !== "") {
				$file++;
			
				if ( $this->upload->do_upload( $k ) ) {
					$chapid = $this->input->post("project_chapter_id_".$k);
					
					$dataup = array('upload_data' => $this->upload->data());
					
					$parget = array(
						"rb_projects" => array(
							"project_id" => $chapid
						)
					);
					$get_project = $this->projects_model->get_projects($parget);
					
					
					
					$data_project = array(
						"project_attachment_count" => $get_project[0]["project_attachment_count"]+1
					);
					$clause = array(
						"project_id" => $chapid
					);
					$update_project = $this->projects_model->update_project($data_project, $clause);
					
					
					
					
					$parparent = array(
						"rb_projects" => array(
							"project_id" =>  $project_id
						)
					);
					$get_project2 = $this->projects_model->get_projects($parparent);
					
					$data_project2 = array(
						"project_attachment_count" => $get_project2[0]["project_attachment_count"]+1
					);
					$clause2 = array(
						"project_id" => $project_id
					);
					$update_project2 = $this->projects_model->update_project($data_project2, $clause2);
					
					
					
					
					$getver = array(
						"rb_versions" => array(
							"project_id" => $chapid
						)
					);
					$get_max = $this->versions->get_versions($getver, '', NULL, NULL, "MAX(version_number) as last_ver");
					
					
					$ver = array(
						"version_id" => NULL,
						"version_number" => $get_max[0]["last_ver"]+1,
						"project_id" => $chapid
					);
					$insert_version = $this->versions->add_new_version($ver);
					
					if( isset($insert_version) && $insert_version ) {
						$att = array(
							"attachment_id" => NULL,
							"attachment_url" => $dataup["upload_data"]["file_name"],
							"attachment_file" => $dataup["upload_data"]["file_name"],
							"attachment_file_ext" => $dataup["upload_data"]["file_ext"],
							"attachment_file_path" => $dataup["upload_data"]["full_path"]
						);
						$insert_attachment = $this->attach->add_new_attachment($att);
						
						// insert data ke table rb_attachment_versions, data : attachment_id, version_id
						if( isset($insert_attachment) && $insert_attachment ){
							$attachvers = array(
								"attachment_id" => $insert_attachment,
								"version_id" => $insert_version
							);
							$insert_attachvers = $this->attach->add_new_attachment_version($attachvers);
						}
					}
					
					
					$arrcountatt++;
				}
			}
		}
		
		redirect($this->input->post("project_url"));	
					
	}
	
	public function go_back_edit() {
		if (!$this->data["self_project"]) {
			show_404();
		}
		$this->get_type($this->data["project_data"][0]["type_id"]);
		$usr = array(
			"rb_user" => array(
				"user_id" =>  $this->data["project_data"][0]["user_id"]
			)
		);
		$this->data["author"] = $this->user->get_users($usr);
		$this->data["author_name"] = get_user_name($this->data["author"]);
		$this->data["author_url"] = get_user_url( $this->data["author"] );
		$this->get_reviewers( $this->data["project_data"][0]["project_reviewer"] );
		$this->get_chapters_file( $this->data["project_data"][0]["project_id"] );
		$this->get_reviews( $this->data["project_data"][0]["project_id"] );
				
		$this->load->view("project/form_edit_admin", $this->data);
	}
	
	/**
	* ---------======@[ SAVE EDIT PROJECT ]@======--------- 
	*/
	public function save_edit(){
		
		
		$datestring = "%Y-%m-%d %H:%i:%s";
		$time = time();			
		$now =  mdate($datestring, $time);
		
		$exp = explode( "|", $this->input->post("project_reviewer") );
		$reviewer = serialize($exp);
		
		$url = spliturl($this->input->post("project_title"), 50);
		
		$project_keywords_temp = $this->input->post( "project_keywords" );
		$project_keywords_exp = explode( ',', $project_keywords_temp );
		$project_keywordstrim = array();
		foreach( $project_keywords_exp as $k => $v ) {
			array_push($project_keywordstrim, trim($v));
		}
		$project_keywords = serialize($project_keywordstrim);
		
		$data_project = array(
			"project_title" => $this->input->post("project_title"),
			"project_content" => $this->input->post("project_content"),
			"project_year" => $this->input->post("project_year"),
			"project_author" => $this->input->post("project_author"),
			"project_reviewer" => $reviewer,
			"project_jurusan" => $this->input->post("project_jurusan"),
			"project_fakultas" => $this->input->post("project_fakultas"),
			"project_strata" => $this->input->post("project_strata"),
			"project_keywords" => $project_keywords,
			"project_link" => $this->input->post("project_link")
/* 			"project_url" => $url, */
		);
		$clause = array(
			"project_id" => $this->input->post("project_id")
		);
		
		
		$update_project = $this->projects_model->update_project($data_project, $clause);
		if( $update_project ){
			redirect("admin_review/".$this->uri->segment(2), "refresh");
		}
	}

}