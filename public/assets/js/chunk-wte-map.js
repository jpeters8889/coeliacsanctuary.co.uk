(self.webpackChunk=self.webpackChunk||[]).push([[7529],{3779:(e,t,n)=>{"use strict";n.r(t),n.d(t,{default:()=>i});const a={data:function(){return{loaded:!1,map:null}},components:{loader:function(){return n.e(8540).then(n.bind(n,2287))}},mounted:function(){var e=this;coeliac().request().get("/api/wheretoeat/settings").then((function(t){e.map=new FlaMap(t.data),e.map.draw("map-container"),e.loaded=!0,setTimeout((function(){window.dispatchEvent(new Event("resize"))}),100)})),this.$root.$on("tab-map-active",(function(){setTimeout((function(){window.dispatchEvent(new Event("resize"))}),100)}))}};const i=(0,n(1900).Z)(a,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"relative h-auto",staticStyle:{"min-height":"100px"}},[n("loader",{directives:[{name:"show",rawName:"v-show",value:!e.loaded,expression:"!loaded"}]}),e._v(" "),n("div",{directives:[{name:"show",rawName:"v-show",value:e.loaded,expression:"loaded"}],attrs:{id:"map-container"}})],1)}),[],!1,null,null,null).exports}}]);