// External Dependencies
import $ from 'jquery';

$(window).on('et_builder_api_ready', () => {
    // Add default data for mdoules in visual builder
    if (window.ETBuilderBackend && window.ETBuilderBackend.defaults && window.DIFL_Diviflash_Backend) {

        // Add default placeholder for Icon List Module
        if (window.DIFL_Diviflash_Backend.iconListDefault) {
            window.ETBuilderBackend.defaults.difl_iconlist = window.DIFL_Diviflash_Backend.iconListDefault;
        }

        // Icon List child Module
        if (window.DIFL_Diviflash_Backend.iconListItemDefault) {
            window.ETBuilderBackend.defaults.difl_iconlistitem = window.DIFL_Diviflash_Backend.iconListItemDefault;
        }

         // Add default placeholder for FAQ Module
         if (window.DIFL_Diviflash_Backend.faqDefault) {
            window.ETBuilderBackend.defaults.difl_faq = window.DIFL_Diviflash_Backend.faqDefault;
        }

        // FAQ child Module
        if (window.DIFL_Diviflash_Backend.faqItemDefault) {
            window.ETBuilderBackend.defaults.difl_faqitem = window.DIFL_Diviflash_Backend.faqItemDefault;
        }

        // Add default placeholder for Timeline Module
        if (window.DIFL_Diviflash_Backend.timelineDefault) {
            window.ETBuilderBackend.defaults.difl_timeline = window.DIFL_Diviflash_Backend.timelineDefault;
        }

        // Timeline child Module
        if (window.DIFL_Diviflash_Backend.timelineItemDefault) {
            window.ETBuilderBackend.defaults.difl_timelineitem = window.DIFL_Diviflash_Backend.timelineItemDefault;
        }

        // Add default placeholder for AdvancedMenu Module
        if (window.DIFL_Diviflash_Backend.advancedMenuDefault) {
            window.ETBuilderBackend.defaults.difl_advancedmenu = window.DIFL_Diviflash_Backend.advancedMenuDefault;
        }
        if (window.DIFL_Diviflash_Backend.advancedMenuItemDefault) {
            window.ETBuilderBackend.defaults.difl_advancedmenuitem = window.DIFL_Diviflash_Backend.advancedMenuItemDefault;
        }
        // PostList child Module
        if (window.DIFL_Diviflash_Backend.postListDefault) {
            window.ETBuilderBackend.defaults.difl_postlist = window.DIFL_Diviflash_Backend.postListDefault;
        }
        // Add default placeholder for Image Reveal Module
        if (window.DIFL_Diviflash_Backend.imageRevealDefault) {
            window.ETBuilderBackend.defaults.difl_imagereveal = window.DIFL_Diviflash_Backend.imageRevealDefault;
        }

        // Add default placeholder for Marquee Text Module
        if (window.DIFL_Diviflash_Backend.marqueeTextDefault) {
            window.ETBuilderBackend.defaults.difl_marqueetext = window.DIFL_Diviflash_Backend.marqueeTextDefault;
        }

        // Marquee Text child Module
        if (window.DIFL_Diviflash_Backend.marqueeTextItemDefault) {
            window.ETBuilderBackend.defaults.difl_marqueetextitem = window.DIFL_Diviflash_Backend.marqueeTextItemDefault;
        }

         // Add default placeholder for Image Reveal Module
         if (window.DIFL_Diviflash_Backend.textHighlighterDefault) {
            window.ETBuilderBackend.defaults.difl_text_highlighter = window.DIFL_Diviflash_Backend.textHighlighterDefault;
        }

    }
});
