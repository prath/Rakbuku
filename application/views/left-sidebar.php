<?php  
/******************************************
* View untuk left navigation
* author : pratama hasriyan
******************************************/ 

$nav = $this->uri->segment(1);
?>

<div class="well sidebar-nav">
	<ul class="nav nav-list">
		<li class="nav-header">Rakbuku</li>
		
		<li <?php active('', $nav);?>><a href="<?php echo base_url();?>">Beranda</a></li>
		<?php 
			if( !empty($project_types) ) {
				foreach( $project_types as $k => $v) {
			
		?>
		<li><a href="<?php echo base_url();?>kategori/<?php echo $v["type_slug"] ?>"><?php echo $v["type_name"];?></a></li>
		<?php
				}
			} else {
				echo "Tidak ada kategori";
			}
		?>
	</ul>
</div>