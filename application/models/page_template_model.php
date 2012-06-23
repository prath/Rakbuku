<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_template_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->model('projects_model', 'projects');
		$this->load->model('user_model', 'users');
	}

	public function get_templates($par = '') {
		$this->db->select('*');
		$this->db->from('rb_page_templ');
		if(is_array($par))
		{
			foreach ($par as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}

	public function save_template($par = '') {
		$arg = array(
			'page_templ_name' => $par['page_templ_name']
		);
		$gets = $this->get_templates($arg);
		if($gets[0]['page_templ_page'] == 'profile')
		{
			$this->db->where('page_templ_name', $par['page_templ_name']);
			$this->db->update('rb_page_templ', $par);
		}
		else
		{
			$gets = $this->get_templates();
			foreach ($gets as $key => $value) {
				if($value['page_templ_status'] == 'active')
				{
					$this->db->where('page_templ_id', $value['page_templ_id']);
					$this->db->where('page_templ_page', 'profile');
					$par1 = array(
						'page_templ_status'=> 'inactive'
					);
					$this->db->update('rb_page_templ', $par1);
				}
			}

			$this->db->insert('rb_page_templ', $par);
			$id = $this->db->insert_id();
			$par2 = array(
				'page_templ_id' => $id
			);

			return $this->get_templates($par2);
		}
	}

	public function update_template($par = '', $clause = '') {
		if(is_array($clause))
		{
			foreach ($clause as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		$this->db->update('rb_page_templ', $par);
		if($this->db->affected_rows() > 0)
		{
			$arg = array(
				'page_templ_status' => 'active',
				'page_templ_page' => 'profile'
			);
			$found = $this->get_templates($arg);

			foreach ($found as $key => $value) {
				if($value['page_templ_name'] == $clause['page_templ_name'] && $value['page_templ_page'] == $clause['page_templ_page'] )
				{
					continue ;
				}

				$this->db->where('page_templ_id', $value['page_templ_id']);
				$par1 = array(
					'page_templ_status'=> 'inactive'
				);
				$this->db->update('rb_page_templ', $par1);
			}

			return $data = $this->get_templates($clause);
		}
		else
		{
			return 'gagal';
		}
	}

}