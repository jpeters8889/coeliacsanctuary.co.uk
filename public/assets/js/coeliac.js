(self.webpackChunk=self.webpackChunk||[]).push([[307],{5774:(e,n,t)=>{"use strict";var o=t(538),r=t(9665),a=t.n(r),i=t(3034),u=t(9669),d=t.n(u),l=d().create();l.defaults.headers.common["X-CSRF-TOKEN"]=document.querySelector('meta[name="csrf-token"]').content,l.interceptors.response.use((function(e){return e}),(function(e){return e.response>=500&&w.$emit("error",e.response.data.message),Promise.reject(e)}));const c=l;var s=t(7810),f=t(2433),m=t(2732),h=t.n(m),p=t(3081),b=t.n(p);function v(e,n){for(var t=0;t<n.length;t++){var o=n[t];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}var w=function(){function e(n){!function(e,n){if(!(e instanceof n))throw new TypeError("Cannot call a class as a function")}(this,e),this.config=n,this.vue=new o.default,this.hasBuilt=!1,this.lazyLoader=new(h())({elements_selector:".lazy",threshold:10,cancel_on_exit:!0,callback_loaded:function(e){e.removeAttribute("width"),e.removeAttribute("height"),e.style.paddingBottom=0}})}var n,t,r;return n=e,(t=[{key:"build",value:function(){var e=this;o.default.component("font-awesome-icon",s.GN),o.default.use(a(),{position:"bottom-right",duration:6e3}),o.default.use(i.ZP),o.default.use(f.ZP),o.default.use(b()),new o.default({el:"#coeliac",mounted:function(){e.updateLazyloader()}}),o.default.config.productionTip=!1,o.default.config.devtools=!1,o.default.config.errorHandler=function(e,n,t){console.log("Error: ".concat(e.toString(),"\nInfo: ").concat(t))},window.onerror=function(e,n,t,o,r){console.log(e)}}},{key:"updateLazyloader",value:function(){this.lazyLoader.update()}},{key:"request",value:function(){return c}},{key:"$on",value:function(e,n){this.vue.$on(e,n)}},{key:"$emit",value:function(e){for(var n,t=arguments.length,o=new Array(t>1?t-1:0),r=1;r<t;r++)o[r-1]=arguments[r];(n=this.vue).$emit.apply(n,[e].concat(o))}},{key:"getAsset",value:function(e){var n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"images";return"/assets/"+n+"/"+e}},{key:"success",value:function(e){o.default.toasted.show(e,{type:"success"})}},{key:"error",value:function(e){o.default.toasted.show(e,{type:"error"})}}])&&v(n.prototype,t),r&&v(n,r),e}(),g=t(8947),P=t(774),y=t(5337),k=t(9545),I=t(9853),q=t(4659),E=t(8279),L=t(6587),T=t(8395),z=t(561),A=t(9216),x=t(4112),_=t(952),B=t(8686),C=t(1602),N=t(2559),S=t(4444),O=t(1145),U=t(2228),$=t(702),j=t(264),Z=t(8055),D=t(1421),M=t(3461),R=t(1436),Y=t(6767),F=t(98),K=t(6073);var X=t(381),G=t.n(X);window.axios=d(),window.moment=G(),g.vI.add(B.cL),g.vI.add(P.xi),g.vI.add(D.eW),g.vI.add(Z.LE),g.vI.add(O.pt),g.vI.add(U.mT),g.vI.add($.RL),g.vI.add(Y.Kl),g.vI.add(T.Xg),g.vI.add(z.tU),g.vI.add(F.r8),g.vI.add(j.wf),g.vI.add(K.Tw),g.vI.add(y.wn),g.vI.add(_.Yc),g.vI.add(M.T),g.vI.add(R.eJY),g.vI.add(x.En),g.vI.add(k.NB),g.vI.add(N.sz),g.vI.add(S.RY),g.vI.add(A.fk),g.vI.add(I.pZ),g.vI.add(q.sd),g.vI.add(E.Zz),g.vI.add(L.Pq),g.vI.add(C.zs),g.vz.watch();function H(){dataLayer.push(arguments)}o.default.component("accordion",(function(){return Promise.all([t.e(931),t.e(414)]).then(t.bind(t,9917))})),o.default.component("add-basket-trigger",(function(){return Promise.all([t.e(931),t.e(52)]).then(t.bind(t,944))})),o.default.component("announcement",(function(){return Promise.all([t.e(931),t.e(342)]).then(t.bind(t,2956))})),o.default.component("article-image",(function(){return Promise.all([t.e(931),t.e(557)]).then(t.bind(t,2537))})),o.default.component("basket-header-widget",(function(){return Promise.all([t.e(931),t.e(551)]).then(t.bind(t,4893))})),o.default.component("basket-quick-link",(function(){return Promise.all([t.e(931),t.e(726)]).then(t.bind(t,8057))})),o.default.component("basket-page",(function(){return Promise.all([t.e(931),t.e(844)]).then(t.bind(t,2499))})),o.default.component("basket-quantity-swticher",(function(){return Promise.all([t.e(931),t.e(828)]).then(t.bind(t,9869))})),o.default.component("basket-sidebar",(function(){return Promise.all([t.e(931),t.e(946)]).then(t.bind(t,8504))})),o.default.component("breadcrumbs",(function(){return Promise.all([t.e(931),t.e(162)]).then(t.bind(t,7004))})),o.default.component("coeliac-icon",(function(){return Promise.all([t.e(931),t.e(791)]).then(t.bind(t,8431))})),o.default.component("coeliac-home-heros",(function(){return Promise.all([t.e(931),t.e(606)]).then(t.bind(t,6975))})),o.default.component("comment-form",(function(){return Promise.all([t.e(931),t.e(259)]).then(t.bind(t,5598))})),o.default.component("contact-trigger",(function(){return Promise.all([t.e(931),t.e(500)]).then(t.bind(t,5262))})),o.default.component("footer-newsletter",(function(){return Promise.all([t.e(931),t.e(264)]).then(t.bind(t,45))})),o.default.component("full-page-loader",(function(){return Promise.all([t.e(931),t.e(419)]).then(t.bind(t,3165))})),o.default.component("google-ad",(function(){return Promise.all([t.e(931),t.e(719)]).then(t.bind(t,2192))})),o.default.component("header-search",(function(){return Promise.all([t.e(931),t.e(796)]).then(t.bind(t,918))})),o.default.component("link-button",(function(){return Promise.all([t.e(931),t.e(14)]).then(t.bind(t,7293))})),o.default.component("mobile-nav",(function(){return Promise.all([t.e(931),t.e(720)]).then(t.bind(t,3469))})),o.default.component("module-list-index",(function(){return Promise.all([t.e(931),t.e(199)]).then(t.bind(t,8436))})),o.default.component("number-counter",(function(){return Promise.all([t.e(931),t.e(5)]).then(t.bind(t,2230))})),o.default.component("popup-cta",(function(){return Promise.all([t.e(931),t.e(580)]).then(t.bind(t,2349))})),o.default.component("product-add-basket",(function(){return Promise.all([t.e(931),t.e(405)]).then(t.bind(t,6923))})),o.default.component("product-images",(function(){return Promise.all([t.e(931),t.e(107)]).then(t.bind(t,5023))})),o.default.component("quick-search",(function(){return Promise.all([t.e(931),t.e(668)]).then(t.bind(t,1147))})),o.default.component("recipe-image",(function(){return Promise.all([t.e(931),t.e(63)]).then(t.bind(t,8216))})),o.default.component("static-map",(function(){return Promise.all([t.e(931),t.e(421)]).then(t.bind(t,8728))})),o.default.component("stars",(function(){return Promise.all([t.e(931),t.e(381)]).then(t.bind(t,5848))})),o.default.component("tab",(function(){return Promise.all([t.e(931),t.e(628)]).then(t.bind(t,4216))})),o.default.component("tabs",(function(){return Promise.all([t.e(931),t.e(948)]).then(t.bind(t,2858))})),o.default.component("top-bar",(function(){return Promise.all([t.e(931),t.e(454)]).then(t.bind(t,2685))})),o.default.component("wheretoeat-list",(function(){return Promise.all([t.e(931),t.e(447)]).then(t.bind(t,2308))})),o.default.component("wheretoeat-map",(function(){return Promise.all([t.e(931),t.e(84)]).then(t.bind(t,9927))})),o.default.component("wheretoeat-place-request-form",(function(){return Promise.all([t.e(931),t.e(294)]).then(t.bind(t,3622))})),o.default.component("wheretoeat-quick-search",(function(){return Promise.all([t.e(931),t.e(90)]).then(t.bind(t,6938))})),o.default.component("widget",(function(){return Promise.all([t.e(931),t.e(364)]).then(t.bind(t,6436))})),o.default.component("widget-blog-search",(function(){return Promise.all([t.e(931),t.e(410)]).then(t.bind(t,3297))})),o.default.component("widget-newsletter-signup",(function(){return Promise.all([t.e(931),t.e(889)]).then(t.bind(t,104))})),o.default.component("widget-recipe-search",(function(){return Promise.all([t.e(931),t.e(785)]).then(t.bind(t,8848))})),o.default.component("widget-review-search",(function(){return Promise.all([t.e(931),t.e(590)]).then(t.bind(t,154))})),o.default.component("widget-wheretoeat-search",(function(){return Promise.all([t.e(931),t.e(96)]).then(t.bind(t,309))})),o.default.config.productionTip=!1,window.coeliac=function(e){return new w(e)},coeliac().build(),document.querySelectorAll(".lazy").forEach((function(e){e.setAttribute("src","data:image/svg+xml,%3Csvg\n        xmlns='http://www.w3.org/2000/svg'\n        viewBox='0 0 3 2'%3E%3C/svg%3E\""),e.width="100%",e.height="auto",e.style.paddingBottom="52.5%"})),document.querySelectorAll(".page-box iframe").forEach((function(e){setTimeout((function(){Array.from(e.attributes).forEach((function(n){"src"!==n.name&&e.removeAttribute(n.name)}));var n=document.createElement("div");n.classList.add("iframe-wrapper"),e.parentElement.insertBefore(n,e),n.appendChild(e)}),500)})),window.dataLayer=window.dataLayer||[],H("js",new Date),H("config","UA-53299243-1"),setTimeout((function(){var e,n,t,o,r,a;e=window,n=document,t="script",e.fbq||(o=e.fbq=function(){o.callMethod?o.callMethod.apply(o,arguments):o.queue.push(arguments)},e._fbq||(e._fbq=o),o.push=o,o.loaded=!0,o.version="2.0",o.queue=[],(r=n.createElement(t)).defer=!0,r.src="https://connect.facebook.net/en_US/fbevents.js",(a=n.getElementsByTagName(t)[0]).parentNode.insertBefore(r,a)),fbq("init","1163828547057901"),fbq("track","PageView")}),5e3)},9046:()=>{},9674:e=>{function n(e){var n=new Error("Cannot find module '"+e+"'");throw n.code="MODULE_NOT_FOUND",n}n.keys=()=>[],n.resolve=n,n.id=9674,e.exports=n}},0,[[5774,940,931],[9046,940,931]]]);