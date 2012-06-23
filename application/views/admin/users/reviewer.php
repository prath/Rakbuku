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
				<h1>Reviewer</h1>
				<p class="muted">Halaman control panel untuk data - data yang berhubungan dengan Reviewers</p>

				<ul class="breadcrumb">
					<li>
						<a href="<?php echo base_url()?>admin/dashboard">Dashboard</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="<?php echo base_url()?>admin/users">Users</a> <span class="divider">/</span>
					</li>
					<li class="active">
						<a href="<?php echo base_url()?>admin/users/reviewer">Reviewer</a>
					</li>
				</ul>
				<hr>

				<div class="row-fluid">
					<div class="pull-left">
						<h3>Daftar Reviewer</h3>
					</div>
					<div class="pull-right">
						<input title="users" type="hidden" name="add_reviewer" value="<?php echo base_url();?>" class="destination">
						<form class="addreviewer" name="Tambah Reviewer Baru" action="<?php echo base_url()?>admin/users/add_reviewer">
							<a rel="tambah Reviewer" class="btn btn-primary modal-button add-reviewer" rel="additem" data-toggle="modal" href="#myModal" ><i class="icon-plus icon-white"></i> Add Reviewer</a>
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
								Nama Reviewer
							</th>
							<th>
								Status
							</th>
							<th >
								Action
							</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($reviewers as $key => $value) {
						?>
						<tr>
							<td class="id"><?php echo $value['user_id'];?></td>
							<td class="fullname target-edit"><?php echo $value['user_firstname'].' '.$value['user_middlename'].' '.$value['user_lastname'];
								?></td>
							<td class="target status">
								<span class="<?php echo ($value['reviewer_status'] === 'inactive') ? 'muted' :  ''; ?>"><?php echo $value['reviewer_status'];?></span>
							</td>
							<td colspan="1" style="width:110px;">
								<?php
									if($value['reviewer_status'] === 'inactive')
									{
								?>
								<input title="users" type="hidden" name="activation" value="<?php echo base_url();?>" class="destination">

								<form class="deactivate-form" name="Non-aktifkan Reviewer" action="<?php echo base_url()?>admin/users/reviewer_activation">

									<input type="hidden" name="ID" value="" class="query">

									<input type="hidden" name="fullname" value="" class="populate disabled query">

									<input type="hidden" name="status" value="" class="query">

									<a rel="aktifkan" data-toggle="modal" href="#myModal" class="btn btn-primary active-reviewer"><i class="icon-ok icon-white"></i> activated</a>

								</form>
								<?php
									}
									else
									{
								?>
								<input title="users" type="hidden" name="activation" value="<?php echo base_url();?>" class="destination">

								<form class="deactivate-form" name="Non-aktifkan Reviewer" action="<?php echo base_url()?>admin/users/reviewer_activation">

									<input type="hidden" name="ID" value="" class="query">

									<input type="hidden" name="fullname" value="" class="populate disabled query">

									<input type="hidden" name="status" value="" class="query">

									<a rel="non-aktifkan" data-toggle="modal" href="#myModal" class="btn btn-warning deactive-reviewer"><i class="icon-remove icon-white"></i> deactivated</a>

								</form>
								<?php
									}
								?>
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

	