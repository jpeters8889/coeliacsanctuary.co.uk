(self.webpackChunk=self.webpackChunk||[]).push([[7739],{4893:(t,e,s)=>{"use strict";s.r(e),s.d(e,{default:()=>i});const n={mixins:[{methods:{viewBasket:function(){this.$root.$emit("show-basket")}}}],data:function(){return{items:0}},mounted:function(){var t=this;this.getSummary(),this.$root.$on("basket-updated",(function(){t.getSummary()}))},methods:{getSummary:function(){var t=this;coeliac().request().get("/api/shop/basket").then((function(e){200===e.status&&(t.items=e.data.quantity)}))}},computed:{itemText:function(){return 1===this.items?"item":"items"}}};const i=(0,s(1900).Z)(n,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"mx-2 p-3 border-blue border rounded bg-blue-light-50 my-2 flex flex-col text-center sm:flex-row sm:text-left sm:justify-between"},[s("span",[t._v("You have "),s("strong",[t._v(t._s(t.items))]),t._v(" "+t._s(t.itemText)+" in your basket.")]),t._v(" "),s("a",{staticClass:"font-semibold hover:underline cursor-pointer",on:{click:function(e){return t.viewBasket()}}},[t._v("\n        View Basket\n    ")])])}),[],!1,null,null,null).exports}}]);