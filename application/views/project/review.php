<?php
	/******************************************
	* View untuk Dashboard
	* author : pratama hasriyan
	******************************************/

	$this->load->view("header");
	
	$users = '';
	foreach ( $user_names as $k => $v ) {
		$users .= '"'.$v.'"';
		if( $k !== count($user_names)-1 ) {
			$users .= ',';
		}
	}
?>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span2">
				<?php $this->load->view("left-sidebar");?>
			</div><!--/span-->
			
			<div class="span8">
			
				<div class="row-fluid">
					<div class="span2 row-fluid">
						<div class="span10 btn btn-small <?php if( $project_data[0]["project_status"] == "approved" ) { echo "btn-danger"; };?> no-clickable">
							<i class="icon-book"></i> 
							<?php
								if( $project_data[0]["project_status"] == "review" ) {
									echo "Drafts";
								} else {
									echo "Finished";
								}
							?>
						</div>
						<br><br>
						<p class="hint-prat">
							<em class="muted">Dibuat pada</em><br>
							<?php echo substr( $project_data[0]["project_made"], 0, 10 )?>
						</p>
						<a href=""><i class="icon-file"></i> <?php echo $type_name[0]["type_name"];?></a>
						<br><br>
						
						<?php
							//print_r($current_reviewers);
							$names = get_user_names($current_reviewers);
							if( $names )
							{
								echo '<strong class="hint-prat">Reviewer</strong><br>';
								foreach($names as $k => $v) {
									if($current_reviewers[0]["reviewer_status"] == "invited") {
							?>
								<div href="" class="span10 btn btn-small disabled no-clickable"><?php echo $v;?> (belum confirm)</div>
							<?php
									} else {
							?>
								<div href="" class="span10 btn <?php echo ($current_reviewers[$k]["user_id"] == $current_user_id ) ? "btn-primary" : "";?> btn-small disabled no-clickable"><?php echo $v;?></div><br><br><br>
							<?php
									}
								}
							}
						?>
						
					</div>
					
					
					
					
					<div class="span10">
						<?php
							if($self_project && $project_data[0]["project_status"] == "approved") {
						?>
						<div class="alert alert-info">
						Project ini telah mendapatkan persetujuan reviewer, silahkan Anda publikasikan project Anda dengan menekan tombol di sidebar kanan
						<br><br>
						<a href="<?php echo base_url()."review/".$project_data[0]["project_url"].'/open_project'; ?>">click disini</a> jika Anda ingin membuka kembali project ini. harap diingat, jika Anda membuka project ini, Anda harus membuka satu per satu halaman bab, selain itu, Anda juga harus membuka mendapatkan persetujuan reviewer kembali untuk dapat mempublikasikan kembali project ini
						</div>
						<?php 
							}
							($self_project && $project_data[0]["project_status"] == "review") ? $this->load->view("project/reviewer_status", $reviewers_invite) : '' ;
						?>
					
						<h3 class="project" style="text-transform: capitalize;">
							<?php echo $project_data[0]["project_title"];?>
							<?php
								if ($self_project && $project_data[0]["project_status"] == "review") {
							?>
							<a class="edit-project-button" href="<?php echo base_url()."review/".$project_data[0]["project_url"].'/edit_project'; ?>">
								<i class="icon-pencil"></i>
							</a>
							<?php
								}
							?>
						</h3>
						<hr />
						
						
						<p class="muted hint-prat">
							<strong class="caped"><?php echo $type_name[0]["type_name"];?></strong>  
							Oleh : <strong><a  lass="caped" href="<?php echo base_url()."user/".$author_url; ?>"><?php echo $author_name;?></a></strong><br>Jurusan : <strong class="caped"><?php echo $project_data[0]["project_jurusan"];?></strong> / Strata : <strong class="caped"><?php echo $project_data[0]["project_strata"];?></strong> / Fakultas : <strong class="caped"><?php echo $project_data[0]["project_fakultas"];?></strong><br>
							<span class="allcaps">Universitas Islam Sunan Gunung Djati Bandung</span><br>
							Pembimbing : 
							<?php
								$c = count($reviewers);
								foreach( $reviewers as $k => $v ) {
									echo $pembimbing = '<strong class="caped">'.$v.'</strong>';
									if($k !== $c-1) {
										echo ' &amp; ';
									}
								}
							?>
							<br>
							<em>dibuat <?php echo $project_data[0]["project_year"]; ?> dengan <?php echo $project_data[0]["project_chapter_num"]; ?> Dokumen</em>
						</p>
						<hr />
						
						<p>
							<h4>Abstract</h4><br>
							<?php echo $project_data[0]["project_content"] ?>
							<br><br>
							<span>
								<em><strong>
									keywords :
								</strong></em>
								<?php
									if( !empty( $project_data[0]["project_keywords"]) ) {
										$unseri = unserialize($project_data[0]["project_keywords"]);
										echo implode(", ", $unseri);
									}
									//echo $project_data[0]["project_keywords"];
								?>
							</span><br>
							<span>
								Project Url :
								
								<?php
									if( !empty( $project_data[0]["project_link"]) ) {
										echo '<a href="'.$project_data[0]["project_link"].'">'.$project_data[0]["project_link"].'</a>';
									}
									//echo $project_data[0]["project_keywords"];
								?>
							</span>
						</p>
						<hr>
						
						<div class="alert alert-info">
							<h4>Daftar Dokumen</h4><br>
							<?php
							if ($self_project && $project_data[0]["project_status"] == "review") {
								if( isset($project_chapters) ) {
							?>
							<a class="flr" href="<?php echo base_url().'review/'.$project_data[0]["project_url"].'/add_bab';?>"><i class="icon-plus"></i> Tambah Bab Baru</a>
							<?php
								} else {
									if(! $project_data[0]["project_attachment_count"] == 0 ){
							?>
							<a class="flr" href="<?php echo base_url()."review/".$project_data[0]["project_url"]."/upload_rev/";?>"><i class="icon-arrow-up"></i> Upload Revisi Baru</a>
							<?php
									}
								}
							}
							?>
							<div class="span10">
								<?php
								if( isset($project_chapters) ) {
									foreach( $project_chapters as $k => $v) {
								?>
								<div style="margin-bottom:5px;">
									<a class="btn btn-small" href="<?php echo base_url()."review/".$project_data[0]["project_url"]."/".$v["project_url"];?>"><?php echo $v["project_title"];?></a> 
									<span class="hint-prat">
										-  <?php echo substr( $project_data[0]["project_made"], 0, 10 )?> - 
										<?php
											if( $v["project_status"] == "review" ) {
												echo "Drafts";
											} else {
												echo "Finished";
											}
										?>
									</span>
									<?php 
										if( $v["project_attachment_count"] == 0 ){
									?>
									 - belum ada attachment <?php if($self_project){ ?><a href="<?php echo base_url()."review/".$project_data[0]["project_url"]."/upload_file/".$v["project_url"];?>">click disini untuk upload</a><?php };?>
									 <br>
									 <?php
									 	} else {
										 	echo $v["project_attachment_count"].' buah file attachment';
										 	if($self_project && $v["project_status"] == "review") {
										 	echo '- <a href="'.base_url().'review/'.$project_data[0]["project_url"].'/delete_bab/'.$v["project_id"].'">delete</a>';
										 	}
									 	}
									 ?>
								</div>
								<?php
									}
								} else {
									if( $project_data[0]["project_attachment_count"] == 0 ){
								?>
									 - belum ada attachment <?php if($self_project){ ?><a href="<?php echo base_url().'review/'.$project_data[0]["project_url"].'/add_bab';?>">click disini untuk upload</a><?php };?>
									 <br>
									 <?php		
									} else {
										foreach( $this->data["versions"] as $k => $v ) {
									?>
								<div style="margin-bottom:5px;">
									<i class="icon-arrow-down icon-white"></i> 
									<?php
											echo '[ versi : '.$v["version_number"].' ] - '.$this->data["attachments"][$k][0]["attachment_url"].' - <a href="'.base_url().'uploads/'.$this->data["attachments"][$k][0]["attachment_url"].'">Download</a>';
											if($self_project) {
												echo '- <a href="'.base_url().'review/'.$project_data[0]["project_url"].'/delete_file/'.$v["version_id"].'">delete</a>';
											}
									?>
								</div>
									<?php
										}
									}
								}
								?>
							</div>
							<div class="clr"></div>
						</div>
						
						<!--
<div>
							<a class="btn btn-success btn-small flr" href="#"><i class="icon-white icon-download-alt"></i> Download files (zip 32Kb)</a>
							<div class="clr"></div>
						</div>
-->
						<!--======@[ BLOCK KOMENTAR ]@======-->
						<hr>
						<?php
							if( $project_data[0]["project_status"] == "approved" ) {
						?>
						<div class="alert alert-danger">Project ini telah mendapatkan persetujuan reviewer</div>
						<?php
							} else {
						?>
						<div class="comment">
							<h4>Review</h4>
							<span class="muted hint-prat"><em>Bimbingan dapat dilakukan disini</em></span>
						</div>
						<hr>
						<div class="row-fluid">
							
							<?php
								if( $reviews ) {
									foreach( $reviews as $k => $v ) {
							?>
							<div class="comment-holder">
								<div class="comment-meta">
									<?php if($commentor[$k][0]["role"] == "reviewer") { ?><i class="icon-search"></i><?php }else{ ?><i class="icon-pencil"></i><?php } ?> <h5 class="comment-author non-block" <?php if($commentor[$k][0]["role"] == "author") { ?>style="color:#FAA732;"<?php } ?>><strong><?php echo $commentor[$k][0]["fullname"];?></strong></h5> - <em>pada <span class="muted hint-prat comment-date"><?php echo substr( $v["review_date"], 0, 10 )?></span></em>
								</div>
								<div class="comment-content">
									<p>	
										<?php echo $v["review_content"] ;?>
									</p>	
								</div>
								<hr class="narrow-muted">
							</div>
							<?php
									}
								} else {
							?>
							<div class="comment-holder">
								<div class="comment-meta">
									<span class="muted hint-prat comment-date">Belum ada review</span>
								</div>
								<hr class="narrow-muted">
							</div>
							<?php
								}
							?>
							<!-- comment form  -->	
							<div class="comment-holder">
								<div class="comment-meta">
									<h5>Tulis Review/Komentar</h5>
								</div>
								<div class="alert alert-warning alert-hidden alert-comment"></div>
								<form id="form-comment" action="<?php echo base_url()."review/".$project_data[0]["project_url"]."/send_comment";?>" method="post">
									<div class="controls">
										<textarea name="comment_content" class="input-xxlarge" id="comment-content" rows="3" placeholder="Komentar Anda disini"></textarea>
									</div>
									<input type="hidden" name="projid" value="<?php echo $current_project_id;?>" />
									<input type="hidden" name="userid" value="<?php echo $current_user_id;?>" />
									<input type="hidden" name="projurl" value="<?php echo $project_data[0]["project_url"];?>" />
									<input type="submit" class="btn btn-primary" name="submit_comment" id="submit_comment" value="Kirim Review/Komentar" >
								</form>
							</div>						
						</div>
						<?php
							}
						?>

					</div>
				</div>
				
			</div><!--/span-->
			
			<div class="span2">
				<?php 
					if( isset( $project_parent ) )
						$prodata["project_parent"] = $project_parent;
					$prodata["project"] = $project_data;
					$prodata["self_project"] = $self_project;
					$this->load->view("right-sidebar-review", $prodata);
				?>
			</div><!--/span-->
			
		</div><!--/row-->
	
		<hr>
	
<?php
	$this->load->view("footer");
?>

	