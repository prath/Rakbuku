<?php
	/******************************************
	* View untuk Profile (including edit datum)
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
			
				<h2 class="profile-dashboard-title">
				<?php 
					if($user_data[0]['user_front_title']) {
						echo $user_data[0]['user_front_title'].'. ';
					}
					echo $user_data[0]['user_firstname'].' '.$user_data[0]['user_middlename'].' '.$user_data[0]['user_lastname'].' ';
					if($user_data[0]['user_back_title']) {
						echo $user_data[0]['user_back_title'];
					}
				?>
				</h2>
				<?php
					$user_url = ($user_data[0]['user_unique_url']=='') ? $user_data[0]['user_activation_key'] : $user_data[0]['user_unique_url']; 
				?>
				<a href="<?php echo base_url().'user/'.$user_url;?>" class="help-block" id="user_url">
					http://localhost/rakbuku/user<span>/<?php echo $user_url;?></span>
				</a>
				<hr />
				
				<div class="tabbable">
					<input id="url" type="hidden" name="url" value="<?php echo base_url().'user/'.$user_url.'/load_templ';?>">
					<?php $this->load->view("user/nav-dashboard");?>
					
					<div class="tab-content">
						<div class="tab-pane active" id="1">
							<div class="row-fluid">
							
								<!--===[ LEFT CONTENT ]===-->
								<div class="span6">
									<!--===[ PERSONAL INFO ]===-->
									<div>
										<h5 class="group-title"><em>Personal Info</em><?php if(is_own_profile($uurl, $current_user)){ ?><a class="edit-button" href="#"><i class="icon-pencil"></i></a><?php };?></h5><hr />
										
										<!--===[ NAMA LENGKAP ]===-->
										<div class="item-holder">
											<div class="span4 span-templ">
												<strong class="muted">Nama Lengkap</strong> 
											</div>
											<div class="span7 item-value editable">
												<span class="data-value"><?php echo (empty($user_data[0]["user_front_title"])) ? "" : $user_data[0]["user_front_title"].'. ';?><?php echo $names;?><?php echo (empty($user_data[0]["user_back_title"])) ? "" : ', '.$user_data[0]["user_back_title"];?></span>
												<form class="edit-data" data-dest="name" action="<?php echo base_url()?>user/<?php echo $user_url;?>/update_user_profile">
													<input type="text" class="input-large span12" name="user_front_title" value="<?php echo (empty($user_data[0]["user_front_title"])) ? "" : $user_data[0]["user_front_title"];?>" placeholder="Gelar">
													<input type="text" class="input-large span12" name="user_firstname" value="<?php echo (empty($user_data[0]["user_firstname"])) ? "" : $user_data[0]["user_firstname"];?>" placeholder="Nama Depan">
													<input type="text" class="input-large span12" name="user_middlename" value="<?php echo (empty($user_data[0]["user_middlename"])) ? "" : $user_data[0]["user_middlename"];?>" placeholder="Nama Tengah">
													<input type="text" class="input-large span12" name="user_lastname" value="<?php echo (empty($user_data[0]["user_lastname"])) ? "" : $user_data[0]["user_lastname"];?>" placeholder="Nama Belakang">
													<input type="text" class="input-large span12" name="user_back_title" value="<?php echo (empty($user_data[0]["user_back_title"])) ? "" : $user_data[0]["user_back_title"];?>" placeholder="Gelar">
													<input type="submit" value="Save Changes" class="save-btn btn btn-primary" >
												</form>
											</div>
											<div class="clr"></div>
											<hr class="item-separator" />
										</div>
										
										<!--===[ EMAIL ]===-->
										<div class="item-holder">
											<div class="span4 span-templ">
												<strong class="muted">Email</strong> 
											</div>
											<div class="span7 item-value editable">
												<span class="data-value"><?php echo $user_data[0]["user_email"];?></span>
												<form class="edit-data" data-dest="email" action="<?php echo base_url()?>user/<?php echo $user_url;?>/update_user_profile">
													<input type="text" class="input-large span12" name="user_email" value="<?php echo (empty($user_data[0]["user_email"])) ? "" : $user_data[0]["user_email"];?>" placeholder="Email">
													<input type="submit" value="Save Changes" class="save-btn btn btn-primary" >
												</form>
											</div>
											<div class="clr"></div>
											<hr class="item-separator" />
										</div>
										
										<!--===[ ALAMAT ]===-->
										<div class="item-holder">
											<div class="span4 span-templ">
												<strong class="muted">Alamat</strong> 
											</div>
											<div class="span7 item-value editable">
												<span class="data-value"><?php echo (empty($user_meta["alamat"])) ? "" : $user_meta["alamat"];?></span>
												<form class="edit-data" data-dest="alamat" action="<?php echo base_url()?>user/<?php echo $user_url;?>/update_user_meta/alamat">
													<textarea class="input-large span12" rows="3" name="user_address" placeholder="Alamat"><?php echo (empty($user_meta["alamat"])) ? "" : $user_meta["alamat"];?></textarea>
													<input type="submit" value="Save Changes" class="save-btn btn btn-primary" >
												</form>
											</div>
											<div class="clr"></div>
											<hr class="item-separator" />
										</div>
										
										<!--===[ BIO ]===-->
										<div class="item-holder">
											<div class="span4 span-templ">
												<strong class="muted">Bio</strong> 
											</div>
											<div class="span7 item-value editable">
												<span class="data-value"><?php echo (empty($user_meta["bio"])) ? "" : $user_meta["bio"];?></span>
												<form class="edit-data" data-dest="bio" action="<?php echo base_url()?>user/<?php echo $user_url;?>/update_user_meta/bio">
													<textarea class="input-large span12" rows="3" name="user_bio" placeholder="Short Bio"><?php echo (empty($user_meta["bio"])) ? "" : $user_meta["bio"];?></textarea>
													<input type="submit" value="Save Changes" class="save-btn btn btn-primary" >
												</form>
											</div>
											<div class="clr"></div>
											<hr class="item-separator" />
										</div>
									</div>
									
									<!--===[ AKADEMIK INFO ]===-->
									<div>
										<h5 class="group-title"><em>Akademik Info</em><?php if(is_own_profile($uurl, $current_user)){ ?><a class="edit-button" href="#"><i class="icon-pencil"></i></a><?php };?></h5><hr />
										
										<!--===[ JURUSAN ]===-->
										<div class="item-holder">
											<div class="span4 span-templ">
												<strong class="muted">Jurusan</strong>
											</div>
											<div class="span7 item-value editable">
												<span class="data-value"><?php echo $jurusan[0]["jur_name"];?></span>
												<form class="edit-data" data-dest="jurusan" action="<?php echo base_url()?>user/<?php echo $user_url;?>/update_user_profile">
												<?php
													$jurarr = '';
													foreach ($alljurusan as $key => $value) {
														$jurarr .= '"'.$value["jur_name"].'"';
														if($key !== count($alljurusan)-1)
														{
															$jurarr .= ',';
														}
													}
												?>
													<input type="text" class="input-large span12" data-provide="typeahead" data-source='[<?php echo $jurarr;?>]' name="jur_name" value="<?php echo (empty($jurusan[0]["jur_name"])) ? "" : $jurusan[0]["jur_name"];?>" placeholder="Jurusan">
													<input type="submit" value="Save Changes" class="save-btn btn btn-primary" >
												</form>
											</div>
											<div class="clr"></div>
											<hr class="item-separator" />
										</div>
										
										<!--===[ FAKULTAS ]===-->
										<div class="item-holder">
											<div class="span4 span-templ">
												<strong class="muted">Fakultas</strong>
											</div>
											<div class="span7 item-value editable">
												<span class="data-value" id="fak_name"><?php echo $jurusan[0]["fak_name"];?></span>
											</div>
											<div class="clr"></div>
											<hr class="item-separator" />
										</div>
									</div>
								</div>
								
								<!--===[ RIGHT CONTENT ]===-->
								<div class="span6">
									<!--===[ PENDIDIKAN ]===-->
									<div>
										<h5 class="group-title"><em>Pendidikan</em><?php if(is_own_profile($uurl, $current_user)){ ?><a class="edit-button" href="#"><i class="icon-pencil"></i></a><?php };?></h5><hr />
										
										<!--===[ S1 ]===-->
										<div class="item-holder">
											<div class="span4 span-templ">
												<strong class="muted">S1</strong>
											</div>
											<div class="span7 item-value editable">
												<?php
													if( !empty($user_meta["s1"]) ) {
														$s1 = unserialize($user_meta["s1"]);
													}
												?>
												<div><em class="muted">Universitas : </em><span class="data-value"><?php echo (empty($s1["pendidikan_s1"])) ? "" : $s1["pendidikan_s1"];?><br></span></div>
												<div><em class="muted">Tahun Lulus : </em><span class="data-value"><?php echo (empty($s1["pendidikan_s1_tahun"])) ? "" : $s1["pendidikan_s1_tahun"];?><br></span></div>
												<div><em class="muted">Jurusan : </em><span class="data-value"><?php echo (empty($s1["pendidikan_s1_jurusan"])) ? "" : $s1["pendidikan_s1_jurusan"];?></span></div>
												<form class="edit-data" data-dest="s1" data-type="serialize" action="<?php echo base_url()?>user/<?php echo $user_url;?>/update_user_meta/s1">
													<input type="text" class="input-large span12" name="pendidikan_s1" value="<?php echo (empty($s1["pendidikan_s1"])) ? "" : $s1["pendidikan_s1"];?>" placeholder="Universitas/Institut/Perguruan Tinggi">
													<input type="text" class="input-small" name="pendidikan_s1_tahun" value="<?php echo (empty($s1["pendidikan_s1_tahun"])) ? "" : $s1["pendidikan_s1_tahun"];?>" placeholder="Tahun Lulus"><br>
													<input type="text" class="input-large span12" name="pendidikan_s1_jurusan" value="<?php echo (empty($s1["pendidikan_s1_jurusan"])) ? "" : $s1["pendidikan_s1_jurusan"];?>" placeholder="Jurusan">
													<input type="submit" value="Save Changes" class="save-btn btn btn-primary" >
												</form>
											</div>
											<div class="clr"></div>
											<hr class="item-separator" />
										</div>
										
										<!--===[ S2 ]===-->
										<div class="item-holder">
											<div class="span4 span-templ">
												<strong class="muted">S2</strong>
											</div>
											<div class="span7 item-value editable">
												<?php
													if( !empty($user_meta["s2"]) ) {
														$s2 = unserialize($user_meta["s2"]);
													}
												?>
												<div><em class="muted">Universitas : </em><span class="data-value"><?php echo (empty($s2["pendidikan_s2"])) ? "" : $s2["pendidikan_s2"];?><br></span></div>
												<div><em class="muted">Tahun Lulus : </em><span class="data-value"><?php echo (empty($s2["pendidikan_s2_tahun"])) ? "" : $s2["pendidikan_s2_tahun"];?><br></span></div>
												<div><em class="muted">Jurusan : </em><span class="data-value"><?php echo (empty($s2["pendidikan_s2_jurusan"])) ? "" : $s2["pendidikan_s2_jurusan"];?></span></div>
												<form class="edit-data" data-dest="s2" data-type="serialize" action="<?php echo base_url()?>user/<?php echo $user_url;?>/update_user_meta/s2">
													<input type="text" class="input-large span12" name="pendidikan_s2" value="<?php echo (empty($s2["pendidikan_s2"])) ? "" : $s2["pendidikan_s2"];?>" placeholder="Universitas/Institut/Perguruan Tinggi">
													<input type="text" class="input-small" name="pendidikan_s2_tahun" value="<?php echo (empty($s2["pendidikan_s2_tahun"])) ? "" : $s2["pendidikan_s2_tahun"];?>" placeholder="Tahun Lulus"><br>
													<input type="text" class="input-large span12" name="pendidikan_s2_jurusan" value="<?php echo (empty($s2["pendidikan_s2_jurusan"])) ? "" : $s2["pendidikan_s2_jurusan"];?>" placeholder="Jurusan">
													<input type="submit" value="Save Changes" class="save-btn btn btn-primary" >
												</form>
											</div>
											<div class="clr"></div>
											<hr class="item-separator" />
										</div>
										
										<!--===[ S3 ]===-->
										<div class="item-holder">
											<div class="span4 span-templ">
												<strong class="muted">S3</strong>
											</div>
											<div class="span7 item-value editable">
												<?php
													if( !empty($user_meta["s3"]) ) {
														$s3 = unserialize($user_meta["s3"]);
													}
												?>
												<div><em class="muted">Universitas : </em><span class="data-value"><?php echo (empty($s3["pendidikan_s3"])) ? "" : $s3["pendidikan_s3"];?><br></span></div>
												<div><em class="muted">Tahun Lulus : </em><span class="data-value"><?php echo (empty($s3["pendidikan_s3_tahun"])) ? "" : $s3["pendidikan_s3_tahun"];?><br></span></div>
												<div><em class="muted">Jurusan : </em><span class="data-value"><?php echo (empty($s3["pendidikan_s3_jurusan"])) ? "" : $s3["pendidikan_s3_jurusan"];?></span></div>
												<form class="edit-data" data-dest="s3" data-type="serialize" action="<?php echo base_url()?>user/<?php echo $user_url;?>/update_user_meta/s3">
													<input type="text" class="input-large span12" name="pendidikan_s3" value="<?php echo (empty($s3["pendidikan_s3"])) ? "" : $s3["pendidikan_s3"];?>" placeholder="Universitas/Institut/Perguruan Tinggi">
													<input type="text" class="input-small" name="pendidikan_s3_tahun" value="<?php echo (empty($s3["pendidikan_s3_tahun"])) ? "" : $s3["pendidikan_s3_tahun"];?>" placeholder="Tahun Lulus"><br>
													<input type="text" class="input-large span12" name="pendidikan_s3_jurusan" value="<?php echo (empty($s3["pendidikan_s3_jurusan"])) ? "" : $s3["pendidikan_s3_jurusan"];?>" placeholder="Jurusan">
													<input type="submit" value="Save Changes" class="save-btn btn btn-primary" >
												</form>
											</div>
											<div class="clr"></div>
											<hr class="item-separator" />
										</div>
									</div>
								</div>
							</div>
							
							<?php 
								if ( is_own_profile($uurl, $current_user) ) { 
							?>
							<div class="row-fluid">
								<!--===[ RUBAH PASSWORD ]===-->
								<div class="span12">
									<div>
										<h5 class="group-title"><em>Rubah Password</em><?php if(is_own_profile($uurl, $current_user)){ ?><a class="edit-button" href="#"><i class="icon-pencil"></i></a><?php };?></h5><hr />
										
										<!--===[ Password ]===-->
										<div class="item-holder">
											<div class="span3 span-templ">
												<strong class="muted">Password</strong> 
											</div>
											<div class="span8 item-value editable">
												<span class="data-value">**********</span>
												<form class="edit-data" data-dest="pass" action="<?php echo base_url();?>user/<?php echo $user_url;?>/update_user_profile">
													<span class="temp"></span>
													<input type="password" class="input-large span12" id="user_pass" name="user_pass" placeholder="Password Baru">
													<input type="password" class="input-large span12" id="re_user_pass" placeholder="Password Baru Lagi">
													<i class="icon-ok form-status-ok"></i>
													<i class="icon-remove form-status-notok"></i>
													<input type="submit" value="Save Password Baru" class="save-btn btn btn-primary submit-pass" >
												</form>
											</div>
											<div class="clr"></div>
											<hr class="item-separator" />
										</div>
										
									</div>
								</div>
							</div>
							
							
							<?php
								}
							?>

						</div>
					</div>
				</div>
				
			</div><!--/span-->
			
			<div class="span2">
				<?php $this->load->view("right-sidebar");?>
			</div><!--/span-->
			
		</div><!--/row-->
	
		<hr>
	
<?php
	$this->load->view("footer");
?>

	