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
					<li class="active">
						<a href="<?php echo base_url()?>admin/jurusan">Jurusan/Program Studi</a>
					</li>
				</ul>
				<hr>

				<div class="row-fluid">
					<div class="pull-left">
						<h3>Daftar Jurusan</h3>
					</div>
					<div class="pull-right">
						<input title="jurusan" type="hidden" name="jurusan" value="<?php echo base_url();?>" class="destination">
						<form class="addjurusan" name="Tambah Jurusan Baru" action="<?php echo base_url()?>admin/jurusan/add_jurusan">
							<a rel="tambah jurusan" class="btn btn-primary modal-button add-jurusan" data-toggle="modal" href="#myModal" ><i class="icon-plus icon-white"></i> Add Jurusan</a>
						</form>
					</div>
				</div>
				<hr>

				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th style="width:50px;">ID</th>
							<th>Jurusan</th>
							<th>Fakultas</th>
							<th colspan = "2">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$i = 1;
							error_reporting(0);
							foreach ($datajur as $key => $value) {
						?>
						<tr>
							<td class="jur_id"><?php echo $value['jur_id'];?></td>
							<td class="target jur_name"><?php echo $value['jur_name'];?></td>
							<td class="target fak_name"><?php echo $value['fak_name'];?></td>

							<td colspan = "1" style="width:65px;">
								<input title="jurusan" type="hidden" name="edit_jurusan" value="<?php echo base_url();?>" class="destination">

								<form class="editjurusan" name="Edit Jurusan" action="<?php echo base_url()?>admin/jurusan/edit_jurusan">
									<input type="hidden" name="ID" value="" class="query">

 									<input type="hidden" name="jur_name" value="" class="populate">

 									<input type="hidden" name="fak_name" value="" class="populate-select query">

									<a rel="Edit Jurusan" data-toggle="modal" href="#myModal" class="btn btn-warning edit-jurusan"><i class="icon-pencil icon-white"></i> Edit</a>
								</form>

							</td>
							<!--
<td colspan = "1" style="width:80px;">
								<input title="jurusan" type="hidden" name="del_jurusan" value="<?php //echo base_url();?>" class="destination">

								<form class="deljurusan" name="Delete Jurusan" action="<?php //echo base_url()?>admin/jurusan/del_jurusan">
									<input type="hidden" name="ID" value="" class="query">

									<input type="hidden" name="jur_name" value="" class="populate disabled">

									
									<a rel="Delete Jurusan" data-toggle="modal" href="#myModal" class="btn btn-danger del-jurusan"><i class="icon-trash icon-white"></i> Delete</a>
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

	