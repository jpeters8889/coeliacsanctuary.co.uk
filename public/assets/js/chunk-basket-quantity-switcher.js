(self.webpackChunk=self.webpackChunk||[]).push([[4755],{5004:(e,t,r)=>{"use strict";r.r(t),r.d(t,{default:()=>i});const n={mixins:[{methods:{increaseQuantity:function(e,t){this.alterQuantity(e,t)},decreaseQuantity:function(e,t){this.alterQuantity(e,t,"decrease")},alterQuantity:function(e,t){var r=this,n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"increase";coeliac().request().put("/api/shop/basket",{product:e,variant:t,action:n}).then((function(e){if(200===e.status)return coeliac().success("Product Updated"),void r.$root.$emit("product-updated");400!==e.status?coeliac().error("There was an error altering the item"):coeliac().error(e.status.error)})).catch((function(){coeliac().error("There was an error altering the item")}))}}}],props:{quantity:{required:!0,type:Number},productId:{required:!0,type:Number},variantId:{required:!0,type:Number}}};const i=(0,r(1900).Z)(n,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"flex"},[r("div",{staticClass:"bg-yellow border border-black rounded-l-full px-2 text-sm flex items-center cursor-pointer",on:{click:function(t){return e.decreaseQuantity(e.productId,e.variantId)}}},[r("font-awesome-icon",{attrs:{icon:["fas","minus"]}})],1),e._v(" "),r("div",{staticClass:"bg-yellow border border-black px-2 flex items-center"},[e._v("\n        "+e._s(e.quantity)+"\n    ")]),e._v(" "),r("div",{staticClass:"bg-yellow border border-black rounded-r-full px-2 text-sm flex items-center cursor-pointer",on:{click:function(t){return e.increaseQuantity(e.productId,e.variantId)}}},[r("font-awesome-icon",{attrs:{icon:["fas","plus"]}})],1)])}),[],!1,null,null,null).exports},1900:(e,t,r)=>{"use strict";function n(e,t,r,n,i,o,s,a){var c,u="function"==typeof e?e.options:e;if(t&&(u.render=t,u.staticRenderFns=r,u._compiled=!0),n&&(u.functional=!0),o&&(u._scopeId="data-v-"+o),s?(c=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),i&&i.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(s)},u._ssrRegister=c):i&&(c=a?function(){i.call(this,(u.functional?this.parent:this).$root.$options.shadowRoot)}:i),c)if(u.functional){u._injectStyles=c;var d=u.render;u.render=function(e,t){return c.call(t),d(e,t)}}else{var l=u.beforeCreate;u.beforeCreate=l?[].concat(l,c):[c]}return{exports:e,options:u}}r.d(t,{Z:()=>n})}}]);