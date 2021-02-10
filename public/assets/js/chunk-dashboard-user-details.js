/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(self["webpackChunk"] = self["webpackChunk"] || []).push([["chunk-dashboard-user-details"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/Components/DashboardUserDetails.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/Components/DashboardUserDetails.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => __WEBPACK_DEFAULT_EXPORT__\n/* harmony export */ });\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\nvar FormInput = function FormInput() {\n  return Promise.all(/*! import() | chunk-form-input */[__webpack_require__.e(\"/assets/js/vendor\"), __webpack_require__.e(\"chunk-form-input\")]).then(__webpack_require__.bind(__webpack_require__, /*! ./Forms/FormInput */ \"./resources/js/Components/Forms/FormInput.vue\"));\n};\n\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({\n  components: {\n    'form-input': FormInput\n  },\n  props: {\n    name: {\n      required: true,\n      type: String\n    },\n    email: {\n      required: true,\n      type: String\n    },\n    phone: {\n      required: false,\n      type: String\n    }\n  },\n  data: function data() {\n    return {\n      form: [{\n        label: 'Your Name',\n        field: 'name',\n        required: true,\n        type: 'text'\n      }, {\n        label: 'Email Address',\n        help: 'You will need to verify your new email address.',\n        field: 'email',\n        required: true,\n        type: 'email'\n      }, {\n        label: 'Phone Number',\n        help: 'This is only used if there\\'s a problem with any of your orders through our shop.',\n        field: 'phone',\n        required: false,\n        type: 'phone'\n      }],\n      fields: {\n        name: '',\n        email: '',\n        phone: ''\n      },\n      validity: {\n        name: false,\n        email: false,\n        phone: true\n      }\n    };\n  },\n  mounted: function mounted() {\n    var _this = this;\n\n    Object.keys(this.fields).forEach(function (field) {\n      _this.fields[field] = _this[field];\n      coeliac().$emit(\"\".concat(field, \"-set-value\"), _this.fields[field]);\n\n      _this.$root.$on(\"\".concat(field, \"-error\"), function () {\n        _this.validity[field] = false;\n      });\n\n      _this.$root.$on(\"\".concat(field, \"-valid\"), function () {\n        _this.validity[field] = true;\n      });\n\n      _this.$root.$on(\"\".concat(field, \"-change\"), function (value) {\n        _this.fields[field] = value;\n      });\n    });\n  },\n  methods: {\n    validateForm: function validateForm() {\n      var _this2 = this;\n\n      Object.keys(this.validity).forEach(function (key) {\n        _this2.$root.$emit(\"\".concat(key, \"-get-value\"));\n      });\n      var isValid = true;\n      Object.keys(this.validity).forEach(function (key) {\n        if (_this2.validity[key] === false) {\n          isValid = false;\n        }\n      });\n      return isValid;\n    }\n  }\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vcmVzb3VyY2VzL2pzL0NvbXBvbmVudHMvRGFzaGJvYXJkVXNlckRldGFpbHMudnVlPzFlNzYiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7Ozs7Ozs7QUFXQTtBQUFBO0FBQUE7O0FBRUE7QUFDQTtBQUNBO0FBREEsR0FEQTtBQUtBO0FBQ0E7QUFDQSxvQkFEQTtBQUVBO0FBRkEsS0FEQTtBQUtBO0FBQ0Esb0JBREE7QUFFQTtBQUZBLEtBTEE7QUFTQTtBQUNBLHFCQURBO0FBRUE7QUFGQTtBQVRBLEdBTEE7QUFvQkE7QUFBQTtBQUNBLGFBQ0E7QUFDQSwwQkFEQTtBQUVBLHFCQUZBO0FBR0Esc0JBSEE7QUFJQTtBQUpBLE9BREEsRUFPQTtBQUNBLDhCQURBO0FBRUEsK0RBRkE7QUFHQSxzQkFIQTtBQUlBLHNCQUpBO0FBS0E7QUFMQSxPQVBBLEVBY0E7QUFDQSw2QkFEQTtBQUVBLGlHQUZBO0FBR0Esc0JBSEE7QUFJQSx1QkFKQTtBQUtBO0FBTEEsT0FkQSxDQURBO0FBd0JBO0FBQ0EsZ0JBREE7QUFFQSxpQkFGQTtBQUdBO0FBSEEsT0F4QkE7QUE4QkE7QUFDQSxtQkFEQTtBQUVBLG9CQUZBO0FBR0E7QUFIQTtBQTlCQTtBQUFBLEdBcEJBO0FBeURBLFNBekRBLHFCQXlEQTtBQUFBOztBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0EsT0FGQTs7QUFJQTtBQUNBO0FBQ0EsT0FGQTs7QUFJQTtBQUNBO0FBQ0EsT0FGQTtBQUdBLEtBZkE7QUFnQkEsR0ExRUE7QUE0RUE7QUFDQSxnQkFEQSwwQkFDQTtBQUFBOztBQUNBO0FBQ0E7QUFDQSxPQUZBO0FBSUE7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLE9BSkE7QUFNQTtBQUNBO0FBZkE7QUE1RUEiLCJmaWxlIjoiLi9ub2RlX21vZHVsZXMvYmFiZWwtbG9hZGVyL2xpYi9pbmRleC5qcz8/Y2xvbmVkUnVsZVNldC01WzBdLnJ1bGVzWzBdLnVzZVswXSEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9pbmRleC5qcz8/dnVlLWxvYWRlci1vcHRpb25zIS4vcmVzb3VyY2VzL2pzL0NvbXBvbmVudHMvRGFzaGJvYXJkVXNlckRldGFpbHMudnVlP3Z1ZSZ0eXBlPXNjcmlwdCZsYW5nPWpzJi5qcyIsInNvdXJjZXNDb250ZW50IjpbIjx0ZW1wbGF0ZT5cbiAgICA8ZGl2IGNsYXNzPVwiZmxleCBmbGV4LWNvbFwiPlxuICAgICAgICA8ZGl2IHYtZm9yPVwiaW5wdXQgaW4gZm9ybVwiIGNsYXNzPVwicHktNCBib3JkZXItYiBib3JkZXItYmx1ZSBsYXN0OmJvcmRlci0wXCI+XG4gICAgICAgICAgICA8bGFiZWwgY2xhc3M9XCJ0ZXh0LWJsdWUtZGFyayBmb250LXNlbWlib2xkIG1iLTFcIiA6Zm9yPVwiaW5wdXQuZmllbGRcIj57eyBpbnB1dC5sYWJlbCB9fTwvbGFiZWw+XG4gICAgICAgICAgICA8Zm9ybS1pbnB1dCA6aWQ9XCJpbnB1dC5maWVsZFwiIDp0eXBlPVwiaW5wdXQudHlwZVwiIDpuYW1lPVwiaW5wdXQuZmllbGRcIiA6cmVxdWlyZWQ9XCJpbnB1dC5yZXF1aXJlZFwiIDp2YWx1ZT1cImZpZWxkc1tpbnB1dC5maWVsZF1cIiAvPlxuICAgICAgICAgICAgPHNwYW4gY2xhc3M9XCJ0ZXh0LXNtIGZvbnQtc2VtaWJvbGRcIiB2LWlmPVwiaW5wdXQuaGVscFwiPnt7IGlucHV0LmhlbHAgfX08L3NwYW4+XG4gICAgICAgIDwvZGl2PlxuICAgIDwvZGl2PlxuPC90ZW1wbGF0ZT5cblxuPHNjcmlwdD5cbmNvbnN0IEZvcm1JbnB1dCA9ICgpID0+IGltcG9ydCgnLi9Gb3Jtcy9Gb3JtSW5wdXQnIC8qIHdlYnBhY2tDaHVua05hbWU6IFwiY2h1bmstZm9ybS1pbnB1dFwiICovKVxuXG5leHBvcnQgZGVmYXVsdCB7XG4gICAgY29tcG9uZW50czoge1xuICAgICAgICAnZm9ybS1pbnB1dCc6IEZvcm1JbnB1dCxcbiAgICB9LFxuXG4gICAgcHJvcHM6IHtcbiAgICAgICAgbmFtZToge1xuICAgICAgICAgICAgcmVxdWlyZWQ6IHRydWUsXG4gICAgICAgICAgICB0eXBlOiBTdHJpbmcsXG4gICAgICAgIH0sXG4gICAgICAgIGVtYWlsOiB7XG4gICAgICAgICAgICByZXF1aXJlZDogdHJ1ZSxcbiAgICAgICAgICAgIHR5cGU6IFN0cmluZyxcbiAgICAgICAgfSxcbiAgICAgICAgcGhvbmU6IHtcbiAgICAgICAgICAgIHJlcXVpcmVkOiBmYWxzZSxcbiAgICAgICAgICAgIHR5cGU6IFN0cmluZyxcbiAgICAgICAgfVxuICAgIH0sXG5cbiAgICBkYXRhOiAoKSA9PiAoe1xuICAgICAgICBmb3JtOiBbXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgbGFiZWw6ICdZb3VyIE5hbWUnLFxuICAgICAgICAgICAgICAgIGZpZWxkOiAnbmFtZScsXG4gICAgICAgICAgICAgICAgcmVxdWlyZWQ6IHRydWUsXG4gICAgICAgICAgICAgICAgdHlwZTogJ3RleHQnLFxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBsYWJlbDogJ0VtYWlsIEFkZHJlc3MnLFxuICAgICAgICAgICAgICAgIGhlbHA6ICdZb3Ugd2lsbCBuZWVkIHRvIHZlcmlmeSB5b3VyIG5ldyBlbWFpbCBhZGRyZXNzLicsXG4gICAgICAgICAgICAgICAgZmllbGQ6ICdlbWFpbCcsXG4gICAgICAgICAgICAgICAgcmVxdWlyZWQ6IHRydWUsXG4gICAgICAgICAgICAgICAgdHlwZTogJ2VtYWlsJyxcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgbGFiZWw6ICdQaG9uZSBOdW1iZXInLFxuICAgICAgICAgICAgICAgIGhlbHA6ICdUaGlzIGlzIG9ubHkgdXNlZCBpZiB0aGVyZVxcJ3MgYSBwcm9ibGVtIHdpdGggYW55IG9mIHlvdXIgb3JkZXJzIHRocm91Z2ggb3VyIHNob3AuJyxcbiAgICAgICAgICAgICAgICBmaWVsZDogJ3Bob25lJyxcbiAgICAgICAgICAgICAgICByZXF1aXJlZDogZmFsc2UsXG4gICAgICAgICAgICAgICAgdHlwZTogJ3Bob25lJyxcbiAgICAgICAgICAgIH1cbiAgICAgICAgXSxcblxuICAgICAgICBmaWVsZHM6IHtcbiAgICAgICAgICAgIG5hbWU6ICcnLFxuICAgICAgICAgICAgZW1haWw6ICcnLFxuICAgICAgICAgICAgcGhvbmU6ICcnLFxuICAgICAgICB9LFxuXG4gICAgICAgIHZhbGlkaXR5OiB7XG4gICAgICAgICAgICBuYW1lOiBmYWxzZSxcbiAgICAgICAgICAgIGVtYWlsOiBmYWxzZSxcbiAgICAgICAgICAgIHBob25lOiB0cnVlLFxuICAgICAgICB9LFxuICAgIH0pLFxuXG4gICAgbW91bnRlZCgpIHtcbiAgICAgICAgT2JqZWN0LmtleXModGhpcy5maWVsZHMpLmZvckVhY2goKGZpZWxkKSA9PiB7XG4gICAgICAgICAgICB0aGlzLmZpZWxkc1tmaWVsZF0gPSB0aGlzW2ZpZWxkXTtcbiAgICAgICAgICAgIGNvZWxpYWMoKS4kZW1pdChgJHtmaWVsZH0tc2V0LXZhbHVlYCwgKHRoaXMuZmllbGRzW2ZpZWxkXSkpO1xuXG4gICAgICAgICAgICB0aGlzLiRyb290LiRvbihgJHtmaWVsZH0tZXJyb3JgLCAoKSA9PiB7XG4gICAgICAgICAgICAgICAgdGhpcy52YWxpZGl0eVtmaWVsZF0gPSBmYWxzZTtcbiAgICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgICB0aGlzLiRyb290LiRvbihgJHtmaWVsZH0tdmFsaWRgLCAoKSA9PiB7XG4gICAgICAgICAgICAgICAgdGhpcy52YWxpZGl0eVtmaWVsZF0gPSB0cnVlO1xuICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgIHRoaXMuJHJvb3QuJG9uKGAke2ZpZWxkfS1jaGFuZ2VgLCAodmFsdWUpID0+IHtcbiAgICAgICAgICAgICAgICB0aGlzLmZpZWxkc1tmaWVsZF0gPSB2YWx1ZTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9KTtcbiAgICB9LFxuXG4gICAgbWV0aG9kczoge1xuICAgICAgICB2YWxpZGF0ZUZvcm0oKSB7XG4gICAgICAgICAgICBPYmplY3Qua2V5cyh0aGlzLnZhbGlkaXR5KS5mb3JFYWNoKChrZXkpID0+IHtcbiAgICAgICAgICAgICAgICB0aGlzLiRyb290LiRlbWl0KGAke2tleX0tZ2V0LXZhbHVlYClcbiAgICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgICBsZXQgaXNWYWxpZCA9IHRydWU7XG5cbiAgICAgICAgICAgIE9iamVjdC5rZXlzKHRoaXMudmFsaWRpdHkpLmZvckVhY2goKGtleSkgPT4ge1xuICAgICAgICAgICAgICAgIGlmICh0aGlzLnZhbGlkaXR5W2tleV0gPT09IGZhbHNlKSB7XG4gICAgICAgICAgICAgICAgICAgIGlzVmFsaWQgPSBmYWxzZTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9KTtcblxuICAgICAgICAgICAgcmV0dXJuIGlzVmFsaWQ7XG4gICAgICAgIH1cbiAgICB9XG59XG48L3NjcmlwdD5cbiJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/Components/DashboardUserDetails.vue?vue&type=script&lang=js&\n");

/***/ }),

/***/ "./resources/js/Components/DashboardUserDetails.vue":
/*!**********************************************************!*\
  !*** ./resources/js/Components/DashboardUserDetails.vue ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => __WEBPACK_DEFAULT_EXPORT__\n/* harmony export */ });\n/* harmony import */ var _DashboardUserDetails_vue_vue_type_template_id_5d1167e4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./DashboardUserDetails.vue?vue&type=template&id=5d1167e4& */ \"./resources/js/Components/DashboardUserDetails.vue?vue&type=template&id=5d1167e4&\");\n/* harmony import */ var _DashboardUserDetails_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./DashboardUserDetails.vue?vue&type=script&lang=js& */ \"./resources/js/Components/DashboardUserDetails.vue?vue&type=script&lang=js&\");\n/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ \"./node_modules/vue-loader/lib/runtime/componentNormalizer.js\");\n\n\n\n\n\n/* normalize component */\n;\nvar component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(\n  _DashboardUserDetails_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,\n  _DashboardUserDetails_vue_vue_type_template_id_5d1167e4___WEBPACK_IMPORTED_MODULE_0__.render,\n  _DashboardUserDetails_vue_vue_type_template_id_5d1167e4___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,\n  false,\n  null,\n  null,\n  null\n  \n)\n\n/* hot reload */\nif (false) { var api; }\ncomponent.options.__file = \"resources/js/Components/DashboardUserDetails.vue\"\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvQ29tcG9uZW50cy9EYXNoYm9hcmRVc2VyRGV0YWlscy52dWU/OGI3ZSJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiOzs7Ozs7O0FBQW1HO0FBQzNCO0FBQ0w7OztBQUduRTtBQUNBLENBQTZGO0FBQzdGLGdCQUFnQixvR0FBVTtBQUMxQixFQUFFLHVGQUFNO0FBQ1IsRUFBRSw0RkFBTTtBQUNSLEVBQUUscUdBQWU7QUFDakI7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQSxJQUFJLEtBQVUsRUFBRSxZQWlCZjtBQUNEO0FBQ0EsaUVBQWUsaUIiLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvQ29tcG9uZW50cy9EYXNoYm9hcmRVc2VyRGV0YWlscy52dWUuanMiLCJzb3VyY2VzQ29udGVudCI6WyJpbXBvcnQgeyByZW5kZXIsIHN0YXRpY1JlbmRlckZucyB9IGZyb20gXCIuL0Rhc2hib2FyZFVzZXJEZXRhaWxzLnZ1ZT92dWUmdHlwZT10ZW1wbGF0ZSZpZD01ZDExNjdlNCZcIlxuaW1wb3J0IHNjcmlwdCBmcm9tIFwiLi9EYXNoYm9hcmRVc2VyRGV0YWlscy52dWU/dnVlJnR5cGU9c2NyaXB0Jmxhbmc9anMmXCJcbmV4cG9ydCAqIGZyb20gXCIuL0Rhc2hib2FyZFVzZXJEZXRhaWxzLnZ1ZT92dWUmdHlwZT1zY3JpcHQmbGFuZz1qcyZcIlxuXG5cbi8qIG5vcm1hbGl6ZSBjb21wb25lbnQgKi9cbmltcG9ydCBub3JtYWxpemVyIGZyb20gXCIhLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3J1bnRpbWUvY29tcG9uZW50Tm9ybWFsaXplci5qc1wiXG52YXIgY29tcG9uZW50ID0gbm9ybWFsaXplcihcbiAgc2NyaXB0LFxuICByZW5kZXIsXG4gIHN0YXRpY1JlbmRlckZucyxcbiAgZmFsc2UsXG4gIG51bGwsXG4gIG51bGwsXG4gIG51bGxcbiAgXG4pXG5cbi8qIGhvdCByZWxvYWQgKi9cbmlmIChtb2R1bGUuaG90KSB7XG4gIHZhciBhcGkgPSByZXF1aXJlKFwiL1VzZXJzL2phbWllcGV0ZXJzL2NvZGUvY29lbGlhYy9ub2RlX21vZHVsZXMvdnVlLWhvdC1yZWxvYWQtYXBpL2Rpc3QvaW5kZXguanNcIilcbiAgYXBpLmluc3RhbGwocmVxdWlyZSgndnVlJykpXG4gIGlmIChhcGkuY29tcGF0aWJsZSkge1xuICAgIG1vZHVsZS5ob3QuYWNjZXB0KClcbiAgICBpZiAoIWFwaS5pc1JlY29yZGVkKCc1ZDExNjdlNCcpKSB7XG4gICAgICBhcGkuY3JlYXRlUmVjb3JkKCc1ZDExNjdlNCcsIGNvbXBvbmVudC5vcHRpb25zKVxuICAgIH0gZWxzZSB7XG4gICAgICBhcGkucmVsb2FkKCc1ZDExNjdlNCcsIGNvbXBvbmVudC5vcHRpb25zKVxuICAgIH1cbiAgICBtb2R1bGUuaG90LmFjY2VwdChcIi4vRGFzaGJvYXJkVXNlckRldGFpbHMudnVlP3Z1ZSZ0eXBlPXRlbXBsYXRlJmlkPTVkMTE2N2U0JlwiLCBmdW5jdGlvbiAoKSB7XG4gICAgICBhcGkucmVyZW5kZXIoJzVkMTE2N2U0Jywge1xuICAgICAgICByZW5kZXI6IHJlbmRlcixcbiAgICAgICAgc3RhdGljUmVuZGVyRm5zOiBzdGF0aWNSZW5kZXJGbnNcbiAgICAgIH0pXG4gICAgfSlcbiAgfVxufVxuY29tcG9uZW50Lm9wdGlvbnMuX19maWxlID0gXCJyZXNvdXJjZXMvanMvQ29tcG9uZW50cy9EYXNoYm9hcmRVc2VyRGV0YWlscy52dWVcIlxuZXhwb3J0IGRlZmF1bHQgY29tcG9uZW50LmV4cG9ydHMiXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/js/Components/DashboardUserDetails.vue\n");

/***/ }),

/***/ "./resources/js/Components/DashboardUserDetails.vue?vue&type=script&lang=js&":
/*!***********************************************************************************!*\
  !*** ./resources/js/Components/DashboardUserDetails.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => __WEBPACK_DEFAULT_EXPORT__\n/* harmony export */ });\n/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_DashboardUserDetails_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./DashboardUserDetails.vue?vue&type=script&lang=js& */ \"./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/Components/DashboardUserDetails.vue?vue&type=script&lang=js&\");\n /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_DashboardUserDetails_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); //# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvQ29tcG9uZW50cy9EYXNoYm9hcmRVc2VyRGV0YWlscy52dWU/OTEwNiJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiOzs7OztBQUE4TixDQUFDLGlFQUFlLHNOQUFHLEVBQUMiLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvQ29tcG9uZW50cy9EYXNoYm9hcmRVc2VyRGV0YWlscy52dWU/dnVlJnR5cGU9c2NyaXB0Jmxhbmc9anMmLmpzIiwic291cmNlc0NvbnRlbnQiOlsiaW1wb3J0IG1vZCBmcm9tIFwiLSEuLi8uLi8uLi9ub2RlX21vZHVsZXMvYmFiZWwtbG9hZGVyL2xpYi9pbmRleC5qcz8/Y2xvbmVkUnVsZVNldC01WzBdLnJ1bGVzWzBdLnVzZVswXSEuLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvaW5kZXguanM/P3Z1ZS1sb2FkZXItb3B0aW9ucyEuL0Rhc2hib2FyZFVzZXJEZXRhaWxzLnZ1ZT92dWUmdHlwZT1zY3JpcHQmbGFuZz1qcyZcIjsgZXhwb3J0IGRlZmF1bHQgbW9kOyBleHBvcnQgKiBmcm9tIFwiLSEuLi8uLi8uLi9ub2RlX21vZHVsZXMvYmFiZWwtbG9hZGVyL2xpYi9pbmRleC5qcz8/Y2xvbmVkUnVsZVNldC01WzBdLnJ1bGVzWzBdLnVzZVswXSEuLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvaW5kZXguanM/P3Z1ZS1sb2FkZXItb3B0aW9ucyEuL0Rhc2hib2FyZFVzZXJEZXRhaWxzLnZ1ZT92dWUmdHlwZT1zY3JpcHQmbGFuZz1qcyZcIiJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/js/Components/DashboardUserDetails.vue?vue&type=script&lang=js&\n");

/***/ }),

/***/ "./resources/js/Components/DashboardUserDetails.vue?vue&type=template&id=5d1167e4&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/Components/DashboardUserDetails.vue?vue&type=template&id=5d1167e4& ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DashboardUserDetails_vue_vue_type_template_id_5d1167e4___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DashboardUserDetails_vue_vue_type_template_id_5d1167e4___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DashboardUserDetails_vue_vue_type_template_id_5d1167e4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./DashboardUserDetails.vue?vue&type=template&id=5d1167e4& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/Components/DashboardUserDetails.vue?vue&type=template&id=5d1167e4&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/Components/DashboardUserDetails.vue?vue&type=template&id=5d1167e4&":
/*!********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/Components/DashboardUserDetails.vue?vue&type=template&id=5d1167e4& ***!
  \********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"render\": () => /* binding */ render,\n/* harmony export */   \"staticRenderFns\": () => /* binding */ staticRenderFns\n/* harmony export */ });\nvar render = function() {\n  var _vm = this\n  var _h = _vm.$createElement\n  var _c = _vm._self._c || _h\n  return _c(\n    \"div\",\n    { staticClass: \"flex flex-col\" },\n    _vm._l(_vm.form, function(input) {\n      return _c(\n        \"div\",\n        { staticClass: \"py-4 border-b border-blue last:border-0\" },\n        [\n          _c(\n            \"label\",\n            {\n              staticClass: \"text-blue-dark font-semibold mb-1\",\n              attrs: { for: input.field }\n            },\n            [_vm._v(_vm._s(input.label))]\n          ),\n          _vm._v(\" \"),\n          _c(\"form-input\", {\n            attrs: {\n              id: input.field,\n              type: input.type,\n              name: input.field,\n              required: input.required,\n              value: _vm.fields[input.field]\n            }\n          }),\n          _vm._v(\" \"),\n          input.help\n            ? _c(\"span\", { staticClass: \"text-sm font-semibold\" }, [\n                _vm._v(_vm._s(input.help))\n              ])\n            : _vm._e()\n        ],\n        1\n      )\n    }),\n    0\n  )\n}\nvar staticRenderFns = []\nrender._withStripped = true\n\n//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvQ29tcG9uZW50cy9EYXNoYm9hcmRVc2VyRGV0YWlscy52dWU/ZTYzMyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiOzs7OztBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEtBQUssK0JBQStCO0FBQ3BDO0FBQ0E7QUFDQTtBQUNBLFNBQVMseURBQXlEO0FBQ2xFO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxzQkFBc0I7QUFDdEIsYUFBYTtBQUNiO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxXQUFXO0FBQ1g7QUFDQTtBQUNBLDBCQUEwQix1Q0FBdUM7QUFDakU7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7QUFDQTtBQUNBO0FBQ0EiLCJmaWxlIjoiLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvbG9hZGVycy90ZW1wbGF0ZUxvYWRlci5qcz8/dnVlLWxvYWRlci1vcHRpb25zIS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL2luZGV4LmpzPz92dWUtbG9hZGVyLW9wdGlvbnMhLi9yZXNvdXJjZXMvanMvQ29tcG9uZW50cy9EYXNoYm9hcmRVc2VyRGV0YWlscy52dWU/dnVlJnR5cGU9dGVtcGxhdGUmaWQ9NWQxMTY3ZTQmLmpzIiwic291cmNlc0NvbnRlbnQiOlsidmFyIHJlbmRlciA9IGZ1bmN0aW9uKCkge1xuICB2YXIgX3ZtID0gdGhpc1xuICB2YXIgX2ggPSBfdm0uJGNyZWF0ZUVsZW1lbnRcbiAgdmFyIF9jID0gX3ZtLl9zZWxmLl9jIHx8IF9oXG4gIHJldHVybiBfYyhcbiAgICBcImRpdlwiLFxuICAgIHsgc3RhdGljQ2xhc3M6IFwiZmxleCBmbGV4LWNvbFwiIH0sXG4gICAgX3ZtLl9sKF92bS5mb3JtLCBmdW5jdGlvbihpbnB1dCkge1xuICAgICAgcmV0dXJuIF9jKFxuICAgICAgICBcImRpdlwiLFxuICAgICAgICB7IHN0YXRpY0NsYXNzOiBcInB5LTQgYm9yZGVyLWIgYm9yZGVyLWJsdWUgbGFzdDpib3JkZXItMFwiIH0sXG4gICAgICAgIFtcbiAgICAgICAgICBfYyhcbiAgICAgICAgICAgIFwibGFiZWxcIixcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwidGV4dC1ibHVlLWRhcmsgZm9udC1zZW1pYm9sZCBtYi0xXCIsXG4gICAgICAgICAgICAgIGF0dHJzOiB7IGZvcjogaW5wdXQuZmllbGQgfVxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIFtfdm0uX3YoX3ZtLl9zKGlucHV0LmxhYmVsKSldXG4gICAgICAgICAgKSxcbiAgICAgICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgICAgIF9jKFwiZm9ybS1pbnB1dFwiLCB7XG4gICAgICAgICAgICBhdHRyczoge1xuICAgICAgICAgICAgICBpZDogaW5wdXQuZmllbGQsXG4gICAgICAgICAgICAgIHR5cGU6IGlucHV0LnR5cGUsXG4gICAgICAgICAgICAgIG5hbWU6IGlucHV0LmZpZWxkLFxuICAgICAgICAgICAgICByZXF1aXJlZDogaW5wdXQucmVxdWlyZWQsXG4gICAgICAgICAgICAgIHZhbHVlOiBfdm0uZmllbGRzW2lucHV0LmZpZWxkXVxuICAgICAgICAgICAgfVxuICAgICAgICAgIH0pLFxuICAgICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgICAgaW5wdXQuaGVscFxuICAgICAgICAgICAgPyBfYyhcInNwYW5cIiwgeyBzdGF0aWNDbGFzczogXCJ0ZXh0LXNtIGZvbnQtc2VtaWJvbGRcIiB9LCBbXG4gICAgICAgICAgICAgICAgX3ZtLl92KF92bS5fcyhpbnB1dC5oZWxwKSlcbiAgICAgICAgICAgICAgXSlcbiAgICAgICAgICAgIDogX3ZtLl9lKClcbiAgICAgICAgXSxcbiAgICAgICAgMVxuICAgICAgKVxuICAgIH0pLFxuICAgIDBcbiAgKVxufVxudmFyIHN0YXRpY1JlbmRlckZucyA9IFtdXG5yZW5kZXIuX3dpdGhTdHJpcHBlZCA9IHRydWVcblxuZXhwb3J0IHsgcmVuZGVyLCBzdGF0aWNSZW5kZXJGbnMgfSJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/Components/DashboardUserDetails.vue?vue&type=template&id=5d1167e4&\n");

/***/ })

}]);