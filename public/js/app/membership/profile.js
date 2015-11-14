jQuery(document).ready(function() {

    // Initialize the plugin
    jQuery('#portfolio-popup').popup({
        autoopen: true,
        transition: 'all 0.3s'
    });

    jQuery('.portfolio-popup-close').on('click', function () {
        jQuery('#portfolio-popup').popup('hide');
    });
});
