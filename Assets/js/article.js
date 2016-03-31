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
	    dropZoneElements: [document.getElementById('blogCovers')],
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
	        endpoint: Vue.url(societycms.api.blog.article.cover.store, { slug: societycms.blog.article.slug }),
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
	        cover: null,
	        loaded: false,
	        meta: null
	    },
	    ready: function ready() {

	        var resource = this.$resource(societycms.api.blog.article.cover.index);

	        resource.get({ slug: societycms.blog.article.slug }, function (data, status, request) {
	            this.$set('cover', data.data);
	            this.$set('meta', data.meta);
	            this.$set('loaded', true);
	        }).error(function (data, status, request) {});
	    },
	    methods: {
	        addPhoto: function addPhoto(photo) {
	            this.cover = photo.data;
	        },
	        deletePhoto: function deletePhoto() {
	            var resource = this.$resource(societycms.api.blog.article.cover.destroy);
	            resource.delete({ slug: societycms.blog.article.slug }, function (data, status, request) {
	                this.cover = null;
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

	        var resource = this.$resource(societycms.api.blog.article.file.index);

	        resource.get({ slug: societycms.blog.article.slug }, function (data, status, request) {
	            this.$set('files', data.data);
	            this.$set('meta', data.meta);
	            this.$set('loaded', true);
	        }).error(function (data, status, request) {});
	    },
	    methods: {
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
	                    clicked: function clicked($el) {
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
	            uploadCompleted: function uploadCompleted($el, data) {}
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
	                    added: function added($el) {},
	                    removed: function removed($el) {}
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
	                    clicked: function clicked($el) {
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