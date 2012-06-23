$(document).ready(function() {

	//$('.typeahead').typeahead()

	/*-------------------------------------------------------------------
	| FUNGSI - FUNGSI jquery untuk manipulasi user data berikut ajax
	-------------------------------------------------------------------*/

	if ($('.edit-button').length){

		$('.edit-button').each(function(i){
			$(this).click(function(){
				if($(this).children().hasClass('icon-remove')){
					$(this).children().removeClass('icon-remove').addClass('icon-pencil');
					$(this).parent().parent().children().find(".edit-data").each(function(i) { 
						var curdisplay = $(this).parent().parent().children().find(".edit-data").css("display");
						if(curdisplay == "block")
						{
							$(this).parent().parent().find(".edit-data").css("display", "none");
						}
					});
					$(this).parent().parent().find(".data-value").css("display", "inline");
				}else{
					$(this).children().removeClass('icon-pencil').addClass('icon-remove');
					var curdisplay = $(this).parent().parent().find(".edit-data").css("display");
					$(this).parent().parent().find(".edit-data").css("display", "block");
					$(this).parent().parent().find(".data-value").css("display", "none");
				}
			});
		});
	}

	/*
	* save edit profile #save-btn
	*/
	$(".edit-data").each(function(i){
		$(this).submit(function(e){
			e.preventDefault();
			var th = $(this);
			var w = $(this).attr("data-dest");
			var s = $(this).attr("data-type");
			var serial = $(this).serialize();
			var uri = $(this).attr("action");
/* 			alert(serial); */

			$.ajax({
			    type: "POST",
				data: serial,
				url: uri,
				dataType : "json",
				cache : false,
			    success: function(response){
			    	if ( response["gagal"] ) {
				    	alert(response["gagal"]);
			    	} else if( w == "pass" ) {
						th.parent().parent().siblings( "h5" ).children( "a" ).children().removeClass('icon-remove').addClass('icon-pencil');
						th.prev(".data-value").html( "Password baru Anda telah berubah" );
				    	th.css("display", "none");
				    	th.prev(".data-value").css("display", "block");
					} else {
				    	th.prev(".data-value").html(response["result"]);
				    	th.css("display", "none");
				    	th.prev(".data-value").css("display", "block");
				    	if( w == "name") {
					    	$( "h2.profile-dashboard-title" ).html( response["result"] );
				    	}
				    	if ( response["fak"] ) {
				    		$("span#fak_name").css("display", "block");
					    	$("span#fak_name").html(response["fak"]);
				    	}
				    	if ( s == "serialize" ) {
					    	var arr = Array(); 
					    	for ( x in response["result"] ) {
						    	arr.push( response["result"][x] );
					    	}
/* 					    	console.log( arr ); */
					    	console.log( th.siblings( "div" ).children( ".data-value" ) );
					    	th.siblings( "div" ).children( ".data-value" ).each ( function( i ) { 
					    		$( this ).css( "display", "inline" );
					    		$( this ).html( arr[i] );
					    	} );
				    	}
			    	}
			    }
			});
		})
	})
	
	var val1 = "";
	
	$( "#user_pass" ).keyup(function(event) { 
		//alert(event.which);
		val1 = $(this).val();
	});
	
	var val2 = "";
	$( "#re_user_pass" ).keyup(function(event) { 
		//alert(event.which);
		var val2 = $(this).val();
		if(val2 === val1) {
			$(".form-status-ok").css("display", "inline-block");
			$(".form-status-notok").css("display", "none");
			$(".submit-pass").css("display", "inline-block");
		} else {
			$(".form-status-ok").css("display", "none");
			$(".submit-pass").css("display", "none");
			$(".form-status-notok").css("display", "inline-block");
		}
	});
	
	
	

	/*???**/
	$('.form-item, .form-item-empty').each(function(i){
		$(this).submit(function(e){
			e.preventDefault();
			if($(this).siblings('a.edit-button').children("i.icon-remove").hasClass('icon-remove')){
				$(this).siblings('a.edit-button').children("i.icon-remove").removeClass('icon-remove').addClass('icon-pencil');
			}
			
			var dataseri = $(this).serialize();
			var site = $(this).attr('action');
			
			$.ajax({
				type: "POST",
				data: dataseri,
				url: site,
				success: function(response){
					$('.item-value:eq('+i+')').show();
					$('.item-value:eq('+i+')').html(response);
					if($('.item-value:eq('+i+')').prev().text() == 'Nama Lengkap')
					{
						$('h2.profile-dashboard-title').text('').html(response);
					}
				},
				dataType:"html"
			});
			$(this).hide();
			$(this).children(".edit-button").show();
		})
	});

});