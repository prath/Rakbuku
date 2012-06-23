<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'controllers/base.php');

class User extends Base {

	public $data = array();
	public $html = '';
	 
	function __construct() {
		parent::__construct();
		$this->data['uurl'] = $this->uri->segment(2);
		$this->data['current_user'] = $this->session->userdata('current_user');
		$this->data['current_user_id'] = $this->session->userdata('user_id');
		$this->data['current_role'] = $this->session->userdata('role_name');
		$check_uurl = $this->user_model->check_uurl($this->data['uurl']);

		if(!$check_uurl)
		{
			show_404();
		}
		$this->load->model('page_template_model', 'ptm');
		$this->load->model('User_meta_model', 'metadata');
		$this->load->model('reviewers_model', 'reviewer');
		//$usr = 'usr'.rand(1, 100).'prt';
		//echo uniqid($usr);
	}
	
	public function index()  {
		//echo $this->uurl = $this->uri->segment(2);
	}
	
	/*------------------------------------------------------------------------
	| Method : login
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : void
	| Description : controller login 
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function login(){ 
		if( $this->session->userdata('user_id') ) {
			redirect('/');
		}
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
		if($this->form_validation->run() == FALSE) {
			
			$this->load->view('login');
		} else {
			$email = $this->input->post('email');
			$pass = md5($this->input->post('password'));
			$par = array(
				'ru.user_email' => $email,
				'ru.user_pass' => $pass
			);
			$userdata = $this->user_model->do_login($par);
			if(!$userdata) {
				$this->data["salah"] = "email atau password salah";
				$this->load->view("login", $this->data);
				//redirect('/');
			}else if($userdata->user_status == "inactive") {
				$this->data["salah"] = "email atau password salah";
				$this->load->view("member_inactive", $this->data);
			} else {
				$newdata = array();
				$newdata['user_id'] = $userdata->user_id;
				$newdata['user_email'] = $userdata->user_email;
				$newdata['user_unique_url'] = strtolower($userdata->user_unique_url);
				$newdata['user_activation_key'] = $userdata->user_activation_key;
				$newdata['current_user'] = ($newdata['user_unique_url']=='') ? $newdata['user_activation_key'] : $newdata['user_unique_url'];
				$newdata['jur_id'] = $userdata->jur_id;
				$newdata['firstname'] = $userdata->user_firstname;
				$newdata['middlename'] = $userdata->user_middlename;
				$newdata['lastname'] = $userdata->user_lastname;
				$newdata['fullname'] = $newdata['firstname'].' '.$newdata['middlename'].' '.$newdata['lastname'];
				$newdata['logged_in'] = true;
				$newdata['role_name'] = $userdata->role_name;
				$this->session->set_userdata($newdata);
				if($newdata['role_name'] == 'admin')
				{
					redirect('admin/dashboard');
				}
				else
				{
					redirect('user/'.$newdata['current_user']);
				}	
			}
		}
	}
	
	/*------------------------------------------------------------------------
	| Method : logout
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : void
	| Description : controller logout
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function lost_pass() {
		if( $this->session->userdata('user_id') ) {
			redirect('/');
		}
		$this->load->view("lost_pass", $this->data);
	}
	
	public function retrieve_pass() {
		if( $this->session->userdata('user_id') ) {
			redirect('/');
		}
		$mail = $this->input->post("email");
		
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean');
		if($this->form_validation->run() == FALSE) {
			$this->load->view("lost_pass", $this->data);
		} else {
			$par = array(
				"rb_user" => array(
					"user_email" => $mail
				)
			);
			$cek = $this->user_model->get_users($par);
			
			if( !empty($cek) ) {
			
				$ss = array(
					"rb_site_settings" => array(
						"site_settings_key" => "Email Admin"
					)
				);
				
				$site_mail = $this->site_settings_model->get_site_settings($ss);
				
				$time = time();
				$datestring = "h%i%s";
				$dte = mdate($datestring, $time);
				$newpass = uniqid($dte);
				$newpassen = md5($newpass);
				
				$arg = array(
					"user_pass" => $newpassen
				);
				
				$clause = array(
					"user_email" => $mail
				);
				
				$update = $this->user_model->update_user($arg, $clause);
				
				if( $update ) {
					
					$mailmsg = "Anda meminta untuk mereset password baru, inilah password baru Anda : $newpass ,Segera rubah password Anda setelah berhasil login";
					
					$mailsent = send_email($mail, $site_mail[0]["site_settings_value"], "Reset Password", $mailmsg);	
					if( $mailsent ) {
						
						$this->data["success"] = "Password telah direset, silahkan buka email Anda";
						$this->load->view("lost_pass", $this->data);
						
					} else {
						
						$this->data["failed"] = "Password gagal direset, silahkan coba lagi";
						$this->load->view("lost_pass", $this->data);
						
					}

				}

				
			} else {
				$this->data["noexist"] = "tidak ada member dengan email yang Anda masukkan";
				$this->load->view("lost_pass", $this->data);
			}
		}
		
	}
	
	public function request_active() {
		if( $this->session->userdata('user_id') ) {
			redirect('/');
		}
		$mail = $this->input->post("email");
		$msg = $this->input->post("msg");
		
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean');
		$this->form_validation->set_rules('msg', 'Pesan', 'required|xss_clean');
		if($this->form_validation->run() == FALSE) {
			$this->load->view("member_inactive", $this->data);
		} else {
			
			$ss = array(
				"rb_site_settings" => array(
					"site_settings_key" => "Email Admin"
				)
			);
			
			$site_mail = $this->site_settings_model->get_site_settings($ss);
			
			$mailsent = send_email($site_mail[0]["site_settings_value"], $mail, "Request Activation", $mail.' berpesan : '.$msg);	
			if( $mailsent ) {
				
				$this->data["success"] = "Pesan telah dikirm, tunggu jawaban dari admin";
				$this->load->view("member_inactive", $this->data);
				
			} else {
				
				$this->data["failed"] = "Pesan gagal dikirim, silahkan coba lagi";
				$this->load->view("member_inactive", $this->data);
				
			}

		}
		
	}
	
	/*------------------------------------------------------------------------
	| Method : logout
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : void
	| Description : controller logout
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function logout() {
		$this->session->sess_destroy();
		$this->session->set_flashdata('redirectToCurrent', current_url());
		redirect($this->session->flashdata('redirectToCurrent'));
		//redirect('/');
	}
	
	/*------------------------------------------------------------------------
	| Method : dashboard
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : void
	| Description : dashboard member/user
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function dashboard() {
		$userdata = $this->data['uurl'];
		$this->data['user_meta'] = $this->user_model->get_user_metas($userdata);
		$this->data['user_data'] = $this->user_model->get_user_data($userdata);

		foreach ($this->data['user_data'] as $key => $value) {
			$name = $value['user_firstname'];
			if($value['user_middlename'] != '')
			{
				$name .= ' '.$value['user_middlename'];
			}
			if($value['user_lastname'] != '')
			{
				$name .= ' '.$value['user_lastname'];
			}
			$this->data['names'] = $name;
		}

		$par = array(
			"rb_jurusan" => array(
				"jur_id" => $this->data['user_data'][0]["jur_id"]
			)
		);
		$this->data["jurusan"] = $this->jurusan->get_jurusan($par, '', NULL, NULL, NULL);
		
		$this->data["alljurusan"] = $this->jurusan->get_jurusan();
		$this->load->view("user/dashboard", $this->data);
	}
	
	
	/*------------------------------------------------------------------------
	| Method : admin review
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : void
	| Description : admin review member/user
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function admin_reviews() {
		$userdata = $this->data['uurl'];
		$this->data['user_meta'] = $this->user_model->get_user_metas($userdata);
		$this->data['user_data'] = $this->user_model->get_user_data($userdata);

		foreach ($this->data['user_data'] as $key => $value) {
			$name = $value['user_firstname'];
			if($value['user_middlename'] != '')
			{
				$name .= ' '.$value['user_middlename'];
			}
			if($value['user_lastname'] != '')
			{
				$name .= ' '.$value['user_lastname'];
			}
			$this->data['names'] = $name;
		}

		$par = array(
			"rb_jurusan" => array(
				"jur_id" => $this->data['user_data'][0]["jur_id"]
			)
		);
		$this->data["jurusan"] = $this->jurusan->get_jurusan($par, '', NULL, NULL, NULL);
		
		$this->data["alljurusan"] = $this->jurusan->get_jurusan();
		$this->load->view("user/admin_reviews", $this->data);
	}
	
	/*------------------------------------------------------------------------
	| Method : Projects
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : void
	| Description : controller projects
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function projects() {
		
		$userdata = $this->data['uurl'];
		$this->data['user_meta'] = $this->user_model->get_user_metas($userdata);
		$this->data['user_data'] = $this->user_model->get_user_data($userdata);

		foreach ($this->data['user_data'] as $key => $value) {
			$name = $value['user_firstname'];
			if($value['user_middlename'] != '')
			{
				$name .= ' '.$value['user_middlename'];
			}
			if($value['user_lastname'] != '')
			{
				$name .= ' '.$value['user_lastname'];
			}
			$this->data['names'] = $name;
		}

		$par = array(
			"rb_jurusan" => array(
				"jur_id" => $this->data['user_data'][0]["jur_id"]
			)
		);
		$this->data["jurusan"] = $this->jurusan->get_jurusan($par, '', NULL, NULL, NULL);
		
		$this->data["alljurusan"] = $this->jurusan->get_jurusan();	
		
		
		//$perpage = 4;
		//$this->paginating("projects_model", "home/index/", 3, $perpage);//end pagination
		
		$usersdata = $this->user_model->get_user_data($userdata);
		//print_r($usersdata);
		
		$order = array(
			'project_made'=>'ASC'
		);
		
		$par = array(
			"rb_projects" => array(
				"user_id" => $usersdata[0]["user_id"]
			)
		);
		$this->data["projects"] = $this->projects_model->get_projects($par, $order);
		
		if( !empty($this->data["projects"]) ) {
			$this->data["types"] = array();
			foreach( $this->data["projects"] as $k => $v ) {
				$typepar = array(
					"type_id" => $v["type_id"]
				);
				
				$type = $this->types->get_types($typepar);
				array_push($this->data["types"], $type[0]["type_name"]);
			}
			$this->data["reviewer"] = array();
			foreach( $this->data["projects"] as $k => $v ) {
			
				$rev = array(
					"rb_reviewer" => array(
						"project_id" => $v["project_id"]
					)
				);
				
				$reviewer = $this->reviewer->get_reviewers($rev);	
				array_push($this->data["reviewer"], $reviewer);	
				
			}
		}
		
		/*
echo "<pre>";
		print_r($this->data["reviewer"]);
		echo "</pre>";
*/
		
		
		$this->load->view("user/projects", $this->data);
		//redirect('/');
	}
	
	/*------------------------------------------------------------------------
	| Method : Reviews
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : void
	| Description : controller projects
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function reviews() {
	
		$userdata = $this->data['uurl'];
		$this->data['user_meta'] = $this->user_model->get_user_metas($userdata);
		$this->data['user_data'] = $this->user_model->get_user_data($userdata);

		foreach ($this->data['user_data'] as $key => $value) {
			$name = $value['user_firstname'];
			if($value['user_middlename'] != '')
			{
				$name .= ' '.$value['user_middlename'];
			}
			if($value['user_lastname'] != '')
			{
				$name .= ' '.$value['user_lastname'];
			}
			$this->data['names'] = $name;
		}

		$par = array(
			"rb_jurusan" => array(
				"jur_id" => $this->data['user_data'][0]["jur_id"]
			)
		);
		$this->data["jurusan"] = $this->jurusan->get_jurusan($par, '', NULL, NULL, NULL);
		
		$this->data["alljurusan"] = $this->jurusan->get_jurusan();	
		
		
		
		//$perpage = 4;
		//$this->paginating("projects_model", "home/index/", 3, $perpage);//end pagination
		$usersdata = $this->user_model->get_user_data($userdata);
		
		$rev = array(
			"rb_reviewer" => array(
				"user_id" => $usersdata[0]["user_id"]
			)
		);
		
		$this->data["reviews"] = $this->reviewer->get_reviewers($rev);
		/*
echo "<pre>";
		print_r($this->data["reviews"]);
		echo "</pre>";
*/
		
		$this->data["reviewing"] = array();
		if( !empty($this->data["reviews"]) ) {
			foreach($this->data["reviews"] as $k => $v) {
				$order = array(
					'project_made'=>'ASC'
				);
				
				$par = array(
					"rb_projects" => array(
						"project_id" =>$v["project_id"]
					)
				);
				$this->data["projects"] = $this->projects_model->get_projects($par, $order);
				$this->data["reviewing"][$k] = $this->data["projects"][0];
			}
		}
		
		/*
echo "<pre>";
		print_r($this->data["reviewing"]);
		echo "</pre>";
*/
		
		
		
		
		if( !empty($this->data["reviewing"]) ) {
			$this->data["types"] = array();
			foreach( $this->data["reviewing"] as $k => $v ) {
				$typepar = array(
					"type_id" => $v["type_id"]
				);
				
				$type = $this->types->get_types($typepar);
				array_push($this->data["types"], $type[0]["type_name"]);
			}
			$this->data["authors"] = array();
			foreach( $this->data["reviewing"] as $k => $v ) {
				$typeuser = array(
					"rb_user" => array(
						"user_id" => $v["user_id"]
					)
				);
				
				$users = $this->user->get_users($typeuser);
				if($users[0]["user_unique_url"] == "") {
					array_push($this->data["authors"], $users[0]["user_activation_key"]);
				} else {
					array_push($this->data["authors"], $users[0]["user_unique_url"]);
				}			
			}
		}
		
		/*
echo "<pre>";
		print_r($this->data["types"]);
		echo "</pre>";
		
		echo "<pre>";
		print_r($this->data["authors"]);
		echo "</pre>";
*/
		

		
		
		$this->load->view("user/reviews", $this->data);
		//redirect('/');
	}
	
	public function accept_invite($arg) {
		
		$par = array(
			"reviewer_status" => "active"
		);
		
		$clause = array(
			"reviewer_id" => $arg
		);
		
		$return["data"] = $this->reviewer->update_invitation($par, $clause);
		
		echo json_encode($return);
	}
	
	/*------------------------------------------------------------------------
	| Method : Profile
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : void
	| Description : controller profile
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function profile() {
		$userdata = $this->data['uurl'];
		$this->data['user_meta'] = $this->user_model->get_user_metas($userdata);
		$this->data['user_data'] = $this->user_model->get_user_data($userdata);

		foreach ($this->data['user_data'] as $key => $value) {
			$name = $value['user_firstname'];
			if($value['user_middlename'] != '')
			{
				$name .= ' '.$value['user_middlename'];
			}
			if($value['user_lastname'] != '')
			{
				$name .= ' '.$value['user_lastname'];
			}
			$this->data['names'] = $name;
		}

		$par = array(
			"rb_jurusan" => array(
				"jur_id" => $this->data['user_data'][0]["jur_id"]
			)
		);
		$this->data["jurusan"] = $this->jurusan->get_jurusan($par, '', NULL, NULL, NULL);
		
		$this->data["alljurusan"] = $this->jurusan->get_jurusan();	
/*
		echo "<pre>";
		print_r($this->data['user_meta']);
		echo "</pre>";
*/
		$this->load->view("user/profile", $this->data);
	}
	
	/*------------------------------------------------------------------------
	| Method : Account
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : void
	| Description : controller account
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function account() {
		if(!is_own_profile($this->data['uurl'], $this->data['current_user'])){
			show_404();
		}
		
		$userdata = $this->data['uurl'];
		$this->data['user_meta'] = $this->user_model->get_user_metas($userdata);
		$this->data['user_data'] = $this->user_model->get_user_data($userdata);

		foreach ($this->data['user_data'] as $key => $value) {
			$name = $value['user_firstname'];
			if($value['user_middlename'] != '')
			{
				$name .= ' '.$value['user_middlename'];
			}
			if($value['user_lastname'] != '')
			{
				$name .= ' '.$value['user_lastname'];
			}
			$this->data['names'] = $name;
		}

		$par = array(
			"rb_jurusan" => array(
				"jur_id" => $this->data['user_data'][0]["jur_id"]
			)
		);
		$this->data["jurusan"] = $this->jurusan->get_jurusan($par, '', NULL, NULL, NULL);
		
		$this->data["alljurusan"] = $this->jurusan->get_jurusan();	
/*
		echo "<pre>";
		print_r($this->data['user_meta']);
		echo "</pre>";
*/
		
		
		$this->load->view("user/account", $this->data);
		//redirect('/');
	}
	
	/*------------------------------------------------------------------------
	| Method : Privacy
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : void
	| Description : controller privacy
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function privacy() {
		if(!is_own_profile($this->data['uurl'], $this->data['current_user'])){
			show_404();
		}
		$this->load->view("user/privacy", $this->data);
		//redirect('/');
	}
	
	/*------------------------------------------------------------------------
	| Method : Invitation
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : void
	| Description : controller invitation
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function invitation() {
		if(!is_own_profile($this->data['uurl'], $this->data['current_user'])){
			show_404();
		}
		
		$userdata = $this->data['uurl'];
		$this->data['user_data'] = $this->user_model->get_user_data($userdata);

		foreach ($this->data['user_data'] as $key => $value) {
			$name = $value['user_firstname'];
			if($value['user_middlename'] != '')
			{
				$name .= ' '.$value['user_middlename'];
			}
			if($value['user_lastname'] != '')
			{
				$name .= ' '.$value['user_lastname'];
			}
			$this->data['names'] = $name;
		}	
		$user_id = $this->data['current_user_id'];
		$par = array(
			"rb_user" => array(
				"user_id" => $user_id
			)
		);
		$select = "user_invite_quota";
		
		$this->data["quota"] = $this->user_model->get_users($par, $orderby = '', $limit = NULL, $offset = NULL, $select);
		
		//invitation
		$parin = array(
			"rb_invitation" => array(
				"invite_by" => $user_id
			)
		);
		$orderby = array(
			"rb_invitation" => array(
				"invitation_date" => "ASC" 	
			)
		);
		
		$this->data["invitation"] = $this->user_model->get_invitations($parin, $orderby, $limit = NULL, $offset = NULL, $select = NULL);
/*
		echo "<pre>";
		print_r($this->data['invitation']);
		echo "</pre>";
*/

		
		$this->load->view("user/invitation", $this->data);
	}
	
	public function invite_new_member() {
		
		$invitee_email = $this->input->post("invitee_email");
		$invitee_name = $this->input->post("invitee_name");
		
		//$return["result"] = "e";
		$cekmail = true;
		$cekarg = array(
			"rb_user" => array(
				"user_email" => $invitee_email
			)
		);
		
		$cekuser = $this->user_model->get_users($cekarg);
		if( is_array($cekuser) ) {
			$cekmail = false;
		}
		
		$cekargi = array(
			"rb_invitation" => array(
				"invitation_email" => $invitee_email,
				"invite_by" => $this->data['current_user_id']
			)
		);
		
		$cekinvitation = $this->user_model->get_invitations($cekargi);
		if( is_array($cekinvitation) ) {
			$cekmail = false;
			
		}
		
		
		if( !$cekmail ) {
			$return["result"] = "exist";
		} else {
			$return["result"] = "empty";
			
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
			$mailmsg = "Hello $invitee_name, $name mengundang Anda untuk menjadi member di situs Rakbuku. \r\n click invitation url berikut untuk manjadi member di website kami \r\n invitation url : ".base_url()."invitations/$invitation_code";
			
			$mailsent = send_email($invitee_email, $site_mail[0]["site_settings_value"], "Undangan untuk menjadi Pembimbing di situs Rakbuku", $mailmsg);	
			if( $mailsent ) {
					
				$inv = array(
					"invitation_code" => $invitation_code,
					"invitation_name" => $invitee_name,
					"invitation_email" => $invitee_email,
					"invitation_date" => $invitation_date,
					"invite_by" => $this->data['current_user_id'],
					"invitation_for" => "member",
					"invitation_url" => base_url()."invitations/".$invitation_code,
				);
				$datainv = $this->user->add_new_invitation($inv);
				
				$return["result"] = "sent";
				
			} else {
				$return["result"] = "failed";
			}
			
		}

		
		
		echo json_encode($return);
		
	}

	/*------------------------------------------------------------------------
	| Method : Update_user_profile
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : array/objects
	| Description : controller untuk mengupdate data profil user dan 
	| 				me-retrieve kembali hasil update ke view.
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function update_user_profile() {
		if(!is_own_profile($this->data['uurl'], $this->data['current_user'])){
			show_404();
		}
		$inputs = $this->input->post();
		$user_id = $this->data['current_user_id'];
		
		if ( !empty($inputs["jur_name"]) ) {
			$cek = 0;
			$inarr = array();
			$this->data["jurusan"] = $this->jurusan->get_jurusan();
			
			foreach ( $this->data["jurusan"] as $key => $value ) {
				if ( $inputs["jur_name"] == $value["jur_name"] ) {
					$cek = 1;
					$inarr["jur_id"] = $value["jur_id"];
				}
			}
			
			if ( $cek ) {
				$return['data'] = $this->user_model->update_user_data($user_id, $inarr);
				foreach ( $inarr as $k => $v ) {
					$idjur = $return['data'][$k];
					$par = array (
						"rb_jurusan" => array (
							"jur_id" => $idjur
						)
					);
					$this->data["jurusan"] = $this->jurusan->get_jurusan($par, '', NULL, NULL, NULL);
					$return["result"] = $this->data["jurusan"][0]["jur_name"];
					$return["fak"] = $this->data["jurusan"][0]["fak_name"];
				}
			} else {
				$return['gagal'] = "tidak ada nama jurusan tersebut";
			}
		} else if( !empty($inputs["user_pass"]) ) {
			$passnew["user_pass"] = md5($inputs["user_pass"]);
			$return['data'] = $this->user_model->update_user_data($user_id, $passnew);
			$return['result'] = "tes";
		} else {
			$return['data'] = $this->user_model->update_user_data($user_id, $inputs);
			
			if( !empty($inputs["user_firstname"]) ) {
				if($return['data']['user_front_title'] != ''){
					$name = $return['data']['user_front_title'].'. ';
				}else{
					$name = '';
				}
				$name .= $return['data']['user_firstname'];
				if($return['data']['user_middlename'] != ''){
					$name .= ' '.$return['data']['user_middlename'];
				}
				if($return['data']['user_lastname'] != ''){
					$name .= ' '.$return['data']['user_lastname'];
				}
				if($return['data']['user_back_title'] != ''){
					$name .= ' '.$return['data']['user_back_title'];
				}
				$return['result'] = $name;
			} else {
				foreach ( $inputs as $k => $v ) {
					$return['result'] = $return['data'][$k];
				}
			}
			
		}
		
		echo json_encode($return);
	}

	/*------------------------------------------------------------------------
	| Method : update_user_meta
	|-------------------------------------------------------------------------
	| Paramater : $meta_key
	| Return : objects
	| Description : controller untuk mengupdate data meta user dan 
	| 				me-retrieve kembali hasil update ke view.
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function update_user_meta($meta_key) {

		if(!is_own_profile($this->data['uurl'], $this->data['current_user'])){
			show_404();
		}
		
		$user_id = $this->data['current_user_id'];
		$inputs = $this->input->post();
		
		$meta_val_arr = array();
		foreach ($inputs as $key => $value) {
			array_push($meta_val_arr, $value);
		}

		$co = count($meta_val_arr);
		if($co > 1){
			$meta_val = serialize($inputs);
		}else{
			$meta_val = $meta_val_arr[0];
		}
		$return["result"] = $meta_val;
		

		$hasil['data'] = $this->user_model->update_user_meta($meta_key, $meta_val, $user_id);

		error_reporting(0);

		$check_serialized = unserialize($hasil['data']->meta_value);
		if($check_serialized || $str === 'b:0;'){
			$hasil['data']->meta_value = $check_serialized;
			$return["result"] = $hasil['data']->meta_value;
		} else {
			$return["result"] = $hasil['data']->meta_value;
		}
/*		
		//return $hasil['data'];
		echo $hasil['data']->meta_value;
*/
		echo json_encode($return);

	}
	
	public function paginating($mdl, $path, $urisegment, $perpage) {
		$config['base_url'] = site_url($path);
        if(gettype($mdl) === 'integer')
        {
        	$config['total_rows'] = $mdl;
        }
        else
        {
        	$config['total_rows'] = $this->$mdl->count_all_published();
        }
        $config['uri_segment'] = $urisegment;
        $config['per_page'] = $perpage; 
        $this->pagination->initialize($config); 
		$this->data['pagination'] = $this->pagination->create_links();


    } 
	

}
