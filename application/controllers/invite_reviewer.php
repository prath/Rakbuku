<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/project.php');

class Invite_reviewer extends Project {

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
		if( $this->laststate !== "invite_reviewer" && $match !== false ){
			$this->redirect_to_state_url($this->laststate, $url);
		}
		foreach ($this->data['users'] as $key => $value) {
			$this->names[$key] = '';
			if($value['user_front_title'] != '') {
				$this->names[$key] .= $value['user_front_title'].' ';
			}
			
			$this->names[$key] .= $value['user_firstname'];
			
			if($value['user_middlename'] != '')	{
				$this->names[$key] .= ' '.$value['user_middlename'];
			}
			
			if($value['user_lastname'] != '') {
				$this->names[$key] .= ' '.$value['user_lastname'];
			}
			
			if($value['user_back_title'] != '') {
				$this->names[$key] .= ' '.$value['user_back_title'];
			}
			
		}
		
		$this->data["user_names"] = $this->names;
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
		if( !is_login($this->data['login']) ){
			show_404();
		}
		
		//$juduldecoded = urldecode(str_replace("_", "+", $judul));
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
			$this->load->view("project/invite_reviewer", $this->data);
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
	
	public function process_invite() {
		//print_r( $this->input->post() );
		
		$status = $this->input->post( "project_status" );
		$proj_id = $this->input->post( "project_id" );
		if( $status == "onrun" ) {
		
			$invitee = $this->input->post( "invitee_email" );
			
			foreach( $invitee as $k => $v ) {
				$userpar = array(
					"rb_user" => array(
						"user_email" => $v
					)
				);
				
				$user_email =  $this->user->get_users($userpar, '', NULL, NULL, "user_id");
				if( !$user_email ) {
				
					//kirim email invite dan masukan data ke table invitation
					$ss = array(
						"rb_site_settings" => array(
							"site_settings_key" => "Email Admin"
						)
					);
					
					$site_mail = $this->site_settings_model->get_site_settings($ss);
					$user_data = array(
						"rb_user" => array(
							"user_id" => $this->data['current_user_id']
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
					
					$mailsent = send_email($v, $site_mail[0]["site_settings_value"], "Undangan untuk menjadi Pembimbing di situs Rakbuku", $mailmsg);
											
					
					if( $mailsent ) {
					
						$inv = array(
							"invitation_code" => $invitation_code,
							"invitation_email" => $v,
							"invitation_date" => $invitation_date,
							"invite_by" => $this->data['current_user_id'],
							"invitation_for" => "reviewer",
							"invitation_project" => $proj_id,
							"invitation_url" => base_url()."invitations/".$invitation_code,
						);
						$datainv = $this->user->add_new_invitation($inv);
						
					} else {
						$par = array(
							"rb_projects" => array(
								"project_id" => $proj_id
							)
						);
						$data_proj = $this->projects_model->get_projects($par);
						$string = $data_proj[0]["project_title"];
						$url = spliturl($string, 50);
						
						$rev = array(
							"project_id" => $proj_id
						);
						$data_reviewer = $this->reviewer->del_reviewer($rev);
						
						redirect("invite_reviewer/".$url."/error_sent", "refresh");
						
					}
				
				} else {
				
					$user_data = array(
						"reviewer_id" => NULL,
						"user_id" => $user_email[0]["user_id"],
						"reviewer_status" => "invited",
						"project_id" => $proj_id
					);
					$data_reviewer = $this->reviewer->add_reviewer_project($user_data);
				
				}
				
			}
			
			$par = array(
				"project_status" => "review"
			);
			$clause = array(
				"project_id" => $proj_id
			);
			$get_child = array(
				"rb_projects" => array(
					"project_parent" => $proj_id
				)
			);
			$datachild = $this->projects_model->get_projects($get_child);
			
			$update_reviewer = $this->projects_model->update_project($par, $clause);
			
			if( $update_reviewer && is_array($datachild) ) {
				foreach($datachild as $k => $v) {
					$parch = array(
						"project_status" => "review"
					);
					
					$clausech = array(
						"project_id" => $v["project_id"]
					);
					
					$update_reviewerch = $this->projects_model->update_project($parch, $clausech);
				}
			}
			
			
			
		} else {
			
			$par = array(
				"project_status" => "admin review"
			);
			
			$clause = array(
				"project_id" => $proj_id
			);
			
			$get_child = array(
				"rb_projects" => array(
					"project_parent" => $proj_id
				)
			);
			$datachild = $this->projects_model->get_projects($get_child);
			
			$update_reviewer = $this->projects_model->update_project($par, $clause);
			
			if( $update_reviewer && is_array($datachild) ) {
				foreach($datachild as $k => $v) {
					$parch = array(
						"project_status" => "admin review"
					);
					
					$clausech = array(
						"project_id" => $v["project_id"]
					);
					
					$update_reviewerch = $this->projects_model->update_project($parch, $clausech);
				}
			}
			
		}
		
		
		
		if( $update_reviewer ) {
		
			$par = array(
				"rb_projects" => array(
					"project_id" => $proj_id
				)
			);
			$data_proj = $this->projects_model->get_projects($par);
			$string = $data_proj[0]["project_title"];
			$url = spliturl($string, 50);
			
			if( $status == "finished" ) {
				//echo $status;
				$parstate = array(
					"project_state" => "admin review",
					"project_state_next_state" => "penyetujuan admin",
					"project_state_next_url" => "admin_approval"
				);
				$clausestate = array(
					"project_id" => $proj_id
				);
				
				$update_project_state = $this->projects_model->update_project_state($parstate, $clausestate);
				
				redirect( "admin_review/".$url , "refresh");
			} else {
				
				$parstate = array(
					"project_state" => $this->input->post( "project_state" ),
					"project_state_next_state" => $this->input->post( "nextstate" ),
					"project_state_next_url" => $this->input->post( "nexturl" )
				);
				$clausestate = array(
					"project_id" => $proj_id
				);
				
				$update_project_state = $this->projects_model->update_project_state($parstate, $clausestate);
				
				redirect($this->input->post( "currenturl" ).'/'.$url, "refresh");
			}
				
		}
			
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
	
	 
}