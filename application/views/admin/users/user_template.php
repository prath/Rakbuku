<?php
	/******************************************
	* View untuk projects admin
	* author : pratama hasriyan
	******************************************/
	$this->load->view("admin/header");
?>

	<div class="modal hide fade" id="myModal">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">×</a>
			<h3>Edit Data</h3>
			<div class="progress progress-info
			     progress-striped active">
			  <div class="bar"
			       style="width: 100%;">
			   </div>
			</div>
		</div>
		<form id="edititem" action="" method="">
			<div class="modal-body">
				<input class="input-xlarge" type="text" name="type_name" id="edit-name" placeholder="Nama Tipe" value="">
			</div>
			<div class="modal-footer">
				<input type="submit" name="submit" id="submit" class="btn btn-primary" value="Save">
				<a href="#" data-dismiss="modal" class="btn">Close</a>
			</div>
		</form>
	</div><!-- end Modal -->

	<div class="modal hide fade" id="myModal2">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">×</a>
			<h3>Save Template</h3>
			<div class="progress progress-info
			     progress-striped active">
			  <div class="bar"
			       style="width: 100%;">
			   </div>
			</div>
		</div>
		<form id="save-template" class="" name="" action="<?php echo base_url()?>admin/users/save_template">
			<div class="modal-body">
				<input type="hidden" name="page" value="profile">
				<input class="input-xlarge" type="text" name="template-name" id="template-name" placeholder="Nama Template" value="">
			</div>
			<div class="modal-footer">
				<input type="submit" name="submit" id="submit" class="btn btn-primary" value="Save">
				<a href="#" data-dismiss="modal" class="btn">Close</a>
			</div>
		</form>
	</div><!-- end Modal -->

	<div class="modal hide fade" id="myModal3">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">×</a>
			<h3>Ubah type input</h3>
			<div class="progress progress-info
			     progress-striped active">
			  <div class="bar"
			       style="width: 100%;">
			   </div>
			</div>
		</div>
		<form id="ubah-input" class="" name="" action="">
			<div class="modal-body">
				<select class="input-type">
					<option selected>Pilih Type</option>
					<option value="Input Text">Input Text</option>
					<option value="Input Textarea">Input Textarea</option>
				</select>
			</div>
			
		</form>
	</div><!-- end Modal -->

	<div class="container-fluid">
		<div class="row-fluid">

			<div class="span2">
				<?php $this->load->view('admin/left-sidebar', $menu);?>
			</div><!--/span-->

			<div class="span10">
				<h1>User Data Config</h1>
				<p class="muted">Control Configurasi Data User</p>
				<hr>
				<!-- <div class="row-fluid">
					<div class="alert alert-info span11">
						<a class="close">×</a>
						<strong>Info! </strong>
						<p>
							Ini adalah Halaman untuk mengkonfigurasikan template untuk halaman profil member. <br>Anda dapat menambahkan data user baru, menyusun struktur informasi pada halaman profil member yang akan digunakan oleh member
						</p>
						<strong>Anda dapat melakukan beberapa hal untuk mengkonfigurasikan template :</strong>
						<ul>
							<li>
								Menambahkan atau Mengurangi data - data user
							</li>
							<li>
								Drag &amp; Drop data - data user baru.
							</li>
							<li>
								Drag &amp; Drop data - data untuk untuk mengatur susunan.
							</li>
							<li>
								Mengatur data - data dalam sebuah grup
							</li>
						</ul>
					</div>
					<br>
				</div> -->
				<div class="tabbable tabs-left">
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#lA" data-toggle="tab">Tambah User Data</a>
						</li>
						<li class="">
							<a href="#lB" data-toggle="tab">Hapus User Data</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="lA">
							<div class="row-fluid">

								
								<!-- drop content -->

								<div class="span12">

									<div class="row-fluid">
										<div class="span12">
											<span class="muted hint-prat">
												Tambahkan user data baru untuk dipakai oleh member/user. 
											</span>
										</div>
									</div>
									<hr>

									<div class="well">
										<form class="form-horizontal">
											<fieldset>
												<legend>Tambah Data User Baru</legend>
												<div class="control-group">
												<label class="control-label" for="input01">Text input</label>
												<div class="controls">
												<input type="text" class="input-xlarge" id="input01">
												<p class="help-block">In addition to freeform text, any HTML5 text-based input appears like so.</p>
												</div>
												</div>
												<div class="control-group">
												<label class="control-label" for="optionsCheckbox">Checkbox</label>
												<div class="controls">
												<label class="checkbox">
												<input type="checkbox" id="optionsCheckbox" value="option1">
												Option one is this and that—be sure to include why it's great
												</label>
												</div>
												</div>
												<div class="control-group">
												<label class="control-label" for="select01">Select list</label>
												<div class="controls">
												<select id="select01">
												<option>something</option>
												<option>2</option>
												<option>3</option>
												<option>4</option>
												<option>5</option>
												</select>
												</div>
												</div>
												<div class="control-group">
												<label class="control-label" for="multiSelect">Multicon-select</label>
												<div class="controls">
												<select multiple="multiple" id="multiSelect">
												<option>1</option>
												<option>2</option>
												<option>3</option>
												<option>4</option>
												<option>5</option>
												</select>
												</div>
												</div>
												<div class="control-group">
												<label class="control-label" for="fileInput">File input</label>
												<div class="controls">
												<input class="input-file" id="fileInput" type="file">
												</div>
												</div>
												<div class="control-group">
												<label class="control-label" for="textarea">Textarea</label>
												<div class="controls">
												<textarea class="input-xlarge" id="textarea" rows="3"></textarea>
												</div>
												</div>
												<div class="form-actions">
												<button type="submit" class="btn btn-primary">Save changes</button>
												<button type="reset" class="btn">Cancel</button>
												</div>
											</fieldset>
										</form>

									</div>
										
								</div>
							</div>
						</div>
						<div class="tab-pane" id="lB">
							<p>Howdy, I'm in Section B.</p>
						</div>
					</div>
				</div>

			</div><!--/span-->

		</div><!--/row-->
	
		<hr>
	
<?php
	$this->load->view("admin/footer");
?>

	