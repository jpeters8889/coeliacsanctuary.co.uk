"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[19],{9081:(t,e,o)=>{o.d(e,{Z:()=>n});const n={methods:{googleEvent:function(t,e){var o=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};window.gtag&&window.gtag(t,e,o)}}}},3189:(t,e,o)=>{o.r(e),o.d(e,{default:()=>a});const n={components:{modal:function(){return o.e(5441).then(o.bind(o,1024))}},mixins:[o(9081).Z],data:function(){return{showModal:!1,modal:{id:"",text:"",link:"",image:""}}},mounted:function(){var t=this;window.innerWidth<=360||(coeliac().request().get("/api/popup").then((function(e){200===e.status&&Object.values(e.data).length>0&&(t.modal=e.data,setTimeout((function(){t.showModal=!0,coeliac().request().patch("/api/popup/".concat(t.modal.id)),t.googleEvent("event","view_promotion",{event_category:"view-main-shop-popup",event_label:"loaded-global-shop-cta"})}),6e3))})),this.$root.$on("modal-closed",(function(){t.showModal=!1})))},methods:{clickedPopup:function(){this.googleEvent("event","view_promotion",{event_label:"clicked-global-shop-cta",promotions:[{id:"shop-popup",name:"global-shop-popup"}]}),window.location.href=this.modal.link}}};const a=(0,o(1900).Z)(n,(function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",[t.showModal?o("portal",{attrs:{to:"modal"}},[o("modal",{attrs:{small:"",footer:t.modal.text}},[o("a",{staticClass:"flex flex-col",attrs:{href:t.modal.link},on:{click:function(e){return e.preventDefault(),t.clickedPopup(e)}}},[o("img",{attrs:{src:t.modal.image,alt:t.modal.text}})])])],1):t._e()],1)}),[],!1,null,null,null).exports},1900:(t,e,o)=>{function n(t,e,o,n,a,i,l,s){var r,d="function"==typeof t?t.options:t;if(e&&(d.render=e,d.staticRenderFns=o,d._compiled=!0),n&&(d.functional=!0),i&&(d._scopeId="data-v-"+i),l?(r=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),a&&a.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(l)},d._ssrRegister=r):a&&(r=s?function(){a.call(this,(d.functional?this.parent:this).$root.$options.shadowRoot)}:a),r)if(d.functional){d._injectStyles=r;var c=d.render;d.render=function(t,e){return r.call(e),c(t,e)}}else{var p=d.beforeCreate;d.beforeCreate=p?[].concat(p,r):[r]}return{exports:t,options:d}}o.d(e,{Z:()=>n})}}]);