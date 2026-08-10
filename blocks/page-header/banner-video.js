// Page Header Banner Video — iframe-safe (WP 7+)

(function ($) {
  'use strict';

  function initializeBannerVideo() {
    var $video = $('.page-header-block #banner-video');
    if (!$video.length || $video.data('cdevVideoInit')) {
      return;
    }
    $video.data('cdevVideoInit', true);

    var fallbackTimeout = setTimeout(function () {
      $video.fadeIn(400, function () {
        $('.page-header-block .header-video .header-banner-text').addClass('show');
      });
      $('.page-header-block .loading-spinner').fadeOut(400);
    }, 2000);

    $video.on('canplay load', function () {
      $video.delay(400).fadeIn(400, function () {
        $('.page-header-block .header-video .header-banner-text').addClass('show');
      });
      $('.page-header-block .loading-spinner').fadeOut(400);
      clearTimeout(fallbackTimeout);
    });
  }

  function runInit() {
    initializeBannerVideo();
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
