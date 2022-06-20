require([
    'jquery'
], function ($) {
    'use strict';

    $(document).ready(function(){
        $('.update_booking').change(function () {
            if ($('.update_booking').prop('checked')) {
                $('.info_booking').attr("disabled", false);
            } else {
                $('.info_booking').attr("disabled", true);
            }
        })

    });

});
