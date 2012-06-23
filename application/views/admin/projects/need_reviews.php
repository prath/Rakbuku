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
					<!--
<div class="pull-right">
						<input title="projects" type="hidden" name="add_type" value="<?php //echo base_url();?>" class="destination">
						<form class="addtype" name="Tambah Tipe Project Baru" action="<?php //echo base_url()?>admin/projects/add_type">
							<a rel="tambah tipe project" class="btn btn-primary modal-button add-type" data-toggle="modal" href="#myModal" ><i class="icon-plus icon-white"></i> Add Tipe Project</a>
						</form>
					</div>
-->
				</div>
				<hr>

				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th style="width:50px;">ID</th>
							<th>Judul Project</th>
							<th>Type Project</th>
							<th>Penulis</th>
							<th colspan="2">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if( !empty($need_reviews) ){
							foreach ($need_reviews as $key => $value) {
						?>
						<tr>
							<td class="type_id"><?php echo $value['project_id'];?></td>
							<td class="type_id"><?php echo $value['project_title'];?></td>
							<td class="type_id"><?php echo $types[$key];?></td>
							<td class="target type_name"><?php echo $value['project_author'];?></td>
							<td colspan="1" style="width:65px;">
								Sedang Direview
							</td>
							<td colspan="1" style="width:65px;">
								<a href="<?php echo base_url().'admin_review/'.$value["project_url"];?>" class="btn btn-small btn-success">Review</a>
							</td>
						</tr>
						<?php
							}
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

	