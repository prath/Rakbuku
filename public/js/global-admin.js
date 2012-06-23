$(document).ready(function() {

	$('#myModal').modal({
		backdrop : false,
		show : false
	});

	$('.progress').hide();
	
	//aktif/nonaktifkan member users
	if($('.activemember, .deactivemember').length)
	{
		$('.activemember, .deactivemember').each(function(i){
			//set the value of input to be queried 
			$(this).siblings('input[name="ID"]').val($(this).parent().parent().siblings('.id').text());
			$(this).siblings('input[name="fullname"]').val($(this).parent().parent().siblings('.fullname').text());
			$(this).siblings('input[name="status"]').val($(this).parent().parent().siblings('.status').children().text());
			//button clicked
			$(this).click(function(e){
				e.preventDefault();
				elmnt = $(this);
				populate_modal(elmnt);
			});
		})
	}

	//tambah user
	if($('.add-member').length)
	{
		$('.add-member').each(function(i){
			//button clicked
			$(this).click(function(e){
				e.preventDefault();
				elmnt = $(this);
				populate_modal(elmnt);
			});
		})
	}

	//kirim account
	if($('.kirimaccount').length)
	{
		$('.kirimaccount').each(function(i){
			//set the value of input to be queried 
			$(this).siblings('input[name="ID"]').val($(this).parent().parent().siblings('.id').text());
			$(this).siblings('input[name="fullname"]').val($(this).parent().parent().siblings('.fullname').text());
			//button clicked
			$(this).click(function(e){
				e.preventDefault();
				elmnt = $(this);
				populate_modal(elmnt);
			});
		})
	}

	//edit user role
	if($('.editrole').length)
	{
		$('.editrole').each(function(i){
			//set the value of input to be queried 
			$(this).siblings('input[name="ID"]').val($(this).parent().parent().siblings('.id').text());
			$(this).siblings('input[name="role_name"]').val($(this).parent().parent().siblings('.role_name').text());
			//button clicked
			$(this).click(function(e){
				e.preventDefault();
				elmnt = $(this);
				populate_modal(elmnt);
			});
		})
	}

	//edit roles
	if($('.editroles').length)
	{
		$('.editroles').each(function(i){
			//set the value of input to be queried 
			$(this).siblings('input[name="ID"]').val($(this).parent().parent().siblings('.id').text());
			$(this).siblings('input[name="role"]').val($(this).parent().parent().siblings('.role_name').text());
			//button clicked
			$(this).click(function(e){
				e.preventDefault();
				elmnt = $(this);
				populate_modal(elmnt);
			});
		})
	}

	//tambah role
	if($('.add-role').length)
	{
		$('.add-role').each(function(i){
			//button clicked
			$(this).click(function(e){
				e.preventDefault();
				elmnt = $(this);
				populate_modal(elmnt);
			});
		})
	}

	//aktif-nonaktif reviewer
	if($('.active-reviewer, .deactive-reviewer').length)
	{
		$('.active-reviewer, .deactive-reviewer').each(function(i){
			//set the value of input to be queried 
			$(this).siblings('input[name="ID"]').val($(this).parent().parent().siblings('.id').text());
			$(this).siblings('input[name="fullname"]').val($(this).parent().parent().siblings('.fullname').text());
			$(this).siblings('input[name="status"]').val($(this).parent().parent().siblings('.status').children().text());
			//button clicked
			$(this).click(function(e){
				e.preventDefault();
				elmnt = $(this);
				populate_modal(elmnt);
			});
		})
	}

	//tambah reviewer
	if($('.add-reviewer').length)
	{
		$('.add-reviewer').each(function(i){
			//button clicked
			$(this).click(function(e){
				e.preventDefault();
				elmnt = $(this);
				populate_modal(elmnt);
			});
		})
	}

	//tambah reviewer
	if($('.invite-member').length)
	{
		$('.invite-member').each(function(i){
			//button clicked
			$(this).click(function(e){
				e.preventDefault();
				elmnt = $(this);
				populate_modal(elmnt);
			});
		})
	}

	//edit roles
	if($('.add-quota').length)
	{
		$('.add-quota').each(function(i){
			//set the value of input to be queried 
			$(this).siblings('input[name="ID"]').val($(this).parent().parent().siblings('.id').text());
			$(this).siblings('input[name="user_invitation_quota"]').val($(this).parent().parent().siblings('.quota').text());
			//button clicked
			$(this).click(function(e){
				e.preventDefault();
				elmnt = $(this);
				populate_modal(elmnt);
			});
		})
	}

	//tambah jurusan
	if($('.add-jurusan').length)
	{
		$('.add-jurusan').each(function(i){
			//button clicked
			$(this).click(function(e){
				e.preventDefault();
				elmnt = $(this);
				populate_modal(elmnt);
			});
		})
	}

	//edit jurusan
	if($('.edit-jurusan').length)
	{
		$('.edit-jurusan').each(function(i){
			//set the value of input to be queried 
			$(this).siblings('input[name="ID"]').val($(this).parent().parent().siblings('.jur_id').text());
			$(this).siblings('input[name="jur_name"]').val($(this).parent().parent().siblings('.jur_name').text());
			$(this).siblings('input[name="fak_name"]').val($(this).parent().parent().siblings('.fak_name').text());
			//button clicked
			$(this).click(function(e){
				e.preventDefault();
				elmnt = $(this);
				populate_modal(elmnt);
			});
		})
	}

	//del jurusan
	if($('.del-jurusan').length)
	{
		$('.del-jurusan').each(function(i){
			//set the value of input to be queried 
			$(this).siblings('input[name="ID"]').val($(this).parent().parent().siblings('.jur_id').text());
			$(this).siblings('input[name="jur_name"]').val($(this).parent().parent().siblings('.jur_name').text());
			//button clicked
			$(this).click(function(e){
				e.preventDefault();
				elmnt = $(this);
				populate_modal(elmnt);
			});
		})
	}

	//tambah fakultas
	if($('.add-fakultas').length)
	{
		$('.add-fakultas').each(function(i){
			//button clicked
			$(this).click(function(e){
				e.preventDefault();
				elmnt = $(this);
				populate_modal(elmnt);
			});
		})
	}

	//edit fakultas
	if($('.edit-fakultas').length)
	{
		$('.edit-fakultas').each(function(i){
			//set the value of input to be queried 
			$(this).siblings('input[name="ID"]').val($(this).parent().parent().siblings('.fak_id').text());
			$(this).siblings('input[name="fak_name"]').val($(this).parent().parent().siblings('.fak_name').text());
			//button clicked
			$(this).click(function(e){
				e.preventDefault();
				elmnt = $(this);
				populate_modal(elmnt);
			});
		})
	}

	//del fakultas
	if($('.del-fakultas').length)
	{
		$('.del-fakultas').each(function(i){
			//set the value of input to be queried 
			$(this).siblings('input[name="ID"]').val($(this).parent().parent().siblings('.fak_id').text());
			$(this).siblings('input[name="fak_name"]').val($(this).parent().parent().siblings('.fak_name').text());
			//button clicked
			$(this).click(function(e){
				e.preventDefault();
				elmnt = $(this);
				populate_modal(elmnt);
			});
		})
	}

	//add tipe project
	if($('.add-type').length)
	{
		$('.add-type').each(function(i){
			//button clicked
			$(this).click(function(e){
				e.preventDefault();
				elmnt = $(this);
				populate_modal(elmnt);
			});
		})
	}

	//edit type
	if($('.edit-type').length)
	{
		$('.edit-type').each(function(i){
			//set the value of input to be queried 
			$(this).siblings('input[name="ID"]').val($(this).parent().parent().siblings('.type_id').text());
			$(this).siblings('input[name="type_name"]').val($(this).parent().parent().siblings('.type_name').text());
			//button clicked
			$(this).click(function(e){
				e.preventDefault();
				elmnt = $(this);
				populate_modal(elmnt);
			});
		})
	}

	//del type
	if($('.del-type').length)
	{
		$('.del-type').each(function(i){
			//set the value of input to be queried 
			$(this).siblings('input[name="ID"]').val($(this).parent().parent().siblings('.type_id').text());
			$(this).siblings('input[name="type_name"]').val($(this).parent().parent().siblings('.type_name').text());
			//button clicked
			$(this).click(function(e){
				e.preventDefault();
				elmnt = $(this);
				populate_modal(elmnt);
			});
		})
	}

	//add topic project
	if($('.add-topic').length)
	{
		$('.add-topic').each(function(i){
			//button clicked
			$(this).click(function(e){
				e.preventDefault();
				elmnt = $(this);
				populate_modal(elmnt);
			});
		})
	}

	//edit topic
	if($('.edit-topic').length)
	{
		$('.edit-topic').each(function(i){
			//set the value of input to be queried 
			$(this).siblings('input[name="ID"]').val($(this).parent().parent().siblings('.topic_id').text());
			$(this).siblings('input[name="topic_name"]').val($(this).parent().parent().siblings('.topic_name').text());
			//button clicked
			$(this).click(function(e){
				e.preventDefault();
				elmnt = $(this);
				populate_modal(elmnt);
			});
		})
	}

	//del topic
	if($('.del-topic').length)
	{
		$('.del-topic').each(function(i){
			//set the value of input to be queried 
			$(this).siblings('input[name="ID"]').val($(this).parent().parent().siblings('.topic_id').text());
			$(this).siblings('input[name="topic_name"]').val($(this).parent().parent().siblings('.topic_name').text());
			//button clicked
			$(this).click(function(e){
				e.preventDefault();
				elmnt = $(this);
				populate_modal(elmnt);
			});
		})
	}


	//the ajax function
	function populate_modal(elmnt)
	{
		var arrq = new Array();
		var arrpop = new Array();
		var arrselect = new Array();
		var base = elmnt.parent().siblings('input.destination').val();
		var dest = elmnt.parent().siblings('input.destination').attr('name');
		var cont = elmnt.parent().siblings('input.destination').attr('title');
		var ctrl = base+'admin/'+cont+'/get_modal_'+dest+"/"+String((new Date()).getTime())
		var target = elmnt.parent().parent().siblings('.target');
		var targetedit = elmnt.parent().parent().siblings('.target-edit');

		seri = elmnt.siblings('input').serializeArray();
		jQuery.each(seri, function(i, field){
			if(elmnt.siblings('input:eq('+i+')').hasClass('query'))
			{
				arrq[field.name] = field.value;
			}	
			if(elmnt.siblings('input:eq('+i+')').hasClass('populate'))
			{
				arrpop[field.name] = field.value;
			}
			if(elmnt.siblings('input:eq('+i+')').hasClass('populate-select'))
			{
				arrselect[field.name] = field.value;
			}
		});

		//$('#myModal').on('show', function (){
			//load modal.php
		$('#myModal').load(ctrl, function(){
			$('.progress').hide();
			//title dan destination modal
			elmntpop = $(this);
			$(this).find('.modal-header h3').text(elmnt.parent().attr('name'));
			$(this).find('form').attr('action', elmnt.parent().attr('action'));
			//type dan text button modal
			newbutton = elmnt.attr('class');
			$(this).find('#submit').removeClass().addClass(newbutton).val(elmnt.attr('rel'));
			for(x in arrpop)
			{
				disabled = ((elmnt.siblings('input[name="'+x+'"]').hasClass('disabled'))) ? 'disabled' : '';
				var input = '<input class="input-xlarge" type="text" name="'+x+'" id="'+x+'" placeholder="'+arrpop[x]+'" '+disabled+'>';
				$(this).find('.modal-body').append(input);
			}

			for(x in arrselect)
			{
				$(this).find('.modal-body select').each(function(i){
					//$(this).children("option:contains('"+arrselect[x]+"')").attr('selected', 'selected');
					$(this).children("option").filter(function(){
						if($(this).text() === arrselect[x])
						{
							$(this).attr('selected', 'selected');
						}
					});
				});	
			}

			addseri = new Array();
			for(c in arrq)
			{
				addseri.push(""+c+"="+arrq[c]); 
			}

			$(this).find('form').submit(function(e)
			{
		  		e.preventDefault();
		  		ajaxseri = $(this).serialize();
		  		for(v in addseri)
	  			{
	  				ajaxseri = ajaxseri+"&"+addseri[v];
	  			} 
	  			uri = $(this).attr('action');

	  			$('.progress')
					.ajaxStart(function(){
						$(this).show();
					}).ajaxStop(function(){
		            	$(this).hide();
				});

	  			$.ajax({
				    type: "POST",
					data: ajaxseri,
					url: uri,
					dataType : "json",
					cache : false,
				    success: function(response){
				    	console.log(response);
				    	if(response['validation_error'] === 'validation error')
				    	{
				    		elmntpop.find('.modal-body div.alert').remove();
				    		errormsg = '<div class="alert"><strong>Warning!</strong>'+response['errors']+'</div>';
				    		elmntpop.find('.modal-body').prepend(errormsg);
				    	}
				    	else if(response['data_ada'])
				    	{
				    		elmntpop.find('.modal-body div.alert').remove();
				    		errormsg = '<div class="alert"><strong>Warning!</strong> '+response['data_ada']+'</div>';
				    		elmntpop.find('.modal-body').prepend(errormsg);
				    	}
				    	else
				    	{
					    	if(response['button_class'])
					    	{
					    		//console.log('ada');
					    		elmnt.attr('rel' , response['button_rel']);
					    		elmnt.attr('class' , response['button_class']);
					    		elmnt.html('').html(response['button_text']);
					    	}

					    	if(response['input'])
					    	{
					    		elmnt.siblings('input').each(function(i){
					    			$(this).val(response['input'][i]);
					    		})
					    	}

					    	if(response['sukses_add'])
					    	{
					    		location.reload();
					    	}

					    	if(response['sukses_del'])
					    	{
					    		location.reload();
					    	}
					    	
					    	if(response['edit'])
					    	{
					    		targetedit.each(function(i){
						    		$(this).html('').html(response['edit'][i]);
						    	})
					    	}
					    	else
					    	{
					    		target.each(function(i){
						    		$(this).html('').html(response[i]);
						    	});
					    	}

					    	$('#myModal').modal('toggle');
					    }
				    }
				});
		  	});
		});
		//});
	}

	$('.alert a.close').each(function(){
		$(this).click(function(){
			$(this).parent().hide();
		});
	})
	
	
	
	/*
	* --===[ Project Frameworks JSs ]===--
	*/
	//var tipstitle = $( ".tips" ).attr( "data-tips" );
	
	/*

	
*/
	
	$( "#project-type" ).change( function( e ) { 
		var ur = $( this ).siblings( "#fw-uri" ).attr( "value" );
		$("#project-type option:selected").each(function () {
			var thisval = $(this).attr( "value" );
			if( !thisval == "" ) {
				var uri = ur+"/"+thisval;
			};
			
			$( "#load-container" ).load( uri, function() { 
				recurseadd($( ".rule-add" ));
				chooserule($( ".rules-opt" ));
				
				recursedel($( ".rule-del" ));
				recurseedit($( ".rule-edit" ));
				
				$(this).find( ".hide-border" ).each(function(i) { 
					var tipstitle = $( this ).attr( "data-tips" ); 
					$(this).tooltip({
						title : tipstitle
					});
				})
				
				$( ".form-horizontal" ).submit( function(e) { 
					e.preventDefault();
					uri = $( this ).attr( "action" );
					var seri = "";
					$( ".uneditable" ).each(function(i) { 
						var valat = $( this ).attr( "value" ).toLowerCase();
						seri += i+"="+valat+"&";
					})
					console.log( uri );
					
					$.ajax ({
					    type: "POST",
						data: seri,
						url: uri,
						dataType : "json",
						cache : false,
					    success: function( response ) {
						    console.log( response["result"] );
						    if( response["result"] !== "gagal" ) {
							    $( ".alert-hidden" ).show();
							    $( ".alert-hidden" ).html( "<strong>Selamat</strong> Konfigurasi telah di-<em>save</em>" );
						    }
					    }
					});
				})
				
				
			});
					
		}); 
	});
	
	function recurseadd( el ) { 
		el.each(function(i) { 
			var tipstitle = $( this ).attr( "data-tips" ); 
			$(this).tooltip({
				title : tipstitle
			});	
			
			$(this).click( function(e) { 
				e.preventDefault();
				var par = $( this ).parent().parent();
				var clone = par.clone();
				$(this).tooltip('toggle');
				$(this).remove();
				
				par.after( clone );
				clone.children().children( ".rule-edit" ).css( "display", "inline-block" );
				clone.children().children( ".rule-del" ).css( "display", "inline-block" );
				clone.children().children( "input" ).removeAttr("value");
				clone.children().children( "input" ).attr("placeholder", "click edit untuk tambah rule baru");
				
				recurseadd( $( ".rule-add" ) );
				recursedel($( ".rule-del" ));
				recurseedit($( ".rule-edit" ));
				chooserule($( ".rules-opt" ));
			});
			
		});
	}
	
	function recursedel( el ) { 
		el.each(function(i) { 
			var tipstitle = $( this ).attr( "data-tips" ); 
			$(this).tooltip({
				title : tipstitle
			});	
			
			$(this).click( function(e) { 
				e.preventDefault();
				var par = $( this ).parent().parent();
				
				if( $( this ).siblings( ".rule-add" ).size() ) {
					var addicon = $('<a class="tips rule-add" href="#" data-tips="click untuk menambah rule baru"><i class="icon-plus"></i></a>');
					var elbef = par.prev().children( "div.controls" );
					addicon.appendTo(elbef);
				}	
				
				$(this).tooltip('toggle');
				$(this).remove();
				par.remove();
				recurseadd( $( ".rule-add" ) );
			});
			
		});
	}
	
	function recurseedit( el ) { 
		el.each(function(i) { 
			var tipstitle = $( this ).attr( "data-tips" ); 
			$(this).tooltip({
				title : tipstitle
			});	
			
			$(this).click( function(e) { 
				e.preventDefault();
				//$( this ).siblings( "input" ).focus();
				$( this ).siblings( "select" ).show();
				$( this ).siblings( "input" ).hide();
			});
			
		});
	}
	
	function chooserule(elm) { 
		elm.each( function(i) { 
			$( this ).change( function( e ) { 
				$( this ).children( "option:selected").each(function () {
					if( $( this ).val() !== "") {
						var v = $( this ).val();	
						$( this ).parent().siblings( "input" ).attr( "value", v);
						$( this ).parent().hide();
						$( this ).parent().siblings( "input" ).show();
					}	
				})
			});
		}) 
	}
	
	
});
