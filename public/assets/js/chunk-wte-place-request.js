"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[6372],{8800:(e,a,t)=>{t.r(a),t.d(a,{default:()=>l});const r={components:{"form-input":function(){return Promise.all([t.e(5816),t.e(1531)]).then(t.bind(t,9668))},"form-select":function(){return Promise.all([t.e(5816),t.e(4014)]).then(t.bind(t,8219))},"form-textarea":function(){return Promise.all([t.e(5816),t.e(993)]).then(t.bind(t,8817))}},props:{venueTypes:{type:Array,required:!0}},data:function(){return{timeout:null,formData:{name:"",email:"",placeName:"",placeAddress:"",placeWebsite:"",placeType:"",placeDetails:""},validity:{name:!1,email:!1,placeName:!1,placeAddress:!1,placeWebsite:!0,placeType:!0,placeDetails:!1}}},mounted:function(){var e=this;Object.keys(this.validity).forEach((function(a){e.$root.$on("".concat(a,"-error"),(function(){e.validity[a]=!1})),e.$root.$on("".concat(a,"-valid"),(function(){e.validity[a]=!0})),e.$root.$on("".concat(a,"-value"),(function(t){e.formData[a]=t}))}))},methods:{submitForm:function(){var e=this;this.validateForm()?coeliac().request().post("/api/wheretoeat/recommend-a-place",{name:this.formData.name,email:this.formData.email,place_name:this.formData.placeName,place_location:this.formData.placeAddress,place_web_address:this.formData.placeWebsite,place_venue_type_id:this.formData.placeType,place_details:this.formData.placeDetails}).then((function(a){if(200===a.status)return Object.keys(e.validity).forEach((function(a){e.formData[a]="",e.$root.$emit("".concat(a,"-reset"))})),void coeliac().success("Thank you for your recommendation, we'll check it out and add them to our eating out guide!");coeliac().error("Sorry, there was an error submitting your recommendation, please try again.")})).catch((function(){coeliac().error("Sorry, there was an error submitting your recommendation, please try again.")})):coeliac().error("Please complete all required fields before submitting!")},validateForm:function(){var e=this;Object.keys(this.validity).forEach((function(a){e.$root.$emit("".concat(a,"-get-value"))}));var a=!0;return Object.keys(this.validity).forEach((function(t){!1===e.validity[t]&&(a=!1)})),a}}};const l=(0,t(1900).Z)(r,(function(){var e=this,a=e.$createElement,t=e._self._c||a;return t("div",[t("div",{staticClass:"flex mt-2 flex-col space-y-5"},[t("div",{staticClass:"flex-1"},[t("form-input",{attrs:{required:"",name:"name",value:e.formData.name,label:"Your name"}})],1),e._v(" "),t("div",{staticClass:"flex-1"},[t("form-input",{attrs:{required:"",name:"email",type:"email",value:e.formData.email,label:"Your email address"}})],1),e._v(" "),t("hr",{staticClass:"bg-blue border-blue"}),e._v(" "),t("div",{staticClass:"flex-1"},[t("form-input",{attrs:{required:"",name:"placeName",value:e.formData.placeName,label:"Place name"}})],1),e._v(" "),t("div",{staticClass:"flex-1"},[t("form-textarea",{attrs:{required:"",name:"placeAddress",value:e.formData.placeAddress,rows:3,label:"Place location / address"}})],1),e._v(" "),t("div",{staticClass:"flex-1"},[t("form-input",{attrs:{name:"placeWebsite",value:e.formData.placeWebsite,label:"Place web address"}})],1),e._v(" "),t("div",{staticClass:"flex-1"},[t("form-select",{attrs:{name:"placeType",label:"Venue Type",value:e.formData.placeType,options:e.venueTypes,"empty-option":""}})],1),e._v(" "),t("div",{staticClass:"flex-1"},[t("form-textarea",{attrs:{required:"",name:"placeDetails",value:e.formData.placeDetails,rows:5,label:"Place details"}})],1)]),e._v(" "),t("button",{staticClass:"mt-2 bg-blue bg-opacity-50 border border-blue rounded-lg px-6 py-2 text-xl text-black transition-all hover:bg-opacity-20",on:{click:function(a){return a.preventDefault(),e.submitForm()}}},[e._v("\n    Send Recommendation\n  ")])])}),[],!1,null,null,null).exports}}]);