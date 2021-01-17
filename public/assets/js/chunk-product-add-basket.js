(self.webpackChunk=self.webpackChunk||[]).push([[6487],{1560:(t,a,n)=>{"use strict";n.d(a,{Z:()=>e});const e={methods:{formatPrice:function(t){return t=(t/100).toFixed(2),"&pound;".concat(t)}}}},2452:(t,a,n)=>{"use strict";n.r(a),n.d(a,{default:()=>d});var e=n(1560);const r={props:{quantity:{type:Number,required:!0}}};var i=n(1900);const o=(0,i.Z)(r,(function(){var t=this,a=t.$createElement,n=t._self._c||a;return n("div",{staticClass:"flex justify-start font-semibold text-lg mt-2"},[n("div",[t._v("\n        Quantity: \n    ")]),t._v(" "),0===t.quantity?n("div",{staticClass:"italic"},[t._v("\n        Sorry, this product is out of stock.\n    ")]):t.quantity<=5?n("div",{staticClass:"text-red"},[t._v("\n        Only "+t._s(t.quantity)+" available\n    ")]):t.quantity<=10?n("div",[t._v("\n        "+t._s(t.quantity)+" available\n    ")]):n("div",[t._v("\n        More than 10 available\n    ")])])}),[],!1,null,null,null).exports;function s(t,a){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var e=Object.getOwnPropertySymbols(t);a&&(e=e.filter((function(a){return Object.getOwnPropertyDescriptor(t,a).enumerable}))),n.push.apply(n,e)}return n}function l(t){for(var a=1;a<arguments.length;a++){var n=null!=arguments[a]?arguments[a]:{};a%2?s(Object(n),!0).forEach((function(a){c(t,a,n[a])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):s(Object(n)).forEach((function(a){Object.defineProperty(t,a,Object.getOwnPropertyDescriptor(n,a))}))}return t}function c(t,a,n){return a in t?Object.defineProperty(t,a,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[a]=n,t}const u={mixins:[e.Z],components:{loader:function(){return n.e(8540).then(n.bind(n,2287))},"product-quantity":o,"form-input":function(){return Promise.all([n.e(931),n.e(1531)]).then(n.bind(n,511))},"form-select":function(){return Promise.all([n.e(931),n.e(4014)]).then(n.bind(n,2460))}},props:{productId:{required:!0,type:Number}},data:function(){return{loading:!0,data:{},availableQuantity:0,watchers:{variant:null,quantity:1},formData:{variant:null,quantity:1},validity:{variant:!0,quantity:!0}}},mounted:function(){var t=this;this.getData(),this.$root.$on("basket-updated",(function(){t.getData()})),Object.keys(this.validity).forEach((function(a){t.$root.$on("".concat(a,"-error"),(function(){t.validity[a]=!1})),t.$root.$on("".concat(a,"-valid"),(function(){t.validity[a]=!0})),t.$root.$on("".concat(a,"-value"),(function(n){t.formData[a]=n})),t.$root.$on("".concat(a,"-change"),(function(n){t.formData[a]=n}))}))},methods:{getData:function(){var t=this;this.loading=!0,coeliac().request().get("/api/shop/product/".concat(this.productId)).then((function(a){t.data=a.data.data,t.formData.variant=t.data.variants[0].id,t.availableQuantity=t.data.variants[0].quantity,t.watchers=l({},t.formData),t.loading=!1}))}},computed:{variantOptions:function(){var t=[];return this.data.variants.forEach((function(a){t.push({value:a.id,label:a.title})})),t}},watch:{formData:{deep:!0,handler:function(t){if(t.variant!==this.watchers.variant){var a=this.data.variants.filter((function(a){return a.id===t.variant}))[0];this.availableQuantity=a?a.quantity:this.availableQuantity}this.watchers=l({},t)}}}};const d=(0,i.Z)(u,(function(){var t=this,a=t.$createElement,n=t._self._c||a;return n("div",{staticClass:"relative w-full bg-blue-light-20 border border-blue p-3 flex flex-col min-h-map-small"},[n("loader",{attrs:{show:t.loading}}),t._v(" "),t.loading?t._e():[t.data.price.old_price?n("div",{staticClass:"text-md text-center"},[t._v("\n            was "),n("span",{staticClass:"font-semibold text-red line-through",domProps:{innerHTML:t._s(t.formatPrice(t.data.price.old_price))}}),t._v("\n            now\n        ")]):t._e(),t._v(" "),n("div",{staticClass:"text-2xl font-semibold mb-4 text-center",domProps:{innerHTML:t._s(t.formatPrice(t.data.price.current_price)+" each")}}),t._v(" "),t.data.variants.length>1?n("div",{staticClass:"flex flex-col"},[n("span",{staticClass:"font-semibold ml-1"},[t._v("Select Product Option")]),t._v(" "),n("form-select",{attrs:{required:"",name:"variant",value:t.formData.variant.toString(),options:t.variantOptions}})],1):t._e(),t._v(" "),n("product-quantity",{attrs:{quantity:t.availableQuantity}}),t._v(" "),n("form-input",{attrs:{required:"",name:"quantity",value:t.formData.quantity.toString(),type:"number",min:1}}),t._v(" "),n("add-basket-trigger",{attrs:{"product-id":t.productId,"variant-id":parseInt(t.formData.variant),quantity:parseInt(t.formData.quantity)}},[n("button",{staticClass:"w-full p-2 bg-blue-light-80 border-blue text-center rounded mt-4 font-semibold"},[t._v("\n                Add to Basket\n            ")])])]],2)}),[],!1,null,null,null).exports}}]);