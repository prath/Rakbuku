<?php
	/******************************************
	* View untuk Dashboard
	* author : pratama hasriyan
	******************************************/

	$this->load->view("header");
	
/* 	print_r($project_data); */
?>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span2">
				<?php $this->load->view("left-sidebar");?>
			</div><!--/span-->
			
			<div class="span8">
			
				<div class="row-fluid">
					<div class="span2 row-fluid">
						<p class="hint-prat">
							<em class="muted">Dibuat pada</em><br>
							<?php echo substr( $project_data[0]["project_made"], 0, 10 )?>
						</p>
						<a href=""><i class="icon-file"></i> <?php echo $type_name[0]["type_name"];?></a>
					</div>
					<div class="span10">
					
						<h3 class="project" style="text-transform: capitalize;">
							<?php echo $project_data[0]["project_title"];?>
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
							
							<div class="span10">
								<?php
									if( !empty($this->data["versions"][0]) ) {
										foreach( $this->data["versions"] as $k => $v ) {
									?>
								<div style="margin-bottom:5px;">
									<?php
											echo $this->data["attachments"][$k][0]["attachment_url"].' - <a href="'.base_url().'uploads/'.$this->data["attachments"][$k][0]["attachment_url"].'">Download</a>';
											
									?>
								</div>
									<?php
										}
									} else {
										echo "tidak memiliki attachment";
									}
								?>
							</div>
							<div class="clr"></div>
						</div>
						
						<div class="well hint-prat muted">
							<table class="table table-prat">
								<?php
									if( !empty($site_settings) )
									{
										foreach( $site_settings as $k => $v) {
								?>
								<tr>
									<td style="width:25%;"><strong><?php echo $v["site_settings_key"];?><strong></td>
									<td><?php echo $v["site_settings_value"];?></td>
								</tr>
								<?php
										}
									}
								?>
							</table>
						</div>
						

					</div>
				</div>
				
			</div><!--/span-->
			
			<div class="span2">
				<?php 
					$this->load->view("right-sidebar");
				?>
			</div><!--/span-->
			
		</div><!--/row-->
	
		<hr>
	
<?php
	$this->load->view("footer");
?>

	