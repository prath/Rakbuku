						
							<?php
								get_user_name($reviewers_invite);
								//print_r($reviewers_invite);
								foreach( $reviewers_invite as $k => $v ) {
									if( isset($v["invitation_status"]) && $v["invitation_status"] == "pending" ) {
							?>
						<div class="alert alert-warning">
							<div class="progress progress-info progress-striped active elm-hidden">
								<div class="bar" style="width:100%;">Mengirim Invitation</div>
							</div>
										Pembimbing dengan email : <strong><?php echo $v["invitation_email"];?></strong> belum menyetujui untuk membimbing Anda. <a class="btn btn-small resendmail" href="<?php echo base_url().'review/'.$project_data[0]["project_url"].'/resend_email_invite/'.$v["invitation_id"] ;?>" >invite ulang</a></div>
							<?php
									}
									if( isset($v["reviewer_status"]) && $v["reviewer_status"] == "invited" ) {
							?>
						<div class="alert alert-warning">
										Pembimbing dengan email : <strong><?php echo $v["user_email"];?></strong> belum menyetujui untuk membimbing Anda.</div>
							<?php		
									}
								}
							?>
						<div class="alert alert-info">
							Anda dapat mempublikasikan project ini sendiri <a href="<?php echo base_url()."review/".$project_data[0]["project_url"]."/publish_project/";?>">Disini</a> tanpa persetujuan dari pembimbing, jika pembimbing telah lama tidak berinteraksi dengan Anda di website ini atau berinteraksi dengan pembimbing secara offline. 
						</div>
						
						<a href="" class="btn btn-primary" id="button-invite-new">Invite Reviewer Baru</a>
						<div id="invite-new-reviewer" class="elm-hidden">
							<div class="alert alert-warning alert-form alert-hidden"></div>
							<div class="progress progress-info progress-striped active elm-hidden">
								<div class="bar" style="width:100%;">loading</div>
							</div>
							<hr>
							<form id="invite-new-form" action="<?php echo base_url()."review/".$project_data[0]["project_url"]."/invite_new";?>" method="post">
								<div class="control-group">
									<label class="control-label" for="focusedInput">Invite Reviewer</label>
									<div class="controls">
										<input class="input-xlarge invitee_email required" name="invitee_email" id="" type="text" value="" placeholder="Ketikkan Email Pembimbing Disini">
									</div>
								</div>
								
								<div class="form-actions">
									<input type="hidden" name="invitation_project" value="<?php echo $project_data[0]["project_id"];?>" />
									<input type="hidden" name="invite_by" value="<?php echo $project_data[0]["user_id"];?>" />
									<input type="submit" class="btn btn-primary" id="submit_invite_new" name="submit" value="Save and Next">
								</div>
							</form>
						</div>
						<hr>
						