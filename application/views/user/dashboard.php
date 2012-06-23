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
				<h2 style="text-transform: capitalize;">
				<?php 
					if($user_data[0]['user_front_title']) {
						echo $user_data[0]['user_front_title'].'. ';
					}
					echo $user_data[0]['user_firstname'].' '.$user_data[0]['user_middlename'].' '.$user_data[0]['user_lastname'].' ';
					if($user_data[0]['user_back_title']) {
						echo $user_data[0]['user_back_title'];
					}
				?>
				</h2>
				<?php
					$user_url = ($user_data[0]['user_unique_url']=='') ? $user_data[0]['user_activation_key'] : $user_data[0]['user_unique_url']; 
				?>
				<a href="<?php echo base_url().'user/'.$user_url;?>" class="help-block" id="user_url">
					http://localhost/rakbuku/user<span>/<?php echo $user_url;?></span>
				</a>
				<hr />
				<div>
					<?php $this->load->view("user/nav-dashboard");?>
				</div>
				<div class="tabbable">
					
					<div class="tab-content">
						<div class="tab-pane active" id="1">
							<h3>Dashboard</h3>
						</div>
					</div>
				</div>
			</div><!--/span-->
			
			<div class="span2">
				<?php $this->load->view("right-sidebar");?>
			</div><!--/span-->
			
		</div><!--/row-->
	
		<hr>
	
<?php
	$this->load->view("footer");
?>

	