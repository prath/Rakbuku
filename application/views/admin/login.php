<?php  
/******************************************
* View untuk Login Admin
* author : pratama hasriyan
******************************************/
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title> Control Panel Rakbuku</title>
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
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row-fluid">
			
			<div class="span4">
				&nbsp;
			</div><!--/span-->
			<div class="span4">
				<div class="">
					<?php 
						if(isset($salah))
						{
					?>
					<div class="alert">
						<strong>Warning!</strong>
						<?php echo $salah;?>
					</div>
					<?php
						}
					?>
					<form action="<?php echo base_url().'admin/dashboard/login';?>" method="post">

						<div class="control-group warning">
							<div class="controls">
								<input class="input-xlarge" type="text" name="email" placeholder="Email">
								<?php echo form_error('email', '<span class="help-inline">', '</span>'); ?>
							</div>
						</div>
						<div class="control-group warning">
							<div class="controls">
								<input class="input-xlarge" type="password" name="password" placeholder="Password">
								<?php echo form_error('password', '<span class="help-inline">', '</span>'); ?>
							</div>
						</div>
						<button type="submit" class="btn btn-primary">Login</button>
					</form>
				</div>
			</div><!--/span-->
			<div class="span4">
				&nbsp;
			</div><!--/span-->
			
		</div><!--/row-->
	
		<hr>
	
		<footer>
			<p>&copy; Rakbuku 2012</p>
		</footer>
    </div><!--/.fluid-container-->
    
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url();?>public/js/jquery.js"></script>
    <script src="<?php echo base_url();?>public/js/bootstrap-transition.js"></script>
    <script src="<?php echo base_url();?>public/js/bootstrap-alert.js"></script>
    <script src="<?php echo base_url();?>public/js/bootstrap-modal.js"></script>
    <script src="<?php echo base_url();?>public/js/bootstrap-dropdown.js"></script>
    <script src="<?php echo base_url();?>public/js/bootstrap-scrollspy.js"></script>
    <script src="<?php echo base_url();?>public/js/bootstrap-tab.js"></script>
    <script src="<?php echo base_url();?>public/js/bootstrap-tooltip.js"></script>
    <script src="<?php echo base_url();?>public/js/bootstrap-popover.js"></script>
    <script src="<?php echo base_url();?>public/js/bootstrap-button.js"></script>
    <script src="<?php echo base_url();?>public/js/bootstrap-collapse.js"></script>
    <script src="<?php echo base_url();?>public/js/bootstrap-carousel.js"></script>
    <script src="<?php echo base_url();?>public/js/bootstrap-typeahead.js"></script>
    <script src="<?php echo base_url();?>public/js/global.js"></script>

</body>
</html>

	