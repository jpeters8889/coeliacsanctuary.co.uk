"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[3426],{5107:(e,t,r)=>{r.d(t,{Z:()=>n});const n={data:function(){return{email:""}},methods:{submit:function(){var e=this;""!==this.email?coeliac().request().post("/api/newsletter",{email:this.email,url:window.location.href}).then((function(t){if(200===t.status)return e.email="",void coeliac().success("Thanks for subscribing to our newsletter!");409!==t.status?coeliac().error("There was an error subscribing you to our newsletter, please try again..."):coeliac().error("You're already subscribed to our newsletter!")})).catch((function(){coeliac().error("There was an error subscribing you to our newsletter, please try again...")})):coeliac().error("Please enter your email address")}}}},6685:(e,t,r)=>{r.r(t),r.d(t,{default:()=>s});const n={mixins:[r(5107).Z]};const s=(0,r(1900).Z)(n,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"w-full flex flex-col justify-center sm:flex-row"},[r("input",{directives:[{name:"model",rawName:"v-model",value:e.email,expression:"email"}],staticClass:"flex-1 leading-none mb-2 rounded border border-grey-lightest p-1 sm:mr-2 sm:py-2",attrs:{type:"email",placeholder:"Enter your email address..."},domProps:{value:e.email},on:{input:function(t){t.target.composing||(e.email=t.target.value)}}}),e._v(" "),r("div",{staticClass:"text-center"},[r("button",{staticClass:"bg-yellow leading-none py-2 px-4 rounded-lg sm:border-t sm:border-yellow sm:leading-tight",on:{click:function(t){return e.submit()}}},[e._v("\n      Subscribe!\n    ")])])])}),[],!1,null,null,null).exports},1900:(e,t,r)=>{function n(e,t,r,n,s,o,i,a){var l,c="function"==typeof e?e.options:e;if(t&&(c.render=t,c.staticRenderFns=r,c._compiled=!0),n&&(c.functional=!0),o&&(c._scopeId="data-v-"+o),i?(l=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),s&&s.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(i)},c._ssrRegister=l):s&&(l=a?function(){s.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:s),l)if(c.functional){c._injectStyles=l;var u=c.render;c.render=function(e,t){return l.call(t),u(e,t)}}else{var d=c.beforeCreate;c.beforeCreate=d?[].concat(d,l):[l]}return{exports:e,options:c}}r.d(t,{Z:()=>n})}}]);