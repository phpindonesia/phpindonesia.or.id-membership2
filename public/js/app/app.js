// disabled again if provinces value is null
// jQuery("#cities-dd").attr('disabled', 'disabled');

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