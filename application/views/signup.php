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
						Sign Up
					</h2>
					<hr>
					
					<?php echo validation_errors('<div class="alert alert-warning">', '</div>');?>
					
					<form class="form-horizontal" method="post" action="<?php echo base_url()."invitations/sign_this_up" ;?>">
						<fieldset>
							<legend>Silahkan isi form berikut untuk menjadi member terlebih dahulu</legend>
							<div class="control-group">
								<label class="control-label" for="input01">Nama Depan Anda</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="firstname" name="firstname" placeholder="" >
									<p class="muted">
										(Harus diisi)
									</p>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="input01">Nama Tengah Anda</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="middlename" name="middlename" placeholder="" >
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="input01">Nama Belakang Anda</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="lastname" name="lastname" placeholder="" >
								</div>
							</div>
							
							
							<div class="control-group">
								<label class="control-label" for="input01">Email Anda</label>
								<div class="controls">
									<?php echo $invitation[0]["invitation_email"];?>
									<p class="muted">
										(Email ini akan digunakan untuk login)
									</p>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input01">Password Anda</label>
								<div class="controls">
									<input type="password" class="input-xlarge" id="pass" name="pass" placeholder="" >
									<p class="muted">
										(harus diisi. Password yang akan Anda gunakan untuk login)
									</p>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input01">URL Anda</label>
								<div class="controls">
									<span class="muted"><?php echo base_url()?>/user/</span><input type="text" class="input-small" id="uurl" name="uurl" placeholder="url anda" data-check = "<?php echo base_url()."invitations/cek_avail"; ?>" > <span class="cekavail elm-hidden"><i class="icon-repeat"></i> <em>checking...</em></span>
									<p class="muted">
										(harus diisi. akan jadi url unik anda)
									</p>
								</div>
							</div>
							
							<div class="form-actions">
								<input type="hidden" name="email" value="<?php echo $invitation[0]["invitation_email"];?>" />
								<input type="hidden" name="cek" value="<?php echo $key;?>" />
								<input type="submit" id="signup" class="btn" name="signup" value="signup" disabled="disabled">
							</div>
						</fieldset>
					</form>
					
					
				</div>
				
			</div><!--/span-->
			
		</div><!--/row-->
	
		<hr>
	
<?php
	$this->load->view("footer");
?>

	