(self.webpackChunk=self.webpackChunk||[]).push([[4650],{9081:(t,e,o)=>{"use strict";o.d(e,{Z:()=>n});const n={methods:{googleEvent:function(t,e){var o=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};window.gtag&&window.gtag(t,e,o)}}}},2394:(t,e,o)=>{"use strict";o.d(e,{Z:()=>n});o(2732);const n={methods:{loadLazyImages:function(){coeliac().updateLazyloader()}},computed:{lazyLoadSrc:function(){return"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"}}}},3640:(t,e,o)=>{"use strict";o.r(e),o.d(e,{default:()=>i});var n=o(2394);const s={mixins:[o(9081).Z,n.Z],components:{modal:function(){return o.e(5441).then(o.bind(o,931))}},props:{src:{required:!0,type:String},title:{type:String,default:null},position:{type:String,default:"left"}},data:function(){return{zoom:!1}},mounted:function(){var t=this;this.$root.$on("modal-closed",(function(){t.zoom=!1})),this.loadLazyImages()},computed:{classMap:function(){var t=["w-auto","p-2","mx-0","my-2","sm:m-2","bg-blue-20"];return"fullwidth"!==this.position&&t.push("sm:max-w-1/2","lg:max-w-2/5"),"left"===this.position&&t.push("sm:ml-0","float-left"),"right"===this.position&&t.push("sm:mr-0","float-right"),t}},watch:{zoom:function(){this.zoom&&this.googleEvent("event","article",{event_category:"viewed-image",event_label:this.src})}}};const i=(0,o(1900).Z)(s,(function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",[o("div",{class:t.classMap},[o("img",{staticClass:"lazy w-full h-auto",staticStyle:{cursor:"zoom-in"},attrs:{"data-src":t.src,src:t.lazyLoadSrc,alt:t.title,loading:"lazy"},on:{click:function(e){t.zoom=!0}}}),t._v(" "),t.title?o("div",{staticClass:"text-center text-sm mt-2 leading-none"},[t._v(t._s(t.title))]):t._e()]),t._v(" "),t.zoom?o("portal",{attrs:{to:"modal"}},[o("modal",[o("img",{staticClass:"max-w-full",attrs:{src:t.src,alt:t.title}}),t._v(" "),t.title?o("div",{staticClass:"text-center text-sm mt-2 leading-none"},[t._v(t._s(t.title))]):t._e()])],1):t._e()],1)}),[],!1,null,null,null).exports},1900:(t,e,o)=>{"use strict";function n(t,e,o,n,s,i,a,r){var l,c="function"==typeof t?t.options:t;if(e&&(c.render=e,c.staticRenderFns=o,c._compiled=!0),n&&(c.functional=!0),i&&(c._scopeId="data-v-"+i),a?(l=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),s&&s.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(a)},c._ssrRegister=l):s&&(l=r?function(){s.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:s),l)if(c.functional){c._injectStyles=l;var d=c.render;c.render=function(t,e){return l.call(e),d(t,e)}}else{var u=c.beforeCreate;c.beforeCreate=u?[].concat(u,l):[l]}return{exports:t,options:c}}o.d(e,{Z:()=>n})}}]);