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
				<?php
					if( isset($project_parent) ){
						if( $this->uri->segment(3) == "upload_file"){
							$action = base_url()."review/".$project_parent[0]["project_url"]."/save_upload/".$project_data[0]["project_url"];
						} else {
							$action = base_url()."review/".$project_parent[0]["project_url"]."/save_rev/".$project_data[0]["project_url"];
						}
					} else {
						if( $this->uri->segment(3) == "upload_file"){
							$action = base_url()."review/".$project_data[0]["project_url"]."/save_upload/";
						} else {
							$action = base_url()."review/".$project_data[0]["project_url"]."/save_rev/";
						}
					}
				?>
				<form class="form-horizontal" id="new_project" action="<?php echo $action;?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
					<fieldset>
						<?php
							if( $this->uri->segment(3) == "upload_file"){
								$stat = "Master";
							} else {
								$stat = "Revisi";
							}
						?>
						<h3>Upload File <?php echo $stat;?> : <?php echo $project_data[0]["project_title"];?></h3>
						<?php
							if( isset($project_parent) ){
						?>
						<span class="muted hint-prat"><em>Sebagai bagian dari project : </em></span><br>
						<div class="row-fluid">
							<div class="span1" style="text-align:right;">
								<i class="icon-arrow-right"></i>
							</div>
							<div class="span11">
								<h5 class="muted"><a class="muted" href="<?php echo base_url().'review/'.$project_parent[0]["project_url"].'/'.$project_data[0]["project_url"];?>"><?php echo $project_parent[0]["project_title"];?></a></h5>
							</div>
						</div>
						<?php
							}
						?>
						<hr>
						<div class="alert alert-warning alert-hidden"></div>
						<div class="control-group">
							<label class="control-label" for="focusedInput">Upload File</label>
							<div class="controls proj-chaps">
								<input class="input-xxlarge upload-input" class="proj-chap-file" type="file" name="project_file" size="20">
							</div>
						</div>
													
						<div class="form-actions">
							<input type="hidden" value="<?php echo $project_data[0]["project_id"]; ?>" name="project_id">
							<?php
								if( isset($project_parent) ){
							?>
							<input type="hidden" value="<?php echo $project_parent[0]["project_id"]; ?>" name="project_parent_id">
							<input type="hidden" value="<?php echo $project_parent[0]["project_attachment_count"]; ?>" name="project_attachment_count_parent">
							<?php
								}
								if( isset($project_parent) ){
									$ur = base_url().'review/'.$project_parent[0]["project_url"].'/'.$project_data[0]["project_url"];
								} else {
									$ur = base_url().'review/'.$project_data[0]["project_url"];
								}
							?>
							<a class="reset btn" href="<?php echo $ur;?>">Back</a>
							<input type="submit" class="btn btn-primary" id="upload_file" name="upload_file" value="Upload File">
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

	