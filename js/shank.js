(function($, Drupal, drupalSettings) {
    Drupal.behaviors.MyModuleBehavior = {
        attach: function(context, settings) {
            // get color_body value with "drupalSettings.mymodule.color_body"
            var color_body = drupalSettings.shashank_exercise.color_body;
            alert(color_body)
            $('body').css('background', color_body);
        }
    };
})(jQuery, Drupal, drupalSettings);


(function ($) {
    $(document).ready(function () {
        var $permanentAdd = $('#same-address');
        var $tempAdd = $('.form-item-other-address');
        if ($permanentAdd.is(':checked')) {
            $tempAdd.hide();
        }
        $permanentAdd.on('change', function () {
        if ($(this).is(':checked')) {
            $tempAdd.hide();
        } else {
            $tempAdd.show();
        }
        });
    });
})(jQuery);


(function ($, Drupal) {

    $.fn.datacheck = function() {
        alert("form submission");
        $("#custom_get_user_details").submit();
    };

}(jQuery, Drupal));