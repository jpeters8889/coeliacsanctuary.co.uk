/*! For license information please see chunk-add-scrapbook.js.LICENSE.txt */
(self.webpackChunk=self.webpackChunk||[]).push([[1855],{3425:(e,t,o)=>{"use strict";o.d(t,{Z:()=>n});const n={methods:{isLoggedIn:function(){return null!==window.config.user},userHasVerifiedEmail:function(){return null!==window.config.user.email_verified_at}}}},8981:(e,t,o)=>{"use strict";o.d(t,{Z:()=>ce});var n="undefined"!=typeof window&&"undefined"!=typeof document&&"undefined"!=typeof navigator,r=function(){for(var e=["Edge","Trident","Firefox"],t=0;t<e.length;t+=1)if(n&&navigator.userAgent.indexOf(e[t])>=0)return 1;return 0}();var i=n&&window.Promise?function(e){var t=!1;return function(){t||(t=!0,window.Promise.resolve().then((function(){t=!1,e()})))}}:function(e){var t=!1;return function(){t||(t=!0,setTimeout((function(){t=!1,e()}),r))}};function s(e){return e&&"[object Function]"==={}.toString.call(e)}function a(e,t){if(1!==e.nodeType)return[];var o=e.ownerDocument.defaultView.getComputedStyle(e,null);return t?o[t]:o}function f(e){return"HTML"===e.nodeName?e:e.parentNode||e.host}function c(e){if(!e)return document.body;switch(e.nodeName){case"HTML":case"BODY":return e.ownerDocument.body;case"#document":return e.body}var t=a(e),o=t.overflow,n=t.overflowX,r=t.overflowY;return/(auto|scroll|overlay)/.test(o+r+n)?e:c(f(e))}function p(e){return e&&e.referenceNode?e.referenceNode:e}var l=n&&!(!window.MSInputMethodContext||!document.documentMode),d=n&&/MSIE 10/.test(navigator.userAgent);function u(e){return 11===e?l:10===e?d:l||d}function h(e){if(!e)return document.documentElement;for(var t=u(10)?document.body:null,o=e.offsetParent||null;o===t&&e.nextElementSibling;)o=(e=e.nextElementSibling).offsetParent;var n=o&&o.nodeName;return n&&"BODY"!==n&&"HTML"!==n?-1!==["TH","TD","TABLE"].indexOf(o.nodeName)&&"static"===a(o,"position")?h(o):o:e?e.ownerDocument.documentElement:document.documentElement}function m(e){return null!==e.parentNode?m(e.parentNode):e}function b(e,t){if(!(e&&e.nodeType&&t&&t.nodeType))return document.documentElement;var o=e.compareDocumentPosition(t)&Node.DOCUMENT_POSITION_FOLLOWING,n=o?e:t,r=o?t:e,i=document.createRange();i.setStart(n,0),i.setEnd(r,0);var s,a,f=i.commonAncestorContainer;if(e!==f&&t!==f||n.contains(r))return"BODY"===(a=(s=f).nodeName)||"HTML"!==a&&h(s.firstElementChild)!==s?h(f):f;var c=m(e);return c.host?b(c.host,t):b(e,m(t).host)}function v(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"top",o="top"===t?"scrollTop":"scrollLeft",n=e.nodeName;if("BODY"===n||"HTML"===n){var r=e.ownerDocument.documentElement,i=e.ownerDocument.scrollingElement||r;return i[o]}return e[o]}function g(e,t){var o=arguments.length>2&&void 0!==arguments[2]&&arguments[2],n=v(t,"top"),r=v(t,"left"),i=o?-1:1;return e.top+=n*i,e.bottom+=n*i,e.left+=r*i,e.right+=r*i,e}function w(e,t){var o="x"===t?"Left":"Top",n="Left"===o?"Right":"Bottom";return parseFloat(e["border"+o+"Width"])+parseFloat(e["border"+n+"Width"])}function y(e,t,o,n){return Math.max(t["offset"+e],t["scroll"+e],o["client"+e],o["offset"+e],o["scroll"+e],u(10)?parseInt(o["offset"+e])+parseInt(n["margin"+("Height"===e?"Top":"Left")])+parseInt(n["margin"+("Height"===e?"Bottom":"Right")]):0)}function x(e){var t=e.body,o=e.documentElement,n=u(10)&&getComputedStyle(o);return{height:y("Height",t,o,n),width:y("Width",t,o,n)}}var k=function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")},E=function(){function e(e,t){for(var o=0;o<t.length;o++){var n=t[o];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(t,o,n){return o&&e(t.prototype,o),n&&e(t,n),t}}(),O=function(e,t,o){return t in e?Object.defineProperty(e,t,{value:o,enumerable:!0,configurable:!0,writable:!0}):e[t]=o,e},S=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var o=arguments[t];for(var n in o)Object.prototype.hasOwnProperty.call(o,n)&&(e[n]=o[n])}return e};function L(e){return S({},e,{right:e.left+e.width,bottom:e.top+e.height})}function T(e){var t={};try{if(u(10)){t=e.getBoundingClientRect();var o=v(e,"top"),n=v(e,"left");t.top+=o,t.left+=n,t.bottom+=o,t.right+=n}else t=e.getBoundingClientRect()}catch(e){}var r={left:t.left,top:t.top,width:t.right-t.left,height:t.bottom-t.top},i="HTML"===e.nodeName?x(e.ownerDocument):{},s=i.width||e.clientWidth||r.width,f=i.height||e.clientHeight||r.height,c=e.offsetWidth-s,p=e.offsetHeight-f;if(c||p){var l=a(e);c-=w(l,"x"),p-=w(l,"y"),r.width-=c,r.height-=p}return L(r)}function C(e,t){var o=arguments.length>2&&void 0!==arguments[2]&&arguments[2],n=u(10),r="HTML"===t.nodeName,i=T(e),s=T(t),f=c(e),p=a(t),l=parseFloat(p.borderTopWidth),d=parseFloat(p.borderLeftWidth);o&&r&&(s.top=Math.max(s.top,0),s.left=Math.max(s.left,0));var h=L({top:i.top-s.top-l,left:i.left-s.left-d,width:i.width,height:i.height});if(h.marginTop=0,h.marginLeft=0,!n&&r){var m=parseFloat(p.marginTop),b=parseFloat(p.marginLeft);h.top-=l-m,h.bottom-=l-m,h.left-=d-b,h.right-=d-b,h.marginTop=m,h.marginLeft=b}return(n&&!o?t.contains(f):t===f&&"BODY"!==f.nodeName)&&(h=g(h,t)),h}function _(e){var t=arguments.length>1&&void 0!==arguments[1]&&arguments[1],o=e.ownerDocument.documentElement,n=C(e,o),r=Math.max(o.clientWidth,window.innerWidth||0),i=Math.max(o.clientHeight,window.innerHeight||0),s=t?0:v(o),a=t?0:v(o,"left"),f={top:s-n.top+n.marginTop,left:a-n.left+n.marginLeft,width:r,height:i};return L(f)}function N(e){var t=e.nodeName;if("BODY"===t||"HTML"===t)return!1;if("fixed"===a(e,"position"))return!0;var o=f(e);return!!o&&N(o)}function D(e){if(!e||!e.parentElement||u())return document.documentElement;for(var t=e.parentElement;t&&"none"===a(t,"transform");)t=t.parentElement;return t||document.documentElement}function I(e,t,o,n){var r=arguments.length>4&&void 0!==arguments[4]&&arguments[4],i={top:0,left:0},s=r?D(e):b(e,p(t));if("viewport"===n)i=_(s,r);else{var a=void 0;"scrollParent"===n?"BODY"===(a=c(f(t))).nodeName&&(a=e.ownerDocument.documentElement):a="window"===n?e.ownerDocument.documentElement:n;var l=C(a,s,r);if("HTML"!==a.nodeName||N(s))i=l;else{var d=x(e.ownerDocument),u=d.height,h=d.width;i.top+=l.top-l.marginTop,i.bottom=u+l.top,i.left+=l.left-l.marginLeft,i.right=h+l.left}}var m="number"==typeof(o=o||0);return i.left+=m?o:o.left||0,i.top+=m?o:o.top||0,i.right-=m?o:o.right||0,i.bottom-=m?o:o.bottom||0,i}function M(e){return e.width*e.height}function F(e,t,o,n,r){var i=arguments.length>5&&void 0!==arguments[5]?arguments[5]:0;if(-1===e.indexOf("auto"))return e;var s=I(o,n,i,r),a={top:{width:s.width,height:t.top-s.top},right:{width:s.right-t.right,height:s.height},bottom:{width:s.width,height:s.bottom-t.bottom},left:{width:t.left-s.left,height:s.height}},f=Object.keys(a).map((function(e){return S({key:e},a[e],{area:M(a[e])})})).sort((function(e,t){return t.area-e.area})),c=f.filter((function(e){var t=e.width,n=e.height;return t>=o.clientWidth&&n>=o.clientHeight})),p=c.length>0?c[0].key:f[0].key,l=e.split("-")[1];return p+(l?"-"+l:"")}function H(e,t,o){var n=arguments.length>3&&void 0!==arguments[3]?arguments[3]:null,r=n?D(t):b(t,p(o));return C(o,r,n)}function A(e){var t=e.ownerDocument.defaultView.getComputedStyle(e),o=parseFloat(t.marginTop||0)+parseFloat(t.marginBottom||0),n=parseFloat(t.marginLeft||0)+parseFloat(t.marginRight||0);return{width:e.offsetWidth+n,height:e.offsetHeight+o}}function W(e){var t={left:"right",right:"left",bottom:"top",top:"bottom"};return e.replace(/left|right|bottom|top/g,(function(e){return t[e]}))}function j(e,t,o){o=o.split("-")[0];var n=A(e),r={width:n.width,height:n.height},i=-1!==["right","left"].indexOf(o),s=i?"top":"left",a=i?"left":"top",f=i?"height":"width",c=i?"width":"height";return r[s]=t[s]+t[f]/2-n[f]/2,r[a]=o===a?t[a]-n[c]:t[W(a)],r}function z(e,t){return Array.prototype.find?e.find(t):e.filter(t)[0]}function B(e,t,o){return(void 0===o?e:e.slice(0,function(e,t,o){if(Array.prototype.findIndex)return e.findIndex((function(e){return e[t]===o}));var n=z(e,(function(e){return e[t]===o}));return e.indexOf(n)}(e,"name",o))).forEach((function(e){e.function&&console.warn("`modifier.function` is deprecated, use `modifier.fn`!");var o=e.function||e.fn;e.enabled&&s(o)&&(t.offsets.popper=L(t.offsets.popper),t.offsets.reference=L(t.offsets.reference),t=o(t,e))})),t}function P(){if(!this.state.isDestroyed){var e={instance:this,styles:{},arrowStyles:{},attributes:{},flipped:!1,offsets:{}};e.offsets.reference=H(this.state,this.popper,this.reference,this.options.positionFixed),e.placement=F(this.options.placement,e.offsets.reference,this.popper,this.reference,this.options.modifiers.flip.boundariesElement,this.options.modifiers.flip.padding),e.originalPlacement=e.placement,e.positionFixed=this.options.positionFixed,e.offsets.popper=j(this.popper,e.offsets.reference,e.placement),e.offsets.popper.position=this.options.positionFixed?"fixed":"absolute",e=B(this.modifiers,e),this.state.isCreated?this.options.onUpdate(e):(this.state.isCreated=!0,this.options.onCreate(e))}}function R(e,t){return e.some((function(e){var o=e.name;return e.enabled&&o===t}))}function $(e){for(var t=[!1,"ms","Webkit","Moz","O"],o=e.charAt(0).toUpperCase()+e.slice(1),n=0;n<t.length;n++){var r=t[n],i=r?""+r+o:e;if(void 0!==document.body.style[i])return i}return null}function U(){return this.state.isDestroyed=!0,R(this.modifiers,"applyStyle")&&(this.popper.removeAttribute("x-placement"),this.popper.style.position="",this.popper.style.top="",this.popper.style.left="",this.popper.style.right="",this.popper.style.bottom="",this.popper.style.willChange="",this.popper.style[$("transform")]=""),this.disableEventListeners(),this.options.removeOnDestroy&&this.popper.parentNode.removeChild(this.popper),this}function V(e){var t=e.ownerDocument;return t?t.defaultView:window}function q(e,t,o,n){var r="BODY"===e.nodeName,i=r?e.ownerDocument.defaultView:e;i.addEventListener(t,o,{passive:!0}),r||q(c(i.parentNode),t,o,n),n.push(i)}function Y(e,t,o,n){o.updateBound=n,V(e).addEventListener("resize",o.updateBound,{passive:!0});var r=c(e);return q(r,"scroll",o.updateBound,o.scrollParents),o.scrollElement=r,o.eventsEnabled=!0,o}function Z(){this.state.eventsEnabled||(this.state=Y(this.reference,this.options,this.state,this.scheduleUpdate))}function G(){var e,t;this.state.eventsEnabled&&(cancelAnimationFrame(this.scheduleUpdate),this.state=(e=this.reference,t=this.state,V(e).removeEventListener("resize",t.updateBound),t.scrollParents.forEach((function(e){e.removeEventListener("scroll",t.updateBound)})),t.updateBound=null,t.scrollParents=[],t.scrollElement=null,t.eventsEnabled=!1,t))}function X(e){return""!==e&&!isNaN(parseFloat(e))&&isFinite(e)}function J(e,t){Object.keys(t).forEach((function(o){var n="";-1!==["width","height","top","right","bottom","left"].indexOf(o)&&X(t[o])&&(n="px"),e.style[o]=t[o]+n}))}var K=n&&/Firefox/i.test(navigator.userAgent);function Q(e,t,o){var n=z(e,(function(e){return e.name===t})),r=!!n&&e.some((function(e){return e.name===o&&e.enabled&&e.order<n.order}));if(!r){var i="`"+t+"`",s="`"+o+"`";console.warn(s+" modifier is required by "+i+" modifier in order to work, be sure to include it before "+i+"!")}return r}var ee=["auto-start","auto","auto-end","top-start","top","top-end","right-start","right","right-end","bottom-end","bottom","bottom-start","left-end","left","left-start"],te=ee.slice(3);function oe(e){var t=arguments.length>1&&void 0!==arguments[1]&&arguments[1],o=te.indexOf(e),n=te.slice(o+1).concat(te.slice(0,o));return t?n.reverse():n}var ne="flip",re="clockwise",ie="counterclockwise";function se(e,t,o,n){var r=[0,0],i=-1!==["right","left"].indexOf(n),s=e.split(/(\+|\-)/).map((function(e){return e.trim()})),a=s.indexOf(z(s,(function(e){return-1!==e.search(/,|\s/)})));s[a]&&-1===s[a].indexOf(",")&&console.warn("Offsets separated by white space(s) are deprecated, use a comma (,) instead.");var f=/\s*,\s*|\s+/,c=-1!==a?[s.slice(0,a).concat([s[a].split(f)[0]]),[s[a].split(f)[1]].concat(s.slice(a+1))]:[s];return(c=c.map((function(e,n){var r=(1===n?!i:i)?"height":"width",s=!1;return e.reduce((function(e,t){return""===e[e.length-1]&&-1!==["+","-"].indexOf(t)?(e[e.length-1]=t,s=!0,e):s?(e[e.length-1]+=t,s=!1,e):e.concat(t)}),[]).map((function(e){return function(e,t,o,n){var r=e.match(/((?:\-|\+)?\d*\.?\d*)(.*)/),i=+r[1],s=r[2];if(!i)return e;if(0===s.indexOf("%")){var a=void 0;switch(s){case"%p":a=o;break;case"%":case"%r":default:a=n}return L(a)[t]/100*i}if("vh"===s||"vw"===s)return("vh"===s?Math.max(document.documentElement.clientHeight,window.innerHeight||0):Math.max(document.documentElement.clientWidth,window.innerWidth||0))/100*i;return i}(e,r,t,o)}))}))).forEach((function(e,t){e.forEach((function(o,n){X(o)&&(r[t]+=o*("-"===e[n-1]?-1:1))}))})),r}var ae={placement:"bottom",positionFixed:!1,eventsEnabled:!0,removeOnDestroy:!1,onCreate:function(){},onUpdate:function(){},modifiers:{shift:{order:100,enabled:!0,fn:function(e){var t=e.placement,o=t.split("-")[0],n=t.split("-")[1];if(n){var r=e.offsets,i=r.reference,s=r.popper,a=-1!==["bottom","top"].indexOf(o),f=a?"left":"top",c=a?"width":"height",p={start:O({},f,i[f]),end:O({},f,i[f]+i[c]-s[c])};e.offsets.popper=S({},s,p[n])}return e}},offset:{order:200,enabled:!0,fn:function(e,t){var o=t.offset,n=e.placement,r=e.offsets,i=r.popper,s=r.reference,a=n.split("-")[0],f=void 0;return f=X(+o)?[+o,0]:se(o,i,s,a),"left"===a?(i.top+=f[0],i.left-=f[1]):"right"===a?(i.top+=f[0],i.left+=f[1]):"top"===a?(i.left+=f[0],i.top-=f[1]):"bottom"===a&&(i.left+=f[0],i.top+=f[1]),e.popper=i,e},offset:0},preventOverflow:{order:300,enabled:!0,fn:function(e,t){var o=t.boundariesElement||h(e.instance.popper);e.instance.reference===o&&(o=h(o));var n=$("transform"),r=e.instance.popper.style,i=r.top,s=r.left,a=r[n];r.top="",r.left="",r[n]="";var f=I(e.instance.popper,e.instance.reference,t.padding,o,e.positionFixed);r.top=i,r.left=s,r[n]=a,t.boundaries=f;var c=t.priority,p=e.offsets.popper,l={primary:function(e){var o=p[e];return p[e]<f[e]&&!t.escapeWithReference&&(o=Math.max(p[e],f[e])),O({},e,o)},secondary:function(e){var o="right"===e?"left":"top",n=p[o];return p[e]>f[e]&&!t.escapeWithReference&&(n=Math.min(p[o],f[e]-("right"===e?p.width:p.height))),O({},o,n)}};return c.forEach((function(e){var t=-1!==["left","top"].indexOf(e)?"primary":"secondary";p=S({},p,l[t](e))})),e.offsets.popper=p,e},priority:["left","right","top","bottom"],padding:5,boundariesElement:"scrollParent"},keepTogether:{order:400,enabled:!0,fn:function(e){var t=e.offsets,o=t.popper,n=t.reference,r=e.placement.split("-")[0],i=Math.floor,s=-1!==["top","bottom"].indexOf(r),a=s?"right":"bottom",f=s?"left":"top",c=s?"width":"height";return o[a]<i(n[f])&&(e.offsets.popper[f]=i(n[f])-o[c]),o[f]>i(n[a])&&(e.offsets.popper[f]=i(n[a])),e}},arrow:{order:500,enabled:!0,fn:function(e,t){var o;if(!Q(e.instance.modifiers,"arrow","keepTogether"))return e;var n=t.element;if("string"==typeof n){if(!(n=e.instance.popper.querySelector(n)))return e}else if(!e.instance.popper.contains(n))return console.warn("WARNING: `arrow.element` must be child of its popper element!"),e;var r=e.placement.split("-")[0],i=e.offsets,s=i.popper,f=i.reference,c=-1!==["left","right"].indexOf(r),p=c?"height":"width",l=c?"Top":"Left",d=l.toLowerCase(),u=c?"left":"top",h=c?"bottom":"right",m=A(n)[p];f[h]-m<s[d]&&(e.offsets.popper[d]-=s[d]-(f[h]-m)),f[d]+m>s[h]&&(e.offsets.popper[d]+=f[d]+m-s[h]),e.offsets.popper=L(e.offsets.popper);var b=f[d]+f[p]/2-m/2,v=a(e.instance.popper),g=parseFloat(v["margin"+l]),w=parseFloat(v["border"+l+"Width"]),y=b-e.offsets.popper[d]-g-w;return y=Math.max(Math.min(s[p]-m,y),0),e.arrowElement=n,e.offsets.arrow=(O(o={},d,Math.round(y)),O(o,u,""),o),e},element:"[x-arrow]"},flip:{order:600,enabled:!0,fn:function(e,t){if(R(e.instance.modifiers,"inner"))return e;if(e.flipped&&e.placement===e.originalPlacement)return e;var o=I(e.instance.popper,e.instance.reference,t.padding,t.boundariesElement,e.positionFixed),n=e.placement.split("-")[0],r=W(n),i=e.placement.split("-")[1]||"",s=[];switch(t.behavior){case ne:s=[n,r];break;case re:s=oe(n);break;case ie:s=oe(n,!0);break;default:s=t.behavior}return s.forEach((function(a,f){if(n!==a||s.length===f+1)return e;n=e.placement.split("-")[0],r=W(n);var c=e.offsets.popper,p=e.offsets.reference,l=Math.floor,d="left"===n&&l(c.right)>l(p.left)||"right"===n&&l(c.left)<l(p.right)||"top"===n&&l(c.bottom)>l(p.top)||"bottom"===n&&l(c.top)<l(p.bottom),u=l(c.left)<l(o.left),h=l(c.right)>l(o.right),m=l(c.top)<l(o.top),b=l(c.bottom)>l(o.bottom),v="left"===n&&u||"right"===n&&h||"top"===n&&m||"bottom"===n&&b,g=-1!==["top","bottom"].indexOf(n),w=!!t.flipVariations&&(g&&"start"===i&&u||g&&"end"===i&&h||!g&&"start"===i&&m||!g&&"end"===i&&b),y=!!t.flipVariationsByContent&&(g&&"start"===i&&h||g&&"end"===i&&u||!g&&"start"===i&&b||!g&&"end"===i&&m),x=w||y;(d||v||x)&&(e.flipped=!0,(d||v)&&(n=s[f+1]),x&&(i=function(e){return"end"===e?"start":"start"===e?"end":e}(i)),e.placement=n+(i?"-"+i:""),e.offsets.popper=S({},e.offsets.popper,j(e.instance.popper,e.offsets.reference,e.placement)),e=B(e.instance.modifiers,e,"flip"))})),e},behavior:"flip",padding:5,boundariesElement:"viewport",flipVariations:!1,flipVariationsByContent:!1},inner:{order:700,enabled:!1,fn:function(e){var t=e.placement,o=t.split("-")[0],n=e.offsets,r=n.popper,i=n.reference,s=-1!==["left","right"].indexOf(o),a=-1===["top","left"].indexOf(o);return r[s?"left":"top"]=i[o]-(a?r[s?"width":"height"]:0),e.placement=W(t),e.offsets.popper=L(r),e}},hide:{order:800,enabled:!0,fn:function(e){if(!Q(e.instance.modifiers,"hide","preventOverflow"))return e;var t=e.offsets.reference,o=z(e.instance.modifiers,(function(e){return"preventOverflow"===e.name})).boundaries;if(t.bottom<o.top||t.left>o.right||t.top>o.bottom||t.right<o.left){if(!0===e.hide)return e;e.hide=!0,e.attributes["x-out-of-boundaries"]=""}else{if(!1===e.hide)return e;e.hide=!1,e.attributes["x-out-of-boundaries"]=!1}return e}},computeStyle:{order:850,enabled:!0,fn:function(e,t){var o=t.x,n=t.y,r=e.offsets.popper,i=z(e.instance.modifiers,(function(e){return"applyStyle"===e.name})).gpuAcceleration;void 0!==i&&console.warn("WARNING: `gpuAcceleration` option moved to `computeStyle` modifier and will not be supported in future versions of Popper.js!");var s=void 0!==i?i:t.gpuAcceleration,a=h(e.instance.popper),f=T(a),c={position:r.position},p=function(e,t){var o=e.offsets,n=o.popper,r=o.reference,i=Math.round,s=Math.floor,a=function(e){return e},f=i(r.width),c=i(n.width),p=-1!==["left","right"].indexOf(e.placement),l=-1!==e.placement.indexOf("-"),d=t?p||l||f%2==c%2?i:s:a,u=t?i:a;return{left:d(f%2==1&&c%2==1&&!l&&t?n.left-1:n.left),top:u(n.top),bottom:u(n.bottom),right:d(n.right)}}(e,window.devicePixelRatio<2||!K),l="bottom"===o?"top":"bottom",d="right"===n?"left":"right",u=$("transform"),m=void 0,b=void 0;if(b="bottom"===l?"HTML"===a.nodeName?-a.clientHeight+p.bottom:-f.height+p.bottom:p.top,m="right"===d?"HTML"===a.nodeName?-a.clientWidth+p.right:-f.width+p.right:p.left,s&&u)c[u]="translate3d("+m+"px, "+b+"px, 0)",c[l]=0,c[d]=0,c.willChange="transform";else{var v="bottom"===l?-1:1,g="right"===d?-1:1;c[l]=b*v,c[d]=m*g,c.willChange=l+", "+d}var w={"x-placement":e.placement};return e.attributes=S({},w,e.attributes),e.styles=S({},c,e.styles),e.arrowStyles=S({},e.offsets.arrow,e.arrowStyles),e},gpuAcceleration:!0,x:"bottom",y:"right"},applyStyle:{order:900,enabled:!0,fn:function(e){var t,o;return J(e.instance.popper,e.styles),t=e.instance.popper,o=e.attributes,Object.keys(o).forEach((function(e){!1!==o[e]?t.setAttribute(e,o[e]):t.removeAttribute(e)})),e.arrowElement&&Object.keys(e.arrowStyles).length&&J(e.arrowElement,e.arrowStyles),e},onLoad:function(e,t,o,n,r){var i=H(r,t,e,o.positionFixed),s=F(o.placement,i,t,e,o.modifiers.flip.boundariesElement,o.modifiers.flip.padding);return t.setAttribute("x-placement",s),J(t,{position:o.positionFixed?"fixed":"absolute"}),o},gpuAcceleration:void 0}}},fe=function(){function e(t,o){var n=this,r=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};k(this,e),this.scheduleUpdate=function(){return requestAnimationFrame(n.update)},this.update=i(this.update.bind(this)),this.options=S({},e.Defaults,r),this.state={isDestroyed:!1,isCreated:!1,scrollParents:[]},this.reference=t&&t.jquery?t[0]:t,this.popper=o&&o.jquery?o[0]:o,this.options.modifiers={},Object.keys(S({},e.Defaults.modifiers,r.modifiers)).forEach((function(t){n.options.modifiers[t]=S({},e.Defaults.modifiers[t]||{},r.modifiers?r.modifiers[t]:{})})),this.modifiers=Object.keys(this.options.modifiers).map((function(e){return S({name:e},n.options.modifiers[e])})).sort((function(e,t){return e.order-t.order})),this.modifiers.forEach((function(e){e.enabled&&s(e.onLoad)&&e.onLoad(n.reference,n.popper,n.options,e,n.state)})),this.update();var a=this.options.eventsEnabled;a&&this.enableEventListeners(),this.state.eventsEnabled=a}return E(e,[{key:"update",value:function(){return P.call(this)}},{key:"destroy",value:function(){return U.call(this)}},{key:"enableEventListeners",value:function(){return Z.call(this)}},{key:"disableEventListeners",value:function(){return G.call(this)}}]),e}();fe.Utils=("undefined"!=typeof window?window:o.g).PopperUtils,fe.placements=ee,fe.Defaults=ae;const ce=fe},7727:(e,t,o)=>{"use strict";o.r(t),o.d(t,{default:()=>a});var n=o(538),r=o(1147),i=o(3425);n.default.use(r.ZP);const s={mixins:[i.Z],components:{modal:function(){return o.e(5441).then(o.bind(o,3516))}},props:{area:{type:String,required:!0},id:{type:Number,required:!0}},data:function(){return{showUserCta:!1,showSelectScrapbook:!1,isInScrapbook:!1,scrapbooks:[]}},mounted:function(){var e=this;this.getScrapbooks(),this.seeIfInScrapbook(),this.$root.$on("modal-closed",(function(t){"userCta"===t&&(e.showUserCta=!1)}))},methods:{getScrapbooks:function(){var e=this;this.scrapbooks=[],this.isLoggedIn()&&coeliac().request().get("/api/member/dashboard/scrapbooks").then((function(t){e.scrapbooks=t.data})).catch((function(){}))},seeIfInScrapbook:function(){var e=this;this.isLoggedIn()&&coeliac().request().post("/api/member/dashboard/scrapbooks/search",{area:this.area,id:this.id}).then((function(t){200!==t.status?e.isInScrapbook=!1:e.isInScrapbook=t.data})).catch((function(){}))},toggleScrapbook:function(){this.isLoggedIn()?this.isInScrapbook?this.deleteFromScrapbook():1!==this.scrapbooks.length?this.showSelectScrapbook=!0:this.addToScrapbook():this.showUserCta=!0},deleteFromScrapbook:function(){var e=this;coeliac().request().delete("/api/member/dashboard/scrapbooks/".concat(this.isInScrapbook.scrapbook_id,"/").concat(this.isInScrapbook.id)).then((function(){coeliac().success("This ".concat(e.area," has been removed to your scrapbook!")),e.isInScrapbook=!1})).catch((function(){coeliac().error("There was an error removing this ".concat(e.area," from your scrapbook"))}))},addToScrapbook:function(){var e=this,t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;t||(t=this.scrapbooks[0].id),coeliac().request().post("/api/member/dashboard/scrapbooks/".concat(t),{type:this.area,id:this.id}).then((function(){coeliac().success("This ".concat(e.area," has been added to your scrapbook!")),e.seeIfInScrapbook()})).catch((function(){coeliac().error("There was an error adding this ".concat(e.area," to your scrapbook"))})).finally((function(){e.showSelectScrapbook=!1}))}},computed:{icon:function(){return this.isInScrapbook?["fas","bookmark"]:["far","bookmark"]},tooltip:function(){return this.isInScrapbook?"Remove from Scrapbook":"Add to Scrapbook"}}};const a=(0,o(1900).Z)(s,(function(){var e=this,t=e.$createElement,o=e._self._c||t;return o("div",[o("div",{directives:[{name:"tooltip",rawName:"v-tooltip.top",value:{content:e.tooltip,classes:["bg-yellow","text-black","rounded-lg","text-sm"]},expression:"{content: tooltip, classes: ['bg-yellow', 'text-black', 'rounded-lg', 'text-sm']}",modifiers:{top:!0}}],staticClass:"mr-2 text-3xl text-grey cursor-pointer hover:text-yellow transition-color",on:{click:function(t){return e.toggleScrapbook()}}},[o("font-awesome-icon",{attrs:{icon:e.icon}})],1),e._v(" "),e.showSelectScrapbook?o("div",[o("div",{staticClass:"fixed top-0 left-0 bg-black-20 w-screen h-screen z-max",on:{click:function(t){e.showSelectScrapbook=!1},keypress:function(t){if(!t.type.indexOf("key")&&e._k(t.keyCode,"escape",void 0,t.key,void 0))return null;e.showSelectScrapbook=!1}}}),e._v(" "),o("div",{staticClass:"absolute w-full bg-white left-0 right-0 shadow-xl rounded z-max mt-2"},[o("ul",e._l(e.scrapbooks,(function(t){return o("li",{staticClass:"py-3 text-center text-lg border-b border-grey-off last:border-0 hover:bg-grey-off-light cursor-pointer transition-bg",on:{click:function(o){return e.addToScrapbook(t.id)}}},[e._v("\n                    "+e._s(t.name)+"\n                ")])})),0)])]):e._e(),e._v(" "),e.showUserCta?o("portal",{attrs:{to:"modal"}},[o("modal",{attrs:{small:"",name:"userCta","modal-classes":"text-center text-lg"}},[o("p",[e._v("You must be signed in to add this "+e._s(e.area)+" to your scrapbook.")]),e._v(" "),o("p",[o("a",{staticClass:"font-semibold hover:text-blue-dark cursor-pointer",attrs:{href:"/member/register"}},[e._v("Create an\n                    account")])]),e._v(" "),o("p",[e._v("\n                Already got one? "),o("a",{staticClass:"font-semibold hover:text-blue-dark cursor-pointer",attrs:{href:"/member/login"}},[e._v("Log\n                in now.")])])])],1):e._e()],1)}),[],!1,null,null,null).exports},7777:(e,t,o)=>{"use strict";o.d(t,{do:()=>i});var n=void 0;function r(){r.init||(r.init=!0,n=-1!==function(){var e=window.navigator.userAgent,t=e.indexOf("MSIE ");if(t>0)return parseInt(e.substring(t+5,e.indexOf(".",t)),10);if(e.indexOf("Trident/")>0){var o=e.indexOf("rv:");return parseInt(e.substring(o+3,e.indexOf(".",o)),10)}var n=e.indexOf("Edge/");return n>0?parseInt(e.substring(n+5,e.indexOf(".",n)),10):-1}())}var i={render:function(){var e=this.$createElement;return(this._self._c||e)("div",{staticClass:"resize-observer",attrs:{tabindex:"-1"}})},staticRenderFns:[],_scopeId:"data-v-b329ee4c",name:"resize-observer",methods:{compareAndNotify:function(){this._w===this.$el.offsetWidth&&this._h===this.$el.offsetHeight||(this._w=this.$el.offsetWidth,this._h=this.$el.offsetHeight,this.$emit("notify"))},addResizeHandlers:function(){this._resizeObject.contentDocument.defaultView.addEventListener("resize",this.compareAndNotify),this.compareAndNotify()},removeResizeHandlers:function(){this._resizeObject&&this._resizeObject.onload&&(!n&&this._resizeObject.contentDocument&&this._resizeObject.contentDocument.defaultView.removeEventListener("resize",this.compareAndNotify),delete this._resizeObject.onload)}},mounted:function(){var e=this;r(),this.$nextTick((function(){e._w=e.$el.offsetWidth,e._h=e.$el.offsetHeight}));var t=document.createElement("object");this._resizeObject=t,t.setAttribute("aria-hidden","true"),t.setAttribute("tabindex",-1),t.onload=this.addResizeHandlers,t.type="text/html",n&&this.$el.appendChild(t),t.data="about:blank",n||this.$el.appendChild(t)},beforeDestroy:function(){this.removeResizeHandlers()}};var s={version:"0.4.5",install:function(e){e.component("resize-observer",i),e.component("ResizeObserver",i)}},a=null;"undefined"!=typeof window?a=window.Vue:void 0!==o.g&&(a=o.g.Vue),a&&a.use(s)}}]);