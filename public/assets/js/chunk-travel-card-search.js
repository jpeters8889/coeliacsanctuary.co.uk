"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[4903],{1560:(t,e,s)=>{s.d(e,{Z:()=>r});const r={methods:{formatPrice:function(t){return t=(t/100).toFixed(2),"&pound;".concat(t)}}}},9022:(t,e,s)=>{s.r(e),s.d(e,{default:()=>i});var r=s(2649),a=s.n(r),n=s(1560);const o={components:{"form-input":function(){return Promise.all([s.e(5816),s.e(1531)]).then(s.bind(s,324))},loader:function(){return s.e(8540).then(s.bind(s,2756))}},directives:{ClickOutside:a()},mixins:[n.Z],data:function(){return{timeout:null,term:"",showResultsBox:!1,isLoading:!1,results:[],selectedResult:!1,matchingCards:{},loadingResult:!0}},watch:{term:function(){var t=this;clearTimeout(this.timeout),""!==this.term&&(this.timeout=setTimeout((function(){t.performSearch()}),300))}},mounted:function(){var t=this;this.$root.$on("term-value",(function(e){t.term=e})),this.$root.$on("term-change",(function(e){t.term=e})),this.$root.$on("term-focus",(function(){t.showResultsBox=!0})),this.$root.$on("term-blur",(function(){t.blur()}))},methods:{blur:function(){""===this.term&&(this.showResultsBox=!1)},performSearch:function(){var t=this;this.showResultsBox=!0,this.isLoading=!0,coeliac().request().post("/api/shop/travel-card-search",{term:this.term}).then((function(e){200!==e.status?coeliac().error("There was an error performing your search..."):t.results=e.data.results})).catch((function(){coeliac().error("There was an error performing your search...")})).finally((function(){t.isLoading=!1}))},selectResult:function(t){var e=this;this.showResultsBox=!1,this.loadingResult=!0,this.selectedResult=!0,this.term="",this.$root.$emit("term-set-value",""),coeliac().request().get("/api/shop/travel-card-search/".concat(t.id)).then((function(t){200!==t.status?coeliac().error("There was an error performing your search..."):e.matchingCards=t.data})).catch((function(){coeliac().error("There was an error performing your search...")})).finally((function(){e.loadingResult=!1}))}}};const i=(0,s(1900).Z)(o,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"flex justify-center"},[s("div",{staticClass:"flex flex-col justify-center items-center space-y-4 w-full"},[s("h2",{staticClass:"text-xl font-semibold"},[t._v("\n      Where are you heading?\n    ")]),t._v(" "),s("div",{staticClass:"flex flex-col justify-center items-center space-y-4 sm:w-3/4"},[s("p",{staticClass:"text-center"},[t._v("\n        Enter the country or language below and we'll try and find the best travel card for you!\n      ")]),t._v(" "),s("div",{staticClass:"flex flex-col w-full"},[s("form-input",{attrs:{name:"term",value:t.term,placeholder:"Search for a country or a language...","border-class":"border-grey-off rounded-none rounded-t","on-escape":function(){return t.showResultsBox=!1}}}),t._v(" "),t.showResultsBox?s("div",{directives:[{name:"click-outside",rawName:"v-click-outside",value:t.blur,expression:"blur"}],staticClass:"border-grey-off border-t-0 border rounded-b"},[t.isLoading?s("div",{staticClass:"py-2 text-xs text-grey"},[t._v("\n            >\n            Loading...\n          ")]):[""===t.term?s("div",{staticClass:"py-2 text-xs text-grey"},[t._v("\n              Start typing to search...\n            ")]):0===t.results.length?s("div",{staticClass:"p-3 text-center flex flex-col space-y-2"},[s("div",[t._v("Sorry, nothing found")]),t._v(" "),t._m(0)]):s("ul",t._l(t.results,(function(e){return s("li",{key:e.id,staticClass:"flex space-x-2 text-left border-b border-grey-off transition cursor-pointer hover:bg-grey-lightest last:border-b-0",on:{click:function(s){return t.selectResult(e)}}},[s("span",{staticClass:"flex-1 p-2",domProps:{innerHTML:t._s(e.term)}}),t._v(" "),s("span",{staticClass:"font-semibold bg-grey-off-light text-grey-dark text-xs flex justify-center items-center w-[77px] sm:w-[100px]"},[t._v("\n                  "+t._s(e.type.charAt(0).toUpperCase()+e.type.slice(1))+"\n                ")])])})),0)]],2):t._e()],1)]),t._v(" "),t.selectedResult?s("div",{staticClass:"w-full"},[t.loadingResult?s("div",{staticClass:"w-full min-h-map justify-center items-center relative"},[s("loader",{attrs:{show:!0}})],1):s("div",{staticClass:"flex flex-col justify-between"},["country"===t.matchingCards.type?s("p",{staticClass:"text-lg font-semibold text-center"},[t._v("\n          Here are our travel cards that can be used in\n          "),s("span",{staticClass:"text-blue-dark"},[t._v(t._s(t.matchingCards.term))])]):s("p",{staticClass:"text-lg font-semibold text-center"},[t._v("\n          Here are our travel cards that can be used in\n          "),s("span",{staticClass:"text-blue-dark"},[t._v(t._s(t.matchingCards.term))]),t._v(" speaking areas\n        ")]),t._v(" "),s("div",{staticClass:"flex flex-col justify-around sm:flex-row"},t._l(t.matchingCards.products,(function(e){return s("div",{key:e.id,staticClass:"sm:max-w-half md:max-w-[400px] xl:max-w-[600px]"},[s("div",{staticClass:"w-full p-4 flex flex-col text-center rounded space-y-2"},[s("a",{attrs:{href:e.link}},[s("img",{staticClass:"lazy",attrs:{src:e.image,loading:"lazy",alt:e.title}})]),t._v(" "),s("h2",{staticClass:"text-lg text-blue-dark font-semibold hover:text-grey transition-all"},[s("a",{attrs:{href:e.link}},[t._v("\n                  "+t._s(e.title)+"\n                ")])]),t._v(" "),s("h3",{staticClass:"text-sm"},[t._v("\n                "+t._s(e.category)+"\n              ")]),t._v(" "),s("p",{staticClass:"text-2xl font-semibold leading-none mb-2",domProps:{innerHTML:t._s(t.formatPrice(e.price))}}),t._v(" "),s("p",{staticClass:"mb-2",domProps:{innerHTML:t._s(e.description)}}),t._v(" "),s("div",{staticClass:"flex flex-col leading-none xs:flex-row xs:justify-around"},[s("a",{staticClass:"font-semibold border border-blue rounded p-2 bg-blue-light bg-opacity-50 text-black hover:bg-opacity-20 transition-all mb-2",attrs:{href:e.link}},[t._v("\n                  Find out more\n                ")]),t._v(" "),e.inStock?s("shop-basket-ui-add-product",{attrs:{"product-id":e.id,"variant-id":e.variant_id}},[s("button",{staticClass:"xs:ml-1 w-full font-semibold border border-blue rounded p-2 bg-blue-light bg-opacity50 text-black hover:bg-opacity-20 transition-all mb-2"},[t._v("\n                    Add to Basket\n                  ")])]):s("button",{staticClass:"xs:ml-1 font-semibold border border-blue-light rounded p-2 bg-opacity-20 text-grey cursor-not-allowed mb-2",attrs:{disabled:""}},[t._v("\n                  Out of stock\n                ")])],1)])])})),0)])]):t._e()])])}),[function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[t._v("\n                Make sure you're searching for a country or a language, and not a city or place name,\n                so search "),s("strong",[t._v("France")]),t._v(", not "),s("strong",[t._v("Paris")]),t._v(" for example!\n              ")])}],!1,null,null,null).exports}}]);