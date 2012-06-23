<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/project.php');

class Review extends Project {

	public $names = array();
	public $dataproj = array();
	public $reviewers = array();
	public $currreviewers = array();
	public $invitation = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('reviews_model', 'review');
		$this->data['types'] =  $this->types->get_types();
		$this->data['title'] = 'Invite Reviewer'; 
		$this->data["users"] = $this->user->get_users();
		$url = $this->uri->segment(2);
		$this->get_project_data($url);
		$this->data["jurusan"] = $this->jurusan->get_jurusan();
		//echo "nepi ";
		$this->laststate = $this->cek_state($this->dataproj[0]["project_id"]);
		$match = array_search($this->laststate, $this->defstates);
		if( $this->laststate !== "review" && $match ){
			$this->redirect_to_state_url($this->laststate, $url);
		}
		
		$this->get_project_reviewers($url);
		$this->data["current_reviewers"] = $this->currreviewers;
		$this->check_invitations($this->dataproj[0]["project_id"]);
		$this->data["user_names"] = get_user_names($this->data["users"]);
		$this->data['current_project_id'] = $this->dataproj[0]["project_id"];
/* 		print_r( $this->currreviewers); */
		$this->data["self_project"] = is_self_project( $this->dataproj[0]["user_id"], $this->data['current_user_id'] );
		if( !is_contributor( $this->dataproj[0]["user_id"], $this->currreviewers, $this->data['current_user_id']) ) {
			//echo "dieu";
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
	
	/**
	* ---------======@[ REMAP ROUTE ]@======--------- 
	*/
	public function _remap( $judul, $bab ) {
		if( !is_login( $this->data['login'] ) ){
			show_404();
		}
		
		//print_r($bab);
		$totalsegs = $this->uri->total_segments();
		
		if( !$bab ) {
			
			$this->cek_url_and_dest( $judul );
			$this->get_current_type( $this->data["project_data"][0]["type_id"] );
			$this->get_author( $this->data["project_data"][0]["user_id"] );
			$this->data["author_name"] = get_user_name( $this->data["author"] );
			$this->data["author_url"] = get_user_url( $this->data["author"] );
			$this->get_reviewers( $this->data["project_data"][0]["project_reviewer"] );
			$this->get_chapters( $this->data["project_data"][0]["project_id"] );
			$this->get_attachment($this->data["project_data"][0]["project_id"]);
			$this->get_reviews($this->data["project_data"][0]["project_id"]);
			$this->check_approve_bab( $this->data["project_data"][0]["project_id"] );
			if( is_array($this->data["project_data"]) ) {
				$this->load->view("project/review", $this->data);
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
		} else {
			
			$this->cek_url_and_dest( $bab[0], $judul );
			$this->get_parent_data($this->data["project_data"][0]["project_parent"]);
			$this->get_current_type( $this->data["project_parent"][0]["type_id"] );
			$this->get_author( $this->data["project_data"][0]["user_id"] );
			$this->data["author_name"] = get_user_name( $this->data["author"] );
			$this->data["author_url"] = get_user_url( $this->data["author"] );
			$this->get_parent_data($this->data["project_data"][0]["project_parent"]);
			$this->get_reviewers( $this->data["project_parent"][0]["project_reviewer"] );
			$this->get_chapters( $this->data["project_data"][0]["project_id"] );
			$this->get_reviews($this->data["project_data"][0]["project_id"]);
			if( is_array($this->data["project_data"]) ) {
				$this->get_attachment($this->data["project_data"][0]["project_id"]);
				$this->load->view("project/review_bab", $this->data);
			} else {
				$method = str_replace(" ", "_", $bab[0]);
				
				if( $totalsegs >= 3) {
					$counter = $totalsegs - 3;
				}
				$arrarg = array();
				for( $i = 0; $i < $counter; $i++ ) {
					$arrarg[$i] = $this->uri->segment($i+4);
				}
				
				if( method_exists($this, $method) ) {
					call_user_func_array( array( $this,$method ), $arrarg);
				} else {
					if( $bab[0] == "" ){
						call_user_func_array( array( $this,"index" ), array());	
					}
				}
			}
		}
		
	}
	
	
	/**
	* ---------======@[ EDIT PROJECT ]@======--------- 
	*/
	public function edit_project(){
		if (!$this->data["self_project"]) {
			show_404();
		}
	
		$this->cek_url_and_dest( $this->uri->segment(2) );
		$this->get_current_type( $this->data["project_data"][0]["type_id"] );
		$this->get_author( $this->data["project_data"][0]["user_id"] );
		$this->data["author_name"] = get_user_name( $this->data["author"] );
		$this->data["author_url"] = get_user_url( $this->data["author"] );
		$this->get_reviewers( $this->data["project_data"][0]["project_reviewer"] );
		$this->get_chapters( $this->data["project_data"][0]["project_id"] );
		$this->load->view("project/form_edit", $this->data);
	}
	
	/**
	* ---------======@[ EDIT BAB ]@======--------- 
	*/
	public function edit_bab(){
		if (!$this->data["self_project"]) {
			show_404();
		}
		
		$this->cek_url_and_dest( $this->uri->segment(4), $this->uri->segment(2) );
		$this->get_current_type( $this->data["project_data"][0]["type_id"] );
		$this->get_author( $this->data["project_data"][0]["user_id"] );
		$this->data["author_name"] = get_user_name( $this->data["author"] );
		$this->data["author_url"] = get_user_url( $this->data["author"] );
		$this->get_reviewers( $this->data["project_data"][0]["project_reviewer"] );
		$this->get_chapters( $this->data["project_data"][0]["project_id"] );
		$this->load->view("project/form_edit_bab", $this->data);
	}
	
	/**
	* ---------======@[ UPLOAD FILE ]@======--------- 
	*/
	public function upload_file(){
		if (!$this->data["self_project"]) {
			show_404();
		}
		
		if( $this->uri->segment(4) == "" ){
			$this->cek_url_and_dest( $this->uri->segment(2) );
		} else {
			$this->cek_url_and_dest( $this->uri->segment(4), $this->uri->segment(2) );
			$this->get_parent_data($this->data["project_data"][0]["project_parent"]);
		}
		$this->load->view("project/form_upload", $this->data);
	}
	
	/**
	* ---------======@[ UPLOAD REVISI ]@======--------- 
	*/
	public function upload_rev(){
		if (!$this->data["self_project"]) {
			show_404();
		}
		
		if( $this->uri->segment(4) == "" ){
			$this->cek_url_and_dest( $this->uri->segment(2) );
		} else {
			$this->cek_url_and_dest( $this->uri->segment(4), $this->uri->segment(2) );
			$this->get_parent_data($this->data["project_data"][0]["project_parent"]);
		}
		$this->load->view("project/form_upload", $this->data);
	}
	
	/**
	* ---------======@[ DELETE FILE ]@======--------- 
	*/
	public function delete_file($id){
		if (!$this->data["self_project"]) {
			show_404();
		}
		
		$this->get_single_attachment($id);
		$this->load->view("project/form_delete", $this->data);
	}
	
	/**
	* ---------======@[ ADD BAB ]@======--------- 
	*/
	public function add_bab(){
		if (!$this->data["self_project"]) {
			show_404();
		}
		
		$this->cek_url_and_dest( $this->uri->segment(2) );
		$this->get_current_type( $this->data["project_data"][0]["type_id"] );
		$this->get_author( $this->data["project_data"][0]["user_id"] );
		$this->data["author_name"] = get_user_name( $this->data["author"] );
		$this->data["author_url"] = get_user_url( $this->data["author"] );
		$this->get_reviewers( $this->data["project_data"][0]["project_reviewer"] );
		$this->get_chapters( $this->data["project_data"][0]["project_id"] );
		$this->load->view("project/form_add_bab", $this->data);
	}
	
	/**
	* ---------======@[ ADD BAB ]@======--------- 
	*/
	public function save_add_bab(){
		if (!$this->data["self_project"]) {
			show_404();
		}
				
		$parpar = array(
			"rb_projects" => array(
				"project_id" => $this->input->post("project_id")
			)
		);
		$parent = $this->projects_model->get_projects($parpar);
		
		$chap_title = $this->input->post("project_title");
		$urlc = spliturl($chap_title, 50);
		
		$par = array(
			"rb_projects" => array(
				"project_title" => $this->input->post("project_title"),
				"project_parent" => $parent[0]["project_id"]
			)
		);
		$proj = $this->projects_model->get_projects($par);
		
		//print_r($proj);
		if( !empty($proj) ) {
			$this->cek_url_and_dest( $this->uri->segment(2) );
			$this->get_current_type( $this->data["project_data"][0]["type_id"] );
			$this->get_author( $this->data["project_data"][0]["user_id"] );
			$this->data["author_name"] = get_user_name( $this->data["author"] );
			$this->data["author_url"] = get_user_url( $this->data["author"] );
			$this->get_reviewers( $this->data["project_data"][0]["project_reviewer"] );
			$this->get_chapters( $this->data["project_data"][0]["project_id"] );
			
			$this->data["error_msg"] = '<div class="alert alert-warning">Judul bab yang anda masukan telah ada</div>';
			$this->load->view("project/form_add_bab", $this->data);
		} else {
			$data_project2 = array(
				"project_id" => NULL,
				"project_chapters" => NULL,
				"project_chapter_num" => NULL,
				"project_title" => $this->input->post("project_title"),
				"project_content" => $parent[0]["project_content"],//parent
				"project_is_parent" => "no",
				"project_parent" => $this->input->post("project_id"),
				"project_made" =>  $parent[0]["project_made"],//parent
				"project_published" => NULL,
				"project_status" => "review",
				"project_attachment_count" => 0,
				"project_downloadable" => "yes",
				"project_year" =>  $parent[0]["project_year"],//parent
				"type_id" => NULL,
				"user_id" =>  $parent[0]["user_id"],//parent
				"project_author" => $parent[0]["project_author"],//parent
				"project_reviewer" => $parent[0]["project_reviewer"],//parent
				"project_jurusan" => $parent[0]["project_jurusan"],//parent
				"project_fakultas" => $parent[0]["project_fakultas"],//parent
				"project_strata" => $parent[0]["project_strata"],//parent
				"project_url" => $urlc
			);
			$insert_project2 = $this->projects_model->add_new_project($data_project2);
			
			$upd_project = array(
				"project_chapters" => $parent[0]["project_chapters"]+1,
				"project_chapter_num" => $parent[0]["project_chapter_num"]+1
			);
			$clause = array(
				"project_id" => $this->input->post("project_id")
			);
			$update_project = $this->projects_model->update_project($upd_project, $clause);
			
			redirect("review/".$this->uri->segment(2), "refresh");
		}
		
	}
	
	/**
	* ---------======@[ DELETE BAB ]@======--------- 
	*/
	public function delete_bab($id){
		if (!$this->data["self_project"]) {
			show_404();
		}
		
		$this->get_attachment($id);
		/*
echo "<pre>";
		print_r($this->data["versions"]);
		echo "</pre>";
		echo "<pre>";
		print_r($this->data["att_vers"]);
		echo "</pre>";
		echo "<pre>";
		print_r($this->data["attachments"]);
		echo "</pre>";
*/

		$par = array(
			"rb_projects" => array(
				"project_id" => $id
			)
		);
		
		$bab = $this->projects_model->get_projects($par);
		
		foreach( $this->data["versions"] as $k => $v) {
			//del attach
			unlink($this->data["attachments"][$k][0]["attachment_file_path"]);
			$delparatt = array( "attachment_id" => $this->data["attachments"][$k][0]["attachment_id"] );
			$delatt = $this->attach->del_attachment($delparatt);
			
			//del attach vers
			$delparver = array( "version_id" => $v["version_id"] );
			$delattver = $this->attach->del_attachment_version($delparver);
			
			//del vers
			$delver = $this->versions->del_version($delparver);
			
			$parpar = array(
				"rb_projects" => array(
					"project_id" => $bab[0]["project_parent"]
				)
			);
			
			$parent = $this->projects_model->get_projects($parpar);
			
			$data_project = array(
				"project_attachment_count" => $parent[0]["project_attachment_count"]-1
			);
			$clause = array(
				"project_id" => $parent[0]["project_id"]
			);
			$update_project = $this->projects_model->update_project($data_project, $clause);
		}
		
		
		$delbab = array( "project_id" => $id );
		$this->projects_model->del_project($delbab);
		
		$data_project2 = array(
			"project_chapters" => $parent[0]["project_chapters"]-1,
			"project_chapter_num" => $parent[0]["project_chapter_num"]-1
		);
		$clause2 = array(
			"project_id" => $parent[0]["project_id"]
		);
		$update_project2 = $this->projects_model->update_project($data_project2, $clause2);
		
		redirect("review/".$this->uri->segment(2), "refresh");
	}
	
	/**
	* ---------======@[ DELETE REVISIONs ]@======--------- 
	*/
	public function del_rev($verid){
		if (!$this->data["self_project"]) {
			show_404();
		}
		
		//print_r($this->input->post() );
		//get attach id form ver_att
		$attver = array(
			"rb_attachment_versions" => array(
				"version_id" =>  $verid
			)
		);
		$this->data["att_vers"] = $this->attach->get_attachment_version($attver);
		
		if( isset($this->data["att_vers"]) ) {
			$att = array(
				"rb_attachment" => array(
					"attachment_id" =>  $this->data["att_vers"][0]["attachment_id"]
				)
			);
			$this->data["att"] = $this->attach->get_attachments($att);
			
			$delparatt = array( "attachment_id" => $this->data["att_vers"][0]["attachment_id"] );
			$delparver = array( "version_id" => $verid );
			//delete attach
			unlink($this->data["att"][0]["attachment_file_path"]);
			$delatt = $this->attach->del_attachment($delparatt);
			//delete version
			$delver = $this->versions->del_version($delparver);
			//delete version_attach
			$delattver = $this->attach->del_attachment_version($delparatt);
			
		}
		
		//update project - kurangi attach-count
		$data_project = array(
			"project_attachment_count" => $this->input->post("project_attachment_count")-1
		);
		$clause = array(
			"project_id" => $this->input->post("project_id")
		);
		$update_project = $this->projects_model->update_project($data_project, $clause);
		
		//if ada project parent, update project parent - kurangi attach-count
		if( $this->input->post("project_parent_id") !== "" ) {
			$data_project2 = array(
				"project_attachment_count" => $this->input->post("project_attachment_count_parent")-1
			);
			$clause2 = array(
				"project_id" => $this->input->post("project_parent_id")
			);
			$update_project2 = $this->projects_model->update_project($data_project2, $clause2);
		}
		redirect($this->input->post("redirect_dest"), "refresh");
	}
	
	/**
	* ---------======@[ SAVE EDIT PROJECT ]@======--------- 
	*/
	public function save_edit(){
		if (!$this->data["self_project"]) {
			show_404();
		}
		
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
/* 			"project_url_edited" => $this->uri->segment(2), */
		);
		$clause = array(
			"project_id" => $this->input->post("project_id")
		);
		
		
		$update_project = $this->projects_model->update_project($data_project, $clause);
		if( $update_project ){
			redirect("review/".$this->uri->segment(2), "refresh");
		}
	}
	
	/**
	* ---------======@[ SAVE EDIT BAB ]@======--------- 
	*/
	public function save_edit_bab(){
		if (!$this->data["self_project"]) {
			show_404();
		}
		
		$url = spliturl($this->input->post("project_title"), 50);
		$data_project = array(
			"project_title" => $this->input->post("project_title"),
/* 			"project_url" => $url, */
		);
		$clause = array(
			"project_id" => $this->input->post("project_id")
		);
		
		
		$update_project = $this->projects_model->update_project($data_project, $clause);
		if( $update_project ){
			redirect("review/".$this->input->post("project_parent_url").'/'.$this->uri->segment(4), "refresh");
		}
	}
	
	/**
	* ---------======@[ SAVE UPLOAD MASTER ]@======--------- 
	*/
	public function save_upload(){
		if (!$this->data["self_project"]) {
			show_404();
		}
		
		// upload file ke directory 'uploads'
		if ( $this->upload->do_upload( "project_file" ) ) {
			$dataup = array('upload_data' => $this->upload->data());
		
			// update project_attachment_count di table rb_projects
			$data_project = array(
				"project_attachment_count" => 1
			);
			$clause = array(
				"project_id" => $this->input->post("project_id")
			);
			$update_project = $this->projects_model->update_project($data_project, $clause);
			
			// update project_attachment_count di table rb_projects untuk parent bab ini
			if( $this->input->post("project_parent_id") !== "" ) {
				$proj_parent_attach = $this->input->post("project_attachment_count_parent")+1;
				$data_project2 = array(
					"project_attachment_count" => $proj_parent_attach
				);
				$clause2 = array(
					"project_id" => $this->input->post("project_parent_id")
				);
				$update_project2 = $this->projects_model->update_project($data_project2, $clause2);
			}
			
			
			// insert data ke table rb_versions, data : version_id, version_number, project_id
			$ver = array(
				"version_id" => NULL,
				"version_number" => 1,
				"project_id" => $this->input->post("project_id")
			);
			$insert_version = $this->versions->add_new_version($ver);
			
			// insert data ke table rb_attachment, data : attachment_id, attachment_url, attachment_file, attachment_file_ext, attachment_file_path
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
			
		}
		
		//if succeeded redirect to project page
		if( isset($insert_attachvers) && $insert_attachvers ){
			redirect("review/".$this->uri->segment(2), "refresh");
		}
			
	}
	
	/**
	* ---------======@[ SAVE UPLOAD REVISI ]@======--------- 
	*/
	public function save_rev(){
		if (!$this->data["self_project"]) {
			show_404();
		}
		
		// upload file ke directory 'uploads'
		if ( $this->upload->do_upload( "project_file" ) ) {
			$dataup = array('upload_data' => $this->upload->data());
		
			// update project_attachment_count di table rb_projects
			$parget = array(
				"rb_projects" => array(
					"project_id" => $this->input->post("project_id")
				)
			);
			$get_project = $this->projects_model->get_projects($parget);
			
			$data_project = array(
				"project_attachment_count" => $get_project[0]["project_attachment_count"]+1
			);
			$clause = array(
				"project_id" => $this->input->post("project_id")
			);
			$update_project = $this->projects_model->update_project($data_project, $clause);
			
			// update project_attachment_count di table rb_projects untuk parent bab ini
			if( $this->input->post("project_parent_id") !== "" ) {
				$proj_parent_attach = $this->input->post("project_attachment_count_parent")+1;
				$data_project2 = array(
					"project_attachment_count" => $proj_parent_attach
				);
				$clause2 = array(
					"project_id" => $this->input->post("project_parent_id")
				);
				$update_project2 = $this->projects_model->update_project($data_project2, $clause2);
			}
			
			$getver = array(
				"rb_versions" => array(
					"project_id" => $this->input->post("project_id")
				)
			);
			$get_max = $this->versions->get_versions($getver, '', NULL, NULL, "MAX(version_number) as last_ver");
			
			// insert data ke table rb_versions, data : version_id, version_number, project_id
			$ver = array(
				"version_id" => NULL,
				"version_number" => $get_max[0]["last_ver"]+1,
				"project_id" => $this->input->post("project_id")
			);
			$insert_version = $this->versions->add_new_version($ver);
			
			// insert data ke table rb_attachment, data : attachment_id, attachment_url, attachment_file, attachment_file_ext, attachment_file_path
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
			
		}
		
		//if succeeded redirect to project page
		if( isset($insert_attachvers) && $insert_attachvers ){
			redirect("review/".$this->uri->segment(2), "refresh");
		}
			
	}
	
	public function up_project($arg, $par){
		if (!$this->data["self_project"]) {
			show_404();
		}
		
		echo "edited";
	}
	
	/**
	* ---------======@[ SEND COMMENT ]@======--------- 
	*/
	public function send_comment(){
		
		 
		$datestring = "%Y-%m-%d %h:%i:%s";
		$time = time();
		$review_date = mdate($datestring, $time);
		
		//print_r($this->input->post());
		$par = array(
			"user_id" => $this->input->post("userid"),
			"review_date" => $review_date,
			"review_content" => $this->input->post("comment_content"),
			"project_id" => $this->input->post("projid"),
		);
		$sendreview = $this->review->add_review($par);
		
		if( $sendreview ) {
			redirect("review/".$this->input->post("projurl"), "refresh");
		}
		
	}
	
	
	
	/**
	* ---------======@[ CEK URL AND NEXT DESTINATION ]@======--------- 
	*/
	private function cek_url_and_dest($judul, $parent = ""){
		
		if( $parent !== "" ){
			$parp = array(
				"rb_projects" => array(
					"project_url" =>  $parent
				)
			);
			$parentdata = $this->projects_model->get_projects($parp, "", NULL, NULL, "project_id");
			$par = array(
				"rb_projects" => array(
					"project_url" =>  $judul,
					"project_parent" => $parentdata[0]["project_id"]
				)
			);
			
		} else {
			$par = array(
				"rb_projects" => array(
					"project_url" =>  $judul
				)
			);
			
		}
		
		$this->data["project_data"] = $this->projects_model->get_projects($par);
		//print_r( $this->data["project_data"] );
		
		$this->data["project_data"][0]["project_id"];
		if( $this->data["project_data"] ) {
			$state = array(
				"rb_projects_state" => array(
					"project_id" =>  $this->data["project_data"][0]["project_id"]
				)
			);
			$this->data["state"] = $this->projects_model->get_projects_state($state);
			
			if( $this->data["project_data"][0]["project_parent"] > 0 ) {
				$this->get_parent_data( $this->data["project_data"][0]["project_parent"] );
				$prevstate_process = $this->data["project_state"][0]["project_state"];
				$this->data["type"] = $this->data["project_parent"][0]["type_id"];
			} else {
				$prevstate_process = $this->data["state"][0]["project_state"];
				$this->data["type"] = $this->data["project_data"][0]["type_id"];
			}
			
			$this->set_destination($this->data["type"], $prevstate_process);
		}
	}
	
	/**
	* ---------======@[ GET CURRENT PROJECT TYPES ]@======--------- 
	*/
	private function get_parent_data($proj_id){
		$par = array(
			"rb_projects" => array(
				"project_id" =>  $proj_id
			)
		);
		$this->data["project_parent"] = $this->projects_model->get_projects($par);
		$st = array(
			"rb_projects_state" => array(
				"project_id" =>  $proj_id
			)
		);
		$this->data["project_state"] = $this->projects_model->get_projects_state($st);
	}
	
	
	/**
	* ---------======@[ GET CURRENT PROJECT TYPES ]@======--------- 
	*/
	private function get_current_type($type_id){
		
		$par = array(
			"type_id" => $type_id
		);
		$this->data["type_name"] = $this->types->get_types($par);
		
	}
	
	/**
	* ---------======@[ GET AUTHOR ]@======--------- 
	*/
	private function get_author($user_id){
		
		$par = array(
			"rb_user" => array(
				"user_id" => $user_id
			)
		);
		$this->data["author"] = $this->user->get_users($par);
		
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
	* ---------======@[ REORDER VERSION ]@======--------- 
	*/
	public function reorder_version() {
		$oldversid = $this->input->post("oldversid");
		$oldvers = $this->input->post("oldvers");
		$latestvers = $this->input->post("latestvers");
		$newvers = $latestvers+1;
		
		$clause = array(
			"version_id" => $oldversid
		);
		
		$arg = array(
			"version_number" => $newvers
		);
		
		$update = $this->versions->update_versions($arg, $clause);
		if( $update ) {
			$return["result"] = "success";
		}
		
		echo json_encode($return);
		
	}
	
	/**
	* ---------======@[ GET ATTACHMENT ]@======--------- 
	*/
	private function get_attachment($proj_id){
		
		$order = array(
			"version_number" => "ASC"
		);
		
		$ver = array(
			"rb_versions" => array(
				"project_id" =>  $proj_id
			)
		);
		$this->data["versions"] = $this->versions->get_versions($ver, $order);

		if( isset($this->data["versions"]) ){
			foreach($this->data["versions"] as $k => $v) {
			
				$attver = array(
					"rb_attachment_versions" => array(
						"version_id" =>  $v["version_id"]
					)
				);
				$this->data["att_vers"][$k] = $this->attach->get_attachment_version($attver);
			}
		}
		
		if( isset($this->data["att_vers"]) ){
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
	* ---------======@[ GET SINGLE ATTACHMENT ]@======--------- 
	*/
	private function get_single_attachment($verid){
		
		$order = array(
			"version_number" => "ASC"
		);
		
		$ver = array(
			"rb_versions" => array(
				"version_id" =>  $verid
			)
		);
		$this->data["versions"] = $this->versions->get_versions($ver, $order);

		if( isset($this->data["versions"]) ){
			$pro = array(
				"rb_projects" => array(
					"project_id" =>  $this->data["versions"][0]["project_id"]
				)
			);
			$this->data["project_data"] = $this->projects_model->get_projects($pro);
			
			if( isset($this->data["project_data"]) ){
				$propar = array(
					"rb_projects" => array(
						"project_id" =>  $this->data["project_data"][0]["project_parent"]
					)
				);
				$this->data["project_parent"] = $this->projects_model->get_projects($propar);
			}
			
			$attver = array(
				"rb_attachment_versions" => array(
					"version_id" =>  $this->data["versions"][0]["version_id"]
				)
			);
			$this->data["att_vers"] = $this->attach->get_attachment_version($attver);
		}
		
		if( isset($this->data["att_vers"]) ){
			$att = array(
				"rb_attachment" => array(
					"attachment_id" =>  $this->data["att_vers"][0]["attachment_id"]
				)
			);
			$this->data["attachments"] = $this->attach->get_attachments($att);
		}
		
	}
	
	/**
	* ---------======@[ GET REVIEWS ]@======--------- 
	*/
	private function get_reviews($projid){
		
		$par = array(
			"rb_review" => array(
				"project_id" =>  $projid
			)
		);
		$this->data["reviews"] = $this->review->get_reviews($par);
		
		
		if( isset($this->data["reviews"]) ){
			foreach($this->data["reviews"] as $k => $v) {
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
				
				$par3 = array(
					"rb_reviewer" => array(
						"user_id" =>  $v["user_id"],
						"project_id" => $projid
					)
				);
				
				$this->data["is_reviewer"][$k] = $this->reviewer->get_reviewers($par3, '', NULL, NULL, "user_id");
				if($this->data["is_reviewer"][$k]) {
					$this->data["commentor"][$k][0]["role"] = "reviewer";
				} else {
					$this->data["commentor"][$k][0]["role"] = "author";
				}
				
			}
		}
		
		
		//print_r($this->data["reviews"]);
		
	
	}
	
	/**
	* ---------======@[ GET PROJECT DATA ]@======--------- 
	*/
	
	public function get_project_data($url){
		//echo $url;
		$par = array(
			"rb_projects" => array(
				"project_url" => $url
			)
		);
		
		$this->dataproj = $this->projects_model->get_projects($par);
		
	}
	
	/**
	* ---------======@[ GET PROJECT DATA REVIEWER ]@======--------- 
	*/
	
	public function get_project_reviewers($url){
		
		$this->get_project_data($url); 
		
		$rev = array(
			"rb_reviewer" => array(
				"project_id" => $this->dataproj[0]["project_id"],
				//"reviewer_status" => "active"
			)
		);
		
		$this->currreviewers = $this->reviewer->get_reviewers($rev);
		//print_r($this->currreviewers);
	}
	
	////////////////////////////////////INVITATIONS & REVIEWERS////////////////////////////////////////////////////
	
	/**
	* ---------======@[ CHECK INVITATIONS ]@======--------- 
	*/
	
	public function check_invitations($id){
		
		$inv = array(
			"rb_invitation" => array(
				"invitation_project" => $id
			)
		);
		
		$invitation = $this->user->get_invitations($inv);
		
		if( $invitation ) {
			foreach( $invitation as $k => $v ) {
				if( $v["invitation_status"] == "pending" ) {
					array_push( $this->reviewers, $v );
				}
			}
		}
		
		
		$rev = array(
			"rb_reviewer" => array(
				"project_id" => $id
			)
		);
		
		$reviewer = $this->reviewer->get_reviewers($rev);
		
		if( $reviewer ) {
			foreach( $reviewer as $k => $v ) {
				if( $v["reviewer_status"] == "invited" ) {
					array_push( $this->reviewers, $v );
				}
			}
		}
		
		$this->data["reviewers_invite"] = $this->reviewers;
		
	}
	
	public function invite_new() {
		
		
		
		$invitee_email = $this->input->post('invitee_email');
		$invite_by = $this->input->post('invite_by');
		$invitation_project = $this->input->post('invitation_project');
		
		$this->form_validation->set_rules('invitee_email', 'Email', 'required|valid_emails');
		if($this->form_validation->run() == FALSE)
        {
            $return['errors'] = validation_errors('<div class="alert alert-warning">', '</div>');
            echo json_encode($return);
            die();
		}
		
		$userpar = array(
			"rb_user" => array(
				"user_email" => $invitee_email
			)
		);
		
		$user_email =  $this->user->get_users($userpar, '', NULL, NULL, "user_id");
		if( !$user_email ) {
			$ss = array(
				"rb_site_settings" => array(
					"site_settings_key" => "Email Admin"
				)
			);
			
			
			$site_mail = $this->site_settings_model->get_site_settings($ss);
			
			$user_data = array(
				"rb_user" => array(
					"user_id" => $invite_by
				)
			);
			$dataus = $this->user->get_users($user_data);
			$name = get_user_name($dataus);
			$invitationurl = urlencode($dataus[0]["user_email"]);
			$invitation_code = md5(uniqid($invitationurl));
			$time = time();
			$datestring = "%Y-%m-%d %h:%i:%s";
			$invitation_date = mdate($datestring, $time);
			$mailmsg = "Hello, $name mengundang Anda untuk menjadi pembimbingnya di situs Rakbuku. \r\n click invitation url berikut untuk manjadi member dan reviewer di website kami \r\n invitation url : ".base_url()."invitations/$invitation_code";
			
			$mailsent = send_email($invitee_email, $site_mail[0]["site_settings_value"], "Undangan untuk menjadi Pembimbing di situs Rakbuku", $mailmsg);
									
			
			if( $mailsent ) {
			
				$inv = array(
					"invitation_code" => $invitation_code,
					"invitation_email" => $invitee_email,
					"invitation_date" => $invitation_date,
					"invite_by" => $invite_by,
					"invitation_for" => "reviewer",
					"invitation_project" => $invitation_project,
					"invitation_url" => base_url()."invitations/".$invitation_code,
				);
				
				$datainv = $this->user->add_new_invitation($inv);
				
				$return['result'] = '<div class="alert alert-info">Sukses</div>';
			} else {
				$return['result'] = '<div class="alert alert-warning">gagal menginvite, silahkan kirim ulang</div>';
			}
		} else {
			$user_data = array(
				"reviewer_id" => NULL,
				"user_id" => $user_email[0]["user_id"],
				"reviewer_status" => "invited",
				"project_id" => $invitation_project
			);
			$data_reviewer = $this->reviewer->add_reviewer_project($user_data);
			if( $data_reviewer ) {
				$return['result'] = '<div class="alert alert-info">Sukses</div>';
			}
		}
		
		echo json_encode($return);
		
	}
	
	
	/**
	* ---------======@[ RESEND INVITATION ]@======--------- 
	*/
	public function resend_email_invite($id){
		
		$inv = array(
			"rb_invitation" => array(
				"invitation_id" => $id,
				"invitation_project" => $this->dataproj[0]["project_id"]
			)
		);
		
		$inva = $this->user_model->get_invitations($inv);
		
		$us = array(
			"rb_user" => array(
				"user_id" => $this->dataproj[0]["user_id"]
			)
		);
		
		$user = $this->user_model->get_users($us);
		
		$name = get_user_name($user);
		
		$ss = array(
			"rb_site_settings" => array(
				"site_settings_key" => "Email Admin"
			)
		);
		$site_mail = $this->site_settings_model->get_site_settings($ss);
		
		$mailmsg = "Hello, $name mengundang Anda untuk menjadi pembimbingnya di situs Rakbuku. \r\n click invitation url berikut untuk manjadi member dan reviewer di website kami \r\n invitation url : ".base_url()."invitations/".$inva[0]["invitation_code"]."";
					
		$send = send_email($inva[0]["invitation_email"], $site_mail[0]["site_settings_value"], "Undangan untuk menjadi Pembimbing di situs Rakbuku", $mailmsg);
		
		if( $send ) {
			redirect("review/".$this->uri->segment(2), "refresh");
		}
		
	}
	
	/**
	* ---------======@[ CHECK APPROVED BAB ]@======--------- 
	*/
	
	public function check_approve_bab($projid){
		
		$par = array(
			"rb_projects" => array(
				"project_parent" => $projid
			)
		);
		
		$babstatus = $this->projects_model->get_projects($par, "", NULL, NULL, "project_status");
		
		$this->data["bab_approved_all"] = true; 
		if(isset($babstatus)) {
			foreach( $babstatus as $k => $v ) {
				if( $v["project_status"] == "review" ) {
					$this->data["bab_approved_all"] = false;
				}
			}
		}
		
	}
	
	/**
	* ---------======@[ approve bab ]@======--------- 
	*/
	public function approve_bab(){
				
		if( $this->uri->segment(4) == "" ){
			$this->cek_url_and_dest( $this->uri->segment(2) );
		} else {
			$this->cek_url_and_dest( $this->uri->segment(4), $this->uri->segment(2) );
			$this->get_parent_data($this->data["project_data"][0]["project_parent"]);
		}
		$this->load->view("project/reviewer_approval_bab", $this->data);
	}
	
	/**
	* ---------======@[ approve project ]@======--------- 
	*/
	public function approve_project(){
				
		if( $this->uri->segment(4) == "" ){
			$this->cek_url_and_dest( $this->uri->segment(2) );
		} else {
			$this->cek_url_and_dest( $this->uri->segment(4), $this->uri->segment(2) );
			$this->get_parent_data($this->data["project_data"][0]["project_parent"]);
		}
		$this->load->view("project/reviewer_approval_project", $this->data);
	}
	
	/**
	* ---------======@[ SAVE APPROVAL BAB ]@======--------- 
	*/
	public function save_approval(){
		
		//print_r($this->input->post());
		$data_project = array(
			"project_status" => "approved"
		);
		$clause = array(
			"project_id" => $this->input->post("project_id")
		);
		
		$update_project = $this->projects_model->update_project($data_project, $clause);
		
		$parent_url = $this->input->post("project_parent_url");
		
		if( $update_project ){
			if( !empty($parent_url) ) {
				redirect("review/".$this->input->post("project_parent_url").'/'.$this->uri->segment(4), "refresh");
			} else {
				redirect("review/".$this->input->post("project_url"), "refresh");
			}
		}
	}
	
	/**
	* ---------======@[ SAVE APPROVAL BAB ]@======--------- 
	*/
	public function open_project(){
		//echo "tes";
		$urlbab = $this->uri->segment(4);
		if( !empty($urlbab) ) {
			$data_project1 = array(
				"project_status" => "review"
			);
			$clause1 = array(
				"project_url" => $this->uri->segment(4)
			);
			$update_project1 = $this->projects_model->update_project($data_project1, $clause1);
		} 
		$data_project = array(
			"project_status" => "review"
		);
		$clause = array(
			"project_url" => $this->uri->segment(2)
		);
		
		$update_project = $this->projects_model->update_project($data_project, $clause);
		
		if( !empty($urlbab) ) {
			redirect("review/".$this->uri->segment(2).'/'.$this->uri->segment(4), "refresh");
		} else {
			redirect("review/".$this->uri->segment(2), "refresh");
		}
		
	}
	
	/**
	* ---------======@[ publish form ]@======--------- 
	*/
	public function publish_project(){
	
		$this->cek_url_and_dest( $this->uri->segment(2) );
		$this->load->view("project/publish_project", $this->data);
	}
	
	/**
	* ---------======@[ go_publish ]@======--------- 
	*/
	public function go_publish(){
	
		$data_project1 = array(
			"project_status" => "approved"
		);
		$clause1 = array(
			"project_url" => $this->uri->segment(2)
		);
		$update_project1 = $this->projects_model->update_project($data_project1, $clause1);
		
		//print_r($this->input->post());
		$parstate = array(
			"project_state" => $this->input->post( "project_state" ),
			"project_state_next_state" => $this->input->post( "nextstate" ),
			"project_state_next_url" => $this->input->post( "nexturl" )
		);
		$clausestate = array(
			"project_id" => $this->input->post( "project_id" )
		);
		
		$update_project_state = $this->projects_model->update_project_state($parstate, $clausestate);
		
		redirect($this->input->post( "currenturl" ).'/'.$this->input->post( "project_url" ), "refresh");
		
	}
	
}