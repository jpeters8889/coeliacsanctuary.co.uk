(self.webpackChunk=self.webpackChunk||[]).push([[554],{9081:(t,e,s)=>{"use strict";s.d(e,{Z:()=>r});const r={methods:{googleEvent:function(t,e){var s=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};window.gtag&&window.gtag(t,e,s)}}}},2394:(t,e,s)=>{"use strict";s.d(e,{Z:()=>r});s(2732);const r={methods:{loadLazyImages:function(){coeliac().updateLazyloader()}},computed:{lazyLoadSrc:function(){return"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"}}}},9225:(t,e,s)=>{"use strict";s.r(e),s.d(e,{default:()=>v});var r=s(2394);const a={props:{result:{type:Object,required:!0}}},l={mixins:[a,r.Z]};var n=s(1900);const i=(0,n.Z)(l,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"flex flex-col p-2 xs:flex-row"},[s("div",{staticClass:"mb-2 xs:mb-0 xs:mr-2 xs:w-1/6"},[s("img",{staticClass:"lazy",attrs:{"data-src":t.result.image,src:t.lazyLoadSrc,loading:"lazy",alt:t.result.title}})]),t._v(" "),s("div",{staticClass:"flex-1 flex flex-col"},[s("h2",{staticClass:"text-blue font-semibold mb-2"},[s("a",{attrs:{href:t.result.link}},[t._v("\n                Blog - "+t._s(t.result.title)+"\n            ")])]),t._v(" "),s("p",{staticClass:"text-sm"},[t._v(t._s(t.result.description))])])])}),[],!1,null,null,null).exports;const c={mixins:[a]};const o=(0,n.Z)(c,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"flex flex-col p-2 xs:flex-row"},[s("div",{staticClass:"mb-2 xs:mb-0 xs:mr-2 xs:w-1/6"},[s("static-map",{attrs:{lat:t.result.lat,lng:t.result.lng,mapClasses:["h-48 xs:h-16"]}})],1),t._v(" "),s("div",{staticClass:"flex-1 flex flex-col"},[s("h2",{staticClass:"text-blue font-semibold mb-2"},[s("a",{attrs:{href:t.result.link}},[t._v("\n                Eatery - "+t._s(t.result.title)+", "+t._s(t.result.town)+", "+t._s(t.result.county)+"\n            ")])]),t._v(" "),s("p",{staticClass:"text-sm"},[t._v(t._s(t.result.description))])])])}),[],!1,null,null,null).exports;const u={mixins:[a]};const f=(0,n.Z)(u,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"flex flex-col p-2 xs:flex-row"},[s("div",{staticClass:"mb-2 xs:mb-0 xs:mr-2 xs:w-1/6"},[s("recipe-image",{attrs:{src:t.result.image,alt:t.result.title}})],1),t._v(" "),s("div",{staticClass:"flex-1 flex flex-col"},[s("h2",{staticClass:"text-blue font-semibold mb-2"},[s("a",{attrs:{href:t.result.link}},[t._v("\n                Recipe - "+t._s(t.result.title)+"\n            ")])]),t._v(" "),s("p",{staticClass:"text-sm"},[t._v(t._s(t.result.description))])])])}),[],!1,null,null,null).exports;const g={mixins:[a,r.Z]};const d=(0,n.Z)(g,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"flex flex-col p-2 xs:flex-row"},[s("div",{staticClass:"mb-2 xs:mb-0 xs:mr-2 xs:w-1/6"},[s("img",{staticClass:"lazy",attrs:{"data-src":t.result.image,src:t.lazyLoadSrc,loading:"lazy",alt:t.result.title}})]),t._v(" "),s("div",{staticClass:"flex-1 flex flex-col"},[s("h2",{staticClass:"text-blue font-semibold mb-2"},[s("a",{attrs:{href:t.result.link}},[t._v("\n                Review - "+t._s(t.result.title)+"\n            ")])]),t._v(" "),s("p",{staticClass:"text-sm"},[t._v(t._s(t.result.description))])])])}),[],!1,null,null,null).exports;const h={mixins:[a,r.Z]};const m=(0,n.Z)(h,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"flex flex-col p-2 xs:flex-row"},[s("div",{staticClass:"mb-2 xs:mb-0 xs:mr-2 xs:w-1/6"},[s("img",{staticClass:"lazy",attrs:{"data-src":t.result.image,src:t.lazyLoadSrc,loading:"lazy",alt:t.result.title}})]),t._v(" "),s("div",{staticClass:"flex-1 flex flex-col"},[s("h2",{staticClass:"text-blue font-semibold mb-2"},[s("a",{attrs:{href:t.result.link}},[t._v("\n                Shop Product - "+t._s(t.result.title)+"\n            ")])]),t._v(" "),s("p",{staticClass:"text-sm"},[t._v(t._s(t.result.description))])])])}),[],!1,null,null,null).exports;const x={mixins:[s(9081).Z,r.Z],props:{term:{required:!0,type:String}},components:{loader:function(){return s.e(8540).then(s.bind(s,2287))},"form-input":function(){return Promise.all([s.e(931),s.e(1531)]).then(s.bind(s,511))},"form-checkbox":function(){return Promise.all([s.e(931),s.e(7279)]).then(s.bind(s,5455))},pagination:function(){return s.e(7929).then(s.bind(s,9720))},"search-blog-result":i,"search-eatery-result":o,"search-recipe-result":f,"search-review-result":d,"search-shop-product-result":m},data:function(){return{isSticky:!1,areas:{blogs:!0,reviews:!0,recipes:!0,eateries:!1,products:!0},currentTerm:"",timeout:null,currentPage:1,lastPage:1,loading:!0,results:[]}},mounted:function(){var t=this;this.currentTerm=this.term,""===this.currentTerm&&(this.loading=!1,coeliac().error("Please enter a search term...")),this.$root.$on("term-change",(function(e){t.currentTerm=e})),this.$root.$on("pagination-click",(function(e){t.googleEvent("event",t.title,{event_category:"navigate-page",event_label:e}),"next"===e&&(e=t.currentPage+1),"prev"===e&&(e=t.currentPage-1),t.currentPage=e,t.runSearch(),t.$scrollTo(t.$refs.items,500,{offset:-200})})),Object.keys(this.areas).forEach((function(e){t.$root.$on("".concat(e,"-change"),(function(s){t.areas[e]=!!s}))})),new IntersectionObserver((function(e){0!==window.scrollY?t.isSticky=0===e[0].intersectionRatio:t.isSticky=!1})).observe(document.querySelector("#searchCheck")),this.parseUrl(),this.runSearch()},methods:{runSearch:function(){var t=this;""!==this.currentTerm?coeliac().request().post("/api/search?page=".concat(this.currentPage),{term:this.currentTerm,areas:this.areas}).then((function(e){t.lastPage=e.data.last_page,t.results=e.data.data})).catch((function(){t.results=[],coeliac().error("Sorry, there was an error running your search.")})).finally((function(){t.loading=!1,t.updateUrl(),t.updateTitle(),t.loadLazyImages()})):this.results=[]},updateUrl:function(){var t=new URLSearchParams(window.location.search);t.set("q",this.currentTerm),t.set("f",btoa(JSON.stringify(this.areas))),history.pushState(null,"","".concat(window.location.origin).concat(window.location.pathname,"?").concat(t.toString()))},updateTitle:function(){var t=document.querySelector("title"),e=t.innerText.split(" | ");e[0]=this.currentTerm,t.innerHTML=e.join(" | ")},labelFor:function(t){return"products"===t?"Shop":t.charAt(0).toUpperCase()+t.slice(1)},resultComponent:function(t){switch(t){case"blogs":return"search-blog-result";case"eateries":return"search-eatery-result";case"reviews":return"search-review-result";case"recipes":return"search-recipe-result";case"products":return"search-shop-product-result"}},parseUrl:function(){var t=this,e=new URLSearchParams(window.location.search);if(e.has("f")){var s=JSON.parse(atob(e.get("f")));JSON.stringify(Object.keys(s))===JSON.stringify(Object.keys(this.areas))&&(this.areas=s,Object.keys(s).forEach((function(e){t.$root.$on("".concat(e,"-set-value"),s[e])})))}}},computed:{filterClasses:function(){var t=["p-2","flex","flex-col","lg:border","border-blue","lg:rounded-lg"];return this.isSticky?t.concat(["bottom-0","left-0","bg-yellow","slide-up","w-full","z-max","lg:bg-grey-lightest","fixed","lg:sticky","lg:no-animation","lg:top-130px","lg:bottom-auto","lg:z-auto"]):t.concat(["bg-blue-light-20","lg:bg-grey-lightest"])}},watch:{currentTerm:function(t,e){var s=this;""!==e&&t!==e&&""!==t&&(clearTimeout(this.timeout),this.timeout=setTimeout((function(){s.currentPage=1,s.runSearch()}),500))},areas:{deep:!0,handler:function(){this.updateUrl(),""===this.currentTerm||this.loading||this.runSearch()}}}};const v=(0,n.Z)(x,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("div",{staticClass:"flex flex-col lg:flex-row"},[s("div",{staticClass:"lg:w-1/4 lg:mr-4 lg:relative"},[s("div",{attrs:{id:"searchCheck"}}),t._v(" "),s("div",{class:t.filterClasses},[s("div",[s("form-input",{attrs:{type:"search",name:"term",required:"",max:50,value:t.currentTerm}})],1),t._v(" "),s("div",{staticClass:"leading-none flex flex-wrap justify-center text-xs lg:flex-no-wrap lg:flex-col"},t._l(t.areas,(function(e,r){return s("div",{staticClass:"px-1 lg:my-1"},[s("form-checkbox",{attrs:{value:e,label:t.labelFor(r),"input-size":"text-xs lg:text-base",name:r}})],1)})),0)])]),t._v(" "),t.loading?s("div",{staticClass:"relative h-32 lg:flex-1"},[s("loader",{attrs:{show:!0}})],1):s("div",{ref:"items",staticClass:"flex-1 flex flex-col mt-2 lg:mt-0"},[s("pagination",{attrs:{current:t.currentPage,lastPage:t.lastPage,"can-go-back":t.currentPage>1,"can-go-forward":t.currentPage<t.lastPage}}),t._v(" "),s("div",{staticClass:"my-2"},[t._l(t.results,(function(e,r){return t.results.length>0?s("div",{staticClass:"border-b border-grey-off-light leading-tight",class:r%2==0?"bg-grey-light":""},[s(t.resultComponent(e.type),{key:e.type+"-"+e.id,tag:"component",attrs:{result:e}})],1):t._e()})),t._v(" "),0===t.results.length?s("div",[s("em",[t._v("No results found...")])]):t._e()],2),t._v(" "),s("pagination",{attrs:{current:t.currentPage,lastPage:t.lastPage,"can-go-back":t.currentPage>1,"can-go-forward":t.currentPage<t.lastPage}})],1)])])}),[],!1,null,null,null).exports}}]);