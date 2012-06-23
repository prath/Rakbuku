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
					<li>
						<a href="<?php echo base_url()?>admin/users/invitation">Invitation</a><span class="divider">/</span>
					</li>
					<li class="active">
						<a href="<?php echo base_url()?>admin/users/invitation_quota">Invitation Quota</a>
					</li>
				</ul>
				<hr>

				<div class="row-fluid">
					<ul class="nav nav-tabs">
						<li>
							<a href="<?php echo base_url()?>admin/users/invitation">Daftar Invitation</a>
						</li>
						<li class="active">
							<a href="<?php echo base_url()?>admin/users/invitation_quota">Quota Invitation</a>
						</li>
					</ul>
					<div class="pull-left">
						<h3>Quota Invitation</h3>
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
								Nama Lengkap
							</th>
							<th>
								Invite Quota
							</th>
							<th>
								Invited (number)
							</th>
							<th>
								Action
							</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ($invitation as $key => $value) {
							
						?>
						<tr>
							<td class="id"><?php echo $value['user_id'];?></td>
							<td>
								<?php echo $fullname[$key];?>
							</td>
							<td class="target quota"><?php echo $value['user_invite_quota'];?></td>
							<td>
								<?php echo count($users[$key]).' orang';?>
							</td>
							<td style="width:130px;">
								<input title="users" type="hidden" name="invitation_quota" value="<?php echo base_url();?>" class="destination">

								<form class="beri-quota" name="Berikan Tambahan Quota Invite" action="<?php echo base_url()?>admin/users/invitation_quota_add">
									<input type="hidden" name="ID" value="" class="query">

									<input type="hidden" name="user_invitation_quota" value="" class="populate">

									<a rel="add quota" data-toggle="modal" href="#myModal" class="btn btn-primary add-quota"><i class="icon-user icon-white"></i> Berikan Quota</a>
								</form>
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

	