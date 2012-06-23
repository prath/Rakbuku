<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invitations extends CI_Controller {
	
	public $data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model('Reviewers_model', 'reviewers');
	}
	
	/**
	* ---------======@[ REMAP ROUTE ]@======--------- 
	*/
	public function _remap( $actkey, $par) {
		//echo $actkey;
		$inv = array(
			"rb_invitation" => array(
				"invitation_code" => $actkey
			)
		);
		
		$this->data["invitation"] = $this->user->get_invitations($inv);
				
		if( is_array($this->data["invitation"]) ) {
			$this->session->sess_destroy();
			$this->load->view("invitation/invitation_confirm", $this->data);
		} else {
			$method = str_replace(" ", "_", $actkey);
			if( empty($par) ) {
				$arg = array();
			} else {
				$arg = array( $par );
			}
			
			if( method_exists($this, $method) ) {
				call_user_func_array( array( $this,$method ), $arg);
			} else {
				//if( $actkey == "" ){
				call_user_func_array( array( $this,"index" ), array());	
				//}
			}
		}
		
		
	}
	
	public function index() {
		show_404();
	}
	
	public function signup($key) {
		$this->data["key"] = $key[0];
		
		$inv = array(
			"rb_invitation" => array(
				"invitation_code" => $key[0]
			)
		);
		
		$this->data["invitation"] = $this->user->get_invitations($inv);
		//print_r($this->data["invitation"]);
		
		if( !empty( $this->data["invitation"] ) ) {
			$this->load->view("signup", $this->data);
		} else {
			show_404();
		}
		
	}
	
	public function decline($key){
		
	}
	
	public function cek_avail() {
		$uurl = $this->input->post("uurl");
		
		if( !empty($uurl) ) { 
			$cekarg = array(
				"rb_user" => array(
					"user_unique_url" => $uurl
				)
			);
			
			$cekuser = $this->user_model->get_users($cekarg);
			if( is_array($cekuser) ) {
				$return["result"] = "exist";
			} else {
				$return["result"] = "empty";
			}
		} else {
			$return["result"] = "fieldempty";
		}
		
		echo json_encode($return);
	}
	
	public function sign_this_up() {
		
		$email = $this->input->post("email");
		$key = $this->input->post("cek");
		$pass =  $this->input->post("pass");
		$user_firstname =  $this->input->post("firstname");
		$user_middlename =  $this->input->post("middlename");
		$user_lastname =  $this->input->post("lastname");
		$uurl = $this->input->post("uurl");
		
		$this->form_validation->set_rules('pass', 'Password', 'required|xss_clean');
		$this->form_validation->set_rules('firstname', 'Nama Depan', 'required|xss_clean');
		if($this->form_validation->run() == FALSE ) {
			$this->data["key"] = $this->input->post("cek");
			$this->load->view("signup", $this->data);
		} else {
			$user_activation_key = $generatedKey = md5(mt_rand(10000,99999).time().$this->input->post('firstname'));
			
			$datestring = "%Y-%m-%d %h:%i:%s";
			$time = time();
			$user_registered = mdate($datestring, $time);
			
			$user_pass = md5($pass);
			
			//add user ambil insert id user
			$user_data = array(
				"user_id" => NULL,
				"user_email" => $email,
				"user_pass" => $user_pass,
				"user_registered" => $user_registered,
				"user_activation_key" => $user_activation_key,
				"user_unique_url" => $uurl,
				"user_firstname" => $user_firstname,
				"user_middlename" => $user_middlename,
				"user_lastname" => $user_lastname,
				"user_status" => "active"
			);
			$role_user = "member";
			
			$user = $this->user_model->add_user($user_data, $role_user);
			
			//cek invitation table klo ada email sama, cek invitation for, klo for nya untuk reviewer masukan ke table reviewer, cek invitation code yang reviewer ini yang invitation codenya beda dengan $key set review status invited, yang sama statusnya active
			$inv = array(
				"rb_invitation" => array(
					"invitation_email" => $email
				)
			);
			
			$cekinvite = $this->user->get_invitations($inv);
			
			$cek_invite = '';
			foreach( $cekinvite as $k => $v ){
				
				
				
				if( $v["invitation_for"] == "reviewer" ) {
					if( $v["invitation_code"] !== $key ) {
						$reviewer_status = "invited";
						$cek_invite = $v["invitation_for"];
					} else {
						$reviewer_status = "active";
					}
					
					$user_data = array(
						"reviewer_id" => NULL,
						"user_id" => $user,
						"reviewer_status" => $reviewer_status,
						"project_id" => $v["invitation_project"]
					);
					$reviewer = $this->reviewers->add_reviewer($user_data);
					
					$parpro = array(
						"rb_projects" => array(
							"project_id" => $v["invitation_project"]
						)
					);
					$project_url = $this->projects_model->get_projects($parpro);
					$redirect_url = "review/".$project_url[0]["project_url"];
				} else {
					$redirect_url = "user/".$uurl.'/profile';
				}
				
				$par = array(
					"invitation_code" => 0,
					"invitation_status" => "accepted"
 				);
				$clause = array(
					"invitation_email" => $email
				);
				$invup = $this->user->update_invitation($par, $clause);
				
			}
			
			$newdata = array();
			$newdata['user_id'] = $user;
			$newdata['user_email'] = $email;
			$newdata['user_unique_url'] = $uurl;
			$newdata['user_activation_key'] = $user_activation_key;
			$newdata['current_user'] = $newdata['user_unique_url'];
			$newdata['jur_id'] = '';
			$newdata['firstname'] = $user_firstname;
			$newdata['middlename'] = $user_middlename;
			$newdata['lastname'] = $user_lastname;
			$newdata['fullname'] = $newdata['firstname'].' '.$newdata['middlename'].' '.$newdata['lastname'];
			$newdata['logged_in'] = true;
			$newdata['role_name'] = $role_user;
			$this->session->set_userdata($newdata);
			
			redirect($redirect_url);
			
		}
	}

}