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
				<form class="form-horizontal" id="new_project" action="<?php echo base_url();?>review/<?php echo $project_data[0]["project_url"];?>/save_edit" method="post" accept-charset="utf-8" enctype="multipart/form-data">
					<fieldset>
						<h3>Edit Project : <?php echo $project_data[0]["project_title"];?></h3>
						<hr>
						
						<div class="control-group">
							<label class="control-label" for="focusedInput">Judul Karya Tulis</label>
							<div class="controls">
								<input class="input-xxlarge required" name="project_title" id="" type="text" value="<?php echo $project_data[0]["project_title"];?>" placeholder="(Judul Jurnal, skripsi, atau karya tulis lainnya - Harus Diisi)">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="focusedInput">Deskripsi/Abstrak</label>
							<div class="controls">
								<textarea name="project_content" class="input-xxlarge required" id="textarea" rows="10" placeholder="(Abstrak atau deskripsi karya tulis Anda - Harus Diisi)"><?php echo $project_data[0]["project_content"];?></textarea>
							</div>
						</div>
						
						<div class="control-group">
							<?php
								if( !empty( $project_data[0]["project_keywords"]) ) {
									$unseri = unserialize($project_data[0]["project_keywords"]);
									$keys = implode(", ", $unseri);
								}
							?>
							<label class="control-label" for="focusedInput">Keywords</label>
							<div class="controls">
								<input class="input-xxlarge required" name="project_keywords" id="keywords" type="text" value="<?php echo (!empty( $project_data[0]["project_keywords"])) ? $keys : "";?>" placeholder="Pisahkan dengan koma (,)">
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="focusedInput">Project URL</label>
							<div class="controls">
								<input class="input-xxlarge required" name="project_link" id="" type="text" value="<?php echo (!empty( $project_data[0]["project_link"])) ? $project_data[0]["project_link"] : "";?>" placeholder="(isi jika ada)">
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="focusedInput">Pembimbing</label>
							<div class="controls">
								<?php
									$c = count($reviewers);
									$pembimbing = "";
									foreach( $reviewers as $k => $v ) {
									 	$pembimbing .= $v;
										if($k !== $c-1) {
											$pembimbing .= '|';
										}
									}
								?>
								<input class="input-xxlarge required" name="project_reviewer" id="" type="text" value="<?php echo $pembimbing;?>" placeholder="(Pisahkan dengan PIPE '|' contoh : 'nama pertama|nama kedua')"><br><span class="muted">(Harus diisi untuk type project : jurnal, skripsi, disertasi, tesis dan laporan kerja praktik. Pisahkan dengan PIPE '|' contoh : 'nama pertama|nama kedua')</span>
							</div>
						</div>
						
						<hr>
						
						<div class="control-group">
							<label class="control-label" for="focusedInput">Nama Lengkap Anda</label>
							<div class="controls">
								<input class="input-xxlarge required" name="project_author" id="" type="text" value="<?php echo $author_name;?>" placeholder="(lengkapi dengan gelar akademik - Harus Diisi)">
							</div>
						</div>
						
						
						<div class="control-group">
							<label class="control-label" for="focusedInput">Jurusan/Program Studi</label>
							<div class="controls">
								<select class="span4" id="jurusan_drop" name="project_jurusan" data-dest="<?php echo base_url();?>new_project/select_jur">
									<option value="none">none</option>
									<?php
										
										foreach( $jurusan as $k => $v ) {
									?>
									<option <?php echo $jur = ( $project_data[0]["project_jurusan"] === $v["jur_name"] ) ? 'selected="selected"' : '';?> value="<?php echo $v["jur_name"]?>"><?php echo $v["jur_name"]?></option>
									<?php
										}
									?>
								</select>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="focusedInput">Fakultas</label>
							<div class="controls">
								<!-- <input class="input-xlarge required" id="fakultas_display" name="project_fakultas" id="" type="text"  > -->
								<span class="fak_display"><?php echo $project_data[0]["project_fakultas"]?></span>
								<input type="hidden" name="project_fakultas" id="project_fakultas" value="<?php echo $project_data[0]["project_fakultas"]?>" />
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="focusedInput">Tingkat Strata</label>
							<div class="controls">
								<select class="span2" name="project_strata">
									<option value="none">none</option>
									<option value="S1" <?php echo $sl = ( $project_data[0]["project_strata"] === "S1" ) ? 'selected="selected"' : '';?>>S1</option>
									<option value="S2" <?php echo $sl = ( $project_data[0]["project_strata"] === "S2" ) ? 'selected="selected"' : '';?>>S2</option>
									<option value="S3" <?php echo $sl = ( $project_data[0]["project_strata"] === "S3" ) ? 'selected="selected"' : '';?>>S3</option>
								</select>
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
								<input class="input-small tahun-type required" data-provide="typeahead" data-source='[<?php echo $tahun;?>]' name="project_year" id="" type="text" value="<?php echo $project_data[0]["project_year"]; ?>" placeholder="" autocomplete="off"> <span class="muted">(Tahun pembuatan project - Harus Diisi)</span>
							</div>
						</div>
														
						<div class="form-actions">
							<input type="hidden" value="<?php echo $project_data[0]["project_id"]; ?>" name="project_id">
							<a class="reset btn" href="<?php echo base_url().'review/'.$project_data[0]["project_url"];?>">Back</a>
							<input type="submit" class="btn btn-primary" id="edit_project" name="edit_project" value="Edit Project">
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

	