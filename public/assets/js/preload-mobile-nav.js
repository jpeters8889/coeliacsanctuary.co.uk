(self.webpackChunk=self.webpackChunk||[]).push([[5440],{9081:(t,e,n)=>{"use strict";n.d(e,{Z:()=>o});const o={methods:{googleEvent:function(t,e){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};window.gtag&&window.gtag(t,e,n)}}}},7192:(t,e,n)=>{"use strict";n.r(e),n.d(e,{default:()=>l});const o={mixins:[n(9081).Z],components:{"contact-form":function(){return n.e(1636).then(n.bind(n,3422))},modal:function(){return n.e(5441).then(n.bind(n,931))}},data:function(){return{showNav:!1,showContact:!1,links:[]}},mounted:function(){var t=this;this.$root.$on("modal-closed",(function(){t.showContact=!1})),this.links=[{label:"Home",link:"/"},{label:"Shop",link:"/shop"},{label:"Blogs",link:"/blog"},{label:"Eating Out",link:"/eating-out"},{label:"Recipes",link:"/recipe"},{label:"Collections",link:"/collection"},{label:"Info",link:"/info"},{label:"About Us",link:"/about"},{label:"FAQ",link:"/faq"},{label:"Contact",callback:function(){this.showContact=!0,this.showNav=!1}.bind(this)}]},watch:{showNav:function(t){if(t)return this.googleEvent("event","mobile-nav",{event_category:"toggled"}),void document.querySelector("body").classList.add("overflow-hidden");document.querySelector("body").classList.remove("overflow-hidden")}}};const l=(0,n(1900).Z)(o,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("div",{staticClass:"cursor-pointer js-mobile-nav-trigger",on:{click:function(e){t.showNav=!0}}},[n("font-awesome-icon",{attrs:{icon:["fas","bars"]}})],1),t._v(" "),n("div",{directives:[{name:"show",rawName:"v-show",value:t.showNav,expression:"showNav"}],staticClass:"h-screen bg-blue fixed overflow-scroll top-0 left-0 w-full h-full flex flex-col z-max js-mobile-nav"},[n("div",{staticClass:"p-1 flex justify-end text-3xl p-2 js-mobile-nav-close-trigger",on:{click:function(e){t.showNav=!1}}},[n("font-awesome-icon",{attrs:{icon:["fas","times"]}})],1),t._v(" "),n("nav",{staticClass:"flex-1 flex items-center"},[n("ul",{staticClass:"flex flex-col w-full"},t._l(t.links,(function(e){return n("li",{staticClass:"text-center p-1"},[e.link?n("a",{attrs:{href:e.link}},[t._v(t._s(e.label))]):t._e(),t._v(" "),e.callback?n("a",{staticClass:"cursor-pointer",on:{click:function(t){return e.callback()}}},[t._v(t._s(e.label))]):t._e()])})),0)])]),t._v(" "),t.showContact?n("portal",{attrs:{to:"modal"}},[n("modal",[n("contact-form")],1)],1):t._e()],1)}),[],!1,null,null,null).exports},1900:(t,e,n)=>{"use strict";function o(t,e,n,o,l,s,i,a){var c,r="function"==typeof t?t.options:t;if(e&&(r.render=e,r.staticRenderFns=n,r._compiled=!0),o&&(r.functional=!0),s&&(r._scopeId="data-v-"+s),i?(c=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),l&&l.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(i)},r._ssrRegister=c):l&&(c=a?function(){l.call(this,(r.functional?this.parent:this).$root.$options.shadowRoot)}:l),c)if(r.functional){r._injectStyles=c;var f=r.render;r.render=function(t,e){return c.call(e),f(t,e)}}else{var u=r.beforeCreate;r.beforeCreate=u?[].concat(u,c):[c]}return{exports:t,options:r}}n.d(e,{Z:()=>o})}}]);