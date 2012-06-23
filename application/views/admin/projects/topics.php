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
				<h2>Topic Project</h2>
				<p class="muted">Halaman control panel untuk data - data Topic Projects</p>

				<ul class="breadcrumb">
					<li>
						<a href="<?php echo base_url()?>admin/projects">Projects</a> <span class="divider">/</span>
					</li>
					<li class="active">
						<a href="<?php echo base_url()?>admin/projects/topics">Topic Project</a>
					</li>
				</ul>
				<hr>

				<div class="row-fluid">
					<div class="pull-left">
						<h3>Daftar Topic Project</h3>
					</div>
					<div class="pull-right">
						<input title="projects" type="hidden" name="add_topic" value="<?php echo base_url();?>" class="destination">
						<form class="addtopic" name="Tambah Topic Project Baru" action="<?php echo base_url()?>admin/projects/add_topic">
							<a rel="tambah topic project" class="btn btn-primary modal-button add-topic" data-toggle="modal" href="#myModal" ><i class="icon-plus icon-white"></i> Add Topic Project</a>
						</form>
					</div>
				</div>
				<hr>

				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th style="width:50px;">ID</th>
							<th>Tipe Project</th>
							<th colspan = "2">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($topics as $key => $value) {
						?>
						<tr>
							<td class="topic_id"><?php echo $value['topic_id'];?></td>
							<td class="target topic_name"><?php echo $value['topic_name'];?></td>
							<td colspan="1" style="width:65px;">

								<input title="projects" type="hidden" name="edit_topic" value="<?php echo base_url();?>" class="destination">

								<form class="edittopic" name="Edit Topic Projects" action="<?php echo base_url()?>admin/projects/edit_topic">
									<input type="hidden" name="ID" value="" class="query">

 									<input type="hidden" name="topic_name" value="" class="populate">

									<a rel="Edit Topic Project" data-toggle="modal" href="#myModal" class="btn btn-warning edit-topic"><i class="icon-pencil icon-white"></i> Edit</a>
								</form>

							</td>
							<td colspan="1" style="width:80px;">

								<input title="projects" type="hidden" name="del_topic" value="<?php echo base_url();?>" class="destination">

								<form class="deltopic" name="Delete Topic Project" action="<?php echo base_url()?>admin/projects/del_topic">
									<input type="hidden" name="ID" value="" class="query">

									<input type="hidden" name="topic_name" value="" class="populate disabled">

									
									<a rel="Delete Topic Project" data-toggle="modal" href="#myModal" class="btn btn-danger del-topic"><i class="icon-trash icon-white"></i> Delete</a>
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

	