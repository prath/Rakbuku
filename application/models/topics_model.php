<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Topics_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	/*------------------------------------------------------------------------
	| Method : get_topics
	|-------------------------------------------------------------------------
	| Paramater : $par - array
	| Return : array
	| Description : mengambil data dari table rb_topic
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function get_topics($par = '', $orderby = '', $limit = NULL, $offset = NULL) {
		$this->db->select('*');
		$this->db->from('rb_topic');
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
	| Method : add_topic
	|-------------------------------------------------------------------------
	| Paramater : $par - array
	| Return : array
	| Description : memasukkan data ke table rb_topic
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function add_topic($par = '') {
		$fetch = $this->get_topics($par);
		if(is_array($fetch))
		{
			return 'gagal add';
		}
		else
		{
			$this->db->insert('rb_topic', $par);
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
	| Method : edit_topic
	|-------------------------------------------------------------------------
	| Paramater : $par - array, $clause - array
	| Return : array
	| Description : mengedit data table rb_topic
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function edit_topic($par = '', $clause = '') {
		$fetch = $this->get_topics($par);
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
			$this->db->update('rb_topic', $par);
			if($this->db->affected_rows() > 0)
			{
				$data = $this->get_topics($par);
				return $data;
			}
			else
			{
				return 'gagal';
			}
		}
	}

	/*------------------------------------------------------------------------
	| Method : del_topic
	|-------------------------------------------------------------------------
	| Paramater : $clause - array
	| Return : array
	| Description : menghapus data rb_topic
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function del_topic($clause = '') {
		$this->db->delete('rb_topic', $clause);
		return 'sukses_del';
	}
	
}