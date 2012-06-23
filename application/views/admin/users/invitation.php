<?php
	/******************************************
	* View untuk users admin
	* author : pratama hasriyan
	******************************************/
	$this->load->view("admin/header" , $title);
?>
	<!-- Modal -->
	<div class="modal hide fade" id="myModal">
		<div class="progress progress-info
		     progress-striped active">
		  <div class="bar"
		       style="width: 100%;">
		   </div>
		</div>
	</div><!-- end Modal -->

	<div class="container-fluid">
		<div class="row-fluid">

			<div class="span2">
				<?php $this->load->view('admin/left-sidebar', $menu);?>
			</div><!--/span-->

			<div class="span10">
				<h1>Invitation</h1>
				<p class="muted">Halaman control panel untuk data - data Invitation yang dilakukan oleh member ataupun admin</p>

				<ul class="breadcrumb">
					<li>
						<a href="<?php echo base_url()?>admin/dashboard">Dashboard</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="<?php echo base_url()?>admin/users">Users</a> <span class="divider">/</span>
					</li>
					<li class="active">
						<a href="<?php echo base_url()?>admin/users/invitation">Invitation</a>
					</li>
				</ul>
				<hr>

				<div class="row-fluid">
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="<?php echo base_url()?>admin/users/invitation">Daftar Invitation</a>
						</li>
						<li>
							<a href="<?php echo base_url()?>admin/users/invitation_quota">Quota Invitation</a>
						</li>
					</ul>
					<div class="pull-left">
						<h3>Daftar Invitation</h3>
					</div>
					<div class="pull-right">
						<input title="users" type="hidden" name="invitation_add" value="<?php echo base_url();?>" class="destination">
						<form class="addinvitation" name="Invite Member Baru" action="<?php echo base_url()?>admin/users/invite_new_member">
							<a rel="Invite New Member" class="btn btn-primary modal-button invite-member" data-toggle="modal" href="#myModal" ><i class="icon-plus icon-white"></i> Invite New Member</a>
						</form>
					</div>
				</div>
				<hr>

				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>
								ID
							</th>
							<th>
								Invitation Code
							</th>
							<th>
								Invitee Name
							</th>
							<th>
								Invitee Email
							</th>
							<th>
								Invited at
							</th>
							<th>
								Invited By
							</th>
							<th>
								Invitation Status
							</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ($invitation as $key => $value) {
							
						?>
						<tr>
							<td>
								<?php echo $value['invitation_id'];?>
							</td>
							<td>
								<a href="">
									<?php echo $value['invitation_code'];?>
								</a>
							</td>
							<td>
								<?php echo $value['invitation_name'];?>
							</td>
							<td>
								<?php echo $value['invitation_email'];?>
							</td>
							<td>
								<?php echo $value['invitation_date'];?>
							</td>
							<td>
								<?php echo $fullname[$key][0];?>
							</td>
							<td>
								<?php echo $value['invitation_status'];?>
							</td>
						</tr>
						<?php
							}
						?>
					</tbody>
				</table>
				<?php echo $pagination;?>

			</div><!--/span-->

		</div><!--/row-->
	
		<hr>
	
<?php
	$this->load->view("admin/footer");
?>

	