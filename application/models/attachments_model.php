<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attachments_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->model('versions_model', 'versions');
	}
	
	public function add_new_attachment($data = '') {
		$this->db->insert('rb_attachment', $data);
		if($this->db->affected_rows() > 0)
		{
			if( $this->db->affected_rows() == 1 ) {
				return $k = $this->db->insert_id();
			} else {
				return $k = $this->db->affected_rows();
			}
		}
		else
		{
			return false;
		}
	}
	
	public function add_new_attachment_version($data = '') {
		$this->db->insert('rb_attachment_versions', $data);
		if($this->db->affected_rows() > 0)
		{
			return $k = $this->db->affected_rows();
		}
		else
		{
			return false;
		}
	}
	
	/**
	* GET ATTACHMENT
	*/
	public function get_attachment_version($par = '', $orderby = '', $limit = NULL, $offset = NULL, $select = NULL) {
		if($select !== NULL)
		{
			$this->db->select($select);
		}
		else
		{
			$this->db->select('*');
		}
		$this->db->from('rb_attachment_versions');
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
	* GET ATTACHMENT
	*/
	public function get_attachments($par = '', $orderby = '', $limit = NULL, $offset = NULL, $select = NULL) {
		if($select !== NULL)
		{
			$this->db->select($select);
		}
		else
		{
			$this->db->select('*');
		}
		$this->db->from('rb_attachment');
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
	* DELETE ATTACHMENT
	*/
	public function del_attachment($clause = '') {
		$this->db->delete('rb_attachment', $clause);
		if($this->db->affected_rows() > 0)
		{
			return $k = $this->db->affected_rows();
		}
	}
	
	/**
	* DELETE ATTACHMENT VERSION
	*/
	public function del_attachment_version($clause = '') {
		$this->db->delete('rb_attachment_versions', $clause);
		if($this->db->affected_rows() > 0)
		{
			return $k = $this->db->affected_rows();
		}
	}
	

}