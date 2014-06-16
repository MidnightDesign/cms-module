/*global jQuery*/

(function ($) {
    var BLOCK_CLASS = 'midnight-cms-block',
        ADD_BLOCK_CLASS = 'add-block-inline';

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
            $block.trigger('activate');
        }

        function getBlockFromClick(e) {
            var $block;
            $block = $(e.target).parents('.' + BLOCK_CLASS).first();
            return $block;
        }

        function deactivate($block) {
            $block.removeClass('active');
            $block.trigger('deactivate');
        }

        function clearActive() {
            $('.' + BLOCK_CLASS).each(function () {
                deactivate($(this));
            });
        }

        $('body')
            .on('click', function (e) {
                var $block;
                clearActive();
                $block = getBlockFromClick(e);
                activate($block);
            })
            .on('click', '.' + BLOCK_CLASS + ' *', function (e) {
                var $block;
                $block = getBlockFromClick(e);
                clearActive();
                activate($block);
            })
    }());

    (function positionAddBlockButtons() {
        var BEFORE = 'before',
            AFTER = 'after';

        function getAnchorBlock($button) {
            var $next = $button.next();
            if ($next.length) {
                return  {
                    $element: $next,
                    position: BEFORE
                };
            }
            return  {
                $element: $button.prev(),
                position: AFTER
            };
        }

        function getTargetPosition($button, $block) {
            var anchorOffset, beforeOrAfter, $anchor, center;
            if ($block) {
                $anchor = $block;
                beforeOrAfter = ($block.prev().get(0) === $button.get(0)) ? BEFORE : AFTER;
            } else {
                $anchor = getAnchorBlock($button);
                beforeOrAfter = $anchor.position;
                $anchor = $anchor.$element;
            }
            anchorOffset = $anchor.offset();
            center = {y: anchorOffset.top};
            if (beforeOrAfter === AFTER) {
                center.y += $anchor.outerHeight();
            }
            center.x = anchorOffset.left + ($anchor.outerWidth() / 2);
            return {
                x: center.x - ($button.outerWidth() / 2),
                y: center.y - ($button.outerHeight() / 2)
            };
        }

        function positionButtons($buttons, $block) {
            $buttons.each(function () {
                var position, $button;
                $button = $(this);
                position = getTargetPosition($button, $block);
                $button.css({
                    left: Math.round(position.x) + 'px',
                    top: Math.round(position.y) + 'px'
                });
            });
        }

        function getAdjacentSiblings($element, selector) {
            return $element.prev(selector).add($element.next(selector));
        }

        function init() {
            $('body')
                .on('mouseover', '.' + BLOCK_CLASS, function () {
                    var $block, $buttons;
                    $block = $(this);
                    if ($block.is('.active')) {
                        return;
                    }
                    $('.' + ADD_BLOCK_CLASS).removeClass('active');
                    $buttons = getAdjacentSiblings($block, '.' + ADD_BLOCK_CLASS);
                    $buttons.addClass('active');
                    positionButtons($buttons, $block);
                })
                .on('activate', '.' + BLOCK_CLASS, function () {
                    var $block, $buttons;
                    $block = $(this);
                    $buttons = getAdjacentSiblings($block, '.' + ADD_BLOCK_CLASS);
                    $buttons.removeClass('active');
                });
        }

        $(init);
    }());

    (function createBlockInline() {
        var CREATE_BLOCK_CLASS = 'create-block';

        function init() {
            $('body')
                .on('click', '.' + ADD_BLOCK_CLASS, function (e) {
                    var $button;
                    e.preventDefault();
                    $button = $(this);
                    $.ajax($button.attr('href'), {
                        success: function (r) {
                            $('<div></div>')
                                .addClass(CREATE_BLOCK_CLASS)
                                .html(r)
                                .insertBefore($button);
                        }
                    });
                })
                .on('click', '.' + CREATE_BLOCK_CLASS, function (e) {
                    e.stopPropagation();
                })
                .on('click', function () {
                    $('.' + CREATE_BLOCK_CLASS).remove();
                })
                .on('click', '.' + CREATE_BLOCK_CLASS + ' a[href]', function (e) {
                    var $button;
                    e.preventDefault();
                    $button = $(this);
                    $.ajax($button.attr('href'), {
                        success: function (r) {
                            var scrollX, scrollY;
                            scrollY = window.scrollY;
                            scrollX = window.scrollX;

                            $('.page-blocks').get(0).innerHTML = $(r).find('.page-blocks').html();
                            setTimeout(function () {
                                window.scrollTo(scrollX, scrollY);
                            }, 100);
                        }
                    });
                });
        }

        $(init);
    }());
}(jQuery));
