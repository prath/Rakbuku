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
				<form class="form-horizontal" id="new_project" action="<?php echo base_url();?>review/<?php echo $project_data[0]["project_url"].'/save_approval';?>" method="post">
					<fieldset>
						<h3>Approve Project : <?php echo $project_data[0]["project_title"];?></h3>
						<hr>
						
						<div class="control-group">
							<label class="control-label" for="focusedInput"></label>
							<div class="controls">
								<div class="alert alert-warning">
									<h4>
										Anda yakin akan menyetujui draft <?php echo $project_data[0]["project_title"];?> untuk menjadi final?
									</h4>
								</div>
								<div class="alert alert-info">
									<span class="hint-prat">
										Ini berarti Anda sudah menyetujui semua bab dari project ini, dan Anda dapat menyetujui project ini, untuk kemudian nanti di publikasikan oleh penulis.
									</span>
								</div>
							</div>
						</div>
														
						<div class="form-actions">
							<input type="hidden" value="<?php echo $project_data[0]["project_url"]; ?>" name="project_url">
							<input type="hidden" value="<?php echo $project_parent[0]["project_url"]; ?>" name="project_parent_url">
							<input type="hidden" value="<?php echo $project_data[0]["project_id"]; ?>" name="project_id">
							<a class="reset btn" href="<?php echo base_url().'review/'.$project_parent[0]["project_url"].'/'.$project_data[0]["project_url"];?>">Back</a>
							<input type="submit" class="btn btn-warning" id="edit_project" name="edit_project" value="Setujui Draft Project">
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

	