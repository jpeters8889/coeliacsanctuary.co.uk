"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[5006],{1828:(o,t,e)=>{e.r(t),e.d(t,{default:()=>i});const n={mixins:[e(9081).Z],props:{group:{type:String,default:""},name:{type:String,required:!0}},data:function(){return{showBody:!1}},watch:{showBody:function(o){o&&this.$scrollTo("#accordion-".concat(this.name),500,{offset:-200})}},methods:{toggleAccordion:function(){var o=this;this.googleEvent("event","accordion",{event_category:"toggled-accordion-".concat(this.name),event_label:this.name}),this.showBody=!this.showBody,this.$root.$emit("accordion-toggled",{group:this.group,name:this.name,visible:this.showBody}),this.$root.$emit("accordion-hide",{group:this.group,name:this.name}),this.$root.$on("accordion-hide",(function(t){t.group&&t.group===o.group&&t.name!==o.name&&(o.showBody=!1)}))}}};const i=(0,e(1900).Z)(n,(function(){var o=this,t=o.$createElement,e=o._self._c||t;return e("div",{attrs:{id:"accordion-"+o.name}},[e("div",{on:{click:function(t){return o.toggleAccordion()}}},[o._t("title")],2),o._v(" "),e("div",{directives:[{name:"show",rawName:"v-show",value:o.showBody,expression:"showBody"}],staticClass:"overflow-hidden"},[e("div",{class:o.showBody?"slide-down":""},[o._t("body")],2)])])}),[],!1,null,null,null).exports}}]);