<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projects_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->model('user_model', 'user');
		$this->load->model('types_model', 'types');
		$this->load->model('topics_model', 'topics');
	}
	
	/**
	* GET PROJECT FRAMEWORKS
	*/
	public function get_projects_fw($par = '', $orderby = '', $limit = NULL, $offset = NULL, $select = NULL) {
		if($select !== NULL)
		{
			$this->db->select($select);
		}
		else
		{
			$this->db->select('*');
		}
		$this->db->from('rb_projects_fw');
		if(is_array($par))
		{
			foreach ($par as $key => $value) {
				foreach ($value as $k => $v) {
					$this->db->where($key.'.'.$k, $v);
				}
			}
		}

		if($limit !== NULL)
		{
			$this->db->limit($limit, $offset);
		}

		if(is_array($orderby))
		{
			$this->db->order_by(key($orderby), $orderby[key($orderby)]);
		}
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}
	
	
	
	/**
	* INSERT PROJECT FRAMEWORKS
	*/
	public function add_projects_fw($data = '') {
		$par = array(
			"rb_projects_fw" => array(
				"type_id" => $data["type_id"]
			)
		);
		$fetch = $this->get_projects_fw($par);
		
		if($fetch !== NULL)
		{
			$this->db->where("type_id", $data["type_id"]);
			$ins = array(
				"fw" => $data["fw"]
			);
			$this->db->update('rb_projects_fw', $ins);
			if($this->db->affected_rows() > 0)
			{
				$data = $this->get_projects_fw($par);
				return $data;
			}
		}
		else
		{
			$this->db->insert('rb_projects_fw', $data);
			if($this->db->affected_rows() > 0)
			{
				$k = $this->db->insert_id();
				$data[$k] = $data[key($data)];
				return $data;
			}
			else
			{
				return 'gagal';
			}
		}
	}
	
	/**
	* INSERT NEW PROJECT DATA
	*/
	public function add_new_project($data = '') {
		$this->db->insert('rb_projects', $data);
		if($this->db->affected_rows() > 0)
		{
			return $k = $this->db->insert_id();
		}
		else
		{
			return false;
		}
	}
	
	/**
	* INSERT NEW PROJECT STATE
	*/
	public function add_new_project_state($data = '') {
		$this->db->insert('rb_projects_state', $data);
		if($this->db->affected_rows() > 0)
		{
			return $k = $this->db->insert_id();
		}
		else
		{
			return false;
		}
	}
	
	/**
	* GET PROJECT STATE
	*/
	public function get_projects_state($par = '', $orderby = '', $limit = NULL, $offset = NULL, $select = NULL) {
		if($select !== NULL)
		{
			$this->db->select($select);
		}
		else
		{
			$this->db->select('*');
		}
		$this->db->from('rb_projects_state');
		if(is_array($par))
		{
			foreach ($par as $key => $value) {
				foreach ($value as $k => $v) {
					$this->db->where($key.'.'.$k, $v);
				}
			}
		}

		if($limit !== NULL)
		{
			$this->db->limit($limit, $offset);
		}

		if(is_array($orderby))
		{
			$this->db->order_by(key($orderby), $orderby[key($orderby)]);
		}
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}
	
	/**
	* UPDATE PROJECT STATE
	*/
	public function update_project_state($par = '', $clause = '') {
		
		if(is_array($clause))
		{
			foreach ($clause as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		$this->db->update('rb_projects_state', $par);
		if($this->db->affected_rows() > 0)
		{
			return $this->db->affected_rows();
		}
		else
		{
			return 'gagal';
		}
	}
	
	/**
	* GET PROJECT
	*/
	public function get_projects($par = '', $orderby = '', $limit = NULL, $offset = NULL, $select = NULL) {
		if($select !== NULL)
		{
			$this->db->select($select);
		}
		else
		{
			$this->db->select('*');
		}
		$this->db->from('rb_projects');
		if(is_array($par))
		{
			foreach ($par as $key => $value) {
				foreach ($value as $k => $v) {
					$this->db->where($key.'.'.$k, $v);
				}
			}
		}

		if($limit !== NULL)
		{
			$this->db->limit($limit, $offset);
		}

		if(is_array($orderby))
		{
			$this->db->order_by(key($orderby), $orderby[key($orderby)]);
		}
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}
	
	public function count_all_published($par = "", $val = "")
    {
    	if( !empty($par) && !empty($par)) {
	    	$this->db->where($par, $val);
    	}
    	$this->db->where('project_status', 'publish');
    	$this->db->from('rb_projects');
        return $this->db->count_all_results();
    }
    
    public function get_projects_need_review($par, $orderby, $limit, $offset) {
	    $this->db->select('*');
	    $this->db->from('rb_projects');
	    $this->db->join('rb_projects_state', 'rb_projects.project_id = rb_projects_state.project_id');
	    $this->db->where('rb_projects_state.project_state', $par);
	    $this->db->order_by('rb_projects.project_made', $orderby);
	    $this->db->limit($limit, $offset);
	    $query = $this->db->get();

		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
    }
	
	/**
	* UPDATE PROJECT DATA
	*/
	public function update_project($par = '', $clause = '') {
		
		if(is_array($clause))
		{
			foreach ($clause as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		$this->db->update('rb_projects', $par);
		if($this->db->affected_rows() > 0)
		{
			return $this->db->affected_rows();
		}
		else
		{
			return 'gagal';
		}
	}
	
	/**
	* DELETE PROJECT DATA
	*/
	public function del_project($clause = '') {
		$this->db->delete('rb_projects', $clause);
		if($this->db->affected_rows() > 0)
		{
			return $k = $this->db->affected_rows();
		}
	}
	
	public function search($keyword) {
		$this->db->select("*");
		$this->db->from('rb_projects');
		$this->db->where('rb_projects.project_parent', NULL);
	    $this->db->or_like('rb_projects.project_title', $keyword);
	    $this->db->or_like('rb_projects.project_jurusan', $keyword);
	    $this->db->or_like('rb_projects.project_fakultas', $keyword);
	    $this->db->or_like('rb_projects.project_keywords', $keyword);
	    $query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	} 

}