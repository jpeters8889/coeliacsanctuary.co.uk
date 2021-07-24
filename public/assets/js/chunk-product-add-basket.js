(self.webpackChunk=self.webpackChunk||[]).push([[6487],{1560:(t,e,a)=>{"use strict";a.d(e,{Z:()=>n});const n={methods:{formatPrice:function(t){return t=(t/100).toFixed(2),"&pound;".concat(t)}}}},3984:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>d});var n=a(1560);const r={props:{quantity:{type:Number,required:!0}}};var i=a(1900);const o=(0,i.Z)(r,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"flex justify-start font-semibold text-lg mt-2"},[a("div",[t._v("\n        Quantity: \n    ")]),t._v(" "),0===t.quantity?a("div",{staticClass:"italic"},[t._v("\n        Sorry, this product is out of stock.\n    ")]):t.quantity<=5?a("div",{staticClass:"text-red"},[t._v("\n        Only "+t._s(t.quantity)+" available\n    ")]):t.quantity<=10?a("div",[t._v("\n        "+t._s(t.quantity)+" available\n    ")]):a("div",[t._v("\n        More than 10 available\n    ")])])}),[],!1,null,null,null).exports;function s(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(t);e&&(n=n.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),a.push.apply(a,n)}return a}function c(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?s(Object(a),!0).forEach((function(e){u(t,e,a[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):s(Object(a)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))}))}return t}function u(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}const l={mixins:[n.Z],components:{loader:function(){return a.e(8540).then(a.bind(a,1337))},"product-quantity":o,"form-input":function(){return Promise.all([a.e(5816),a.e(1531)]).then(a.bind(a,5542))},"form-select":function(){return Promise.all([a.e(5816),a.e(4014)]).then(a.bind(a,9729))}},props:{productId:{required:!0,type:Number}},data:function(){return{loading:!0,data:{},availableQuantity:0,watchers:{variant:null,quantity:1},formData:{variant:null,quantity:1},validity:{variant:!0,quantity:!0}}},mounted:function(){var t=this;this.getData(),this.$root.$on("basket-updated",(function(){t.getData()})),Object.keys(this.validity).forEach((function(e){t.$root.$on("".concat(e,"-error"),(function(){t.validity[e]=!1})),t.$root.$on("".concat(e,"-valid"),(function(){t.validity[e]=!0})),t.$root.$on("".concat(e,"-value"),(function(a){t.formData[e]=a})),t.$root.$on("".concat(e,"-change"),(function(a){t.formData[e]=a}))}))},methods:{getData:function(){var t=this;this.loading=!0,coeliac().request().get("/api/shop/product/".concat(this.productId)).then((function(e){t.data=e.data.data,t.formData.variant=t.data.variants[0].id,t.availableQuantity=t.data.variants[0].quantity,t.watchers=c({},t.formData),t.loading=!1}))}},computed:{variantOptions:function(){var t=[];return this.data.variants.forEach((function(e){t.push({value:e.id,label:e.title})})),t}},watch:{formData:{deep:!0,handler:function(t){if(t.variant!==this.watchers.variant){var e=this.data.variants.filter((function(e){return e.id===t.variant}))[0];this.availableQuantity=e?e.quantity:this.availableQuantity}this.watchers=c({},t)}}}};const d=(0,i.Z)(l,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"relative w-full bg-blue-light-20 border border-blue p-3 flex flex-col min-h-map-small"},[a("loader",{attrs:{show:t.loading}}),t._v(" "),t.loading?t._e():[t.data.price.old_price?a("div",{staticClass:"text-md text-center"},[t._v("\n            was "),a("span",{staticClass:"font-semibold text-red line-through",domProps:{innerHTML:t._s(t.formatPrice(t.data.price.old_price))}}),t._v("\n            now\n        ")]):t._e(),t._v(" "),a("div",{staticClass:"text-2xl font-semibold mb-4 text-center",domProps:{innerHTML:t._s(t.formatPrice(t.data.price.current_price)+" each")}}),t._v(" "),t.data.variants.length>1?a("div",{staticClass:"flex flex-col"},[a("span",{staticClass:"font-semibold ml-1"},[t._v("Select Product Option")]),t._v(" "),a("form-select",{attrs:{required:"",name:"variant",value:t.formData.variant.toString(),options:t.variantOptions}})],1):t._e(),t._v(" "),a("product-quantity",{attrs:{quantity:t.availableQuantity}}),t._v(" "),a("form-input",{attrs:{required:"",name:"quantity",value:t.formData.quantity.toString(),type:"number",min:1}}),t._v(" "),a("shop-basket-ui-add-product",{attrs:{"product-id":t.productId,"variant-id":parseInt(t.formData.variant),quantity:parseInt(t.formData.quantity)}},[a("button",{staticClass:"w-full p-2 bg-blue-light-80 border-blue text-center rounded mt-4 font-semibold"},[t._v("\n                Add to Basket\n            ")])])]],2)}),[],!1,null,null,null).exports},1900:(t,e,a)=>{"use strict";function n(t,e,a,n,r,i,o,s){var c,u="function"==typeof t?t.options:t;if(e&&(u.render=e,u.staticRenderFns=a,u._compiled=!0),n&&(u.functional=!0),i&&(u._scopeId="data-v-"+i),o?(c=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),r&&r.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(o)},u._ssrRegister=c):r&&(c=s?function(){r.call(this,(u.functional?this.parent:this).$root.$options.shadowRoot)}:r),c)if(u.functional){u._injectStyles=c;var l=u.render;u.render=function(t,e){return c.call(e),l(t,e)}}else{var d=u.beforeCreate;u.beforeCreate=d?[].concat(d,c):[c]}return{exports:t,options:u}}a.d(e,{Z:()=>n})}}]);