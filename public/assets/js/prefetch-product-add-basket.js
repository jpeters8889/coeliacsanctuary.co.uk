(self.webpackChunk=self.webpackChunk||[]).push([[405],{1560:(t,e,r)=>{"use strict";r.d(e,{Z:()=>n});const n={methods:{formatPrice:function(t){return t=(t/100).toFixed(2),"&pound;".concat(t)}}}},2102:(t,e,r)=>{"use strict";r.d(e,{Z:()=>n});const n={data:function(){return{hasError:!1,showError:!1,errorText:"",currentValue:""}},props:{type:{type:String,default:"text"},name:{type:String,required:!0},value:{type:String,default:""},placeholder:{type:String,default:""},required:{type:Boolean,default:!1},disabled:{type:Boolean,default:!1},min:{type:Number,default:null},max:{type:Number,default:null},pattern:{type:RegExp,default:null},patternError:{type:String,default:"Field is Invalid"},match:{type:String,default:null}},mounted:function(){var t=this;this.currentValue=this.value,this.required&&""===this.currentValue&&(this.hasError=!0),this.$root.$on(this.name+"-get-value",(function(){t.validate(),t.$root.$emit(t.name+"-value",t.currentValue)})),this.$root.$on(this.name+"-set-value",(function(e){t.currentValue=e,t.hasError=!0,t.validate()})),this.$root.$on(this.name+"-reset",(function(){t.currentValue="",t.showError=!1})),this.$root.$on(this.name+"-validate",(function(){t.hasError=!0,t.validate()}))},methods:{validate:function(){if(this.showError=!0,this.required&&""===this.currentValue)return this.errorText="Field is required",void this.pushError();if(this.pattern&&(this.required||""!==this.currentValue)&&!this.currentValue.match(this.pattern))return this.errorText=this.patternError,void this.pushError();if(this.match&&this.currentValue!==this.match)return this.errorText="Field does not match",void this.pushError();switch(this.type){case"email":if(!this.checkEmail())return this.errorText="Must be a valid email address",void this.pushError()}this.hasError=!1,this.errorText="",this.$root.$emit(this.name+"-valid")},checkEmail:function(){return/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(this.currentValue)},pushError:function(){this.hasError=!0,this.$root.$emit(this.name+"-error",this.errorText)}},watch:{hasError:function(){this.hasError?this.$root.$emit(this.name+"-error",this.errorText):this.$root.$emit(this.name+"-valid")},currentValue:function(t){this.$root.$emit(this.name+"-change",t)}}}},6692:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>i});var n=r(3645),a=r.n(n)()(!0);a.push([t.id,"input:focus {\n  outline: none;\n}\ninput:-webkit-autofill {\n  background: none;\n}\n","",{version:3,sources:["webpack://resources/js/Components/Forms/FormInput.vue"],names:[],mappings:"AAuBA;EACA,aAAA;AACA;AAEA;EACA,gBAAA;AACA",sourcesContent:['<template>\n    <div class="flex overflow-hidden border border-blue rounded">\n        <div class="bg-grey-lightest p-0 flex-1">\n            <input v-model="currentValue" :type="type" :name="name" :placeholder="placeholder" @blur="validate()" :min="min" :max="max"\n                   :disabled="disabled" class="w-full bg-transparent border-0 p-3 m-0 text-grey-darkest" :class="disabled ? \'text-grey-light cursor:not-allowed\' : \'\'" />\n        </div>\n\n        <div class="bg-red flex justify-center items-center p-2 text-white" v-if="hasError && showError"\n             v-tooltip.left="{content: errorText, classes: [\'bg-red\', \'border-red\', \'text-white\'], boundariesElement: \'body\'}">\n            <font-awesome-icon :icon="[\'fas\', \'exclamation-circle\']"></font-awesome-icon>\n        </div>\n    </div>\n</template>\n\n<script>\n    import IsFormField from "../../Mixins/IsFormField";\n\n    export default {\n        mixins: [IsFormField],\n    }\n<\/script>\n\n<style>\n    input:focus {\n        outline: none;\n    }\n\n    input:-webkit-autofill {\n        background: none;\n    }\n</style>\n'],sourceRoot:""}]);const i=a},2750:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>i});var n=r(3645),a=r.n(n)()(!0);a.push([t.id,"input:focus {\n  outline: none;\n}\ninput:-webkit-autofill {\n  background: none;\n}\n","",{version:3,sources:["webpack://resources/js/Components/Forms/FormSelect.vue"],names:[],mappings:"AA2CA;EACA,aAAA;AACA;AAEA;EACA,gBAAA;AACA",sourcesContent:['<template>\n    <div>\n        <span v-if="label" class="block font-semibold text-lg mb-2">{{ label }}</span>\n\n        <div class="flex overflow-hidden border border-blue rounded">\n            <div class="bg-grey-lightest p-0 flex-1">\n                <select :name="name" v-model="currentValue" @blur="validate()"\n                        class="w-full bg-transparent border-0 m-0 text-grey-darkest" :class="padding">\n                    <option v-for="option in options" :value="option.value" v-text="option.label"></option>\n                </select>\n            </div>\n\n            <div class="bg-red flex justify-center items-center p-2 text-white" v-if="hasError && showError"\n                 v-tooltip.bottom="{content: errorText, classes: [\'bg-red\', \'border-red\', \'text-white\']}">\n                <font-awesome-icon :icon="[\'fas\', \'exclamation-circle\']"></font-awesome-icon>\n            </div>\n        </div>\n    </div>\n</template>\n\n<script>\n    import IsFormField from "../../Mixins/IsFormField";\n\n    export default {\n        mixins: [IsFormField],\n\n        props: {\n            options: {\n                required: true,\n                type: Array,\n            },\n            padding: {\n                default: \'p-3\',\n            },\n            label: {\n                type: String,\n                default: null,\n            }\n        }\n    }\n<\/script>\n\n<style>\n    input:focus {\n        outline: none;\n    }\n\n    input:-webkit-autofill {\n        background: none;\n    }\n</style>\n'],sourceRoot:""}]);const i=a},1067:(t,e,r)=>{var n=r(3379),a=r(6692);"string"==typeof(a=a.__esModule?a.default:a)&&(a=[[t.id,a,""]]);var i={insert:"head",singleton:!1};n(a,i);t.exports=a.locals||{}},8936:(t,e,r)=>{var n=r(3379),a=r(2750);"string"==typeof(a=a.__esModule?a.default:a)&&(a=[[t.id,a,""]]);var i={insert:"head",singleton:!1};n(a,i);t.exports=a.locals||{}},6970:(t,e,r)=>{"use strict";r.d(e,{Z:()=>a});r(1067);const n={mixins:[r(2102).Z]};const a=(0,r(1900).Z)(n,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"flex overflow-hidden border border-blue rounded"},[r("div",{staticClass:"bg-grey-lightest p-0 flex-1"},["checkbox"===t.type?r("input",{directives:[{name:"model",rawName:"v-model",value:t.currentValue,expression:"currentValue"}],staticClass:"w-full bg-transparent border-0 p-3 m-0 text-grey-darkest",class:t.disabled?"text-grey-light cursor:not-allowed":"",attrs:{name:t.name,placeholder:t.placeholder,min:t.min,max:t.max,disabled:t.disabled,type:"checkbox"},domProps:{checked:Array.isArray(t.currentValue)?t._i(t.currentValue,null)>-1:t.currentValue},on:{blur:function(e){return t.validate()},change:function(e){var r=t.currentValue,n=e.target,a=!!n.checked;if(Array.isArray(r)){var i=t._i(r,null);n.checked?i<0&&(t.currentValue=r.concat([null])):i>-1&&(t.currentValue=r.slice(0,i).concat(r.slice(i+1)))}else t.currentValue=a}}}):"radio"===t.type?r("input",{directives:[{name:"model",rawName:"v-model",value:t.currentValue,expression:"currentValue"}],staticClass:"w-full bg-transparent border-0 p-3 m-0 text-grey-darkest",class:t.disabled?"text-grey-light cursor:not-allowed":"",attrs:{name:t.name,placeholder:t.placeholder,min:t.min,max:t.max,disabled:t.disabled,type:"radio"},domProps:{checked:t._q(t.currentValue,null)},on:{blur:function(e){return t.validate()},change:function(e){t.currentValue=null}}}):r("input",{directives:[{name:"model",rawName:"v-model",value:t.currentValue,expression:"currentValue"}],staticClass:"w-full bg-transparent border-0 p-3 m-0 text-grey-darkest",class:t.disabled?"text-grey-light cursor:not-allowed":"",attrs:{name:t.name,placeholder:t.placeholder,min:t.min,max:t.max,disabled:t.disabled,type:t.type},domProps:{value:t.currentValue},on:{blur:function(e){return t.validate()},input:function(e){e.target.composing||(t.currentValue=e.target.value)}}})]),t._v(" "),t.hasError&&t.showError?r("div",{directives:[{name:"tooltip",rawName:"v-tooltip.left",value:{content:t.errorText,classes:["bg-red","border-red","text-white"],boundariesElement:"body"},expression:"{content: errorText, classes: ['bg-red', 'border-red', 'text-white'], boundariesElement: 'body'}",modifiers:{left:!0}}],staticClass:"bg-red flex justify-center items-center p-2 text-white"},[r("font-awesome-icon",{attrs:{icon:["fas","exclamation-circle"]}})],1):t._e()])}),[],!1,null,null,null).exports},1312:(t,e,r)=>{"use strict";r.d(e,{Z:()=>a});r(8936);const n={mixins:[r(2102).Z],props:{options:{required:!0,type:Array},padding:{default:"p-3"},label:{type:String,default:null}}};const a=(0,r(1900).Z)(n,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",[t.label?r("span",{staticClass:"block font-semibold text-lg mb-2"},[t._v(t._s(t.label))]):t._e(),t._v(" "),r("div",{staticClass:"flex overflow-hidden border border-blue rounded"},[r("div",{staticClass:"bg-grey-lightest p-0 flex-1"},[r("select",{directives:[{name:"model",rawName:"v-model",value:t.currentValue,expression:"currentValue"}],staticClass:"w-full bg-transparent border-0 m-0 text-grey-darkest",class:t.padding,attrs:{name:t.name},on:{blur:function(e){return t.validate()},change:function(e){var r=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){return"_value"in t?t._value:t.value}));t.currentValue=e.target.multiple?r:r[0]}}},t._l(t.options,(function(e){return r("option",{domProps:{value:e.value,textContent:t._s(e.label)}})})),0)]),t._v(" "),t.hasError&&t.showError?r("div",{directives:[{name:"tooltip",rawName:"v-tooltip.bottom",value:{content:t.errorText,classes:["bg-red","border-red","text-white"]},expression:"{content: errorText, classes: ['bg-red', 'border-red', 'text-white']}",modifiers:{bottom:!0}}],staticClass:"bg-red flex justify-center items-center p-2 text-white"},[r("font-awesome-icon",{attrs:{icon:["fas","exclamation-circle"]}})],1):t._e()])])}),[],!1,null,null,null).exports},8978:(t,e,r)=>{"use strict";r.d(e,{Z:()=>a});const n={props:{show:{type:Boolean,default:!1},width:{type:String,default:"50%"},height:{type:String,default:"50%"},maxWidth:{type:String,default:"50px"},maxHeight:{type:String,default:"50px"},background:{type:String,default:"bg-transparent"},fadedBorderColor:{type:String,default:"border-blue-20"},primaryBorderColor:{type:String,default:"#80CCFC"},backgroundPosition:{type:String,default:"absolute"},borderWidth:{type:String,default:"5px"}},computed:{loaderStyles:function(){return{borderTopColor:this.primaryBorderColor,borderWidth:this.borderWidth,width:this.width,height:this.height,maxWidth:this.maxWidth,maxHeight:this.maxHeight}}}};const a=(0,r(1900).Z)(n,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{directives:[{name:"show",rawName:"v-show",value:t.show,expression:"show"}],staticClass:"top-0 left-0 flex justify-center items-center w-full h-full z-max",class:[t.background,t.backgroundPosition]},[r("div",{staticClass:"rounded-full spin",class:t.fadedBorderColor,style:t.loaderStyles})])}),[],!1,null,null,null).exports},9882:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>h});var n=r(1560),a=r(8978);const i={props:{quantity:{type:Number,required:!0}}};var o=r(1900);const s=(0,o.Z)(i,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"flex justify-start font-semibold text-lg mt-2"},[r("div",[t._v("\n        Quantity: \n    ")]),t._v(" "),0===t.quantity?r("div",{staticClass:"italic"},[t._v("\n        Sorry, this product is out of stock.\n    ")]):t.quantity<=5?r("div",{staticClass:"text-red"},[t._v("\n        Only "+t._s(t.quantity)+" available\n    ")]):t.quantity<=10?r("div",[t._v("\n        "+t._s(t.quantity)+" available\n    ")]):r("div",[t._v("\n        More than 10 available\n    ")])])}),[],!1,null,null,null).exports;var l=r(6970),u=r(1312);function d(t,e){var r=Object.keys(t);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(t);e&&(n=n.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),r.push.apply(r,n)}return r}function c(t){for(var e=1;e<arguments.length;e++){var r=null!=arguments[e]?arguments[e]:{};e%2?d(Object(r),!0).forEach((function(e){p(t,e,r[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(r)):d(Object(r)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(r,e))}))}return t}function p(t,e,r){return e in t?Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[e]=r,t}const m={mixins:[n.Z],components:{loader:a.Z,"product-quantity":s,"form-input":l.Z,"form-select":u.Z},props:{productId:{required:!0,type:Number}},data:function(){return{loading:!0,data:{},availableQuantity:0,watchers:{variant:null,quantity:1},formData:{variant:null,quantity:1},validity:{variant:!0,quantity:!0}}},mounted:function(){var t=this;this.getData(),this.$root.$on("basket-updated",(function(){t.getData()})),Object.keys(this.validity).forEach((function(e){t.$root.$on("".concat(e,"-error"),(function(){t.validity[e]=!1})),t.$root.$on("".concat(e,"-valid"),(function(){t.validity[e]=!0})),t.$root.$on("".concat(e,"-value"),(function(r){t.formData[e]=r})),t.$root.$on("".concat(e,"-change"),(function(r){t.formData[e]=r}))}))},methods:{getData:function(){var t=this;this.loading=!0,coeliac().request().get("/api/shop/product/".concat(this.productId)).then((function(e){t.data=e.data.data,t.formData.variant=t.data.variants[0].id,t.availableQuantity=t.data.variants[0].quantity,t.watchers=c({},t.formData),t.loading=!1}))}},computed:{variantOptions:function(){var t=[];return this.data.variants.forEach((function(e){t.push({value:e.id,label:e.title})})),t}},watch:{formData:{deep:!0,handler:function(t){if(t.variant!==this.watchers.variant){var e=this.data.variants.filter((function(e){return e.id===t.variant}))[0];this.availableQuantity=e?e.quantity:this.availableQuantity}this.watchers=c({},t)}}}};const h=(0,o.Z)(m,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"relative w-full bg-blue-light-20 border border-blue p-3 flex flex-col min-h-map-small"},[r("loader",{attrs:{show:t.loading}}),t._v(" "),t.loading?t._e():[t.data.price.old_price?r("div",{staticClass:"text-md text-center"},[t._v("\n            was "),r("span",{staticClass:"font-semibold text-red line-through",domProps:{innerHTML:t._s(t.formatPrice(t.data.price.old_price))}}),t._v("\n            now\n        ")]):t._e(),t._v(" "),r("div",{staticClass:"text-2xl font-semibold mb-4 text-center",domProps:{innerHTML:t._s(t.formatPrice(t.data.price.current_price)+" each")}}),t._v(" "),t.data.variants.length>1?r("div",{staticClass:"flex flex-col"},[r("span",{staticClass:"font-semibold ml-1"},[t._v("Select Product Option")]),t._v(" "),r("form-select",{attrs:{required:"",name:"variant",value:t.formData.variant.toString(),options:t.variantOptions}})],1):t._e(),t._v(" "),r("product-quantity",{attrs:{quantity:t.availableQuantity}}),t._v(" "),r("form-input",{attrs:{required:"",name:"quantity",value:t.formData.quantity.toString(),type:"number",min:1}}),t._v(" "),r("add-basket-trigger",{attrs:{"product-id":t.productId,"variant-id":parseInt(t.formData.variant),quantity:parseInt(t.formData.quantity)}},[r("button",{staticClass:"w-full p-2 bg-blue-light-80 border-blue text-center rounded mt-4 font-semibold"},[t._v("\n                Add to Basket\n            ")])])]],2)}),[],!1,null,null,null).exports}}]);