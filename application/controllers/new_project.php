<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/project.php');

class New_project extends Project {
	
	function __construct() {
		parent::__construct();
		
		//$generatedKey = md5(mt_rand(10000,99999).time().$str);
		$this->data["jurusan"] = $this->jurusan->get_jurusan();
		
		if( !is_login($this->data['login']) ){
			show_404();
		}
	}
	
	public function index() {
		if( !is_login($this->data['login']) ){
			show_404();
		}
		
		$this->data['types'] =  $this->types->get_types();
		$this->data['title'] = 'New Project'; 
		
		$this->load->view("project/new_project", $this->data);
	}
	
	/**
	* ---------======@[ NEW FORM ]@======--------- 
	*/
	public function new_form() {
		if( !is_login($this->data['login']) || ( $this->input->post("project_state") == "" && ($this->laststate != $this->uri->segment( 1 )) ) ){
			show_404();
		}
		
		$prevstate_process = $this->input->post("project_state");
		$this->data["type"] = $this->input->post("project_type");
		
		$par = array(
			"type_id" => $this->data["type"]
		);
		$this->data["types"] = $this->types->get_types($par);
		
		
		//print_r($this->data["jurusan"]);
		
		$this->set_destination($this->data["type"], $prevstate_process);
		$this->load->view("project/form_new", $this->data);
	}
	
	
	/**
	* ---------======@[ SAVE NEW PROJECT ]@======--------- 
	*
	* saving new project
	*/
	public function save_new_project(){
		if( !is_login($this->data['login']) || ( $this->input->post("project_state") == "" && ($this->laststate != $this->uri->segment( 1 )) ) ){
			show_404();
		}
		$this->data["type"] = $this->input->post( "project_type" );
		$this->data["status"] = $this->input->post( "project_status" );
		$this->data["state"] = $this->input->post( "project_state" );
		$this->data["nextstate"] = $this->input->post( "nextstate" );
		$this->data["nexturl"] = $this->input->post( "nexturl" );
		$this->data["currenturl"] = $this->input->post( "currenturl" );
		$project_title = $this->input->post( "project_title" );
		$project_content = $this->input->post( "project_content" );
		$project_author = $this->input->post( "project_author" );
		$project_reviewer = $this->input->post( "project_reviewer" );
		$project_year = $this->input->post( "project_year" );
		$project_chapters = $this->input->post( "project_chapters" );
		$project_jurusan = $this->input->post( "project_jurusan" );
		$project_fakultas = $this->input->post( "project_fakultas" );
		$project_strata = $this->input->post( "project_strata" );
		
		$this->form_validation->set_rules('project_title', 'Judul', 'required|xss_clean');
		$this->form_validation->set_rules('project_content', 'Abstract', 'required|xss_clean');
		$this->form_validation->set_rules('project_author', 'Nama Lengkap', 'required|xss_clean');
		$this->form_validation->set_rules('project_year', 'Tahun Pembuatan', 'required|numeric|xss_clean');
		$this->form_validation->set_rules('project_jurusan', 'Jurusan', 'required|xss_clean');
		$this->form_validation->set_rules('project_fakultas', 'Fakultas', 'required|xss_clean');
		$this->form_validation->set_rules('project_strata', 'Strata', 'required|xss_clean');
		if($this->data["type"] == 1 || $this->data["type"] == 2 || $this->data["type"] == 3 || $this->data["type"] == 4 || $this->data["type"] == 5) {
			$this->form_validation->set_rules('project_reviewer', 'Pembimbing', 'required|xss_clean');
		}
		
		$judul = $this->projects_model->get_projects('', '', NULL, NULL, "project_title");
		$this->data["cekjuudul"] = "";
		if( isset($judul) ) {
			foreach( $judul as $k => $v ) {
				if( array_search( $project_title, $v ) ){
					$this->data["cekjuudul"] = "ada";
				}
			}	
		}
		
        if($this->form_validation->run() == FALSE || $this->data["cekjuudul"] == "ada") {
        	$par = array(
				"type_id" => $this->input->post( "project_type" )
			);
			$this->data["types"] = $this->types->get_types($par);
        	$prevstate_process = $this->prev_state($this->data["type"], $this->data["state"]);
        	$this->data["type"] = $this->input->post("project_type");
        	$this->set_destination($this->data["type"], $prevstate_process);
            $this->load->view("project/form_new", $this->data);
		} else {
			//save disini 2012-05-31 06:36:46
			$save = $this->save_process($this->input->post());
		}
	
	}
	
	protected function save_process($post) {
		if( !is_login($this->data['login']) || ( $this->input->post("project_state") == "" && ($this->laststate != $this->uri->segment( 1 )) ) ){
			show_404();
		}
		
		//$this->output->enable_profiler(TRUE);
		//echo "<pre>";
		//print_r($_FILES);
		//echo "</pre>";
		
		$arrcountatt = 0;
		foreach( $_FILES as $k => $v ) {
			if($v["name"] !== "") {
				$arrcountatt++;
			}
		}
		
		$arrcountatt;
		
		$datestring = "%Y-%m-%d %H:%i:%s";
		$time = time();			
		$now =  mdate($datestring, $time);
		error_reporting(0);
		$exp = explode( "|", $post["project_reviewer"] );
		$reviewer = serialize($exp);
		$string = $post["project_title"];
		$url = spliturl($string, 50);
		
		$project_keywords_temp = $this->input->post( "project_keywords" );
		$project_keywords_exp = explode( ',', $project_keywords_temp );
		$project_keywordstrim = array();
		foreach( $project_keywords_exp as $k => $v ) {
			array_push($project_keywordstrim, trim($v));
		}
		$project_keywords = serialize($project_keywordstrim);
				
		$data_project = array(
			"project_id" => NULL,
			"project_chapters" => $post["project_chapters"],
			"project_chapter_num" => $post["project_chapters"],
			"project_title" => $post["project_title"],
			"project_content" => $post["project_content"],
			"project_is_parent" => "yes",
			"project_parent" => NULL,
			"project_made" => $now,
			"project_published" => NULL,
			"project_status" => "created",
			"project_attachment_count" => $arrcountatt,
			"project_downloadable" => "yes",
			"project_year" => $post["project_year"],
			"type_id" => $this->data["type"],
			"user_id" => $this->data['current_user_id'],
			"project_author" => $post["project_author"],
			"project_reviewer" => $reviewer,
			"project_jurusan" => $post["project_jurusan"],
			"project_fakultas" => $post["project_fakultas"],
			"project_strata" => $post["project_strata"],
			"project_url" => $url,
			"project_keywords" => $project_keywords,
			"project_link" => $post["project_link"]
		);
		
		
		$insert_project = $this->projects_model->add_new_project($data_project);
		
		if( $insert_project ) {
			$par = array(
				"rb_projects_fw" => array(
					"type_id" => $this->data["type"]
				)
			);
			
			$fw = $this->projects_model->get_projects_fw($par);
			$data_project_state = array(
				"project_state_id" => NULL,
				"project_id" => $insert_project,
				"project_state" => $post["project_state"],
				"project_state_next_state" => $post["nextstate"],
				"project_state_next_url" => $post["nexturl"],
				"project_state_fw" => $fw[0]["fw"]		
			);
			
			$insert_project_state = $this->projects_model->add_new_project_state($data_project_state);
		}
		
		if( $post["project_chapters"] > 1 ) {
			$chaps = $post["project_chapters"];
			
			$b = 0;
			$projattachcount = array();
			foreach( $_FILES as $k => $v) {
				if($v["name"] !== "") {
					$projattachcount[$b] = $v["name"];
				}
				$b++;
			}
			
			for( $i = 0; $i < $chaps; $i++ ) {
				
				$x = $i+1;
				
				if( $post["project_chap_title"][$i] == "") {
					$chap_title = "BAB ".$x;
					$urlc = spliturl($chap_title, 50);
				} else {
					$chap_title = $post["project_chap_title"][$i];
					$urlc = spliturl($chap_title, 50);
				}
				
				error_reporting(0);
				$proatc = 0;
				if($projattachcount[$i]) {
					$proatc = 1;
				}
				
				$data_project2 = array(
					"project_id" => NULL,
					"project_chapters" => NULL,
					"project_chapter_num" => NULL,
					"project_title" => $chap_title,
					"project_content" => $post["project_content"],
					"project_is_parent" => "no",
					"project_parent" => $insert_project,
					"project_made" => $now,
					"project_published" => NULL,
					"project_status" => "created",
					"project_attachment_count" => $proatc,
					"project_downloadable" => "yes",
					"project_year" => $post["project_year"],
					"type_id" => NULL,
					"user_id" => $this->data['current_user_id'],
					"project_author" => $post["project_author"],
					"project_reviewer" => $reviewer,
					"project_jurusan" => $post["project_jurusan"],
					"project_fakultas" => $post["project_fakultas"],
					"project_strata" => $post["project_strata"],
					"project_url" => $urlc
				);
				$insert_project2 = $this->projects_model->add_new_project($data_project2);
				
				if($this->upload->do_upload( "project_chap_file_".$x )){
					$dataup = array('upload_data' => $this->upload->data());
					
					$ver = array(
						"version_id" => NULL,
						"version_number" => 1,
						"project_id" => $insert_project2
					);
					$insert_version = $this->versions->add_new_version($ver);
					
					if( $insert_version ) {
						$att = array(
							"attachment_id" => NULL,
							"attachment_url" => $dataup["upload_data"]["file_name"],
							"attachment_file" => $dataup["upload_data"]["file_name"],
							"attachment_file_ext" => $dataup["upload_data"]["file_ext"],
							"attachment_file_path" => $dataup["upload_data"]["full_path"]
						);
						$insert_attachment = $this->attach->add_new_attachment($att);
						
						if( $insert_attachment ){
							$attachvers = array(
								"attachment_id" => $insert_attachment,
								"version_id" => $insert_version
							);
							$insert_attachvers = $this->attach->add_new_attachment_version($attachvers);
						}
					}
				}
			
			}
			
			if( $insert_project ){
				$destination = $this->input->post( "currenturl" );
				redirect($destination.'/'.$url, "refresh");
			}
			
		} else {
		
			$projattachcount = 0;
			foreach( $_FILES as $k => $v) {
				if($v["name"] !== "") {
					$projattachcount = 1;
				}
			}
						
			$chap_title = "BAB I";
			$urlc = spliturl($chap_title, 50);
			
			$data_project2 = array(
				"project_id" => NULL,
				"project_chapters" => NULL,
				"project_chapter_num" => NULL,
				"project_title" => $chap_title,
				"project_content" => $post["project_content"],
				"project_is_parent" => "no",
				"project_parent" => $insert_project,
				"project_made" => $now,
				"project_published" => NULL,
				"project_status" => "created",
				"project_attachment_count" => $projattachcount,
				"project_downloadable" => "yes",
				"project_year" => $post["project_year"],
				"type_id" => NULL,
				"user_id" => $this->data['current_user_id'],
				"project_author" => $post["project_author"],
				"project_reviewer" => $reviewer,
				"project_jurusan" => $post["project_jurusan"],
				"project_fakultas" => $post["project_fakultas"],
				"project_strata" => $post["project_strata"],
				"project_url" => $urlc
			);
			$insert_project2 = $this->projects_model->add_new_project($data_project2);
			
			if ( $this->upload->do_upload( "project_chap_file_0" ) ) {
				
				$dataup = array('upload_data' => $this->upload->data());
				
				$ver = array(
					"version_id" => NULL,
					"version_number" => 1,
					"project_id" => $insert_project2
				);
				$insert_version = $this->versions->add_new_version($ver);
				
				if( $insert_version ) {
					$att = array(
						"attachment_id" => NULL,
						"attachment_url" => $dataup["upload_data"]["file_name"],
						"attachment_file" => $dataup["upload_data"]["file_name"],
						"attachment_file_ext" => $dataup["upload_data"]["file_ext"],
						"attachment_file_path" => $dataup["upload_data"]["full_path"]
					);
					$insert_attachment = $this->attach->add_new_attachment($att);
					
					if( $insert_attachment ){
						$attachvers = array(
							"attachment_id" => $insert_attachment,
							"version_id" => $insert_version
						);
						$insert_attachvers = $this->attach->add_new_attachment_version($attachvers);
					}
				}
				
			}
			if( $insert_project ){
				$destination = $this->input->post( "currenturl" );
				$string = $post["project_title"];
				redirect($destination.'/'.$url, "refresh");
			}
		
		}
		
	}
	
	

}