<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jurusan_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->model('fakultas_model', 'fakultas');
	}
	
	/*------------------------------------------------------------------------
	| Method : get_jurusan
	|-------------------------------------------------------------------------
	| Paramater : $par - array(), $orderby - array()
	| Return : array
	| Description : mengambil data dari table jurusan
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function get_jurusan($par = '', $orderby = '', $limit = NULL, $offset = NULL, $select = NULL) {
		if($select !== NULL)
		{
			$this->db->select($select);
		}
		else
		{
			$this->db->select('*');
		}
		$this->db->from('rb_jurusan');
		$this->db->join('rb_fakultas', 'rb_fakultas.fak_id = rb_jurusan.fak_id');
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

	public function count()
    {
        return $this->db->count_all_results('rb_jurusan');
    }

	/*------------------------------------------------------------------------
	| Method : add_jurusan
	|-------------------------------------------------------------------------
	| Paramater : $par - array()
	| Return : array
	| Description : mamasukkan data dari table jurusan
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function add_jurusan($par = '') {
		$fetch = $this->get_jurusan($par);
		if(is_array($fetch))
		{
			return 'gagal add';
		}
		else
		{
			$arr = array();
			$arr[key($par['rb_fakultas'])] = $par['rb_fakultas'][key($par['rb_fakultas'])];
			$arr[key($par['rb_jurusan'])] = $par['rb_jurusan'][key($par['rb_jurusan'])];
			$this->db->insert('rb_jurusan', $arr);
			if($this->db->affected_rows() > 0)
			{
				$data = $this->get_jurusan($par);
				return $data;
			}
			else
			{
				return 'gagal';
			}
		}
	}

	/*------------------------------------------------------------------------
	| Method : del_jurusan
	|-------------------------------------------------------------------------
	| Paramater : $clause - array
	| Return : array
	| Description : hapus data dari jurusan
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function del_jurusan($clause = '') {
		$this->db->delete('rb_jurusan', $clause);
		return 'sukses_del';
	}

	/*------------------------------------------------------------------------
	| Method : edit_jurusan
	|-------------------------------------------------------------------------
	| Paramater : $par - array, $clause - array
	| Return : array
	| Description : edit data table jurusan
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function edit_jurusan($par = '', $clause = '') {
		$fetch = $this->get_jurusan($par);
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
			$arr2 = array();
			$arr2[key($par['rb_fakultas'])] = $par['rb_fakultas'][key($par['rb_fakultas'])];
			$arr2[key($par['rb_jurusan'])] = $par['rb_jurusan'][key($par['rb_jurusan'])];
			$this->db->update('rb_jurusan', $arr2);
			if($this->db->affected_rows() > 0)
			{
				$data = $this->get_jurusan($par);
				return $data;
			}
			else
			{
				return 'gagal';
			}
		}
	}

}