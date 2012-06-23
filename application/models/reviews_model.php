<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'models/user_model.php');

class Reviews_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->model('reviewers_model', 'reviewer');
	}
	
	
	/**
	* GET REVIEWS
	*/
	public function get_reviews($par = '', $orderby = '', $limit = NULL, $offset = NULL, $select = NULL) {
		if($select !== NULL)
		{
			$this->db->select($select);
		}
		else
		{
			$this->db->select('*');
		}
		$this->db->from('rb_review');
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
	* GET REVIEWS
	*/
	public function get_admin_reviews($par = '', $orderby = '', $limit = NULL, $offset = NULL, $select = NULL) {
		if($select !== NULL)
		{
			$this->db->select($select);
		}
		else
		{
			$this->db->select('*');
		}
		$this->db->from('rb_admin_review');
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
	* INSERT REVIEW
	*/
	public function add_review($data = '') {
		$this->db->insert('rb_review', $data);
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
	* INSERT REVIEW
	*/
	public function add_admin_review($data = '') {
		$this->db->insert('rb_admin_review', $data);
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
	* UPDATE PROJECT STATE
	*/
	/*
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
*/
	
	/**
	* DELETE PROJECT DATA
	*/
	/*
public function del_project($clause = '') {
		$this->db->delete('rb_projects', $clause);
		if($this->db->affected_rows() > 0)
		{
			return $k = $this->db->affected_rows();
		}
	}
*/
	
}