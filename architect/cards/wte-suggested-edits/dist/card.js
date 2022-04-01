/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/Components/Card.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/Components/Card.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    data: {
      type: Object,
      required: true
    },
    labels: {
      type: Array,
      required: false,
      "default": function _default() {
        return [];
      }
    }
  },
  data: function data() {
    return {
      loading: true,
      details: {},
      expanded: true
    };
  },
  computed: {
    wrapperClasses: function wrapperClasses() {
      var classes = ['flex', 'flex-col', 'space-y-2', '-m-4', 'p-4'];

      if (this.details.status === 'Accepted') {
        classes.push('bg-green-200', 'bg-opacity-75');
      }

      if (this.details.status === 'Rejected') {
        classes.push('bg-red-200', 'bg-opacity-75');
      }

      return classes;
    },
    processCurrentValue: function processCurrentValue() {
      var rtr;

      switch (this.details.field) {
        case 'opening_times':
          if (!this.details.currentValue) {
            return 'None set';
          } // eslint-disable-next-line no-case-declarations


          var openingTimes = JSON.parse(this.details.currentValue); // eslint-disable-next-line no-case-declarations

          rtr = '<ul class="flex flex-col space-y-1">';
          openingTimes.forEach(function (openingTime) {
            rtr += '<li class="flex space-x-2 items-center">';
            rtr += "<span class=\"font-semibold\">".concat(openingTime.label, "</span>");

            if (openingTime.closed) {
              rtr += '<span>Closed</span>';
            } else {
              delete openingTime.start[2];
              delete openingTime.end[2];

              if (openingTime.start[0] < 10) {
                openingTime.start[0] = "0".concat(openingTime.start[0]);
              }

              if (openingTime.start[1] === 0) {
                openingTime.start[1] = '00';
              }

              if (openingTime.end[0] < 10) {
                openingTime.end[0] = "0".concat(openingTime.end[0]);
              }

              if (openingTime.end[1] === 0) {
                openingTime.end[1] = '00';
              }

              rtr += "<span>".concat(openingTime.start.join(':'), "</span>");
              rtr += '<span>-</span>';
              rtr += "<span>".concat(openingTime.end.join(':'), "</span>");
            }

            rtr += '</li>';
          });
          rtr += '</ul>';
          break;

        case 'features':
          // eslint-disable-next-line no-case-declarations
          var features = JSON.parse(this.details.currentValue); // eslint-disable-next-line no-case-declarations

          rtr = '<ul class="flex flex-col space-y-1">';
          Object.keys(features).forEach(function (feature) {
            rtr += '<li class="flex space-x-2 items-center">';
            rtr += "<span class=\"font-semibold\">".concat(feature, "</span>");
            rtr += '<span>-</span>';
            rtr += "<span class=\"".concat(features[feature] ? 'text-green-500' : 'text-red-500', "\">").concat(features[feature] ? 'Yes' : 'No', "</span>");
            rtr += '</li>';
          });
          rtr += '</ul>';
          break;

        default:
          return this.details.currentValue;
      }

      return rtr;
    },
    processedRecommendedValue: function processedRecommendedValue() {
      var rtr;

      switch (this.details.field) {
        case 'opening_times':
          // eslint-disable-next-line no-case-declarations
          var openingTimes = JSON.parse(this.details.recommendedValue); // eslint-disable-next-line no-case-declarations

          rtr = '<ul class="flex flex-col space-y-1">';
          openingTimes.forEach(function (openingTime) {
            rtr += '<li class="flex space-x-2 items-center">';
            rtr += "<span class=\"font-semibold\">".concat(openingTime.label, "</span>");

            if (openingTime.closed) {
              rtr += '<span>Closed</span>';
            } else {
              if (openingTime.start[0] < 10) {
                openingTime.start[0] = "0".concat(openingTime.start[0]);
              }

              if (openingTime.start[1] === 0) {
                openingTime.start[1] = '00';
              }

              if (openingTime.end[0] < 10) {
                openingTime.end[0] = "0".concat(openingTime.end[0]);
              }

              if (openingTime.end[1] === 0) {
                openingTime.end[1] = '00';
              }

              rtr += "<span>".concat(openingTime.start.join(':'), "</span>");
              rtr += '<span>-</span>';
              rtr += "<span>".concat(openingTime.end.join(':'), "</span>");
            }

            rtr += '</li>';
          });
          rtr += '</ul>';
          break;

        case 'features':
          // eslint-disable-next-line no-case-declarations
          var features = JSON.parse(this.details.recommendedValue); // eslint-disable-next-line no-case-declarations

          rtr = '<ul class="flex flex-col space-y-1">';
          features.forEach(function (feature) {
            rtr += '<li class="flex space-x-2 items-center">';
            rtr += "<span class=\"font-semibold\">".concat(feature.label, "</span>");
            rtr += '<span>-</span>';
            rtr += "<span class=\"".concat(feature.selected ? 'text-green-500' : 'text-red-500', "\">").concat(feature.selected ? 'Yes' : 'No', "</span>");
            rtr += '</li>';
          });
          rtr += '</ul>';
          break;

        default:
          return this.details.recommendedValue;
      }

      return rtr;
    }
  },
  mounted: function mounted() {
    var _this = this;

    Architect.request().get("/external/coeliac-wte-suggested-edits/get/".concat(this.data.id)).then(function (response) {
      _this.details = response.data;
      _this.loading = false;
      _this.expanded = _this.details.status === 'New';
    });
  },
  methods: {
    expand: function expand() {
      if (this.details.status === 'New') {
        return;
      }

      this.expanded = !this.expanded;
    },
    accept: function accept() {
      var _this2 = this;

      Architect.request().put("/external/coeliac-wte-suggested-edits/accept/".concat(this.data.id)).then(function () {
        _this2.details.accepted = true;
        _this2.details.status = 'Accepted';
        _this2.expanded = false;
      });
    },
    reject: function reject() {
      var _this3 = this;

      Architect.request()["delete"]("/external/coeliac-wte-suggested-edits/reject/".concat(this.data.id)).then(function () {
        _this3.details.rejected = true;
        _this3.details.status = 'Rejected';
        _this3.expanded = false;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/Components/Card.vue?vue&type=template&id=52f81d61&":
/*!****************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/Components/Card.vue?vue&type=template&id=52f81d61& ***!
  \****************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return !_vm.loading
    ? _c("div", { class: _vm.wrapperClasses }, [
        _c(
          "div",
          {
            staticClass: "flex justify-between items-center",
            class: { "cursor-pointer": _vm.details.status !== "New" },
          },
          [
            _c(
              "div",
              {
                staticClass: "text-2xl",
                on: {
                  click: function ($event) {
                    return _vm.expand()
                  },
                },
              },
              [_vm._v("\n      " + _vm._s(_vm.details.location) + "\n    ")]
            ),
            _vm._v(" "),
            _c("div", [_vm._v(_vm._s(_vm.details.status))]),
          ]
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            directives: [
              {
                name: "show",
                rawName: "v-show",
                value: _vm.expanded,
                expression: "expanded",
              },
            ],
            staticClass: "flex flex-col space-y-2 w-full",
          },
          [
            _c("div", { staticClass: "flex flex-col w-full" }, [
              _c("div", { staticClass: "text-lg mb-2" }, [
                _c("strong", [_vm._v("Field")]),
                _vm._v(
                  "\n        " + _vm._s(_vm.details.field_label) + "\n      "
                ),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "flex space-x-2 w-full" }, [
                _c("div", { staticClass: "w-1/2 flex flex-col" }, [
                  _c("strong", [_vm._v("Current Value")]),
                  _vm._v(" "),
                  _c("div", {
                    domProps: { innerHTML: _vm._s(_vm.processCurrentValue) },
                  }),
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "w-1/2 flex flex-col" }, [
                  _c("strong", [_vm._v("Recommended Value")]),
                  _vm._v(" "),
                  _c("div", {
                    domProps: {
                      innerHTML: _vm._s(_vm.processedRecommendedValue),
                    },
                  }),
                ]),
              ]),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "flex space-x-2" }, [
              _c(
                "a",
                {
                  staticClass:
                    "block rounded bg-blue-500 py-2 px-4 font-semibold hover:bg-opacity-75 cursor-pointer",
                  attrs: {
                    href:
                      "/cs-adm/blueprints/wheretoeat/" + _vm.details.eatery_id,
                    target: "_blank",
                  },
                },
                [_vm._v("\n        Open Eatery\n      ")]
              ),
              _vm._v(" "),
              _vm.details.status === "New"
                ? _c(
                    "a",
                    {
                      staticClass:
                        "block rounded bg-green-500 py-2 px-4 font-semibold hover:bg-opacity-75 cursor-pointer",
                      on: {
                        click: function ($event) {
                          $event.preventDefault()
                          return _vm.accept()
                        },
                      },
                    },
                    [_vm._v("\n        Mark as accepted\n      ")]
                  )
                : _vm._e(),
              _vm._v(" "),
              _vm.details.status === "New"
                ? _c(
                    "a",
                    {
                      staticClass:
                        "block rounded bg-red-500 py-2 px-4 font-semibold hover:bg-opacity-75 cursor-pointer",
                      on: {
                        click: function ($event) {
                          $event.preventDefault()
                          return _vm.reject()
                        },
                      },
                    },
                    [_vm._v("\n        Reject / Ignore\n      ")]
                  )
                : _vm._e(),
            ]),
          ]
        ),
        _vm._v(" "),
        _c("div", { staticClass: "text-xs" }, [
          _c("span", [
            _vm._v(
              "\n      Created: " +
                _vm._s(_vm.details.created_at) +
                ",\n      last updated: " +
                _vm._s(_vm.details.updated_at) +
                "\n    "
            ),
          ]),
        ]),
      ])
    : _vm._e()
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js":
/*!********************************************************************!*\
  !*** ./node_modules/vue-loader/lib/runtime/componentNormalizer.js ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return normalizeComponent; });
/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

function normalizeComponent (
  scriptExports,
  render,
  staticRenderFns,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier, /* server only */
  shadowMode /* vue-cli only */
) {
  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (render) {
    options.render = render
    options.staticRenderFns = staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = 'data-v-' + scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = shadowMode
      ? function () {
        injectStyles.call(
          this,
          (options.functional ? this.parent : this).$root.$options.shadowRoot
        )
      }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functional component in vue file
      var originalRender = options.render
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return originalRender(h, context)
      }
    } else {
      // inject component registration as beforeCreate hook
      var existing = options.beforeCreate
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    }
  }

  return {
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ "./resources/Components/Card.vue":
/*!***************************************!*\
  !*** ./resources/Components/Card.vue ***!
  \***************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Card_vue_vue_type_template_id_52f81d61___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Card.vue?vue&type=template&id=52f81d61& */ "./resources/Components/Card.vue?vue&type=template&id=52f81d61&");
/* harmony import */ var _Card_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Card.vue?vue&type=script&lang=js& */ "./resources/Components/Card.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Card_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Card_vue_vue_type_template_id_52f81d61___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Card_vue_vue_type_template_id_52f81d61___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/Components/Card.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/Components/Card.vue?vue&type=script&lang=js&":
/*!****************************************************************!*\
  !*** ./resources/Components/Card.vue?vue&type=script&lang=js& ***!
  \****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Card_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../node_modules/babel-loader/lib??ref--4-0!../../node_modules/vue-loader/lib??vue-loader-options!./Card.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/Components/Card.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Card_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/Components/Card.vue?vue&type=template&id=52f81d61&":
/*!**********************************************************************!*\
  !*** ./resources/Components/Card.vue?vue&type=template&id=52f81d61& ***!
  \**********************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Card_vue_vue_type_template_id_52f81d61___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../node_modules/vue-loader/lib??vue-loader-options!./Card.vue?vue&type=template&id=52f81d61& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/Components/Card.vue?vue&type=template&id=52f81d61&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Card_vue_vue_type_template_id_52f81d61___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Card_vue_vue_type_template_id_52f81d61___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/card.js":
/*!***************************!*\
  !*** ./resources/card.js ***!
  \***************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Components_Card__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Components/Card */ "./resources/Components/Card.vue");

Architect.onBoot(function (Vue) {
  Vue.component('wte-suggested-edits-card', _Components_Card__WEBPACK_IMPORTED_MODULE_0__["default"]);
});

/***/ }),

/***/ "./resources/card.scss":
/*!*****************************!*\
  !*** ./resources/card.scss ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*******************************************************!*\
  !*** multi ./resources/card.js ./resources/card.scss ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/jamiepeters/code/coeliac/architect/cards/wte-suggested-edits/resources/card.js */"./resources/card.js");
module.exports = __webpack_require__(/*! /Users/jamiepeters/code/coeliac/architect/cards/wte-suggested-edits/resources/card.scss */"./resources/card.scss");


/***/ })

/******/ });