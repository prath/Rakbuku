<?php  
	$nav = $this->uri->segment(3);
	//$login = $this->session->userdata('logged_in');
	//if($login){
?>

<ul class="nav nav-tabs">
	<!-- <li <?php //active('', $nav);?>><a href="<?php //echo base_url().'user/'.$uurl;?>">Dashboard</a></li> -->
	<li <?php active('projects', $nav);?>><a href="<?php echo base_url().'user/'.$uurl.'/projects';?>">Projects</a></li>
	<?php  
		if(is_own_profile($uurl, $current_user)){
	?>
	<li <?php active('reviews', $nav);?>><a href="<?php echo base_url().'user/'.$uurl.'/reviews';?>">Reviews</a></li>
	<?php  
		}
	?>
	<li <?php active('profile', $nav);?>><a href="<?php echo base_url().'user/'.$uurl.'/profile';?>">Profile</a></li>
	<?php  
		if(is_own_profile($uurl, $current_user)){
	?>
<!-- 	<li <?php //active('account', $nav);?>><a href="<?php //echo base_url().'user/'.$uurl.'/account';?>">Account</a></li> -->
<!-- 	<li <?php //active('privacy', $nav);?>><a href="<?php //echo base_url().'user/'.$uurl.'/privacy';?>">Privacy</a></li> -->
	<li <?php active('invitation', $nav);?>><a href="<?php echo base_url().'user/'.$uurl.'/invitation';?>">Invitation</a></li>
	<?php  
		}
	?>
	<?php  
		if(is_own_profile($uurl, $current_user)){
			if($current_role == "admin_reviewer") {
		
	?>
	<li <?php active('admin_reviews', $nav);?>><a href="<?php echo base_url().'user/'.$uurl.'/admin_reviews';?>">Admin Reviews</a></li>
	<?php  
			}
		}
	?>
</ul>