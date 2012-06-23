<?php
	/******************************************
	* View untuk jurusan admin
	* author : pratama hasriyan
	******************************************/
	$this->load->view("admin/header" , $title);
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
				<h2>Jurusan/Program Studi</h2>
				<p class="muted">Halaman control panel untuk data - data yang berhubungan dengan Jurusan/Program Studi dan Fakultas</p>

				<ul class="breadcrumb">
					<li>
						<a href="<?php echo base_url()?>admin/dashboard">Dashboard</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="<?php echo base_url()?>admin/jurusan">Jurusan/Program Studi</a><span class="divider">/</span>
					</li>
					<li class="active">
						<a href="<?php echo base_url()?>admin/jurusan/fakultas">Fakultas</a>
					</li>
				</ul>
				<hr>

				<div class="row-fluid">
					<div class="pull-left">
						<h3>Daftar Fakultas</h3>
					</div>
					<div class="pull-right">
						<input title="jurusan" type="hidden" name="fakultas" value="<?php echo base_url();?>" class="destination">
						<form class="addfakultas" name="Tambah Fakultas Baru" action="<?php echo base_url()?>admin/jurusan/add_fakultas">
							<a rel="tambah Fakultas" class="btn btn-primary modal-button add-fakultas" data-toggle="modal" href="#myModal" ><i class="icon-plus icon-white"></i> Add Fakultas</a>
						</form>
					</div>
				</div>
				<hr>

				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th style="width:50px;">ID</th>
							<th>Fakultas</th>
							<th colspan = "2">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$i = 1;
							error_reporting(0);
							foreach ($datafak as $key => $value) {
						?>
						<tr>
							<td class="fak_id"><?php echo $value['fak_id'];?></td>
							<td class="target fak_name"><?php echo $value['fak_name'];?></td>
							<td colspan = "1" style="width:65px;">
								<input title="jurusan" type="hidden" name="edit_fakultas" value="<?php echo base_url();?>" class="destination">

								<form class="editfakultas" name="Edit Fakultas" action="<?php echo base_url()?>admin/jurusan/edit_fakultas">
									<input type="hidden" name="ID" value="" class="query">

 									<input type="hidden" name="fak_name" value="" class="populate">

									<a rel="Edit Fakultas" data-toggle="modal" href="#myModal" class="btn btn-warning edit-fakultas"><i class="icon-pencil icon-white"></i> Edit</a>
								</form>
							</td>
							<!--
<td colspan = "1" style="width:80px;">
								<input title="jurusan" type="hidden" name="del_fakultas" value="<?php //echo base_url();?>" class="destination">

								<form class="delfakultas" name="Delete Fakultas" action="<?php //echo base_url()?>admin/jurusan/del_fakultas">
									<input type="hidden" name="ID" value="" class="query">

									<input type="hidden" name="fak_name" value="" class="populate disabled">

									
									<a rel="Delete Fakultas" data-toggle="modal" href="#myModal" class="btn btn-danger del-fakultas"><i class="icon-trash icon-white"></i> Delete</a>
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

	