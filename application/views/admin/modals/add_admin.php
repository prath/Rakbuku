<div class="modal-header">
	<a class="close" data-dismiss="modal">×</a>
	<h3></h3>
	<div class="progress progress-info
	     progress-striped active">
	  <div class="bar"
	       style="width: 100%;">
	   </div>
	</div>
</div>
	<?php
		$namearr = '';
		foreach ($names as $key => $value) {
			$namearr .= '"'.$value.'"';
			if($key !== count($names)-1)
			{
				$namearr .= ',';
			}
		}
	?>
<form id="additemform" action="" method="">
	<div class="modal-body">
		<input type="text" name="fullname" data-provide="typeahead" data-source='[<?php echo $namearr;?>]' placeholder="Nama Admin">
		<br>
		<?php
			echo anchor('admin/users/index','Tambahkan User disini jika orang yang Anda Cari tidak ada');
		?>
	</div>
	<div class="modal-footer">
		<input type="submit" name="addfak" id="submit" class="btn btn-primary" value="Save">
		<a href="#" data-dismiss="modal" class="btn">Close</a>
	</div>
</form>
