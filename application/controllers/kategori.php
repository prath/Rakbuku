<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'controllers/base.php');

class Kategori extends Base {
	public $data = array();
	 
	function __construct() {
		parent::__construct();
	}

	public function _remap($judul, $offset = 0 ) {
		//echo $judul;
		$route = $this->get_project_per_type($judul);
		
		if( is_array($this->data["types_project"]) ) {
			if( !empty($offset) ) {
				$off = $offset[0];
			} else {
				$off = 0;
			}
			$this->get_projects($judul, $this->data["types_project"][0]["type_id"], $off);
			$this->load->view("kategori", $this->data);
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
	
	public function get_project_per_type($type) {
		$par = array(
			"type_slug" => $type
		);
		
		$this->data["types_project"] = $this->types->get_types($par);
	}
	
	public function get_projects($type, $type_id, $offset) {
		/*
		* pagination
		*/
		$perpage = 4;
		$this->paginating("projects_model", "kategori/".$type, 3, $perpage, "type_id", $type_id);//end pagination
		
		$order = array(
			'project_made'=>'ASC'
		);
		
		$par = array(
			"rb_projects" => array(
				"project_status" => "publish",
				"type_id" => $type_id
			)
		);
		$this->data["projects"] = $this->projects_model->get_projects($par, $order, $perpage, $offset);
		
		$this->data["authors"] = array();
		if( !empty($this->data["projects"]) ) {
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
	}
	
	public function paginating($mdl, $path, $urisegment, $perpage, $where = "", $val = "") {
		$config['base_url'] = site_url($path);
        if(gettype($mdl) === 'integer')
        {
        	$config['total_rows'] = $mdl;
        }
        else
        {
        	$config['total_rows'] = $this->$mdl->count_all_published($where, $val);
        }
        $config['uri_segment'] = $urisegment;
        $config['per_page'] = $perpage; 
        $this->pagination->initialize($config); 
		$this->data['pagination'] = $this->pagination->create_links();


    } 
	
	
}