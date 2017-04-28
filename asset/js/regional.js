$(document).ready(function () {

  // City dropdown triggered by #provinces-dd
  $('#provinces-dd').change(function (e) {
    var cities = $(this).val();

    if (cities != '') {
      $.ajax({
        url: baseUrl('regionals/cities/' + cities),
        type: 'GET',
        dataType: 'json',
        success: function (kota) {
          var dd = inputSelectN({ value: 'id', label: 'regional_name' }, kota);
          $('#cities-dd').html(dd);
        }
      });
    }
  });

});
