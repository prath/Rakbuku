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
				<h2 style="text-transform: capitalize;">Project Baru</h2>
				<p class="muted">Isi dan lengkapi form project baru</p>
				<hr />
				
				<form lass="form-horizontal" action="<?php echo base_url();?>project/<?php echo $currenturl;?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">					
					<fieldset>
						<h3>Upload Dokumen</h3>
						<hr>
						<div class="progress progress-danger progress-striped active">
							<div class="bar" style="width:75%;">Upload Dokumen (3/4 langkah)</div>
						</div>
						<hr>
						
						<div class="alert alert-warning alert-hidden"></div>
						<div class="control-group">
							<label class="control-label" for="focusedInput">Dokumen (hanya diijinkan dengan format pdf)</label>
							<div class="controls upload-control">
								<input class="input-xxlarge upload-input" type="file" name="project_attachment_0" size="20"><a class="add-upload" style="float:right" href=""><i class="icon-plus"></i></a>
							</div>
						</div>
												
						<div class="form-actions">
							<input type="hidden" class="num_file" name="num_file" value="1" />
							<input type="hidden" name="project_type" value="<?php echo $type;?>" />
							<input type="hidden" name="project_state" value="<?php echo $state;?>" />
							<input type="hidden" name="nextstate" value="<?php echo $nextstate;?>" />
							<input type="hidden" name="nexturl" value="<?php echo $nexturl;?>" />
							<input type="submit" class="btn" name="back" value="Back To Prev Step">
							<input type="submit" class="btn btn-primary" id="upload_file" name="upload_file" value="Upload and Next Step">
						</div>
					</fieldset>
				</form>
				
			</div><!--/span-->
			
			<div class="span2">
				<?php $this->load->view("right-sidebar");?>
			</div><!--/span-->
			
		</div><!--/row-->
	
		<hr>
	
<?php
	$this->load->view("footer");
?>