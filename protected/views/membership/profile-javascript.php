jQuery(document).ready(function() {

    // Initialize the plugin
    jQuery('#portfolio-popup').popup({
        autoopen: <?php echo $have_portf ? 'false' : 'true'; ?>,
        transition: 'all 0.3s',
        scrolllock: true
    });

    jQuery('.portfolio-popup-close').on('click', function () {
        jQuery('#portfolio-popup').popup('hide');
    });
});
