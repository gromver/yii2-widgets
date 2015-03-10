/*-------------------------------

	POPUP.JS

	Simple Popup plugin for Yii2 Grom Platform

	@author Roman Gayazov
	@version 1.0.0

-------------------------------*/

yii.gromverPopup = (function ($) {
    var popupStack = [],
        defaults = {

            // Markup
            backClass : 'popup_back',
            backOpacity : 0.7,
            containerClass : 'popup_cont',
            closeContent : '<div class="popup_close">&times;</div>',
            markup : '<div class="popup"><div class="popup_content"/></div>',
            contentClass : 'popup_content',
            preloaderContent : '<p class="preloader">Loading</p>',
            activeClass : 'popup_active',
            hideFlash : false,
            speed : 200,
            popupPlaceholderClass : 'popup_placeholder',
            keepInlineChanges :  true,

            // Events
            afterOpen: function(popup) {},
            afterClose: function() {},

            // Content
            modal : false,
            content : null,
            width : null,
            height : null
        },
        pub = {
            init: function() {

            },//afterClose
            open: function(options) {
                $.each(popupStack, function(index, popup) {
                    popup.hide();
                });
                popupStack.push(new Popup(options));
            },
            close: function() {
                var popup;
                if (popup = popupStack.pop()) {
                    popup.close();
                }
                if (popupStack.length && (popup = popupStack[popupStack.length-1])) {
                    popup.show();
                }
            }
        };

    function cleanUp() {
        var popup;

        popupStack.pop();

        if (popupStack.length && (popup = popupStack[popupStack.length-1])) {
            popup.show();
        }
    }

    function Popup(options) {
        var self = this;

        this.options = $.extend(true, {}, defaults, options);

        // Create back and fade in
        this.$back = $('<div class="'+this.options.backClass+'"/>')
            .appendTo($('body'))
            .css('opacity', this.options.backOpacity);
            /*.css('opacity', 0)
            .animate({
                opacity : p.o.backOpacity
            }, p.o.speed);*/

        // If modal isn't specified, bind click event
        if ( !this.options.modal ) {

            this.$back.one('click.popup', function(){
                self.close();
            });

        }

        // Should we hide the flash?
        if( this.options.hideFlash ){

            $('object, embed').css('visibility', 'hidden');

        }

        // Preloader
        /*if( this.options.preloaderContent ){

            $preloader = $(this.options.preloaderContent)
                .appendTo($('body'));

        }*/


        // Create the container
        this.$container = $('<div class="'+this.options.containerClass+'">');

        // Add in the popup markup
        $(this.options.markup).appendTo(this.$container);

        // Add in the close button
        $(this.options.closeContent)
            .one('click', function() {
                self.close();
            })
            .appendTo(this.$container);

        // Bind the resize event
        $(window).resize($.proxy(this.center, this));

        // Append the container to the body
        // and set the opacity
        this.$container.appendTo($('body'));//.css('opacity', 0);


        // Get the actual content element
        this.$content = $('.'+this.options.contentClass, this.$container);
        $(this.options.content).appendTo(this.$content);

        // Do we have a set width/height?
        if ( this.options.width ) {

            this.$container.css('width', this.options.width, 10);

        } else {

            this.$container.css('width', '');
        }

        if ( this.options.height ) {

            this.$container.css('height', this.options.height, 10);

        } else {

            this.$container.css('height', '');

        }

        this.center();

        this.options.afterOpen(this);

        // Put the content in place!
        /*if( $p.hasClass(this.options.contentClass) ){

            $p
                .html(content);

        }else{

            $p
                .find('.'+this.options.contentClass)
                .html(content);

        }*/

    }

    Popup.prototype = {
        show: function() {
            this.$back.show();
            this.$container.show();
        },
        hide: function() {
            this.$back.hide();
            this.$container.hide();
        },
        close: function() {
            this.$back.remove();
            this.$container.remove();
            delete this.$back;
            delete this.$container;
            delete this.$content;
            cleanUp();
            this.options.afterClose();
        },
        center: function() {
            var pW = this.$container.children().outerWidth(true),
                pH = this.$container.children().outerHeight(true),
                wW = document.documentElement.clientWidth,
                wH = document.documentElement.clientHeight,
                center = {
                    top : wH * 0.5 - pH * 0.5,
                    left : wW * 0.5 - pW * 0.5
                };

            this.$container.css(center);

            // Only need force for IE6
            this.$back.css({
                height : document.documentElement.clientHeight
            });
        }
    };

    return pub;
})(jQuery);
