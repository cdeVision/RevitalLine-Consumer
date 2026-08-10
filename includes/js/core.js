// JavaScript Document

// Popup ///////////////////////////////////////
document.addEventListener('DOMContentLoaded', function () {
    const popup = document.getElementById('homepage-popup');
    const overlay = document.getElementById('popup-overlay');
    const closeButton = popup ? popup.querySelector('.popup-close') : null;

    if (popup && overlay && document.body.classList.contains('home')) {
        setTimeout(() => {
            popup.classList.remove('hidden');
            overlay.classList.remove('hidden');
            overlay.style.display = 'block'; // Ensure overlay is visible
        }, 2000); // Changed delay to 2 seconds

        closeButton.addEventListener('click', () => {
            popup.classList.add('hidden');
            overlay.classList.add('hidden');
            overlay.style.display = 'none'; // Hide overlay
        });

        overlay.addEventListener('click', () => {
            popup.classList.add('hidden');
            overlay.classList.add('hidden');
            overlay.style.display = 'none'; // Hide overlay
        });
    }
});

// Pages /////////////////////////////////////
var $j = jQuery.noConflict();
$j(function () {
    
// Mobile menu ///////////////////////////////
var focusableSelectors = 'a[href], button:not([disabled]), input, select, textarea, [tabindex]:not([tabindex="-1"])';

function openNavPanel() {
    $j('.nav-panel').addClass('open');
    $j('.mobile-hamburger__link').addClass('open').attr('aria-expanded', 'true');
    // Move focus to first focusable element in panel after transition
    setTimeout(function () {
        var first = $j('.nav-panel').find(focusableSelectors).first();
        if (first.length) first.trigger('focus');
    }, 350);
}

function closeNavPanel() {
    $j('.nav-panel').removeClass('open');
    $j('.mobile-hamburger__link').removeClass('open').attr('aria-expanded', 'false');
    // Return focus to hamburger button
    $j('.mobile-hamburger__link').trigger('focus');
}

$j('.mobile-hamburger__link').click(function () {
    if ($j('.nav-panel').hasClass('open')) {
        closeNavPanel();
    } else {
        openNavPanel();
    }
});


// Close panel on outside click 
$j(document).on('click', function (e) {
    if (!$j('.nav-panel').hasClass('open')) return;
    if ($j(e.target).closest('.nav-panel, .mobile-hamburger').length) return;
    closeNavPanel();
});


// Focus trap inside panel ///////////////////
$j(document).on('keydown', function (e) {
    if (!$j('.nav-panel').hasClass('open')) return;

    // Escape key closes panel
    if (e.key === 'Escape') {
        closeNavPanel();
        return;
    }

    if (e.key !== 'Tab') return;

    var panelFocusable = $j('.nav-panel').find(focusableSelectors).filter(':visible');
    var hamburger = $j('.mobile-hamburger__link');
    var allFocusable = panelFocusable.add(hamburger);
    if (!allFocusable.length) return;

    var first = allFocusable.first();
    var last  = allFocusable.last();
    var current = $j(document.activeElement);

    if (e.shiftKey) {
        // Shift+Tab: if focus is on first element, wrap to hamburger (last)
        if (current.is(first)) {
            e.preventDefault();
            last.trigger('focus');
        }
    } else {
        // Tab: if focus is on last element (hamburger), wrap to first panel element
        if (current.is(last)) {
            e.preventDefault();
            first.trigger('focus');
        }
    }
});
///////////////////////////////////////////////



// main menu dropdown menu ///////////////////
    
// shut down click in main menu
$j(".noclick > a").click(function (e) {
    // stop default link action
    //return false;
    e.preventDefault();
});

// Desk menu (hover only — skipped when nav-panel is in mobile mode)
$j('.primary-menu .menu-item-has-children').hover(
    function () {
        if ($j('.nav-panel').css('position') === 'fixed') return;
        $j('ul', this).stop().delay(200).fadeIn(200);
    },
    function () {
        if ($j('.nav-panel').css('position') === 'fixed') return;
        $j('ul', this).stop().clearQueue().fadeOut(200);
    }
);

$j('.primary-menu .menu-item-has-children > a').click(function(){
	if ($j('.nav-panel').css('position') !== 'fixed') return false;
});

///////////////////////////////////////////////


    
// Mobile sub-menu toggle ////////////////////
$j('.nav-panel .primary-menu .menu-item-has-children > a').attr('aria-expanded', 'false');
$j('.nav-panel .primary-menu .menu-item-has-children > a').click(function(){
	var e = $j(this);
	var isOpen = e.hasClass('open');
	e.next('ul').slideToggle("fast");
	e.toggleClass('open').attr('aria-expanded', !isOpen);
	return false;
});
///////////////////////////////////////////////

    
// alert close ////////////////////////////////
$j('.alertbar .close').click(function(){
	$j('.alertbar').slideToggle("fast");
	return false;
});
///////////////////////////////////////////////


// Suppress transitions on window resize ////
var resizeTimer;
$j(window).on('resize', function() {
    $j('body').addClass('resize-animation-stopper');
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
        $j('body').removeClass('resize-animation-stopper');
    }, 400);
});
/////////////////////////////////////////////// 


// Accordion + gallery "View More" live in blocks/*/accordion.js and gallery.js
// (block.json "script") so they also run in the WP 7+ editor iframe.


}); // end