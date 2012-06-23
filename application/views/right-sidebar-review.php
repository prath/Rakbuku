<?php  
/******************************************
* View untuk right sidebar
* author : pratama hasriyan
******************************************/
$login = $this->session->userdata('logged_in');
$usfn = $this->session->userdata('fullname');
$uslink = $this->session->userdata('current_user');
$current_user = $this->session->userdata('user_id');
$cekreview = $this->uri->segment(1);
//$self_project;
//print_r($project_parent);
?>
<div class="well">
	<?php
		//print_r($current_reviewers);
		if( $login ){
	?>
	<div class="row-fluid">
		<div class="span12 no-margin">
			<a href="<?php echo base_url();?>new_project" class="btn btn-primary btn-large btn-sidebar"><i class="icon-plus icon-white"></i> Buat Project Baru</a>
		</div>
	</div>
	<?php
			if( $self_project ) {
				if($project_data[0]["project_status"] == "approved" && $project_data[0]["project_parent"] == "" && $this->uri->segment(1) == "review"){
			
	?>
	<br>
	<div class="row-fluid">
		<div class="span12 no-margin">
			<a href="<?php echo base_url()."review/".$project_data[0]["project_url"]."/publish_project/";?>" class="btn btn-warning btn-large btn-sidebar"><i class="icon-plus icon-white"></i> Publikasikan Project</a>
		</div>
	</div>
	<?php
				}
			} else {
				if( isset($project_parent) ) {
	?>
	<br>
	<div class="row-fluid">
		<div class="span12 no-margin">
		<?php 
					$cekreviewer = is_reviewer_active($current_reviewers, $current_user_id);
					if(isset($attachments) && $project_data[0]["project_status"] == "review" && $cekreviewer ) {
					
		?>
			<a href="<?php echo base_url()."review/".$project_parent[0]["project_url"]."/approve_bab/".$project_data[0]["project_url"];?>" class="btn btn-warning btn-large btn-sidebar"><i class="icon-plus icon-white"></i> Approve Bab</a>
		<?php
					}
		?>
		</div>
	</div>
	<?php
				} else {
	?>
	<br>
	<div class="row-fluid">
		<div class="span12 no-margin">
		<?php
					$cekreviewer = is_reviewer_active($current_reviewers, $current_user_id);
					if(isset($bab_approved_all) && $bab_approved_all && $project_data[0]["project_status"] == "review" && $cekreviewer) {
					
		?>
			<a href="<?php echo base_url()."review/".$project_data[0]["project_url"]."/approve_project"?>" class="btn btn-warning btn-large btn-sidebar"><i class="icon-plus icon-white"></i> Approve Project</a>
		<?php
					}
		?>
		</div>
	</div>
	<?php
				}
			}
			
		}
	?>
	
	<?php
		if( !empty($is_admin) && $is_admin && $this->uri->segment(1) == "admin_review" ) {
			
	?>
	<div class="row-fluid">
		<div class="span12 no-margin">
			<a href="<?php echo base_url()."admin_review/".$project_data[0]["project_url"]."/publish_project/";?>" class="btn btn-warning btn-large btn-sidebar"><i class="icon-plus icon-white"></i> Publikasikan Project</a>
		</div>
	</div>
	<?php
		}
	?>
	
</div><!--/.well -->