<?php
	/******************************************
	* View untuk Dashboard
	* author : pratama hasriyan
	******************************************/
	
	$this->load->view("header");
	error_reporting(0);
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
							
							<h5 class="group-title"><em>Invite Member Baru</em></h5><hr />
							<div class="row-fluid">
								<div class="span12">
									<div class="alert alert-warning alert-hidden">
									</div>
									<div class="progress progress-info progress-striped active elm-hidden">
										<div class="bar" style="width: 100%;">Sending Email</div>
									</div>
									<form id="form-invite" method="post" action="<?php echo base_url().'user/'.$user_url.'/invite_new_member/';?>">
										<input type="text" class="input-large" id="invitee_name" name="invitee_name" placeholder="Nama Member Baru">
										<input type="text" class="input-large" id="invitee_email" name="invitee_email" placeholder="Email Member Baru">
										<input type="submit" value="Invite Member Baru" class="save-btn btn btn-primary submit-invite">
									</form>
								</div>
							</div>

							<div class="row-fluid" id="invitation-list">
								<div class="span12">
									<table class="table table-striped">
										<thead>
											<tr>
												<th>Invited</th>
												<th>Invitee</th>
												<th>Invitee Email Address</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
										<?php
											foreach( $invitation as $k => $v ) {
										?>
											<tr>
												<td><?php echo $v["invitation_date"]; ?></td>
												<td><?php echo $v["invitation_name"]; ?></td>
												<td><?php echo $v["invitation_email"]; ?></td>
												<td><?php echo $v["invitation_status"]; ?></td>
											</tr>
										<?php
											}
										?>
										</tbody>
									</table>
								</div>
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

	