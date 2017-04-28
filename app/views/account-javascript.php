$(document).ready(function() {

    // Initialize the plugin
    $('#portfolio-popup').popup({
        autoopen: <?php echo $open_portfolio ? 'true' : 'false'; ?>,
        transition: 'all 0.3s',
        scrolllock: true
    });

    $('#skill-popup').popup({
        autoopen: <?php echo $open_skill ? 'true' : 'false'; ?>,
        transition: 'all 0.3s',
        scrolllock: true
    });

});
