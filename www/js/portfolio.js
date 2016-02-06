$(document).ready(function () {

  $("#work-status").on('change', function () {
    var status = $('#work-status :selected').val();
    var $akhirKerja =$('#akhir-bekerja-block');

    if (status == 'R') {
      $akhirKerja.show('slow');
    } else {
      $akhirKerja.hide('slow');
    }
  });

  $('.portfolio-popup-close').on('click', function () {
    $.ajax({
      method: 'GET',
      url: baseUrl('/account/portfolio/setcookie'),
      dataType: 'json'
    }).done(function (data) {
      console.log(data);
    }).fail(function (data) {
      alert('Failed to request data');
    }).always(function (data) {
      $('#portfolio-popup').popup('hide');
    });
  });

  $('.skill-popup-close').on('click', function () {
    $.ajax({
      method: 'GET',
      url: baseUrl('/account/skills/setcookie'),
      dataType: 'json'
    }).done(function (data) {
      console.log(data);
    }).fail(function (data) {
      alert('Failed to request data');
    }).always(function (data) {
      $('#skill-popup').popup('hide');
    });
  });

});
