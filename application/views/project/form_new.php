<?php
	/******************************************
	* View untuk Dashboard
	* author : pratama hasriyan
	******************************************/

	$this->load->view("header");
?>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span2">
				<?php $this->load->view("left-sidebar");?>
			</div><!--/span-->
			
			<div class="span8">
				<h2 style="text-transform: capitalize;">Project Baru <?php echo $types[0]["type_name"];?></h2>
				<p class="muted">Isi dan lengkapi form project baru</p>
				<hr />
				
				
				<form class="form-horizontal" id="new_project" action="<?php echo base_url();?>new_project/save_new_project" method="post" accept-charset="utf-8" enctype="multipart/form-data">
					<fieldset>
						<h3>Lengkapi Informasi Project</h3>
						<hr>
						<div class="progress progress-danger progress-striped active">
							<div class="bar" style="width:66%;">Lengkapi Informasi Project (2/3 langkah)</div>
						</div>
						<hr>
						<div class="alert alert-warning alert-hidden"></div>
						<?php 
							if( isset($cekjuudul) && $cekjuudul == "ada" ) {
								echo '<div class="alert alert-warnin"> judul telah ada </div>';
							}
							echo validation_errors('<div class="alert alert-warnin">', '</div>'); 
						?>
						
						<div class="control-group">
							<label class="control-label" for="focusedInput">Judul Karya Tulis</label>
							<div class="controls">
								<input class="input-xxlarge required" name="project_title" id="" type="text" value="" placeholder="(Judul Jurnal, skripsi, atau karya tulis lainnya)"> <i class="icon-asterisk"></i>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="focusedInput">Deskripsi/Abstrak</label>
							<div class="controls">
								<textarea name="project_content" class="input-xxlarge required" id="textarea" rows="10" placeholder="(Abstrak atau deskripsi karya tulis Anda)"></textarea> <i class="icon-asterisk"></i>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="focusedInput">Keywords</label>
							<div class="controls">
								<input class="input-xxlarge required" name="project_keywords" id="keywords" type="text" value="" placeholder="Pisahkan dengan koma (,)">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="focusedInput">Project URL</label>
							<div class="controls">
								<input class="input-xxlarge required" name="project_link" id="" type="text" value="" placeholder="(isi jika ada)">
							</div>
						</div>
						<?php
							if( $type == 10 ){
							} else {
							
							
						?>
						<div class="control-group">
							<label class="control-label" for="focusedInput">Pembimbing</label>
							<div class="controls">
								<input class="input-xxlarge required" name="project_reviewer" id="" type="text" value="" placeholder="(Pisahkan dengan PIPE '|' contoh : 'nama pertama|nama kedua' )"> <i class="icon-asterisk"></i><i class="icon-question-sign"></i>
							</div>
						</div>
						<?php
							}
						?>
						<hr>
						
						<div class="control-group">
							<label class="control-label" for="focusedInput">Nama Lengkap Anda</label>
							<div class="controls">
								<input class="input-xxlarge required" name="project_author" id="" type="text" value="" placeholder="(lengkapi dengan gelar akademik)"><i class="icon-asterisk"></i>
							</div>
						</div>
						<!--
<div class="control-group">
							<label class="control-label" for="focusedInput">NIM</label>
							<div class="controls">
								<input class="input-large required" name="project_nim" id="" type="text" value="" placeholder="">
							</div>
						</div>
-->
						<div class="control-group">
							<label class="control-label" for="focusedInput">Jurusan/Program Studi</label>
							<div class="controls">
								<select class="span4" id="jurusan_drop" name="project_jurusan" data-dest="<?php echo base_url();?>new_project/select_jur">
									<option value="none">none</option>
									<?php
										foreach( $jurusan as $k => $v ) {
									?>
									<option value="<?php echo $v["jur_name"]?>"><?php echo $v["jur_name"]?></option>
									<?php
										}
									?>
								</select> <i class="icon-asterisk"></i>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="focusedInput">Fakultas</label>
							<div class="controls">
								<!-- <input class="input-xlarge required" id="fakultas_display" name="project_fakultas" id="" type="text"  > -->
								<span class="fak_display"></span>
								<input type="hidden" name="project_fakultas" id="project_fakultas" value="" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="focusedInput">Tingkat Strata</label>
							<div class="controls">
								<select class="span2" name="project_strata">
									<option value="none">none</option>
									<option value="S1">S1</option>
									<option value="S2">S2</option>
									<option value="S3">S3</option>
								</select> <i class="icon-asterisk"></i>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="focusedInput">Tahun Pembuatan</label>
							<div class="controls">
								<?php
									$tahunarr = gen_year();
									$tahun = '';
									foreach ( $tahunarr as $k => $v ) {
										$tahun .= '"'.$v.'"';
										if( $k !== count($tahunarr)-1 ) {
											$tahun .= ',';
										}
									}
								?>
								<input class="input-small tahun-type required" data-provide="typeahead" data-source='[<?php echo $tahun;?>]' name="project_year" id="" type="text" value="" placeholder="" autocomplete="off"> <span class="muted">(Tahun pembuatan project)</span> <i class="icon-asterisk"></i>
							</div>
						</div>
						
						<hr>
						
						<div class="control-group">
							<label class="control-label" for="focusedInput">Jumlah Bab/File</label>
							<div class="controls">
								<select class="span2 select-bab" name="project_chapters">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							</div>
						</div>	
						<div class="control-group">
							<label class="control-label" for="focusedInput">Upload File</label>
							<div class="controls proj-chaps">
								<input class="input-xxlarge upload-input" class="proj-chap-file" type="file" name="project_chap_file_0" size="20">
							</div>
						</div>									
						<div class="form-actions">
							<input type="hidden" name="project_type" value="<?php echo $type;?>" />
							<input type="hidden" name="project_state" value="<?php echo $state;?>" />
							<input type="hidden" name="nextstate" value="<?php echo $nextstate;?>" />
							<input type="hidden" name="currenturl" value="<?php echo $currenturl;?>" />
							<input type="hidden" name="nexturl" value="<?php echo $nexturl;?>" />
							<input type="submit" class="btn" name="back" value="Back To Prev Step">
							<input type="submit" class="btn btn-primary" id="save_project" name="save_project" value="Save and Next Step">
						</div>
					</fieldset>
				</form>
				
			</div><!--/span-->
			
			<div class="span2">
				<?php $this->load->view("right-sidebar");?>
			</div><!--/span-->
			
		</div><!--/row-->
	
		<hr>
	
<?php
	$this->load->view("footer");
?>

	