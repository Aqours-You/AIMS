/**
 * Filename:login.php
 * Version:jQuery1.11.1
 * Create Date:2016/12/13
 * Author:y.shirahama
 */

jQuery(function($) {
    $(function() {
        $('.authgroup').on('click', function() {
            if ($(this).prop('checked')) {
                $('.authgroup').prop('checked', false);
                $(this).prop('checked', true);
            }
        });
    });
});
            