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
				<form class="form-horizontal" id="add_bab" action="<?php echo base_url();?>review/<?php echo $project_data[0]["project_url"];?>/save_add_bab" method="post" >
					<fieldset>
						<h3>Add Bab </h3>
						<span class="muted hint-prat"><em>Sebagai bagian dari project : </em></span><br>
						<div class="row-fluid">
							<div class="span1" style="text-align:right;">
								<i class="icon-arrow-right"></i>
							</div>
							<div class="span11">
								<h5 class="muted"><a class="muted"" href="<?php echo base_url().'review/'.$project_data[0]["project_url"];?>"><?php echo $project_data[0]["project_title"];?></a></h5>
							</div>
						</div>
						<hr>
						<div class="alert alert-warning alert-add alert-hidden"></div>
						<div class="control-group">
							<label class="control-label" for="focusedInput">Judul BAB</label>
							<div class="controls">
								<input class="input-xxlarge required" name="project_title" id="project_title" type="text" value="" placeholder="(Judul Bab)">
							</div>
						</div>
						
						<?php
							if( isset($error_msg) )
								echo $error_msg;
						?>						
						<div class="form-actions">
							<input type="hidden" value="<?php echo $project_data[0]["project_id"]; ?>" name="project_id">
							<a class="reset btn" href="<?php echo base_url().'review/'.$project_data[0]["project_url"];?>">Back</a>
							<input type="submit" class="btn btn-primary" id="edit_project" name="edit_project" value="Add Bab">
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

	