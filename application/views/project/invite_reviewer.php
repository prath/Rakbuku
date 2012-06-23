<?php
	/******************************************
	* View untuk Dashboard
	* author : pratama hasriyan
	******************************************/

	$this->load->view("header");
	
	$users = '';
	foreach ( $user_names as $k => $v ) {
		$users .= '"'.$v.'"';
		if( $k !== count($user_names)-1 ) {
			$users .= ',';
		}
	}
?>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span2">
				<?php $this->load->view("left-sidebar");?>
			</div><!--/span-->
			
			<div class="span8">
				<h2 style="text-transform: capitalize;">Project Baru</h2>
				<p class="muted">Isi dan lengkapi form project baru</p>
				<hr />
				
				<?php 
				$attr = array('class' => 'form-horizontal');
				//echo form_open( "project/route_project_fw", $attr );
				?>
				
				<form class="form-horizontal" method="post" action="<?php echo base_url();?>invite_reviewer/process_invite">
					<fieldset>
					
						<h3>Invite Reviewer</h3>
						<hr>
						<div class="progress progress-danger progress-striped active">
							<div class="bar" style="width:100%;">Invite Reviewer (3/3 langkah)</div>
						</div>
						<hr>
						<div class="alert alert-info">
							Selamat, Anda telah berhasil membuat sebuah project berujudul : <strong><?php echo $project_data[0]["project_title"];?></strong>.<br><br>
							Selanjutnya adalah memilih apakah project ini adalah project yang telah selesai atau project yang masih dalam proses bimbingan, dengan cara memilih dropdown di bawah ini : 
							<br><em class="muted">(Jika Anda memilih "Sedang Berjalan" Anda bisa mengundang pembimbing Anda, dan melakukan bimbingan online. Jika memilih "Telah Selesai" dokumen Anda akan di review oleh admin sebelum akhirnya dipublikasikan)</em>
						</div>
						<div class="control-group">
							<label class="control-label" for="focusedInput">Status Project</label>
							<div class="controls">
								<select id="status_select" name="project_status">
									<option value="">Pilih Status Project</option>
									<option value="onrun">Sedang Berjalan</option>
									<option value="finished">Telah Selesai</option>
								</select>
								<input type="hidden" name="project_id" value="<?php echo $project_data[0]["project_id"];?>" />
							</div>
						</div>
						
						<div class="progress progress-info progress-striped active elm-hidden">
							<div class="bar" style="width:100%;">loading</div>
						</div>
						
						<div class="form-actions">
							<input type="submit" class="btn btn-primary submit-admin-review elm-hidden" id="submit_invite_admin" name="submit" value="Save and Next">
						</div>
						<?php
								
							if($this->uri->segment(3) == "error_sent") {
						?>		
						<div class="alert alert-warning">Email Gagal Dikirim, Mohon Diulang Kembali</div>
						<?php		
							}
						?>
						
						<div class="onrun elm-hidden">
							
							<div class="alert alert-warning alert-form alert-hidden"></div>
							<hr>
							<div class="control-group">
								<label class="control-label" for="focusedInput">Invite Reviewer</label>
								<div class="controls">
									<input class="input-xlarge invitee_email required" name="invitee_email[]" id="" type="text" value="" placeholder="Ketikkan Email Anda Pembimbing Disini">
									<a class="tips person-add" href="#"><i class="icon-plus"></i></a>
									<br><br>
								</div>
							</div>
							
							<div class="form-actions">
								<input type="hidden" name="project_type" value="<?php echo $type;?>" />
								<input type="hidden" name="project_state" value="<?php echo $state;?>" />
								<input type="hidden" name="nextstate" value="<?php echo $nextstate;?>" />
								<input type="hidden" name="currenturl" value="<?php echo $currenturl;?>" />
								<input type="hidden" name="nexturl" value="<?php echo $nexturl;?>" />
								<input type="submit" class="btn btn-primary" id="submit_invite" name="submit" value="Save and Next">
							</div>
						</div>
						
						
					</fieldset>
				</form>
				<?php //echo form_close();?>
				
			</div><!--/span-->
			
			<div class="span2">
				<?php $this->load->view("right-sidebar");?>
			</div><!--/span-->
			
		</div><!--/row-->
	
		<hr>
	
<?php
	$this->load->view("footer");
?>

	