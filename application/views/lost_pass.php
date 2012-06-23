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
					<div class="alert alert-info">
						<h4>
							Masukkan email Anda untuk mendapatkan password baru
						</h4>
					</div>
					
					<?php
						if( isset($noexist) ) {	
					?>
					<div class="alert alert-warning">
						<?php echo $noexist;?>
					</div>
					<?php
						} else { 
							echo form_error('email', '<div class="alert alert-warning">', '</div>');
						}
					?>
					
					<?php
						if( isset($success) ) {	
					?>
					<div class="alert alert-info">
						<?php echo $success;?>
					</div>
					<?php
						}
					?>
					
					<?php
						if( isset($failed) ) {	
					?>
					<div class="alert alert-warning">
						<?php echo $failed;?>
					</div>
					<?php
						}
					?>
					<div class="progress progress-info progress-striped active">
						<div class="bar" style="width: 100%;">Sending Email</div>
					</div>
					<form class="offset2" action="<?php echo base_url().'retrieve_pass';?>" method="post">
						
						<div class="control-group">
							<div class="controls">
								<input class="input-xlarge" type="text" name="email" placeholder="Email">
							</div>
						</div>
						<button type="submit" id="lost-pass" class="btn btn-primary offset2">Send</button> 
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

	