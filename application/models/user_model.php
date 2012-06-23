<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->model('jurusan_model', 'jurusan');
		$this->load->model('User_roles_model', 'user_role');
	}

	/*------------------------------------------------------------------------
	| Method : get_users
	|-------------------------------------------------------------------------
	| Paramater : $par - array(), $orderby - array()
	| Return : array
	| Description : mengambil data users semua.
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function get_users($par = '', $orderby = '', $limit = NULL, $offset = NULL, $select = NULL) {
		if($select !== NULL)
		{
			$this->db->select($select);
		}
		else
		{
			$this->db->select('*');
		}
		$this->db->from('rb_user');
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
	
	public function update_user($par = '', $clause = '') {
		
		if(is_array($clause))
		{
			foreach ($clause as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		$this->db->update('rb_user', $par);
		if($this->db->affected_rows() > 0)
		{
			return $this->db->affected_rows();
		}
		else
		{
			return 'gagal';
		}
	}

	/*------------------------------------------------------------------------
	| Method : get_users
	|-------------------------------------------------------------------------
	| Paramater : $par - array(), $orderby - array()
	| Return : array
	| Description : mengambil data users semua.
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function get_users_w_roles($par = '', $orderby = '', $limit = NULL, $offset = NULL, $select = NULL) {
		if($select !== NULL)
		{
			$this->db->select($select);
		}
		else
		{
			$this->db->select('*');
		}
		$this->db->from('rb_user');
		$this->db->join('rb_user_role', 'rb_user.user_id=rb_user_role.user_id');
		$this->db->join('rb_role', 'rb_user_role.role_id=rb_role.role_id');
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
        return $this->db->count_all_results('rb_user');
    }
	
	/*------------------------------------------------------------------------
	| Method : is_login
	|-------------------------------------------------------------------------
	| Paramater : void
	| Return : boolean
	| Description : mengecek apakah user telah melakukan login atau belum
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function is_login() {
		$userlogin =  $this->session->userdata('logged_in');
		if($userlogin == ''){
			return false;
		}
		else {
			return true;
		}
	}
	
	/*------------------------------------------------------------------------
	| Method : do_login
	|-------------------------------------------------------------------------
	| Paramater : $email, $pass
	| Return : object
	| Description : login
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function do_login($par) {
		$this->db->select("*");
		$this->db->from('rb_user ru');
		$this->db->join('rb_user_role rur', 'rur.user_id = ru.user_id');
		$this->db->join('rb_role rr', 'rr.role_id = rur.role_id');
		foreach ($par as $key => $value) {
			$this->db->where($key, $value);
		}
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $row = $query->row();
		}
	}
	
	/*------------------------------------------------------------------------
	| Method : check_uurl
	|-------------------------------------------------------------------------
	| Paramater : uurl -- user unique url
	| Return : boolean
	| Description : check apakah url user tersedia ataukah tidak.
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function check_uurl($uurl) {
		$this->db->select('*');
		$this->db->from('rb_user');
		$this->db->where('user_unique_url', $uurl);
		$this->db->or_where('user_activation_key', $uurl); 
		$query = $this->db->get();
		//$query = $this->db->get_where('rb_user', array('user_unique_url' => $uurl));
		if ($query->num_rows() > 0){
			return true;
		}
	}

	/*------------------------------------------------------------------------
	| Method : get_user_data
	|-------------------------------------------------------------------------
	| Paramater : userdata -- userdata -- user_activation_code atau 
	| 			  user_unique_url
	| Return : object
	| Description : mengambil data user.
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function get_user_data($userdata) {
		$this->db->select('*');
		$this->db->from('rb_user');
		// $this->db->join('rb_user_meta', 'rb_user_meta.user_id = rb_user.user_id');
		$this->db->where('rb_user.user_unique_url', $userdata);
		$this->db->or_where('rb_user.user_activation_key', $userdata); 
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $row = $query->result_array();
		}
	}

	/*------------------------------------------------------------------------
	| Method : get_user_metas
	|-------------------------------------------------------------------------
	| Paramater : userdata -- user_activation_code atau user_unique_url
	| Return : object
	| Description : mengambil data user meta.
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function get_user_metas($userdata) {
		$this->db->select('rb_user_meta.meta_value, rb_user_meta.meta_key');
		$this->db->from('rb_user_meta');
		$this->db->join('rb_user', 'rb_user.user_id = rb_user_meta.user_id');
		$this->db->where('rb_user.user_unique_url', $userdata);
		$this->db->or_where('rb_user.user_activation_key', $userdata); 
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			$row = $query->result_array();
			//print_r($row);
			$metaarr1 = array();
			$metaarr2 = array();
			foreach ($row as $key => $value) {
				foreach ($value as $k => $v) {
					if($k == 'meta_key'){
						array_push($metaarr1, $v);
					}else{
						array_push($metaarr2, $v);
					}
				} 
			}
			return $metaarr = array_combine($metaarr1, $metaarr2);
		}
	}

	/*------------------------------------------------------------------------
	| Method : Update_user_data
	|-------------------------------------------------------------------------
	| Paramater : $user_id -- integer, $userdata -- array
	| Return : object
	| Description : update data  user di table rb_user atau 
	| 				menambahkan jika data belum tersedia.
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function update_user_data($user_id, $userdata) {

		$fields = '';

		foreach ($userdata as $key => $value) {
			$fields .= $key.',';
		}
		$fields = substr($fields, 0,-1);


		$this->db->select($fields);
		$this->db->from('rb_user');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0){
			$row = $query->result_array();
			
			$cek = 'true';
			foreach ($userdata as $key => $value) {
				if($value !== $row[0][$key]){
					$cek = "false";
					break;
				}
			}
			if($cek =='true'){
				return $row[0];
			}else{
				$this->db->where('user_id', $user_id);
				$this->db->update('rb_user', $userdata);
				if($this->db->affected_rows()>0){
					$query = $this->db->get_where('rb_user', array('user_id' => $user_id));
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

	/*------------------------------------------------------------------------
	| Method : Update_user_meta
	|-------------------------------------------------------------------------
	| Paramater : $meta_key, $meta_value, $user_id
	| Return : object
	| Description : update data meta user di table meta_user atau 
	| 				menambahkan jika data meta belum tersedia.
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function update_user_meta($meta_key, $meta_value, $user_id) {

		$this->db->select('*');
		$this->db->from('rb_user_meta');
		$this->db->where('meta_key', $meta_key);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();

		if ($query->num_rows() > 0){
			$row = $query->row();
			$cur_val = $row->meta_value;
			if($cur_val == $meta_value){
				return $row;
			}else{
				$data = array(
					'meta_value' => $meta_value
				);
				$this->db->where('meta_key', $meta_key);
				$this->db->where('user_id', $user_id);
				$this->db->update('rb_user_meta', $data);
				if($this->db->affected_rows()>0){
					$query = $this->db->get_where('rb_user_meta', array('user_id' => $user_id, 'meta_key'=>$meta_key));
					if ($query->num_rows() > 0){
						return $row = $query->row();
					}
				}
			}
		}else{
			$data = array(
				'user_meta_id' => NULL,
				'user_id' => $user_id,
				'meta_value' => $meta_value,
				'meta_key' => $meta_key
			);
			$this->db->insert('rb_user_meta', $data); 
			if($this->db->affected_rows()>0){
				$query = $this->db->get_where('rb_user_meta', array('user_id' => $user_id, 'meta_key'=>$meta_key));
				if ($query->num_rows() > 0){
					return $row = $query->row();
				}
			}
		}
	}

	/*------------------------------------------------------------------------
	| Method : add_user
	|-------------------------------------------------------------------------
	| Paramater : user_data - array
	| Return : array
	| Description : memasukkan data user baru
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function add_user($user_data, $role_user)
	{
		//id, email, pass, registered, activationkey, jurid, uniqueurl, firstname, middlename, lastname, fronttitle, backtitle, status.

		$par = array(
			'rb_user' => array(
				'user_email' => $user_data['user_email']
			)
		);
		$cekdata = $this->get_users($par);

		if($cekdata[0]['user_email'] === $user_data['user_email'])
		{
			return "gagal add";
		}
		else
		{
			$this->db->insert('rb_user', $user_data);

			$user_id = $this->db->insert_id();
			$par = array(
				'role_name'=>$role_user
			);
			$user_role =  $this->user_role->get_roles($par);

			$user_role_data = array(
				'role_id' => $user_role[0]['role_id'],
				'user_id' => $user_id
			);
			$this->user_role->add_user_role($user_role_data);
			return $user_id;
		}
	}

	/*------------------------------------------------------------------------
	| Method : get_invitations
	|-------------------------------------------------------------------------
	| Paramater : $par - array(), $orderby - array()
	| Return : array
	| Description : mengambil data users semua.
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function get_invitations($par = '', $orderby = '', $limit = NULL, $offset = NULL, $select = NULL) {
		if($select !== NULL)
		{
			$this->db->select($select);
		}
		else
		{
			$this->db->select('*');
		}
		$this->db->from('rb_invitation');
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

	/*------------------------------------------------------------------------
	| Method : invite_new
	|-------------------------------------------------------------------------
	| Paramater : user_data - array
	| Return : array
	| Description : memasukkan data user baru
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function invite_new($name, $email, $invite_by)
	{
		//id, email, pass, registered, activationkey, jurid, uniqueurl, firstname, middlename, lastname, fronttitle, backtitle, status.

		$par = array(
			'rb_user' => array(
				'user_email' => $email
			)
		);
		$cekdata = $this->get_users($par);

		$pari = array(
			'rb_invitation' => array(
				'invitation_email' => $email
			)
		);
		$cekdatai = $this->get_invitations($pari);

		if($cekdata[0]['user_email'] === $email || $cekdatai[0]['invitation_email'] === $email)
		{
			return "gagal add";
		}
		else
		{
			$invitationurl = urlencode($email);
			$invitation_code = md5(uniqid($invitationurl));

			$para = array(
				'rb_user' => array(
					'user_id' => $invite_by
				)
			);
			
			$time = time();
			$datestring = "%Y-%m-%d %h:%i:%s";
			$invitation_date = mdate($datestring, $time);

			$invitation_data = array(
				'invitation_code' => $invitation_code,
				'invitation_name' => $name,
				'invitation_email' => $email,
				'invitation_date' => $invitation_date,
				'invite_by' => $invite_by
			);

			$this->db->insert('rb_invitation', $invitation_data);

			$invitation_id = $this->db->insert_id();
			return $invitation_id;
		}
	}

	/*------------------------------------------------------------------------
	| Method : update_invitation_quota
	|-------------------------------------------------------------------------
	| Paramater : user_data - array
	| Return : array
	| Description : edit data user role
	| Author : Pratama Hasriyan
	------------------------------------------------------------------------*/
	public function update_invitation_quota($par = '', $clause = '')
	{
		if(is_array($clause))
		{
			foreach ($clause as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		$this->db->update('rb_user', $par);
		if($this->db->affected_rows() > 0)
		{
			$par2 = array(
				'rb_user' => $clause
			);
			$data = $this->get_users($par2);
			return $data;
		}
		else
		{
			return 'gagal';
		}
	}
	
	/**
	* INSERT NEW PROJECT STATE
	*/
	public function add_new_invitation($data = '') {
		$this->db->insert('rb_invitation', $data);
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
	* UPDATE PROJECT DATA
	*/
	public function update_invitation($par = '', $clause = '') {
		
		if(is_array($clause))
		{
			foreach ($clause as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		$this->db->update('rb_invitation', $par);
		if($this->db->affected_rows() > 0)
		{
			return $this->db->affected_rows();
		}
		else
		{
			return 'gagal';
		}
	}

}