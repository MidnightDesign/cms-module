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

    (function activateBlock() {
        function activate($block) {
            $block.addClass('active');
        }

        function getBlockFromClick(e) {
            var $block;
            $block = $(e.target).parents('.midnight-cms-block').first();
            return $block;
        }

        function clearActive() {
            $('.midnight-cms-block').removeClass('active');
        }

        $('body')
            .on('click', function (e) {
                var $block;
                clearActive();
                $block = getBlockFromClick(e);
                activate($block);
            })
            .on('click', '.midnight-cms-block *', function (e) {
                var $block;
                $block = getBlockFromClick(e);
                if (!$block.is('.active')) {
                    e.stopPropagation();
                    e.preventDefault();
                }
                clearActive();
                activate($block);
            })
    }())
}(jQuery));
