(function ($, Drupal) {

    $.fn.datacheck = function() {
        alert("form submission");
        $("#custom-user-details-form").submit();
    };

}(jQuery, Drupal));


