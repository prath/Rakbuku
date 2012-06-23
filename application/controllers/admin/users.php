<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'controllers/admin/dashboard.php');

class Users extends Dashboard {
	 
	public $data;

	function __construct() {
		parent::__construct();
		if(! $this->is_login())
		{
			redirect('admin/dashboard');
		}
		$this->load->model('user_model', 'users');
		$this->load->model('reviewers_model', 'reviewers');
		$this->load->model('page_template_model', 'ptm');
		$this->load->model('User_meta_model', 'metadata');
		$this->metadata->initialize('user_model', 'users');
	}
	
	public function index($offset = 0)
	{
		/*
		* tentukan menu-menu sidebar ke dalam array $this->data['menu']
		*/
		$this->data['title'] = 'Member'; 
		$this->data['menu'] = $this->get_sidebar_menu();
		$order = array(
			'user_id'=>'ASC'
		);//end menu

		/*
		* pagination
		*/
		$perpage = 2;
		$this->paginating("users", "admin/users/index/", 4, $perpage);//end pagination

		$this->data['users'] =  $this->users->get_users('', $order, $perpage, $offset);
		$this->data['user_roles'] = array();
		foreach ($this->data['users'] as $key => $value) {
			$par = array(
				'rb_user_role' => array(
					'user_id'=>$value['user_id']
				),
			);
			$this->data['user_roles'][$key] =  $this->user_role->get_user_roles($par);
		}
		$this->load->view('admin/users/users', $this->data);
	}

	/*------------------------------------------------------------------------
	| Method : getmenu
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : array
	| Description : fungsi controller untuk menset menusidebar
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	private function get_sidebar_menu()
	{
		$menu = array(
			'title' => 'Users',
			'menus' => array(
				'' => 'Member',
				//'user_role' => 'User Role',
				//'reviewer' => 'Reviewer',
				//'user_template' => 'User Data Config',
				'manage_admin' => 'Manage Admin',
				//'invitation' => 'Invitation',
			),
		);

		return $menu;
	}

	/**
	* USER
	*/

	/*------------------------------------------------------------------------
	| Method : user_activation
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : json
	| Description : controller untuk ajax
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function user_activation()
	{
		$curstatus = $this->input->post('status');
		$user_id = $this->input->post('ID');
		$user_name = $this->input->post('fullname');
		if($curstatus === 'active')
		{
			$userdata = array(
				'user_status' => 'inactive'
			);
			$data = $this->users->update_user_data($user_id, $userdata);
			$return[0] =  '<span class="muted">'.$data['user_status'].'</span>';
			$return['button_rel'] = 'aktifkan';
			$return['button_class'] = 'btn btn-primary activemember';
			$return['button_text'] = '<i class="icon-ok icon-white"></i> activated';
			$return['input'] = array($user_id, $user_name, ''.$data['user_status'].'');
		}
		else
		{
			$userdata = array(
				'user_status' => 'active'
			);
			$data = $this->users->update_user_data($user_id, $userdata);
			$return[0] =  '<span>'.$data['user_status'].'</span>';
			$return['button_rel'] = 'non-aktifkan';
			$return['button_class'] = 'btn btn-warning deactivemember';
			$return['button_text'] = '<i class="icon-remove icon-white"></i> deactivated';
			$return['input'] = array($user_id, $user_name, ''.$data['user_status'].'');
		}
		
		echo json_encode($return);
	}

	/*------------------------------------------------------------------------
	| Method : sent_account
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : json
	| Description : controller untuk ajax
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function sent_account()
	{
		$return['id'] = $this->input->post('ID');
		echo json_encode($return);
	}

	/*------------------------------------------------------------------------
	| Method : add_user
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : json
	| Description : controller untuk ajax
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function add_user()
	{
		$this->form_validation->set_rules('user_email', 'Email', 'required|valid_emails');
		$this->form_validation->set_rules('user_firstname', 'First Name', 'required');
		$this->form_validation->set_rules('user_pass', 'Password', 'required');
		$this->form_validation->set_rules('role', 'User Role', 'required');
        if($this->form_validation->run() == FALSE)
        {
        	$return['validation_error'] = 'validation error';
            $return['errors'] = validation_errors('<div class="error">', '</div>');
            echo json_encode($return);
            die();
		}
		$datestring = "%Y-%m-%d %h:%i:%s";
		$time = time();
		$str = urlencode($this->input->post('user_firstname'));
		$user_data = array(
			'user_id' => NULL,
			'user_email' => $this->input->post('user_email'),
			'user_pass' => md5($this->input->post('user_pass')),
			'user_registered' => mdate($datestring, $time),
			'user_activation_key' => uniqid($str),
			'jur_id' => NULL,
			'user_unique_url' => NULL,
			'user_firstname' => $this->input->post('user_firstname'),
			'user_middlename' => $this->input->post('user_middlename'),
			'user_lastname' => $this->input->post('user_lastname'),
			'user_front_title' => NULL,
			'user_back_title' => NULL,
			'user_status' => 'active'
		);
		$return['tes']='tes';
		$role_id = $this->input->post('role');
		$return['datainput'] = $this->users->add_user($user_data, $role_id);
		if($return['datainput'] === 'gagal add')
		{
			$return['data_ada'] = "Email yang Anda Masukkan telah ada, coba dengan email yang lain";
		}
		else
		{
			$return['sukses_add'] = 'sukses';
		}
		echo json_encode($return);
	}

	public function manage_admin($offset = 0)
	{
		/*
		* tentukan menu-menu sidebar ke dalam array $this->data['menu']
		*/
		$this->data['title'] = 'Manage Admin'; 
		$this->data['menu'] = $this->get_sidebar_menu();
		$order = array(
			'rb_user_role' => array(
				'user_id'=>'ASC'
			)
		);//end menu

		/*
		* pagination
		*/
		$perpage = 2;

		$par = array(
			"rb_role" => array(
				"role_name" => "admin"
			)
		);

		$totalrow = count($this->users->get_users_w_roles($par, $order));
		
		$this->paginating($totalrow, "admin/users/manage_admin/", 4, $perpage);//end pagination

		$this->data['users'] =  $this->users->get_users_w_roles($par, $order, $perpage, $offset);

		/*echo "<pre>";
		print_r($this->users->get_users_w_roles($par, $order));
		echo "</pre>";*/
		
		$this->load->view('admin/users/admin', $this->data);
	}

	/*------------------------------------------------------------------------
	| Method : add_reviewer
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : json
	| Description : controller untuk ajax
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function add_admin()
	{
		$this->form_validation->set_rules('fullname', 'Admin Name', 'required');
        if($this->form_validation->run() == FALSE)
        {
        	$return['validation_error'] = 'validation error';
            $return['errors'] = validation_errors('<div class="error">', '</div>');
            echo json_encode($return);
            die();
		}
		$return['full name'] = $this->input->post('fullname');

		$this->data['users'] = $this->users->get_users('', '', NULL, NULL, "user_id, user_firstname, user_middlename, user_lastname");
		foreach ($this->data['users'] as $key => $value) {
			$name = $value['user_firstname'];
			if($value['user_middlename'] != '')
			{
				$name .= ' '.$value['user_middlename'];
			}
			if($value['user_lastname'] != '')
			{
				$name .= ' '.$value['user_lastname'];
			}
			$this->data['names'][$value['user_id']] = $name;
		}

		$return['userarr'] = $this->data['names'];
		$return['user_id_query'] = array_search($return['full name'], $this->data['names']);

		$role_data = array('role_name' => 'admin');
		$return['role_id'] = $this->user_role->get_roles($role_data, '', NULL, NULL, "role_id");


		$admin_data = array(
			'role_id' => $return['role_id'][0]['role_id']
		);
		$clause = array(
			'user_id' => $return['user_id_query']
		);
		$return['datainput'] = $this->user_role->add_admin($admin_data, $clause);
		if($return['datainput'] === 'gagal add')
		{
			$return['data_ada'] = "User yang Anda Masukkan telah menjadi admin atau tidak ada member dengan nama itu, coba yang lain";
		}
		else
		{
			$return['sukses_add'] = 'sukses';
		}
		echo json_encode($return);
	}

	/**
	* end USER
	*/

	/**
	* USER ROLE
	*/

	/*------------------------------------------------------------------------
	| Method : user_role
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : array
	| Description : controller untuk menampilkan list user_role
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function user_role($offset = 0)
	{
		/*
		* tentukan menu-menu sidebar ke dalam array $this->data['menu']
		*/
		$this->data['title'] = 'User Role'; 
		$this->data['menu'] = $this->get_sidebar_menu();
		$order = array(
			'role_id'=>'ASC'
		);//end menu

		/*
		* pagination
		*/
		$perpage = 2;
		$this->paginating("user_role", "admin/users/user_role/", 4, $perpage);//end pagination

		$this->data['user_roles'] =  $this->user_role->get_roles('', $order, $perpage, $offset);
		$this->load->view('admin/users/user_role', $this->data);
	}

	/*------------------------------------------------------------------------
	| Method : edit_user_role
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : json
	| Description : controller untuk ajax
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function edit_user_role()
	{
		$this->form_validation->set_rules('role', 'User Role', 'required');
        if($this->form_validation->run() == FALSE)
        {
        	$return['validation_error'] = 'validation error';
            $return['errors'] = validation_errors('<div class="error">', '</div>');
            echo json_encode($return);
            die();
		}
		$role_data = array(
			'role_id' => $this->input->post('role')
		); 
		$clause = array(
			'user_id' => $this->input->post('ID')
		);
		$return['dataupdate'] = $this->user_role->update_user_role($role_data, $clause);
		if($return['dataupdate'] !== 'gagal')
		{
			$return['edit'] =  array($return['dataupdate'][0]['role_name']);
			$return['input'] =  array($this->input->post('ID'), $return['dataupdate'][0]['role_name']);
		}
		else
		{
			$par = array(
				'rb_user_role' => $role_data,
				'rb_user_role' => $clause,
			);
			$dataerror = $this->user_role->get_user_roles($par);
			$return['edit'] =  array($dataerror[0]['role_name']);
			$return['input'] =  array($this->input->post('ID'), $dataerror[0]['role_name']);
		}

		echo json_encode($return);
	}

	/*------------------------------------------------------------------------
	| Method : edit_role
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : json
	| Description : controller untuk ajax
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function edit_role()
	{
		$this->form_validation->set_rules('role', 'Role', 'required');
        if($this->form_validation->run() == FALSE)
        {
        	$return['validation_error'] = 'validation error';
            $return['errors'] = validation_errors('<div class="error">', '</div>');
            echo json_encode($return);
            die();
		}
		$role_data = array(
			'role_name' => $this->input->post('role')
		); 
		$clause = array(
			'role_id' => $this->input->post('ID')
		);
		$return['dataupdate'] = $this->user_role->update_role($role_data, $clause);
		if($return['dataupdate'] !== 'gagal')
		{
			$return['edit'] =  array($return['dataupdate'][0]['role_name']);
		}
		else
		{
			$dataerror = $this->user_role->get_roles($clause);
			$return['edit'] =  array($dataerror[0]['role_name']);
		}

		echo json_encode($return);
	}

	/*------------------------------------------------------------------------
	| Method : add_role
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : json
	| Description : controller untuk ajax
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function add_role()
	{
		$this->form_validation->set_rules('role_name', 'Nama Role', 'required');
        if($this->form_validation->run() == FALSE)
        {
        	$return['validation_error'] = 'validation error';
            $return['errors'] = validation_errors('<div class="error">', '</div>');
            echo json_encode($return);
            die();
		}
		$role_data = $this->input->post();
		$return['datainput'] = $this->user_role->add_role($role_data);
		if($return['datainput'] === 'gagal add')
		{
			$return['data_ada'] = "Role yang Anda masukkan telah ada, coba yang lain";
		}
		else
		{
			$return['sukses_add'] = 'sukses';
		}
		echo json_encode($return);
	}

	/**
	* USER ROLE
	*/

	/**
	* REVIEWER
	*/

	/*------------------------------------------------------------------------
	| Method : reviewer
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : array
	| Description : controller untuk menampilkan list user_role
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function reviewer($offset = 0)
	{
		/*
		* tentukan menu-menu sidebar ke dalam array $this->data['menu']
		*/
		$this->data['title'] = 'Reviewer'; 
		$this->data['menu'] = $this->get_sidebar_menu();
		$order = array(
			'rb_user' => array(
				'user_id'=>'ASC'
			)
		);//end menu

		/*
		* pagination
		*/
		$perpage = 2;
		$this->paginating("reviewers", "admin/users/reviewer/", 4, $perpage);//end pagination

		$this->data['reviewers'] =  $this->reviewers->get_reviewers('', $order, $perpage, $offset);

		$this->load->view('admin/users/reviewer', $this->data);
	}

	/*------------------------------------------------------------------------
	| Method : reviewer_activation
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : json
	| Description : controller untuk ajax
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function reviewer_activation()
	{
		$curstatus = $this->input->post('status');
		$user_id = $this->input->post('ID');
		$reviewer_name = $this->input->post('fullname');
		if($curstatus === 'active')
		{
			$reviewerdata = array(
				'reviewer_status' => 'inactive'
			);
			$data = $this->reviewers->update_reviewer_data($user_id, $reviewerdata);
			$return[0] =  '<span class="muted">'.$data['reviewer_status'].'</span>';
			$return['button_rel'] = 'aktifkan';
			$return['button_class'] = 'btn btn-primary active-reviewer';
			$return['button_text'] = '<i class="icon-ok icon-white"></i> activated';
			$return['input'] = array($user_id, $reviewer_name, ''.$data['reviewer_status'].'');
		}
		else
		{
			$reviewerdata = array(
				'reviewer_status' => 'active'
			);
			$data = $this->reviewers->update_reviewer_data($user_id, $reviewerdata);
			$return[0] =  '<span>'.$data['reviewer_status'].'</span>';
			$return['button_rel'] = 'non-aktifkan';
			$return['button_class'] = 'btn btn-warning deactive-reviewer';
			$return['button_text'] = '<i class="icon-remove icon-white"></i> deactivated';
			$return['input'] = array($user_id, $reviewer_name, ''.$data['reviewer_status'].'');
		}
		
		echo json_encode($return);
	}

	/*------------------------------------------------------------------------
	| Method : add_reviewer
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : json
	| Description : controller untuk ajax
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function add_reviewer()
	{
		$this->form_validation->set_rules('fullname', 'Reviewer Name', 'required');
        if($this->form_validation->run() == FALSE)
        {
        	$return['validation_error'] = 'validation error';
            $return['errors'] = validation_errors('<div class="error">', '</div>');
            echo json_encode($return);
            die();
		}
		$return['full name'] = $this->input->post('fullname');

		$this->data['users'] = $this->users->get_users('', '', NULL, NULL, "user_id, user_firstname, user_middlename, user_lastname");
		foreach ($this->data['users'] as $key => $value) {
			$name = $value['user_firstname'];
			if($value['user_middlename'] != '')
			{
				$name .= ' '.$value['user_middlename'];
			}
			if($value['user_lastname'] != '')
			{
				$name .= ' '.$value['user_lastname'];
			}
			$this->data['names'][$value['user_id']] = $name;
		}

		$return['userarr'] = $this->data['names'];
		$return['user_id_query'] = array_search($return['full name'], $this->data['names']);
		$reviewer_data = array(
			'user_id' => $return['user_id_query'],
			'reviewer_status' => 'active'
		);
		$return['datainput'] = $this->reviewers->add_reviewer($reviewer_data);
		if($return['datainput'] === 'gagal add')
		{
			$return['data_ada'] = "User yang Anda Masukkan telah menjadi reviewer atau tidak ada member dengan nama itu, coba yang lain";
		}
		else
		{
			$return['sukses_add'] = 'sukses';
		}
		echo json_encode($return);
	}

	/**
	* end REVIEWER
	*/

	/**
	* INVITATION
	*/
	public function invitation($offset = 0)
	{
		/*
		* tentukan menu-menu sidebar ke dalam array $this->data['menu']
		*/
		$this->data['title'] = 'Invitation'; 
		$this->data['menu'] = $this->get_sidebar_menu();
		$order = array(
			'rb_invitation' => array(
				'invitation_id'=>'ASC'
			)
		);//end menu

		/*
		* pagination
		*/
		$perpage = 2;

		$totalrow = count($this->users->get_invitations('', $order));
		/*
		* pagination
		*/
		$this->paginating($totalrow, "admin/users/invitation/", 4, $perpage);//end pagination

		$this->data['invitation'] =  $this->users->get_invitations('', $order, $perpage, $offset);

		foreach ($this->data['invitation'] as $key => $value) {
			$par = array(
				'rb_user' => array(
					'user_id'=>$value['invite_by']
				),
			);
			$this->data['users'][$key] =  $this->users->get_users($par, '', NULL, NULL, "user_id, user_firstname, user_middlename, user_lastname");
			foreach ($this->data['users'][$key] as $k => $v) {
				$name = $v['user_firstname'];
				if($v['user_middlename'] != '')
				{
					$name .= ' '.$v['user_middlename'];
				}
				if($v['user_lastname'] != '')
				{
					$name .= ' '.$v['user_lastname'];
				}
				$this->data['fullname'][$key][$k] = $name;
			}
		}

		/*echo "<pre>";
		print_r($this->data['fullname']);
		echo "</pre>";*/
		
		$this->load->view('admin/users/invitation', $this->data);
	}

	public function invite_new_member()
	{
		$this->form_validation->set_rules('invitation_name', 'Name', 'required');
		$this->form_validation->set_rules('invitation_email', 'Email', 'required|valid_emails');
        if($this->form_validation->run() == FALSE)
        {
        	$return['validation_error'] = 'validation error';
            $return['errors'] = validation_errors('<div class="error">', '</div>');
            echo json_encode($return);
            die();
		}
		$return['invite_by'] = $this->session->userdata('user_id');
		$return['full name'] = $this->input->post('invitation_name');
		$return['email'] = $this->input->post('invitation_email');

		$return['datainput'] = $this->users->invite_new($return['full name'], $return['email'], $return['invite_by']);
		if($return['datainput'] === 'gagal add')
		{
			$return['data_ada'] = "Orang yang Anda invite telah menjadi member atau telah diinvite";
		}
		else
		{
			$return['sukses_add'] = 'sukses';
		}
		echo json_encode($return);
	}

	public function invitation_quota($offset = 0)
	{
		/*
		* tentukan menu-menu sidebar ke dalam array $this->data['menu']
		*/
		$this->data['title'] = 'Invitation Quota'; 
		$this->data['menu'] = $this->get_sidebar_menu();
		$order = array(
			'user_id'=>'ASC'
		);//end menu

		/*
		* pagination
		*/
		$perpage = 2;
		$this->paginating('users', "admin/users/invitation_quota/", 4, $perpage);//end pagination

		$this->data['invitation'] =  $this->users->get_users('', $order, $perpage, $offset);
		foreach ($this->data['invitation'] as $k => $v) {
			$name = $v['user_firstname'];
			if($v['user_middlename'] != '')
			{
				$name .= ' '.$v['user_middlename'];
			}
			if($v['user_lastname'] != '')
			{
				$name .= ' '.$v['user_lastname'];
			}
			$this->data['fullname'][$k] = $name;
		}

		foreach ($this->data['invitation'] as $k => $v) {
			$par = array(
				'rb_invitation' => array(
					'invite_by'=>$v['user_id']
				),
			);
			$this->data['users'][$k] =  $this->users->get_invitations($par);
		}

		/*echo "<pre>";
		print_r($this->data['users']);
		echo "</pre>";*/
		
		$this->load->view('admin/users/invitation_quota', $this->data);
	}

	public function invitation_quota_add()
	{
		$quota = $this->input->post('user_invitation_quota');
		$user_id = $this->input->post('ID');

		$this->form_validation->set_rules('user_invitation_quota', 'Jumlah Quota', 'required|numeric');
        if($this->form_validation->run() == FALSE)
        {
        	$return['validation_error'] = 'validation error';
            $return['errors'] = validation_errors('<div class="error">', '</div>');
            echo json_encode($return);
            die();
		}

		$update_data = array('user_invite_quota'=>$quota);
		$clause = array('user_id'=>$user_id);
		$data = $this->users->update_invitation_quota($update_data, $clause);

		$return[0] =  $data[0]['user_invite_quota'];
		
		$return['input'] = array($user_id, $quota);
		
		echo json_encode($return);
	}


	/**
	* end INVITATION
	*/

	/**
	* MODAL
	*/
	public function get_modal_member()
	{
		//$this->data['fak'] = $this->fakultas->get_fakultas();
		$this->data['role'] = $this->user_role->get_roles();
		$this->load->view('admin/modals/add_user', $this->data);
	}

	public function get_modal_activation()
	{
		//$this->data['fak'] = $this->fakultas->get_fakultas();
		$this->load->view('admin/modals/activation');
	}

	public function get_modal_sent_account()
	{
		$this->load->view('admin/modals/sent_account');
	}

	public function get_modal_edit_user_role()
	{
		$this->data['role'] = $this->user_role->get_roles();
		$this->load->view('admin/modals/edit_user_role', $this->data);
	}

	public function get_modal_edit_role()
	{
		$this->data['role'] = $this->user_role->get_roles();
		$this->load->view('admin/modals/edit_role', $this->data);
	}

	public function get_modal_add_role()
	{
		$this->load->view('admin/modals/add_role');
	}

	public function get_modal_add_reviewer()
	{
		$this->data['names'] = array();
		$this->data['users'] = $this->users->get_users('', '', NULL, NULL, "user_id, user_firstname, user_middlename, user_lastname");
		foreach ($this->data['users'] as $key => $value) {
			$name = $value['user_firstname'];
			if($value['user_middlename'] != '')
			{
				$name .= ' '.$value['user_middlename'];
			}
			if($value['user_lastname'] != '')
			{
				$name .= ' '.$value['user_lastname'];
			}
			$this->data['names'][$key] = $name;
		}

		sort($this->data['names']);
		$this->load->view('admin/modals/add_reviewer', $this->data);
	}

	public function get_modal_admin()
	{
		$this->data['names'] = array();
		$this->data['users'] = $this->users->get_users('', '', NULL, NULL, "user_id, user_firstname, user_middlename, user_lastname");
		foreach ($this->data['users'] as $key => $value) {
			$name = $value['user_firstname'];
			if($value['user_middlename'] != '')
			{
				$name .= ' '.$value['user_middlename'];
			}
			if($value['user_lastname'] != '')
			{
				$name .= ' '.$value['user_lastname'];
			}
			$this->data['names'][$key] = $name;
		}

		sort($this->data['names']);
		$this->load->view('admin/modals/add_admin', $this->data);
	}

	public function get_modal_invitation_add()
	{
		$this->load->view('admin/modals/invitation', $this->data);
	}

	public function get_modal_invitation_quota()
	{
		$this->load->view('admin/modals/invitation_quota');
	}
	/**
	* end MODAL
	*/

	/**
	* USER TEMPLATES
	*/
	public function user_template()
	{
		/*
		* tentukan menu-menu sidebar ke dalam array $this->data['menu']
		*/
		$this->data['title'] = 'User Page Template'; 
		$this->data['menu'] = $this->get_sidebar_menu();
		$id = $this->session->userdata('user_id');
		$par = array(
			'rb_user' => array(
				'user_id' => $id
			)
		);

		$tableuser = $this->users->get_users($par, '', NULL, NULL, 'user_email, user_pass, jur_id, user_firstname, user_middlename, user_lastname, user_front_title, user_back_title');

		$jurusan = array();
		foreach ($tableuser as $key => $value) {
			$par = array(
				'rb_jurusan' => array(
					'jur_id'=>$value['jur_id']
				),
			);
			$jurusan =  $this->jurusan->get_jurusan($par, '', NULL, NULL, 'jur_name, fak_name');
		}

		$data_temp = array_merge($tableuser[0], $jurusan[0]);
		unset($data_temp['jur_id']);

		$data = array();
		foreach ($data_temp as $key => $value) {
			array_push($data, $key);
		}

		$pengganti = array("email", "password", "nama depan", "nama tengah", "nama belakang", "gelar depan", "gelar belakang", "jurusan", "fakultas");
		$this->data['data'] = array_combine($data, $pengganti);

		$groupby = array(
			'meta_key'
		);
		$select = "DISTINCT(meta_key)";
		$metadata = $this->metadata->get_meta_data(NULL, NULL, $groupby, NULL, NULL, $select);

		$meta_temp = array();
		foreach ($metadata as $key => $value) {
			array_push($meta_temp, $value['meta_key']);
		}
		$this->data['meta'] = array_flip($meta_temp);

		$par = array(
			'page_templ_page' => 'profile',
			'page_templ_status' => 'active'
		);

		$this->data['templ_all'] = $this->ptm->get_templates();
		$this->data['templ'] = $this->ptm->get_templates($par);

		/*echo '<pre>';
		print_r($this->data['data']);
		echo '</pre>';*/
		$this->load->view('admin/users/user_template', $this->data);
	}

	public function save_template()
	{
		$this->form_validation->set_rules('template-name', 'Template Name', 'required');
        if($this->form_validation->run() == FALSE)
        {
        	$return['validation_error'] = 'validation error';
            $return['errors'] = validation_errors('<div class="error">', '</div>');
            echo json_encode($return);
            die();
		}

		$par = array(
			'page_templ_page' => $this->input->post('page'),
			'page_templ_name' => $this->input->post('template-name'),
			'page_templ_content' => mysql_real_escape_string($this->input->post('content')),
			'page_templ_status' => 'active',
			'page_templ_config' => $this->input->post('config')
		);

		$return['data'] = $this->ptm->save_template($par);
		echo json_encode($return);
	}

	public function activate_template()
	{
		$clause = array(
			'page_templ_name'=> $this->input->post('page_templ_name'),
			'page_templ_page'=> 'profile'
		);
		$par = array(
			'page_templ_status'=> 'active'
		);
		$return['asd'] = 'asd';
		$return['update'] = $this->ptm->update_template($par, $clause);

		echo json_encode($return);
	}
	/**
	* end USER TEMPLATES
	*/

}

/*$usr = urlencode($value['user_firstname']);
echo uniqid($usr);
echo '<br />';*/

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */