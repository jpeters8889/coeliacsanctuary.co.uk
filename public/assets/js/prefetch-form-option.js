(self.webpackChunk=self.webpackChunk||[]).push([[588],{2102:(t,e,r)=>{"use strict";r.d(e,{Z:()=>n});var i=r(538),s=r(3034);i.default.use(s.ZP);const n={data:function(){return{hasError:!1,showError:!1,errorText:"",currentValue:""}},props:{type:{type:String,default:"text"},name:{type:String,required:!0},value:{type:String,default:""},placeholder:{type:String,default:""},required:{type:Boolean,default:!1},disabled:{type:Boolean,default:!1},min:{type:Number,default:null},max:{type:Number,default:null},pattern:{type:RegExp,default:null},patternError:{type:String,default:"Field is Invalid"},match:{type:String,default:null}},mounted:function(){var t=this;this.currentValue=this.value,this.required&&""===this.currentValue&&(this.hasError=!0),this.$root.$on(this.name+"-get-value",(function(){t.validate(),t.$root.$emit(t.name+"-value",t.currentValue)})),this.$root.$on(this.name+"-set-value",(function(e){t.currentValue=e,t.hasError=!0,t.validate()})),this.$root.$on(this.name+"-reset",(function(){t.currentValue="",t.showError=!1})),this.$root.$on(this.name+"-validate",(function(){t.hasError=!0,t.validate()}))},methods:{validate:function(){if(this.showError=!0,this.required&&""===this.currentValue)return this.errorText="Field is required",void this.pushError();if(this.pattern&&(this.required||""!==this.currentValue)&&!this.currentValue.match(this.pattern))return this.errorText=this.patternError,void this.pushError();if(this.match&&this.currentValue!==this.match)return this.errorText="Field does not match",void this.pushError();switch(this.type){case"email":if(!this.checkEmail())return this.errorText="Must be a valid email address",void this.pushError()}this.hasError=!1,this.errorText="",this.$root.$emit(this.name+"-valid")},checkEmail:function(){return/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(this.currentValue)},pushError:function(){this.hasError=!0,this.$root.$emit(this.name+"-error",this.errorText)}},watch:{hasError:function(){this.hasError?this.$root.$emit(this.name+"-error",this.errorText):this.$root.$emit(this.name+"-valid")},currentValue:function(t){this.$root.$emit(this.name+"-change",t)}}}},4055:(t,e,r)=>{"use strict";r.d(e,{Z:()=>n});var i=r(3645),s=r.n(i)()((function(t){return t[1]}));s.push([t.id,"input:focus{outline:none}input:-webkit-autofill{background:none}",""]);const n=s},5142:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>u});const i={mixins:[r(2102).Z],props:{options:{required:!0,type:Array},label:{required:!0,type:String}},methods:{changeOption:function(t){this.currentValue=t,this.validate()}}};var s=r(3379),n=r.n(s),a=r(4055),o={insert:"head",singleton:!1};n()(a.Z,o);a.Z.locals;const u=(0,r(1900).Z)(i,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"flex flex-col"},[r("span",{staticClass:"font-semibold text-lg mb-2"},[t._v(t._s(t.label))]),t._v(" "),t._l(t.options,(function(e){return r("div",{staticClass:"flex items-center cursor-pointer",on:{click:function(r){return t.changeOption(e.value)}}},[r("div",{staticClass:"p-2 pl-0"},[r("div",{staticClass:"border border-grey-off bg-grey-lightest p-1 text-xl",class:e.value===t.currentValue?"text-green":"text-grey-off-light"},[r("font-awesome-icon",{attrs:{icon:["fas","check"]}})],1)]),t._v(" "),r("div",{staticClass:"flex-1"},[t._v("\n            "+t._s(e.label)+"\n        ")])])}))],2)}),[],!1,null,null,null).exports}}]);