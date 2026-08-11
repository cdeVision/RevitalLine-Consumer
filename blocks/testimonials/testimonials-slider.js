// Testimonials Slider — iframe-safe (WP 7+; loads via block.json inside canvas)

(function ($) {
  'use strict';

  var slickSettings = {
    useTransform: true,
    autoplay: false,
    arrows: true,
    dots: false,
    infinite: true,
    speed: 600,
    cssEase: 'ease-out',
    slidesToShow: 3,
    slidesToScroll: 1,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  };

  function markClampedQuotes($slider) {
    $slider.find('.testimonial-quote').each(function () {
      var $quote = $(this);
      var el = $quote.find('p').get(0);
      if (!el) {
        $quote.removeClass('is-clamped');
        return;
      }
      // Line-clamped when content taller than visible box
      $quote.toggleClass('is-clamped', el.scrollHeight > el.clientHeight + 1);
    });
  }

  function equalizeCardHeights($slider) {
    var $items = $slider.find('.testimonial-item');
    if (!$items.length) {
      return;
    }

    $items.css('height', 'auto');
    markClampedQuotes($slider);

    var maxHeight = 0;
    $items.each(function () {
      maxHeight = Math.max(maxHeight, $(this).outerHeight());
    });

    if (maxHeight > 0) {
      $items.css('height', maxHeight);
    }
  }

  function initializeSlick() {
    $('.testimonials-slider').not('.slick-initialized').each(function () {
      var $slider = $(this);
      if (!$slider.children().length) {
        return;
      }
      if (typeof $slider.slick !== 'function') {
        return;
      }

      var slideCount = $slider.children().length;
      var settings = $.extend(true, {}, slickSettings);

      // Slick hides arrows when there aren't enough slides to scroll.
      if (slideCount <= settings.slidesToShow) {
        settings.infinite = false;
      }

      $slider.on('init breakpoint setPosition reInit', function () {
        window.requestAnimationFrame(function () {
          equalizeCardHeights($slider);
        });
      });

      $slider.slick(settings);
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
    clearTimeout(debounceTimer);
    debounceTimer = window.setTimeout(function () {
      $('.testimonials-slider.slick-initialized').each(function () {
        equalizeCardHeights($(this));
      });
    }, 150);
  });
})(jQuery);
