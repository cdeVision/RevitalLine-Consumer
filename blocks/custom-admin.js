/**
 * Custom admin script for handling block updates on post save.
 * 
 * This script listens for changes in the WordPress editor state and triggers
 * updates to a specific block's attributes when the post title changes and the
 * post is saved. It ensures that the block is refreshed and the post is saved
 * again if necessary to clear the dirty state.
 */


// console.log('custom-admin.js loaded');


// Sync page header title with post title in real-time
wp.domReady(() => {
    const { select, subscribe } = wp.data;
    const { getEditedPostAttribute } = select('core/editor');

    let previousTitle = getEditedPostAttribute('title') || '';

    subscribe(() => {
        const currentTitle = getEditedPostAttribute('title') || '';

        // Only update when title actually changes
        if (currentTitle !== previousTitle) {
            previousTitle = currentTitle;

            // Find the page header title element and update it directly
            const headerBlock = document.querySelector('.page-header-block .header-banner-text .h1');
            // Skip if title has an override (ACF override_page_title or other override)
            if (headerBlock && !headerBlock.hasAttribute('data-title-override')) {
                // Preserve any parent link HTML (e.g., "Artist: ")
                const parentLink = headerBlock.querySelector('a');
                if (parentLink) {
                    // Keep the link, update only the text after it
                    const linkHtml = parentLink.outerHTML;
                    headerBlock.innerHTML = linkHtml + currentTitle;
                } else {
                    headerBlock.textContent = currentTitle;
                }
            }
        }
    });
});


jQuery.noConflict();
jQuery(document).ready(function ($) {
    //console.log('AccordionJS Loaded');

    // Accordion /////////////////////////////////
    $(document).on('click', '.accordiontitle', function () {
        //console.log('Accordion clicked - Admin');
        $(this).next('div').slideToggle("fast");
        $(this).toggleClass('open');
        return false;
    });

    // View More gallery link ////////////////////
    $(document).on('click', '.gallery_view_more a.box', function () {
        $('.gallery_view_more').hide();
        $('.gallery_view_more').prev("div").find("a").fadeIn(400);
        return false;
    });
    /////////////////////////////////////////////// 

    // Gallery lightbox ///////////////////////////
    $(document).on('click', '.gallery-item a', function () {
        return false;
    });

});


// Force preview mode for all blocks on save
wp.domReady(() => {
    const { subscribe, dispatch, select } = wp.data;

    // Subscribe to editor state changes
    subscribe(() => {
        const isSaving = select('core/editor').isSavingPost();
        const isAutosaving = select('core/editor').isAutosavingPost();

        if (isSaving && !isAutosaving) {
            const blocks = select('core/block-editor').getBlocks();

            blocks.forEach(block => {
                // Only switch if block is in edit mode
                if (block.attributes.mode === 'edit') {
                    dispatch('core/block-editor').updateBlockAttributes(block.clientId, {
                        mode: 'preview',
                    });
                }
            });
        }
    });
});