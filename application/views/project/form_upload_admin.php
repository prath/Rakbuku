<?php
	/******************************************
	* View untuk Dashboard
	* author : pratama hasriyan
	******************************************/

	$this->load->view("header");
	//print_r($project_chapters);
?>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span2">
				<?php $this->load->view("left-sidebar");?>
			</div><!--/span-->
			
			<div class="span8">
				<?php
					$action = base_url()."admin_review/".$project_data[0]["project_url"]."/save_upload/"
				?>
				<form class="form-horizontal" id="new_project" action="<?php echo $action;?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
					<fieldset>
						<h3>Upload File : <?php echo $project_data[0]["project_title"];?></h3>
						
						<hr>
						<div class="alert alert-warning alert-hidden"></div>
						
						<div class="controls proj-chaps">
						<?php 
							$project_data[0]["project_chapters"];
							foreach($project_chapters as $k => $v) {
								$x = $k+1;
							
						?>
							<input type="hidden" name="project_chapter_id_project_chap_file_<?php echo $x;?>" value="<?php echo $v["project_id"]; ?>">
							<input class="input-xxlarge required proj-chap-title" name="project_chap_title_project_chap_file_<?php echo $x;?>" id="" type="text" value="<?php echo $v["project_title"];?>" readonly="readonly">
							<input class="input-xxlarge upload-input" type="file" name="project_chap_file_<?php echo $x;?>" size="20"><br><br>
							<?php
								}
							?>
						</div>
						
													
						<div class="form-actions">
							<input type="hidden" value="<?php echo base_url().'admin_review/'.$project_data[0]["project_url"]; ?>" name="project_url">
							<input type="hidden" value="<?php echo $project_data[0]["project_id"]; ?>" name="project_id">
							<?php
								if( isset($project_parent) ){
							?>
							<input type="hidden" value="<?php echo $project_parent[0]["project_id"]; ?>" name="project_parent_id">
							<input type="hidden" value="<?php echo $project_parent[0]["project_attachment_count"]; ?>" name="project_attachment_count_parent">
							<?php
								}
								if( isset($project_parent) ){
									$ur = base_url().'admin_review/'.$project_parent[0]["project_url"].'/'.$project_data[0]["project_url"];
								} else {
									$ur = base_url().'admin_review/'.$project_data[0]["project_url"];
								}
							?>
							<a class="reset btn" href="<?php echo $ur;?>">Back</a>
							<input type="submit" class="btn btn-primary" id="upload_file_other" name="upload_file" value="Upload File">
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

	