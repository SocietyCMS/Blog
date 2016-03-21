/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	__webpack_require__(1);

	__webpack_require__(2);

	__webpack_require__(3);

/***/ },
/* 1 */
/***/ function(module, exports) {

	'use strict';

	var dragAndDropModule = new fineUploader.DragAndDrop({
	    dropZoneElements: [document.getElementById('blogImages')],
	    classes: {
	        dropActive: "cssClassToAddToDropZoneOnEnter"
	    },
	    callbacks: {
	        processingDroppedFilesComplete: function processingDroppedFilesComplete(files, dropTarget) {
	            fineUploaderBasicInstanceImages.addFiles(files);
	        }
	    }
	});

	var fineUploaderBasicInstanceImages = new fineUploader.FineUploaderBasic({
	    button: document.getElementById('uploadImageButton'),
	    request: {
	        endpoint: Vue.url(societycms.api.blog.article.image.store, { slug: societycms.blog.article.slug }),
	        inputName: 'image',
	        customHeaders: {
	            "Authorization": "Bearer " + societycms.jwtoken
	        }
	    },
	    callbacks: {
	        onComplete: function onComplete(id, name, responseJSON) {
	            VueInstanceImage.addPhoto(responseJSON);
	        },
	        onUpload: function onUpload() {
	            $('#uploadImageButton').hide();
	            $('#uploadImageProgrssbar').show();
	        },
	        onTotalProgress: function onTotalProgress(totalUploadedBytes, totalBytes) {
	            $('#uploadImageProgrssbar').progress({
	                percent: Math.ceil(totalUploadedBytes / totalBytes * 100)
	            });
	        },
	        onAllComplete: function onAllComplete(succeeded, failed) {
	            $('#uploadImageButton').show();
	            $('#uploadImageProgrssbar').hide();
	        }
	    }
	});

	var VueInstanceImage = new Vue({
	    el: '#blogImagesSegment',
	    data: {
	        album: null,
	        detailPhoto: null,
	        loaded: false,
	        meta: null
	    },
	    ready: function ready() {

	        this.$http.get({ slug: societycms.blog.article.slug }, societycms.api.blog.article.image.index, function (data, status, request) {

	            this.$set('album', data.data);
	            this.$set('meta', data.meta);
	            this.$set('loaded', true);
	        }).error(function (data, status, request) {});
	    },
	    methods: {
	        detail: function detail(photo) {
	            this.detailPhoto = photo;
	            $('#deleteAlbumButton').show();
	        },
	        addPhoto: function addPhoto(photo) {
	            this.album.push(photo.data);
	        },
	        deletePhoto: function deletePhoto() {

	            var resource = this.$resource(societycms.api.blog.article.image.destroy);

	            resource.delete({ slug: societycms.blog.article.slug, id: this.detailPhoto.id }, this.detailPhoto, function (data, status, request) {
	                this.album.pop(this.detailPhoto);
	            }).error(function (data, status, request) {});
	        }
	    }

	});

	$('#deleteAlbumButton').click(function () {
	    VueInstanceImage.deletePhoto();
	});

/***/ },
/* 2 */
/***/ function(module, exports) {

	'use strict';

	var dragAndDropModule = new fineUploader.DragAndDrop({
	    dropZoneElements: [document.getElementById('blogFiles')],
	    classes: {
	        dropActive: "cssClassToAddToDropZoneOnEnter"
	    },
	    callbacks: {
	        processingDroppedFilesComplete: function processingDroppedFilesComplete(files, dropTarget) {
	            fineUploaderBasicInstanceFiles.addFiles(files);
	        }
	    }
	});

	var fineUploaderBasicInstanceFiles = new fineUploader.FineUploaderBasic({
	    button: document.getElementById('uploadFileButton'),
	    request: {
	        endpoint: Vue.url(societycms.api.blog.article.file.store, { slug: societycms.blog.article.slug }),
	        inputName: 'file',
	        customHeaders: {
	            "Authorization": "Bearer " + societycms.jwtoken
	        }
	    },
	    callbacks: {
	        onComplete: function onComplete(id, name, responseJSON) {
	            VueInstanceFile.addFile(responseJSON);
	        },
	        onUpload: function onUpload() {
	            $('#uploadFileButton').hide();
	            $('#uploadFileProgrssbar').show();
	        },
	        onTotalProgress: function onTotalProgress(totalUploadedBytes, totalBytes) {
	            $('#uploadFileProgrssbar').progress({
	                percent: Math.ceil(totalUploadedBytes / totalBytes * 100)
	            });
	        },
	        onAllComplete: function onAllComplete(succeeded, failed) {
	            $('#uploadFileButton').show();
	            $('#uploadFileProgrssbar').hide();
	        }
	    }
	});

	var VueInstanceFile = new Vue({
	    el: '#uploadFilesSection',
	    data: {
	        files: null,
	        meta: null,
	        detailFile: null,
	        loaded: false

	    },
	    ready: function ready() {

	        this.$http.get({ slug: societycms.blog.article.slug }, societycms.api.blog.article.file.index, function (data, status, request) {

	            this.$set('files', data.data);
	            this.$set('meta', data.meta);
	            this.$set('loaded', true);
	        }).error(function (data, status, request) {});
	    },
	    methods: {
	        fileClass: function fileClass(mime) {

	            if (semanticFileTypeClassMap[mime]) {
	                return semanticFileTypeClassMap[mime];
	            }
	            return "file outline";
	        },
	        humanReadableFilesize: function humanReadableFilesize(size) {
	            return filesize(size, { round: 0 });
	        },
	        detail: function detail(file) {
	            this.detailFile = file;
	            $('#deleteFileButton').show();
	        },
	        addFile: function addFile(file) {
	            this.files.push(file.data);
	        },
	        deleteFile: function deleteFile(file) {

	            var resource = this.$resource(societycms.api.blog.article.file.destroy);

	            resource.delete({ slug: societycms.blog.article.slug, id: file.id }, file, function (data, status, request) {
	                this.files.$remove(file);
	            }).error(function (data, status, request) {});
	        }
	    }

	});

	$('#uploadFileProgrssbar').hide();
	$('#deleteAlbumButton').click(function () {
	    VueInstanceFile.deleteFile();
	});

/***/ },
/* 3 */
/***/ function(module, exports) {

	'use strict';

	$('.editable').mediumInsert({
	    editor: editor,
	    addons: {
	        images: {
	            label: '<i class="camera retro icon"></i>',
	            deleteScript: Vue.url(societycms.api.blog.article.image.delete, { slug: societycms.blog.article.slug, token: societycms.jwtoken }),
	            deleteMethod: 'DELETE',
	            preview: false,
	            captions: true,
	            captionPlaceholder: 'Type caption for image (optional)',
	            autoGrid: 3,
	            fileUploadOptions: {
	                url: Vue.url(societycms.api.blog.article.image.upload, { slug: societycms.blog.article.slug }),
	                acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
	                beforeSend: function beforeSend(xhr) {
	                    xhr.setRequestHeader("Authorization", "Bearer " + societycms.jwtoken);
	                }
	            },
	            styles: { // (object) Available image styles configuration
	                wide: { // (object) Image style configuration. Key is used as a class name added to an image, when the style is selected (.medium-insert-images-wide)
	                    label: '<span class="fa fa-align-justify"></span>', // (string) A label for a style
	                    added: function added($el) {}, // (function) Callback function called after the style was selected. A parameter $el is a current active paragraph (.medium-insert-active)
	                    removed: function removed($el) {} // (function) Callback function called after a different style was selected and this one was removed. A parameter $el is a current active paragraph (.medium-insert-active)
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
	                    clicked: function clicked($el) {
	                        // (function) Callback function called when an action is selected
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
	            uploadCompleted: function uploadCompleted($el, data) {} // (function) Callback function called when upload is completed
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
	                    added: function added($el) {}, // (function) Callback function called after the style was selected. A parameter $el is a current active paragraph (.medium-insert-active)
	                    removed: function removed($el) {} // (function) Callback function called after a different style was selected and this one was removed. A parameter $el is a current active paragraph (.medium-insert-active)
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
	                    clicked: function clicked($el) {
	                        // (function) Callback function called when an action is selected
	                        var $event = $.Event('keydown');

	                        $event.which = 8;
	                        $(document).trigger($event);
	                    }
	                }
	            }
	        }
	    }
	});

/***/ }
/******/ ]);