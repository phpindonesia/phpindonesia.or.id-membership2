function input_select(settings, data) {
	var str_opts = '';
	if (data.length > 0) {
		str_opts += '<option value="" selected="selected">--Pilih--</option>';
		for (var i=0; i<data.length; i++) {
			str_opts += '<option value="'+data[i][settings.value]+'">'+data[i][settings.label]+'</option>';
		}
	} else {
		str_opts = '<option value="" selected="selected">--Pilih--</option>';
	}

	settings.dst.html(str_opts);
}

function input_select_n(settings, data) {
	var str_opts = '';
	if (data.length > 0) {
		str_opts += '<option value="" selected="selected">--Pilih--</option>';
		for (var i=0; i<data.length; i++) {
			str_opts += '<option value="'+data[i][settings.value]+'">'+data[i][settings.label]+'</option>';
		}
	} else {
		str_opts = '<option value="" selected="selected">--Pilih--</option>';
	}

	return str_opts;
}


jQuery(function($){
	// BaseURL
	var baseUrl = $('body').data('baseurl');

	// City dropdown triggered by #provinces-dd 
	$('#provinces-dd').change(function(e){
		if($(this).val() != ''){
			$.ajax({
				url: baseUrl + 'regionals/cities/' + $(this).val(),
				type: 'GET',
				dataType: 'json',
				success: function(kota){
					var dd = input_select_n({value: 'id', label: 'regional_name'}, kota);
					$('#cities-dd').html(dd);
				}
			});
		}
	});

});
