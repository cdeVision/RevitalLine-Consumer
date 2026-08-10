// Gallery "View More" — iframe-safe (WP 7+; loads via block.json)

(function ($) {
  'use strict';

  $(document).on('click', '.gallery_view_more a.box', function (e) {
    e.preventDefault();
    var $viewMore = $(this).closest('.gallery_view_more');
    $viewMore.hide();
    $viewMore.prev('div').find('a').fadeIn(400);
  });
})(jQuery);
