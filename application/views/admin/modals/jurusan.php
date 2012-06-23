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
<form id="additemform" action="" method="">
	<div class="modal-body">
		<?php
			
			if(isset($fak))
			{
				?>
		<select name="fak_id">
			<option value="">Fakultas</option>
				<?php
				foreach ($fak as $key => $value) {
					?>
			<option value="<?php echo $value['fak_id'];?>"><?php echo $value['fak_name'];?></option>
					<?php
				}
				?>
		</select>
				<?php
			}
		?>
		<input class="input-xlarge" type="text" name="name" id="name" placeholder="Nama Jurusan">
	</div>
	<div class="modal-footer">
		<input type="submit" name="addfak" id="submit" class="btn btn-primary" value="Save">
		<a href="#" data-dismiss="modal" class="btn">Close</a>
	</div>
</form>