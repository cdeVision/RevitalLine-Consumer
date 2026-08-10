// Slideshow — iframe-safe (WP 7+; loads via block.json inside canvas)

(function ($) {
  'use strict';

  var slickSettings = {
    useTransform: true,
    autoplay: false,
    pauseOnHover: true,
    autoplaySpeed: 4000,
    arrows: $(window).width() > 1360,
    dots: $(window).width() <= 1360,
    infinite: true,
    speed: 800,
    cssEase: 'ease-out',
    fade: true
  };

  function initializeSlick() {
    $('.slideshow').not('.slick-initialized').each(function () {
      var $slideshow = $(this);
      if (!$slideshow.children().length) {
        return;
      }
      if (typeof $slideshow.slick !== 'function') {
        return;
      }
      $slideshow.slick(slickSettings);
    });
  }

  function runInit() {
    initializeSlick();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', runInit);
  } else {
    runInit();
  }

  if (typeof window.wp !== 'undefined' && window.wp.domReady) {
    window.wp.domReady(runInit);
  }

  var debounceTimer;
  var domObserver = new MutationObserver(function () {
    clearTimeout(debounceTimer);
    debounceTimer = window.setTimeout(runInit, 100);
  });

  if (document.body) {
    domObserver.observe(document.body, { childList: true, subtree: true });
  } else {
    document.addEventListener('DOMContentLoaded', function () {
      if (document.body) {
        domObserver.observe(document.body, { childList: true, subtree: true });
      }
    });
  }

  $(window).on('resize', function () {
    var wide = $(window).width() > 1360;
    $('.slideshow.slick-initialized').each(function () {
      var $s = $(this);
      $s.slick('slickSetOption', 'arrows', wide, false);
      $s.slick('slickSetOption', 'dots', !wide, true);
    });
  });
})(jQuery);
