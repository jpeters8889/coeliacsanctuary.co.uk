(self.webpackChunk=self.webpackChunk||[]).push([[19],{9081:(t,e,o)=>{"use strict";o.d(e,{Z:()=>n});const n={methods:{googleEvent:function(t,e){var o=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};window.gtag&&window.gtag(t,e,o)}}}},5239:(t,e,o)=>{"use strict";o.r(e),o.d(e,{default:()=>i});const n={mixins:[o(9081).Z],components:{modal:function(){return o.e(5441).then(o.bind(o,3516))}},data:function(){return{showModal:!1,modal:{id:"",text:"",link:"",image:""}}},mounted:function(){var t=this;coeliac().request().get("/api/popup").then((function(e){200===e.status&&Object.values(e.data).length>0&&(t.modal=e.data,setTimeout((function(){t.showModal=!0,t.googleEvent("event","view-promotion",{event_label:"loaded"})}),6e3))})),this.$root.$on("modal-closed",(function(){t.showModal=!1,t.modal.id&&coeliac().request().patch("/api/popup/".concat(t.modal.id))}))},methods:{clickedPopup:function(t){this.googleEvent("event","view-promotion",{event_label:"clicked"}),window.location.href=modal.link}}};const i=(0,o(1900).Z)(n,(function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",[t.showModal?o("portal",{attrs:{to:"modal"}},[o("modal",{attrs:{small:""}},[o("a",{staticClass:"flex flex-col",attrs:{href:t.modal.link},on:{click:function(e){return e.preventDefault(),t.clickedPopup(e)}}},[o("div",[o("img",{attrs:{src:t.modal.image,alt:t.modal.text}})]),t._v(" "),o("div",{staticClass:"flex justify-center"},[o("div",{staticClass:"w-3/4 text-center",domProps:{innerHTML:t._s(t.modal.text)}})])])])],1):t._e()],1)}),[],!1,null,null,null).exports},1900:(t,e,o)=>{"use strict";function n(t,e,o,n,i,a,s,l){var r,d="function"==typeof t?t.options:t;if(e&&(d.render=e,d.staticRenderFns=o,d._compiled=!0),n&&(d.functional=!0),a&&(d._scopeId="data-v-"+a),s?(r=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),i&&i.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(s)},d._ssrRegister=r):i&&(r=l?function(){i.call(this,(d.functional?this.parent:this).$root.$options.shadowRoot)}:i),r)if(d.functional){d._injectStyles=r;var c=d.render;d.render=function(t,e){return r.call(e),c(t,e)}}else{var u=d.beforeCreate;d.beforeCreate=u?[].concat(u,r):[r]}return{exports:t,options:d}}o.d(e,{Z:()=>n})}}]);