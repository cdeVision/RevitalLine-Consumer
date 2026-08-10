// Page Header Banner Slideshow — iframe-safe (WP 7+)

(function ($) {
  'use strict';

  function initializeBannerSlick() {
    $('.page-header-block .banner_slideshow').not('.slick-initialized').each(function () {
      var $slideshow = $(this);
      if (!$slideshow.children().length) {
        return;
      }
      if (typeof $slideshow.slick !== 'function') {
        return;
      }
      $slideshow.slick({
        useTransform: true,
        autoplay: true,
        pauseOnHover: true,
        autoplaySpeed: 4000,
        arrows: $(window).width() > 1360,
        dots: false,
        infinite: true,
        speed: 800,
        cssEase: 'ease-out',
        fade: true
      });
    });

    $('.page-header-block .header-slideshow .header-banner-text').addClass('show');
  }

  function runInit() {
    initializeBannerSlick();
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
    $('.page-header-block .banner_slideshow.slick-initialized').each(function () {
      $(this).slick('slickSetOption', 'arrows', wide, true);
    });
  });
})(jQuery);
