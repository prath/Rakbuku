<h1>ini halaman admin approval</h1>
<form class="form-horizontal" action="<?php echo base_url();?>project/<?php echo $nexturl;?>" method="post">
<input type="hidden" name="project_state" value="<?php echo $state;?>" />
<input type="hidden" name="project_type" value="<?php echo $type;?>" />
<input type="hidden" name="project_status" value="<?php echo $status;?>" />
<input type="submit" class="btn btn-primary" name="submit" value="Save and Next Step">
</form>