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
								<h4 class="group-title"><em>Reviewing Projects</em></h4>
								<span class="hint-prat muted">Ini adalah daftar project yang Anda Bimbing (memerlukan review dan persetujuan Anda) dan juga undangan untuk menjadi reviewer dalam sebuah project</span>
								<hr>
								
								<table class="table table-striped hint-prat">
									<thead>
										<tr>
											<th style="width:300px">Judul Project</th>
											<th>Penulis Project</th>
											<th>Type Project</th>
											<th>Status Project</th>
											<th>Status Anda</th>
										</tr>
									</thead>
									<tbody>
									<?php
										if( !empty($reviews) ) {
											
											foreach($reviews as $k => $v) {
									?>
										<tr>
											<td><a href="<?php echo base_url()."review/".$reviewing[$k]["project_url"];?>"><?php echo $reviewing[$k]["project_title"];?></td>
											
											<td><a href="<?php echo base_url()."/user/".$authors[$k].'/profile';?>"><?php echo $reviewing[$k]["project_author"];?></a></td>
											<td><?php echo $types[$k];?></td>
											
											<td><?php echo $reviewing[$k]["project_status"];?></td>
											
											<td>
												<?php 
													if($v["reviewer_status"] == "active") {
														echo $v["reviewer_status"];
													} else {
														echo '<a href="'.base_url().'user/'.$user_url.'/accept_invite/'.$v["reviewer_id"].'" class="btn btn-small btn-success accept-button">Bimbing</a> ';
													}
												?>
											</td>
										</tr>
									<?php
											}
										} else {
											echo "Anda tidak sedang membimbing project apapun";
										}
									?>
									</tbody>
								</table>
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

	