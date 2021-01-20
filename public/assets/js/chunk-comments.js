(self.webpackChunk=self.webpackChunk||[]).push([[4082],{3923:(t,e,r)=>{"use strict";r.d(e,{Z:()=>o});var n=r(7484),a=r.n(n);const o={methods:{formatDate:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"D MMMM YYYY";return a()(t).format(e)}}}},7681:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>i});function n(t){return function(t){if(Array.isArray(t))return a(t)}(t)||function(t){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(t))return Array.from(t)}(t)||function(t,e){if(!t)return;if("string"==typeof t)return a(t,e);var r=Object.prototype.toString.call(t).slice(8,-1);"Object"===r&&t.constructor&&(r=t.constructor.name);if("Map"===r||"Set"===r)return Array.from(t);if("Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r))return a(t,e)}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function a(t,e){(null==e||e>t.length)&&(e=t.length);for(var r=0,n=new Array(e);r<e;r++)n[r]=t[r];return n}const o={mixins:[r(3923).Z],components:{loader:function(){return r.e(8540).then(r.bind(r,2287))}},props:{area:{type:String,required:!0},id:{type:Number,required:!0}},data:function(){return{initial:!1,loaded:!1,data:[],currentPage:1,hasMore:!1}},mounted:function(){var t=this;this.data=[],this.currentPage=1,this.hasMore=!1,new IntersectionObserver((function(e){console.log(e),t.initial||e[0].intersectionRatio>0&&(t.initial=!0,t.getData())})).observe(document.querySelector("#comments-wrapper"))},methods:{getData:function(){var t=this;coeliac().request().get("/api/comments/".concat(this.area,"/").concat(this.id,"?page=").concat(this.currentPage)).then((function(e){var r;t.hasMore=t.currentPage!==e.data.last_page,(r=t.data).push.apply(r,n(e.data.data))})).catch((function(t){})).finally((function(){return t.loaded=!0}))},nextPage:function(){this.currentPage++,this.getData()}}};const i=(0,r(1900).Z)(o,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{attrs:{id:"comments-wrapper"}},[t.loaded?r("div",[0===t.data.length?r("div",{staticClass:"mb-3"},[r("strong",{staticClass:"font-semibold"},[t._v("There's no comments on this Blog, why not leave one?")])]):r("div",[t._l(t.data,(function(e){return r("div",[r("div",{staticClass:"flex flex-col bg-blue-gradient-30 p-3 border-l-8 border-yellow shadow mb-3"},[r("div",{staticClass:"mb-2",domProps:{innerHTML:t._s(e.comment)}}),t._v(" "),r("div",{staticClass:"flex text-xs font-medium text-grey"},[r("div",{staticClass:"mr-2"},[t._v(t._s(e.name))]),t._v(" "),r("div",[t._v(t._s(t.formatDate(e.created_at)))])]),t._v(" "),e.reply?r("div",{staticClass:"flex mt-2 flex-col mt-3 bg-white-80 p-3"},[r("strong",[t._v("Alison @ Coeliac Sanctuary replied to this comment\n                            on "+t._s(t.formatDate(e.reply.created_at)))]),t._v(" "),r("p",{domProps:{innerHTML:t._s(e.reply.comment_reply)}})]):t._e()])])})),t._v(" "),t.hasMore?r("div",{staticClass:"my-2 bg-blue-gradient-20 p-1 shadow border border-blue text-center text-lg hover:bg-blue-gradient-10 cursor-pointer",on:{click:function(e){return t.nextPage()}}},[t._v("\n                Load More Comments\n            ")]):t._e()],2)]):r("div",{staticClass:"relative h-32"},[r("loader",{attrs:{show:!0}})],1)])}),[],!1,null,null,null).exports}}]);