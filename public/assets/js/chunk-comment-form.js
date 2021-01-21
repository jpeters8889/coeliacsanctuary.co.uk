/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(self["webpackChunk"] = self["webpackChunk"] || []).push([["chunk-comment-form"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/Components/CommentForm.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/Components/CommentForm.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => __WEBPACK_DEFAULT_EXPORT__\n/* harmony export */ });\nfunction ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }\n\nfunction _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }\n\nfunction _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }\n\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\nvar FormInput = function FormInput() {\n  return Promise.all(/*! import() | chunk-form-input */[__webpack_require__.e(\"/assets/js/vendor\"), __webpack_require__.e(\"chunk-form-input\")]).then(__webpack_require__.bind(__webpack_require__, /*! ./Forms/FormInput */ \"./resources/js/Components/Forms/FormInput.vue\"));\n};\n\nvar FormTextarea = function FormTextarea() {\n  return Promise.all(/*! import() | chunk-form-textarea */[__webpack_require__.e(\"/assets/js/vendor\"), __webpack_require__.e(\"chunk-form-textarea\")]).then(__webpack_require__.bind(__webpack_require__, /*! ./Forms/FormTextarea */ \"./resources/js/Components/Forms/FormTextarea.vue\"));\n};\n\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({\n  components: {\n    'form-input': FormInput,\n    'form-textarea': FormTextarea\n  },\n  props: {\n    area: {\n      type: String,\n      required: true\n    },\n    id: {\n      type: Number,\n      required: true\n    }\n  },\n  data: function data() {\n    return {\n      formData: {\n        name: '',\n        email: '',\n        comment: ''\n      },\n      validity: {\n        name: false,\n        email: false,\n        comment: false\n      }\n    };\n  },\n  mounted: function mounted() {\n    var _this = this;\n\n    Object.keys(this.validity).forEach(function (key) {\n      _this.$root.$on(\"\".concat(key, \"-error\"), function () {\n        _this.validity[key] = false;\n      });\n\n      _this.$root.$on(\"\".concat(key, \"-valid\"), function () {\n        _this.validity[key] = true;\n      });\n\n      _this.$root.$on(\"\".concat(key, \"-value\"), function (value) {\n        _this.formData[key] = value;\n      });\n    });\n  },\n  methods: {\n    submitForm: function submitForm() {\n      var _this2 = this;\n\n      if (this.validateForm()) {\n        coeliac().request().post('/api/comments', _objectSpread({\n          area: this.area,\n          id: this.id\n        }, this.formData)).then(function (response) {\n          if (response.status === 200) {\n            Object.keys(_this2.validity).forEach(function (key) {\n              _this2.formData[key] = '';\n\n              _this2.$root.$emit(\"\".concat(key, \"-reset\"));\n            });\n            coeliac().success('Thanks, your comment has been submitted and is awaiting approval!');\n            return;\n          }\n\n          coeliac().error('Sorry, there was an error submitting your comment, please try again.');\n        });\n      }\n    },\n    validateForm: function validateForm() {\n      var _this3 = this;\n\n      Object.keys(this.validity).forEach(function (key) {\n        _this3.$root.$emit(\"\".concat(key, \"-get-value\"));\n      });\n      var isValid = true;\n      Object.keys(this.validity).forEach(function (key) {\n        if (_this3.validity[key] === false) {\n          isValid = false;\n        }\n      });\n      return isValid;\n    }\n  }\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vcmVzb3VyY2VzL2pzL0NvbXBvbmVudHMvQ29tbWVudEZvcm0udnVlP2U5ZjAiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7QUFtQ0E7QUFBQTtBQUFBOztBQUNBO0FBQUE7QUFBQTs7QUFFQTtBQUNBO0FBQ0EsMkJBREE7QUFFQTtBQUZBLEdBREE7QUFNQTtBQUNBO0FBQ0Esa0JBREE7QUFFQTtBQUZBLEtBREE7QUFLQTtBQUNBLGtCQURBO0FBRUE7QUFGQTtBQUxBLEdBTkE7QUFpQkE7QUFBQTtBQUNBO0FBQ0EsZ0JBREE7QUFFQSxpQkFGQTtBQUdBO0FBSEEsT0FEQTtBQU9BO0FBQ0EsbUJBREE7QUFFQSxvQkFGQTtBQUdBO0FBSEE7QUFQQTtBQUFBLEdBakJBO0FBK0JBLFNBL0JBLHFCQStCQTtBQUFBOztBQUNBO0FBQ0E7QUFDQTtBQUNBLE9BRkE7O0FBSUE7QUFDQTtBQUNBLE9BRkE7O0FBSUE7QUFDQTtBQUNBLE9BRkE7QUFHQSxLQVpBO0FBYUEsR0E3Q0E7QUErQ0E7QUFDQSxjQURBLHdCQUNBO0FBQUE7O0FBQ0E7QUFDQTtBQUNBLHlCQURBO0FBRUE7QUFGQSxXQUdBLGFBSEEsR0FJQSxJQUpBLENBSUE7QUFDQTtBQUNBO0FBQ0E7O0FBQ0E7QUFDQSxhQUhBO0FBS0E7QUFDQTtBQUNBOztBQUVBO0FBQ0EsU0FoQkE7QUFpQkE7QUFDQSxLQXJCQTtBQXVCQSxnQkF2QkEsMEJBdUJBO0FBQUE7O0FBQ0E7QUFDQTtBQUNBLE9BRkE7QUFJQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsT0FKQTtBQU1BO0FBQ0E7QUFyQ0E7QUEvQ0EiLCJmaWxlIjoiLi9ub2RlX21vZHVsZXMvYmFiZWwtbG9hZGVyL2xpYi9pbmRleC5qcz8/Y2xvbmVkUnVsZVNldC01WzBdLnJ1bGVzWzBdLnVzZVswXSEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9pbmRleC5qcz8/dnVlLWxvYWRlci1vcHRpb25zIS4vcmVzb3VyY2VzL2pzL0NvbXBvbmVudHMvQ29tbWVudEZvcm0udnVlP3Z1ZSZ0eXBlPXNjcmlwdCZsYW5nPWpzJi5qcyIsInNvdXJjZXNDb250ZW50IjpbIjx0ZW1wbGF0ZT5cbiAgICA8ZGl2IGNsYXNzPVwicGFnZS1ib3ggcC0zIG10LTNcIj5cbiAgICAgICAgPGgyIGNsYXNzPVwidGV4dC0yeGwgbXktMiBmb250LXNlbWlib2xkIGZvbnQtY29lbGlhY1wiPlN1Ym1pdCBhIENvbW1lbnQ8L2gyPlxuXG4gICAgICAgIDxwPldhbnQgdG8gbGVhdmUgYSBjb21tZW50IG9uIHRoaXMge3sgYXJlYSB9fT8gRmVlbCBmcmVlIHRvIGpvaW4gdGhlIGRpc2N1c3Npb24hPC9wPlxuXG4gICAgICAgIDxkaXYgY2xhc3M9XCJmbGV4IG10LTIgZmxleC1jb2xcIj5cbiAgICAgICAgICAgIDxkaXYgY2xhc3M9XCJtYi01IGZsZXgtMVwiPlxuICAgICAgICAgICAgICAgIDxmb3JtLWlucHV0IHJlcXVpcmVkIG5hbWU9XCJuYW1lXCIgOnZhbHVlPVwiZm9ybURhdGEubmFtZVwiIHBsYWNlaG9sZGVyPVwiWW91ciBuYW1lLi4uXCI+PC9mb3JtLWlucHV0PlxuICAgICAgICAgICAgPC9kaXY+XG4gICAgICAgICAgICA8ZGl2IGNsYXNzPVwibWItNSBmbGV4LTFcIj5cbiAgICAgICAgICAgICAgICA8Zm9ybS1pbnB1dCByZXF1aXJlZCBuYW1lPVwiZW1haWxcIiB0eXBlPVwiZW1haWxcIiA6dmFsdWU9XCJmb3JtRGF0YS5lbWFpbFwiXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgcGxhY2Vob2xkZXI9XCJZb3VyIGVtYWlsLi4uXCI+PC9mb3JtLWlucHV0PlxuICAgICAgICAgICAgPC9kaXY+XG4gICAgICAgICAgICA8ZGl2IGNsYXNzPVwibWItNSBmbGV4LTFcIj5cbiAgICAgICAgICAgICAgICA8Zm9ybS10ZXh0YXJlYSByZXF1aXJlZCBuYW1lPVwiY29tbWVudFwiIDp2YWx1ZT1cImZvcm1EYXRhLmNvbW1lbnRcIiA6cm93cz1cIjEwXCJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBwbGFjZWhvbGRlcj1cIllvdXIgY29tbWVudC4uLlwiPjwvZm9ybS10ZXh0YXJlYT5cbiAgICAgICAgICAgIDwvZGl2PlxuICAgICAgICA8L2Rpdj5cblxuICAgICAgICA8cCBjbGFzcz1cIi1tdC0yIHRleHQtc20gaXRhbGljXCI+XG4gICAgICAgICAgICBOb3RlLCB5b3VyIGVtYWlsIGFkZHJlc3Mgd2lsbCBuZXZlciBiZSBkaXNwbGF5ZWQgd2l0aCB5b3VyIGNvbW1lbnQsIGl0IGlzIG9ubHlcbiAgICAgICAgICAgIHJlcXVpcmVkIHRvIGFsZXJ0IHlvdSB3aGVuIHlvdXIgY29tbWVudCBoYXMgYmVlbiBhcHByb3ZlZCBvciBpZiB0aGUgQ29lbGlhYyBTYW5jdHVhcnkgdGVhbSByZXBseSB0byB5b3VyXG4gICAgICAgICAgICBjb21tZW50LlxuICAgICAgICA8L3A+XG5cbiAgICAgICAgPGJ1dHRvblxuICAgICAgICAgICAgY2xhc3M9XCJtdC0yIGJnLWJsdWUtNTAgYm9yZGVyIGJvcmRlci1ibHVlIHJvdW5kZWQtbGcgcHgtNiBweS0yIHRleHQteGwgdGV4dC1ibGFjayB0cmFuc2l0aW9uLWJnIGhvdmVyOmJnLWJsdWUtMjBcIlxuICAgICAgICAgICAgQGNsaWNrLnByZXZlbnQ9XCJzdWJtaXRGb3JtKClcIj5cbiAgICAgICAgICAgIFN1Ym1pdCBDb21tZW50XG4gICAgICAgIDwvYnV0dG9uPlxuICAgIDwvZGl2PlxuPC90ZW1wbGF0ZT5cblxuPHNjcmlwdD5cbmNvbnN0IEZvcm1JbnB1dCA9ICgpID0+IGltcG9ydCgnLi9Gb3Jtcy9Gb3JtSW5wdXQnIC8qIHdlYnBhY2tDaHVua05hbWU6IFwiY2h1bmstZm9ybS1pbnB1dFwiICovKVxuY29uc3QgRm9ybVRleHRhcmVhID0gKCkgPT4gaW1wb3J0KCcuL0Zvcm1zL0Zvcm1UZXh0YXJlYScgLyogd2VicGFja0NodW5rTmFtZTogXCJjaHVuay1mb3JtLXRleHRhcmVhXCIgKi8pXG5cbmV4cG9ydCBkZWZhdWx0IHtcbiAgICBjb21wb25lbnRzOiB7XG4gICAgICAgICdmb3JtLWlucHV0JzogRm9ybUlucHV0LFxuICAgICAgICAnZm9ybS10ZXh0YXJlYSc6IEZvcm1UZXh0YXJlYSxcbiAgICB9LFxuXG4gICAgcHJvcHM6IHtcbiAgICAgICAgYXJlYToge1xuICAgICAgICAgICAgdHlwZTogU3RyaW5nLFxuICAgICAgICAgICAgcmVxdWlyZWQ6IHRydWUsXG4gICAgICAgIH0sXG4gICAgICAgIGlkOiB7XG4gICAgICAgICAgICB0eXBlOiBOdW1iZXIsXG4gICAgICAgICAgICByZXF1aXJlZDogdHJ1ZSxcbiAgICAgICAgfVxuICAgIH0sXG5cbiAgICBkYXRhOiAoKSA9PiAoe1xuICAgICAgICBmb3JtRGF0YToge1xuICAgICAgICAgICAgbmFtZTogJycsXG4gICAgICAgICAgICBlbWFpbDogJycsXG4gICAgICAgICAgICBjb21tZW50OiAnJyxcbiAgICAgICAgfSxcblxuICAgICAgICB2YWxpZGl0eToge1xuICAgICAgICAgICAgbmFtZTogZmFsc2UsXG4gICAgICAgICAgICBlbWFpbDogZmFsc2UsXG4gICAgICAgICAgICBjb21tZW50OiBmYWxzZSxcbiAgICAgICAgfVxuICAgIH0pLFxuXG4gICAgbW91bnRlZCgpIHtcbiAgICAgICAgT2JqZWN0LmtleXModGhpcy52YWxpZGl0eSkuZm9yRWFjaCgoa2V5KSA9PiB7XG4gICAgICAgICAgICB0aGlzLiRyb290LiRvbihgJHtrZXl9LWVycm9yYCwgKCkgPT4ge1xuICAgICAgICAgICAgICAgIHRoaXMudmFsaWRpdHlba2V5XSA9IGZhbHNlO1xuICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgIHRoaXMuJHJvb3QuJG9uKGAke2tleX0tdmFsaWRgLCAoKSA9PiB7XG4gICAgICAgICAgICAgICAgdGhpcy52YWxpZGl0eVtrZXldID0gdHJ1ZTtcbiAgICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgICB0aGlzLiRyb290LiRvbihgJHtrZXl9LXZhbHVlYCwgKHZhbHVlKSA9PiB7XG4gICAgICAgICAgICAgICAgdGhpcy5mb3JtRGF0YVtrZXldID0gdmFsdWU7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfSk7XG4gICAgfSxcblxuICAgIG1ldGhvZHM6IHtcbiAgICAgICAgc3VibWl0Rm9ybSgpIHtcbiAgICAgICAgICAgIGlmICh0aGlzLnZhbGlkYXRlRm9ybSgpKSB7XG4gICAgICAgICAgICAgICAgY29lbGlhYygpLnJlcXVlc3QoKS5wb3N0KCcvYXBpL2NvbW1lbnRzJywge1xuICAgICAgICAgICAgICAgICAgICBhcmVhOiB0aGlzLmFyZWEsXG4gICAgICAgICAgICAgICAgICAgIGlkOiB0aGlzLmlkLFxuICAgICAgICAgICAgICAgICAgICAuLi50aGlzLmZvcm1EYXRhLFxuICAgICAgICAgICAgICAgIH0pLnRoZW4oKHJlc3BvbnNlKSA9PiB7XG4gICAgICAgICAgICAgICAgICAgIGlmIChyZXNwb25zZS5zdGF0dXMgPT09IDIwMCkge1xuICAgICAgICAgICAgICAgICAgICAgICAgT2JqZWN0LmtleXModGhpcy52YWxpZGl0eSkuZm9yRWFjaCgoa2V5KSA9PiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdGhpcy5mb3JtRGF0YVtrZXldID0gJyc7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdGhpcy4kcm9vdC4kZW1pdChgJHtrZXl9LXJlc2V0YCk7XG4gICAgICAgICAgICAgICAgICAgICAgICB9KTtcblxuICAgICAgICAgICAgICAgICAgICAgICAgY29lbGlhYygpLnN1Y2Nlc3MoJ1RoYW5rcywgeW91ciBjb21tZW50IGhhcyBiZWVuIHN1Ym1pdHRlZCBhbmQgaXMgYXdhaXRpbmcgYXBwcm92YWwhJyk7XG4gICAgICAgICAgICAgICAgICAgICAgICByZXR1cm47XG4gICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICBjb2VsaWFjKCkuZXJyb3IoJ1NvcnJ5LCB0aGVyZSB3YXMgYW4gZXJyb3Igc3VibWl0dGluZyB5b3VyIGNvbW1lbnQsIHBsZWFzZSB0cnkgYWdhaW4uJyk7XG4gICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH0sXG5cbiAgICAgICAgdmFsaWRhdGVGb3JtKCkge1xuICAgICAgICAgICAgT2JqZWN0LmtleXModGhpcy52YWxpZGl0eSkuZm9yRWFjaCgoa2V5KSA9PiB7XG4gICAgICAgICAgICAgICAgdGhpcy4kcm9vdC4kZW1pdChgJHtrZXl9LWdldC12YWx1ZWApXG4gICAgICAgICAgICB9KTtcblxuICAgICAgICAgICAgbGV0IGlzVmFsaWQgPSB0cnVlO1xuXG4gICAgICAgICAgICBPYmplY3Qua2V5cyh0aGlzLnZhbGlkaXR5KS5mb3JFYWNoKChrZXkpID0+IHtcbiAgICAgICAgICAgICAgICBpZiAodGhpcy52YWxpZGl0eVtrZXldID09PSBmYWxzZSkge1xuICAgICAgICAgICAgICAgICAgICBpc1ZhbGlkID0gZmFsc2U7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgIHJldHVybiBpc1ZhbGlkO1xuICAgICAgICB9XG4gICAgfVxufVxuPC9zY3JpcHQ+XG4iXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/Components/CommentForm.vue?vue&type=script&lang=js&\n");

/***/ }),

/***/ "./resources/js/Components/CommentForm.vue":
/*!*************************************************!*\
  !*** ./resources/js/Components/CommentForm.vue ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => __WEBPACK_DEFAULT_EXPORT__\n/* harmony export */ });\n/* harmony import */ var _CommentForm_vue_vue_type_template_id_37c42548___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CommentForm.vue?vue&type=template&id=37c42548& */ \"./resources/js/Components/CommentForm.vue?vue&type=template&id=37c42548&\");\n/* harmony import */ var _CommentForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CommentForm.vue?vue&type=script&lang=js& */ \"./resources/js/Components/CommentForm.vue?vue&type=script&lang=js&\");\n/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ \"./node_modules/vue-loader/lib/runtime/componentNormalizer.js\");\n\n\n\n\n\n/* normalize component */\n;\nvar component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(\n  _CommentForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,\n  _CommentForm_vue_vue_type_template_id_37c42548___WEBPACK_IMPORTED_MODULE_0__.render,\n  _CommentForm_vue_vue_type_template_id_37c42548___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,\n  false,\n  null,\n  null,\n  null\n  \n)\n\n/* hot reload */\nif (false) { var api; }\ncomponent.options.__file = \"resources/js/Components/CommentForm.vue\"\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvQ29tcG9uZW50cy9Db21tZW50Rm9ybS52dWU/NDY1NCJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiOzs7Ozs7O0FBQTBGO0FBQzNCO0FBQ0w7OztBQUcxRDtBQUNBLENBQTZGO0FBQzdGLGdCQUFnQixvR0FBVTtBQUMxQixFQUFFLDhFQUFNO0FBQ1IsRUFBRSxtRkFBTTtBQUNSLEVBQUUsNEZBQWU7QUFDakI7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQSxJQUFJLEtBQVUsRUFBRSxZQWlCZjtBQUNEO0FBQ0EsaUVBQWUsaUIiLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvQ29tcG9uZW50cy9Db21tZW50Rm9ybS52dWUuanMiLCJzb3VyY2VzQ29udGVudCI6WyJpbXBvcnQgeyByZW5kZXIsIHN0YXRpY1JlbmRlckZucyB9IGZyb20gXCIuL0NvbW1lbnRGb3JtLnZ1ZT92dWUmdHlwZT10ZW1wbGF0ZSZpZD0zN2M0MjU0OCZcIlxuaW1wb3J0IHNjcmlwdCBmcm9tIFwiLi9Db21tZW50Rm9ybS52dWU/dnVlJnR5cGU9c2NyaXB0Jmxhbmc9anMmXCJcbmV4cG9ydCAqIGZyb20gXCIuL0NvbW1lbnRGb3JtLnZ1ZT92dWUmdHlwZT1zY3JpcHQmbGFuZz1qcyZcIlxuXG5cbi8qIG5vcm1hbGl6ZSBjb21wb25lbnQgKi9cbmltcG9ydCBub3JtYWxpemVyIGZyb20gXCIhLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3J1bnRpbWUvY29tcG9uZW50Tm9ybWFsaXplci5qc1wiXG52YXIgY29tcG9uZW50ID0gbm9ybWFsaXplcihcbiAgc2NyaXB0LFxuICByZW5kZXIsXG4gIHN0YXRpY1JlbmRlckZucyxcbiAgZmFsc2UsXG4gIG51bGwsXG4gIG51bGwsXG4gIG51bGxcbiAgXG4pXG5cbi8qIGhvdCByZWxvYWQgKi9cbmlmIChtb2R1bGUuaG90KSB7XG4gIHZhciBhcGkgPSByZXF1aXJlKFwiL1VzZXJzL2phbWllcGV0ZXJzL2NvZGUvY29lbGlhYy9ub2RlX21vZHVsZXMvdnVlLWhvdC1yZWxvYWQtYXBpL2Rpc3QvaW5kZXguanNcIilcbiAgYXBpLmluc3RhbGwocmVxdWlyZSgndnVlJykpXG4gIGlmIChhcGkuY29tcGF0aWJsZSkge1xuICAgIG1vZHVsZS5ob3QuYWNjZXB0KClcbiAgICBpZiAoIWFwaS5pc1JlY29yZGVkKCczN2M0MjU0OCcpKSB7XG4gICAgICBhcGkuY3JlYXRlUmVjb3JkKCczN2M0MjU0OCcsIGNvbXBvbmVudC5vcHRpb25zKVxuICAgIH0gZWxzZSB7XG4gICAgICBhcGkucmVsb2FkKCczN2M0MjU0OCcsIGNvbXBvbmVudC5vcHRpb25zKVxuICAgIH1cbiAgICBtb2R1bGUuaG90LmFjY2VwdChcIi4vQ29tbWVudEZvcm0udnVlP3Z1ZSZ0eXBlPXRlbXBsYXRlJmlkPTM3YzQyNTQ4JlwiLCBmdW5jdGlvbiAoKSB7XG4gICAgICBhcGkucmVyZW5kZXIoJzM3YzQyNTQ4Jywge1xuICAgICAgICByZW5kZXI6IHJlbmRlcixcbiAgICAgICAgc3RhdGljUmVuZGVyRm5zOiBzdGF0aWNSZW5kZXJGbnNcbiAgICAgIH0pXG4gICAgfSlcbiAgfVxufVxuY29tcG9uZW50Lm9wdGlvbnMuX19maWxlID0gXCJyZXNvdXJjZXMvanMvQ29tcG9uZW50cy9Db21tZW50Rm9ybS52dWVcIlxuZXhwb3J0IGRlZmF1bHQgY29tcG9uZW50LmV4cG9ydHMiXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/js/Components/CommentForm.vue\n");

/***/ }),

/***/ "./resources/js/Components/CommentForm.vue?vue&type=script&lang=js&":
/*!**************************************************************************!*\
  !*** ./resources/js/Components/CommentForm.vue?vue&type=script&lang=js& ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => __WEBPACK_DEFAULT_EXPORT__\n/* harmony export */ });\n/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CommentForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CommentForm.vue?vue&type=script&lang=js& */ \"./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/Components/CommentForm.vue?vue&type=script&lang=js&\");\n /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CommentForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); //# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvQ29tcG9uZW50cy9Db21tZW50Rm9ybS52dWU/MGJhZCJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiOzs7OztBQUFxTixDQUFDLGlFQUFlLDZNQUFHLEVBQUMiLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvQ29tcG9uZW50cy9Db21tZW50Rm9ybS52dWU/dnVlJnR5cGU9c2NyaXB0Jmxhbmc9anMmLmpzIiwic291cmNlc0NvbnRlbnQiOlsiaW1wb3J0IG1vZCBmcm9tIFwiLSEuLi8uLi8uLi9ub2RlX21vZHVsZXMvYmFiZWwtbG9hZGVyL2xpYi9pbmRleC5qcz8/Y2xvbmVkUnVsZVNldC01WzBdLnJ1bGVzWzBdLnVzZVswXSEuLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvaW5kZXguanM/P3Z1ZS1sb2FkZXItb3B0aW9ucyEuL0NvbW1lbnRGb3JtLnZ1ZT92dWUmdHlwZT1zY3JpcHQmbGFuZz1qcyZcIjsgZXhwb3J0IGRlZmF1bHQgbW9kOyBleHBvcnQgKiBmcm9tIFwiLSEuLi8uLi8uLi9ub2RlX21vZHVsZXMvYmFiZWwtbG9hZGVyL2xpYi9pbmRleC5qcz8/Y2xvbmVkUnVsZVNldC01WzBdLnJ1bGVzWzBdLnVzZVswXSEuLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvaW5kZXguanM/P3Z1ZS1sb2FkZXItb3B0aW9ucyEuL0NvbW1lbnRGb3JtLnZ1ZT92dWUmdHlwZT1zY3JpcHQmbGFuZz1qcyZcIiJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/js/Components/CommentForm.vue?vue&type=script&lang=js&\n");

/***/ }),

/***/ "./resources/js/Components/CommentForm.vue?vue&type=template&id=37c42548&":
/*!********************************************************************************!*\
  !*** ./resources/js/Components/CommentForm.vue?vue&type=template&id=37c42548& ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CommentForm_vue_vue_type_template_id_37c42548___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CommentForm_vue_vue_type_template_id_37c42548___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CommentForm_vue_vue_type_template_id_37c42548___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CommentForm.vue?vue&type=template&id=37c42548& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/Components/CommentForm.vue?vue&type=template&id=37c42548&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/Components/CommentForm.vue?vue&type=template&id=37c42548&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/Components/CommentForm.vue?vue&type=template&id=37c42548& ***!
  \***********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"render\": () => /* binding */ render,\n/* harmony export */   \"staticRenderFns\": () => /* binding */ staticRenderFns\n/* harmony export */ });\nvar render = function() {\n  var _vm = this\n  var _h = _vm.$createElement\n  var _c = _vm._self._c || _h\n  return _c(\"div\", { staticClass: \"page-box p-3 mt-3\" }, [\n    _c(\"h2\", { staticClass: \"text-2xl my-2 font-semibold font-coeliac\" }, [\n      _vm._v(\"Submit a Comment\")\n    ]),\n    _vm._v(\" \"),\n    _c(\"p\", [\n      _vm._v(\n        \"Want to leave a comment on this \" +\n          _vm._s(_vm.area) +\n          \"? Feel free to join the discussion!\"\n      )\n    ]),\n    _vm._v(\" \"),\n    _c(\"div\", { staticClass: \"flex mt-2 flex-col\" }, [\n      _c(\n        \"div\",\n        { staticClass: \"mb-5 flex-1\" },\n        [\n          _c(\"form-input\", {\n            attrs: {\n              required: \"\",\n              name: \"name\",\n              value: _vm.formData.name,\n              placeholder: \"Your name...\"\n            }\n          })\n        ],\n        1\n      ),\n      _vm._v(\" \"),\n      _c(\n        \"div\",\n        { staticClass: \"mb-5 flex-1\" },\n        [\n          _c(\"form-input\", {\n            attrs: {\n              required: \"\",\n              name: \"email\",\n              type: \"email\",\n              value: _vm.formData.email,\n              placeholder: \"Your email...\"\n            }\n          })\n        ],\n        1\n      ),\n      _vm._v(\" \"),\n      _c(\n        \"div\",\n        { staticClass: \"mb-5 flex-1\" },\n        [\n          _c(\"form-textarea\", {\n            attrs: {\n              required: \"\",\n              name: \"comment\",\n              value: _vm.formData.comment,\n              rows: 10,\n              placeholder: \"Your comment...\"\n            }\n          })\n        ],\n        1\n      )\n    ]),\n    _vm._v(\" \"),\n    _c(\"p\", { staticClass: \"-mt-2 text-sm italic\" }, [\n      _vm._v(\n        \"\\n        Note, your email address will never be displayed with your comment, it is only\\n        required to alert you when your comment has been approved or if the Coeliac Sanctuary team reply to your\\n        comment.\\n    \"\n      )\n    ]),\n    _vm._v(\" \"),\n    _c(\n      \"button\",\n      {\n        staticClass:\n          \"mt-2 bg-blue-50 border border-blue rounded-lg px-6 py-2 text-xl text-black transition-bg hover:bg-blue-20\",\n        on: {\n          click: function($event) {\n            $event.preventDefault()\n            return _vm.submitForm()\n          }\n        }\n      },\n      [_vm._v(\"\\n        Submit Comment\\n    \")]\n    )\n  ])\n}\nvar staticRenderFns = []\nrender._withStripped = true\n\n//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvQ29tcG9uZW50cy9Db21tZW50Rm9ybS52dWU/N2ZkMyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiOzs7OztBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0Esb0JBQW9CLG1DQUFtQztBQUN2RCxjQUFjLDBEQUEwRDtBQUN4RTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsZUFBZSxvQ0FBb0M7QUFDbkQ7QUFDQTtBQUNBLFNBQVMsNkJBQTZCO0FBQ3RDO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxXQUFXO0FBQ1g7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsU0FBUyw2QkFBNkI7QUFDdEM7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsV0FBVztBQUNYO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLFNBQVMsNkJBQTZCO0FBQ3RDO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLFdBQVc7QUFDWDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsYUFBYSxzQ0FBc0M7QUFDbkQ7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxPQUFPO0FBQ1A7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBIiwiZmlsZSI6Ii4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL2xvYWRlcnMvdGVtcGxhdGVMb2FkZXIuanM/P3Z1ZS1sb2FkZXItb3B0aW9ucyEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9pbmRleC5qcz8/dnVlLWxvYWRlci1vcHRpb25zIS4vcmVzb3VyY2VzL2pzL0NvbXBvbmVudHMvQ29tbWVudEZvcm0udnVlP3Z1ZSZ0eXBlPXRlbXBsYXRlJmlkPTM3YzQyNTQ4Ji5qcyIsInNvdXJjZXNDb250ZW50IjpbInZhciByZW5kZXIgPSBmdW5jdGlvbigpIHtcbiAgdmFyIF92bSA9IHRoaXNcbiAgdmFyIF9oID0gX3ZtLiRjcmVhdGVFbGVtZW50XG4gIHZhciBfYyA9IF92bS5fc2VsZi5fYyB8fCBfaFxuICByZXR1cm4gX2MoXCJkaXZcIiwgeyBzdGF0aWNDbGFzczogXCJwYWdlLWJveCBwLTMgbXQtM1wiIH0sIFtcbiAgICBfYyhcImgyXCIsIHsgc3RhdGljQ2xhc3M6IFwidGV4dC0yeGwgbXktMiBmb250LXNlbWlib2xkIGZvbnQtY29lbGlhY1wiIH0sIFtcbiAgICAgIF92bS5fdihcIlN1Ym1pdCBhIENvbW1lbnRcIilcbiAgICBdKSxcbiAgICBfdm0uX3YoXCIgXCIpLFxuICAgIF9jKFwicFwiLCBbXG4gICAgICBfdm0uX3YoXG4gICAgICAgIFwiV2FudCB0byBsZWF2ZSBhIGNvbW1lbnQgb24gdGhpcyBcIiArXG4gICAgICAgICAgX3ZtLl9zKF92bS5hcmVhKSArXG4gICAgICAgICAgXCI/IEZlZWwgZnJlZSB0byBqb2luIHRoZSBkaXNjdXNzaW9uIVwiXG4gICAgICApXG4gICAgXSksXG4gICAgX3ZtLl92KFwiIFwiKSxcbiAgICBfYyhcImRpdlwiLCB7IHN0YXRpY0NsYXNzOiBcImZsZXggbXQtMiBmbGV4LWNvbFwiIH0sIFtcbiAgICAgIF9jKFxuICAgICAgICBcImRpdlwiLFxuICAgICAgICB7IHN0YXRpY0NsYXNzOiBcIm1iLTUgZmxleC0xXCIgfSxcbiAgICAgICAgW1xuICAgICAgICAgIF9jKFwiZm9ybS1pbnB1dFwiLCB7XG4gICAgICAgICAgICBhdHRyczoge1xuICAgICAgICAgICAgICByZXF1aXJlZDogXCJcIixcbiAgICAgICAgICAgICAgbmFtZTogXCJuYW1lXCIsXG4gICAgICAgICAgICAgIHZhbHVlOiBfdm0uZm9ybURhdGEubmFtZSxcbiAgICAgICAgICAgICAgcGxhY2Vob2xkZXI6IFwiWW91ciBuYW1lLi4uXCJcbiAgICAgICAgICAgIH1cbiAgICAgICAgICB9KVxuICAgICAgICBdLFxuICAgICAgICAxXG4gICAgICApLFxuICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgIF9jKFxuICAgICAgICBcImRpdlwiLFxuICAgICAgICB7IHN0YXRpY0NsYXNzOiBcIm1iLTUgZmxleC0xXCIgfSxcbiAgICAgICAgW1xuICAgICAgICAgIF9jKFwiZm9ybS1pbnB1dFwiLCB7XG4gICAgICAgICAgICBhdHRyczoge1xuICAgICAgICAgICAgICByZXF1aXJlZDogXCJcIixcbiAgICAgICAgICAgICAgbmFtZTogXCJlbWFpbFwiLFxuICAgICAgICAgICAgICB0eXBlOiBcImVtYWlsXCIsXG4gICAgICAgICAgICAgIHZhbHVlOiBfdm0uZm9ybURhdGEuZW1haWwsXG4gICAgICAgICAgICAgIHBsYWNlaG9sZGVyOiBcIllvdXIgZW1haWwuLi5cIlxuICAgICAgICAgICAgfVxuICAgICAgICAgIH0pXG4gICAgICAgIF0sXG4gICAgICAgIDFcbiAgICAgICksXG4gICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgX2MoXG4gICAgICAgIFwiZGl2XCIsXG4gICAgICAgIHsgc3RhdGljQ2xhc3M6IFwibWItNSBmbGV4LTFcIiB9LFxuICAgICAgICBbXG4gICAgICAgICAgX2MoXCJmb3JtLXRleHRhcmVhXCIsIHtcbiAgICAgICAgICAgIGF0dHJzOiB7XG4gICAgICAgICAgICAgIHJlcXVpcmVkOiBcIlwiLFxuICAgICAgICAgICAgICBuYW1lOiBcImNvbW1lbnRcIixcbiAgICAgICAgICAgICAgdmFsdWU6IF92bS5mb3JtRGF0YS5jb21tZW50LFxuICAgICAgICAgICAgICByb3dzOiAxMCxcbiAgICAgICAgICAgICAgcGxhY2Vob2xkZXI6IFwiWW91ciBjb21tZW50Li4uXCJcbiAgICAgICAgICAgIH1cbiAgICAgICAgICB9KVxuICAgICAgICBdLFxuICAgICAgICAxXG4gICAgICApXG4gICAgXSksXG4gICAgX3ZtLl92KFwiIFwiKSxcbiAgICBfYyhcInBcIiwgeyBzdGF0aWNDbGFzczogXCItbXQtMiB0ZXh0LXNtIGl0YWxpY1wiIH0sIFtcbiAgICAgIF92bS5fdihcbiAgICAgICAgXCJcXG4gICAgICAgIE5vdGUsIHlvdXIgZW1haWwgYWRkcmVzcyB3aWxsIG5ldmVyIGJlIGRpc3BsYXllZCB3aXRoIHlvdXIgY29tbWVudCwgaXQgaXMgb25seVxcbiAgICAgICAgcmVxdWlyZWQgdG8gYWxlcnQgeW91IHdoZW4geW91ciBjb21tZW50IGhhcyBiZWVuIGFwcHJvdmVkIG9yIGlmIHRoZSBDb2VsaWFjIFNhbmN0dWFyeSB0ZWFtIHJlcGx5IHRvIHlvdXJcXG4gICAgICAgIGNvbW1lbnQuXFxuICAgIFwiXG4gICAgICApXG4gICAgXSksXG4gICAgX3ZtLl92KFwiIFwiKSxcbiAgICBfYyhcbiAgICAgIFwiYnV0dG9uXCIsXG4gICAgICB7XG4gICAgICAgIHN0YXRpY0NsYXNzOlxuICAgICAgICAgIFwibXQtMiBiZy1ibHVlLTUwIGJvcmRlciBib3JkZXItYmx1ZSByb3VuZGVkLWxnIHB4LTYgcHktMiB0ZXh0LXhsIHRleHQtYmxhY2sgdHJhbnNpdGlvbi1iZyBob3ZlcjpiZy1ibHVlLTIwXCIsXG4gICAgICAgIG9uOiB7XG4gICAgICAgICAgY2xpY2s6IGZ1bmN0aW9uKCRldmVudCkge1xuICAgICAgICAgICAgJGV2ZW50LnByZXZlbnREZWZhdWx0KClcbiAgICAgICAgICAgIHJldHVybiBfdm0uc3VibWl0Rm9ybSgpXG4gICAgICAgICAgfVxuICAgICAgICB9XG4gICAgICB9LFxuICAgICAgW192bS5fdihcIlxcbiAgICAgICAgU3VibWl0IENvbW1lbnRcXG4gICAgXCIpXVxuICAgIClcbiAgXSlcbn1cbnZhciBzdGF0aWNSZW5kZXJGbnMgPSBbXVxucmVuZGVyLl93aXRoU3RyaXBwZWQgPSB0cnVlXG5cbmV4cG9ydCB7IHJlbmRlciwgc3RhdGljUmVuZGVyRm5zIH0iXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/Components/CommentForm.vue?vue&type=template&id=37c42548&\n");

/***/ })

}]);