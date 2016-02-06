if (typeof jQuery === 'function') {
  $ = jQuery
}

// Retrieve application base url
function baseUrl(permalink) {
  var siteUrl = $('body').data('baseurl');
  var permalink = permalink || '';

  return siteUrl + permalink;
}

function inputSelect(settings, data) {
  var str_opts = '';
  if (data.length > 0) {
    str_opts += '<option value="" selected="selected">--Pilih--</option>';
    for (var i=0; i<data.length; i++) {
      str_opts += '<option value="'+data[i][settings.value]+'">'+data[i][settings.label]+'</option>';
    }
  } else {
    str_opts = '<option value="" selected="selected">--Pilih--</option>';
  }

  settings.dst.html(str_opts);
}

function inputSelectN(settings, data) {
  var str_opts = '';
  if (data.length > 0) {
    str_opts += '<option value="" selected="selected">--Pilih--</option>';
    for (var i=0; i<data.length; i++) {
      str_opts += '<option value="'+data[i][settings.value]+'">'+data[i][settings.label]+'</option>';
    }
  } else {
    str_opts = '<option value="" selected="selected">--Pilih--</option>';
  }

  return str_opts;
}

function delete_socmed(item_id) {
  $('#'+item_id).hide('slow', function () {

    var deletes = $('#delete-collections input');
    var first_td = $(this).children(':first');
    var socmed_type = first_td.children('.socmed-type').val();
    var db_row_id = parseInt(first_td.children('.db-row-id').val());

    if (db_row_id > 0) {
      $('#delete-collections').append('<input type="hidden" name="socmeds_delete[]" value="'+socmed_type+'" />');
    }

    $(this).remove();
  });
}

MAX_SIZE = 1024 * 250;

function validate_image_upload() {
  var upload = $('#photo-profile');
  var upload_path = upload.value;

  if (upload_path != '') {
    var ext = upload_path.substring(upload_path.lastIndexOf('.') + 1).toLowerCase();

    if (ext == 'jpg' || ext == 'jpeg' || ext == 'png') {

      if (upload.files && upload.files[0]) {
        var fsize = upload.files[0].size;
        var fsize_in_kb = MAX_SIZE / 1024;

        if (fsize > MAX_SIZE) {
          alert('File Max: '+fsize_in_kb+'KB. Ukuran file melebihi kapasitas yang sudah ditentukan.');
          upload.value = '';
          return false;
        } else {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#img-photo-profile').attr('src', e.target.result);
          }

          reader.readAsDataURL(upload.files[0]);
        }
      }

    } else {
      alert('Anda hanya boleh upload file gambar dengan tipe jpg atau png');
      upload.value = '';
      return false;
    }
  }

  return true;
}
