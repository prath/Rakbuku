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
				<h1>User Roles</h1>
				<p class="muted">Halaman control panel untuk data - data yang berhubungan dengan Role Users</p>

				<ul class="breadcrumb">
					<li>
						<a href="<?php echo base_url()?>admin/dashboard">Dashboard</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="<?php echo base_url()?>admin/users">Users</a> <span class="divider">/</span>
					</li>
					<li class="active">
						<a href="<?php echo base_url()?>admin/users/user_role">User Roles</a>
					</li>
				</ul>
				<hr>

				<div class="row-fluid">
					<div class="pull-left">
						<h3>Daftar User Roles</h3>
					</div>
					<div class="pull-right">
						<input title="users" type="hidden" name="add_role" value="<?php echo base_url();?>" class="destination">
						<form class="addrole" name="Tambah Role Baru" action="<?php echo base_url()?>admin/users/add_role">
							<a rel="tambah Role" class="btn btn-primary modal-button add-role" rel="additem" data-toggle="modal" href="#myModal" ><i class="icon-plus icon-white"></i> Add Role</a>
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
								Role
							</th>
							<th >
								Action
							</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($user_roles as $key => $value) {
						?>
						<tr>
							<td class="id"><?php echo $value['role_id'];?></td>
							<td class="role_name target-edit"><?php echo $value['role_name'];?></td>
							<td style="width:100px;">
								<input title="users" type="hidden" name="edit_role" value="<?php echo base_url();?>" class="destination">

								<form class="edit-role" name="Edit Role" action="<?php echo base_url()?>admin/users/edit_role">
									<input type="hidden" name="ID" value="" class="query">

									<input type="hidden" name="role" value="" class="populate">

									<a rel="Edit Role User" data-toggle="modal" href="#myModal" class="btn btn-warning editroles"><i class="icon-pencil icon-white"></i> Edit Role</a>
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

	