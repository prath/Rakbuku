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
				<h2>Framework Project</h2>
				<p class="muted">Halaman configurasi alur kerja peng-upload-an, review, approval dan publishing project</p>

				<ul class="breadcrumb">
					<li>
						<a href="<?php echo base_url()?>admin/projects">Projects</a> <span class="divider">/</span>
					</li>
					<li class="active">
						<a href="<?php echo base_url()?>admin/projects/project_frameworks">Framework Project</a>
					</li>
				</ul>
				<hr>
								
				<div class="row-fluid">
					<div class="alert alert-info">
						<p>
							<strong>Project Framework</strong> adalah aturan - aturan yang ditentukan dalam proses peng-upload-an dan pembuatan project baru, berikut juga proses bimbingan, penyetujuan dan publikasi project jika telah disetujui. 
						</p>
						<p>
							setiap type project memiliki satu project framework yang dapat di-configurasi ulang, disusun ulang, dihapus beberapa aturan atau pun ditambahkan beberapa aturan. 
						</p>
						<p>
							untuk mulai mengkonfgurasi aturan - aturan framework, pilih type project di bawah terlebih dahulu. <a href="#">click disini untuk penjelasan lebih lanjut</a> 
						</p>
						<input id="fw-uri" type="hidden" name="uri" value="<?php echo base_url()?>admin/projects/load_frameworks">
						<select id="project-type">
							<option value="">Pilih Type Project</option>
						<?php
							foreach( $types as $k => $v ) {					
						?>
			                <option value="<?php echo $v["type_id"];?>"><?php echo $v["type_name"];?></option>
			            <?php
			            	}
			            ?>
		                </select>
					</div>
				</div>
				
				<div class="row-fluid" id="load-container">
					
				</div>

				
			</div><!--/span-->

		</div><!--/row-->
	
		<hr>

<?php
	$this->load->view("admin/footer");
?>