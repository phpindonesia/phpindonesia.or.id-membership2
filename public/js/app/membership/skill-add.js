jQuery("#skill-parent-id").on('change', function () {
    var pid = jQuery("#skill-parent-id :selected").val();

    if (pid != '') {
        jQuery.ajax({
            method: 'GET',
            url: _base_url_+'/apps/common-data/skills/'+pid,
            dataType: 'json'
        }).done(function (data) {

            if (data.length > 0) {
                var str_opts = input_select_n({
                    value: 'skill_id',
                    label: 'skill_name'
                }, data);

                jQuery("#skill-id-dd").html(str_opts);
                jQuery("#skill-id-row").fadeIn();

            } else {
                jQuery("#skill-id-row").fadeOut();                
            }

        }).fail(function (data) {
            alert('Failed to request data');
        }).always(function (data) {
            //
        });
        
    }
});