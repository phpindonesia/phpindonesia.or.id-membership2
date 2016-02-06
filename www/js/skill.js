$(document).ready(function () {

  $("#skill-parent-id").on('change', function () {

    var pid = $("#skill-parent-id :selected").val();

    if (pid != '') {
      $.ajax({
        method: 'GET',
        url: baseUrl('account/skills/' + pid),
        dataType: 'json'
      }).done(function (data) {

        if (data.length > 0) {
          var str_opts = inputSelectN({
            value: 'skill_id',
            label: 'skill_name'
          }, data);

          $("#skill-id-dd").html(str_opts);
          $("#skill-id-dd").attr('disabled', false);
          $("#skill-id-row").fadeIn();
        } else {
          $("#skill-id-row").fadeOut();
          $("#skill-id-dd").attr('disabled', true);
        }

      }).fail(function (data) {
        alert('Failed to request data');
      }).always(function (data) {
        //
      });
    } else {
      var str_opts = inputSelectN({}, []);

      $("#skill-id-dd").html(str_opts);
      $("#skill-id-dd").attr('disabled', true);
      $("#skill-id-row").fadeOut();
    }

  });

});
