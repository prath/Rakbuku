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
				<h2 class="profile-dashboard-title">
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
				
				<div class="tabbable">
					
					<?php $this->load->view("user/nav-dashboard");?>
					
					<div class="tab-content">
						<div class="tab-pane active" id="1">
							<div class="row-fluid">
								<!--===[ LEFT CONTENT ]===-->
								<div class="span12">
									<!--===[ PERSONAL INFO ]===-->
									<div>
										<h5 class="group-title"><em>Personal Info</em><?php if(is_own_profile($uurl, $current_user)){ ?><a class="edit-button" href="#"><i class="icon-pencil"></i></a><?php };?></h5><hr />
										
										<!--===[ NAMA LENGKAP ]===-->
										<div class="item-holder">
											<div class="span4 span-templ">
												<strong class="muted">Nama Lengkap</strong> 
											</div>
											<div class="span7 item-value editable">
												<span class="data-value"><?php echo (empty($user_data[0]["user_front_title"])) ? "" : $user_data[0]["user_front_title"].'. ';?><?php echo $names;?><?php echo (empty($user_data[0]["user_back_title"])) ? "" : ', '.$user_data[0]["user_back_title"];?></span>
												<form class="edit-data" data-dest="name" action="<?php echo base_url();?>user/<?php echo $user_url;?>/update_user_profile">
													<input type="text" class="input-large" name="user_front_title" value="<?php echo (empty($user_data[0]["user_front_title"])) ? "" : $user_data[0]["user_front_title"];?>" placeholder="Gelar">
													<input type="text" class="input-large" name="user_firstname" value="<?php echo (empty($user_data[0]["user_firstname"])) ? "" : $user_data[0]["user_firstname"];?>" placeholder="Nama Depan">
													<input type="text" class="input-large" name="user_middlename" value="<?php echo (empty($user_data[0]["user_middlename"])) ? "" : $user_data[0]["user_middlename"];?>" placeholder="Nama Tengah">
													<input type="text" class="input-large" name="user_lastname" value="<?php echo (empty($user_data[0]["user_lastname"])) ? "" : $user_data[0]["user_lastname"];?>" placeholder="Nama Belakang">
													<input type="text" class="input-large" name="user_back_title" value="<?php echo (empty($user_data[0]["user_back_title"])) ? "" : $user_data[0]["user_back_title"];?>" placeholder="Gelar">
													<input type="submit" value="Save Changes" class="save-btn btn btn-primary" >
												</form>
											</div>
											<div class="clr"></div>
											<hr class="item-separator" />
										</div>
										
									</div>
								</div>
								
								<!--===[ RIGHT CONTENT ]===-->
<!-- 								<div class="span6"> -->
									<!--===[ AKADEMIK INFO ]===-->
<!--
									<div>
										tis
									</div>
-->
<!-- 								</div> -->
							
							</div>
							
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

	