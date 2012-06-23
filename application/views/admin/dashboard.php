<?php
	/******************************************
	* View untuk home dashboard admin
	* author : pratama hasriyan
	******************************************/
	$this->load->view("admin/header" , $title);
?>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<div class="hero-unit">
					<h1>Rakbuku Admin Dashboard</h1>
					<p>Selamat Datang Admin</p>
				</div>
			</div><!--/span-->

		</div><!--/row-->
	
		<hr>
	
<?php
	$this->load->view("admin/footer");
?>

	