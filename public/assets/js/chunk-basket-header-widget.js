"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[7739],{4438:(t,e,n)=>{n.r(e),n.d(e,{default:()=>i});const s={mixins:[{methods:{viewBasket:function(){this.$root.$emit("show-basket")}}}],data:function(){return{items:0}},computed:{itemText:function(){return 1===this.items?"item":"items"}},mounted:function(){var t=this;this.getSummary(),this.$root.$on("basket-updated",(function(){t.getSummary()}))},methods:{getSummary:function(){var t=this;coeliac().request().get("/api/shop/basket").then((function(e){200===e.status&&(t.items=e.data.quantity)}))}}};const i=(0,n(1900).Z)(s,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"mx-2 p-3 border-blue border rounded bg-blue-light bg-opacity-50 my-2 flex flex-col text-center sm:flex-row sm:text-left sm:justify-between",attrs:{id:"header-basket-detail"}},[n("span",[t._v("You have "),n("strong",[t._v(t._s(t.items))]),t._v(" "+t._s(t.itemText)+" in your basket.")]),t._v(" "),n("a",{staticClass:"font-semibold hover:underline cursor-pointer",on:{click:function(e){return t.viewBasket()}}},[t._v("\n    View Basket\n  ")])])}),[],!1,null,null,null).exports},1900:(t,e,n)=>{function s(t,e,n,s,i,o,r,a){var u,c="function"==typeof t?t.options:t;if(e&&(c.render=e,c.staticRenderFns=n,c._compiled=!0),s&&(c.functional=!0),o&&(c._scopeId="data-v-"+o),r?(u=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),i&&i.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(r)},c._ssrRegister=u):i&&(u=a?function(){i.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:i),u)if(c.functional){c._injectStyles=u;var d=c.render;c.render=function(t,e){return u.call(e),d(t,e)}}else{var l=c.beforeCreate;c.beforeCreate=l?[].concat(l,u):[u]}return{exports:t,options:c}}n.d(e,{Z:()=>s})}}]);