(self.webpackChunk=self.webpackChunk||[]).push([[500],{9081:(e,t,r)=>{"use strict";r.d(t,{Z:()=>a});const a={methods:{googleEvent:function(e,t){var r=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};window.gtag&&window.gtag(e,t,r)}}}},2102:(e,t,r)=>{"use strict";r.d(t,{Z:()=>a});const a={data:function(){return{hasError:!1,showError:!1,errorText:"",currentValue:""}},props:{type:{type:String,default:"text"},name:{type:String,required:!0},value:{type:String,default:""},placeholder:{type:String,default:""},required:{type:Boolean,default:!1},disabled:{type:Boolean,default:!1},min:{type:Number,default:null},max:{type:Number,default:null},pattern:{type:RegExp,default:null},patternError:{type:String,default:"Field is Invalid"},match:{type:String,default:null}},mounted:function(){var e=this;this.currentValue=this.value,this.required&&""===this.currentValue&&(this.hasError=!0),this.$root.$on(this.name+"-get-value",(function(){e.validate(),e.$root.$emit(e.name+"-value",e.currentValue)})),this.$root.$on(this.name+"-set-value",(function(t){e.currentValue=t,e.hasError=!0,e.validate()})),this.$root.$on(this.name+"-reset",(function(){e.currentValue="",e.showError=!1})),this.$root.$on(this.name+"-validate",(function(){e.hasError=!0,e.validate()}))},methods:{validate:function(){if(this.showError=!0,this.required&&""===this.currentValue)return this.errorText="Field is required",void this.pushError();if(this.pattern&&(this.required||""!==this.currentValue)&&!this.currentValue.match(this.pattern))return this.errorText=this.patternError,void this.pushError();if(this.match&&this.currentValue!==this.match)return this.errorText="Field does not match",void this.pushError();switch(this.type){case"email":if(!this.checkEmail())return this.errorText="Must be a valid email address",void this.pushError()}this.hasError=!1,this.errorText="",this.$root.$emit(this.name+"-valid")},checkEmail:function(){return/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(this.currentValue)},pushError:function(){this.hasError=!0,this.$root.$emit(this.name+"-error",this.errorText)}},watch:{hasError:function(){this.hasError?this.$root.$emit(this.name+"-error",this.errorText):this.$root.$emit(this.name+"-valid")},currentValue:function(e){this.$root.$emit(this.name+"-change",e)}}}},7289:(e,t,r)=>{"use strict";r.d(t,{Z:()=>n});var a=r(3645),o=r.n(a)()((function(e){return e[1]}));o.push([e.id,"input:focus{outline:none}input:-webkit-autofill{background:none}",""]);const n=o},1777:(e,t,r)=>{"use strict";r.d(t,{Z:()=>n});var a=r(3645),o=r.n(a)()((function(e){return e[1]}));o.push([e.id,"input:focus{outline:none}input:-webkit-autofill{background:none}",""]);const n=o},4600:(e,t,r)=>{"use strict";r.d(t,{Z:()=>s});var a=r(511),o=r(6631);const n={components:{"form-input":a.Z,"form-textarea":o.Z},data:function(){return{formData:{name:"",subject:"",email:"",message:""},validity:{name:!1,subject:!1,email:!1,message:!1}}},mounted:function(){var e=this;Object.keys(this.validity).forEach((function(t){e.$root.$on("".concat(t,"-error"),(function(){e.validity[t]=!1})),e.$root.$on("".concat(t,"-valid"),(function(){e.validity[t]=!0})),e.$root.$on("".concat(t,"-value"),(function(r){e.formData[t]=r}))}))},methods:{submitForm:function(){var e=this;this.validateForm()&&coeliac().request().post("/api/contact",this.formData).then((function(t){if(200===t.status)return Object.keys(e.validity).forEach((function(t){e.formData[t]="",e.$root.$emit("".concat(t,"-reset"))})),void coeliac().success("Thanks, your message has been sent!");coeliac().error("Sorry, there was an error submitting your message, please try again.")})).catch((function(){coeliac().error("Sorry, there was an error submitting your message, please try again.")}))},validateForm:function(){var e=this;Object.keys(this.validity).forEach((function(t){e.$root.$emit("".concat(t,"-get-value"))}));var t=!0;return Object.keys(this.validity).forEach((function(r){!1===e.validity[r]&&(t=!1)})),t}}};const s=(0,r(1900).Z)(n,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"js-contact-form"},[r("div",{staticClass:"flex mt-2 flex-col"},[r("p",{staticClass:"mb-5 flex-1"},[e._v("\n            Need to get in touch with the Coeliac Sanctuary team? Complete this form and we'll get back to you as\n            soon as we can!\n        ")]),e._v(" "),r("p",{staticClass:"mb-5 flex-1"},[e._v("\n            Before you complete this form why not check our frequently asked questions, your question may have\n            already been answered!\n        ")]),e._v(" "),r("p",{staticClass:"mb-5 flex-1"},[e._v("\n            Are you suggesting a location to add to our Eating Out guide? Please use our Place Request form instead.\n        ")]),e._v(" "),r("div",{staticClass:"mb-5 flex-1"},[r("form-input",{attrs:{required:"",name:"name",value:e.formData.name,placeholder:"Your name..."}})],1),e._v(" "),r("div",{staticClass:"mb-5 flex-1"},[r("form-input",{attrs:{required:"",name:"subject",value:e.formData.subject,placeholder:"Your Subject..."}})],1),e._v(" "),r("div",{staticClass:"mb-5 flex-1"},[r("form-input",{attrs:{required:"",name:"email",type:"email",value:e.formData.email,placeholder:"Your e  mail..."}})],1),e._v(" "),r("div",{staticClass:"mb-5 flex-1"},[r("form-textarea",{attrs:{required:"",name:"message",value:e.formData.message,rows:10,placeholder:"Your message..."}})],1)]),e._v(" "),r("button",{staticClass:"mt-2 bg-blue-50 border border-blue rounded-lg px-6 py-2 text-xl text-black transition-bg hover:bg-blue-20",on:{click:function(t){return t.preventDefault(),e.submitForm()}}},[e._v("\n        Send Message\n    ")])])}),[],!1,null,null,null).exports},5262:(e,t,r)=>{"use strict";r.r(t),r.d(t,{default:()=>i});var a=r(9081),o=r(4600),n=r(931);const s={mixins:[a.Z],components:{"contact-form":o.Z,modal:n.Z},props:{open:{type:Boolean,default:!1},redirect:{type:String,default:null},inline:{type:Boolean,default:!1}},data:function(){return{showContact:!1}},mounted:function(){var e=this;this.open&&(this.showContact=!0),this.$root.$on("hide-contact-form",(function(){e.closeModal()})),this.$root.$on("modal-closed",(function(){e.closeModal()}))},methods:{closeModal:function(){this.showContact=!1,this.redirect&&(window.location.href=this.redirect)}},watch:{showContact:function(){this.showContact&&this.googleEvent("event","contact-form",{event_category:"toggled"})}}};const i=(0,r(1900).Z)(s,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{class:e.inline?"inline-block":""},[r("div",{class:e.inline?"inline-block":"",attrs:{n:""},on:{click:function(t){e.showContact=!0}}},[e._t("default")],2),e._v(" "),e.showContact?r("portal",{attrs:{to:"modal"}},[r("modal",[r("contact-form")],1)],1):e._e()],1)}),[],!1,null,null,null).exports},511:(e,t,r)=>{"use strict";r.d(t,{Z:()=>l});const a={mixins:[r(2102).Z]};var o=r(3379),n=r.n(o),s=r(7289),i={insert:"head",singleton:!1};n()(s.Z,i);s.Z.locals;const l=(0,r(1900).Z)(a,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"flex overflow-hidden border border-blue rounded"},[r("div",{staticClass:"bg-grey-lightest p-0 flex-1"},["checkbox"===e.type?r("input",{directives:[{name:"model",rawName:"v-model",value:e.currentValue,expression:"currentValue"}],staticClass:"w-full bg-transparent border-0 p-3 m-0 text-grey-darkest",class:e.disabled?"text-grey-light cursor:not-allowed":"",attrs:{name:e.name,placeholder:e.placeholder,min:e.min,max:e.max,disabled:e.disabled,type:"checkbox"},domProps:{checked:Array.isArray(e.currentValue)?e._i(e.currentValue,null)>-1:e.currentValue},on:{blur:function(t){return e.validate()},change:function(t){var r=e.currentValue,a=t.target,o=!!a.checked;if(Array.isArray(r)){var n=e._i(r,null);a.checked?n<0&&(e.currentValue=r.concat([null])):n>-1&&(e.currentValue=r.slice(0,n).concat(r.slice(n+1)))}else e.currentValue=o}}}):"radio"===e.type?r("input",{directives:[{name:"model",rawName:"v-model",value:e.currentValue,expression:"currentValue"}],staticClass:"w-full bg-transparent border-0 p-3 m-0 text-grey-darkest",class:e.disabled?"text-grey-light cursor:not-allowed":"",attrs:{name:e.name,placeholder:e.placeholder,min:e.min,max:e.max,disabled:e.disabled,type:"radio"},domProps:{checked:e._q(e.currentValue,null)},on:{blur:function(t){return e.validate()},change:function(t){e.currentValue=null}}}):r("input",{directives:[{name:"model",rawName:"v-model",value:e.currentValue,expression:"currentValue"}],staticClass:"w-full bg-transparent border-0 p-3 m-0 text-grey-darkest",class:e.disabled?"text-grey-light cursor:not-allowed":"",attrs:{name:e.name,placeholder:e.placeholder,min:e.min,max:e.max,disabled:e.disabled,type:e.type},domProps:{value:e.currentValue},on:{blur:function(t){return e.validate()},input:function(t){t.target.composing||(e.currentValue=t.target.value)}}})]),e._v(" "),e.hasError&&e.showError?r("div",{directives:[{name:"tooltip",rawName:"v-tooltip.left",value:{content:e.errorText,classes:["bg-red","border-red","text-white"],boundariesElement:"body"},expression:"{content: errorText, classes: ['bg-red', 'border-red', 'text-white'], boundariesElement: 'body'}",modifiers:{left:!0}}],staticClass:"bg-red flex justify-center items-center p-2 text-white"},[r("font-awesome-icon",{attrs:{icon:["fas","exclamation-circle"]}})],1):e._e()])}),[],!1,null,null,null).exports},6631:(e,t,r)=>{"use strict";r.d(t,{Z:()=>l});const a={mixins:[r(2102).Z],props:{rows:{type:Number,default:3}}};var o=r(3379),n=r.n(o),s=r(1777),i={insert:"head",singleton:!1};n()(s.Z,i);s.Z.locals;const l=(0,r(1900).Z)(a,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"flex overflow-hidden border border-blue rounded"},[r("div",{staticClass:"bg-grey-lightest flex-1"},[r("textarea",{directives:[{name:"model",rawName:"v-model",value:e.currentValue,expression:"currentValue"}],staticClass:"w-full bg-transparent border-0 p-3 m-0 text-grey-darkest",attrs:{name:e.name,placeholder:e.placeholder,rows:e.rows,maxlength:e.max},domProps:{value:e.currentValue},on:{blur:function(t){return e.validate()},input:function(t){t.target.composing||(e.currentValue=t.target.value)}}})]),e._v(" "),e.hasError&&e.showError?r("div",{directives:[{name:"tooltip",rawName:"v-tooltip",value:{content:e.errorText,classes:["bg-red","border-red","text-white"]},expression:"{content: errorText, classes: ['bg-red', 'border-red', 'text-white']}"}],staticClass:"bg-red flex justify-center p-2 text-white pt-3"},[r("font-awesome-icon",{attrs:{icon:["fas","exclamation-circle"]}})],1):e._e()])}),[],!1,null,null,null).exports},931:(e,t,r)=>{"use strict";r.d(t,{Z:()=>o});const a={props:{name:{type:String,default:""},modalClasses:{type:Array|String,default:function(){return[]}},small:{type:Boolean,default:!1}},mounted:function(){var e=this;document.querySelector("body").classList.add("overflow-hidden"),this.$root.$on("close-modal",(function(t){t&&t!==e.name||e.close()}))},methods:{close:function(){document.querySelector("body").classList.remove("overflow-hidden"),this.$root.$emit("modal-closed",this.name)}},computed:{computedClasses:function(){var e=this.modalClasses;Array.isArray(e)||(e=e.split(" "));var t="max-w-modal";return this.small&&(t="max-w-modal-small"),e.push(t),e}}};const o=(0,r(1900).Z)(a,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"z-max fixed inset-0 w-full h-full bg-black-80 flex justify-center items-center",on:{click:function(t){return t.target!==t.currentTarget?null:e.close()}}},[r("div",{staticClass:"h-auto max-h-3/4 shadow p-2 border-2 border-blue-light w-auto rounded-lg bg-blue-light overflow-y-scroll",class:e.computedClasses},[r("div",{staticClass:"h-full relative"},[r("div",{staticClass:"absolute top-0 right-0 bg-white p-1 -mt-1 -mr-1 leading-none z-50 rounded border border-black cursor-pointer transition-bg",on:{click:function(t){return e.close()}}},[r("font-awesome-icon",{attrs:{icon:["fas","times"]}})],1),e._v(" "),r("div",{staticClass:"h-full w-full bg-white-80 p-2 rounded"},[e._t("default")],2)])])])}),[],!1,null,null,null).exports}}]);