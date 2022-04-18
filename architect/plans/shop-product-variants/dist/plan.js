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
                window.Architect.$emit(this.name + '-changed', this.emitterValue);
            }
        },

        bootstrapListeners() {
            window.Architect.$on(this.listener, () => {
                window.Architect.$emit(this.emitter, this.getFormData());
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
                    window.Architect.$on(column + '-' + event, value => {
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

/* harmony default export */ __webpack_exports__["default"] = ({
  mixins: [architect_js_helpers__WEBPACK_IMPORTED_MODULE_0__["IsAFormField"]],
  data: function data() {
    return {
      variants: [],
      variantsToAdd: []
    };
  },
  mounted: function mounted() {
    var _this = this;

    if (this.$route.params.id) {
      window.Architect.request().get("external/coeliac-shop-product-variants/variants/".concat(this.$route.params.id)).then(function (response) {
        _this.variants = response.data;
      });
    } else {
      this.addVariant();
    }
  },
  methods: {
    addVariant: function addVariant() {
      this.variantsToAdd.push({
        title: '',
        weight: '',
        quantity: '',
        live: false
      });
    },
    updateVariant: function updateVariant(index, field, $event) {
      this.variants[index][field] = $event.target.value;
    },
    setVariant: function setVariant(index, field, $event) {
      this.variantsToAdd[index][field] = $event.target.value;
    },
    getFormData: function getFormData() {
      return {
        name: this.name,
        value: JSON.stringify({
          update: this.variants,
          add: this.variantsToAdd
        })
      };
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
  props: ['id'],
  data: function data() {
    return {
      variants: []
    };
  },
  created: function created() {
    this.variants = [];
  },
  mounted: function mounted() {
    this.variants = [];
    this.loadData();
  },
  methods: {
    loadData: function loadData() {
      var _this = this;

      window.Architect.request().get('/external/coeliac-shop-product-variants/variants/' + this.id).then(function (response) {
        _this.variants = response.data;
      });
    }
  },
  watch: {
    id: function id() {
      this.loadData();
    }
  }
});

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
  return _c("div", { staticClass: "flex flex-col" }, [
    _c(
      "ul",
      _vm._l(_vm.variants, function(variant, index) {
        return _c(
          "li",
          {
            key: index,
            staticClass: "flex justify-between p-2 rounded my-2 leading-none",
            class: index % 2 === 0 ? "bg-gray-100" : ""
          },
          [
            _c("div", { staticClass: "w-2/3 flex flex-col pr-1" }, [
              _c("strong", { staticClass: "mr-1 mb-1" }, [_vm._v("Title")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: variant.title,
                    expression: "variant.title"
                  }
                ],
                staticClass: "form-control form-control-input",
                attrs: { type: "text" },
                domProps: { value: variant.title },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(variant, "title", $event.target.value)
                  }
                }
              })
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "w-1/6 flex flex-col pr-1" }, [
              _c("strong", { staticClass: "mr-1 mb-1" }, [_vm._v("Weight")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: variant.weight,
                    expression: "variant.weight"
                  }
                ],
                staticClass: "form-control form-control-input",
                attrs: { type: "text" },
                domProps: { value: variant.weight },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(variant, "weight", $event.target.value)
                  }
                }
              })
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "w-1/6 flex flex-col pr-1" }, [
              _c("strong", { staticClass: "mr-1 mb-1" }, [_vm._v("Quantity")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: variant.quantity,
                    expression: "variant.quantity"
                  }
                ],
                staticClass: "form-control form-control-input",
                attrs: { type: "text" },
                domProps: { value: variant.quantity },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(variant, "quantity", $event.target.value)
                  }
                }
              })
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "flex flex-col pr-1" }, [
              _c("strong", { staticClass: "mr-1 mb-2" }, [_vm._v("Live")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: variant.live,
                    expression: "variant.live"
                  }
                ],
                staticClass: "form-control form-control-input",
                attrs: { type: "checkbox" },
                domProps: {
                  checked: Array.isArray(variant.live)
                    ? _vm._i(variant.live, null) > -1
                    : variant.live
                },
                on: {
                  change: function($event) {
                    var $$a = variant.live,
                      $$el = $event.target,
                      $$c = $$el.checked ? true : false
                    if (Array.isArray($$a)) {
                      var $$v = null,
                        $$i = _vm._i($$a, $$v)
                      if ($$el.checked) {
                        $$i < 0 && _vm.$set(variant, "live", $$a.concat([$$v]))
                      } else {
                        $$i > -1 &&
                          _vm.$set(
                            variant,
                            "live",
                            $$a.slice(0, $$i).concat($$a.slice($$i + 1))
                          )
                      }
                    } else {
                      _vm.$set(variant, "live", $$c)
                    }
                  }
                }
              })
            ])
          ]
        )
      }),
      0
    ),
    _vm._v(" "),
    _c("div", { staticClass: "w-full my-2 bg-blue-500" }),
    _vm._v(" "),
    _c(
      "ul",
      [
        _vm.variantsToAdd.length > 0
          ? _vm._l(_vm.variantsToAdd, function(variant, index) {
              return _c(
                "li",
                {
                  key: index,
                  staticClass:
                    "flex justify-between p-2 rounded my-2 leading-none",
                  class: index % 2 === 0 ? "bg-gray-100" : ""
                },
                [
                  _c("div", { staticClass: "w-2/3 flex flex-col pr-1" }, [
                    _c("strong", { staticClass: "mr-1 mb-1" }, [
                      _vm._v("Title")
                    ]),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: variant.title,
                          expression: "variant.title"
                        }
                      ],
                      staticClass: "form-control form-control-input",
                      attrs: { type: "text" },
                      domProps: { value: variant.title },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(variant, "title", $event.target.value)
                        }
                      }
                    })
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "w-1/6 flex flex-col pr-1" }, [
                    _c("strong", { staticClass: "mr-1 mb-1" }, [
                      _vm._v("Weight")
                    ]),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: variant.weight,
                          expression: "variant.weight"
                        }
                      ],
                      staticClass: "form-control form-control-input",
                      attrs: { type: "text" },
                      domProps: { value: variant.weight },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(variant, "weight", $event.target.value)
                        }
                      }
                    })
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "w-1/6 flex flex-col pr-1" }, [
                    _c("strong", { staticClass: "mr-1 mb-1" }, [
                      _vm._v("Quantity")
                    ]),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: variant.quantity,
                          expression: "variant.quantity"
                        }
                      ],
                      staticClass: "form-control form-control-input",
                      attrs: { type: "text" },
                      domProps: { value: variant.quantity },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(variant, "quantity", $event.target.value)
                        }
                      }
                    })
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "flex flex-col pr-1" }, [
                    _c("strong", { staticClass: "mr-1 mb-2" }, [
                      _vm._v("Live")
                    ]),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: variant.live,
                          expression: "variant.live"
                        }
                      ],
                      staticClass: "form-control form-control-input",
                      attrs: { type: "checkbox" },
                      domProps: {
                        checked: Array.isArray(variant.live)
                          ? _vm._i(variant.live, null) > -1
                          : variant.live
                      },
                      on: {
                        change: function($event) {
                          var $$a = variant.live,
                            $$el = $event.target,
                            $$c = $$el.checked ? true : false
                          if (Array.isArray($$a)) {
                            var $$v = null,
                              $$i = _vm._i($$a, $$v)
                            if ($$el.checked) {
                              $$i < 0 &&
                                _vm.$set(variant, "live", $$a.concat([$$v]))
                            } else {
                              $$i > -1 &&
                                _vm.$set(
                                  variant,
                                  "live",
                                  $$a.slice(0, $$i).concat($$a.slice($$i + 1))
                                )
                            }
                          } else {
                            _vm.$set(variant, "live", $$c)
                          }
                        }
                      }
                    })
                  ])
                ]
              )
            })
          : _vm._e(),
        _vm._v(" "),
        _c("li", [
          _c("div", [
            _c(
              "a",
              {
                staticClass:
                  "button button-primary py-1 px-4 rounded cursor-pointer",
                on: {
                  click: function($event) {
                    return _vm.addVariant()
                  }
                }
              },
              [_vm._v("\n          Add Variant\n        ")]
            )
          ])
        ])
      ],
      2
    )
  ])
}
var staticRenderFns = []
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
  return _vm.variants !== []
    ? _c(
        "ul",
        { staticClass: "flex flex-col" },
        _vm._l(_vm.variants, function(variant, index) {
          return _c(
            "li",
            {
              staticClass: "py-1",
              class: index % 2 !== 0 ? "rounded bg-blue-100" : ""
            },
            [
              variant.title !== ""
                ? _c("div", { staticClass: "flex" }, [
                    _c(
                      "div",
                      {
                        staticClass:
                          "w-full flex justify-between px-1 border-b border-blue"
                      },
                      [
                        _c("strong", [_vm._v("Title:")]),
                        _vm._v(" "),
                        _c("span", [_vm._v(_vm._s(variant.title))])
                      ]
                    )
                  ])
                : _vm._e(),
              _vm._v(" "),
              _c("div", { staticClass: "flex" }, [
                _c(
                  "div",
                  { staticClass: "flex flex-col px-1 border-r border-blue" },
                  [
                    _c("strong", [_vm._v("Live")]),
                    _vm._v(" "),
                    _c("span", [_vm._v(_vm._s(variant.live))])
                  ]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "flex flex-col px-1" }, [
                  _c("strong", [_vm._v("Quantity")]),
                  _vm._v(" "),
                  _c("span", [_vm._v(_vm._s(variant.quantity))])
                ])
              ])
            ]
          )
        }),
        0
      )
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
      ? function () { injectStyles.call(this, this.$root.$options.shadowRoot) }
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
  Vue.component('shop-product-variants-list', _Components_PlanList__WEBPACK_IMPORTED_MODULE_0__["default"]);
  Vue.component('shop-product-variants-form', _Components_PlanForm__WEBPACK_IMPORTED_MODULE_1__["default"]);
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

__webpack_require__(/*! /Users/jamiepeters/code/coeliac/architect/plans/shop-product-variants/resources/plan.js */"./resources/plan.js");
module.exports = __webpack_require__(/*! /Users/jamiepeters/code/coeliac/architect/plans/shop-product-variants/resources/plan.scss */"./resources/plan.scss");


/***/ })

/******/ });