/* jQuery(document).ready(function($) {
  var $form = $("#edd_purchase_form");
  
  // Validate discount location
  var $checkout_form_wrap = $('#edd_checkout_form_wrap');
  $checkout_form_wrap.on('click', '.edd-apply-discount', function (event) {
    event.preventDefault();
    var discount_code = $form.find('#edd-discount').val();
    var country = $form.find('#billing_country').val();
    //alert(country);
    var data = {
      action: 'validate_discount_location',
      code: discount_code,
      country: country,
      apply: true
    }
    if(discount_code != '') {
      $.post( ajax_object.ajax_url, data, function(responce) {
        responce = $.parseJSON(responce);
        console.log(responce);
        if(! responce.valid) {
          $('#edd-discount-error-wrap').html( '<span class="edd_error">' + responce.message + '</span>' );
          $('#edd-discount-error-wrap').css('display: block');
        }
      });
    }
  });
}); */