jQuery("#provinces-dd").on('change', function () {
    var prov_id = jQuery("#provinces-dd :selected").val();

    // disabled again if provinces value is null
    if(prov_id == '') {
        jQuery("#cities-dd").attr('disabled', 'disabled');
    }

	if (prov_id != '') {
        jQuery.ajax({
    		method: 'GET',
    		url: _base_url_+'/apps/common-data/cities/'+prov_id,
    		dataType: 'json'
    	}).done(function (data) {
            input_select({
                value: 'id',
                label: 'regional_name',
                dst: jQuery("#cities-dd")
            }, data);

            // enable select #cities-dd
            jQuery("#cities-dd").removeAttr('disabled');

    	}).fail(function (data) {
    		alert('Failed to request data');
    	}).always(function (data) {
    	});
    } else {
        input_select({dst: jQuery("#cities-dd")}, []);
    }
});