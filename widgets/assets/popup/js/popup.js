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
            backgroundClass : 'popup-background',
            backgroundOpacity : 0.7,
            containerClass : 'popup-container',
            popupMarkup : '<div class="popup"><div class="popup-content"/></div>',
            closeMarkup : '<div class="popup-close">&times;</div>',
            contentClass : 'popup-content',
            preloaderMarkup : '<div class="preloader">Loading</div>',
            hideFlash : false,
            speed : 200,

            // Events
            beforeOpen: function(popup) {},
            afterOpen: function(popup) {},
            beforeClose: function(popup) {},
            afterClose: function() {},

            // Content
            modal : false,
            content : null,
            width : '80%',
            height : null
        },
        pub = {
            init: function() {

            },
            open: function(options) {
                $.each(popupStack, function(index, popup) {
                    popup.hide();
                });
                popupStack.push(new Popup(options));
            },
            close: function() {
                var popup;
                if (popupStack.length && (popup = popupStack[popupStack.length-1])) {
                    popup.close();
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

        this.options.beforeOpen(this);

        // Should we hide the flash?
        if( this.options.hideFlash ){

            $('object, embed').css('visibility', 'hidden');

        }

        // Create the container
        this.$container = $('<div class="'+this.options.containerClass+'">');

        // Create back and fade in
        this.$background = $('<div class="'+this.options.backgroundClass+'"/>')
            .appendTo(this.$container)
            .css('opacity', this.options.backgroundOpacity);

        // If modal isn't specified, bind click event
        if ( !this.options.modal ) {

            this.$background.one('click.popup', function(){
                self.close();
            });

        }

        this.$popup = $(this.options.popupMarkup);

        // Get the actual content element
        this.$content = $('.'+this.options.contentClass, this.$popup);

        $(this.options.content).appendTo(this.$content);

        var $iframe = this.$content.find('iframe');

        // если контент содержит айфрейм то можно отобразить прелоадер
        if( $iframe.length && (!$iframe[0].contentWindow || ['uninitialized', 'loading'].indexOf($iframe[0].contentWindow.document.readyState) !== -1 ) ){

            // Preloader
            if( this.options.preloaderMarkup ){

                this.$popup.css('opacity',0);
                var $preloader = $(this.options.preloaderMarkup).appendTo($('body'));

                $iframe.load(function(){
                    $preloader.remove();
                    self.$popup.css('opacity',1);
                })

            }

        }

        // Add in the popup markup
        $(this.$popup).appendTo(this.$container);

        // Add in the close button
        $(this.options.closeMarkup)
            .one('click', function() {
                self.close();
            })
            .appendTo(this.$popup);

        // Append the container to the body
        this.$container.appendTo($('body'));

        // Do we have a set width/height?
        if ( this.options.width ) {

            this.$popup.css('width', this.options.width, 10);

        } else {

            this.$popup.css('width', '');
        }

        if ( this.options.height ) {

            this.$popup.css('height', this.options.height, 10);

        } else {

            this.$popup.css('height', '');

        }

        this.$popup.css({
            marginTop : "+=" + $(window).scrollTop()
        });

        this.options.afterOpen(this);
    }

    Popup.prototype = {
        show: function() {
            this.$container.show();
        },
        hide: function() {
            this.$container.hide();
        },
        close: function() {
            this.options.beforeClose(this);
            this.$container.remove();
            delete this.$container;
            delete this.$background;
            delete this.$popup;
            delete this.$content;
            cleanUp();
            this.options.afterClose();
        }
    };

    return pub;
})(jQuery);
