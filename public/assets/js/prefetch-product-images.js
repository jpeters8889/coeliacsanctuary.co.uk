(self.webpackChunk=self.webpackChunk||[]).push([[107],{2287:(t,e,s)=>{"use strict";s.d(e,{Z:()=>o});const l={props:{show:{type:Boolean,default:!1},width:{type:String,default:"50%"},height:{type:String,default:"50%"},maxWidth:{type:String,default:"50px"},maxHeight:{type:String,default:"50px"},background:{type:String,default:"bg-transparent"},fadedBorderColor:{type:String,default:"border-blue-20"},primaryBorderColor:{type:String,default:"#80CCFC"},backgroundPosition:{type:String,default:"absolute"},borderWidth:{type:String,default:"5px"}},computed:{loaderStyles:function(){return{borderTopColor:this.primaryBorderColor,borderWidth:this.borderWidth,width:this.width,height:this.height,maxWidth:this.maxWidth,maxHeight:this.maxHeight}}}};const o=(0,s(1900).Z)(l,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{directives:[{name:"show",rawName:"v-show",value:t.show,expression:"show"}],staticClass:"top-0 left-0 flex justify-center items-center w-full h-full z-max",class:[t.background,t.backgroundPosition]},[s("div",{staticClass:"rounded-full spin",class:t.fadedBorderColor,style:t.loaderStyles})])}),[],!1,null,null,null).exports},931:(t,e,s)=>{"use strict";s.d(e,{Z:()=>o});const l={props:{name:{type:String,default:""},modalClasses:{type:Array|String,default:function(){return[]}},small:{type:Boolean,default:!1}},mounted:function(){var t=this;document.querySelector("body").classList.add("overflow-hidden"),this.$root.$on("close-modal",(function(e){e&&e!==t.name||t.close()}))},methods:{close:function(){document.querySelector("body").classList.remove("overflow-hidden"),this.$root.$emit("modal-closed",this.name)}},computed:{computedClasses:function(){var t=this.modalClasses;Array.isArray(t)||(t=t.split(" "));var e="max-w-modal";return this.small&&(e="max-w-modal-small"),t.push(e),t}}};const o=(0,s(1900).Z)(l,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"z-max fixed inset-0 w-full h-full bg-black-80 flex justify-center items-center",on:{click:function(e){return e.target!==e.currentTarget?null:t.close()}}},[s("div",{staticClass:"h-auto max-h-3/4 shadow p-2 border-2 border-blue-light w-auto rounded-lg bg-blue-light overflow-y-scroll",class:t.computedClasses},[s("div",{staticClass:"h-full relative"},[s("div",{staticClass:"absolute top-0 right-0 bg-white p-1 -mt-1 -mr-1 leading-none z-50 rounded border border-black cursor-pointer transition-bg",on:{click:function(e){return t.close()}}},[s("font-awesome-icon",{attrs:{icon:["fas","times"]}})],1),t._v(" "),s("div",{staticClass:"h-full w-full bg-white-80 p-2 rounded"},[t._t("default")],2)])])])}),[],!1,null,null,null).exports},5023:(t,e,s)=>{"use strict";s.r(e),s.d(e,{default:()=>r});var l=s(2287),o=s(931);const a={props:{productId:{required:!0,type:Number}},components:{loader:l.Z,modal:o.Z},data:function(){return{images:[],loading:!0,currentImage:"",showModal:!1}},mounted:function(){var t=this;this.getImages(),this.$root.$on("modal-closed",(function(){t.showModal=!1}))},methods:{getImages:function(){var t=this;this.loading=!0,coeliac().request().get("/api/shop/product/".concat(this.productId,"/images")).then((function(e){200===e.status&&(t.images=e.data.images,t.currentImage=t.images[0],t.loading=!1)}))},viewImage:function(){this.showModal=!0},switchImage:function(t){this.currentImage=t}}};const r=(0,s(1900).Z)(a,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("div",{staticClass:"relative w-full bg-blue-light-20 border border-blue p-3 flex flex-col min-h-map-small"},[s("loader",{attrs:{show:t.loading}}),t._v(" "),t.loading?t._e():s("div",[s("img",{staticClass:"w-full mb-3 cursor-pointer",staticStyle:{"max-height":"300px"},attrs:{src:t.currentImage,alt:""},on:{click:function(e){return t.viewImage()}}})]),t._v(" "),t.loading?t._e():s("div",{staticClass:"flex flex-wrap"},t._l(t.images,(function(e){return s("div",{staticClass:"w-1/5 mr-1",staticStyle:{cursor:"zoom-in"},on:{click:function(s){return t.switchImage(e)}}},[s("img",{attrs:{src:e,alt:""}})])})),0)],1),t._v(" "),t.showModal?s("portal",{attrs:{to:"modal"}},[s("modal",{attrs:{"modal-classes":"w-full"}},[s("img",{staticClass:"w-full mb-3",attrs:{src:t.currentImage,alt:""}})])],1):t._e()],1)}),[],!1,null,null,null).exports}}]);