<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'controllers/admin/dashboard.php');

class Projects extends Dashboard {
	 
	public $data;
	public $fw_default_num = 4;

	function __construct() {
		parent::__construct();
		$this->load->model('projects_model', 'projects');
		$this->load->model('types_model', 'types');
		$this->load->model('topics_model', 'topics');
		$this->load->model('page_template_model', 'ptm');
		if(! $this->is_login())
		{
			redirect('admin/dashboard');
		}
	}
	
	public function index($offset=0)
	{
		/*
		* tentukan menu-menu sidebar ke dalam array $this->data['menu']
		*/
		$this->data['title'] = 'Projects'; 
		$this->data['menu'] = $this->get_sidebar_menu();

		$this->load->view('admin/projects/projects', $this->data);
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
			'title' => 'Projects',
			'menus' => array(
				'need_reviews' => 'Need-Review Projects',
				//'published' => 'Published Projects',
				//'drafts' => 'Draft Projects',
				//'unpublished' => 'Unpublished Projects',
				'project_types' => 'Project Types',
				//'topics' => 'Topics',
				//'project_data_template' => 'Project Data Template',
				'project_frameworks' => 'Project Frameworks'
			),
		);

		return $menu;
	}

	/**
	* PROJECT TYPES
	*/

	public function project_types($offset=0)
	{
		/*
		* tentukan menu-menu sidebar ke dalam array $this->data['menu']
		*/
		$this->data['title'] = 'Project Types'; 
		$this->data['menu'] = $this->get_sidebar_menu();
		$order = array(
			'type_id'=>'ASC'
		);//end menu

		/*
		* pagination
		*/
		$perpage = 2;

		$totalrow = count($this->types->get_types('', $order));
		
		$this->paginating($totalrow, "admin/projects/project_types/", 4, $perpage);//end pagination

		$this->data['types'] =  $this->types->get_types('', $order, $perpage, $offset);

		$this->load->view('admin/projects/types', $this->data);
	}

	public function add_type()
	{
		$this->form_validation->set_rules('type_name', 'Project Type', 'required');
        if($this->form_validation->run() == FALSE)
        {
        	$return['validation_error'] = 'validation error';
            $return['errors'] = validation_errors('<div class="error">', '</div>');
            echo json_encode($return);
            die();
		}
		
		$tp = $this->input->post('type_name');
		$slug = strtolower(str_replace(" ", "-", $tp));

		$par = array(
			'type_name'=>$this->input->post('type_name'),
			'type_slug'=>$slug
		);
		$return['datainput'] = $this->types->add_type($par);

		if($return['datainput'] === 'gagal add')
		{
			$return['data_ada'] = "Tipe Project yang Anda masukkan telah ada, coba yang lain";
		}
		else
		{
			$return['sukses_add'] = 'sukses';
		}
		echo json_encode($return);
	}

	public function edit_type()
	{
		$this->form_validation->set_rules('type_name', 'Nama Tipe', 'required');
        if($this->form_validation->run() == FALSE)
        {
        	$return['validation_error'] = 'validation error';
            $return['errors'] = validation_errors('<div class="error">', '</div>');
            echo json_encode($return);
            die();
		}

		$par = array(
			'type_name'=>$this->input->post('type_name')
		);
		$clause = array(
			'type_id'=>$this->input->post('ID')
		);

		$return['dataupdate'] = $this->types->edit_type($par, $clause);
		$return[0] =  $return['dataupdate'][0]['type_name'];
		
		$return['input'] = array($return['dataupdate'][0]['type_id'], $return[0]);

		echo json_encode($return);
	}

	public function del_type()
	{
		$type_id = $this->input->post('ID');
		$clause = array(
			'type_id'=>$type_id
		);
		$return['sukses_del'] = $this->types->del_type($clause);
		echo json_encode($return);
	}

	/**
	* end PROJECT TYPES
	*/

	/**
	* PROJECT TOPICS
	*/

	public function topics($offset=0)
	{
		/*
		* tentukan menu-menu sidebar ke dalam array $this->data['menu']
		*/
		$this->data['title'] = 'Project Topics'; 
		$this->data['menu'] = $this->get_sidebar_menu();
		$order = array(
			'topic_id'=>'ASC'
		);//end menu

		/*
		* pagination
		*/
		$perpage = 2;

		$totalrow = count($this->topics->get_topics('', $order));
		
		$this->paginating($totalrow, "admin/projects/topics/", 4, $perpage);//end pagination

		$this->data['topics'] =  $this->topics->get_topics('', $order, $perpage, $offset);

		$this->load->view('admin/projects/topics', $this->data);
	}

	public function add_topic()
	{
		$this->form_validation->set_rules('topic_name', 'Project Topics', 'required');
        if($this->form_validation->run() == FALSE)
        {
        	$return['validation_error'] = 'validation error';
            $return['errors'] = validation_errors('<div class="error">', '</div>');
            echo json_encode($return);
            die();
		}

		$par = array(
			'topic_name'=>$this->input->post('topic_name')
		);
		$return['datainput'] = $this->topics->add_topic($par);

		if($return['datainput'] === 'gagal add')
		{
			$return['data_ada'] = "Tipe Project yang Anda masukkan telah ada, coba yang lain";
		}
		else
		{
			$return['sukses_add'] = 'sukses';
		}
		echo json_encode($return);
	}

	public function edit_topic()
	{
		$this->form_validation->set_rules('topic_name', 'Nama Topic', 'required');
        if($this->form_validation->run() == FALSE)
        {
        	$return['validation_error'] = 'validation error';
            $return['errors'] = validation_errors('<div class="error">', '</div>');
            echo json_encode($return);
            die();
		}

		$par = array(
			'topic_name'=>$this->input->post('topic_name')
		);
		$clause = array(
			'topic_id'=>$this->input->post('ID')
		);

		$return['dataupdate'] = $this->topics->edit_topic($par, $clause);
		$return[0] =  $return['dataupdate'][0]['topic_name'];
		
		$return['input'] = array($return['dataupdate'][0]['topic_id'], $return[0]);

		echo json_encode($return);
	}

	public function del_topic()
	{
		$topic_id = $this->input->post('ID');
		$clause = array(
			'topic_id'=>$topic_id
		);
		$return['sukses_del'] = $this->topics->del_topic($clause);
		echo json_encode($return);
	}

	/**
	* end PROJECT TOPICS
	*/
	
	/**
	* NEED REVIEWS
	*/

	public function need_reviews($offset=0)
	{
		
		/*
		* tentukan menu-menu sidebar ke dalam array $this->data['menu']
		*/
		$this->data['title'] = 'Project Types'; 
		$this->data['menu'] = $this->get_sidebar_menu();
		//end menu

		/*
		* pagination
		*/
		$par = array(
			"rb_projects_state" => array(
				"project_state" => "admin review"
			)
		);
		$perpage = 2;

		$totalrow = count($this->projects_model->get_projects_state($par));
		
		//$this->paginating("projects_model", "home/index/", 3, $perpage);//end pagination
		$this->paginating_project($totalrow, "admin/projects/need_reviews/", 4, $perpage);//end pagination
		
		$this->data['need_reviews'] =  $this->projects_model->get_projects_need_review("admin review", "ASC", $perpage, $offset);
		$this->data['types'] = array();
		if( !empty($this->data['need_reviews']) ) {
			foreach( $this->data['need_reviews'] as $k => $v ) {
				$par = array(
						"type_id" => $v["type_id"]
				);
				$types =  $this->types->get_types($par);
				array_push($this->data['types'], $types[0]["type_name"]);
			}
		}
		
		/*
echo "<pre>";
		print_r($this->data["types"]);
		echo "</pre>";
*/

		$this->load->view('admin/projects/need_reviews', $this->data);
	}
	
	/**
	* END NEED REVIEWS
	*/
	
	/**
	* PROJECT FRAMEWORKS
	*/

	public function project_frameworks()
	{
		/*
		* tentukan menu-menu sidebar ke dalam array $this->data['menu']
		*/
		$this->data['title'] = 'Project Frameworks'; 
		$this->data['menu'] = $this->get_sidebar_menu();
		$order = array(
			'type_id'=>'ASC'
		);//end menu
		
		$this->data['types'] =  $this->types->get_types('', $order);
		
		$this->load->view('admin/projects/frameworks', $this->data);
	}
	
	public function load_frameworks($arg) {
		$this->data["par"] = $arg;
		$par = array(
			"rb_projects_fw" => array(
				"type_id" => $arg
			)	
		);
		$partype = array(
			"type_id" => $arg		
		);	
		
		$this->data['types'] =  $this->types->get_types($partype);
		
		$this->data["fw_data"] = $this->projects->get_projects_fw($par);
		$this->data["fw"] = unserialize($this->data["fw_data"][0]["fw"]);
		$countfw = count($this->data["fw"]);
		$diff = $countfw - $this->fw_default_num;
		
		if( $countfw == $this->fw_default_num ) {
			$this->data["slice"] = NULL;
		} else {
			if( $diff > 0 ) {
				$this->data["slice"] = array_slice($this->data["fw"], 2, $diff);
			}
		}
		
		$this->load->view( "admin/projects/ajax_fw", $this->data );
	}
	
	public function save_frameworks($arg) {
		$inputs = $this->input->post();
		$seri = serialize($inputs);
		$return["result"] = $seri;
		
		$par = array(
			"type_id" => $arg,
			"fw" => $seri
		);
		
		$return["result"] = $this->projects->add_projects_fw($par);
		
		echo json_encode($return);
	}
	
	/**
	* end PROJECT FRAMEWORKS
	*/

	/**
	* MODAL CONTROLLERS
	*/
	public function get_modal_add_type()
	{
		$this->load->view('admin/modals/add_type');
	}

	public function get_modal_edit_type()
	{
		$this->load->view('admin/modals/edit_type');
	}

	public function get_modal_del_type()
	{
		$this->load->view('admin/modals/del_type');
	}

	public function get_modal_add_topic()
	{
		$this->load->view('admin/modals/add_topic');
	}

	public function get_modal_edit_topic()
	{
		$this->load->view('admin/modals/edit_topic');
	}

	public function get_modal_del_topic()
	{
		$this->load->view('admin/modals/del_topic');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */