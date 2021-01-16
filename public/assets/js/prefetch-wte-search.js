(self.webpackChunk=self.webpackChunk||[]).push([[96],{2287:(e,t,r)=>{"use strict";r.d(t,{Z:()=>o});const a={props:{show:{type:Boolean,default:!1},width:{type:String,default:"50%"},height:{type:String,default:"50%"},maxWidth:{type:String,default:"50px"},maxHeight:{type:String,default:"50px"},background:{type:String,default:"bg-transparent"},fadedBorderColor:{type:String,default:"border-blue-20"},primaryBorderColor:{type:String,default:"#80CCFC"},backgroundPosition:{type:String,default:"absolute"},borderWidth:{type:String,default:"5px"}},computed:{loaderStyles:function(){return{borderTopColor:this.primaryBorderColor,borderWidth:this.borderWidth,width:this.width,height:this.height,maxWidth:this.maxWidth,maxHeight:this.maxHeight}}}};const o=(0,r(1900).Z)(a,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{directives:[{name:"show",rawName:"v-show",value:e.show,expression:"show"}],staticClass:"top-0 left-0 flex justify-center items-center w-full h-full z-max",class:[e.background,e.backgroundPosition]},[r("div",{staticClass:"rounded-full spin",class:e.fadedBorderColor,style:e.loaderStyles})])}),[],!1,null,null,null).exports},309:(e,t,r)=>{"use strict";r.r(t),r.d(t,{default:()=>o});const a={components:{loader:r(2287).Z},data:function(){return{searchText:"",range:"2",loading:!1}},methods:{search:function(){var e=this;this.loading=!0,coeliac().request().post("/api/wheretoeat/search",{text:this.searchText,range:this.range}).then((function(t){if(200!==t.status)e.loading=!1,coeliac().error("There was an error running your search...");else{var r=t.data.search;window.location.href="/wheretoeat/search/".concat(r)}})).catch((function(){e.loading=!1,coeliac().error("There was an error running your search...")}))}}};const o=(0,r(1900).Z)(a,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",[r("loader",{attrs:{show:e.loading,background:"bg-black-80"}}),e._v(" "),r("widget",{scopedSlots:e._u([{key:"title",fn:function(){return[e._v("\n            Search Places\n        ")]},proxy:!0},{key:"body",fn:function(){return[r("div",{staticClass:"flex flex-col"},[r("p",{staticClass:"mb-2"},[e._v("\n                    Looking for somewhere specific? Search by postcode or town below to get places to eat near you!\n                ")]),e._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:e.searchText,expression:"searchText"}],staticClass:"text-sm p-1 flex-1 bg-grey-lightest border border-grey-off rounded",attrs:{type:"search",placeholder:"Search..."},domProps:{value:e.searchText},on:{keyup:function(t){return!t.type.indexOf("key")&&e._k(t.keyCode,"enter",13,t.key,"Enter")?null:e.search()},input:function(t){t.target.composing||(e.searchText=t.target.value)}}}),e._v(" "),r("div",{staticClass:"mt-2 flex w-full"},[r("select",{directives:[{name:"model",rawName:"v-model",value:e.range,expression:"range"}],staticClass:"flex-1 text-sm p-1 flex-1 bg-grey-lightest border border-grey-off rounded rounded-l",on:{keyup:function(t){return!t.type.indexOf("key")&&e._k(t.keyCode,"enter",13,t.key,"Enter")?null:e.search()},change:function(t){var r=Array.prototype.filter.call(t.target.options,(function(e){return e.selected})).map((function(e){return"_value"in e?e._value:e.value}));e.range=t.target.multiple?r:r[0]}}},[r("option",{attrs:{value:"1"}},[e._v("within 1 Mile")]),e._v(" "),r("option",{attrs:{value:"2"}},[e._v("within 2 Miles")]),e._v(" "),r("option",{attrs:{value:"5"}},[e._v("within 5 Miles")]),e._v(" "),r("option",{attrs:{value:"10"}},[e._v("within 10 Miles")]),e._v(" "),r("option",{attrs:{value:"20"}},[e._v("within 20 Miles")])]),e._v(" "),r("button",{staticClass:"bg-blue text-grey-lightest px-2 rounded-r",on:{click:function(t){return e.search()}}},[r("font-awesome-icon",{attrs:{icon:["fas","search"]}})],1)])])]},proxy:!0}])})],1)}),[],!1,null,null,null).exports}}]);