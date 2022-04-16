"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[4847],{2053:(e,t,i)=>{i.r(t),i.d(t,{default:()=>r});const o={components:{"form-input":function(){return Promise.all([i.e(5816),i.e(1531)]).then(i.bind(i,9668))},"form-checkbox":function(){return Promise.all([i.e(5816),i.e(7279)]).then(i.bind(i,966))},loader:function(){return i.e(8540).then(i.bind(i,2756))}},props:{name:{required:!0,type:String},email:{required:!0,type:String}},data:function(){return{isSubmitting:!1,fields:{name:"",email:"",password:"",password_confirmation:"",terms:!1},validity:{password:!1,password_confirmation:!1,terms:!1},errors:{password:"",password_confirmation:"",generic:""}}},mounted:function(){var e=this;this.fields.name=this.name,this.fields.email=this.email,Object.keys(this.fields).forEach((function(t){e.$root.$on("".concat(t,"-error"),(function(){e.validity[t]=!1})),e.$root.$on("".concat(t,"-valid"),(function(){e.validity[t]=!0})),e.$root.$on("".concat(t,"-value"),(function(i){e.fields[t]=i}))})),this.$root.$on("terms-change",(function(t){e.fields.terms=t,e.validity.terms=t}))},methods:{submitRegistration:function(){var e=this;this.validateForm()?(this.isSubmitting=!0,coeliac().request().post("/api/member/register",this.fields).then((function(){window.location="/member/dashboard"})).catch((function(t){422===t.response.status&&t.response.data.errors.email&&"Your email is already associated with an account!"===t.response.data.errors.email[0]?coeliac().error("Your email is already associated with an account, please log in to view your order history!"):(coeliac().error("Please correct any errors before continuing!"),e.fields.password="",e.validity.password=!1,e.fields.password_confirmation="",e.validity.password_confirmation=!1,e.fields.terms=!1,e.validity.terms=!1,e.$root.$emit("password-set-value",""),e.$root.$emit("password_confirmation-set-value",""),e.$root.$emit("terms-set-value",!1))})).finally((function(){e.isSubmitting=!1}))):coeliac().error("Please complete all fields!")},validateForm:function(){var e=this;Object.keys(this.validity).forEach((function(t){e.$root.$emit("".concat(t,"-get-value"))}));var t=!0;return Object.keys(this.validity).forEach((function(i){!1===e.validity[i]&&(t=!1)})),t}}};const r=(0,i(1900).Z)(o,(function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("div",{staticClass:"bg-white bg-opacity-50 rounded-lg mb-2 p-2 shadow lg:w-1/3 mr-2"},[i("p",{staticClass:"text-center font-semibold"},[e._v("\n    Why not create an account with us to be able to see your order history, create and manage\n    personal scrapbooks, get notified about places to eat near you, and much more!\n  ")]),e._v(" "),i("form",{staticClass:"flex flex-col space-y-2 mt-2",on:{submit:function(t){return t.preventDefault(),e.submitRegistration.apply(null,arguments)}}},[i("form-input",{attrs:{type:"password",name:"password",autocomplete:"password",placeholder:"Password",required:"",min:8,value:e.fields.password}}),e._v(" "),i("form-input",{attrs:{type:"password",name:"password_confirmation",autocomplete:"password_confirmation",placeholder:"Confirm Your Password",required:"",min:8,value:e.fields.password_confirmation,match:e.fields.password}}),e._v(" "),i("form-checkbox",{attrs:{required:"",name:"terms","input-size":"text-base",label:"I accept the <a href='/terms-of-use' target='_blank' class='font-semibold hover:underline'>Terms and Conditions</a>",value:e.fields.terms}}),e._v(" "),i("button",{staticClass:"rounded-lg bg-blue leading-none text-lg font-semibold text-white hover:bg-blue-light transition-all flex items-center justify-center",class:e.isSubmitting?"py-2":"py-3",staticStyle:{height:"42px"},attrs:{disabled:e.isSubmitting},on:{click:function(t){return t.preventDefault(),e.submitRegistration.apply(null,arguments)}}},[e.isSubmitting?i("loader",{attrs:{"background-position":"",show:!0,height:"25px",width:"25px","border-width":"3px","faded-border-color":"border-white border-opacity-50","primary-border-color":"white"}}):i("span",[e._v("Join now!")])],1)],1)])}),[],!1,null,null,null).exports}}]);