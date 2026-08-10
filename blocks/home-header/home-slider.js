// Home Header Slideshow — iframe-safe (WP 7+)

(function ($) {
  'use strict';

  function initializeHomeSlick() {
    var $slideshows = $('.home-header-block .home_slideshow').not('.slick-initialized');
    if (!$slideshows.length) {
      return;
    }

    $slideshows
      .off('init.homeSlider beforeChange.homeSlider afterChange.homeSlider')
      .on('init.homeSlider', function () {
        setTimeout(function () {
          $('.home-header-block .home_slideshow .slick-slide[data-slick-index="0"] .header-banner-text').addClass('fade-in');
        }, 150);
      })
      .on('beforeChange.homeSlider', function () {
        $('.home-header-block .home_slideshow .slick-slide .header-banner-text').removeClass('fade-in');
      })
      .on('afterChange.homeSlider', function (event, slick, currentSlide) {
        setTimeout(function () {
          $('.home-header-block .home_slideshow .slick-slide[data-slick-index="' + currentSlide + '"] .header-banner-text').addClass('fade-in');
        }, 150);
      });

    $slideshows.each(function () {
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
        dots: $(window).width() <= 1360,
        infinite: true,
        speed: 800,
        cssEase: 'ease-out',
        fade: true
      });
    });
  }

  function runInit() {
    initializeHomeSlick();
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
    $('.home-header-block .home_slideshow.slick-initialized').each(function () {
      var $s = $(this);
      $s.slick('slickSetOption', 'arrows', wide, false);
      $s.slick('slickSetOption', 'dots', !wide, true);
    });
  });
})(jQuery);
