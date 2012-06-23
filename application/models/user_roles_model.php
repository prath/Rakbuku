<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_roles_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	/*------------------------------------------------------------------------
	| Method : get_user_roles
	|-------------------------------------------------------------------------
	| Paramater : $par - array(), $orderby - array()
	| Return : array
	| Description : mengambil data user roles semua.
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function get_user_roles($par = '', $orderby = '', $limit = NULL, $offset = NULL) {
		$this->db->select('*');
		$this->db->from('rb_role');
		$this->db->join('rb_user_role', 'rb_role.role_id = rb_user_role.role_id');
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

	/*------------------------------------------------------------------------
	| Method : get_roles
	|-------------------------------------------------------------------------
	| Paramater : $par - array(), $orderby - array()
	| Return : array
	| Description : mengambil data user roles semua.
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function get_roles($par = '', $orderby = '', $limit = NULL, $offset = NULL, $select = NULL) {
		if($select !== NULL)
		{
			$this->db->select($select);
		}
		else
		{
			$this->db->select('*');
		}
		$this->db->from('rb_role');
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
        return $this->db->count_all_results('rb_role');
    }

	/*------------------------------------------------------------------------
	| Method : add_user_role
	|-------------------------------------------------------------------------
	| Paramater : user_data - array
	| Return : array
	| Description : memasukkan data user baru
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function add_user_role($user_role_data)
	{
		//id, email, pass, registered, activationkey, jurid, uniqueurl, firstname, middlename, lastname, fronttitle, backtitle, status.

		$this->db->insert('rb_user_role', $user_role_data);
	}

	/*------------------------------------------------------------------------
	| Method : update_user_role
	|-------------------------------------------------------------------------
	| Paramater : user_data - array
	| Return : array
	| Description : edit data user role
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function update_user_role($par = '', $clause = '')
	{
		if(is_array($clause))
		{
			foreach ($clause as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		$this->db->update('rb_user_role', $par);
		if($this->db->affected_rows() > 0)
		{
			$par2 = array(
				'rb_user_role' => $par,
				'rb_user_role' => $clause
			);
			$data = $this->get_user_roles($par2);
			return $data;
		}
		else
		{
			return 'gagal';
		}
	}

	/*------------------------------------------------------------------------
	| Method : update_role
	|-------------------------------------------------------------------------
	| Paramater : user_data - array
	| Return : array
	| Description : edit data role
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function update_role($par = '', $clause = '')
	{
		if(is_array($clause))
		{
			foreach ($clause as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		$this->db->update('rb_role', $par);
		if($this->db->affected_rows() > 0)
		{
			$data = $this->get_roles($clause);
			return $data;
		}
		else
		{
			return 'gagal';
		}
	}

	/*------------------------------------------------------------------------
	| Method : add_role
	|-------------------------------------------------------------------------
	| Paramater : role_data - array
	| Return : array
	| Description : memasukkan data role baru
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function add_role($role_data)
	{
		//role_id, role_name

		$par = array(
			'role_name' => $role_data['role_name']
		);
		$cekdata = $this->get_roles($par);

		if($cekdata[0]['role_name'] === $role_data['role_name'])
		{
			return "gagal add";
		}
		else
		{
			$this->db->insert('rb_role', $role_data);
			$role_id = $this->db->insert_id();
			return $role_id;
		}
	}

	public function add_admin($admin_data, $clause)
	{
		//id, email, pass, registered, activationkey, jurid, uniqueurl, firstname, middlename, lastname, fronttitle, backtitle, status.

		$par = array(
			'rb_user_role' => array(
				'user_id' => $clause['user_id'],
				'role_id' => $admin_data['role_id']
			)
		);

		$cekdata = $this->get_user_roles($par);
		//return $cekdata;
		if($cekdata[0]['user_id'] == $clause['user_id'])
		{
			return "gagal add";
		}
		else
		{
			if(is_array($clause))
			{
				foreach ($clause as $key => $value) {
					$this->db->where($key, $value);
				}
			}
			$this->db->update('rb_user_role', $admin_data);		}
	}

}