<?php
	/******************************************
	* View untuk projects admin
	* author : pratama hasriyan
	******************************************/
	$this->load->view("admin/header");
?>
	<div class="container-fluid">
		<div class="row-fluid">

			<div class="span2">
				<?php $this->load->view('admin/left-sidebar', $menu);?>
			</div><!--/span-->

			<div class="span10">
				<h1>F.A.Q</h1>
				<p class="muted">Halaman control panel untuk F.A.Q</p>
			</div><!--/span-->

		</div><!--/row-->
	
		<hr>
	
<?php
	$this->load->view("admin/footer");
?>

	