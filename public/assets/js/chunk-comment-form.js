"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[302],{4207:(t,e,r)=>{r.r(e),r.d(e,{default:()=>i});function a(t,e){var r=Object.keys(t);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(t);e&&(a=a.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),r.push.apply(r,a)}return r}function o(t,e,r){return e in t?Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[e]=r,t}const n={components:{"form-input":function(){return Promise.all([r.e(5816),r.e(1531)]).then(r.bind(r,9668))},"form-textarea":function(){return Promise.all([r.e(5816),r.e(993)]).then(r.bind(r,8817))}},mixins:[r(3425).Z],props:{area:{type:String,required:!0},id:{type:Number,required:!0}},data:function(){return{formData:{name:"",email:"",comment:""},validity:{name:!1,email:!1,comment:!1}}},mounted:function(){var t=this;Object.keys(this.validity).forEach((function(e){t.$root.$on("".concat(e,"-error"),(function(){t.validity[e]=!1})),t.$root.$on("".concat(e,"-valid"),(function(){t.validity[e]=!0})),t.$root.$on("".concat(e,"-value"),(function(r){t.formData[e]=r}))})),this.isLoggedIn()&&(this.formData.name=window.config.user.name,this.formData.email=window.config.user.email)},methods:{submitForm:function(){var t=this;this.validateForm()&&coeliac().request().post("/api/comments",function(t){for(var e=1;e<arguments.length;e++){var r=null!=arguments[e]?arguments[e]:{};e%2?a(Object(r),!0).forEach((function(e){o(t,e,r[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(r)):a(Object(r)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(r,e))}))}return t}({area:this.area,id:this.id},this.formData)).then((function(e){if(200===e.status)return Object.keys(t.validity).forEach((function(e){t.formData[e]="",t.$root.$emit("".concat(e,"-reset"))})),void coeliac().success("Thanks, your comment has been submitted and is awaiting approval!");coeliac().error("Sorry, there was an error submitting your comment, please try again.")}))},validateForm:function(){var t=this;Object.keys(this.validity).forEach((function(e){t.$root.$emit("".concat(e,"-get-value"))}));var e=!0;return Object.keys(this.validity).forEach((function(r){!1===t.validity[r]&&(e=!1)})),e}}};const i=(0,r(1900).Z)(n,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"page-box p-3 mt-3"},[r("h2",{staticClass:"text-2xl my-2 font-semibold font-coeliac"},[t._v("\n    Submit a Comment\n  ")]),t._v(" "),r("p",[t._v("Want to leave a comment on this "+t._s(t.area)+"? Feel free to join the discussion!")]),t._v(" "),r("div",{staticClass:"flex mt-2 flex-col"},[r("div",{staticClass:"mb-5 flex-1"},[r("form-input",{attrs:{required:"",name:"name",value:t.formData.name,placeholder:"Your name..."}})],1),t._v(" "),r("div",{staticClass:"mb-5 flex-1"},[r("form-input",{attrs:{required:"",name:"email",type:"email",value:t.formData.email,placeholder:"Your email..."}})],1),t._v(" "),r("div",{staticClass:"mb-5 flex-1"},[r("form-textarea",{attrs:{required:"",name:"comment",value:t.formData.comment,rows:10,placeholder:"Your comment..."}})],1)]),t._v(" "),r("p",{staticClass:"-mt-2 text-sm italic"},[t._v("\n    Note, your email address will never be displayed with your comment, it is only\n    required to alert you when your comment has been approved or if the Coeliac Sanctuary team reply to your\n    comment.\n  ")]),t._v(" "),r("button",{staticClass:"mt-2 bg-blue bg-opacity-50 border border-blue rounded-lg px-6 py-2 text-xl text-black transition-all hover:bg-opacity-20",on:{click:function(e){return e.preventDefault(),t.submitForm()}}},[t._v("\n    Submit Comment\n  ")])])}),[],!1,null,null,null).exports}}]);