
    $(document).ready(function() {

    jQuery.validator.setDefaults({
      debug: true,
      success: "valid"
    });

    $( "#myform" ).validate({
      rules: {
        "phone-number": {
          required: true,
          number: true,
          maxlength:10,
          minlength:10
        }
      }
    });

    var form = $( "#myform" );

    $(".phone-number").on('input',function(){
       
        form.valid();
    })


})