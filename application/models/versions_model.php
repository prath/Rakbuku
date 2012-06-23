<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Versions_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	/**
	* INSERT VERSION ATTACHMENT
	*/
	public function add_new_version($data = '') {
		$this->db->insert('rb_versions', $data);
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
	
	/**
	* GET VERSIONS
	*/
	public function get_versions($par = '', $orderby = '', $limit = NULL, $offset = NULL, $select = NULL) {
		if($select !== NULL)
		{
			$this->db->select($select);
		}
		else
		{
			$this->db->select('*');
		}
		$this->db->from('rb_versions');
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
	
	public function update_versions($par = '', $clause = '') {
		
		if(is_array($clause))
		{
			foreach ($clause as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		$this->db->update('rb_versions', $par);
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
	* DELETE VERSION
	*/
	public function del_version($clause = '') {
		$this->db->delete('rb_versions', $clause);
		if($this->db->affected_rows() > 0)
		{
			return $k = $this->db->affected_rows();
		}
	}
}