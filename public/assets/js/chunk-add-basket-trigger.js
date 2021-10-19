"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[8783],{9081:(t,e,r)=>{r.d(e,{Z:()=>n});const n={methods:{googleEvent:function(t,e){var r=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};window.gtag&&window.gtag(t,e,r)}}}},1538:(t,e,r)=>{r.r(e),r.d(e,{default:()=>o});const n={mixins:[r(9081).Z],props:{productId:{required:!0,type:Number},variantId:{required:!0,type:Number},quantity:{type:Number,default:1}},methods:{click:function(){var t=this;coeliac().request().post("/api/shop/basket",{product_id:this.productId,variant_id:this.variantId,quantity:this.quantity}).then((function(e){if(200===e.status)return t.googleEvent("event","add-to-cart",{items:[{id:t.productId,name:e.data.data.product_title,price:e.data.data.product_price/100,quantity:t.quantity}]}),coeliac().success("Product added to basket!"),t.$root.$emit("basket-updated"),void t.$root.$emit("show-basket");coeliac().error("There was an error adding this product to your basket, please try again")})).catch((function(t){var e="There was an error adding this product to your basket, please try again";422===t.response.status&&t.response.data.error&&(e=t.response.data.error),coeliac().error(e)}))}}};const o=(0,r(1900).Z)(n,(function(){var t=this,e=t.$createElement;return(t._self._c||e)("div",{on:{click:function(e){return t.click()}}},[t._t("default")],2)}),[],!1,null,null,null).exports},1900:(t,e,r)=>{function n(t,e,r,n,o,a,i,s){var d,c="function"==typeof t?t.options:t;if(e&&(c.render=e,c.staticRenderFns=r,c._compiled=!0),n&&(c.functional=!0),a&&(c._scopeId="data-v-"+a),i?(d=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),o&&o.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(i)},c._ssrRegister=d):o&&(d=s?function(){o.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:o),d)if(c.functional){c._injectStyles=d;var u=c.render;c.render=function(t,e){return d.call(e),u(t,e)}}else{var p=c.beforeCreate;c.beforeCreate=p?[].concat(p,d):[d]}return{exports:t,options:c}}r.d(e,{Z:()=>n})}}]);