<?php
	/******************************************
	* View untuk Dashboard
	* author : pratama hasriyan
	******************************************/
	
	$this->load->view("header");
?>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span2">
				<?php $this->load->view("left-sidebar");?>
			</div><!--/span-->
			
			<div class="span8">
				<h2>Pratama Hasriyan Salahudin</h2>
				<hr />
				<div class="tabbable">
					
					<?php $this->load->view("user/nav-dashboard");?>
					
					<div class="tab-content">
						<div class="tab-pane active" id="1">
							<h3>Privacy</h3>
						</div>
					</div>
				</div>
			</div><!--/span-->
			
			<div class="span2">
				<?php $this->load->view("right-sidebar");?>
			</div><!--/span-->
			
		</div><!--/row-->
	
		<hr>
	
<?php
	$this->load->view("footer");
?>

	