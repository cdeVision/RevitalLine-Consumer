// Logo Slider — iframe-safe (WP 7+; loads via block.json inside canvas)

(function ($) {
  'use strict';

  var slickDefaults = {
    useTransform: true,
    autoplay: true,
    pauseOnHover: true,
    autoplaySpeed: 4000,
    arrows: true,
    dots: false,
    infinite: true,
    speed: 500,
    cssEase: 'ease-out',
    slidesToScroll: 1,
    responsive: [
      {
        breakpoint: 1200,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 1,
          infinite: true,
          arrows: true,
          dots: false
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          infinite: true,
          arrows: true,
          dots: false
        }
      }
    ]
  };

  function mergeDataSlick($el) {
    var settings = $.extend(true, {}, slickDefaults);
    var raw = $el.attr('data-slick');
    if (raw) {
      try {
        var parsed = typeof raw === 'string' ? JSON.parse(raw) : raw;
        $.extend(true, settings, parsed);
      } catch (e) {
        // Ignore invalid JSON
      }
    }
    return settings;
  }

  function initializeSlick() {
    $('.logo_slideshow').not('.slick-initialized').each(function () {
      var $slideshow = $(this);
      if (!$slideshow.children().length) {
        return;
      }
      if (typeof $slideshow.slick !== 'function') {
        return;
      }
      $slideshow.slick(mergeDataSlick($slideshow));
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
})(jQuery);
