$('.editable').mediumInsert({
    editor: editor,
    addons: { // (object) Addons configuration
        images: { // (object) Image addon configuration
            label: '<i class="camera retro icon"></i>', // (string) A label for an image addon
            deleteScript: 'delete.php', // (string) A relative path to a delete script
            deleteMethod: 'POST',
            fileDeleteOptions: {}, // (object) extra parameters send on the delete ajax request, see http://api.jquery.com/jquery.ajax/
            preview: true, // (boolean) Show an image before it is uploaded (only in browsers that support this feature)
            captions: true, // (boolean) Enable captions
            captionPlaceholder: 'Type caption for image (optional)', // (string) Caption placeholder
            autoGrid: 3, // (integer) Min number of images that automatically form a grid
            fileUploadOptions: { // (object) File upload configuration. See https://github.com/blueimp/jQuery-File-Upload/wiki/Options
                url: Vue.url(societycms.api.blog.article.upload, {slug: societycms.blog.article.slug}),
                acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                formData: {example: 'test'},
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Bearer " + societycms.jwtoken);
                }
            },
            styles: { // (object) Available image styles configuration
                wide: { // (object) Image style configuration. Key is used as a class name added to an image, when the style is selected (.medium-insert-images-wide)
                    label: '<span class="fa fa-align-justify"></span>', // (string) A label for a style
                    added: function ($el) {
                    }, // (function) Callback function called after the style was selected. A parameter $el is a current active paragraph (.medium-insert-active)
                    removed: function ($el) {
                    } // (function) Callback function called after a different style was selected and this one was removed. A parameter $el is a current active paragraph (.medium-insert-active)
                },
                left: {
                    label: '<span class="fa fa-align-left"></span>'
                },
                right: {
                    label: '<span class="fa fa-align-right"></span>'
                },
                grid: {
                    label: '<span class="fa fa-th"></span>'
                }
            },
            actions: { // (object) Actions for an optional second toolbar
                remove: { // (object) Remove action configuration
                    label: '<span class="fa fa-times"></span>', // (string) Label for an action
                    clicked: function ($el) { // (function) Callback function called when an action is selected
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
            } // (function) Callback function called when upload is completed
        },
        embeds: { // (object) Embeds addon configuration
            label: '<span class="fa fa-youtube-play"></span>', // (string) A label for an embeds addon
            placeholder: 'Paste a YouTube, Vimeo, Facebook, Twitter or Instagram link and press Enter', // (string) Placeholder displayed when entering URL to embed
            captions: true, // (boolean) Enable captions
            captionPlaceholder: 'Type caption (optional)', // (string) Caption placeholder
            oembedProxy: 'http://medium.iframe.ly/api/oembed?iframe=1', // (string/null) URL to oEmbed proxy endpoint, such as Iframely, Embedly or your own. You are welcome to use "http://medium.iframe.ly/api/oembed?iframe=1" for your dev and testing needs, courtesy of Iframely. *Null* will make the plugin use pre-defined set of embed rules without making server calls.
            styles: { // (object) Available embeds styles configuration
                wide: { // (object) Embed style configuration. Key is used as a class name added to an embed, when the style is selected (.medium-insert-embeds-wide)
                    label: '<span class="fa fa-align-justify"></span>', // (string) A label for a style
                    added: function ($el) {
                    }, // (function) Callback function called after the style was selected. A parameter $el is a current active paragraph (.medium-insert-active)
                    removed: function ($el) {
                    } // (function) Callback function called after a different style was selected and this one was removed. A parameter $el is a current active paragraph (.medium-insert-active)
                },
                left: {
                    label: '<span class="fa fa-align-left"></span>'
                },
                right: {
                    label: '<span class="fa fa-align-right"></span>'
                }
            },
            actions: { // (object) Actions for an optional second toolbar
                remove: { // (object) Remove action configuration
                    label: '<span class="fa fa-times"></span>', // (string) Label for an action
                    clicked: function ($el) { // (function) Callback function called when an action is selected
                        var $event = $.Event('keydown');

                        $event.which = 8;
                        $(document).trigger($event);
                    }
                }
            }
        }
    }
});
