<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'controllers/base.php');

class Search extends Base {
	 
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
	public function index(){	
	
		$keyword = $this->input->post("keyword");
	
		$this->search($keyword);
			
		$this->load->view('search', $this->data);
	}
	
	public function search($keyword) {
		
		$this->data["search_result"] = $this->projects_model->search($keyword);
		//print_r($this->data["search_result"]);
		
		if( !empty($this->data["search_result"]) ) {
			$this->data["types"] = array();
			foreach( $this->data["search_result"] as $k => $v ) {
				
				$typepar = array(
					"type_id" => $v["type_id"]
				);
				
				$type = $this->types->get_types($typepar);
				array_push($this->data["types"], $type[0]["type_name"]);
			}
			$this->data["authors"] = array();
			foreach( $this->data["search_result"] as $k => $v ) {
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

/* End of file home.php */
/* Location: ./application/controllers/home.php */