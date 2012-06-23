<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Types_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	/*------------------------------------------------------------------------
	| Method : get_types
	|-------------------------------------------------------------------------
	| Paramater : $par - array
	| Return : array
	| Description : mengambil data dari table rb_type
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function get_types($par = '', $orderby = '', $limit = NULL, $offset = NULL) {
		$this->db->select('*');
		$this->db->from('rb_type');
		if(is_array($par))
		{
			foreach ($par as $key => $value) {
				$this->db->where($key, $value);
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

	/*------------------------------------------------------------------------
	| Method : add_type
	|-------------------------------------------------------------------------
	| Paramater : $par - array
	| Return : array
	| Description : memasukkan data ke table rb_type
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function add_type($par = '') {
		$fetch = $this->get_types($par);
		if(is_array($fetch))
		{
			return 'gagal add';
		}
		else
		{
			$this->db->insert('rb_type', $par);
			if($this->db->affected_rows() > 0)
			{
				$k = $this->db->insert_id();
				$data[$k] = $par[key($par)];
				return $data;
			}
			else
			{
				return 'gagal';
			}
		}
	}

	/*------------------------------------------------------------------------
	| Method : edit_type
	|-------------------------------------------------------------------------
	| Paramater : $par - array, $clause - array
	| Return : array
	| Description : mengedit data table rb_type
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function edit_type($par = '', $clause = '') {
		$fetch = $this->get_types($par);
		if(is_array($fetch))
		{
			return $fetch;
		}
		else
		{
			$arr = array();
			if(is_array($clause))
			{
				foreach ($clause as $key => $value) {
					$this->db->where($key, $value);
					array_push($arr, $value);
				}
			}
			$this->db->update('rb_type', $par);
			if($this->db->affected_rows() > 0)
			{
				$data = $this->get_types($par);
				return $data;
			}
			else
			{
				return 'gagal';
			}
		}
	}

	/*------------------------------------------------------------------------
	| Method : del_type
	|-------------------------------------------------------------------------
	| Paramater : $clause - array
	| Return : array
	| Description : menghapus data rb_type
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function del_type($clause = '') {
		$this->db->delete('rb_type', $clause);
		return 'sukses_del';
	}
	
}