<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	if ( ! function_exists('active'))
	{
	    function active($var = '', $nav)
	    {
	        if($var == $nav){
	        	echo 'class="active"';
	        }
	    }   
	}
	
	if ( ! function_exists('is_own_profile'))
	{
	    function is_own_profile($uurl, $currentu)
	    {
	        if($uurl == $currentu){
	        	return true;
	        }else {
	        	return false;
	        }
	    }   
	}
	
	if ( ! function_exists('is_login'))
	{
	    function is_login($login)
	    {
			$userlogin =  $login;
			if( $userlogin == '' ) {
				return false;
			} else {
				return true;
			}
	    }   
	}
	
	if( !function_exists( "gen_year" ) ) {
		function gen_year() {
			$tahun = array();
			$ynow = date("Y");
			for( $i = 1950; $i <= $ynow; $i++ ) {
				array_push( $tahun, $i );
			}
			return $tahun;
		}
	}
	
	if( !function_exists( "names" ) ) {
		function get_user_names($user_data) {
			
			$names = array();
			foreach ($user_data as $key => $value) {
				
				$names[$key] = '';
				if($value['user_front_title'] != '') {
					$names[$key] .= $value['user_front_title'].' ';
				}
				
				$names[$key] .= $value['user_firstname'];
				
				if($value['user_middlename'] != '')	{
					$names[$key] .= ' '.$value['user_middlename'];
				}
				
				if($value['user_lastname'] != '') {
					$names[$key] .= ' '.$value['user_lastname'];
				}
				
				if($value['user_back_title'] != '') {
					$names[$key] .= ' '.$value['user_back_title'];
				}
				
			}
			
			return $names;
			
		}
	}
	
	if( !function_exists( "name" ) ) {
		function get_user_name($user_data) {
			
				
			$name = '';
			if($user_data[0]['user_front_title'] != '') {
				$name .= $user_data[0]['user_front_title'].' ';
			}
			
			$name .= $user_data[0]['user_firstname'];
			
			if($user_data[0]['user_middlename'] != '')	{
				$name .= ' '.$user_data[0]['user_middlename'];
			}
			
			if($user_data[0]['user_lastname'] != '') {
				$name .= ' '.$user_data[0]['user_lastname'];
			}
			
			if($user_data[0]['user_back_title'] != '') {
				$name .= ' '.$user_data[0]['user_back_title'];
			}
				
			return $name;
			
		}
	}
	
	if( !function_exists( "get_user_url" ) ) {
		function get_user_url($user_data) {
		
			return $user_u_url = ($user_data[0]['user_unique_url']=='') ? $user_data[0]['user_activation_key'] : $user_data[0]['user_unique_url'];
			
		}
	}
	
	if( !function_exists( "spliturl" ) ) {
		function spliturl($string, $len) {
		
			$parts = preg_split('/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE);
			$parts_count = count($parts);
			
			$length = 0;
			$last_part = 0;
			for (; $last_part < $parts_count; ++$last_part) {
			$length += strlen($parts[$last_part]);
			if ($length > $len) { break; }
			}
			
			$splitted = implode(array_slice($parts, 0, $last_part));
			
			$slug = strtolower( preg_replace('/[^A-Za-z0-9-]+/', '-', $splitted) );
			
			if( substr( $slug, -1) == "-" ) {
				$l = strlen($slug) - 1;
				return substr( $slug, 0, $l);
			} else {
				return $slug;
			}
			
		}
	}
	
	if ( ! function_exists('is_contributor'))
	{
	    function is_contributor($user_id_project, $reviewer_id_project, $current_user_id)
	    {
	    	error_reporting(0);
	    	$arr_rev = array();
	    	foreach($reviewer_id_project as $k => $v) {
		    	array_push($arr_rev, $v["user_id"]);
	    	}
	    	
	    	$found = array_search($current_user_id, $arr_rev);
/* 	    	 echo $found = in_array($current_user_id, $arr_rev); */
	    	 //echo $arr_rev[$found];
	    	//if()
	    	
	    	if( $user_id_project != $current_user_id && $found === false ) {
				return false;
			} else {
				return true;
			}
			
	    }   
	}
	
	if ( ! function_exists('is_reviewer_active'))
	{
	    function is_reviewer_active($reviewer_id_project, $current_user_id)
	    {
	    	error_reporting(0);
	    	$arr_rev = array();
	    	$arr_status = array();
	    	foreach($reviewer_id_project as $k => $v) {
		    	array_push($arr_rev, $v["user_id"]);
		    	array_push($arr_status, $v["reviewer_status"]);
	    	}
	    	
	    	
	    	$found = array_search($current_user_id, $arr_rev);
	    
/* 	    	 echo $found = in_array($current_user_id, $arr_rev); */
	    	 //echo $arr_rev[$found];
	    	//if()
	    	
	    	if( $arr_status[$found] === "invited" ) {
				return false;
			} else {
				return true;
			}
			
	    }    
	}
	
	if ( ! function_exists('is_in_admin_review'))
	{
	    function is_in_admin_review($user_id_project, $admin_review_ids, $current_user_id)
	    {
	    	$found = array_search($current_user_id, $admin_review_ids);
			if( $user_id_project == $current_user_id || $found !== false ) {
				return true;
			} else {
				return false;
			}
	    }   
	}
	
	if ( ! function_exists('is_self_project'))
	{
	    function is_self_project($user_id_project, $current_user_id)
	    {
			if( $user_id_project != $current_user_id ) {
				return false;
			} else {
				return true;
			}
	    }   
	}
	
	if ( ! function_exists('is_admin'))
	{
	    function is_admin($current_user_role)
	    {
			if( $current_user_role == "admin" ) {
				return true;
			} else {
				return false;
			}
	    }   
	}
	