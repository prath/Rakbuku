<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_meta_model extends CI_Model {
	public $initial;
	public $prefix = "rb_";
	
	function __construct() {
		parent::__construct();
	}

	public function initialize($model_rel, $initial = NULL){
		if($initial == NULL){
			$this->initial = $model_rel;
			$this->load->model($model_rel.'_model', $this->initial);
		}	
		else{
			$this->initial = $model_rel;
			$this->load->model($model_rel.'_model', $this->initial);
		}
	}

	public function get_meta_data($par = NULL, $orderby = NULL, $groupby = NULL, $limit = NULL, $offset = NULL, $select = NULL) {
		if($select !== NULL)
		{
			$this->db->select($select);
		}
		else
		{
			$this->db->select('*');
		}
		$this->db->from('rb_user_meta');

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

		if(is_array($groupby))
		{
			$this->db->group_by($groupby); 
		}
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}

}