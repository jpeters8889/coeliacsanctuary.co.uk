"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[5441],{4706:(e,t,s)=>{s.r(t),s.d(t,{default:()=>l});const a={props:{name:{type:String,default:""},title:{type:String,default:null,required:!1},footer:{type:String,default:null,required:!1},closable:{type:Boolean,default:function(){return!0},required:!1},modalClasses:{type:Array|String,default:function(){return[]}},small:{type:Boolean,default:!1},large:{type:Boolean,default:!1}},data:function(){return{show:!1}},mounted:function(){var e=this;document.querySelector("body").classList.add("overflow-hidden"),this.$root.$on("close-modal",(function(t){t&&t!==e.name||e.close()})),setTimeout((function(){return e.show=!0}),50)},methods:{close:function(){this.closable&&(document.querySelector("body").classList.remove("overflow-hidden"),this.$root.$emit("modal-closed",this.name))}},computed:{computedClasses:function(){var e=this.modalClasses;Array.isArray(e)||(e=e.split(" "));var t="max-w-modal";return this.small&&(t="max-w-modal-small"),this.large&&(t="max-w-modal-large"),e.push(t),e}}};const l=(0,s(1900).Z)(a,(function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"fixed z-max inset-0 overflow-y-auto",attrs:{"aria-labelledby":"modal-title",role:"dialog","aria-modal":"true"}},[s("div",{staticClass:"flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0"},[s("transition",{attrs:{"enter-active-class":"ease-out duration-300","enter-class":"opacity-0","enter-to-class":"opacity-100","leave-active-class":"duration-200 ease-in","leave-class":"opacity-100","leave-to-class":"opacity-0"}},[e.show?s("div",{staticClass:"fixed inset-0 bg-black bg-opacity-80 transition-all",attrs:{"aria-hidden":"true"},on:{"~click":function(t){return t.ctrlKey||t.shiftKey||t.altKey||t.metaKey?null:(t.stopPropagation(),e.close())}}}):e._e()]),e._v(" "),s("span",{staticClass:"hidden sm:inline-block sm:align-middle sm:h-screen",attrs:{"aria-hidden":"true"}},[e._v("​")]),e._v(" "),s("transition",{attrs:{"enter-active-class":"ease-out duration-300","enter-class":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-75","enter-to-class":"opacity-100 translate-y-0 sm:scale-100","leave-active-class":"duration-200 ease-in","leave-class":"opacity-100 translate-y-0 sm:scale-100","leave-to-class":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-75"}},[e.show?s("div",{staticClass:"mx-4 inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle",class:e.computedClasses},[e.title||e.closable?s("div",{staticClass:"flex justify-between bg-grey-off-light leading-none items-center border-b border-grey"},[e.title?s("div",{staticClass:"flex-1 pl-3 text-grey font-semibold text-lg"},[e._v("\n                        "+e._s(e.title)+"\n                    ")]):e._e(),e._v(" "),e.closable?s("div",{staticClass:"flex justify-end p-3 text-grey-off-dark hover:text-grey cursor-pointer text-xl transition-all",class:e.title?"":"w-full",on:{click:function(t){return e.close()}}},[s("font-awesome-icon",{attrs:{icon:["fas","times"]}})],1):e._e()]):e._e(),e._v(" "),s("div",[e._t("default")],2),e._v(" "),e.footer?s("div",{staticClass:"flex justify-between bg-grey-off-light leading-none items-center border-t border-grey"},[s("div",{staticClass:"flex-1 p-3 text-grey text-sm",domProps:{innerHTML:e._s(e.footer)}})]):e._e()]):e._e()])],1)])}),[],!1,null,null,null).exports}}]);