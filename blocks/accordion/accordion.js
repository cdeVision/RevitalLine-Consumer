// Accordion — iframe-safe (WP 7+; loads via block.json)

(function ($) {
  'use strict';

  $(document).on('click', '.accordiontitle', function (e) {
    e.preventDefault();
    $(this).next('div').slideToggle('fast');
    $(this).toggleClass('open');
  });
})(jQuery);
