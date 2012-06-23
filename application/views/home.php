<?php
	/******************************************
	* View untuk home
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
				<div class="hero-unit">
					<h1 class="hero">RAK BUKU</h1>
					<p>
						Platform penerbitan karya tulis ilmiah Universitas Islam Negeri Sunan Gunung Djati Bandung
					</p>
				</div>
				
				<?php
				if( !empty($projects) ) {
					foreach($projects as $k => $v) {
				?>
				<div class="row-fluid">
					<div class="span2 row-fluid">
						<p class="hint-prat">
							<em class="muted">Dibuat pada</em><br>
							<?php echo $v["project_made"];?>						
						</p>
						<a href=""><i class="icon-file"></i> <?php echo $types[$k];?></a>
					</div>
					<div class="span10">
					
						<h3 class="project" style="text-transform: capitalize;">
							<a class="proj_title" href="<?php echo base_url()."karya_tulis/".$v["project_url"] ;?>"><?php echo $v["project_title"];?></a>
						</h3>
						<p class="muted hint-prat">
							<strong class="caped"><?php echo $types[$k];?></strong>  
							Oleh : <strong><a href="<?php echo base_url()."/user/".$authors[$k]."/profile";?>"><?php echo $v["project_author"];?></a></strong>
						</p>
						<hr>
					</div>
				</div>
				<?php
					}
				} else {
					echo "belum ada projects";
				}
				?>
				<?php echo $pagination;?>
				
			</div><!--/span-->
			
			<div class="span2">
				<?php $this->load->view("right-sidebar");?>
			</div><!--/span-->
			
		</div><!--/row-->
	
		<hr>
	
<?php
	$this->load->view("footer");
?>

	