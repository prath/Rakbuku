<?php  
/******************************************
* View untuk header
* author : pratama hasriyan
******************************************/
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Rakbuku</title>
	<meta name="description" content="">
	<meta name="author" content="">
	
	<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<!-- Le styles -->
	<link href="<?php echo base_url();?>public/css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo base_url();?>public/css/style.css" rel="stylesheet">
	<style type="text/css">
		body {
		padding-top: 60px;
		padding-bottom: 40px;
		}
		.sidebar-nav {
		padding: 9px 0;
		}
	</style>
	<link href="<?php echo base_url();?>public/css/bootstrap-responsive.css" rel="stylesheet">
	
	<!-- Le fav and touch icons -->
	<link rel="shortcut icon" href="<?php echo base_url();?>public/images/favicon.ico">
	<link rel="apple-touch-icon" href="<?php echo base_url();?>public/images/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url();?>public/images/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url();?>public/images/apple-touch-icon-114x114.png">
</head>
<body>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
			  	<a class="brand" href="<?php echo base_url();?>">Rakbuku</a>
				<div class="nav-collapse">
					<ul class="nav">
						<li class="active"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Jurusan/Program Studi <b class="caret"></b></a>
								
 								<ul class="dropdown-menu">
			                      <li><a href="#">Teknik Informatika</a></li>
			                      <li><a href="#">Biologi</a></li>
			                      <li><a href="#">Kimia</a></li>
			                      <li class="divider"></li>
			                      <li><a href="#">Separated link</a></li>
			                    </ul>

			            </li>
						<!--
<li><a href="#contact">Help</a></li>
						<li><a href="#about">Member</a></li>
						<li><a href="#about">F.A.Q</a></li>
						<li><a href="#about">Contact</a></li>
-->
					</ul>
					
					<div class="pull-right">
						<?php
							$login = $this->session->userdata('logged_in');
							$usfn = $this->session->userdata('fullname');
							$uslink = $this->session->userdata('current_user');
							if($login){
						?>
						<p class="navbar-text pull-right">Logged in as <?php if($current_role == "admin"){ ?><a href="<?php echo base_url().'admin';?>"><?php } echo $current_role; if($current_role == "admin") { ?></a><?php };?> |  <a href="<?php echo base_url().'user/'.$uslink;?>" style="text-transform: capitalize;"><?php echo $usfn;?></a> | <?php echo anchor('logout', "logout");?></p>
						<?php
							}else {
						?>
						<div class="pull-left" style="margin-right: 10px; margin-top: 5px;">
						<?php
								echo form_open('login');
								$data = array(
								              'name'        => 'email',
								              'id'          => 'email',
								              'placeholder' => 'Email',
								              'class'		=> 'input-small login-form',
								            );
								echo form_input($data);
								
								$datapass = array(
								              'name'        => 'password',
								              'id'          => 'password',
								              'placeholder' => 'Password',
								              'class'		=> 'input-small login-form',
								            );
								echo form_password($datapass);
								$datasubmit = array(
								              'name'        => 'login',
								              'id'          => 'login',
								              'value' 		=> 'Login',
								              'class'		=> 'btn login',
								            );
								echo form_submit($datasubmit);
								echo form_close();
								//echo validation_errors();
							}
						?>
						</div>
					</div>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>
	
