$(document).ready(function() {
	$('#myModal, #myModal2').modal({
		backdrop : false,
		show : false
	});

	//hint
	$('select#preset').popover({
		title : 'Preset',
		content : 'Preset yang anda pilih akan otomatis menjadi default template yang akan dipakai di halaman profil member. pilih "Preset Kosong" untuk membuat baru dan "Save Template" setelahnya.'
	});

	$('#add-group-template').popover({
		title : 'Nama Group',
		content : 'masukkan nama group, kemudian drag ke area sebelah kanan. tambahkan jika group kosong dengan mengetikkan nama group > tekan enter dan drag ke area drop sebelah kanan.'
	});

	$('#add-data-profile').popover({
		title : 'Data Profil Member',
		content : 'Masukkan data member baru dan tekan enter kemudian drag ke area sebelah kanan untuk menempatkannya di template.'
	});

	$('#save-template-button').popover({
		title : 'Save Template',
		content : 'Pastikan Data dan Template tidak kosong',
		placement : 'left'
	});
})