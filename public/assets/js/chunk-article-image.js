<<<<<<< develop
(self.webpackChunk=self.webpackChunk||[]).push([[4650],{9081:(t,e,o)=>{"use strict";o.d(e,{Z:()=>n});const n={methods:{googleEvent:function(t,e){var o=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};window.gtag&&window.gtag(t,e,o)}}}},2394:(t,e,o)=>{"use strict";o.d(e,{Z:()=>n});o(2732);const n={methods:{loadLazyImages:function(){coeliac().updateLazyloader()}},computed:{lazyLoadSrc:function(){return"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"}}}},4277:(t,e,o)=>{"use strict";o.r(e),o.d(e,{default:()=>i});var n=o(2394);const s={mixins:[o(9081).Z,n.Z],components:{modal:function(){return o.e(5441).then(o.bind(o,622))}},props:{src:{required:!0,type:String},title:{type:String,default:null},position:{type:String,default:"left"}},data:function(){return{zoom:!1}},mounted:function(){var t=this;this.$root.$on("modal-closed",(function(){t.zoom=!1})),this.loadLazyImages()},computed:{classMap:function(){var t=["w-auto","p-2","mx-0","my-2","sm:m-2","bg-blue-20"];return"fullwidth"!==this.position&&t.push("sm:max-w-1/2","lg:max-w-2/5"),"left"===this.position&&t.push("sm:ml-0","float-left"),"right"===this.position&&t.push("sm:mr-0","float-right"),t}},watch:{zoom:function(){this.zoom&&this.googleEvent("event","article",{event_category:"viewed-image",event_label:this.src})}}};const i=(0,o(1900).Z)(s,(function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",[o("div",{class:t.classMap},[o("img",{staticClass:"lazy w-full h-auto",staticStyle:{cursor:"zoom-in"},attrs:{"data-src":t.src,src:t.lazyLoadSrc,alt:t.title,loading:"lazy"},on:{click:function(e){t.zoom=!0}}}),t._v(" "),t.title?o("div",{staticClass:"text-center text-sm mt-2 leading-none"},[t._v(t._s(t.title))]):t._e()]),t._v(" "),t.zoom?o("portal",{attrs:{to:"modal"}},[o("modal",[o("img",{staticClass:"max-w-full",attrs:{src:t.src,alt:t.title}}),t._v(" "),t.title?o("div",{staticClass:"text-center text-sm mt-2 leading-none"},[t._v(t._s(t.title))]):t._e()])],1):t._e()],1)}),[],!1,null,null,null).exports},1900:(t,e,o)=>{"use strict";function n(t,e,o,n,s,i,a,r){var l,c="function"==typeof t?t.options:t;if(e&&(c.render=e,c.staticRenderFns=o,c._compiled=!0),n&&(c.functional=!0),i&&(c._scopeId="data-v-"+i),a?(l=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),s&&s.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(a)},c._ssrRegister=l):s&&(l=r?function(){s.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:s),l)if(c.functional){c._injectStyles=l;var d=c.render;c.render=function(t,e){return l.call(e),d(t,e)}}else{var u=c.beforeCreate;c.beforeCreate=u?[].concat(u,l):[l]}return{exports:t,options:c}}o.d(e,{Z:()=>n})}}]);
=======
/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(self["webpackChunk"] = self["webpackChunk"] || []).push([["chunk-article-image"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/Components/ArticleImage.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/Components/ArticleImage.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => __WEBPACK_DEFAULT_EXPORT__\n/* harmony export */ });\n/* harmony import */ var _Mixins_LazyLoadsImages__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../Mixins/LazyLoadsImages */ \"./resources/js/Mixins/LazyLoadsImages.js\");\n/* harmony import */ var _Mixins_GoogleEvents__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../Mixins/GoogleEvents */ \"./resources/js/Mixins/GoogleEvents.js\");\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n\n\n\nvar Modal = function Modal() {\n  return __webpack_require__.e(/*! import() | chunk-modal */ \"chunk-modal\").then(__webpack_require__.bind(__webpack_require__, /*! ./Modal */ \"./resources/js/Components/Modal.vue\"));\n};\n\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({\n  mixins: [_Mixins_GoogleEvents__WEBPACK_IMPORTED_MODULE_1__.default, _Mixins_LazyLoadsImages__WEBPACK_IMPORTED_MODULE_0__.default],\n  components: {\n    'modal': Modal\n  },\n  props: {\n    src: {\n      required: true,\n      type: String\n    },\n    title: {\n      type: String,\n      \"default\": null\n    },\n    position: {\n      type: String,\n      \"default\": 'left'\n    }\n  },\n  data: function data() {\n    return {\n      zoom: false\n    };\n  },\n  mounted: function mounted() {\n    var _this = this;\n\n    this.$root.$on('modal-closed', function () {\n      _this.zoom = false;\n    });\n    this.loadLazyImages();\n  },\n  computed: {\n    classMap: function classMap() {\n      var classes = ['w-auto', 'p-2', 'mx-0', 'my-2', 'sm:m-2', 'bg-blue-20'];\n\n      if (this.position !== 'fullwidth') {\n        classes.push('sm:max-w-1/2', 'lg:max-w-2/5');\n      }\n\n      if (this.position === 'left') {\n        classes.push('sm:ml-0', 'float-left');\n      }\n\n      if (this.position === 'right') {\n        classes.push('sm:mr-0', 'float-right');\n      }\n\n      return classes;\n    }\n  },\n  watch: {\n    zoom: function zoom() {\n      if (this.zoom) {\n        this.googleEvent('event', 'article', {\n          event_category: 'viewed-image',\n          event_label: this.src\n        });\n      }\n    }\n  }\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vcmVzb3VyY2VzL2pzL0NvbXBvbmVudHMvQXJ0aWNsZUltYWdlLnZ1ZT81NTcyIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7QUFpQkE7QUFDQTs7QUFDQTtBQUFBO0FBQUE7O0FBRUE7QUFDQSxtSUFEQTtBQUdBO0FBQ0E7QUFEQSxHQUhBO0FBT0E7QUFDQTtBQUNBLG9CQURBO0FBRUE7QUFGQSxLQURBO0FBS0E7QUFDQSxrQkFEQTtBQUVBO0FBRkEsS0FMQTtBQVNBO0FBQ0Esa0JBREE7QUFFQTtBQUZBO0FBVEEsR0FQQTtBQXNCQTtBQUFBO0FBQ0E7QUFEQTtBQUFBLEdBdEJBO0FBMEJBLFNBMUJBLHFCQTBCQTtBQUFBOztBQUNBO0FBQ0E7QUFDQSxLQUZBO0FBSUE7QUFDQSxHQWhDQTtBQWtDQTtBQUNBLFlBREEsc0JBQ0E7QUFDQSxxQkFDQSxRQURBLEVBRUEsS0FGQSxFQUdBLE1BSEEsRUFJQSxNQUpBLEVBS0EsUUFMQSxFQU1BLFlBTkE7O0FBU0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQXhCQSxHQWxDQTtBQTZEQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLHdDQURBO0FBRUE7QUFGQTtBQUlBO0FBQ0E7QUFSQTtBQTdEQSIsImZpbGUiOiIuL25vZGVfbW9kdWxlcy9iYWJlbC1sb2FkZXIvbGliL2luZGV4LmpzPz9jbG9uZWRSdWxlU2V0LTVbMF0ucnVsZXNbMF0udXNlWzBdIS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL2luZGV4LmpzPz92dWUtbG9hZGVyLW9wdGlvbnMhLi9yZXNvdXJjZXMvanMvQ29tcG9uZW50cy9BcnRpY2xlSW1hZ2UudnVlP3Z1ZSZ0eXBlPXNjcmlwdCZsYW5nPWpzJi5qcyIsInNvdXJjZXNDb250ZW50IjpbIjx0ZW1wbGF0ZT5cbiAgICA8ZGl2PlxuICAgICAgICA8ZGl2IDpjbGFzcz1cImNsYXNzTWFwXCI+XG4gICAgICAgICAgICA8aW1nIDpkYXRhLXNyYz1cInNyY1wiIDpzcmM9XCJsYXp5TG9hZFNyY1wiIDphbHQ9XCJ0aXRsZVwiIGxvYWRpbmc9XCJsYXp5XCIgY2xhc3M9XCJsYXp5IHctZnVsbCBoLWF1dG9cIiBzdHlsZT1cImN1cnNvcjogem9vbS1pblwiIEBjbGljaz1cInpvb20gPSB0cnVlXCIvPlxuICAgICAgICAgICAgPGRpdiB2LWlmPVwidGl0bGVcIiBjbGFzcz1cInRleHQtY2VudGVyIHRleHQtc20gbXQtMiBsZWFkaW5nLW5vbmVcIj57eyB0aXRsZSB9fTwvZGl2PlxuICAgICAgICA8L2Rpdj5cblxuICAgICAgICA8cG9ydGFsIHRvPVwibW9kYWxcIiB2LWlmPVwiem9vbVwiPlxuICAgICAgICAgICAgPG1vZGFsPlxuICAgICAgICAgICAgICAgIDxpbWcgOnNyYz1cInNyY1wiIDphbHQ9XCJ0aXRsZVwiIGNsYXNzPVwibWF4LXctZnVsbFwiIC8+XG4gICAgICAgICAgICAgICAgPGRpdiB2LWlmPVwidGl0bGVcIiBjbGFzcz1cInRleHQtY2VudGVyIHRleHQtc20gbXQtMiBsZWFkaW5nLW5vbmVcIj57eyB0aXRsZSB9fTwvZGl2PlxuICAgICAgICAgICAgPC9tb2RhbD5cbiAgICAgICAgPC9wb3J0YWw+XG4gICAgPC9kaXY+XG48L3RlbXBsYXRlPlxuXG48c2NyaXB0PlxuICAgIGltcG9ydCBMYXp5TG9hZHNJbWFnZXMgZnJvbSBcIi4uL01peGlucy9MYXp5TG9hZHNJbWFnZXNcIjtcbiAgICBpbXBvcnQgR29vZ2xlRXZlbnRzIGZyb20gXCIuLi9NaXhpbnMvR29vZ2xlRXZlbnRzXCI7XG4gICAgY29uc3QgTW9kYWwgPSAoKSA9PiBpbXBvcnQoJy4vTW9kYWwnIC8qIHdlYnBhY2tDaHVua05hbWU6IFwiY2h1bmstbW9kYWxcIiAqLylcblxuICAgIGV4cG9ydCBkZWZhdWx0IHtcbiAgICAgICAgbWl4aW5zOiBbR29vZ2xlRXZlbnRzLCBMYXp5TG9hZHNJbWFnZXNdLFxuXG4gICAgICAgIGNvbXBvbmVudHM6IHtcbiAgICAgICAgICAgICdtb2RhbCc6IE1vZGFsLFxuICAgICAgICB9LFxuXG4gICAgICAgIHByb3BzOiB7XG4gICAgICAgICAgICBzcmM6IHtcbiAgICAgICAgICAgICAgICByZXF1aXJlZDogdHJ1ZSxcbiAgICAgICAgICAgICAgICB0eXBlOiBTdHJpbmcsXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgdGl0bGU6IHtcbiAgICAgICAgICAgICAgICB0eXBlOiBTdHJpbmcsXG4gICAgICAgICAgICAgICAgZGVmYXVsdDogbnVsbCxcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBwb3NpdGlvbjoge1xuICAgICAgICAgICAgICAgIHR5cGU6IFN0cmluZyxcbiAgICAgICAgICAgICAgICBkZWZhdWx0OiAnbGVmdCcsXG4gICAgICAgICAgICB9XG4gICAgICAgIH0sXG5cbiAgICAgICAgZGF0YTogKCkgPT4gKHtcbiAgICAgICAgICAgem9vbTogZmFsc2UsXG4gICAgICAgIH0pLFxuXG4gICAgICAgIG1vdW50ZWQoKSB7XG4gICAgICAgICAgICB0aGlzLiRyb290LiRvbignbW9kYWwtY2xvc2VkJywgKCkgPT4ge1xuICAgICAgICAgICAgICAgIHRoaXMuem9vbSA9IGZhbHNlO1xuICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgIHRoaXMubG9hZExhenlJbWFnZXMoKTtcbiAgICAgICAgfSxcblxuICAgICAgICBjb21wdXRlZDoge1xuICAgICAgICAgICAgY2xhc3NNYXAoKSB7XG4gICAgICAgICAgICAgICAgY29uc3QgY2xhc3NlcyA9IFtcbiAgICAgICAgICAgICAgICAgICAgJ3ctYXV0bycsXG4gICAgICAgICAgICAgICAgICAgICdwLTInLFxuICAgICAgICAgICAgICAgICAgICAnbXgtMCcsXG4gICAgICAgICAgICAgICAgICAgICdteS0yJyxcbiAgICAgICAgICAgICAgICAgICAgJ3NtOm0tMicsXG4gICAgICAgICAgICAgICAgICAgICdiZy1ibHVlLTIwJyxcbiAgICAgICAgICAgICAgICBdO1xuXG4gICAgICAgICAgICAgICAgaWYodGhpcy5wb3NpdGlvbiAhPT0gJ2Z1bGx3aWR0aCcpIHtcbiAgICAgICAgICAgICAgICAgICAgY2xhc3Nlcy5wdXNoKCdzbTptYXgtdy0xLzInLCAnbGc6bWF4LXctMi81Jyk7XG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgaWYodGhpcy5wb3NpdGlvbiA9PT0gJ2xlZnQnKSB7XG4gICAgICAgICAgICAgICAgICAgIGNsYXNzZXMucHVzaCgnc206bWwtMCcsICdmbG9hdC1sZWZ0JylcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICBpZih0aGlzLnBvc2l0aW9uID09PSAncmlnaHQnKSB7XG4gICAgICAgICAgICAgICAgICAgIGNsYXNzZXMucHVzaCgnc206bXItMCcsICdmbG9hdC1yaWdodCcpO1xuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIHJldHVybiBjbGFzc2VzO1xuICAgICAgICAgICAgfVxuICAgICAgICB9LFxuXG4gICAgICAgIHdhdGNoOiB7XG4gICAgICAgICAgICB6b29tOiBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICBpZih0aGlzLnpvb20pIHtcbiAgICAgICAgICAgICAgICAgICAgdGhpcy5nb29nbGVFdmVudCgnZXZlbnQnLCAnYXJ0aWNsZScsIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIGV2ZW50X2NhdGVnb3J5OiAndmlld2VkLWltYWdlJyxcbiAgICAgICAgICAgICAgICAgICAgICAgIGV2ZW50X2xhYmVsOiB0aGlzLnNyYyxcbiAgICAgICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuICAgICAgICB9XG4gICAgfVxuPC9zY3JpcHQ+XG4iXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/Components/ArticleImage.vue?vue&type=script&lang=js&\n");

/***/ }),

/***/ "./resources/js/Mixins/GoogleEvents.js":
/*!*********************************************!*\
  !*** ./resources/js/Mixins/GoogleEvents.js ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => __WEBPACK_DEFAULT_EXPORT__\n/* harmony export */ });\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({\n  methods: {\n    googleEvent: function googleEvent(key, event) {\n      var attributes = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};\n\n      if (!window.gtag) {\n        return;\n      }\n\n      window.gtag(key, event, attributes);\n    }\n  }\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvTWl4aW5zL0dvb2dsZUV2ZW50cy5qcz9jNWYwIl0sIm5hbWVzIjpbIm1ldGhvZHMiLCJnb29nbGVFdmVudCIsImtleSIsImV2ZW50IiwiYXR0cmlidXRlcyIsIndpbmRvdyIsImd0YWciXSwibWFwcGluZ3MiOiI7Ozs7QUFBQSxpRUFBZTtBQUNYQSxTQUFPLEVBQUU7QUFDTEMsZUFESyx1QkFDT0MsR0FEUCxFQUNZQyxLQURaLEVBQ29DO0FBQUEsVUFBakJDLFVBQWlCLHVFQUFKLEVBQUk7O0FBQ3JDLFVBQUksQ0FBQ0MsTUFBTSxDQUFDQyxJQUFaLEVBQWtCO0FBQ2Q7QUFDSDs7QUFFREQsWUFBTSxDQUFDQyxJQUFQLENBQVlKLEdBQVosRUFBaUJDLEtBQWpCLEVBQXdCQyxVQUF4QjtBQUNIO0FBUEk7QUFERSxDQUFmIiwiZmlsZSI6Ii4vcmVzb3VyY2VzL2pzL01peGlucy9Hb29nbGVFdmVudHMuanMuanMiLCJzb3VyY2VzQ29udGVudCI6WyJleHBvcnQgZGVmYXVsdCB7XG4gICAgbWV0aG9kczoge1xuICAgICAgICBnb29nbGVFdmVudChrZXksIGV2ZW50LCBhdHRyaWJ1dGVzID0ge30pIHtcbiAgICAgICAgICAgIGlmICghd2luZG93Lmd0YWcpIHtcbiAgICAgICAgICAgICAgICByZXR1cm47XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIHdpbmRvdy5ndGFnKGtleSwgZXZlbnQsIGF0dHJpYnV0ZXMpO1xuICAgICAgICB9XG4gICAgfVxufVxuIl0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/Mixins/GoogleEvents.js\n");

/***/ }),

/***/ "./resources/js/Mixins/LazyLoadsImages.js":
/*!************************************************!*\
  !*** ./resources/js/Mixins/LazyLoadsImages.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => __WEBPACK_DEFAULT_EXPORT__\n/* harmony export */ });\n/* harmony import */ var vanilla_lazyload__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vanilla-lazyload */ \"./node_modules/vanilla-lazyload/dist/lazyload.min.js\");\n/* harmony import */ var vanilla_lazyload__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vanilla_lazyload__WEBPACK_IMPORTED_MODULE_0__);\n\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({\n  methods: {\n    loadLazyImages: function loadLazyImages() {\n      coeliac().updateLazyloader();\n    }\n  },\n  computed: {\n    lazyLoadSrc: function lazyLoadSrc() {\n      return \"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E\";\n    }\n  }\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvTWl4aW5zL0xhenlMb2Fkc0ltYWdlcy5qcz9iMGJjIl0sIm5hbWVzIjpbIm1ldGhvZHMiLCJsb2FkTGF6eUltYWdlcyIsImNvZWxpYWMiLCJ1cGRhdGVMYXp5bG9hZGVyIiwiY29tcHV0ZWQiLCJsYXp5TG9hZFNyYyJdLCJtYXBwaW5ncyI6Ijs7Ozs7O0FBQUE7QUFFQSxpRUFBZTtBQUNYQSxTQUFPLEVBQUU7QUFDTEMsa0JBREssNEJBQ1k7QUFDYkMsYUFBTyxHQUFHQyxnQkFBVjtBQUNIO0FBSEksR0FERTtBQU9YQyxVQUFRLEVBQUU7QUFDTkMsZUFBVyxFQUFFLHVCQUFXO0FBQ3BCO0FBQ0g7QUFISztBQVBDLENBQWYiLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvTWl4aW5zL0xhenlMb2Fkc0ltYWdlcy5qcy5qcyIsInNvdXJjZXNDb250ZW50IjpbImltcG9ydCBMYXp5TG9hZCBmcm9tIFwidmFuaWxsYS1sYXp5bG9hZFwiO1xuXG5leHBvcnQgZGVmYXVsdCB7XG4gICAgbWV0aG9kczoge1xuICAgICAgICBsb2FkTGF6eUltYWdlcygpIHtcbiAgICAgICAgICAgIGNvZWxpYWMoKS51cGRhdGVMYXp5bG9hZGVyKCk7XG4gICAgICAgIH1cbiAgICB9LFxuXG4gICAgY29tcHV0ZWQ6IHtcbiAgICAgICAgbGF6eUxvYWRTcmM6IGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgcmV0dXJuIGBkYXRhOmltYWdlL3N2Zyt4bWwsJTNDc3ZnIHhtbG5zPSdodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2Zycgdmlld0JveD0nMCAwIDggMiclM0UlM0Mvc3ZnJTNFYDtcbiAgICAgICAgfVxuICAgIH1cbn1cbiJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/js/Mixins/LazyLoadsImages.js\n");

/***/ }),

/***/ "./resources/js/Components/ArticleImage.vue":
/*!**************************************************!*\
  !*** ./resources/js/Components/ArticleImage.vue ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => __WEBPACK_DEFAULT_EXPORT__\n/* harmony export */ });\n/* harmony import */ var _ArticleImage_vue_vue_type_template_id_57236750___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ArticleImage.vue?vue&type=template&id=57236750& */ \"./resources/js/Components/ArticleImage.vue?vue&type=template&id=57236750&\");\n/* harmony import */ var _ArticleImage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ArticleImage.vue?vue&type=script&lang=js& */ \"./resources/js/Components/ArticleImage.vue?vue&type=script&lang=js&\");\n/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ \"./node_modules/vue-loader/lib/runtime/componentNormalizer.js\");\n\n\n\n\n\n/* normalize component */\n;\nvar component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(\n  _ArticleImage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,\n  _ArticleImage_vue_vue_type_template_id_57236750___WEBPACK_IMPORTED_MODULE_0__.render,\n  _ArticleImage_vue_vue_type_template_id_57236750___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,\n  false,\n  null,\n  null,\n  null\n  \n)\n\n/* hot reload */\nif (false) { var api; }\ncomponent.options.__file = \"resources/js/Components/ArticleImage.vue\"\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvQ29tcG9uZW50cy9BcnRpY2xlSW1hZ2UudnVlPzkxMjMiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6Ijs7Ozs7OztBQUEyRjtBQUMzQjtBQUNMOzs7QUFHM0Q7QUFDQSxDQUE2RjtBQUM3RixnQkFBZ0Isb0dBQVU7QUFDMUIsRUFBRSwrRUFBTTtBQUNSLEVBQUUsb0ZBQU07QUFDUixFQUFFLDZGQUFlO0FBQ2pCO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0EsSUFBSSxLQUFVLEVBQUUsWUFpQmY7QUFDRDtBQUNBLGlFQUFlLGlCIiwiZmlsZSI6Ii4vcmVzb3VyY2VzL2pzL0NvbXBvbmVudHMvQXJ0aWNsZUltYWdlLnZ1ZS5qcyIsInNvdXJjZXNDb250ZW50IjpbImltcG9ydCB7IHJlbmRlciwgc3RhdGljUmVuZGVyRm5zIH0gZnJvbSBcIi4vQXJ0aWNsZUltYWdlLnZ1ZT92dWUmdHlwZT10ZW1wbGF0ZSZpZD01NzIzNjc1MCZcIlxuaW1wb3J0IHNjcmlwdCBmcm9tIFwiLi9BcnRpY2xlSW1hZ2UudnVlP3Z1ZSZ0eXBlPXNjcmlwdCZsYW5nPWpzJlwiXG5leHBvcnQgKiBmcm9tIFwiLi9BcnRpY2xlSW1hZ2UudnVlP3Z1ZSZ0eXBlPXNjcmlwdCZsYW5nPWpzJlwiXG5cblxuLyogbm9ybWFsaXplIGNvbXBvbmVudCAqL1xuaW1wb3J0IG5vcm1hbGl6ZXIgZnJvbSBcIiEuLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvcnVudGltZS9jb21wb25lbnROb3JtYWxpemVyLmpzXCJcbnZhciBjb21wb25lbnQgPSBub3JtYWxpemVyKFxuICBzY3JpcHQsXG4gIHJlbmRlcixcbiAgc3RhdGljUmVuZGVyRm5zLFxuICBmYWxzZSxcbiAgbnVsbCxcbiAgbnVsbCxcbiAgbnVsbFxuICBcbilcblxuLyogaG90IHJlbG9hZCAqL1xuaWYgKG1vZHVsZS5ob3QpIHtcbiAgdmFyIGFwaSA9IHJlcXVpcmUoXCIvVXNlcnMvamFtaWVwZXRlcnMvY29kZS9jb2VsaWFjL25vZGVfbW9kdWxlcy92dWUtaG90LXJlbG9hZC1hcGkvZGlzdC9pbmRleC5qc1wiKVxuICBhcGkuaW5zdGFsbChyZXF1aXJlKCd2dWUnKSlcbiAgaWYgKGFwaS5jb21wYXRpYmxlKSB7XG4gICAgbW9kdWxlLmhvdC5hY2NlcHQoKVxuICAgIGlmICghYXBpLmlzUmVjb3JkZWQoJzU3MjM2NzUwJykpIHtcbiAgICAgIGFwaS5jcmVhdGVSZWNvcmQoJzU3MjM2NzUwJywgY29tcG9uZW50Lm9wdGlvbnMpXG4gICAgfSBlbHNlIHtcbiAgICAgIGFwaS5yZWxvYWQoJzU3MjM2NzUwJywgY29tcG9uZW50Lm9wdGlvbnMpXG4gICAgfVxuICAgIG1vZHVsZS5ob3QuYWNjZXB0KFwiLi9BcnRpY2xlSW1hZ2UudnVlP3Z1ZSZ0eXBlPXRlbXBsYXRlJmlkPTU3MjM2NzUwJlwiLCBmdW5jdGlvbiAoKSB7XG4gICAgICBhcGkucmVyZW5kZXIoJzU3MjM2NzUwJywge1xuICAgICAgICByZW5kZXI6IHJlbmRlcixcbiAgICAgICAgc3RhdGljUmVuZGVyRm5zOiBzdGF0aWNSZW5kZXJGbnNcbiAgICAgIH0pXG4gICAgfSlcbiAgfVxufVxuY29tcG9uZW50Lm9wdGlvbnMuX19maWxlID0gXCJyZXNvdXJjZXMvanMvQ29tcG9uZW50cy9BcnRpY2xlSW1hZ2UudnVlXCJcbmV4cG9ydCBkZWZhdWx0IGNvbXBvbmVudC5leHBvcnRzIl0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/Components/ArticleImage.vue\n");

/***/ }),

/***/ "./resources/js/Components/ArticleImage.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./resources/js/Components/ArticleImage.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => __WEBPACK_DEFAULT_EXPORT__\n/* harmony export */ });\n/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ArticleImage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ArticleImage.vue?vue&type=script&lang=js& */ \"./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/Components/ArticleImage.vue?vue&type=script&lang=js&\");\n /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ArticleImage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); //# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvQ29tcG9uZW50cy9BcnRpY2xlSW1hZ2UudnVlP2NjODEiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6Ijs7Ozs7QUFBc04sQ0FBQyxpRUFBZSw4TUFBRyxFQUFDIiwiZmlsZSI6Ii4vcmVzb3VyY2VzL2pzL0NvbXBvbmVudHMvQXJ0aWNsZUltYWdlLnZ1ZT92dWUmdHlwZT1zY3JpcHQmbGFuZz1qcyYuanMiLCJzb3VyY2VzQ29udGVudCI6WyJpbXBvcnQgbW9kIGZyb20gXCItIS4uLy4uLy4uL25vZGVfbW9kdWxlcy9iYWJlbC1sb2FkZXIvbGliL2luZGV4LmpzPz9jbG9uZWRSdWxlU2V0LTVbMF0ucnVsZXNbMF0udXNlWzBdIS4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9pbmRleC5qcz8/dnVlLWxvYWRlci1vcHRpb25zIS4vQXJ0aWNsZUltYWdlLnZ1ZT92dWUmdHlwZT1zY3JpcHQmbGFuZz1qcyZcIjsgZXhwb3J0IGRlZmF1bHQgbW9kOyBleHBvcnQgKiBmcm9tIFwiLSEuLi8uLi8uLi9ub2RlX21vZHVsZXMvYmFiZWwtbG9hZGVyL2xpYi9pbmRleC5qcz8/Y2xvbmVkUnVsZVNldC01WzBdLnJ1bGVzWzBdLnVzZVswXSEuLi8uLi8uLi9ub2RlX21vZHVsZXMvdnVlLWxvYWRlci9saWIvaW5kZXguanM/P3Z1ZS1sb2FkZXItb3B0aW9ucyEuL0FydGljbGVJbWFnZS52dWU/dnVlJnR5cGU9c2NyaXB0Jmxhbmc9anMmXCIiXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/js/Components/ArticleImage.vue?vue&type=script&lang=js&\n");

/***/ }),

/***/ "./resources/js/Components/ArticleImage.vue?vue&type=template&id=57236750&":
/*!*********************************************************************************!*\
  !*** ./resources/js/Components/ArticleImage.vue?vue&type=template&id=57236750& ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ArticleImage_vue_vue_type_template_id_57236750___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ArticleImage_vue_vue_type_template_id_57236750___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ArticleImage_vue_vue_type_template_id_57236750___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ArticleImage.vue?vue&type=template&id=57236750& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/Components/ArticleImage.vue?vue&type=template&id=57236750&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/Components/ArticleImage.vue?vue&type=template&id=57236750&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/Components/ArticleImage.vue?vue&type=template&id=57236750& ***!
  \************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"render\": () => /* binding */ render,\n/* harmony export */   \"staticRenderFns\": () => /* binding */ staticRenderFns\n/* harmony export */ });\nvar render = function() {\n  var _vm = this\n  var _h = _vm.$createElement\n  var _c = _vm._self._c || _h\n  return _c(\n    \"div\",\n    [\n      _c(\"div\", { class: _vm.classMap }, [\n        _c(\"img\", {\n          staticClass: \"lazy w-full h-auto\",\n          staticStyle: { cursor: \"zoom-in\" },\n          attrs: {\n            \"data-src\": _vm.src,\n            src: _vm.lazyLoadSrc,\n            alt: _vm.title,\n            loading: \"lazy\"\n          },\n          on: {\n            click: function($event) {\n              _vm.zoom = true\n            }\n          }\n        }),\n        _vm._v(\" \"),\n        _vm.title\n          ? _c(\n              \"div\",\n              { staticClass: \"text-center text-sm mt-2 leading-none\" },\n              [_vm._v(_vm._s(_vm.title))]\n            )\n          : _vm._e()\n      ]),\n      _vm._v(\" \"),\n      _vm.zoom\n        ? _c(\n            \"portal\",\n            { attrs: { to: \"modal\" } },\n            [\n              _c(\"modal\", [\n                _c(\"img\", {\n                  staticClass: \"max-w-full\",\n                  attrs: { src: _vm.src, alt: _vm.title }\n                }),\n                _vm._v(\" \"),\n                _vm.title\n                  ? _c(\n                      \"div\",\n                      { staticClass: \"text-center text-sm mt-2 leading-none\" },\n                      [_vm._v(_vm._s(_vm.title))]\n                    )\n                  : _vm._e()\n              ])\n            ],\n            1\n          )\n        : _vm._e()\n    ],\n    1\n  )\n}\nvar staticRenderFns = []\nrender._withStripped = true\n\n//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvQ29tcG9uZW50cy9BcnRpY2xlSW1hZ2UudnVlPzliYzkiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6Ijs7Ozs7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLGlCQUFpQixzQkFBc0I7QUFDdkM7QUFDQTtBQUNBLHdCQUF3QixvQkFBb0I7QUFDNUM7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLFdBQVc7QUFDWDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsU0FBUztBQUNUO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsZUFBZSx1REFBdUQ7QUFDdEU7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLGFBQWEsU0FBUyxjQUFjLEVBQUU7QUFDdEM7QUFDQTtBQUNBO0FBQ0E7QUFDQSwwQkFBMEI7QUFDMUIsaUJBQWlCO0FBQ2pCO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsdUJBQXVCLHVEQUF1RDtBQUM5RTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBIiwiZmlsZSI6Ii4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL2xvYWRlcnMvdGVtcGxhdGVMb2FkZXIuanM/P3Z1ZS1sb2FkZXItb3B0aW9ucyEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9pbmRleC5qcz8/dnVlLWxvYWRlci1vcHRpb25zIS4vcmVzb3VyY2VzL2pzL0NvbXBvbmVudHMvQXJ0aWNsZUltYWdlLnZ1ZT92dWUmdHlwZT10ZW1wbGF0ZSZpZD01NzIzNjc1MCYuanMiLCJzb3VyY2VzQ29udGVudCI6WyJ2YXIgcmVuZGVyID0gZnVuY3Rpb24oKSB7XG4gIHZhciBfdm0gPSB0aGlzXG4gIHZhciBfaCA9IF92bS4kY3JlYXRlRWxlbWVudFxuICB2YXIgX2MgPSBfdm0uX3NlbGYuX2MgfHwgX2hcbiAgcmV0dXJuIF9jKFxuICAgIFwiZGl2XCIsXG4gICAgW1xuICAgICAgX2MoXCJkaXZcIiwgeyBjbGFzczogX3ZtLmNsYXNzTWFwIH0sIFtcbiAgICAgICAgX2MoXCJpbWdcIiwge1xuICAgICAgICAgIHN0YXRpY0NsYXNzOiBcImxhenkgdy1mdWxsIGgtYXV0b1wiLFxuICAgICAgICAgIHN0YXRpY1N0eWxlOiB7IGN1cnNvcjogXCJ6b29tLWluXCIgfSxcbiAgICAgICAgICBhdHRyczoge1xuICAgICAgICAgICAgXCJkYXRhLXNyY1wiOiBfdm0uc3JjLFxuICAgICAgICAgICAgc3JjOiBfdm0ubGF6eUxvYWRTcmMsXG4gICAgICAgICAgICBhbHQ6IF92bS50aXRsZSxcbiAgICAgICAgICAgIGxvYWRpbmc6IFwibGF6eVwiXG4gICAgICAgICAgfSxcbiAgICAgICAgICBvbjoge1xuICAgICAgICAgICAgY2xpY2s6IGZ1bmN0aW9uKCRldmVudCkge1xuICAgICAgICAgICAgICBfdm0uem9vbSA9IHRydWVcbiAgICAgICAgICAgIH1cbiAgICAgICAgICB9XG4gICAgICAgIH0pLFxuICAgICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgICBfdm0udGl0bGVcbiAgICAgICAgICA/IF9jKFxuICAgICAgICAgICAgICBcImRpdlwiLFxuICAgICAgICAgICAgICB7IHN0YXRpY0NsYXNzOiBcInRleHQtY2VudGVyIHRleHQtc20gbXQtMiBsZWFkaW5nLW5vbmVcIiB9LFxuICAgICAgICAgICAgICBbX3ZtLl92KF92bS5fcyhfdm0udGl0bGUpKV1cbiAgICAgICAgICAgIClcbiAgICAgICAgICA6IF92bS5fZSgpXG4gICAgICBdKSxcbiAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICBfdm0uem9vbVxuICAgICAgICA/IF9jKFxuICAgICAgICAgICAgXCJwb3J0YWxcIixcbiAgICAgICAgICAgIHsgYXR0cnM6IHsgdG86IFwibW9kYWxcIiB9IH0sXG4gICAgICAgICAgICBbXG4gICAgICAgICAgICAgIF9jKFwibW9kYWxcIiwgW1xuICAgICAgICAgICAgICAgIF9jKFwiaW1nXCIsIHtcbiAgICAgICAgICAgICAgICAgIHN0YXRpY0NsYXNzOiBcIm1heC13LWZ1bGxcIixcbiAgICAgICAgICAgICAgICAgIGF0dHJzOiB7IHNyYzogX3ZtLnNyYywgYWx0OiBfdm0udGl0bGUgfVxuICAgICAgICAgICAgICAgIH0pLFxuICAgICAgICAgICAgICAgIF92bS5fdihcIiBcIiksXG4gICAgICAgICAgICAgICAgX3ZtLnRpdGxlXG4gICAgICAgICAgICAgICAgICA/IF9jKFxuICAgICAgICAgICAgICAgICAgICAgIFwiZGl2XCIsXG4gICAgICAgICAgICAgICAgICAgICAgeyBzdGF0aWNDbGFzczogXCJ0ZXh0LWNlbnRlciB0ZXh0LXNtIG10LTIgbGVhZGluZy1ub25lXCIgfSxcbiAgICAgICAgICAgICAgICAgICAgICBbX3ZtLl92KF92bS5fcyhfdm0udGl0bGUpKV1cbiAgICAgICAgICAgICAgICAgICAgKVxuICAgICAgICAgICAgICAgICAgOiBfdm0uX2UoKVxuICAgICAgICAgICAgICBdKVxuICAgICAgICAgICAgXSxcbiAgICAgICAgICAgIDFcbiAgICAgICAgICApXG4gICAgICAgIDogX3ZtLl9lKClcbiAgICBdLFxuICAgIDFcbiAgKVxufVxudmFyIHN0YXRpY1JlbmRlckZucyA9IFtdXG5yZW5kZXIuX3dpdGhTdHJpcHBlZCA9IHRydWVcblxuZXhwb3J0IHsgcmVuZGVyLCBzdGF0aWNSZW5kZXJGbnMgfSJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/Components/ArticleImage.vue?vue&type=template&id=57236750&\n");

/***/ })

}]);
>>>>>>> wip
