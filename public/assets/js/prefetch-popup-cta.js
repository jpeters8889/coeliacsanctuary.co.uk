(self.webpackChunk=self.webpackChunk||[]).push([[1580],{9081:(t,e,o)=>{"use strict";o.d(e,{Z:()=>n});const n={methods:{googleEvent:function(t,e){var o=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};window.gtag&&window.gtag(t,e,o)}}}},8215:(t,e,o)=>{"use strict";o.r(e),o.d(e,{default:()=>l});const n={mixins:[o(9081).Z],components:{modal:function(){return o.e(5869).then(o.bind(o,931))}},data:function(){return{showModal:!1,modal:{id:"",text:"",link:"",image:""}}},mounted:function(){var t=this;coeliac().request().get("/api/popup").then((function(e){200===e.status&&Object.values(e.data).length>0&&(t.modal=e.data,setTimeout((function(){t.showModal=!0,t.googleEvent("event","view-promotion",{event_label:"loaded"})}),6e3))})),this.$root.$on("modal-closed",(function(){t.showModal=!1,t.modal.id&&coeliac().request().patch("/api/popup/".concat(t.modal.id))}))},methods:{clickedPopup:function(t){this.googleEvent("event","view-promotion",{event_label:"clicked"}),window.location.href=modal.link}}};const l=(0,o(1900).Z)(n,(function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",[t.showModal?o("portal",{attrs:{to:"modal"}},[o("modal",{attrs:{small:""}},[o("a",{staticClass:"flex flex-col",attrs:{href:t.modal.link},on:{click:function(e){return e.preventDefault(),t.clickedPopup(e)}}},[o("div",[o("img",{attrs:{src:t.modal.image,alt:t.modal.text}})]),t._v(" "),o("div",{staticClass:"flex justify-center"},[o("div",{staticClass:"w-3/4 text-center",domProps:{innerHTML:t._s(t.modal.text)}})])])])],1):t._e()],1)}),[],!1,null,null,null).exports}}]);