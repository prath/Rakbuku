$(document).ready(function() {

	//add upload
	$( this ).find( "input, textarea" ).each( function(i) { 
		var pl = $( this ).attr("placeholder");
		$( this ).focus( function(e) { 
			$( this ).attr("placeholder", "");
		});
		$( this ).blur( function(e) { 
			$( this ).attr("placeholder", pl);
		});
	})
	
	$( ".select-bab" ).change( function(e) { 
		var countne =  $( this ).val();
		if( countne !== "1" ) {
			$( ".proj-chaps" ).empty();
			for( i = 0; i < countne; i++ ) {
				var x = i+1;
				var elm = '<input class="input-xxlarge required proj-chap-title" name="project_chap_title[]" id="" type="text" value="" placeholder="(Judul BAB/Dokumen ke-'+x+')"><input class="input-xxlarge upload-input" class="proj-chap-file" type="file" name="project_chap_file_'+x+'" size="20"><br><span class="muted"><em>Boleh dikosongkan jika belum memiliki file</em></span><br><br>';
				$( ".proj-chaps" ).append(elm);
			}
/* 			$( ".proj-chaps" ).after( clprev ); */
		} else {
			$( ".proj-chaps" ).empty();
			var elm = '<input class="input-xxlarge upload-input" class="proj-chap-file" type="file" name="project_chap_file_0" size="20">';
			$( ".proj-chaps" ).append(elm);
		}
	})
	
	$( "#save_project" ).click(function(e) { 
		$( ".alert-hidden" ).fadeOut()
		var cek = true;
		$( ".upload-input" ).each( function(i) { 
			/*
if( $( this ).val() == "" ) {
				cek = false;
			}
*/
			var n = $( this ).val().slice(-3);
			if( $( this ).val() !== "" && n !== "pdf" ) {
				cek = false;
			}
		})
		
		if( !cek ) {
			e.preventDefault();
			var error = "hanya diperbolehkan untuk mengupload file pdf";
			$( ".alert-hidden" ).fadeIn().show();
			$( ".alert-hidden" ).html(error);
		}
	})
	
	$( "#upload_file" ).click(function(e) { 
		$( ".alert-hidden" ).fadeOut()
		var cek = true;
		$( ".upload-input" ).each( function(i) { 
			if( $( this ).val() == "" ) {
				cek = false;
				error = "Anda belum memilih file";
			}
			var n = $( this ).val().slice(-3);
			if( $( this ).val() !== "" && n !== "pdf" ) {
				cek = false;
				error = "hanya diperbolehkan untuk mengupload file pdf";
			}
		})
		
		if( !cek ) {
			e.preventDefault();
			$( ".alert-hidden" ).fadeIn().show();
			$( ".alert-hidden" ).html(error);
		}
	})
	
	$( "#status_select" ).change( function(e) { 
		if( $(this).val() == "onrun" ) {
			$( ".onrun" ).show();
			$( ".submit-admin-review" ).hide();
		} else if(  $(this).val() == "finished" ) {
			$( ".submit-admin-review" ).show();
			$( ".onrun" ).hide();
		} else {
			$( ".onrun" ).hide();
			$( ".submit-admin-review" ).hide();
		}
	});
	
	//add reviewer form
	recurseadd( $( ".person-add" ) );
	function recurseadd(elm) {
		$( ".person-add" ).each(function(i) { 
			var tipstitle = $( this ).attr( "data-tips" ); 
			$(this).tooltip({
				title : tipstitle
			});	
			
			$(this).click( function(e) { 
				e.preventDefault();
				var par = $( this ).parent();
				var clone = par.clone();
				$(this).tooltip('toggle');
				$(this).remove();
				
				par.after( clone );
				
				recurseadd( $( ".person-add" ) );
			});
			
		});
	}
	
	//validation email
	$( "#submit_invite" ).click( function(e) { 
		
		$(".progress-info").show();
		
		var err = "";
		var cek = true;
		$( ".invitee_email" ).each(function(i) { 
		
			if( $(this).val() !== "" ) {
				
				invitee_email = $(this).val();
				var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				if( !emailReg.test(invitee_email) ) {
					cek = false;
					err = "Format email salah";
				} else {
					cek = true;
				}
				
			} else {
				err = "Field Harus diisi";
				cek = false;
			}
			
		})
		
		if( !cek ) {
			e.preventDefault();
			$(".progress-info").hide();
			$( ".alert-hidden" ).fadeIn().show();
			$( ".alert-form" ).html(err);
		}
		
	})
	
	$(".resendmail").click(function(e) { 
		$(".progress-info").show();
	})
	
	$("#add_bab").submit( function(e) { 
		var v = $("#project_title").val();
		if( v == '' ) {
			e.preventDefault();
			$( ".alert-add" ).fadeIn().show();
			$( ".alert-add" ).html( "Field tidak boleh kosong" );
		}
	})
	
	$("#form-comment").submit(function(e) { 
		var v = $( "#comment-content" ).val();
		if( v == '' ) {
			e.preventDefault();
			$( ".alert-comment" ).fadeIn().show();
			$( ".alert-comment" ).html( "Field tidak boleh kosong" );
		}
	})
	
	
	//ajax halaman reviewing accept invitation
	$( ".accept-button" ).each(function(i){
		
		$( this ).click(function(e){
			
			e.preventDefault();
			$.ajax({
			    type: "POST",
				url: $( this ).attr( "href" ),
				dataType : "json",
				cache : false,
			    success: function( response ){
			    	if( response["mssg"] !== "gagal" ) {
				    	location.reload();
				    }
			    }
			})
		})
		
	})
	
	//ajax submit invite
	/*
	* inviting form
	*/
	var invitee = "";
	$( "#invitee_name" ).keyup(function(e) { 
		invitee = $(this).val();
	});
	var invitee_email
	$( "#invitee_email" ).keyup(function(e) { 
		invitee_email = $(this).val();
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		if( emailReg.test(invitee_email) && invitee != "" && invitee_email != "" ) {
			console.log(invitee_email);
			$(".submit-invite").css("display", "inline-block");
		} else {
			$(".submit-invite").css("display", "none");
		}
	})
	
	$( ".progress" ).fadeIn().hide();
	$( "#form-invite" ).submit(function(e) {
		e.preventDefault();
		
		$( this ).one( "ajaxStart", function() {
			$( ".progress" ).fadeIn().show();
		});
		
		var seri = $( this ).serialize();
		$.ajax({
		    type: "POST",
			url: $( this ).attr( "action" ),
			data : seri,
			dataType : "json",
			cache : false,
		    success: function( response ){
	    		if( response["result"] == "exist") {
		    		$( ".progress" ).fadeOut().hide();
		    		$( ".alert-hidden" ).fadeIn().show();
		    		$( ".alert-hidden" ).html("Email yang Anda masukkan telah menjadi member atau telah anda undang");
	    		} else if( response["result"] == "sent") {
		    		$( "#form-invite" ).one( "ajaxComplete", function() {
			
						$("#invitation-list").load(location.href+" #invitation-list>*");
					
						//$("#invitation-list").load(location.href+" #invitation-list>*");
						$( ".alert-hidden" ).removeClass("alert-warning");
						$( ".alert-hidden" ).addClass("alert-info");
			    		$( ".alert-hidden" ).fadeIn().show();
			    		$( ".alert-hidden" ).html("Email telah dikirim");
						$( ".progress" ).fadeIn().hide();
					});
	    		} else {
	    			$( ".alert-hidden" ).removeClass("alert-warning");
	    			$( ".alert-hidden" ).removeClass("alert-info");
	    			$( ".alert-hidden" ).addClass("alert-danger");
		    		$( ".alert-hidden" ).fadeIn().show();
		    		$( ".alert-hidden" ).html("Email gagal dikirim, mohon coba lagi");
	    		}
		    	//location.reload();
		    }
		})
	})
	
	//ajax uurl cek
	$( "input#signup" ).attr('disabled', "disabled");
	$( "#uurl" ).bind( "keyup focus dblclick click", function() {
		$( this ).one( "ajaxStart", function() {
			$( ".cekavail" ).fadeIn().show();
		});
		
		$.ajax({
		    type: "POST",
			url: $( this ).attr( "data-check" ),
			data : "uurl="+$( this ).val(),
			dataType : "json",
			cache : false,
		    success: function( response ){
		    	//alert( response["result"]);
		    	if( response["result"] == "empty" ) {
			    	$( "input#signup" ).removeAttr('disabled');
			    	$( "input#signup" ).addClass("btn-primary");
			    	$( ".cekavail em" ).text("available");
		    	} else if( response["result"] == "fieldempty" ) {
			    	$( "input#signup" ).attr('disabled', "disabled");
			    	$( "input#signup" ).removeClass("btn-primary");
			    	$( ".cekavail em" ).text("harus diisi");
		    	} else {
			    	$( "input#signup" ).attr('disabled', "disabled");
			    	$( "input#signup" ).removeClass("btn-primary");
			    	$( ".cekavail em" ).text("not available");
		    	}
	    		//alert(response["result"]);
	    		//$( ".cekavail" ).fadeOut().hide();
		    }
		})
	});
	
	//lost pass
	$( "#lost-pass" ).click(function() {
		$( ".progress" ).fadeIn().show();
	})
	
	//jurusan_drop
	$( "#jurusan_drop" ).change(function(e) {
		e.preventDefault();
		var uri = $( this ).attr( "data-dest" );
		var data = "jurusan="+$( this ).val();
		$.ajax({
		    type: "POST",
			url: uri,
			data : data,
			dataType : "json",
			cache : false,
		    success: function( response ){
			    //alert(response["fakultas"]);
			    var fak = response["fakultas"];
			    $( 'span.fak_display').text(fak);
			    $( "#project_fakultas" ).attr("value", fak);
		    }
		})
	});
	
	//version revert
	reorder(".bab-item");
	
	function reorder(elm) {
		$( elm ).each(function(i) {
			var usechildren = $( this ).children( 'a.use-version' );
			$( this ).hover(function() {	
				$( this ).children( 'a.use-version' ).show();
				
			}, function() {
				$( this ).children( 'a.use-version' ).hide();
			})
			usechildren.click(function(e) {
				e.preventDefault();
				var data = "oldversid="+$(this).attr("data-version-which")+"&oldvers="+$(this).attr("data-version")+"&latestvers="+$(this).attr("data-version-use");
				var uri = $(this).attr("data-uri");
				$.ajax({
				    type: "POST",
					url: uri,
					data : data,
					dataType : "json",
					cache : false,
				    success: function( response ){
					    if(response["result"] == "success") {
						    $("#daftar-dok").load(location.href+" #daftar-dok>*", function(){
							    reorder(".bab-item");
						    });
					    }
				    }
				})
			})
		})
	}
	
	//invite new in review
	$( "#button-invite-new" ).click(function(e) {
		e.preventDefault();
		$( '#invite-new-reviewer' ).show();
		$( this ).hide();
		$("#invite-new-form").submit(function(e) {
			e.preventDefault();
			$( '.progress' ).show();
			var seri = $(this).serialize();
			var uri = $(this).attr("action");
			$.ajax({
			    type: "POST",
				url: uri,
				data : seri,
				dataType : "json",
				cache : false,
			    success: function( response ){
			    	$( '.progress' ).hide();
			    	if(response["errors"]) {
			    		$("#invite-new-form").prepend(response["errors"]);
			    	} else {
				    	$("#invite-new-form").prepend(response["result"]);
				    	location.reload();
			    	}
			    }
			})
		})
	})
	
	
});