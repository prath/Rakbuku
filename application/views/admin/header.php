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
	<title>Control Panel Rakbuku | <?php echo $title;?></title>
	<meta name="description" content="">
	<meta name="author" content="">
	
	<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<!-- Le styles -->
	<link href="<?php echo base_url();?>public/css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo base_url();?>public/css/styleadmin.css" rel="stylesheet">
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
	<?php
		$nav = $this->uri->segment(2);
	?>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
			  	<a class="brand" href="<?php echo base_url();?>admin/dashboard">Rakbuku Control Panel</a>
				<div class="nav-collapse">
					<ul class="nav">
						<li><a href="<?php echo base_url();?>">Kunjungi Front Page</a></li>
						<li <?php active('jurusan', $nav);?>><a href="<?php echo base_url();?>admin/jurusan">Jurusan/Program Studi</a></li>
						<li <?php active('users', $nav);?>><a href="<?php echo base_url();?>admin/users">Users</a></li>
						<li <?php active('projects', $nav);?>><a href="<?php echo base_url();?>admin/projects">Project Tulisan</a></li>
						<!-- <li <?php //active('site_settings', $nav);?>><a href="<?php //echo base_url();?>admin/site_settings">Site Settings</a></li> -->
						<!--
<li <?php //active('faqs', $nav);?>><a href="<?php echo base_url();?>admin/faqs">F.A.Q</a></li>
						<li <?php //active('contact', $nav);?>><a href="<?php echo base_url();?>admin/contact">Contact</a></li>
-->
						
					</ul>
					
					<div class="pull-right">
						<?php
							$login = $this->session->userdata('logged_in');
							if($login){
						?>
						<p class="navbar-text pull-right">
							<?php echo anchor('admin/dashboard/logout', "logout");?>
						</p>
						<?php
							}
						?>
						</div>
						
					</div>  
					    
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>
