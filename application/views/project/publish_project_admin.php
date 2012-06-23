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
				<form class="form-horizontal" id="new_project" action="<?php echo base_url();?>admin_review/<?php echo $project_data[0]["project_url"].'/go_publish';?>" method="post">
					<fieldset>
						<h3>Publish Project : <?php echo $project_data[0]["project_title"];?></h3>
						<hr>
						
						<div class="control-group">
							<label class="control-label" for="focusedInput"></label>
							<div class="controls">
								<div class="alert alert-warning">
									<h4>
										Anda yakin akan mempublikasikan project <?php echo $project_data[0]["project_title"];?>? Admin akan mereview kelengkapan dokumen sebelum project dipublish.
									</h4>
								</div>
							</div>
						</div>
														
						<div class="form-actions">
							<input type="hidden" name="project_type" value="<?php echo $type;?>" />
							<input type="hidden" name="project_state" value="<?php echo $state;?>" />
							<input type="hidden" name="currenturl" value="<?php echo $currenturl;?>" />
							<input type="hidden" name="project_url" value="<?php echo $project_data[0]["project_url"]; ?>" >
							<input type="hidden" name="project_id" value="<?php echo $project_data[0]["project_id"]; ?>">
							<a class="reset btn" href="<?php echo base_url().'admin_review/'.$project_data[0]["project_url"];?>">Back</a>
							<input type="submit" class="btn btn-warning" id="publish_project" name="publish_project" value="Publish Project">
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

	