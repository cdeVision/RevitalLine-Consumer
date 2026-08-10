// Home Header Video — iframe-safe (WP 7+)

(function ($) {
  'use strict';

  function initializeHomeVideo() {
    var $video = $('.home-header-block #home-video');
    if (!$video.length || $video.data('cdevVideoInit')) {
      return;
    }
    $video.data('cdevVideoInit', true);

    var $wrap = $('.home-header-block .home-header.header-video video');

    var fallbackTimeout = setTimeout(function () {
      $wrap.fadeIn(400, function () {
        $('.home-header-block .header-video .header-banner-text').addClass('show');
      });
      $('.home-header-block .loading-spinner').fadeOut(400);
    }, 2000);

    $video.on('canplay load', function () {
      $wrap.delay(400).fadeIn(400, function () {
        $('.home-header-block .header-video .header-banner-text').addClass('show');
      });
      $('.home-header-block .loading-spinner').fadeOut(400);
      clearTimeout(fallbackTimeout);
    });
  }

  function runInit() {
    initializeHomeVideo();
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
