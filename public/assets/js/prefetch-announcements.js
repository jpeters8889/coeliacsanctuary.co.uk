(self.webpackChunk=self.webpackChunk||[]).push([[342],{9081:(t,e,o)=>{"use strict";o.d(e,{Z:()=>s});const s={methods:{googleEvent:function(t,e){var o=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};window.gtag&&window.gtag(t,e,o)}}}},2956:(t,e,o)=>{"use strict";o.r(e),o.d(e,{default:()=>a});var s=o(9081),l=o(931);const n={mixins:[s.Z],components:{modal:l.Z},data:function(){return{showModal:!1}},mounted:function(){var t=this;this.$root.$on("modal-closed",(function(){t.showModal=!1}))},watch:{showModal:function(){this.showModal&&this.googleEvent("event","viewed-announcement")}}};const a=(0,o(1900).Z)(n,(function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",[o("div",{staticClass:"bg-red-dark p-1 text-center text-white"},[o("div",{staticClass:"flex flex-col"},[t._t("title"),t._v(" "),o("a",{staticClass:"cursor-pointer text-white-80 text-sm hover:text-white hover:underline transition-color",on:{click:function(e){t.showModal=!0}}},[t._v("\n                Read more\n            ")])],2)]),t._v(" "),t.showModal?o("portal",{attrs:{to:"modal"}},[o("modal",{attrs:{"modal-classes":"text-center"}},[o("h2",{staticClass:"text-lg mb-2 font-semibold"},[t._t("title")],2),t._v(" "),o("div",[t._t("default")],2)])],1):t._e()],1)}),[],!1,null,null,null).exports},931:(t,e,o)=>{"use strict";o.d(e,{Z:()=>l});const s={props:{name:{type:String,default:""},modalClasses:{type:Array|String,default:function(){return[]}},small:{type:Boolean,default:!1}},mounted:function(){var t=this;document.querySelector("body").classList.add("overflow-hidden"),this.$root.$on("close-modal",(function(e){e&&e!==t.name||t.close()}))},methods:{close:function(){document.querySelector("body").classList.remove("overflow-hidden"),this.$root.$emit("modal-closed",this.name)}},computed:{computedClasses:function(){var t=this.modalClasses;Array.isArray(t)||(t=t.split(" "));var e="max-w-modal";return this.small&&(e="max-w-modal-small"),t.push(e),t}}};const l=(0,o(1900).Z)(s,(function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",{staticClass:"z-max fixed inset-0 w-full h-full bg-black-80 flex justify-center items-center",on:{click:function(e){return e.target!==e.currentTarget?null:t.close()}}},[o("div",{staticClass:"h-auto max-h-3/4 shadow p-2 border-2 border-blue-light w-auto rounded-lg bg-blue-light overflow-y-scroll",class:t.computedClasses},[o("div",{staticClass:"h-full relative"},[o("div",{staticClass:"absolute top-0 right-0 bg-white p-1 -mt-1 -mr-1 leading-none z-50 rounded border border-black cursor-pointer transition-bg",on:{click:function(e){return t.close()}}},[o("font-awesome-icon",{attrs:{icon:["fas","times"]}})],1),t._v(" "),o("div",{staticClass:"h-full w-full bg-white-80 p-2 rounded"},[t._t("default")],2)])])])}),[],!1,null,null,null).exports}}]);