<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'controllers/admin/dashboard.php');

class Jurusan extends Dashboard {
	 
	public $data;

	function __construct() {
		parent::__construct();
		$this->load->model('jurusan_model', 'jurusan');
		if(! $this->is_login())
		{
			redirect('admin/dashboard');
		}
	}
	
	public function index($offset = 0)
	{
		/*
		* tentukan menu-menu sidebar ke dalam array $this->data['menu']
		*/
		$this->data['title'] = 'Jurusan'; 
		$this->data['menu'] = $this->get_sidebar_menu();

        $perpage = 2;
		$this->paginating("jurusan", "admin/jurusan/index/", 4, $perpage);

		$order = array(
			'jur_id'=>'ASC'
		);
		$this->data['datajur'] = $this->jurusan->get_jurusan('', $order, $perpage, $offset);
		
		$this->load->view('admin/jurusan/jurusan', $this->data);
	}

	/*------------------------------------------------------------------------
	| Method : fakultas
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : array
	| Description : controller untuk menampilkan list fak
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function fakultas($offset = 0)
	{
		$this->data['title'] = 'Fakultas'; 

		$perpage = 2;
		$this->paginating("fakultas", "admin/jurusan/fakultas/", 4, $perpage);

		$order = array(
			'fak_id'=>'ASC'
		);
		$this->data['datafak'] = $this->fakultas->get_fakultas('', $order, $perpage, $offset);
		$this->data['menu'] = $this->get_sidebar_menu();
		$this->load->view('admin/jurusan/fakultas', $this->data);
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
			'title' => 'Jurusan/Program Studi',
			'menus' => array(
				'' => 'Jurusan',
				'fakultas' => 'Fakultas'
			),
		);

		return $menu;
	}

	/*------------------------------------------------------------------------
	| Method : add_fakultas
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : html
	| Description : controller untuk menambahkan data fakultas
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function add_fakultas()
	{
		$this->form_validation->set_rules('fak_name', 'Fakultas', 'required');
        if($this->form_validation->run() == FALSE)
        {
        	$return['validation_error'] = 'validation error';
            $return['errors'] = validation_errors('<div class="error">', '</div>');
            echo json_encode($return);
            die();
		}

		$par = array(
			'fak_name'=>$this->input->post('fak_name')
		);
		$return['datainput'] = $this->fakultas->add_fakultas($par);

		if($return['datainput'] === 'gagal add')
		{
			$return['data_ada'] = "Fakultas yang Anda masukkan telah ada, coba yang lain";
		}
		else
		{
			$return['sukses_add'] = 'sukses';
		}
		echo json_encode($return);
	}

	/*------------------------------------------------------------------------
	| Method : edit_fakultas
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : html
	| Description : controller untuk mengedit data fakultas
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function edit_fakultas()
	{
		$this->form_validation->set_rules('fak_name', 'Nama Fakultas', 'required');
        if($this->form_validation->run() == FALSE)
        {
        	$return['validation_error'] = 'validation error';
            $return['errors'] = validation_errors('<div class="error">', '</div>');
            echo json_encode($return);
            die();
		}

		$par = array(
			'fak_name'=>$this->input->post('fak_name')
		);
		$clause = array(
			'fak_id'=>$this->input->post('ID')
		);

		$return['dataupdate'] = $this->fakultas->edit_fakultas($par, $clause);
		$return[0] =  $return['dataupdate'][0]['fak_name'];
		
		$return['input'] = array($return['dataupdate'][0]['fak_id'], $return[0]);

		echo json_encode($return);
	}

	/*------------------------------------------------------------------------
	| Method : del_fakultas
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : html
	| Description : controller untuk delete data fakultas
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function del_fakultas()
	{
		$fak_id = $this->input->post('ID');
		$clause = array(
			'fak_id'=>$fak_id
		);
		$return['sukses_del'] = $this->fakultas->del_fakultas($clause);
		echo json_encode($return);
	}

	/*------------------------------------------------------------------------
	| Method : get_modal_jurusan
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : html
	| Description : controller untuk meload file view untuk di load menggunakan load() jquery
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function get_modal_jurusan()
	{
		$this->data['fak'] = $this->fakultas->get_fakultas();
		$this->load->view('admin/modals/jurusan', $this->data);
	}

	public function get_modal_edit_jurusan()
	{
		$this->data['fak'] = $this->fakultas->get_fakultas();
		$this->load->view('admin/modals/edit_jurusan', $this->data);
	}

	public function get_modal_del_jurusan()
	{
		$this->load->view('admin/modals/del_jurusan');
	}

	/*------------------------------------------------------------------------
	| Method : get_modal_fakultas
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : html
	| Description : controller untuk meload file view untuk di load menggunakan load() jquery
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function get_modal_fakultas()
	{
		$this->load->view('admin/modals/fakultas');
	}

	public function get_modal_edit_fakultas()
	{
		$this->load->view('admin/modals/edit_fakultas');
	}

	public function get_modal_del_fakultas()
	{
		$this->load->view('admin/modals/del_fakultas');
	}

	/*------------------------------------------------------------------------
	| Method : add_jurusan
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : html
	| Description : controller untuk menambahkan data jurusan
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function add_jurusan()
	{
		$this->form_validation->set_rules('fak_id', 'Fakultas', 'required');
		$this->form_validation->set_rules('name', 'Nama Jurusan', 'required');
        if($this->form_validation->run() == FALSE)
        {
        	$return['validation_error'] = 'validation error';
            $return['errors'] = validation_errors('<div class="error">', '</div>');
            echo json_encode($return);
            die();
		}

		$jur_name = $this->input->post('name');
		$fak_id = $this->input->post('fak_id');
		$par = array(
			'rb_fakultas' => array(
				'fak_id'=>$fak_id
			),
			'rb_jurusan' => array(
				'jur_name'=>$jur_name
			)
		);

		$return['datainput'] = $this->jurusan->add_jurusan($par);
		if($return['datainput'] === 'gagal add')
		{
			$return['data_ada'] = "Jurusan yang Anda masukkan telah ada, coba yang lain";
		}
		else
		{
			$return['sukses_add'] = 'sukses';
		}

		echo json_encode($return);
	}

	/*------------------------------------------------------------------------
	| Method : del_jurusan
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : html
	| Description : controller untuk delete data jurusan
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function del_jurusan()
	{
		$jur_id = $this->input->post('ID');
		$clause = array(
			'jur_id'=>$jur_id
		);
		$return['sukses_del'] = $data = $this->jurusan->del_jurusan($clause);
		echo json_encode($return);
	}

	/*------------------------------------------------------------------------
	| Method : edit_jurusan
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : html
	| Description : controller untuk mengedit data jurusan
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function edit_jurusan()
	{
		$this->form_validation->set_rules('fak_id', 'Fakultas', 'required');
		$this->form_validation->set_rules('jur_name', 'Nama Jurusan', 'required');
        if($this->form_validation->run() == FALSE)
        {
        	$return['validation_error'] = 'validation error';
            $return['errors'] = validation_errors('<div class="error">', '</div>');
            echo json_encode($return);
            die();
		}

		$jur_name = $this->input->post('jur_name');
		$jur_id = $this->input->post('ID');
		$fak_id = $this->input->post('fak_id');
		$fak_name = $this->input->post('fak_name');
		$par = array(
			'rb_fakultas' => array(
				'fak_id'=>$fak_id
			),
			'rb_jurusan' => array(
				'jur_name'=>$jur_name
			)
		);

		$clause = array(
			'jur_id'=>$jur_id
		);

		$return['dataupdate'] = $this->jurusan->edit_jurusan($par, $clause);
		$return[0] =  $return['dataupdate'][0]['jur_name'];
		$return[1] =  $return['dataupdate'][0]['fak_name'];
		
		$return['input'] = array($jur_id, $jur_name, $return[1]);

		echo json_encode($return);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */