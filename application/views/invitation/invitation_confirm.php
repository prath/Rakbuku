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
			
			<div class="span10">
			
				<div class="row-fluid">
					<h2 class="project" style="text-transform: capitalize;">
						Invitation
					</h2>
					<hr>
					<p>
						Anda telah diundang untuk menjadi pembimbing untuk project judul project oleh pratama hasriyan. 
						<br><br>
						<a href="<?php echo base_url()."invitations/signup/".$invitation[0]["invitation_code"] ;?>" class="btn btn-primary">click disini untuk menyetujui permohonannya</a>
					</p>
				</div>
				
			</div><!--/span-->
			
		</div><!--/row-->
	
		<hr>
	
<?php
	$this->load->view("footer");
?>

	