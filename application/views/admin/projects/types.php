<?php
	/******************************************
	* View untuk projects admin
	* author : pratama hasriyan
	******************************************/
	$this->load->view("admin/header");
?>
	<!-- Modal -->
	<div class="modal hide fade" id="myModal">	
	</div><!-- end Modal -->

	<div class="container-fluid">
		<div class="row-fluid">

			<div class="span2">
				<?php $this->load->view('admin/left-sidebar', $menu);?>
			</div><!--/span-->

			<div class="span10">
				<h2>Tipe Project</h2>
				<p class="muted">Halaman control panel untuk data - data Tipe Projects</p>

				<ul class="breadcrumb">
					<li>
						<a href="<?php echo base_url()?>admin/projects">Projects</a> <span class="divider">/</span>
					</li>
					<li class="active">
						<a href="<?php echo base_url()?>admin/projects/project_types">Tipe Project</a>
					</li>
				</ul>
				<hr>

				<div class="row-fluid">
					<div class="pull-left">
						<h3>Daftar Tipe Project</h3>
					</div>
					<div class="pull-right">
						<input title="projects" type="hidden" name="add_type" value="<?php echo base_url();?>" class="destination">
						<form class="addtype" name="Tambah Tipe Project Baru" action="<?php echo base_url()?>admin/projects/add_type">
							<a rel="tambah tipe project" class="btn btn-primary modal-button add-type" data-toggle="modal" href="#myModal" ><i class="icon-plus icon-white"></i> Add Tipe Project</a>
						</form>
					</div>
				</div>
				<hr>

				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th style="width:50px;">ID</th>
							<th>Tipe Project</th>
							<th colspan = "1">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($types as $key => $value) {
						?>
						<tr>
							<td class="type_id"><?php echo $value['type_id'];?></td>
							<td class="target type_name"><?php echo $value['type_name'];?></td>
							<td colspan="1" style="width:65px;">

								<input title="projects" type="hidden" name="edit_type" value="<?php echo base_url();?>" class="destination">

								<form class="edittype" name="Edit Tipe Projects" action="<?php echo base_url()?>admin/projects/edit_type">
									<input type="hidden" name="ID" value="" class="query">

 									<input type="hidden" name="type_name" value="" class="populate">

									<a rel="Edit Tipe Project" data-toggle="modal" href="#myModal" class="btn btn-warning edit-type"><i class="icon-pencil icon-white"></i> Edit</a>
								</form>

							</td>
							<!--
<td colspan="1" style="width:80px;">

								<input title="projects" type="hidden" name="del_type" value="<?php //echo base_url();?>" class="destination">

								<form class="deltype" name="Delete Tipe Project" action="<?php //echo base_url()?>admin/projects/del_type">
									<input type="hidden" name="ID" value="" class="query">

									<input type="hidden" name="type_name" value="" class="populate disabled">

									
									<a rel="Delete Tipe Project" data-toggle="modal" href="#myModal" class="btn btn-danger del-type"><i class="icon-trash icon-white"></i> Delete</a>
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

	