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

	"use strict";

	var _createClass = (function () { function defineProperties(target, props) { for (var key in props) { var prop = props[key]; prop.configurable = true; if (prop.value) prop.writable = true; } Object.defineProperties(target, props); } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

	var _classCallCheck = function (instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } };

	$ = jQuery;

	var AdminPoll = (function () {
	  function AdminPoll(options) {
	    _classCallCheck(this, AdminPoll);

	    console.log("AdminPoll::constructor");

	    this.firebase = new Firebase("https://senti.firebaseio.com/");
	    // console.log(this.firebase);

	    this.$el = $(options.el);

	    var data = {
	      action: "get_firebase_path",
	      post_id: parseInt(this.$el.attr("id").replace("post-", ""))
	    };

	    $.post(ajaxurl, data, $.proxy(this.getRecord, this));
	  }

	  _createClass(AdminPoll, {
	    getRecord: {
	      value: function getRecord(path) {
	        this.firebase.child(path).on("value", $.proxy(this.render, this));
	      }
	    },
	    render: {
	      value: function render(snapshot) {
	        var data = snapshot.val();
	        if (data) {
	          this.$el.find(".column-entries").html(data.entries);
	        }
	      }
	    }
	  });

	  return AdminPoll;
	})();

	var modules = $("#the-list tr");
	modules.each(function (index, el) {
	  new AdminPoll({ el: el });
	});

/***/ }
/******/ ]);