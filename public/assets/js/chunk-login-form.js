"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[4823],{206:(t,e,i)=>{i.r(e),i.d(e,{default:()=>r});const o={components:{"form-input":function(){return Promise.all([i.e(5816),i.e(1531)]).then(i.bind(i,9668))},loader:function(){return i.e(8540).then(i.bind(i,2756))}},data:function(){return{isSubmitting:!1,needsToVerify:!1,fields:{email:"",password:""},validity:{email:!1,password:!1}}},mounted:function(){var t=this;Object.keys(this.fields).forEach((function(e){t.$root.$on("".concat(e,"-error"),(function(){t.validity[e]=!1})),t.$root.$on("".concat(e,"-valid"),(function(){t.validity[e]=!0})),t.$root.$on("".concat(e,"-value"),(function(i){t.fields[e]=i}))}))},methods:{attemptLogin:function(){var t=this;this.validateForm()?(this.isSubmitting=!0,coeliac().request().post("/api/member/login",this.fields).then((function(){window.location="/member/dashboard"})).catch((function(){t.fields.password="",t.validity.password=!1,t.$root.$emit("password-set-value",""),coeliac().error("There was an error logging you in...")})).finally((function(){t.isSubmitting=!1}))):coeliac().error("Please enter your email and password!")},validateForm:function(){var t=this;Object.keys(this.validity).forEach((function(e){t.$root.$emit("".concat(e,"-get-value"))}));var e=!0;return Object.keys(this.validity).forEach((function(i){!1===t.validity[i]&&(e=!1)})),e}}};const r=(0,i(1900).Z)(o,(function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"flex justify-center items-center"},[i("form",{staticClass:"p-4 flex flex-col space-y-4 w-full max-w-lg",on:{submit:function(e){return e.preventDefault(),t.attemptLogin.apply(null,arguments)}}},[i("div",{staticClass:"mx-auto",staticStyle:{width:"50px"}},[i("global-layout-coeliac-icon",{attrs:{colour:"#80CCFC"}})],1),t._v(" "),i("form-input",{attrs:{type:"email",required:"",name:"email",label:"Email Address",value:t.fields.email,autocomple:"email"}}),t._v(" "),i("form-input",{attrs:{type:"password",required:"",name:"password",label:"Password",value:t.fields.password,autocomplete:"password"}}),t._v(" "),i("button",{staticClass:"rounded-lg bg-blue leading-none text-lg font-semibold text-white hover:bg-blue-light transition-all flex items-center justify-center",class:t.isSubmitting?"py-2":"py-3",staticStyle:{height:"42px"},attrs:{disabled:t.isSubmitting},on:{click:function(e){return e.preventDefault(),t.attemptLogin.apply(null,arguments)}}},[t.isSubmitting?i("loader",{attrs:{"background-position":"",show:!0,height:"25px",width:"25px","border-width":"3px","faded-border-color":"border-white border-opacity-50","primary-border-color":"white"}}):i("span",[t._v("Log In")])],1),t._v(" "),t.needsToVerify?i("div",{staticClass:"border-red border p-2 rounded-sm bg-red bg-opacity-20 text-red font-semibold"},[t._v("\n      You need to verify your email address before you can login,\n      "),i("a",{staticClass:"text-black",attrs:{href:""}},[t._v("Resend verification email")]),t._v(".\n    ")]):t._e(),t._v(" "),t._m(0)],1)])}),[function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"flex justify-between text-xs mt-2 font-semibold"},[i("a",{staticClass:"text-blue hover:text-grey",attrs:{href:"/member/register"}},[t._v("Sign up!")]),t._v(" "),i("a",{staticClass:"text-blue hover:text-grey",attrs:{href:"/member/forgot-password"}},[t._v("Forgotten Password?")])])}],!1,null,null,null).exports}}]);