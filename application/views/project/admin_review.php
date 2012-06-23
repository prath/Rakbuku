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
			
				<div class="row-fluid">
					<div class="span2 row-fluid">
						<div class="span10 btn btn-small btn-warning no-clickable">
							<i class="icon-search"></i> 
							Admin Review
						</div>
						<br><br>
						<p class="hint-prat">
							<em class="muted">Dibuat pada</em><br>
							<?php echo substr( $project_data[0]["project_made"], 0, 10 )?>
						</p>
						<a href=""><i class="icon-file"></i> <?php echo $types[0]["type_name"];?></a>
					</div>
					<div class="span10">
					
						<h3 class="project" style="text-transform: capitalize;">
							<?php echo $project_data[0]["project_title"];?>
							
						</h3>
						<hr />
						
						
						<p class="muted hint-prat">
							<strong class="caped"><?php echo $types[0]["type_name"];?></strong>  
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
							if($self_project) {
							?>
							<a class="flr" href="<?php echo base_url()."admin_review/".$project_data[0]["project_url"]."/upload_other";?>"><i class="icon-arrow-up"></i> Upload File</a>
							<!-- <a class="flr" href="<?php //echo base_url()."admin_review/".$project_data[0]["project_url"]."/tambah_bab";?>"><i class="icon-arrow-up"></i> Tambah Bab</a> -->
							<?php
							}	
							?>
							<div class="span10">
								<?php
									if( $project_data[0]["project_attachment_count"] == 0 ){
								?>
									 - tidak ada attachment 
									 <?php		
									} else {
										
										foreach( $this->data["versions"] as $k => $v ) {
									?>
								<div style="margin-bottom:5px;">
									<?php
											echo $this->data["attachments"][$k][0]["attachment_url"].' - <a href="'.base_url().'uploads/'.$this->data["attachments"][$k][0]["attachment_url"].'">Download</a>';
											if($self_project && $project_data[0]["project_status"] == "review") {
											echo ' - <a href="'.base_url().'review/'.$project_parent[0]["project_url"].'/delete_file/'.$v["version_id"].'">delete</a>';
											}
									?>
								</div>
									<?php
										}
									}
								?>
							</div>
							<div class="clr"></div>
						</div>
						
						
						
						<!--======@[ BLOCK KOMENTAR ]@======-->
						<?php
							if(!$is_admin) {
								//if( !empty($admin_reviews) ) {
							
						?>
						<div class="alert alert-danger">
							<a href="<?php echo base_url()."admin_review/".$project_data[0]["project_url"]."/go_back_edit";?>">Click disini untuk memperbaiki dokumen Anda</a> 
						</div>
						<?php
								//}
							}
						?>
						<hr>
						<div class="comment">
							<h4>Review</h4>
							<span class="muted hint-prat"><em>Bimbingan dapat dilakukan disini</em></span>
						</div>
						<hr>
						<div class="row-fluid">
							
							<?php
								if( !empty($admin_reviews) ) {
									foreach( $admin_reviews as $k => $v ) {
							?>
							<div class="comment-holder">
								<div class="comment-meta">
									<h5 class="comment-author non-block"><strong><?php echo $commentor[$k][0]["fullname"];?></strong></h5> - <em>pada <span class="muted hint-prat comment-date"><?php echo substr( $v["admin_review_date"], 0, 10 )?></span></em>
								</div>
								<div class="comment-content">
									<p>	
										<?php echo $v["admin_review_content"] ;?>
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
								<form id="form-comment" action="<?php echo base_url()."admin_review/".$project_data[0]["project_url"]."/send_comment";?>" method="post">
									<div class="controls">
										<textarea name="comment_content" class="input-xxlarge" id="comment-content" rows="3" placeholder="Komentar Anda disini"></textarea>
									</div>
									<input type="hidden" name="projid" value="<?php echo $project_data[0]["project_id"];?>" />
									<input type="hidden" name="userid" value="<?php echo $current_user_id;?>" />
									<input type="hidden" name="projurl" value="<?php echo $project_data[0]["project_url"];?>" />
									<input type="submit" class="btn btn-primary" name="submit_comment" id="submit_comment" value="Kirim Review/Komentar" >
								</form>
							</div>						
						</div>
						

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

	