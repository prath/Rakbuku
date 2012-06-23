<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'models/user_model.php');

class Reviewers_model extends User_model {

	function __construct() {
		parent::__construct();
	}

	/**
	* @Method : get_reviewers
	*
	* @Paramater : $par - array, $orderby - array, $limit, $offset
	* @Return : array
	* @Description : mengambil data reviewer
	* @Author : Pratama Hasriyan
	*/
	public function get_reviewers($par = '', $orderby = '', $limit = NULL, $offset = NULL)
	{
		$this->db->select('*');
		$this->db->from('rb_user');
		$this->db->join('rb_reviewer', 'rb_user.user_id=rb_reviewer.user_id');
		//$this->db->join('rb_role', 'rb_role.role_id=rb_user_role.role_id');
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
			$this->db->order_by(key($orderby).'.'.key($orderby[key($orderby)]), $orderby[key($orderby)][key($orderby[key($orderby)])]);
		}
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}

	public function count()
    {
        return $this->db->count_all_results('rb_reviewer');
    }

    /*------------------------------------------------------------------------
	| Method : Update_reviewer_data
	|-------------------------------------------------------------------------
	| Paramater : $user_id -- integer, $userdata -- array
	| Return : object
	| Description : update data  user di table rb_user atau 
	| 				menambahkan jika data belum tersedia.
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function update_reviewer_data($user_id, $reviewerdata) {

		$fields = '';

		foreach ($reviewerdata as $key => $value) {
			$fields .= $key.',';
		}
		$fields = substr($fields, 0,-1);

		$this->db->select($fields);
		$this->db->from('rb_reviewer');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0){
			$row = $query->result_array();
			//print_r($row[0]);
			$cek = 'true';
			foreach ($reviewerdata as $key => $value) {
				if($value !== $row[0][$key]){
					$cek = "false";
					break;
				}
			}
			if($cek =='true'){
				return $row[0];
			}else{
				$this->db->where('user_id', $user_id);
				$this->db->update('rb_reviewer', $reviewerdata);
				if($this->db->affected_rows()>0){
					$query = $this->db->get_where('rb_reviewer', array('user_id' => $user_id));
					if ($query->num_rows() > 0){
						$row = $query->result_array();
						return $row[0];
					}
				}
			}
		}else{
			//if needed an insert query, then put that here.		
		}
	}

	public function add_reviewer($user_data)
	{

		/*
$par = array(
			'rb_reviewer' => array(
				'user_id' => $user_data['user_id']
			)
		);

		$cekdata = $this->get_reviewers($par);
		//return $cekdata;
		if($cekdata[0]['user_id'] == $user_data['user_id'])
		{
			return "gagal add";
		}
		else
		{
*/
			$this->db->insert('rb_reviewer', $user_data);

			$user_id = $this->db->insert_id();
			return $user_id;
		//}
	}
	
	public function update_invitation($par = '', $clause = '') {
		
		if(is_array($clause))
		{
			foreach ($clause as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		$this->db->update('rb_reviewer', $par);
		if($this->db->affected_rows() > 0)
		{
			return $this->db->affected_rows();
		}
		else
		{
			return 'gagal';
		}
	}
	
	public function add_reviewer_project($user_data)
	{

		$this->db->insert('rb_reviewer', $user_data);
		if($this->db->affected_rows() > 0)
		{
			return $k = $this->db->insert_id();
		}
		else
		{
			return false;
		}
	}
	
	public function del_reviewer($clause = '') {
		$this->db->delete('rb_reviewer', $clause);	
	}



}