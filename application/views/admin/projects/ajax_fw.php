<?php
	if( !$fw_data ) {
?>
<div class="alert alert-success alert-hidden">
</div>
<div class="span8">
	<form class="form-horizontal" action="<?php echo base_url()?>admin/projects/save_frameworks/<?php echo strtolower( $types[0]["type_id"] );?>">
		<fieldset>
			<legend>Framework Project <?php echo $types[0]["type_name"];?></legend>
			<div class="control-group">
				<label class="control-label" for="focusedInput"><i class="icon-arrow-down"></i></label>
				<div class="controls">
					<input class="input-xlarge hide-border uneditable" type="text" value="Pilih Project" disabled="disabled">
				</div>
			</div>
			<div class="control-group">	
				<label class="control-label" for="focusedInput"><i class="icon-arrow-down"></i></label>
				<div class="controls">
					<input class="input-xlarge hide-border uneditable" name="tes" type="text" value="Isi Form Project Baru"  disabled="disabled" >
					<select class="rules-opt">
						<option value="">Pilih Rule</option>
						<option value="Undang Reviewer/Collaborator">Undang Reviewer/Collaborator</option>
						<option value="Review/Collaboration">Review/Collaboration</option>
					</select>
					<a class="tips rule-edit" href="#" data-tips="click untuk mengedit rule baru"><i class="icon-pencil"></i></a>
					<a class="tips rule-del" href="#" data-tips="click untuk manghapus rule baru"><i class="icon-minus"></i></a>
					<a class="tips rule-add" href="#" data-tips="click untuk menambah rule baru"><i class="icon-plus"></i></a>
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="focusedInput"><i class="icon-arrow-down"></i></label>
				<div class="controls">
					<input class="input-xlarge hide-border uneditable" type="text" value="Admin Review" disabled="disabled">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="focusedInput"><i class="icon-arrow-down"></i></label>
				<div class="controls">
					<input class="input-xlarge hide-border uneditable" type="text" value="Publikasikan Project" disabled="disabled">
				</div>
			</div>
			<div class="form-actions">
				<input type="submit" class="btn btn-primary save-fw" value="Save Konfigurasi Framework">
			</div>
			
			
		</fieldset>
	</form>
</div>


<?php
	} else {
?>
<div class="alert alert-success alert-hidden">
</div>
<div class="span8">
	<form class="form-horizontal" action="<?php echo base_url()?>admin/projects/save_frameworks/<?php echo strtolower( $types[0]["type_id"] );?>">
		<fieldset>
			<legend>Framework Project <?php echo $types[0]["type_name"];?></legend>
			<div class="control-group">
				<label class="control-label" for="focusedInput"><i class="icon-arrow-down"></i></label>
				<div class="controls">
					<input class="input-xlarge hide-border uneditable" type="text" value="Pilih Project" disabled="disabled">
				</div>
			</div>
			
			<?php
				if( is_array($slice) ) {
			?>
			<div class="control-group">	
				<label class="control-label" for="focusedInput"><i class="icon-arrow-down"></i></label>
				<div class="controls">
					<input class="input-xlarge hide-border uneditable" name="tes" type="text" value="Isi Form Project Baru"  disabled="disabled">
					<select class="rules-opt">
						<option value="">Pilih Rule</option>
						<option value="Undang Reviewer/Collaborator">Undang Reviewer/Collaborator</option>
						<option value="Review/Collaboration">Review/Collaboration</option>
					</select>
					<a class="tips rule-edit" href="#" data-tips="click untuk mengedit rule baru"><i class="icon-pencil"></i></a>
					<a class="tips rule-del" href="#" data-tips="click untuk manghapus rule baru"><i class="icon-minus"></i></a>
				</div>
			</div>
			<?php
				foreach($slice as $k => $v) {
			?>
			<div class="control-group">	
				<label class="control-label" for="focusedInput"><i class="icon-arrow-down"></i></label>
				<div class="controls">
					<input class="input-xlarge hide-border uneditable" type="text" value="<?php echo $v;?>" disabled="disabled">
					<select class="rules-opt">
						<option value="">Pilih Rule</option>
						<option value="Undang Reviewer/Collaborator">Undang Reviewer/Collaborator</option>
						<option value="Review/Collaboration">Review/Collaboration</option>
					</select>
					<a class="tips rule-edit" href="#" data-tips="click untuk mengedit rule baru" style="display:inline-block"><i class="icon-pencil"></i></a>
					<a class="tips rule-del" href="#" data-tips="click untuk manghapus rule baru" style="display:inline-block"><i class="icon-minus"></i></a>
					<?php 
						if( $k+1 == count($slice) )
						{
					?>
					<a class="tips rule-add" href="#" data-tips="click untuk menambah rule baru"><i class="icon-plus"></i></a>
					<?php
						}
					?>
				</div>
			</div>
			<?php
				}
			?>
			<?php
					
				} else {
			?>
			<div class="control-group">	
				<label class="control-label" for="focusedInput"><i class="icon-arrow-down"></i></label>
				<div class="controls">
					<input class="input-xlarge hide-border uneditable" name="tes" type="text" value="Isi Form Project Baru"  disabled="disabled">
					<select class="rules-opt">
						<option value="">Pilih Rule</option>
						<option value="Undang Reviewer/Collaborator">Undang Reviewer/Collaborator</option>
						<option value="Review/Collaboration">Review/Collaboration</option>
					</select>
					<a class="tips rule-edit" href="#" data-tips="click untuk mengedit rule baru"><i class="icon-pencil"></i></a>
					<a class="tips rule-del" href="#" data-tips="click untuk manghapus rule baru"><i class="icon-minus"></i></a>
					<a class="tips rule-add" href="#" data-tips="click untuk menambah rule baru"><i class="icon-plus"></i></a>
				</div>
			</div>
			<?php
				}
				
			?>
			
			<div class="control-group">
				<label class="control-label" for="focusedInput"><i class="icon-arrow-down"></i></label>
				<div class="controls">
					<input class="input-xlarge hide-border uneditable" type="text" value="Admin Review" disabled="disabled">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="focusedInput"><i class="icon-arrow-down"></i></label>
				<div class="controls">
					<input class="input-xlarge hide-border uneditable" type="text" value="Publikasikan Project" disabled="disabled">
				</div>
			</div>
			<div class="form-actions">
				<input type="submit" class="btn btn-primary save-fw" value="Save Konfigurasi Framework">
			</div>
			
			
		</fieldset>
	</form>
</div>
<?php
	}
?>
