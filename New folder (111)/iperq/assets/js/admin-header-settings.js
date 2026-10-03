(function ($) {
    'use strict';

    var $form;
    var $saveBar;
    var isDirty = false;

    function setDirtyState(dirty) {
        isDirty = dirty;
        if (!$saveBar || !$saveBar.length) {
            return;
        }

        $saveBar.toggleClass('is-dirty', dirty).removeClass('is-saving');
        $saveBar.find('[data-save-state]').text(dirty ? 'Unsaved changes' : 'All changes saved');
    }

    function updateLogoPreview(url) {
        var $preview = $('[data-media-preview]');
        $preview.empty().toggleClass('is-empty', !url);
        if (url) {
            $('<img>', {src: url, alt: ''}).appendTo($preview);
        }
    }

    function activateNav(sectionId) {
        $('.iperq-settings-nav a').removeClass('is-active');
        $('.iperq-settings-nav a[href="#' + sectionId + '"]').addClass('is-active');
    }

    function initSectionNavigation() {
        var $links = $('.iperq-settings-nav a');
        var $sections = $('[data-settings-section]');

        $links.on('click', function (event) {
            var selector = $(this).attr('href');
            var $target = $(selector);
            if (!$target.length) {
                return;
            }

            event.preventDefault();
            activateNav($target.attr('id'));
            window.history.replaceState(null, '', selector);
            $target[0].scrollIntoView({behavior: 'smooth', block: 'start'});
        });

        if ('IntersectionObserver' in window && $sections.length) {
            var observer = new IntersectionObserver(function (entries) {
                var visible = entries.filter(function (entry) {
                    return entry.isIntersecting;
                }).sort(function (a, b) {
                    return a.boundingClientRect.top - b.boundingClientRect.top;
                });

                if (visible.length) {
                    activateNav(visible[0].target.id);
                }
            }, {rootMargin: '-80px 0px -65% 0px', threshold: 0});

            $sections.each(function () {
                observer.observe(this);
            });
        }
    }

    $(function () {
        $form = $('[data-header-settings-form]');
        $saveBar = $('[data-save-bar]');

        initSectionNavigation();

        $form.on('input change', 'input, textarea, select', function () {
            setDirtyState(true);
        });

        $form.on('submit', function () {
            isDirty = false;
            $saveBar.removeClass('is-dirty').addClass('is-saving');
            $saveBar.find('[data-save-state]').text('Saving changes…');
        });

        $('.iperq-header-logo-select').on('click', function (event) {
            event.preventDefault();

            var frame = wp.media({
                title: 'Choose header logo',
                button: {text: 'Use logo'},
                library: {type: 'image'},
                multiple: false
            });

            frame.on('select', function () {
                var attachment = frame.state().get('selection').first().toJSON();
                $('[data-media-id]').val(attachment.id || 0);
                updateLogoPreview(attachment.url || '');
                setDirtyState(true);
            });

            frame.open();
        });

        $('.iperq-header-logo-remove').on('click', function (event) {
            event.preventDefault();
            var defaultLogo = $('[data-media-field]').attr('data-default-logo') || '';
            $('[data-media-id]').val(0);
            updateLogoPreview(defaultLogo);
            setDirtyState(true);
        });

        $(window).on('beforeunload', function () {
            if (isDirty) {
                return 'You have unsaved header changes.';
            }
        });
    });
})(jQuery);
