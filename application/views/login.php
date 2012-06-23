<?php
	/******************************************
	* View untuk home
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
				<h2>
					Login
				</h2>
				<hr>
				<div class="row-fluid">
					<?php
						if( isset($salah) ) {	
					?>
					<div class="alert alert-warning">
						<?php echo $salah;?>
					</div>
					<?php
						} else {
					?>
					<div class="alert alert-warning">
						<?php echo validation_errors();?>
					</div>
					<?php
						}
					?>
					<form class="offset2" action="<?php echo base_url().'login';?>" method="post">

						<div class="control-group">
							<div class="controls">
								<input class="input-xlarge" type="text" name="email" placeholder="Email">
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<input class="input-xlarge" type="password" name="password" placeholder="Password">
							</div>
						</div>
						<a href="<?php echo base_url().'lost_pass';?>">lupa password?</a><button type="submit" class="btn btn-primary offset1">Login</button> 
					</form>
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

	