jQuery(document).ready(function($) {
  $('#edd_locations_enable').on('click', function() {
    var checked = $(this).attr('checked');
    if(checked == 'checked') {
      $('#edd_locations').removeAttr('disabled');
      $('#edd_locations').trigger('chosen:updated');
    } else {
      $('#edd_locations').attr('disabled', 'disable');
      $('#edd_locations').trigger('chosen:updated');
    }
  });
});
