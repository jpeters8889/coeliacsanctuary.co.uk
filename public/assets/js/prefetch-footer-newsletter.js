(self.webpackChunk=self.webpackChunk||[]).push([[264],{5107:(e,t,r)=>{"use strict";r.d(t,{Z:()=>s});const s={data:function(){return{email:""}},methods:{submit:function(){var e=this;""!==this.email?coeliac().request().post("/api/newsletter",{email:this.email,url:window.location.href}).then((function(t){if(200===t.status)return e.email="",void coeliac().success("Thanks for subscribing to our newsletter!");409!==t.status?coeliac().error("There was an error subscribing you to our newsletter, please try again..."):coeliac().error("You're already subscribed to our newsletter!")})).catch((function(){coeliac().error("There was an error subscribing you to our newsletter, please try again...")})):coeliac().error("Please enter your email address")}}}},45:(e,t,r)=>{"use strict";r.r(t),r.d(t,{default:()=>i});const s={mixins:[r(5107).Z]};const i=(0,r(1900).Z)(s,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"w-full flex flex-col justify-center sm:flex-row"},[r("input",{directives:[{name:"model",rawName:"v-model",value:e.email,expression:"email"}],staticClass:"flex-1 leading-none mb-2 rounded border border-grey-lightest p-1 sm:mr-2 sm:py-2",attrs:{type:"email",placeholder:"Enter your email address..."},domProps:{value:e.email},on:{input:function(t){t.target.composing||(e.email=t.target.value)}}}),e._v(" "),r("div",{staticClass:"text-center"},[r("button",{staticClass:"bg-yellow leading-none py-2 px-4 rounded-lg sm:border-t sm:border-yellow sm:leading-tight",on:{click:function(t){return e.submit()}}},[e._v("\n            Subscribe!\n        ")])])])}),[],!1,null,null,null).exports}}]);