$(document).ready(function () {

  $('#add-socmed').on('click', function () {
    $('#socmed-rows').children('.empty-row').remove();

    var rows = $('#socmed-rows tr');
    var item_value = $('#meds-dd :selected').val();
    var item_label = $('#meds-dd :selected').text();
    var account_name = $('#socmed-account-name').val();
    var account_url = $('#socmed-account-url').val();
    var item_number = 0;
    var item = '';

    if (rows.length > 0) {
      item_number = (rows.length + 1) - 1;
      if ($('#socmed-item'+item_number).length) {
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

    $('#socmed-rows').append(item);
    $('#socmed-account-name').val('');
    $('#socmed-account-url').val('');
    $('#meds-dd').val('');
  });

  $('#photo-profile').on('change', function (e) {
    validate_image_upload();
  });

  $('#birth-date').inputmask('yyyy-mm-dd');

});
