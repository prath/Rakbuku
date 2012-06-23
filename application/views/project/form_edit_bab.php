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
				<form class="form-horizontal" id="new_project" action="<?php echo base_url();?>review/<?php echo $project_parent[0]["project_url"];?>/save_edit_bab/"<?php echo $project_parent[0]["project_url"];?> method="post" accept-charset="utf-8" enctype="multipart/form-data">
					<fieldset>
						<h3>Edit Project : <?php echo $project_data[0]["project_title"];?></h3>
						<span class="muted hint-prat"><em>Sebagai bagian dari project : </em></span><br>
						<div class="row-fluid">
							<div class="span1" style="text-align:right;">
								<i class="icon-arrow-right"></i>
							</div>
							<div class="span11">
								<h5 class="muted"><a class="muted"" href="<?php echo base_url().'review/'.$project_parent[0]["project_url"].'/'.$project_data[0]["project_url"];?>"><?php echo $project_parent[0]["project_title"];?></a></h5>
							</div>
						</div>
						<hr>
						
						<div class="control-group">
							<label class="control-label" for="focusedInput">Judul BAB</label>
							<div class="controls">
								<input class="input-xxlarge required" name="project_title" id="" type="text" value="<?php echo $project_data[0]["project_title"];?>" placeholder="(Judul Jurnal, skripsi, atau karya tulis lainnya - Harus Diisi)">
							</div>
						</div>
														
						<div class="form-actions">
							<input type="hidden" value="<?php echo $project_parent[0]["project_url"]; ?>" name="project_parent_url">
							<input type="hidden" value="<?php echo $project_data[0]["project_id"]; ?>" name="project_id">
							<a class="reset btn" href="<?php echo base_url().'review/'.$project_parent[0]["project_url"].'/'.$project_data[0]["project_url"];?>">Back</a>
							<input type="submit" class="btn btn-primary" id="edit_project" name="edit_project" value="Edit Project">
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

	