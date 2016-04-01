$('.editable').mediumInsert({
    editor: editor,
    addons: {
        images: {
            label: '<i class="camera retro icon"></i>',
            deleteScript: Vue.url(societycms.api.blog.article.image.delete, {slug: societycms.blog.article.slug, token: societycms.jwtoken}),
            deleteMethod: 'DELETE',
            preview: false,
            captions: true,
            captionPlaceholder: 'Type caption for image (optional)',
            autoGrid: 3,
            fileUploadOptions: {
                url: Vue.url(societycms.api.blog.article.image.upload, {slug: societycms.blog.article.slug}),
                acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Bearer " + societycms.jwtoken);
                }
            },
            styles: {
                wide: {
                    label: '<i class="align justify icon"></i>'
                },
                left: {
                    label: '<i class="align left icon"></i>'
                },
                right: {
                    label: '<i class="align right icon"></i>'
                },
                grid: {
                    label: '<i class="grid layout icon"></i>'
                }
            },
            actions: {
                remove: {
                    label: '<i class="remove icon"></i>',
                    clicked: function ($el) {
                        var $event = $.Event('keydown');

                        $event.which = 8;
                        $(document).trigger($event);
                    }
                }
            },
            messages: {
                acceptFileTypesError: 'This file is not in a supported format: ',
                maxFileSizeError: 'This file is too big: '
            },
            uploadCompleted: function ($el, data) {
            }
        },
        embeds: {
            label: '<i class="youtube play icon"></i>',
            placeholder: 'Paste a YouTube, Vimeo, Facebook, Twitter or Instagram link and press Enter',
            captions: true,
            captionPlaceholder: 'Type caption (optional)',
            oembedProxy: 'http://medium.iframe.ly/api/oembed?iframe=1',
            styles: {
                wide: {
                    label: '<i class="align justify icon"></i>',
                    added: function ($el) {
                    },
                    removed: function ($el) {
                    }
                },
                left: {
                    label: '<i class="align left icon"></i>'
                },
                right: {
                    label: '<i class="align right icon"></i>'
                }
            },
            actions: {
                remove: {
                    label: '<i class="remove icon"></i>',
                    clicked: function ($el) {
                        var $event = $.Event('keydown');

                        $event.which = 8;
                        $(document).trigger($event);
                    }
                }
            }
        }
    }
});
