"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[7968],{1560:(t,e,s)=>{s.d(e,{Z:()=>n});const n={methods:{formatPrice:function(t){return t=(t/100).toFixed(2),"&pound;".concat(t)}}}},9081:(t,e,s)=>{s.d(e,{Z:()=>n});const n={methods:{googleEvent:function(t,e){var s=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};window.gtag&&window.gtag(t,e,s)}}}},8222:(t,e,s)=>{s.d(e,{Z:()=>n});const n={methods:{currentSize:function(){var t=this,e="";return Object.keys(this.breakpoints).forEach((function(s){window.innerWidth>=t.breakpoints[s].from&&window.innerWidth<t.breakpoints[s].to&&(e=s)})),e},isLte:function(t){return!Object.keys(this.breakpoints).includes(t)||window.innerWidth<=this.breakpoints[t].from},isLt:function(t){return!Object.keys(this.breakpoints).includes(t)||window.innerWidth<this.breakpoints[t].from},is:function(t){if(!Object.keys(this.breakpoints).includes(t))return!0;var e=this.breakpoints[t];return window.innerWidth>=e.from&&window.innerWidth<e.to},isGt:function(t){return!Object.keys(this.breakpoints).includes(t)||window.innerWidth>this.breakpoints[t].from},isGte:function(t){return!Object.keys(this.breakpoints).includes(t)||window.innerWidth>=this.breakpoints[t].from}},computed:{breakpoints:function(){return{xxs:{from:0,to:499},xs:{from:500,to:599},sm:{from:600,to:749},md:{from:750,to:899},lg:{from:900,to:1199},xl:{from:1200,to:1499},"2xl":{from:1500,to:99999}}}}}},102:(t,e,s)=>{s.r(e),s.d(e,{default:()=>r});var n=s(1560),a=s(9081),o=s(8222);const i={mixins:[n.Z,a.Z,o.Z],data:function(){return{showBasket:!1,hasBackground:!1,data:{items:[],subtotal:0}}},mounted:function(){var t=this;this.getData(),this.$root.$on("background-entered",(function(){t.hasBackground=!0})),this.$root.$on("show-basket",(function(){t.showBasket=!0})),this.$root.$on("product-updated",(function(){t.getData()}))},methods:{getData:function(){var t=this;coeliac().request().get("/api/shop/basket/summary").then((function(e){t.googleEvent("event","checkout-progress",{event_category:"opened-basket-sidebar"}),200!==e.status?t.data={items:[],subtotal:0}:t.$set(t,"data",e.data)})).catch((function(){t.data={items:[],subtotal:0}}))}},watch:{showBasket:function(t){if(t)return document.querySelector("body").classList.add("overflow-hidden"),void this.getData();document.querySelector("body").classList.remove("overflow-hidden")}}};const r=(0,s(1900).Z)(i,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("transition",{attrs:{"enter-active-class":"duration-300 ease-out","enter-class":"opacity-0","enter-to-class":"opacity-100","leave-active-class":"duration-200 ease-in","leave-class":"opacity-100","leave-to-class":"opacity-0"},on:{enter:function(e){return t.$root.$emit("background-entered")}}},[t.showBasket?s("div",{staticClass:"transition-all transform fixed inset-0 h-full bg-black bg-opacity-50 w-full z-max overflow-hidden"},[s("transition",{attrs:{"enter-active-class":"duration-400 ease-out","enter-class":"translate-x-full","enter-to-class":"translate-x-0","leave-active-class":"duration-200 ease-in","leave-class":"translate-x-0","leave-to-class":"translate-x-full"}},[t.showBasket&&t.hasBackground?s("div",{staticClass:"transition-all transform w-11/12 h-full right-0 top-0 bg-white p-3 shadow-basket-sidebar fixed z-max max-w-basket-sidebar"},[s("div",{staticClass:"relative flex flex-col h-full"},[s("div",{staticClass:"absolute right-0 top-0 text-xl cursor-pointer",on:{click:function(e){t.showBasket=!1,t.hasBackground=!1}}},[s("font-awesome-icon",{attrs:{icon:["fas","times"]}})],1),t._v(" "),t.data.items.length>0?[s("div",{staticClass:"flex flex-col h-full"},[s("div",{staticClass:"flex-1 scrollable"},[s("table",{staticClass:"font-semibold"},[t._l(t.data.items,(function(e){return[s("tr",[s("td",{staticClass:"py-1",attrs:{colspan:"2"}},[t._v("\n                                                "+t._s(e.product.title)+" "),""!==e.variant.title?s("span",[t._v("("+t._s(e.variant.title)+")")]):t._e()])]),t._v(" "),s("tr",{staticClass:"text-xl"},[s("td",[s("shop-basket-ui-quantity-switcher",{attrs:{quantity:e.quantity,"product-id":e.product.id,"variant-id":e.variant.id}})],1),t._v(" "),s("td",{staticClass:"text-right",domProps:{innerHTML:t._s(t.formatPrice(e.subtotal))}})])]}))],2)]),t._v(" "),s("div",[s("table",{staticClass:"font-semibold"},[s("tr",{staticClass:"text-xl"},[s("td",[t._v("Subtotal")]),t._v(" "),s("td",{staticClass:"text-right",domProps:{innerHTML:t._s(t.formatPrice(t.data.subtotal))}})]),t._v(" "),s("tr",[s("td",{staticClass:"text-xs font-normal text-center leading-tight",attrs:{colspan:"2"}},[t._v("\n                                            Postage and Discount codes are calculated at checkout.\n                                        ")])]),t._v(" "),s("tr",[s("td",{attrs:{colspan:"2"}},[s("a",{staticClass:"block bg-blue-light hover:bg-opacity-75 rounded-lg p-2 w-full text-center transition-all",attrs:{href:"/shop/basket"}},[t._v("\n                                                Checkout\n                                            ")])])])])])])]:[s("p",[t._v("We couldn't find any items in your basket...")])]],2)]):t._e()])],1):t._e()])}),[],!1,null,null,null).exports},1900:(t,e,s)=>{function n(t,e,s,n,a,o,i,r){var c,l="function"==typeof t?t.options:t;if(e&&(l.render=e,l.staticRenderFns=s,l._compiled=!0),n&&(l.functional=!0),o&&(l._scopeId="data-v-"+o),i?(c=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),a&&a.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(i)},l._ssrRegister=c):a&&(c=r?function(){a.call(this,(l.functional?this.parent:this).$root.$options.shadowRoot)}:a),c)if(l.functional){l._injectStyles=c;var d=l.render;l.render=function(t,e){return c.call(e),d(t,e)}}else{var u=l.beforeCreate;l.beforeCreate=u?[].concat(u,c):[c]}return{exports:t,options:l}}s.d(e,{Z:()=>n})}}]);