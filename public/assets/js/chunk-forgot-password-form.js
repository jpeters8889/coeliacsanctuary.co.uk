"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[9162],{7324:(t,e,o)=>{o.r(e),o.d(e,{default:()=>r});const i={components:{"form-input":function(){return Promise.all([o.e(5816),o.e(1531)]).then(o.bind(o,6189))},loader:function(){return o.e(8540).then(o.bind(o,6676))}},data:function(){return{isSubmitting:!1,needsToVerify:!1,isCompleted:!1,fields:{email:""},validity:{email:!1}}},mounted:function(){var t=this;Object.keys(this.fields).forEach((function(e){t.$root.$on("".concat(e,"-error"),(function(){t.validity[e]=!1})),t.$root.$on("".concat(e,"-valid"),(function(){t.validity[e]=!0})),t.$root.$on("".concat(e,"-value"),(function(o){t.fields[e]=o})),t.$root.$on("".concat(e,"-change"),(function(o){t.fields[e]=o}))}))},methods:{submitForgotPassword:function(){var t=this;this.validateForm()?(this.isSubmitting=!0,coeliac().request().post("/api/member/forgot-password",this.fields).then((function(){t.isCompleted=!0})).catch((function(){coeliac().error("There was an error processing your forgot password request, please try again!")})).finally((function(){t.isSubmitting=!1}))):coeliac().error("Please enter a valid email address!")},validateForm:function(){var t=this;Object.keys(this.validity).forEach((function(e){t.$root.$emit("".concat(e,"-get-value"))}));var e=!0;return Object.keys(this.validity).forEach((function(o){!1===t.validity[o]&&(e=!1)})),e}}};const r=(0,o(1900).Z)(i,(function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",{staticClass:"page-box p-4 rounded-lg shadow"},[o("div",{staticClass:"max-w-lg mx-auto"},[o("p",{staticClass:"mb-4 text-lg text-center"},[t._v("\n      Forgot your password? Just enter the email associated with your account below and we'll send you a link\n      to\n      reset it!\n    ")]),t._v(" "),t.isCompleted?[o("p",{staticClass:"text-lg font-semibold text-center"},[t._v("\n        Thanks! We've received your request and have sent you a link to reset your email.\n      ")]),t._v(" "),t._m(0)]:o("form",{staticClass:"flex flex-col space-y-4 w-full",on:{submit:function(e){return e.preventDefault(),t.submitForgotPassword.apply(null,arguments)}}},[o("form-input",{attrs:{type:"email",required:"",name:"email",placeholder:"Email Address",value:t.fields.email,autocomple:"email"}}),t._v(" "),o("button",{staticClass:"rounded-lg bg-blue leading-none text-lg font-semibold text-white hover:bg-blue-light transition-all flex items-center justify-center",class:t.isSubmitting?"py-2":"py-3",staticStyle:{height:"42px"},attrs:{disabled:t.isSubmitting},on:{click:function(e){return e.preventDefault(),t.submitForgotPassword.apply(null,arguments)}}},[t.isSubmitting?o("loader",{attrs:{"background-position":"",show:!0,height:"25px",width:"25px","border-width":"3px","faded-border-color":"border-white border-opacity-50","primary-border-color":"white"}}):o("span",[t._v("Submit")])],1)],1)],2)])}),[function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("p",{staticClass:"mt-2 text-center"},[o("a",{attrs:{href:"/"}},[t._v("Back Home")])])}],!1,null,null,null).exports},938:(t,e,o)=>{o.r(e),o.d(e,{default:()=>r});const i={components:{"form-input":function(){return Promise.all([o.e(5816),o.e(1531)]).then(o.bind(o,6189))},loader:function(){return o.e(8540).then(o.bind(o,6676))}},props:{token:{required:!0,type:String}},data:function(){return{isSubmitting:!1,needsToVerify:!1,isCompleted:!1,fields:{token:"",email:"",password:"",password_confirmation:""},validity:{token:!0,email:!1,password:!1,password_confirmation:!1}}},mounted:function(){var t=this;this.fields.token=this.token,Object.keys(this.fields).forEach((function(e){t.$root.$on("".concat(e,"-error"),(function(){t.validity[e]=!1})),t.$root.$on("".concat(e,"-valid"),(function(){t.validity[e]=!0})),t.$root.$on("".concat(e,"-value"),(function(o){t.fields[e]=o})),t.$root.$on("".concat(e,"-change"),(function(o){t.fields[e]=o}))}))},methods:{submitResetPassword:function(){var t=this;this.validateForm()?(this.isSubmitting=!0,coeliac().request().post("/api/member/reset-password",this.fields).then((function(){coeliac().success("You've changed your password!"),t.isCompleted=!0})).catch((function(){coeliac().error("There was an error resetting your password, please try again!")})).finally((function(){t.isSubmitting=!1}))):coeliac().error("Make sure you've completed the form!")},validateForm:function(){var t=this;Object.keys(this.validity).forEach((function(e){t.$root.$emit("".concat(e,"-get-value"))}));var e=!0;return Object.keys(this.validity).forEach((function(o){!1===t.validity[o]&&(e=!1)})),e}}};const r=(0,o(1900).Z)(i,(function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",{staticClass:"rounded-lg border border-blue bg-gradient-to-br from-blue/30 to-blue-light/30 p-4"},[t.isCompleted?[o("p",{staticClass:"text-lg font-semibold text-center"},[t._v("\n      Thanks! We've reset your password, please log in below.\n    ")]),t._v(" "),o("div",{staticClass:"mt-2 text-center"},[o("member-login-form")],1)]:o("form",{staticClass:"flex flex-col space-y-4 w-full max-w-basket-sidebar",on:{submit:function(e){return e.preventDefault(),t.submitResetPassword.apply(null,arguments)}}},[o("form-input",{attrs:{type:"email",required:"",name:"email",placeholder:"Email Address",value:t.fields.email,autocomple:"email"}}),t._v(" "),o("form-input",{attrs:{type:"password",required:"",name:"password",placeholder:"Password",value:t.fields.password,autocomplete:"password"}}),t._v(" "),o("form-input",{attrs:{type:"password",required:"",name:"password_confirmation",placeholder:"Confirm your password",match:t.fields.password,value:t.fields.password_confirmation,autocomplete:"password_confirmation"}}),t._v(" "),o("button",{staticClass:"rounded-lg bg-blue leading-none text-lg font-semibold text-white hover:bg-blue-light transition-all flex items-center justify-center",class:t.isSubmitting?"py-2":"py-3",staticStyle:{height:"42px"},attrs:{disabled:t.isSubmitting},on:{click:function(e){return e.preventDefault(),t.submitResetPassword.apply(null,arguments)}}},[t.isSubmitting?o("loader",{attrs:{"background-position":"",show:!0,height:"25px",width:"25px","border-width":"3px","faded-border-color":"border-white border-opacity-50","primary-border-color":"white"}}):o("span",[t._v("Reset Password")])],1)],1)],2)}),[],!1,null,null,null).exports}}]);