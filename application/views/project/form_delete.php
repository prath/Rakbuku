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
						$action = base_url()."review/".$project_parent[0]["project_url"]."/del_rev/".$versions[0]["version_id"];
					} else {
						$action = base_url()."review/".$project_data[0]["project_url"]."/del_rev/".$versions[0]["version_id"];
					}
				?>
				<form class="form-horizontal" id="new_project" action="<?php echo $action;?>" method="post">
					<fieldset>
						<?php
							if( $this->uri->segment(3) == "upload_file"){
								$stat = "Master";
							} else {
								$stat = "Revisi";
							}
						?>
						<h3>Delete File <?php echo $stat;?> : <?php echo $project_data[0]["project_title"];?></h3>
						<?php
							if( isset($project_parent) ){
						?>
						<span class="muted hint-prat"><em>Sebagai bagian dari project : </em></span><br>
						<div class="row-fluid">
							<div class="span1" style="text-align:right;">
								<i class="icon-arrow-right"></i>
							</div>
							<div class="span11">
								<h5 class="muted"><a class="muted" href="<?php echo base_url().'review/'.$project_parent[0]["project_url"];?>"><?php echo $project_parent[0]["project_title"];?></a></h5>
							</div>
						</div>
						<?php
							}
						?>
						<hr>
						<div class="alert alert-warning alert-hidden"></div>
						<div class="control-group">
							<label class="control-label" for="focusedInput">File</label>
							<div class="controls proj-chaps">
								<input class="input-xxlarge upload-input" class="proj-chap-file" type="text" disabled="disabled" name="project_file" value="[ versi : <?php echo $versions[0]["version_number"].' ] - '.$this->data["attachments"][0]["attachment_url"];?>" size="20">
							</div>
						</div>
													
						<div class="form-actions">
							<input type="hidden" value="<?php echo $project_data[0]["project_id"]; ?>" name="project_id">
							<input type="hidden" value="<?php echo $project_data[0]["project_attachment_count"]; ?>" name="project_attachment_count">
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
							<?php
								if( isset($project_parent) ){
									$reddest = "review/".$project_parent[0]["project_url"].'/'.$project_data[0]["project_url"];
								} else {
									$reddest = "review/".$project_data[0]["project_url"];
								}
							?>
							<input type="hidden" name="redirect_dest" value="<?php echo $reddest;?>" >
							<input type="submit" class="btn btn-warning" id="del_ver" name="del_ver" value="Delete File">
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

	