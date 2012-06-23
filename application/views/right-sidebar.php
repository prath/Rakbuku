<?php  
/******************************************
* View untuk right sidebar
* author : pratama hasriyan
******************************************/
$login = $this->session->userdata('logged_in');
$usfn = $this->session->userdata('fullname');
$uslink = $this->session->userdata('current_user');
?>
<div class="well">
	<div class="row-fluid">
		<div class="span12 no-margin">
			<div class="">
			<form action="<?php echo base_url();?>search" method="post" >
				<input class="span12 input-small pull-left" name="keyword" id="inputIcon" type="text" placeholder="search">
				<input type="submit" name="search" value="search" class="btn btn-primary btn-small ">
			</div>
		</div>
		</div>
</div>
	
	<?php
		if( $login ){
	?>
<div class="well">
	<div class="row-fluid">
		<div class="span12 no-margin">
			<a href="<?php echo base_url();?>new_project" class="btn btn-primary btn-large btn-sidebar"><i class="icon-plus icon-white"></i> Buat Project Baru</a>
		</div>
	</div>
	<!--
<div class="row-fluid">
		<h4>Topic Anda</h4>
		<br>
		<a href="">Teknik Informatika</a>&nbsp;<a href="">Rekayasa Perangkat Lunak</a>
	</div>
-->
</div>
	<?php
		} else {
	?>

	<!--
<div class="row-fluid">
		<h4>Topic</h4>
		<br>
		<a href="">Teknik Informatika</a>&nbsp;<a href="">Rekayasa Perangkat Lunak</a>
	</div>
-->
	<?php
		}
	?>
<!--/.well -->