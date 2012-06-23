<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/base.php');

class Home extends Base {
	public $data = array();
	 
	function __construct() {
		parent::__construct();
		
	}
	
	/*------------------------------------------------------------------------
	| Method : index
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : void
	| Description : home index
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function index($offset = 0){
		/*
		* pagination
		*/
		$perpage = 4;
		$this->paginating("projects_model", "home/index/", 3, $perpage);//end pagination
		
		$order = array(
			'project_made'=>'DESC'
		);
		
		$par = array(
			"rb_projects" => array(
				"project_status" => "publish"
			)
		);
		$this->data["projects"] = $this->projects_model->get_projects($par, $order, $perpage, $offset);
		
		if( !empty($this->data["projects"]) ) {
			$this->data["types"] = array();
			foreach( $this->data["projects"] as $k => $v ) {
				$typepar = array(
					"type_id" => $v["type_id"]
				);
				
				$type = $this->types->get_types($typepar);
				array_push($this->data["types"], $type[0]["type_name"]);
			}
			$this->data["authors"] = array();
			foreach( $this->data["projects"] as $k => $v ) {
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
		
		$this->load->view('home', $this->data);
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
    
    public function test() {
	    
	    
	    
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */