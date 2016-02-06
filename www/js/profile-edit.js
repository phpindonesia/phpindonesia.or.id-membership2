jQuery(document).ready(function () {

  jQuery("#provinces-dd").on('change', function () {
    var prov_id = jQuery("#provinces-dd :selected").val();

    if (prov_id != '') {

      jQuery.ajax({
        method: 'GET',
        url: _base_url_+'/apps/common-data/cities/'+prov_id,
        dataType: 'json'
      }).done(function (data) {
        input_select({
          value: 'id',
          label: 'regional_name',
          dst: jQuery("#cities-dd")
        }, data);
      }).fail(function (data) {
        alert('Failed to request data');
      });

    } else {
      input_select({dst: jQuery("#cities-dd")}, []);
    }
  });

  jQuery('#add-socmed').on('click', function () {
    jQuery('#socmed-rows').children('.empty-row').remove();

    var rows = jQuery('#socmed-rows tr');
    var item_value = jQuery('#meds-dd :selected').val();
    var item_label = jQuery('#meds-dd :selected').text();
    var account_name = jQuery('#socmed-account-name').val();
    var account_url = jQuery('#socmed-account-url').val();
    var item_number = 0;
    var item = '';

    if (rows.length > 0) {
      item_number = (rows.length + 1) - 1;
      if (jQuery('#socmed-item'+item_number).length) {
        item_number += 1;
      }
    }

    item += '<tr id="socmed-item'+item_number+'">';

    item += '<td>';
    item += item_label;
    item += '<input class="db-row-id" type="hidden" name="socmeds['+item_number+'][member_socmed_id]" value="0" />';
    item += '<input class="socmed-type" type="hidden" name="socmeds['+item_number+'][socmed_type]" value="'+item_value+'" />';
    item += '</td>';

    item += '<td>';
    item += '<input type="text" name="socmeds['+item_number+'][account_name]" value="'+account_name+'" />';
    item += '</td>';

    item += '<td>';
    item += '<input type="text" name="socmeds['+item_number+'][account_url]" value="'+account_url+'" />';
    item += '</td>';

    item += '<td style="font-size: 1.5em">';
    item += "<a href=\"javascript:delete_socmed('socmed-item"+item_number+"')\" title=\"Delete this socmed item\">x</a>";
    item += '</td>';

    item += '</tr>';

    jQuery('#socmed-rows').append(item);
    jQuery('#socmed-account-name').val('');
    jQuery('#socmed-account-url').val('');
    jQuery('#meds-dd').val('');
  });

  jQuery('#photo-profile').on('change', function (e) {
    validate_image_upload();
  });

  jQuery('#birth-date').inputmask('yyyy-mm-dd');

})

function delete_socmed(item_id) {

  jQuery('#'+item_id).hide('slow', function () {

    var deletes = jQuery('#delete-collections input');
    var first_td = jQuery(this).children(':first');
    var socmed_type = first_td.children('.socmed-type').val();
    var db_row_id = parseInt(first_td.children('.db-row-id').val());

    if (db_row_id > 0) {
      jQuery('#delete-collections').append('<input type="hidden" name="socmeds_delete[]" value="'+socmed_type+'" />');
    }

    jQuery(this).remove();
  });
}

MAX_SIZE = 1024 * 250;

function validate_image_upload() {
  var upload = document.getElementById('photo-profile');
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
            jQuery('#img-photo-profile').attr('src', e.target.result);
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
