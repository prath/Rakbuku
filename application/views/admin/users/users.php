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
				<h1>Users</h1>
				<p class="muted">Halaman control panel untuk data - data yang berhubungan dengan Users, User Roles, dan Members</p>

				<ul class="breadcrumb">
					<li>
						<a href="<?php echo base_url()?>admin/dashboard">Dashboard</a> <span class="divider">/</span>
					</li>
					<li class="active">
						<a href="<?php echo base_url()?>admin/users">members</a>
					</li>
				</ul>
				<hr>

				<div class="row-fluid">
					<div class="pull-left">
						<h3>Daftar Member</h3>
					</div>
					<!--
<div class="pull-right">
						<input title="users" type="hidden" name="member" value="<?php //echo base_url();?>" class="destination">
						<form class="addmember" name="Tambah User Baru" action="<?php //echo base_url()?>admin/users/add_user">
							<a rel="tambah member" class="btn btn-primary modal-button add-member" rel="additem" data-toggle="modal" href="#myModal" ><i class="icon-plus icon-white"></i> Add Member</a>
						</form>
					</div>
-->
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
								Tanggal Join
							</th>
							<th>
								Member Role
							</th>
							<th>
								Member Profile Url
							</th>
							<th>
								Status
							</th>
							<th colspan="2">
								Action
							</th>
							<!--
<th>
								Kirimkan Account
							</th>
-->
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($users as $key => $value) {
						?>
						<tr>
							<td class="id"><?php echo $value['user_id'];?></td>
							<td class="fullname"><?php echo $value['user_firstname'].' '.$value['user_middlename'].' '.$value['user_lastname'];
								?></td>
							<td class="user_registered"><?php echo $value['user_registered'];?></td>
							<td class="target-edit role_name"><?php echo $user_roles[$key][0]['role_name'];?></td>
							<td class="user_unique_url">
								<a href="">
									<?php 
										if($value['user_unique_url'] !== NULL)
										{
											$url = $value['user_unique_url'];
										}
										else
										{
											$url = $value['user_activation_key'];
										}
										echo anchor('user/'.$url, $value['user_firstname']);
									?>
								</a>
							</td>
							<td class="target status">
								<span class="<?php echo ($value['user_status'] === 'inactive') ? 'muted' :  ''; ?>"><?php echo $value['user_status'];?></span>
							</td>
							<td colspan="1" style="width:110px;">
								<?php
									if($value['user_status'] === 'inactive')
									{
								?>
								<input title="users" type="hidden" name="activation" value="<?php echo base_url();?>" class="destination">

								<form class="deactivate-form" name="Non-aktifkan User" action="<?php echo base_url()?>admin/users/user_activation">

									<input type="hidden" name="ID" value="" class="query">

									<input type="hidden" name="fullname" value="" class="populate disabled query">

									<input type="hidden" name="status" value="" class="query">

									<a rel="aktifkan" data-toggle="modal" href="#myModal" class="btn btn-primary activemember"><i class="icon-ok icon-white"></i> activated</a>

								</form>
								<?php
									}
									else
									{
								?>
								<input title="users" type="hidden" name="activation" value="<?php echo base_url();?>" class="destination">

								<form class="deactivate-form" name="Non-aktifkan User" action="<?php echo base_url()?>admin/users/user_activation">

									<input type="hidden" name="ID" value="" class="query">

									<input type="hidden" name="fullname" value="" class="populate disabled query">

									<input type="hidden" name="status" value="" class="query">

									<a rel="non-aktifkan" data-toggle="modal" href="#myModal" class="btn btn-warning deactivemember"><i class="icon-remove icon-white"></i> deactivated</a>

								</form>
								<?php
									}
								?>
							</td>
							<td colspan="1">
								<input title="users" type="hidden" name="edit_user_role" value="<?php echo base_url();?>" class="destination">

								<form class="edit-role" name="Edit Role Member" action="<?php echo base_url()?>admin/users/edit_user_role">
									<input type="hidden" name="ID" value="" class="query">

									<input type="hidden" name="role_name" value="" class="populate-select query">

									<a rel="Edit Role User" data-toggle="modal" href="#myModal" class="btn btn-warning editrole"><i class="icon-pencil icon-white"></i> Edit Role</a>
								</form>
							</td>
							<!--
<td style="width:110px;">
								<input title="users" type="hidden" name="sent_account" value="<?php echo base_url();?>" class="destination">

								<form class="kirim-account" name="Kirimkan Informasi Account User" action="<?php echo base_url()?>admin/users/sent_account">
									<input type="hidden" name="ID" value="" class="query">

									<input type="hidden" name="fullname" value="" class="populate disabled">

									<a rel="kirim account info" data-toggle="modal" href="#myModal" class="btn btn-primary kirimaccount"><i class="icon-envelope icon-white"></i> kirim</a>
								</form>
							</td>
-->
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

	