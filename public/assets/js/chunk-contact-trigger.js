(self.webpackChunk=self.webpackChunk||[]).push([[1174],{9081:(t,n,o)=>{"use strict";o.d(n,{Z:()=>e});const e={methods:{googleEvent:function(t,n){var o=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};window.gtag&&window.gtag(t,n,o)}}}},8201:(t,n,o)=>{"use strict";o.r(n),o.d(n,{default:()=>c});const e={mixins:[o(9081).Z],components:{"contact-form":function(){return o.e(1636).then(o.bind(o,3422))},modal:function(){return o.e(5441).then(o.bind(o,931))}},props:{open:{type:Boolean,default:!1},redirect:{type:String,default:null},inline:{type:Boolean,default:!1}},data:function(){return{showContact:!1}},mounted:function(){var t=this;this.open&&(this.showContact=!0),this.$root.$on("hide-contact-form",(function(){t.closeModal()})),this.$root.$on("modal-closed",(function(){t.closeModal()}))},methods:{closeModal:function(){this.showContact=!1,this.redirect&&(window.location.href=this.redirect)}},watch:{showContact:function(){this.showContact&&this.googleEvent("event","contact-form",{event_category:"toggled"})}}};const c=(0,o(1900).Z)(e,(function(){var t=this,n=t.$createElement,o=t._self._c||n;return o("div",{class:t.inline?"inline-block":""},[o("div",{class:t.inline?"inline-block":"",attrs:{n:""},on:{click:function(n){t.showContact=!0}}},[t._t("default")],2),t._v(" "),t.showContact?o("portal",{attrs:{to:"modal"}},[o("modal",[o("contact-form")],1)],1):t._e()],1)}),[],!1,null,null,null).exports}}]);