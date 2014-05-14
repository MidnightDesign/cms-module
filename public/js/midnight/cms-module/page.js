/*global jQuery*/

(function ($) {
    (function editDialog() {
        $('body').on('click', 'a.edit-cms-block', function (e) {
            var $link, href;
            $link = $(this);
            e.preventDefault();
            href = $link.attr('href');
            $.ajax(href, {
                success: function (r, status, xhr) {
                    if ('text/fragment+html' === xhr.getResponseHeader("content-type")) {
                        new Midnight.UI.Dialog(r);
                    } else {
                        location.href = href;
                    }
                }
            });
        });
    }());
}(jQuery));
