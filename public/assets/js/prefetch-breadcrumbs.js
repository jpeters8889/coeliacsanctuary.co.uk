(self.webpackChunk=self.webpackChunk||[]).push([[162],{9081:(t,e,n)=>{"use strict";n.d(e,{Z:()=>r});const r={methods:{googleEvent:function(t,e){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};window.gtag&&window.gtag(t,e,n)}}}},7004:(t,e,n)=>{"use strict";n.r(e),n.d(e,{default:()=>o});const r={mixins:[n(9081).Z],props:{location:{required:!0,type:String},crumbs:{required:!0,type:Array}},data:function(){return{sticky:!1}},mounted:function(){var t=this;new IntersectionObserver((function(e){t.sticky=0===e[0].intersectionRatio})).observe(document.querySelector("#breadcrumb-check"))},methods:{facebookShare:function(){this.googleEvent("event","share",{event_label:"facebook"}),this.openPopup("https://www.facebook.com/sharer.php?u="+window.location.href,"Share On Facebook")},twitterShare:function(){this.googleEvent("event","share",{event_label:"twitter"}),this.openPopup("https://twitter.com/intent/tweet?text="+document.querySelector("meta[name=description").getAttribute("content")+"&via=CoeliacSanc&url="+window.location.href,"Share on Twitter")},pinterestShare:function(){this.googleEvent("event","share",{event_label:"pinterest"}),this.openPopup("https://www.pinterest.com/pin/create/button/?url="+window.location.href+"&media="+document.querySelector('meta[property="og:image"]').getAttribute("content")+"&description="+document.querySelector("meta[name=description").getAttribute("content"),"Share on Pinterest")},redditShare:function(){this.googleEvent("event","share",{event_label:"reddit"}),this.openPopup("http://www.reddit.com/submit?url="+window.location.href+"&title="+document.querySelector("title").innerText,"Share on Reddit")},openPopup:function(t,e){window.open(t,e,"height=480,width=640,toolbar=no,menubar=no,scrollbars=no,resizable=no,location=no,directories=no,status=no")}}};const o=(0,n(1900).Z)(r,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"hidden xs:block"},[n("div",{staticClass:"my-2 border-grey-off border bg-grey-off-light p-2 leading-none",class:t.sticky?"fixed top-50px slide-down w-full mt-1 z-20":"",attrs:{id:"breadcrumb"}},[n("div",{staticClass:"leading-none inner-wrapper flex flex-col sm:flex-row sm:items-center",style:t.sticky?"max-width: 1500px;":""},[n("div",{staticClass:"flex-1 flex-col flex justify-center flex-wrap mb-2 sm:flex-no-wrap sm:flex-row sm:items-center sm:justify-start sm:m-0 sm:pr-3"},[n("div",{staticClass:"font-thin text-center sm:pr-1"},[t._v("\n                    You're here:\n                ")]),t._v(" "),n("div",{staticClass:"flex flex-wrap my-1 justify-center"},t._l(t.crumbs,(function(e){return n("div",{staticClass:"text-grey-dark font-medium flex justify-start items-center p-1 sm:w-full lg:w-auto"},[n("span",{staticClass:"flex-1"},[n("a",{staticClass:"hover:underline",attrs:{href:e.link}},[t._v(t._s(e.title))])]),t._v(" "),n("span",{staticClass:"text-left pl-1"},[n("font-awesome-icon",{attrs:{icon:["fas","angle-double-right"]}})],1)])})),0),t._v(" "),n("div",{staticClass:"font-medium text-center"},[t._v("\n                    "+t._s(t.location)+"\n                ")])]),t._v(" "),n("div",{staticClass:"flex justify-center"},[n("div",{staticClass:"mr-2 text-3xl text-grey cursor-pointer hover:text-social-facebook transition-color",on:{click:function(e){return e.preventDefault(),t.facebookShare()}}},[n("font-awesome-icon",{attrs:{icon:["fab","facebook-square"]}})],1),t._v(" "),n("div",{staticClass:"mr-2 text-3xl text-grey cursor-pointer hover:text-social-twitter transition-color",on:{click:function(e){return e.preventDefault(),t.twitterShare()}}},[n("font-awesome-icon",{attrs:{icon:["fab","twitter-square"]}})],1),t._v(" "),n("div",{staticClass:"mr-2 text-3xl text-grey cursor-pointer hover:text-social-pinterest transition-color",on:{click:function(e){return e.preventDefault(),t.pinterestShare()}}},[n("font-awesome-icon",{attrs:{icon:["fab","pinterest-square"]}})],1),t._v(" "),n("div",{staticClass:"text-3xl text-grey cursor-pointer hover:text-social-reddit transition-color",on:{click:function(e){return e.preventDefault(),t.redditShare()}}},[n("font-awesome-icon",{attrs:{icon:["fab","reddit-square"]}})],1)])])]),t._v(" "),n("div",{attrs:{id:"breadcrumb-check"}})])}),[],!1,null,null,null).exports}}]);