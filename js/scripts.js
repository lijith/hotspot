$(document).ready(function() {

  jQuery.validator.setDefaults({
    debug: true,
    success: "valid"
  });

  var form = $("#myform");


  form.validate({
    rules: {
      "phone-number": {
        required: true,
        number: true,
        maxlength: 10,
        minlength: 10
      }
    },
    submitHandler: function(form) {
      // do other things for a valid form
      form.submit();
    }
  });


  $(".phone-number").on('input', function() {

    form.valid();
  })


})