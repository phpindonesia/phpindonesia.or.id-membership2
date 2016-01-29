jQuery(document).ready(function () {

	jQuery("#work-status").on('change', function () {
        var status = jQuery('#work-status :selected').val();
        if (status == 'R') {
            jQuery('#akhir-bekerja-block').show('slow');
        } else {
            jQuery('#akhir-bekerja-block').hide('slow');
        }
    });
    
});

