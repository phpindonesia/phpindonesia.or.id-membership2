!(function($) {
    $('#member-search-form').submit(function(event) {
        location.href = baseUrl() +'?'+ serializeForm(this);
        return false;
    });

    function serializeForm(form) {
        var data = [];
        var inputs = $(form).serializeArray();

        $.each(inputs, function (index, input) {
            if (input.value.length > 0) {
                data.push(input.name +'='+ input.value);
            }
        });

        return data.join('&');
    }
})(jQuery);
