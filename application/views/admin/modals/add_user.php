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
		<input class="input-xlarge" type="text" name="user_email" id="email" placeholder="Email"><span class="help-inline muted">harus diisi</span>
		<input class="input-xlarge" type="password" name="user_pass" id="password" placeholder="Password"><span class="help-inline muted">harus diisi</span>
		<input class="input-xlarge" type="text" name="user_firstname" id="firstname" placeholder="Nama Depan"><span class="help-inline muted">harus diisi</span>
		<input class="input-xlarge" type="text" name="user_middlename" id="middlename" placeholder="Nama Tengah">
		<input class="input-xlarge" type="text" name="user_lastname" id="lastname" placeholder="Nama Belakang">
		<br />
		<select name="role">
			<option value="">Role User</option>
 		<?php
			foreach ($role as $key => $value) {
		?>
			<option value="<?php echo $value['role_name'];?>"><?php echo $value['role_name'];?></option>
		<?php
			}
		?>
		</select><span class="help-inline muted">harus diisi</span>
	</div>
	<div class="modal-footer">
		<input type="submit" name="addfak" id="submit" class="btn btn-primary" value="Save">
		<a href="#" data-dismiss="modal" class="btn">Close</a>
	</div>
</form>