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
				
				<?php 
				$attr = array('class' => 'form-horizontal');
				//echo form_open( "project/route_project_fw", $attr );
				?>
				<form class="form-horizontal" action="<?php echo base_url();?>new_project/new_form" method="post">
					<fieldset>
					
						<h3>Pilih Type Project</h3>
						<hr>
						<div class="progress progress-danger progress-striped active">
							<div class="bar" style="width:33%;">Pilih Project (1/3 langkah)</div>
						</div>
						<hr>
						
						<div class="control-group">
							<label class="control-label" for="focusedInput">Type Project</label>
							<div class="controls">
								<select id="type_select" name="project_type">
								<?php
									foreach( $types as $k => $v) {
								?>
									<option value="<?php echo $v["type_id"];?>"><?php echo $v["type_name"];?></option>
								<?php
									}
								?>
								</select>
							</div>
						</div>
						
						<div class="form-actions">
							<input type="hidden" name="project_state" value="isi form project baru" />
							<input type="submit" class="btn btn-primary" name="submit" value="Save and Next Step">
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

	