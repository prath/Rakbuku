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
				<form class="form-horizontal" id="new_project" action="<?php echo base_url();?>review/<?php echo $project_parent[0]["project_url"].'/save_approval/'.$project_data[0]["project_url"];?>" method="post">
					<fieldset>
						<h3>Approve Project : <?php echo $project_data[0]["project_title"];?></h3>
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
							<label class="control-label" for="focusedInput"></label>
							<div class="controls">
								<div class="alert alert-warning">
									<h4>
										Anda yakin akan menyetujui draft <?php echo $project_data[0]["project_title"];?> untuk menjadi final?
									</h4>
								</div>
								<div class="alert alert-info">
									<span class="hint-prat">
										Setelah Anda menyetujui semua draft bab dari project berjudul : <strong><?php echo $project_parent[0]["project_title"];?></strong>, Anda dapat menyetujui project tersebut <a href="<?php echo base_url().'review/'.$project_parent[0]["project_url"];?>">di halaman ini</a> dan menjadikannya final. 
									</span>
								</div>
							</div>
						</div>
														
						<div class="form-actions">
							<input type="hidden" value="<?php echo $project_parent[0]["project_url"]; ?>" name="project_parent_url">
							<input type="hidden" value="<?php echo $project_data[0]["project_id"]; ?>" name="project_id">
							<a class="reset btn" href="<?php echo base_url().'review/'.$project_parent[0]["project_url"].'/'.$project_data[0]["project_url"];?>">Back</a>
							<input type="submit" class="btn btn-warning" id="edit_project" name="edit_project" value="Setujui Draft Bab">
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

	