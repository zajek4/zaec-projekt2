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

    function updateRepeaterUi($repeater) {
        var $rows = $repeater.find('[data-repeater-list] > [data-repeater-row]');
        var count = $rows.length;

        $rows.each(function (index) {
            var $row = $(this);
            $row.find('[data-row-number]').first().text(index + 1);

            $row.find('[data-name-template]').each(function () {
                var template = $(this).attr('data-name-template');
                if (template) {
                    $(this).attr('name', template.replace(/__INDEX__/g, index));
                }
            });
        });

        $repeater.find('[data-repeater-count]').text(count);
        $repeater.find('[data-repeater-empty]').prop('hidden', count > 0);
    }

    function initSortable($repeater) {
        var $list = $repeater.find('[data-repeater-list]').first();
        if (!$list.length || typeof $list.sortable !== 'function') {
            return;
        }

        $list.sortable({
            items: '> [data-repeater-row]',
            handle: '.iperq-repeater__handle',
            axis: 'y',
            tolerance: 'pointer',
            placeholder: 'iperq-repeater-row iperq-repeater-row--placeholder',
            forcePlaceholderSize: true,
            start: function (event, ui) {
                ui.placeholder.height(ui.item.outerHeight());
            },
            update: function () {
                updateRepeaterUi($repeater);
                setDirtyState(true);
            }
        });
    }

    function setMediaPreview($field, url) {
        var $preview = $field.find('[data-media-preview]').first();
        if (!$preview.length) {
            return;
        }

        $preview.empty();
        if (url) {
            $('<img>', {src: url, alt: ''}).appendTo($preview);
        } else {
            $('<span>').text($preview.hasClass('iperq-media-preview--icon') ? 'Icon' : 'No image selected').appendTo($preview);
        }
    }

    function activateNavForSection(sectionId) {
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
            activateNavForSection($target.attr('id'));
            window.history.replaceState(null, '', selector);
            $target[0].scrollIntoView({behavior: 'smooth', block: 'start'});
        });

        if ('IntersectionObserver' in window && $sections.length) {
            var observer = new IntersectionObserver(function (entries) {
                var visible = entries
                    .filter(function (entry) { return entry.isIntersecting; })
                    .sort(function (a, b) { return a.boundingClientRect.top - b.boundingClientRect.top; });

                if (visible.length) {
                    activateNavForSection(visible[0].target.id);
                }
            }, {
                rootMargin: '-80px 0px -65% 0px',
                threshold: 0
            });

            $sections.each(function () {
                observer.observe(this);
            });
        }
    }

    $(function () {
        $form = $('[data-footer-settings-form]');
        $saveBar = $('[data-save-bar]');

        $('[data-repeater]').each(function () {
            var $repeater = $(this);
            updateRepeaterUi($repeater);
            initSortable($repeater);
        });

        initSectionNavigation();

        $form.on('input change', 'input, textarea, select', function () {
            setDirtyState(true);
        });

        $form.on('submit', function () {
            isDirty = false;
            $saveBar.removeClass('is-dirty').addClass('is-saving');
            $saveBar.find('[data-save-state]').text('Saving changes…');
        });

        $(document).on('click', '.iperq-repeater-add', function () {
            var $repeater = $(this).closest('[data-repeater]');
            var template = $repeater.find('template[data-repeater-template]').first().html();
            if (!template) {
                return;
            }

            var $row = $(template.trim());
            $repeater.find('[data-repeater-list]').first().append($row);
            updateRepeaterUi($repeater);
            setDirtyState(true);

            $row.hide().fadeIn(140);
            $row.find('input[type="text"]').first().trigger('focus');
        });

        $(document).on('click', '.iperq-repeater-remove', function () {
            var $repeater = $(this).closest('[data-repeater]');
            var $row = $(this).closest('[data-repeater-row]');

            $row.fadeOut(120, function () {
                $row.remove();
                updateRepeaterUi($repeater);
                setDirtyState(true);
            });
        });

        $(document).on('click', '.iperq-media-select', function (event) {
            event.preventDefault();

            var $field = $(this).closest('[data-media-field]');
            var frame = wp.media({
                title: 'Choose image',
                button: {text: 'Use image'},
                library: {type: 'image'},
                multiple: false
            });

            frame.on('select', function () {
                var attachment = frame.state().get('selection').first().toJSON();
                $field.find('[data-media-id]').val(attachment.id || 0);
                $field.find('[data-media-url]').val(attachment.url || '');
                setMediaPreview($field, attachment.url || '');
                setDirtyState(true);
            });

            frame.open();
        });

        $(document).on('click', '.iperq-media-remove', function (event) {
            event.preventDefault();
            var $field = $(this).closest('[data-media-field]');
            $field.find('[data-media-id]').val(0);
            $field.find('[data-media-url]').val('');
            setMediaPreview($field, '');
            setDirtyState(true);
        });

        $(window).on('beforeunload', function () {
            if (isDirty) {
                return 'You have unsaved footer changes.';
            }
        });
    });
})(jQuery);
