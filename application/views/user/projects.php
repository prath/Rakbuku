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
				<h2 style="text-transform: capitalize;">
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
				<div>
					<?php $this->load->view("user/nav-dashboard");?>
				</div>
				<div class="tabbable">
					
					<div class="tab-content">
						<div class="tab-pane active" id="1">
							<div class="row-fluid">
							<?php
								if(is_own_profile($uurl, $current_user)) {
							?>
								<span class="hint-prat muted">Ini adalah daftar project yang Anda Buat (Sedang dalam proses review maupun yang telah di publish)</span>
							<?php
								} else {
							?>
								<span class="hint-prat muted">Ini adalah daftar project yang dimiliki 
									<?php 
										if($user_data[0]['user_front_title']) {
											echo $user_data[0]['user_front_title'].'. ';
										}
										echo $user_data[0]['user_firstname'].' '.$user_data[0]['user_middlename'].' '.$user_data[0]['user_lastname'].' ';
										if($user_data[0]['user_back_title']) {
											echo $user_data[0]['user_back_title'];
										}
									?>
								</span>
							<?php
								}
							?>
								<hr>
								<?php
									if( !empty($projects) ) {
								?>
								<table class="table table-striped hint-prat">
									<thead>
										<tr>
											<th style="width:50%">Judul Project</th>
											<th style="width:12%">Type Project</th>
											<th style="width:12%">Status Project</th>
											<th >Di review oleh</th>
										</tr>
									</thead>
									<tbody>
									<?php
											
											foreach($projects as $k => $v) {
												if(is_own_profile($uurl, $current_user)) {	
									?>
										<tr <?php echo ($v["project_parent"] !== NULL) ? 'class="child"' : 'class="parent"'; ?>>
											<td <?php echo ($v["project_parent"] !== NULL) ? 'class="marge"' : ""; ?>>
												<?php
													if($v["project_parent"] == NULL) {
												?>
												<a href="<?php  echo base_url()."review/".$v["project_url"];?>">
													<?php 
													}
														echo ($v["project_parent"] !== NULL) ? '&raquo; ' : ""; echo $v["project_title"];
													if($v["project_parent"] == NULL) {
													?>
												</a>
												<?php
													}
												?>
											</td>
											
											<td><?php echo $types[$k];?></td>
											<td><?php echo ($v["project_parent"] == NULL) ? $v["project_status"] : "";?></td>
											
											<td>
												<?php 
												if( !empty($reviewer[$k]) ) {
													foreach($reviewer[$k] as $k => $v) {
														if( $v["reviewer_status"] == "active" ) {
															echo '&raquo; '.$v["user_firstname"].' ('.$v["user_email"].')<br>';
														} else if ( $v["reviewer_status"] == "invited" ) {
															echo '<span class="warning">&raquo; '.$v["user_firstname"].' ('.$v["user_email"].' -- belum menerima undangan )</span><br>';
														} else {
															echo '<span class="danger">&raquo; '.$v["user_firstname"].' ('.$v["user_email"].' -- menolak undangan )</span><br>';
														}
													}
												}
												?>
											</td>
										</tr>
									<?php
												} else {
													if($v["project_status"] == "publish"){
													//for public
												
									?>				
										<tr <?php echo ($v["project_parent"] !== NULL) ? 'class="child"' : 'class="parent"'; ?>>
											<td <?php echo ($v["project_parent"] !== NULL) ? 'class="marge"' : ""; ?>>
												<?php
													if($v["project_parent"] == NULL) {
												?>
												<a href="<?php  echo base_url()."review/".$v["project_url"];?>">
													<?php 
													}
														echo ($v["project_parent"] !== NULL) ? '&raquo; ' : ""; echo $v["project_title"];
													if($v["project_parent"] == NULL) {
													?>
												</a>
												<?php
													}
												?>
											</td>
											
											<td><?php echo $types[$k];?></td>
											<td><?php echo $v["project_status"];?></td>
											
											<td>
												<?php 
												if( !empty($reviewer[$k]) ) {
													foreach($reviewer[$k] as $k => $v) {
														if( $v["reviewer_status"] == "active" ) {
															echo '&raquo; '.$v["user_firstname"].' ('.$v["user_email"].')<br>';
														} else if ( $v["reviewer_status"] == "invited" ) {
															echo '<span class="warning">&raquo; '.$v["user_firstname"].' ('.$v["user_email"].' -- belum menerima undangan )</span><br>';
														} else {
															echo '<span class="danger">&raquo; '.$v["user_firstname"].' ('.$v["user_email"].' -- menolak undangan )</span><br>';
														}
													}
												}
												?>
											</td>
										</tr>			
									<?php			
													}	
												}
											}
										
									?>
									</tbody>
								</table>
								<?php
									} else {
											echo "Anda tidak memiliki project apapun";
										}
								?>
							</div>
							
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

<!-- <a href="'.base_url().'user/'.$user_url.'/decline_invite/'.$v["reviewer_id"].'" class="btn btn-small btn-warning decline-button">Tolak</a> -->

	