(self.webpackChunk=self.webpackChunk||[]).push([[454],{2394:(t,e,l)=>{"use strict";l.d(e,{Z:()=>n});l(2732);const n={methods:{loadLazyImages:function(){coeliac().updateLazyloader()}},computed:{lazyLoadSrc:function(){return"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"}}}},2685:(t,e,l)=>{"use strict";l.r(e),l.d(e,{default:()=>r});const n={mixins:[l(2394).Z],data:function(){return{hoveringOn:"",navigation:{home:{label:"Home",link:"/",children:null},shop:{label:"Shop",link:"/shop",children:null},blogs:{label:"Blogs",link:"/blog",children:null},eatingOut:{label:"Eating Out",link:"/eating-out",children:null},recipes:{label:"Recipes",link:"/recipe",children:null},collections:{label:"Collections",link:"/collection",children:null},info:{label:"Info",link:"/info",children:null}}}},mounted:function(){var t=this;coeliac().request().get("/api/navigation").then((function(e){Object.keys(e.data).forEach((function(l){t.navigation[l]&&(t.navigation[l].children=e.data[l])})),null!==t.navigation.collections.children&&0!==t.navigation.collections.children.items.length||t.$root.$delete(t.navigation,"collections"),t.loadLazyImages()}))},watch:{hoveringOn:function(){Object.values(this.navigation).map((function(t){return t.label})).includes(this.hoveringOn)&&document.querySelectorAll("img.lazy").forEach((function(t){t.hasAttribute("data-src")&&(t.setAttribute("src",t.getAttribute("data-src")),t.removeAttribute("data-src"),t.classList.remove("lazy"))}))}}};var i=l(1900);const a=(0,i.Z)(n,(function(){var t=this,e=t.$createElement,l=t._self._c||e;return l("nav",{staticClass:"text-lg text-black h-full leading-loose w-full js-primary-nav"},[l("ul",{staticClass:"flex relative"},t._l(t.navigation,(function(e){return l("li",{staticClass:"border-b-4 border-transparent hover:border-white-80 cursor:pointer",on:{mouseenter:function(l){t.hoveringOn=e.label},mouseleave:function(e){t.hoveringOn=""}}},[l("a",{staticClass:"py-2 px-4",attrs:{href:e.link}},[t._v("\n                "+t._s(e.label)+"\n            ")]),t._v(" "),e.children?l("div",{directives:[{name:"show",rawName:"v-show",value:t.hoveringOn===e.label,expression:"hoveringOn === item.label"}],staticClass:"absolute z-max bg-grey-lightest p-2 w-full left-0 shadow-2xl"},["3x5"===e.children.layout||"3"===e.children.layout?[l("div",{staticClass:"flex"},[l("ul",{staticClass:"w-3/5"},t._l(e.children.items,(function(e,n){return n<3?l("li",{staticClass:"py-2 mr-4 hover:bg-yellow-40 transition-bg",class:n<2?"border-b border-yellow":""},[l("a",{staticClass:"flex",attrs:{href:e.link}},[l("div",{staticClass:"w-1/4 mr-1 lg:w-1/6"},[l("img",{staticClass:"lazy",attrs:{"data-src":e.main_image+"?nav",src:t.lazyLoadSrc,loading:"lazy",alt:e.title}})]),t._v(" "),l("div",{staticClass:"leading-none flex-1"},[l("h3",{staticClass:"mb-1 font-medium"},[t._v(t._s(e.title))]),t._v(" "),l("p",{staticClass:"text-sm"},[t._v(t._s(e.meta_description))])])])]):t._e()})),0),t._v(" "),"3x5"===e.children.layout?l("ul",{staticClass:"w-2/5 text-base leading-none flex flex-col py-2"},[t._l(e.children.items,(function(n,i){return i>=3?l("li",{staticClass:"mb-3",class:i===e.children.items.length-1?"flex-1":""},[l("a",{attrs:{href:e.link+"/"+n.slug}},[t._v(t._s(n.title))])]):t._e()})),t._v(" "),l("li",[l("link-button",{attrs:{href:e.link,rounded:""}},[t._v("See All "+t._s(e.label))])],1)],2):t._e()])]:t._e(),t._v(" "),"list"===e.children.layout?[l("ul",{staticClass:"flex flex-wrap text-base leading-none py-2"},t._l(e.children.items,(function(e){return l("li",{staticClass:"w-1/2 mb-2 hover:underline"},[e.label&&e.link?l("a",{staticClass:"block w-full",attrs:{href:e.link}},[t._v("\n                                "+t._s(e.label)+"\n                            ")]):t._e(),t._v(" "),e.component?[l(e.component,{tag:"component",staticClass:"block w-full cursor-pointer"},[t._v("\n                                    "+t._s(e.label)+"\n                                ")])]:t._e()],2)})),0)]:t._e()],2):t._e()])})),0)])}),[],!1,null,null,null).exports,s={props:{transparent:{required:!1,type:Boolean,default:function(){return!1}}},data:function(){return{stickyNav:!1}},components:{"coeliac-nav":a},mounted:function(){var t=this;new IntersectionObserver((function(e){0!==window.scrollY?t.stickyNav=0===e[0].intersectionRatio:t.stickyNav=!1})).observe(document.querySelector("#top-bar-check"))},computed:{backgroundClasses:function(){return this.stickyNav?["top-0","bg-blue","slide-down"]:this.transparent?[]:["bg-blue-80","md:bg-blue"]},width:function(){return window.innerWidth}}};const r=(0,i.Z)(s,(function(){var t=this,e=t.$createElement,l=t._self._c||e;return l("div",{staticClass:"w-full"},[l("div",{staticClass:"z-max w-full px-2 py-0 text-white text-3xl md:p-0 z-10",class:t.backgroundClasses,style:t.stickyNav?"position: fixed!important;":"",attrs:{id:"top-bar"}},[l("div",{staticClass:"flex justify-between items-center inner-wrapper md:relative py-2 md:py-0"},[l("mobile-nav",{staticClass:"mr-2 md:hidden"}),t._v(" "),l("a",{attrs:{href:"/"}},[l("coeliac-icon",{staticClass:"js-mob-icon text-white md:hidden",staticStyle:{height:"1.875rem"}})],1),t._v(" "),t.width>500?l("coeliac-nav",{staticClass:"hidden md:block"}):t._e(),t._v(" "),l("header-search",{staticClass:"h-full flex items-center md:absolute md:right-0 md:top-0 md:mr-2"})],1)]),t._v(" "),l("div",{attrs:{id:"top-bar-check"}})])}),[],!1,null,null,null).exports}}]);