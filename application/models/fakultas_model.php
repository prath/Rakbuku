<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fakultas_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	/*------------------------------------------------------------------------
	| Method : get_fakultas
	|-------------------------------------------------------------------------
	| Paramater : $par - array
	| Return : array
	| Description : mengambil data dari table fakultas
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function get_fakultas($par = '', $orderby = '', $limit = NULL, $offset = NULL) {
		$this->db->select('*');
		$this->db->from('rb_fakultas');
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

	public function count()
    {
        return $this->db->count_all_results('rb_fakultas');
    }

	/*------------------------------------------------------------------------
	| Method : add_fakultas
	|-------------------------------------------------------------------------
	| Paramater : $par - array
	| Return : array
	| Description : mengambil data dari table fakultas
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function add_fakultas($par = '') {
		$fetch = $this->get_fakultas($par);
		if(is_array($fetch))
		{
			return 'gagal add';
		}
		else
		{
			$this->db->insert('rb_fakultas', $par);
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
	| Method : edit_fakultas
	|-------------------------------------------------------------------------
	| Paramater : $par - array, $clause - array
	| Return : array
	| Description : mengambil data dari table fakultas
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function edit_fakultas($par = '', $clause = '') {
		$fetch = $this->get_fakultas($par);
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
			$this->db->update('rb_fakultas', $par);
			if($this->db->affected_rows() > 0)
			{
				$data = $this->get_fakultas($par);
				return $data;
			}
			else
			{
				return 'gagal';
			}
		}
	}

	/*------------------------------------------------------------------------
	| Method : del_fakultas
	|-------------------------------------------------------------------------
	| Paramater : $clause - array
	| Return : array
	| Description : mengambil data dari table fakultas
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function del_fakultas($clause = '') {
		$this->db->delete('rb_jurusan', $clause);
		$this->db->delete('rb_fakultas', $clause);
		return 'sukses_del';
	}
}