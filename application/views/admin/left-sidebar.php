<?php  
/******************************************
* View untuk left navigation admin
* author : pratama hasriyan
******************************************/ 

$nav = $this->uri->segment(3);
$nav_parent = $this->uri->segment(2);
?>

<div class="well sidebar-nav">
	<ul class="nav nav-list">
		<li class="nav-header"><?php echo $menu['title'];?></li>
		<?php
			foreach ($menu['menus'] as $key => $value) {
				if($key == '')
				{
					$key = 'index';
				}
		?>
			<li <?php active($key, $nav);?>><a href="<?php echo base_url();?>admin/<?php echo $nav_parent.'/'.$key;?>"><?php echo $value;?></a></li>
		<?php
			}
		?>
	</ul>
</div>