(self.webpackChunk=self.webpackChunk||[]).push([[5137],{2858:(t,e,i)=>{"use strict";i.r(e),i.d(e,{default:()=>s});const n={props:{baseUrl:{type:String,required:!0}},data:function(){return{tabs:[],activeTab:null}},mounted:function(){var t=this;this.tabs=this.$children,this.setInitialActiveTab(),this.$root.$on("active-tab",(function(e){t.activeTab=e})),this.$root.$on("link-change",(function(e){t.update(e)}))},methods:{setInitialActiveTab:function(){var t=this,e=window.location.pathname.split("/").slice(-1)[0];this.tabs.forEach((function(i){e===i.url&&(t.activeTab=i)})),!this.activeTab&&window.innerWidth<=500&&(this.activeTab=this.tabs.find((function(t){return t.mobileDefault}))||null),this.activeTab||(this.activeTab=this.tabs.find((function(t){return t.active}))||this.tabs[0])},updateUrl:function(t){window.history.pushState(null,null,window.location.origin+"/"+this.baseUrl+"/"+t)}},watch:{activeTab:function(t){var e=this;this.tabs.map((function(i){if(i===t)return i.isActive=!0,void e.updateUrl(i.url);i.isActive=!1}))}}};const s=(0,i(1900).Z)(n,(function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",[i("ul",{staticClass:"flex flex-col leading-none xs:flex-row"},t._l(t.tabs,(function(e){return i("li",{staticClass:"w-full cursor-pointer py-3 px-6 border-2 w-full block transition-bg xs:w-auto xs:rounded-t-lg xs:mr-1",class:e.isActive?"bg-yellow-50 border-yellow hover:bg-yellow-40":"bg-blue-light-50 border-blue-light hover:bg-blue-light-40",on:{click:function(i){t.activeTab=e}}},[t._v("\n            "+t._s(e.title)+"\n        ")])})),0),t._v(" "),t._t("default")],2)}),[],!1,null,null,null).exports},1900:(t,e,i)=>{"use strict";function n(t,e,i,n,s,o,a,r){var l,c="function"==typeof t?t.options:t;if(e&&(c.render=e,c.staticRenderFns=i,c._compiled=!0),n&&(c.functional=!0),o&&(c._scopeId="data-v-"+o),a?(l=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),s&&s.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(a)},c._ssrRegister=l):s&&(l=r?function(){s.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:s),l)if(c.functional){c._injectStyles=l;var u=c.render;c.render=function(t,e){return l.call(e),u(t,e)}}else{var h=c.beforeCreate;c.beforeCreate=h?[].concat(h,l):[l]}return{exports:t,options:c}}i.d(e,{Z:()=>n})}}]);