(self.webpackChunk=self.webpackChunk||[]).push([[5006],{9081:(o,t,e)=>{"use strict";e.d(t,{Z:()=>n});const n={methods:{googleEvent:function(o,t){var e=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};window.gtag&&window.gtag(o,t,e)}}}},4168:(o,t,e)=>{"use strict";e.r(t),e.d(t,{default:()=>i});const n={mixins:[e(9081).Z],props:{group:{type:String},name:{type:String,required:!0}},data:function(){return{showBody:!1}},methods:{toggleAccordion:function(){var o=this;this.googleEvent("event","accordion",{event_category:"toggled",event_label:this.name}),this.showBody=!this.showBody,this.$root.$emit("accordion-toggled",{group:this.group,name:this.name,visible:this.showBody}),this.$root.$emit("accordion-hide",{group:this.group,name:this.name}),this.$root.$on("accordion-hide",(function(t){t.group&&t.group===o.group&&t.name!==o.name&&(o.showBody=!1)}))}},watch:{showBody:function(o){o&&this.$scrollTo("#accordion-"+this.name,500,{offset:-200})}}};const i=(0,e(1900).Z)(n,(function(){var o=this,t=o.$createElement,e=o._self._c||t;return e("div",{attrs:{id:"accordion-"+o.name}},[e("div",{on:{click:function(t){return o.toggleAccordion()}}},[o._t("title")],2),o._v(" "),e("div",{directives:[{name:"show",rawName:"v-show",value:o.showBody,expression:"showBody"}],staticClass:"overflow-hidden"},[e("div",{class:o.showBody?"slide-down":""},[o._t("body")],2)])])}),[],!1,null,null,null).exports},1900:(o,t,e)=>{"use strict";function n(o,t,e,n,i,s,r,d){var a,c="function"==typeof o?o.options:o;if(t&&(c.render=t,c.staticRenderFns=e,c._compiled=!0),n&&(c.functional=!0),s&&(c._scopeId="data-v-"+s),r?(a=function(o){(o=o||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(o=__VUE_SSR_CONTEXT__),i&&i.call(this,o),o&&o._registeredComponents&&o._registeredComponents.add(r)},c._ssrRegister=a):i&&(a=d?function(){i.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:i),a)if(c.functional){c._injectStyles=a;var h=c.render;c.render=function(o,t){return a.call(t),h(o,t)}}else{var l=c.beforeCreate;c.beforeCreate=l?[].concat(l,a):[a]}return{exports:o,options:c}}e.d(t,{Z:()=>n})}}]);