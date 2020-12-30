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

/***/ "./node_modules/architect-js-helpers/dist/index.js":
/*!*********************************************************!*\
  !*** ./node_modules/architect-js-helpers/dist/index.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

(function webpackUniversalModuleDefinition(root, factory) {
	if(true)
		module.exports = factory();
	else {}
})(this, function() {
return /******/ (function(modules) { // webpackBootstrap
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
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = ({
    props: {
        name: String,
        value: String | Array | Object,
        metas: Array | Object,
        id: Number,
        listener: {
            type: String,
            default: 'prepare-form-data'
        },
        emitter: {
            type: String,
            default: 'form-field-change'
        }
    },

    mounted() {
        if (this.value !== undefined) {
            this.actualValue = this.value;
        }

        this.bootstrapListeners();

        this.debouncedEvents = window._.debounce(this.dispatchEvents, 500);
    },

    data: () => ({
        actualValue: '',
        emitterValue: null,
        setEmitterValue: true
    }),

    methods: {
        getFormData() {
            return {
                name: this.name,
                value: this.actualValue
            };
        },

        dispatchEvents() {
            if (this.emitterValue) {
                Architect.$emit(this.name + '-changed', this.emitterValue);
            }
        },

        bootstrapListeners() {
            Architect.$on(this.listener, () => {
                Architect.$emit(this.emitter, this.getFormData());
            });

            /**
             * listeners [
             *      changed: [
             *          column1
             *          column2
             *      ]
             *  ]
             */

            Object.keys(this.metas.listeners).forEach(event => {
                let column = this.metas.listeners[event];

                if (typeof column === 'string') {
                    Architect.$on(column + '-' + event, value => {
                        Architect.request().post('/listener', {
                            blueprint: this.$route.params.blueprint,
                            event: column + '-' + event,
                            column: this.name,
                            value: JSON.stringify(value)
                        }).then(response => {
                            this.actualValue = response.data;
                        }).catch(error => {
                            Architect.$emit(error.response.data.message);
                        });
                    });
                }
            });
        }
    },

    watch: {
        emitterValue: function (newValue) {
            if (newValue !== '') {
                this.debouncedEvents();
            }
        },
        actualValue: function (newValue) {
            if (this.setEmitterValue) {
                this.emitterValue = newValue;
            }
        }
    }
});

/***/ }),
/* 1 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__traits_IsAFormField__ = __webpack_require__(0);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "IsAFormField", function() { return __WEBPACK_IMPORTED_MODULE_0__traits_IsAFormField__["a"]; });




/***/ })
/******/ ]);
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/Components/PlanForm.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/Components/PlanForm.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var architect_js_helpers__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! architect-js-helpers */ "./node_modules/architect-js-helpers/dist/index.js");
/* harmony import */ var architect_js_helpers__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(architect_js_helpers__WEBPACK_IMPORTED_MODULE_0__);
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
  mixins: [architect_js_helpers__WEBPACK_IMPORTED_MODULE_0__["IsAFormField"]],
  data: function data() {
    return {
      items: [],
      showModal: false,
      addModal: {
        searchType: 'blogs',
        searchString: '',
        searchDescription: '',
        searchResults: [],
        selectedItem: null
      }
    };
  },
  mounted: function mounted() {
    var _this = this;

    Architect.$on('modal-close', function () {
      _this.showModal = false;
    });

    if (this.value) {
      this.items = this.value;
    }
  },
  methods: {
    getFormData: function getFormData() {
      return {
        name: this.name,
        value: JSON.stringify(this.items.map(function (item, index) {
          return {
            id: item.id,
            description: item.description,
            type: item.type,
            position: index + 1
          };
        }))
      };
    },
    moveItemUp: function moveItemUp(index) {
      this.items.splice(index - 1, 0, this.items.splice(index, 1)[0]);
    },
    moveItemDown: function moveItemDown(index) {
      this.items.splice(index + 1, 0, this.items.splice(index, 1)[0]);
    },
    deleteItem: function deleteItem(index) {
      this.items.splice(index, 1);
    },
    modalSearch: function modalSearch() {
      var _this2 = this;

      Architect.request().post('/external/collection-items/search', {
        type: this.addModal.searchType,
        term: this.addModal.searchString
      }).then(function (response) {
        _this2.addModal.searchResults = response.data.results;
      })["catch"](function () {
        Architect.error('No results found');
      });
    },
    selectItem: function selectItem(item) {
      this.addModal.selectedItem = item;
      this.addModal.searchDescription = item.description;
      this.addModal.searchResults = [];
    },
    addItem: function addItem() {
      this.addModal.selectedItem.description = this.addModal.searchDescription;
      this.items.push(this.addModal.selectedItem);
      this.showModal = false;
      this.addModal.searchType = 'blogs';
      this.addModal.searchString = '';
      this.addModal.searchDescription = '';
      this.addModal.searchResults = [];
      this.addModal.selectedItem = null;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/Components/PlanList.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/Components/PlanList.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/Components/PlanForm.vue?vue&type=template&id=56d6e6de&":
/*!********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/Components/PlanForm.vue?vue&type=template&id=56d6e6de& ***!
  \********************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("div", { staticClass: "bg-blue-100 rounded-lg p-4" }, [
        _c("div", { staticClass: "text-right mb-4" }, [
          _c(
            "a",
            {
              staticClass:
                "bg-blue-700 py-2 px-4 text-lg leading-none font-semibold cursor-pointer slider-bg inline-block rounded text-white",
              on: {
                click: function($event) {
                  _vm.showModal = true
                }
              }
            },
            [_vm._v("\n                Add Item\n            ")]
          )
        ]),
        _vm._v(" "),
        _c(
          "table",
          { staticClass: "w-full leading-none" },
          [
            _vm._m(0),
            _vm._v(" "),
            _vm._l(_vm.items, function(item, index) {
              return _c(
                "tr",
                { staticClass: "border-b border-blue-300 bg-white" },
                [
                  _c(
                    "td",
                    {
                      staticClass: "p-2 border-r border-blue-200 text-blue-900",
                      staticStyle: { width: "50px" }
                    },
                    [
                      _vm.items.length > 1
                        ? [
                            index > 0
                              ? _c("font-awesome-icon", {
                                  staticClass: "cursor-pointer",
                                  attrs: { icon: ["fas", "caret-up"] },
                                  on: {
                                    click: function($event) {
                                      return _vm.moveItemUp(index)
                                    }
                                  }
                                })
                              : _vm._e(),
                            _vm._v(" "),
                            index > 0 && index < _vm.items.length - 1
                              ? _c("span", [_vm._v("/")])
                              : _vm._e(),
                            _vm._v(" "),
                            index < _vm.items.length - 1
                              ? _c("font-awesome-icon", {
                                  staticClass: "cursor-pointer",
                                  attrs: { icon: ["fas", "caret-down"] },
                                  on: {
                                    click: function($event) {
                                      return _vm.moveItemDown(index)
                                    }
                                  }
                                })
                              : _vm._e()
                          ]
                        : _vm._e()
                    ],
                    2
                  ),
                  _vm._v(" "),
                  _c("td", { staticClass: "p-2 border-r border-blue-200" }, [
                    _vm._v(
                      "\n                    " +
                        _vm._s(item.type) +
                        "\n                "
                    )
                  ]),
                  _vm._v(" "),
                  _c("td", { staticClass: "p-2 border-r border-blue-200" }, [
                    _vm._v(
                      "\n                    " +
                        _vm._s(item.title) +
                        "\n                "
                    )
                  ]),
                  _vm._v(" "),
                  _c(
                    "td",
                    {
                      staticClass: "text-center py-1",
                      staticStyle: { width: "65px" }
                    },
                    [
                      _c(
                        "a",
                        {
                          staticClass:
                            "bg-red-500 p-2 inline-block rounded text-sm leading-none font-semibold cursor-pointer slider-bg",
                          on: {
                            click: function($event) {
                              return _vm.deleteItem(index)
                            }
                          }
                        },
                        [
                          _vm._v(
                            "\n                        Delete\n                    "
                          )
                        ]
                      )
                    ]
                  )
                ]
              )
            })
          ],
          2
        ),
        _vm._v(" "),
        _c("div", { staticClass: "text-right mt-4" }, [
          _c(
            "a",
            {
              staticClass:
                "bg-blue-700 py-2 px-4 text-lg leading-none font-semibold cursor-pointer slider-bg inline-block rounded text-white",
              on: {
                click: function($event) {
                  _vm.showModal = true
                }
              }
            },
            [_vm._v("\n                Add Item\n            ")]
          )
        ])
      ]),
      _vm._v(" "),
      _vm.showModal
        ? _c(
            "portal",
            { attrs: { to: "modal" } },
            [
              _c("modal", { attrs: { title: "Add Item to Collection" } }, [
                _c(
                  "div",
                  {
                    staticClass:
                      "w-full flex flex-col justify-center items-center leading-none"
                  },
                  [
                    _c("div", { staticClass: "w-full py-3 flex-col" }, [
                      !_vm.addModal.selectedItem
                        ? _c("div", [
                            _c(
                              "div",
                              { staticClass: "flex w-full items-center mb-2" },
                              [
                                _c("p", { staticClass: "w-1/6" }, [
                                  _vm._v(
                                    "\n                                Item Area\n                            "
                                  )
                                ]),
                                _vm._v(" "),
                                _c(
                                  "select",
                                  {
                                    directives: [
                                      {
                                        name: "model",
                                        rawName: "v-model",
                                        value: _vm.addModal.searchType,
                                        expression: "addModal.searchType"
                                      }
                                    ],
                                    staticClass:
                                      "form-control form-control-input w-full flex-1",
                                    on: {
                                      change: function($event) {
                                        var $$selectedVal = Array.prototype.filter
                                          .call($event.target.options, function(
                                            o
                                          ) {
                                            return o.selected
                                          })
                                          .map(function(o) {
                                            var val =
                                              "_value" in o ? o._value : o.value
                                            return val
                                          })
                                        _vm.$set(
                                          _vm.addModal,
                                          "searchType",
                                          $event.target.multiple
                                            ? $$selectedVal
                                            : $$selectedVal[0]
                                        )
                                      }
                                    }
                                  },
                                  [
                                    _c(
                                      "option",
                                      { attrs: { value: "blogs" } },
                                      [_vm._v("Blogs")]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "option",
                                      { attrs: { value: "recipes" } },
                                      [_vm._v("Recipes")]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "option",
                                      { attrs: { value: "reviews" } },
                                      [_vm._v("Reviews")]
                                    ),
                                    _vm._v(" "),
                                    _c("option", { attrs: { value: "wte" } }, [
                                      _vm._v("Where to Eat")
                                    ]),
                                    _vm._v(" "),
                                    _c("option", { attrs: { value: "shop" } }, [
                                      _vm._v("Shop Products")
                                    ])
                                  ]
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "div",
                              { staticClass: "flex w-full items-center" },
                              [
                                _c("p", { staticClass: "w-1/6" }, [
                                  _vm._v(
                                    "\n                                Search For...\n                            "
                                  )
                                ]),
                                _vm._v(" "),
                                _c("div", { staticClass: "relative flex-1" }, [
                                  _c("input", {
                                    directives: [
                                      {
                                        name: "model",
                                        rawName: "v-model",
                                        value: _vm.addModal.searchString,
                                        expression: "addModal.searchString"
                                      }
                                    ],
                                    staticClass:
                                      "form-control form-control-input w-full",
                                    class: _vm.addModal.searchResults.length
                                      ? "rounded-b-none"
                                      : "",
                                    attrs: { type: "text" },
                                    domProps: {
                                      value: _vm.addModal.searchString
                                    },
                                    on: {
                                      keyup: function($event) {
                                        return _vm.modalSearch()
                                      },
                                      input: function($event) {
                                        if ($event.target.composing) {
                                          return
                                        }
                                        _vm.$set(
                                          _vm.addModal,
                                          "searchString",
                                          $event.target.value
                                        )
                                      }
                                    }
                                  }),
                                  _vm._v(" "),
                                  _vm.addModal.searchResults.length
                                    ? _c(
                                        "div",
                                        {
                                          staticClass:
                                            "rounded-b-lg bg-white border border-black overflow-hidden z-50 w-full overflow-y-scroll"
                                        },
                                        [
                                          _c(
                                            "ul",
                                            {
                                              staticStyle: {
                                                "max-height": "170px"
                                              }
                                            },
                                            _vm._l(
                                              _vm.addModal.searchResults,
                                              function(result) {
                                                return _c(
                                                  "li",
                                                  {
                                                    staticClass:
                                                      "p-2 border-b border-black bg-blue-100 hover:bg-white transition-bg w-full cursor-pointer",
                                                    on: {
                                                      click: function($event) {
                                                        return _vm.selectItem(
                                                          result
                                                        )
                                                      }
                                                    }
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                            " +
                                                        _vm._s(result.title) +
                                                        "\n                                        "
                                                    )
                                                  ]
                                                )
                                              }
                                            ),
                                            0
                                          )
                                        ]
                                      )
                                    : _vm._e()
                                ])
                              ]
                            )
                          ])
                        : _c("div", [
                            _c("div", [
                              _c("p", { staticClass: "font-semibold" }, [
                                _vm._v(
                                  "\n                                " +
                                    _vm._s(_vm.addModal.selectedItem.title) +
                                    "\n                            "
                                )
                              ])
                            ]),
                            _vm._v(" "),
                            _c(
                              "div",
                              { staticClass: "flex w-full items-center mt-2" },
                              [
                                _c("textarea", {
                                  directives: [
                                    {
                                      name: "model",
                                      rawName: "v-model",
                                      value: _vm.addModal.searchDescription,
                                      expression: "addModal.searchDescription"
                                    }
                                  ],
                                  staticClass:
                                    "form-control form-control-input w-full flex-1",
                                  class: !_vm.addModal.selectedItem
                                    ? "bg-gray-100 cursor-not-allowed"
                                    : "",
                                  attrs: {
                                    disabled: !_vm.addModal.selectedItem,
                                    rows: "5"
                                  },
                                  domProps: {
                                    value: _vm.addModal.searchDescription
                                  },
                                  on: {
                                    input: function($event) {
                                      if ($event.target.composing) {
                                        return
                                      }
                                      _vm.$set(
                                        _vm.addModal,
                                        "searchDescription",
                                        $event.target.value
                                      )
                                    }
                                  }
                                })
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "div",
                              {
                                staticClass: "w-full pt-3 flex justify-center"
                              },
                              [
                                _c(
                                  "button",
                                  {
                                    staticClass:
                                      "button-primary button px-4 py-3 rounded text-xl",
                                    on: {
                                      click: function($event) {
                                        $event.preventDefault()
                                        return _vm.addItem()
                                      }
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                                Add Item\n                            "
                                    )
                                  ]
                                )
                              ]
                            )
                          ])
                    ])
                  ]
                )
              ])
            ],
            1
          )
        : _vm._e()
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "tr",
      { staticClass: "bg-blue-900 text-white text-semibold text-left" },
      [
        _c("th", { staticClass: "p-2 border-r border-blue-200" }),
        _vm._v(" "),
        _c("th", { staticClass: "p-2 border-r border-blue-200" }, [
          _vm._v("Type")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "p-2 border-r border-blue-200" }, [
          _vm._v("Title")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "p-2" })
      ]
    )
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/Components/PlanList.vue?vue&type=template&id=ea5fe490&":
/*!********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/Components/PlanList.vue?vue&type=template&id=ea5fe490& ***!
  \********************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div")
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

/***/ "./resources/Components/PlanForm.vue":
/*!*******************************************!*\
  !*** ./resources/Components/PlanForm.vue ***!
  \*******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _PlanForm_vue_vue_type_template_id_56d6e6de___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PlanForm.vue?vue&type=template&id=56d6e6de& */ "./resources/Components/PlanForm.vue?vue&type=template&id=56d6e6de&");
/* harmony import */ var _PlanForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PlanForm.vue?vue&type=script&lang=js& */ "./resources/Components/PlanForm.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _PlanForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _PlanForm_vue_vue_type_template_id_56d6e6de___WEBPACK_IMPORTED_MODULE_0__["render"],
  _PlanForm_vue_vue_type_template_id_56d6e6de___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/Components/PlanForm.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/Components/PlanForm.vue?vue&type=script&lang=js&":
/*!********************************************************************!*\
  !*** ./resources/Components/PlanForm.vue?vue&type=script&lang=js& ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PlanForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../node_modules/babel-loader/lib??ref--4-0!../../node_modules/vue-loader/lib??vue-loader-options!./PlanForm.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/Components/PlanForm.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PlanForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/Components/PlanForm.vue?vue&type=template&id=56d6e6de&":
/*!**************************************************************************!*\
  !*** ./resources/Components/PlanForm.vue?vue&type=template&id=56d6e6de& ***!
  \**************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PlanForm_vue_vue_type_template_id_56d6e6de___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../node_modules/vue-loader/lib??vue-loader-options!./PlanForm.vue?vue&type=template&id=56d6e6de& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/Components/PlanForm.vue?vue&type=template&id=56d6e6de&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PlanForm_vue_vue_type_template_id_56d6e6de___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PlanForm_vue_vue_type_template_id_56d6e6de___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/Components/PlanList.vue":
/*!*******************************************!*\
  !*** ./resources/Components/PlanList.vue ***!
  \*******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _PlanList_vue_vue_type_template_id_ea5fe490___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PlanList.vue?vue&type=template&id=ea5fe490& */ "./resources/Components/PlanList.vue?vue&type=template&id=ea5fe490&");
/* harmony import */ var _PlanList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PlanList.vue?vue&type=script&lang=js& */ "./resources/Components/PlanList.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _PlanList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _PlanList_vue_vue_type_template_id_ea5fe490___WEBPACK_IMPORTED_MODULE_0__["render"],
  _PlanList_vue_vue_type_template_id_ea5fe490___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/Components/PlanList.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/Components/PlanList.vue?vue&type=script&lang=js&":
/*!********************************************************************!*\
  !*** ./resources/Components/PlanList.vue?vue&type=script&lang=js& ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PlanList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../node_modules/babel-loader/lib??ref--4-0!../../node_modules/vue-loader/lib??vue-loader-options!./PlanList.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/Components/PlanList.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PlanList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/Components/PlanList.vue?vue&type=template&id=ea5fe490&":
/*!**************************************************************************!*\
  !*** ./resources/Components/PlanList.vue?vue&type=template&id=ea5fe490& ***!
  \**************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PlanList_vue_vue_type_template_id_ea5fe490___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../node_modules/vue-loader/lib??vue-loader-options!./PlanList.vue?vue&type=template&id=ea5fe490& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/Components/PlanList.vue?vue&type=template&id=ea5fe490&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PlanList_vue_vue_type_template_id_ea5fe490___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PlanList_vue_vue_type_template_id_ea5fe490___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/plan.js":
/*!***************************!*\
  !*** ./resources/plan.js ***!
  \***************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Components_PlanList__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Components/PlanList */ "./resources/Components/PlanList.vue");
/* harmony import */ var _Components_PlanForm__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Components/PlanForm */ "./resources/Components/PlanForm.vue");


Architect.onBoot(function (Vue) {
  Vue.component('collection-items-list', _Components_PlanList__WEBPACK_IMPORTED_MODULE_0__["default"]);
  Vue.component('collection-items-form', _Components_PlanForm__WEBPACK_IMPORTED_MODULE_1__["default"]);
});

/***/ }),

/***/ "./resources/plan.scss":
/*!*****************************!*\
  !*** ./resources/plan.scss ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*******************************************************!*\
  !*** multi ./resources/plan.js ./resources/plan.scss ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/jamiepeters/code/coeliac/architect/plans/collection-items/resources/plan.js */"./resources/plan.js");
module.exports = __webpack_require__(/*! /Users/jamiepeters/code/coeliac/architect/plans/collection-items/resources/plan.scss */"./resources/plan.scss");


/***/ })

/******/ });