(()=>{"use strict";var e,c={},a={};function n(e){if(a[e])return a[e].exports;var t=a[e]={id:e,exports:{}};return c[e].call(t.exports,t,t.exports,n),t.exports}n.m=c,n.x=e=>{},n.n=e=>{var c=e&&e.__esModule?()=>e.default:()=>e;return n.d(c,{a:c}),c},n.d=(e,c)=>{for(var a in c)n.o(c,a)&&!n.o(e,a)&&Object.defineProperty(e,a,{enumerable:!0,get:c[a]})},n.f={},n.e=e=>Promise.all(Object.keys(n.f).reduce(((c,a)=>(n.f[a](e,c),c)),[])),n.u=e=>"assets/js/"+{11:"chunk-number-count",19:"preload-popup-cta",198:"chunk-widget",220:"chunk-product-images",302:"chunk-comment-form",336:"chunk-basket-quick-link",554:"chunk-site-search",993:"chunk-form-textarea",1174:"chunk-contact-trigger",1369:"chunk-recipe-search",1531:"chunk-form-input",1636:"chunk-contact-form",1640:"chunk-article-header",1837:"chunk-breadcrumbs",2371:"chunk-recipe-image",2393:"preload-google-ad",2533:"chunk-wte-search",2535:"chunk-newsletter-signup",2906:"chunk-tab",3426:"chunk-footer-newsletter",3432:"preload-quick-search",3602:"chunk-link-button",3749:"chunk-stars",4014:"chunk-form-select",4076:"preload-top-bar",4082:"chunk-comments",4650:"chunk-article-image",4755:"chunk-basket-quantity-switcher",5006:"chunk-accordion",5137:"chunk-tabs",5210:"chunk-wte-list",5377:"chunk-module-list-index",5440:"preload-mobile-nav",5441:"chunk-modal",5804:"chunk-wte-quick-search",6193:"chunk-announcements",6257:"chunk-page-loader",6360:"chunk-basket-page",6372:"chunk-wte-place-request",6487:"chunk-product-add-basket",6940:"chunk-form-option",7148:"chunk-static-map",7279:"chunk-form-checkbox",7529:"chunk-wte-map",7739:"chunk-basket-header-widget",7929:"chunk-pagination",7968:"chunk-basket-sidebar",8540:"chunk-loader",8661:"preload-header-search",8720:"chunk-blog-search",8783:"chunk-add-basket-trigger",8840:"chunk-competition",9169:"preload-coeliac-icon",9725:"chunk-home-heros",9771:"chunk-review-search"}[e]+".js?id="+{11:"3cfdf71c23d23ad3da5f",19:"193152b03c1b5b4daba8",198:"acd6a297ae356a02492c",220:"51516e61c4895e8eac51",302:"5cdef40577d6d2d2be8e",336:"a1587d4e142b287e13a9",554:"bec88e756b4f7f9bb269",993:"686e714f3be65ccc7eb1",1174:"5158f8c9640a237f1226",1369:"55b4ed537d1fc9086c25",1531:"549f4263ca064c491275",1636:"d45b63ed2891bcc53ce7",1640:"883ff3294f1973692c0b",1837:"3fb0f42c73f0b4ac15a8",2371:"ccddfe27a72af7900502",2393:"718fb00cebf57b12b824",2533:"ae8efc7aca7265a0a5ac",2535:"8c8c07ad0a71470965ad",2906:"2eeb25eb1de8faa9bbb0",3426:"44a5faa8c90a04602f80",3432:"712777aea26b5cf8c60f",3602:"16e4ff909283a4652cfb",3749:"bd2a8e3cadf3a1f57160",4014:"394ef3f4bbc575aa6a91",4076:"66c71d9a9482431737bb",4082:"016964d3a403b6d9ff82",4650:"638ba49b29b0d64f6303",4755:"94ecd4b27b9cc69c7967",5006:"308c0180a7b263a11b6d",5137:"909e134731844cc92790",5210:"f5d23a1d2711845cfbe2",5377:"956f1a35fcadbdf9c12d",5440:"2fd2dee0513fcd3182fe",5441:"2e3457a44fba733ad2bc",5804:"80835beda93dc84f4597",6193:"e17d80341a949d410947",6257:"663ca87d6eeb231bdd48",6360:"786fd7ed86facfd8c8bc",6372:"4525b1db8e06892a2088",6487:"9c204c924cd082ea0355",6940:"05e47d7f18d1f08f8a3f",7148:"e9412b08be831eda805c",7279:"180c7e241c4ee9dfcf31",7529:"985dcf5015d0f307e79f",7739:"7fabdfca041db1e02dd7",7929:"a3a1c6b4ff02b6bb9d2c",7968:"6afbab883aa3ddd3ce2c",8540:"8952ba5cdc02b39b1eb7",8661:"d6e987e668aa91156f08",8720:"9a381b9b93a71de47121",8783:"309ccfc8496b824afbdb",8840:"904015acdb23f2a01552",9169:"15492adfa5968a2a7d0f",9725:"e705ae781e9a67cc6a4c",9771:"f69062b3b8b62e173e14"}[e],n.miniCssF=e=>({11:"chunk-number-count",19:"preload-popup-cta",198:"chunk-widget",220:"chunk-product-images",302:"chunk-comment-form",336:"chunk-basket-quick-link",554:"chunk-site-search",931:"/assets/js/vendor",940:"/assets/js/manifest",993:"chunk-form-textarea",1174:"chunk-contact-trigger",1369:"chunk-recipe-search",1531:"chunk-form-input",1636:"chunk-contact-form",1640:"chunk-article-header",1837:"chunk-breadcrumbs",2371:"chunk-recipe-image",2393:"preload-google-ad",2533:"chunk-wte-search",2535:"chunk-newsletter-signup",2906:"chunk-tab",3426:"chunk-footer-newsletter",3432:"preload-quick-search",3602:"chunk-link-button",3749:"chunk-stars",4014:"chunk-form-select",4076:"preload-top-bar",4082:"chunk-comments",4650:"chunk-article-image",4755:"chunk-basket-quantity-switcher",5006:"chunk-accordion",5137:"chunk-tabs",5210:"chunk-wte-list",5377:"chunk-module-list-index",5440:"preload-mobile-nav",5441:"chunk-modal",5804:"chunk-wte-quick-search",5926:"assets/css/coeliac",6193:"chunk-announcements",6257:"chunk-page-loader",6360:"chunk-basket-page",6372:"chunk-wte-place-request",6487:"chunk-product-add-basket",6940:"chunk-form-option",7148:"chunk-static-map",7279:"chunk-form-checkbox",7529:"chunk-wte-map",7739:"chunk-basket-header-widget",7929:"chunk-pagination",7968:"chunk-basket-sidebar",8540:"chunk-loader",8661:"preload-header-search",8720:"chunk-blog-search",8783:"chunk-add-basket-trigger",8840:"chunk-competition",9169:"preload-coeliac-icon",9307:"/assets/js/coeliac",9725:"chunk-home-heros",9771:"chunk-review-search"}[e]+".css"),n.g=function(){if("object"==typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(e){if("object"==typeof window)return window}}(),n.o=(e,c)=>Object.prototype.hasOwnProperty.call(e,c),e={},n.l=(c,a,t,r)=>{if(e[c])e[c].push(a);else{var u,o;if(void 0!==t)for(var d=document.getElementsByTagName("script"),h=0;h<d.length;h++){var s=d[h];if(s.getAttribute("src")==c){u=s;break}}u||(o=!0,(u=document.createElement("script")).charset="utf-8",u.timeout=120,n.nc&&u.setAttribute("nonce",n.nc),u.src=c),e[c]=[a];var i=(a,n)=>{u.onerror=u.onload=null,clearTimeout(b);var t=e[c];if(delete e[c],u.parentNode&&u.parentNode.removeChild(u),t&&t.forEach((e=>e(n))),a)return a(n)},b=setTimeout(i.bind(null,void 0,{type:"timeout",target:u}),12e4);u.onerror=i.bind(null,u.onerror),u.onload=i.bind(null,u.onload),o&&document.head.appendChild(u)}},n.r=e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.p="/",(()=>{var e={940:0},c=[];n.f.j=(c,a)=>{var t=n.o(e,c)?e[c]:void 0;if(0!==t)if(t)a.push(t[2]);else{var r=new Promise(((a,n)=>{t=e[c]=[a,n]}));a.push(t[2]=r);var u=n.p+n.u(c),o=new Error;n.l(u,(a=>{if(n.o(e,c)&&(0!==(t=e[c])&&(e[c]=void 0),t)){var r=a&&("load"===a.type?"missing":a.type),u=a&&a.target&&a.target.src;o.message="Loading chunk "+c+" failed.\n("+r+": "+u+")",o.name="ChunkLoadError",o.type=r,o.request=u,t[1](o)}}),"chunk-"+c,c)}};var a=e=>{},t=(t,r)=>{for(var u,o,[d,h,s,i]=r,b=0,k=[];b<d.length;b++)o=d[b],n.o(e,o)&&e[o]&&k.push(e[o][0]),e[o]=0;for(u in h)n.o(h,u)&&(n.m[u]=h[u]);for(s&&s(n),t&&t(r);k.length;)k.shift()();return i&&c.push.apply(c,i),a()},r=self.webpackChunk=self.webpackChunk||[];function u(){for(var a,t=0;t<c.length;t++){for(var r=c[t],u=!0,o=1;o<r.length;o++){var d=r[o];0!==e[d]&&(u=!1)}u&&(c.splice(t--,1),a=n(n.s=r[0]))}return 0===c.length&&(n.x(),n.x=e=>{}),a}r.forEach(t.bind(null,0)),r.push=t.bind(null,r.push.bind(r));var o=n.x;n.x=()=>(n.x=o||(e=>{}),(a=u)())})(),n.x()})();