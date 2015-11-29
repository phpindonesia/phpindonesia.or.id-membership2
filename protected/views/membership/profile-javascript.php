jQuery(document).ready(function() {

    // Initialize the plugin
    jQuery('#portfolio-popup').popup({
        autoopen: <?php echo $open_portfolio ? 'true' : 'false'; ?>,
        transition: 'all 0.3s',
        scrolllock: true
    });

    jQuery('#skill-popup').popup({
        autoopen: <?php echo $open_skill ? 'true' : 'false'; ?>,
        transition: 'all 0.3s',
        scrolllock: true
    });

    jQuery('.portfolio-popup-close').on('click', function () {
        jQuery.ajax({
            method: 'GET',
            url: _base_url_+'/apps/membership/profile-portfolio-setcookie',
            dataType: 'json'
        }).done(function (data) {
            console.log(data);
        }).fail(function (data) {
            alert('Failed to request data');
        }).always(function (data) {
            jQuery('#portfolio-popup').popup('hide');
        });
    });

    jQuery('.skill-popup-close').on('click', function () {
        jQuery.ajax({
            method: 'GET',
            url: _base_url_+'/apps/membership/profile-skill-setcookie',
            dataType: 'json'
        }).done(function (data) {
            console.log(data);
        }).fail(function (data) {
            alert('Failed to request data');
        }).always(function (data) {
            jQuery('#skill-popup').popup('hide');
        });
    });
});
