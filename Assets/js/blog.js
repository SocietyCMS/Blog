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
/***/ function(module, exports) {

	'use strict';

	var VueInstance = new Vue({
	    el: '#societyAdmin',
	    data: {
	        newArticle: {
	            title: null
	        }
	    },
	    methods: {
	        newArticleModal: function newArticleModal() {
	            $('#newArticleModal').modal('setting', 'transition', 'fade up').modal('show');
	        },
	        deleteArticleModal: function deleteArticleModal(slug) {
	            console.log(slug);
	            $('#deleteArticleModal').modal('setting', 'transition', 'fade up').modal({
	                closable: false,
	                onApprove: function onApprove() {
	                    VueInstance.deleteArticle(slug);
	                }
	            }).modal('show');
	        },
	        createNewArticle: function createNewArticle() {
	            var resource = this.$resource(societycms.api.blog.article.store);

	            resource.save(this.newArticle, function (data, status, request) {
	                var backend;

	                if (data.data.links) {
	                    data.data.links.forEach(function (data) {
	                        if (data.rel == "backend") {
	                            backend = data.url;
	                        }
	                    });
	                }
	                window.location.replace(backend);
	            }).error(function (data, status, request) {
	                $('#newArticleModal').modal('close');
	                Toastr.error('Error');
	            });
	        },
	        deleteArticle: function deleteArticle(slug) {
	            var resource = this.$resource(societycms.api.blog.article.destroy);

	            resource.delete({ article: slug }, function (data, status, request) {
	                location.reload();
	            }).error(function (data, status, request) {});
	        }
	    }
	});

/***/ }
/******/ ]);