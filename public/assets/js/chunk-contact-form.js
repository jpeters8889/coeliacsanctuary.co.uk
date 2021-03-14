(self.webpackChunk=self.webpackChunk||[]).push([[1636],{3422:(e,t,a)=>{"use strict";a.r(t),a.d(t,{default:()=>r});const o={components:{"form-input":function(){return Promise.all([a.e(5816),a.e(1531)]).then(a.bind(a,511))},"form-textarea":function(){return Promise.all([a.e(5816),a.e(993)]).then(a.bind(a,6631))}},data:function(){return{formData:{name:"",subject:"",email:"",message:""},validity:{name:!1,subject:!1,email:!1,message:!1}}},mounted:function(){var e=this;Object.keys(this.validity).forEach((function(t){e.$root.$on("".concat(t,"-error"),(function(){e.validity[t]=!1})),e.$root.$on("".concat(t,"-valid"),(function(){e.validity[t]=!0})),e.$root.$on("".concat(t,"-value"),(function(a){e.formData[t]=a}))}))},methods:{submitForm:function(){var e=this;this.validateForm()&&coeliac().request().post("/api/contact",this.formData).then((function(t){if(200===t.status)return Object.keys(e.validity).forEach((function(t){e.formData[t]="",e.$root.$emit("".concat(t,"-reset"))})),void coeliac().success("Thanks, your message has been sent!");coeliac().error("Sorry, there was an error submitting your message, please try again.")})).catch((function(){coeliac().error("Sorry, there was an error submitting your message, please try again.")}))},validateForm:function(){var e=this;Object.keys(this.validity).forEach((function(t){e.$root.$emit("".concat(t,"-get-value"))}));var t=!0;return Object.keys(this.validity).forEach((function(a){!1===e.validity[a]&&(t=!1)})),t}}};const r=(0,a(1900).Z)(o,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"js-contact-form"},[a("div",{staticClass:"flex mt-2 flex-col"},[a("p",{staticClass:"mb-5 flex-1"},[e._v("\n            Need to get in touch with the Coeliac Sanctuary team? Complete this form and we'll get back to you as\n            soon as we can!\n        ")]),e._v(" "),a("p",{staticClass:"mb-5 flex-1"},[e._v("\n            Before you complete this form why not check our frequently asked questions, your question may have\n            already been answered!\n        ")]),e._v(" "),a("p",{staticClass:"mb-5 flex-1"},[e._v("\n            Are you suggesting a location to add to our Eating Out guide? Please use our Place Request form instead.\n        ")]),e._v(" "),a("div",{staticClass:"mb-5 flex-1"},[a("form-input",{attrs:{required:"",name:"name",value:e.formData.name,placeholder:"Your name..."}})],1),e._v(" "),a("div",{staticClass:"mb-5 flex-1"},[a("form-input",{attrs:{required:"",name:"subject",value:e.formData.subject,placeholder:"Your Subject..."}})],1),e._v(" "),a("div",{staticClass:"mb-5 flex-1"},[a("form-input",{attrs:{required:"",name:"email",type:"email",value:e.formData.email,placeholder:"Your e  mail..."}})],1),e._v(" "),a("div",{staticClass:"mb-5 flex-1"},[a("form-textarea",{attrs:{required:"",name:"message",value:e.formData.message,rows:10,placeholder:"Your message..."}})],1)]),e._v(" "),a("button",{staticClass:"mt-2 bg-blue-50 border border-blue rounded-lg px-6 py-2 text-xl text-black transition-bg hover:bg-blue-20",on:{click:function(t){return t.preventDefault(),e.submitForm()}}},[e._v("\n        Send Message\n    ")])])}),[],!1,null,null,null).exports}}]);