<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	 
	function __construct() {
		parent::__construct();
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache"); 
		
		$role = $this->session->userdata('role_name');

		if($this->is_login())
		{
			if(! ($role === 'admin'))
			{
				redirect('/');
			}
		}
	}
	
	public function index()
	{
		if($this->is_login())
		{
			$this->data['title'] = 'Dashboard'; 
			$this->load->view("admin/dashboard", $this->data);
		}
		else
		{
			$this->load->view("admin/login");
		}

	}

	/*------------------------------------------------------------------------
	| Method : login
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : void
	| Description : controller login 
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function login()
	{
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
		$role = $this->session->userdata('role_name');
		if($this->form_validation->run() == FALSE && $role == '') {
			$this->load->view('admin/login');
		} else {
			$email = $this->input->post('email');
			$pass = md5($this->input->post('password'));
			$par = array(
				'ru.user_email' => $email,
				'ru.user_pass' => $pass,
				'rr.role_name' => 'admin'
			);
			$userdata = $this->user_model->do_login($par);
			if(!$userdata){
				$data['salah'] = "Password atau Username Salah";
				$this->load->view('admin/login', $data);
			}else {
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
				redirect('admin/dashboard');	
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
		$this->session->set_flashdata('redirectToCurrent', current_url());
		$this->session->sess_destroy();
		redirect('admin/dashboard');
		//redirect('/');
	}

	/*------------------------------------------------------------------------
	| Method : is_login
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : boolean
	| Description : mengecek apakah user telah melakukan login atau belum
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function is_login() {
		$userlogin =  $this->session->userdata('logged_in');
		if($userlogin == ''){
			return false;
		}
		else {
			return true;
		}
	}

	/*------------------------------------------------------------------------
	| Method : paginating
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : void
	| Description : menampilkan pagination berdasarkan paramater confgnya.
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/

	public function paginating($mdl, $path, $urisegment, $perpage)
    {
        $config['base_url'] = site_url($path);
        if(gettype($mdl) === 'integer')
        {
        	$config['total_rows'] = $mdl;
        }
        else
        {
        	$config['total_rows'] = $this->$mdl->count();
        }
        $config['uri_segment'] = $urisegment;
        $config['per_page'] = $perpage; 
        $this->pagination->initialize($config); 
		$this->data['pagination'] = $this->pagination->create_links();
    } 
    
    public function paginating_project($mdl, $path, $urisegment, $perpage) {
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

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */