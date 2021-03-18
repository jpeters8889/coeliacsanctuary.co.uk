/*! For license information please see chunk-form-option.js.LICENSE.txt */
(self.webpackChunk=self.webpackChunk||[]).push([[6940],{2102:(e,t,n)=>{"use strict";n.d(t,{Z:()=>o});var r=n(538),i=n(1147);r.default.use(i.ZP);const o={data:function(){return{hasError:!1,showError:!1,errorText:"",currentValue:""}},props:{type:{type:String,default:"text"},name:{type:String,required:!0},value:{type:String,default:""},placeholder:{type:String,default:""},required:{type:Boolean,default:!1},disabled:{type:Boolean,default:!1},min:{type:Number,default:null},max:{type:Number,default:null},pattern:{type:RegExp,default:null},patternError:{type:String,default:"Field is Invalid"},match:{type:String,default:null}},mounted:function(){var e=this;this.currentValue=this.value,this.required&&""===this.currentValue&&(this.hasError=!0),this.$root.$on(this.name+"-get-value",(function(){e.validate(),e.$root.$emit(e.name+"-value",e.currentValue)})),this.$root.$on(this.name+"-set-value",(function(t){e.currentValue=t,e.hasError=!0,e.validate()})),this.$root.$on(this.name+"-reset",(function(){e.currentValue="",e.showError=!1})),this.$root.$on(this.name+"-validate",(function(){e.hasError=!0,e.validate()}))},methods:{validate:function(){if(this.showError=!0,this.required&&""===this.currentValue)return this.errorText="Field is required",void this.pushError();if(this.pattern&&(this.required||""!==this.currentValue)&&!this.currentValue.match(this.pattern))return this.errorText=this.patternError,void this.pushError();if(this.match&&this.currentValue!==this.match)return this.errorText="Field does not match",void this.pushError();switch(this.type){case"email":if(!this.checkEmail())return this.errorText="Must be a valid email address",void this.pushError()}this.hasError=!1,this.errorText="",this.$root.$emit(this.name+"-valid")},checkEmail:function(){return/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(this.currentValue)},pushError:function(){this.hasError=!0,this.$root.$emit(this.name+"-error",this.errorText)}},watch:{hasError:function(){this.hasError?this.$root.$emit(this.name+"-error",this.errorText):this.$root.$emit(this.name+"-valid")},currentValue:function(e){this.$root.$emit(this.name+"-change",e)}}}},7077:(e,t,n)=>{"use strict";n.d(t,{Z:()=>o});var r=n(3645),i=n.n(r)()((function(e){return e[1]}));i.push([e.id,"input:focus{outline:none}input:-webkit-autofill{background:none}",""]);const o=i},3645:e=>{"use strict";e.exports=function(e){var t=[];return t.toString=function(){return this.map((function(t){var n=e(t);return t[2]?"@media ".concat(t[2]," {").concat(n,"}"):n})).join("")},t.i=function(e,n,r){"string"==typeof e&&(e=[[null,e,""]]);var i={};if(r)for(var o=0;o<this.length;o++){var s=this[o][0];null!=s&&(i[s]=!0)}for(var a=0;a<e.length;a++){var f=[].concat(e[a]);r&&i[f[0]]||(n&&(f[2]?f[2]="".concat(n," and ").concat(f[2]):f[2]=n),t.push(f))}},t}},8981:(e,t,n)=>{"use strict";n.d(t,{Z:()=>le});var r="undefined"!=typeof window&&"undefined"!=typeof document&&"undefined"!=typeof navigator,i=function(){for(var e=["Edge","Trident","Firefox"],t=0;t<e.length;t+=1)if(r&&navigator.userAgent.indexOf(e[t])>=0)return 1;return 0}();var o=r&&window.Promise?function(e){var t=!1;return function(){t||(t=!0,window.Promise.resolve().then((function(){t=!1,e()})))}}:function(e){var t=!1;return function(){t||(t=!0,setTimeout((function(){t=!1,e()}),i))}};function s(e){return e&&"[object Function]"==={}.toString.call(e)}function a(e,t){if(1!==e.nodeType)return[];var n=e.ownerDocument.defaultView.getComputedStyle(e,null);return t?n[t]:n}function f(e){return"HTML"===e.nodeName?e:e.parentNode||e.host}function l(e){if(!e)return document.body;switch(e.nodeName){case"HTML":case"BODY":return e.ownerDocument.body;case"#document":return e.body}var t=a(e),n=t.overflow,r=t.overflowX,i=t.overflowY;return/(auto|scroll|overlay)/.test(n+i+r)?e:l(f(e))}function u(e){return e&&e.referenceNode?e.referenceNode:e}var c=r&&!(!window.MSInputMethodContext||!document.documentMode),d=r&&/MSIE 10/.test(navigator.userAgent);function p(e){return 11===e?c:10===e?d:c||d}function h(e){if(!e)return document.documentElement;for(var t=p(10)?document.body:null,n=e.offsetParent||null;n===t&&e.nextElementSibling;)n=(e=e.nextElementSibling).offsetParent;var r=n&&n.nodeName;return r&&"BODY"!==r&&"HTML"!==r?-1!==["TH","TD","TABLE"].indexOf(n.nodeName)&&"static"===a(n,"position")?h(n):n:e?e.ownerDocument.documentElement:document.documentElement}function m(e){return null!==e.parentNode?m(e.parentNode):e}function v(e,t){if(!(e&&e.nodeType&&t&&t.nodeType))return document.documentElement;var n=e.compareDocumentPosition(t)&Node.DOCUMENT_POSITION_FOLLOWING,r=n?e:t,i=n?t:e,o=document.createRange();o.setStart(r,0),o.setEnd(i,0);var s,a,f=o.commonAncestorContainer;if(e!==f&&t!==f||r.contains(i))return"BODY"===(a=(s=f).nodeName)||"HTML"!==a&&h(s.firstElementChild)!==s?h(f):f;var l=m(e);return l.host?v(l.host,t):v(e,m(t).host)}function g(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"top",n="top"===t?"scrollTop":"scrollLeft",r=e.nodeName;if("BODY"===r||"HTML"===r){var i=e.ownerDocument.documentElement,o=e.ownerDocument.scrollingElement||i;return o[n]}return e[n]}function b(e,t){var n=arguments.length>2&&void 0!==arguments[2]&&arguments[2],r=g(t,"top"),i=g(t,"left"),o=n?-1:1;return e.top+=r*o,e.bottom+=r*o,e.left+=i*o,e.right+=i*o,e}function w(e,t){var n="x"===t?"Left":"Top",r="Left"===n?"Right":"Bottom";return parseFloat(e["border"+n+"Width"])+parseFloat(e["border"+r+"Width"])}function y(e,t,n,r){return Math.max(t["offset"+e],t["scroll"+e],n["client"+e],n["offset"+e],n["scroll"+e],p(10)?parseInt(n["offset"+e])+parseInt(r["margin"+("Height"===e?"Top":"Left")])+parseInt(r["margin"+("Height"===e?"Bottom":"Right")]):0)}function x(e){var t=e.body,n=e.documentElement,r=p(10)&&getComputedStyle(n);return{height:y("Height",t,n,r),width:y("Width",t,n,r)}}var E=function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")},O=function(){function e(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}return function(t,n,r){return n&&e(t.prototype,n),r&&e(t,r),t}}(),T=function(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e},C=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var r in n)Object.prototype.hasOwnProperty.call(n,r)&&(e[r]=n[r])}return e};function N(e){return C({},e,{right:e.left+e.width,bottom:e.top+e.height})}function L(e){var t={};try{if(p(10)){t=e.getBoundingClientRect();var n=g(e,"top"),r=g(e,"left");t.top+=n,t.left+=r,t.bottom+=n,t.right+=r}else t=e.getBoundingClientRect()}catch(e){}var i={left:t.left,top:t.top,width:t.right-t.left,height:t.bottom-t.top},o="HTML"===e.nodeName?x(e.ownerDocument):{},s=o.width||e.clientWidth||i.width,f=o.height||e.clientHeight||i.height,l=e.offsetWidth-s,u=e.offsetHeight-f;if(l||u){var c=a(e);l-=w(c,"x"),u-=w(c,"y"),i.width-=l,i.height-=u}return N(i)}function M(e,t){var n=arguments.length>2&&void 0!==arguments[2]&&arguments[2],r=p(10),i="HTML"===t.nodeName,o=L(e),s=L(t),f=l(e),u=a(t),c=parseFloat(u.borderTopWidth),d=parseFloat(u.borderLeftWidth);n&&i&&(s.top=Math.max(s.top,0),s.left=Math.max(s.left,0));var h=N({top:o.top-s.top-c,left:o.left-s.left-d,width:o.width,height:o.height});if(h.marginTop=0,h.marginLeft=0,!r&&i){var m=parseFloat(u.marginTop),v=parseFloat(u.marginLeft);h.top-=c-m,h.bottom-=c-m,h.left-=d-v,h.right-=d-v,h.marginTop=m,h.marginLeft=v}return(r&&!n?t.contains(f):t===f&&"BODY"!==f.nodeName)&&(h=b(h,t)),h}function k(e){var t=arguments.length>1&&void 0!==arguments[1]&&arguments[1],n=e.ownerDocument.documentElement,r=M(e,n),i=Math.max(n.clientWidth,window.innerWidth||0),o=Math.max(n.clientHeight,window.innerHeight||0),s=t?0:g(n),a=t?0:g(n,"left"),f={top:s-r.top+r.marginTop,left:a-r.left+r.marginLeft,width:i,height:o};return N(f)}function D(e){var t=e.nodeName;if("BODY"===t||"HTML"===t)return!1;if("fixed"===a(e,"position"))return!0;var n=f(e);return!!n&&D(n)}function S(e){if(!e||!e.parentElement||p())return document.documentElement;for(var t=e.parentElement;t&&"none"===a(t,"transform");)t=t.parentElement;return t||document.documentElement}function A(e,t,n,r){var i=arguments.length>4&&void 0!==arguments[4]&&arguments[4],o={top:0,left:0},s=i?S(e):v(e,u(t));if("viewport"===r)o=k(s,i);else{var a=void 0;"scrollParent"===r?"BODY"===(a=l(f(t))).nodeName&&(a=e.ownerDocument.documentElement):a="window"===r?e.ownerDocument.documentElement:r;var c=M(a,s,i);if("HTML"!==a.nodeName||D(s))o=c;else{var d=x(e.ownerDocument),p=d.height,h=d.width;o.top+=c.top-c.marginTop,o.bottom=p+c.top,o.left+=c.left-c.marginLeft,o.right=h+c.left}}var m="number"==typeof(n=n||0);return o.left+=m?n:n.left||0,o.top+=m?n:n.top||0,o.right-=m?n:n.right||0,o.bottom-=m?n:n.bottom||0,o}function F(e){return e.width*e.height}function H(e,t,n,r,i){var o=arguments.length>5&&void 0!==arguments[5]?arguments[5]:0;if(-1===e.indexOf("auto"))return e;var s=A(n,r,o,i),a={top:{width:s.width,height:t.top-s.top},right:{width:s.right-t.right,height:s.height},bottom:{width:s.width,height:s.bottom-t.bottom},left:{width:t.left-s.left,height:s.height}},f=Object.keys(a).map((function(e){return C({key:e},a[e],{area:F(a[e])})})).sort((function(e,t){return t.area-e.area})),l=f.filter((function(e){var t=e.width,r=e.height;return t>=n.clientWidth&&r>=n.clientHeight})),u=l.length>0?l[0].key:f[0].key,c=e.split("-")[1];return u+(c?"-"+c:"")}function $(e,t,n){var r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:null,i=r?S(t):v(t,u(n));return M(n,i,r)}function j(e){var t=e.ownerDocument.defaultView.getComputedStyle(e),n=parseFloat(t.marginTop||0)+parseFloat(t.marginBottom||0),r=parseFloat(t.marginLeft||0)+parseFloat(t.marginRight||0);return{width:e.offsetWidth+r,height:e.offsetHeight+n}}function B(e){var t={left:"right",right:"left",bottom:"top",top:"bottom"};return e.replace(/left|right|bottom|top/g,(function(e){return t[e]}))}function _(e,t,n){n=n.split("-")[0];var r=j(e),i={width:r.width,height:r.height},o=-1!==["right","left"].indexOf(n),s=o?"top":"left",a=o?"left":"top",f=o?"height":"width",l=o?"width":"height";return i[s]=t[s]+t[f]/2-r[f]/2,i[a]=n===a?t[a]-r[l]:t[B(a)],i}function V(e,t){return Array.prototype.find?e.find(t):e.filter(t)[0]}function W(e,t,n){return(void 0===n?e:e.slice(0,function(e,t,n){if(Array.prototype.findIndex)return e.findIndex((function(e){return e[t]===n}));var r=V(e,(function(e){return e[t]===n}));return e.indexOf(r)}(e,"name",n))).forEach((function(e){e.function&&console.warn("`modifier.function` is deprecated, use `modifier.fn`!");var n=e.function||e.fn;e.enabled&&s(n)&&(t.offsets.popper=N(t.offsets.popper),t.offsets.reference=N(t.offsets.reference),t=n(t,e))})),t}function z(){if(!this.state.isDestroyed){var e={instance:this,styles:{},arrowStyles:{},attributes:{},flipped:!1,offsets:{}};e.offsets.reference=$(this.state,this.popper,this.reference,this.options.positionFixed),e.placement=H(this.options.placement,e.offsets.reference,this.popper,this.reference,this.options.modifiers.flip.boundariesElement,this.options.modifiers.flip.padding),e.originalPlacement=e.placement,e.positionFixed=this.options.positionFixed,e.offsets.popper=_(this.popper,e.offsets.reference,e.placement),e.offsets.popper.position=this.options.positionFixed?"fixed":"absolute",e=W(this.modifiers,e),this.state.isCreated?this.options.onUpdate(e):(this.state.isCreated=!0,this.options.onCreate(e))}}function I(e,t){return e.some((function(e){var n=e.name;return e.enabled&&n===t}))}function P(e){for(var t=[!1,"ms","Webkit","Moz","O"],n=e.charAt(0).toUpperCase()+e.slice(1),r=0;r<t.length;r++){var i=t[r],o=i?""+i+n:e;if(void 0!==document.body.style[o])return o}return null}function R(){return this.state.isDestroyed=!0,I(this.modifiers,"applyStyle")&&(this.popper.removeAttribute("x-placement"),this.popper.style.position="",this.popper.style.top="",this.popper.style.left="",this.popper.style.right="",this.popper.style.bottom="",this.popper.style.willChange="",this.popper.style[P("transform")]=""),this.disableEventListeners(),this.options.removeOnDestroy&&this.popper.parentNode.removeChild(this.popper),this}function q(e){var t=e.ownerDocument;return t?t.defaultView:window}function U(e,t,n,r){var i="BODY"===e.nodeName,o=i?e.ownerDocument.defaultView:e;o.addEventListener(t,n,{passive:!0}),i||U(l(o.parentNode),t,n,r),r.push(o)}function Z(e,t,n,r){n.updateBound=r,q(e).addEventListener("resize",n.updateBound,{passive:!0});var i=l(e);return U(i,"scroll",n.updateBound,n.scrollParents),n.scrollElement=i,n.eventsEnabled=!0,n}function Y(){this.state.eventsEnabled||(this.state=Z(this.reference,this.options,this.state,this.scheduleUpdate))}function G(){var e,t;this.state.eventsEnabled&&(cancelAnimationFrame(this.scheduleUpdate),this.state=(e=this.reference,t=this.state,q(e).removeEventListener("resize",t.updateBound),t.scrollParents.forEach((function(e){e.removeEventListener("scroll",t.updateBound)})),t.updateBound=null,t.scrollParents=[],t.scrollElement=null,t.eventsEnabled=!1,t))}function J(e){return""!==e&&!isNaN(parseFloat(e))&&isFinite(e)}function X(e,t){Object.keys(t).forEach((function(n){var r="";-1!==["width","height","top","right","bottom","left"].indexOf(n)&&J(t[n])&&(r="px"),e.style[n]=t[n]+r}))}var K=r&&/Firefox/i.test(navigator.userAgent);function Q(e,t,n){var r=V(e,(function(e){return e.name===t})),i=!!r&&e.some((function(e){return e.name===n&&e.enabled&&e.order<r.order}));if(!i){var o="`"+t+"`",s="`"+n+"`";console.warn(s+" modifier is required by "+o+" modifier in order to work, be sure to include it before "+o+"!")}return i}var ee=["auto-start","auto","auto-end","top-start","top","top-end","right-start","right","right-end","bottom-end","bottom","bottom-start","left-end","left","left-start"],te=ee.slice(3);function ne(e){var t=arguments.length>1&&void 0!==arguments[1]&&arguments[1],n=te.indexOf(e),r=te.slice(n+1).concat(te.slice(0,n));return t?r.reverse():r}var re="flip",ie="clockwise",oe="counterclockwise";function se(e,t,n,r){var i=[0,0],o=-1!==["right","left"].indexOf(r),s=e.split(/(\+|\-)/).map((function(e){return e.trim()})),a=s.indexOf(V(s,(function(e){return-1!==e.search(/,|\s/)})));s[a]&&-1===s[a].indexOf(",")&&console.warn("Offsets separated by white space(s) are deprecated, use a comma (,) instead.");var f=/\s*,\s*|\s+/,l=-1!==a?[s.slice(0,a).concat([s[a].split(f)[0]]),[s[a].split(f)[1]].concat(s.slice(a+1))]:[s];return(l=l.map((function(e,r){var i=(1===r?!o:o)?"height":"width",s=!1;return e.reduce((function(e,t){return""===e[e.length-1]&&-1!==["+","-"].indexOf(t)?(e[e.length-1]=t,s=!0,e):s?(e[e.length-1]+=t,s=!1,e):e.concat(t)}),[]).map((function(e){return function(e,t,n,r){var i=e.match(/((?:\-|\+)?\d*\.?\d*)(.*)/),o=+i[1],s=i[2];if(!o)return e;if(0===s.indexOf("%")){var a=void 0;switch(s){case"%p":a=n;break;case"%":case"%r":default:a=r}return N(a)[t]/100*o}if("vh"===s||"vw"===s)return("vh"===s?Math.max(document.documentElement.clientHeight,window.innerHeight||0):Math.max(document.documentElement.clientWidth,window.innerWidth||0))/100*o;return o}(e,i,t,n)}))}))).forEach((function(e,t){e.forEach((function(n,r){J(n)&&(i[t]+=n*("-"===e[r-1]?-1:1))}))})),i}var ae={placement:"bottom",positionFixed:!1,eventsEnabled:!0,removeOnDestroy:!1,onCreate:function(){},onUpdate:function(){},modifiers:{shift:{order:100,enabled:!0,fn:function(e){var t=e.placement,n=t.split("-")[0],r=t.split("-")[1];if(r){var i=e.offsets,o=i.reference,s=i.popper,a=-1!==["bottom","top"].indexOf(n),f=a?"left":"top",l=a?"width":"height",u={start:T({},f,o[f]),end:T({},f,o[f]+o[l]-s[l])};e.offsets.popper=C({},s,u[r])}return e}},offset:{order:200,enabled:!0,fn:function(e,t){var n=t.offset,r=e.placement,i=e.offsets,o=i.popper,s=i.reference,a=r.split("-")[0],f=void 0;return f=J(+n)?[+n,0]:se(n,o,s,a),"left"===a?(o.top+=f[0],o.left-=f[1]):"right"===a?(o.top+=f[0],o.left+=f[1]):"top"===a?(o.left+=f[0],o.top-=f[1]):"bottom"===a&&(o.left+=f[0],o.top+=f[1]),e.popper=o,e},offset:0},preventOverflow:{order:300,enabled:!0,fn:function(e,t){var n=t.boundariesElement||h(e.instance.popper);e.instance.reference===n&&(n=h(n));var r=P("transform"),i=e.instance.popper.style,o=i.top,s=i.left,a=i[r];i.top="",i.left="",i[r]="";var f=A(e.instance.popper,e.instance.reference,t.padding,n,e.positionFixed);i.top=o,i.left=s,i[r]=a,t.boundaries=f;var l=t.priority,u=e.offsets.popper,c={primary:function(e){var n=u[e];return u[e]<f[e]&&!t.escapeWithReference&&(n=Math.max(u[e],f[e])),T({},e,n)},secondary:function(e){var n="right"===e?"left":"top",r=u[n];return u[e]>f[e]&&!t.escapeWithReference&&(r=Math.min(u[n],f[e]-("right"===e?u.width:u.height))),T({},n,r)}};return l.forEach((function(e){var t=-1!==["left","top"].indexOf(e)?"primary":"secondary";u=C({},u,c[t](e))})),e.offsets.popper=u,e},priority:["left","right","top","bottom"],padding:5,boundariesElement:"scrollParent"},keepTogether:{order:400,enabled:!0,fn:function(e){var t=e.offsets,n=t.popper,r=t.reference,i=e.placement.split("-")[0],o=Math.floor,s=-1!==["top","bottom"].indexOf(i),a=s?"right":"bottom",f=s?"left":"top",l=s?"width":"height";return n[a]<o(r[f])&&(e.offsets.popper[f]=o(r[f])-n[l]),n[f]>o(r[a])&&(e.offsets.popper[f]=o(r[a])),e}},arrow:{order:500,enabled:!0,fn:function(e,t){var n;if(!Q(e.instance.modifiers,"arrow","keepTogether"))return e;var r=t.element;if("string"==typeof r){if(!(r=e.instance.popper.querySelector(r)))return e}else if(!e.instance.popper.contains(r))return console.warn("WARNING: `arrow.element` must be child of its popper element!"),e;var i=e.placement.split("-")[0],o=e.offsets,s=o.popper,f=o.reference,l=-1!==["left","right"].indexOf(i),u=l?"height":"width",c=l?"Top":"Left",d=c.toLowerCase(),p=l?"left":"top",h=l?"bottom":"right",m=j(r)[u];f[h]-m<s[d]&&(e.offsets.popper[d]-=s[d]-(f[h]-m)),f[d]+m>s[h]&&(e.offsets.popper[d]+=f[d]+m-s[h]),e.offsets.popper=N(e.offsets.popper);var v=f[d]+f[u]/2-m/2,g=a(e.instance.popper),b=parseFloat(g["margin"+c]),w=parseFloat(g["border"+c+"Width"]),y=v-e.offsets.popper[d]-b-w;return y=Math.max(Math.min(s[u]-m,y),0),e.arrowElement=r,e.offsets.arrow=(T(n={},d,Math.round(y)),T(n,p,""),n),e},element:"[x-arrow]"},flip:{order:600,enabled:!0,fn:function(e,t){if(I(e.instance.modifiers,"inner"))return e;if(e.flipped&&e.placement===e.originalPlacement)return e;var n=A(e.instance.popper,e.instance.reference,t.padding,t.boundariesElement,e.positionFixed),r=e.placement.split("-")[0],i=B(r),o=e.placement.split("-")[1]||"",s=[];switch(t.behavior){case re:s=[r,i];break;case ie:s=ne(r);break;case oe:s=ne(r,!0);break;default:s=t.behavior}return s.forEach((function(a,f){if(r!==a||s.length===f+1)return e;r=e.placement.split("-")[0],i=B(r);var l=e.offsets.popper,u=e.offsets.reference,c=Math.floor,d="left"===r&&c(l.right)>c(u.left)||"right"===r&&c(l.left)<c(u.right)||"top"===r&&c(l.bottom)>c(u.top)||"bottom"===r&&c(l.top)<c(u.bottom),p=c(l.left)<c(n.left),h=c(l.right)>c(n.right),m=c(l.top)<c(n.top),v=c(l.bottom)>c(n.bottom),g="left"===r&&p||"right"===r&&h||"top"===r&&m||"bottom"===r&&v,b=-1!==["top","bottom"].indexOf(r),w=!!t.flipVariations&&(b&&"start"===o&&p||b&&"end"===o&&h||!b&&"start"===o&&m||!b&&"end"===o&&v),y=!!t.flipVariationsByContent&&(b&&"start"===o&&h||b&&"end"===o&&p||!b&&"start"===o&&v||!b&&"end"===o&&m),x=w||y;(d||g||x)&&(e.flipped=!0,(d||g)&&(r=s[f+1]),x&&(o=function(e){return"end"===e?"start":"start"===e?"end":e}(o)),e.placement=r+(o?"-"+o:""),e.offsets.popper=C({},e.offsets.popper,_(e.instance.popper,e.offsets.reference,e.placement)),e=W(e.instance.modifiers,e,"flip"))})),e},behavior:"flip",padding:5,boundariesElement:"viewport",flipVariations:!1,flipVariationsByContent:!1},inner:{order:700,enabled:!1,fn:function(e){var t=e.placement,n=t.split("-")[0],r=e.offsets,i=r.popper,o=r.reference,s=-1!==["left","right"].indexOf(n),a=-1===["top","left"].indexOf(n);return i[s?"left":"top"]=o[n]-(a?i[s?"width":"height"]:0),e.placement=B(t),e.offsets.popper=N(i),e}},hide:{order:800,enabled:!0,fn:function(e){if(!Q(e.instance.modifiers,"hide","preventOverflow"))return e;var t=e.offsets.reference,n=V(e.instance.modifiers,(function(e){return"preventOverflow"===e.name})).boundaries;if(t.bottom<n.top||t.left>n.right||t.top>n.bottom||t.right<n.left){if(!0===e.hide)return e;e.hide=!0,e.attributes["x-out-of-boundaries"]=""}else{if(!1===e.hide)return e;e.hide=!1,e.attributes["x-out-of-boundaries"]=!1}return e}},computeStyle:{order:850,enabled:!0,fn:function(e,t){var n=t.x,r=t.y,i=e.offsets.popper,o=V(e.instance.modifiers,(function(e){return"applyStyle"===e.name})).gpuAcceleration;void 0!==o&&console.warn("WARNING: `gpuAcceleration` option moved to `computeStyle` modifier and will not be supported in future versions of Popper.js!");var s=void 0!==o?o:t.gpuAcceleration,a=h(e.instance.popper),f=L(a),l={position:i.position},u=function(e,t){var n=e.offsets,r=n.popper,i=n.reference,o=Math.round,s=Math.floor,a=function(e){return e},f=o(i.width),l=o(r.width),u=-1!==["left","right"].indexOf(e.placement),c=-1!==e.placement.indexOf("-"),d=t?u||c||f%2==l%2?o:s:a,p=t?o:a;return{left:d(f%2==1&&l%2==1&&!c&&t?r.left-1:r.left),top:p(r.top),bottom:p(r.bottom),right:d(r.right)}}(e,window.devicePixelRatio<2||!K),c="bottom"===n?"top":"bottom",d="right"===r?"left":"right",p=P("transform"),m=void 0,v=void 0;if(v="bottom"===c?"HTML"===a.nodeName?-a.clientHeight+u.bottom:-f.height+u.bottom:u.top,m="right"===d?"HTML"===a.nodeName?-a.clientWidth+u.right:-f.width+u.right:u.left,s&&p)l[p]="translate3d("+m+"px, "+v+"px, 0)",l[c]=0,l[d]=0,l.willChange="transform";else{var g="bottom"===c?-1:1,b="right"===d?-1:1;l[c]=v*g,l[d]=m*b,l.willChange=c+", "+d}var w={"x-placement":e.placement};return e.attributes=C({},w,e.attributes),e.styles=C({},l,e.styles),e.arrowStyles=C({},e.offsets.arrow,e.arrowStyles),e},gpuAcceleration:!0,x:"bottom",y:"right"},applyStyle:{order:900,enabled:!0,fn:function(e){var t,n;return X(e.instance.popper,e.styles),t=e.instance.popper,n=e.attributes,Object.keys(n).forEach((function(e){!1!==n[e]?t.setAttribute(e,n[e]):t.removeAttribute(e)})),e.arrowElement&&Object.keys(e.arrowStyles).length&&X(e.arrowElement,e.arrowStyles),e},onLoad:function(e,t,n,r,i){var o=$(i,t,e,n.positionFixed),s=H(n.placement,o,t,e,n.modifiers.flip.boundariesElement,n.modifiers.flip.padding);return t.setAttribute("x-placement",s),X(t,{position:n.positionFixed?"fixed":"absolute"}),n},gpuAcceleration:void 0}}},fe=function(){function e(t,n){var r=this,i=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};E(this,e),this.scheduleUpdate=function(){return requestAnimationFrame(r.update)},this.update=o(this.update.bind(this)),this.options=C({},e.Defaults,i),this.state={isDestroyed:!1,isCreated:!1,scrollParents:[]},this.reference=t&&t.jquery?t[0]:t,this.popper=n&&n.jquery?n[0]:n,this.options.modifiers={},Object.keys(C({},e.Defaults.modifiers,i.modifiers)).forEach((function(t){r.options.modifiers[t]=C({},e.Defaults.modifiers[t]||{},i.modifiers?i.modifiers[t]:{})})),this.modifiers=Object.keys(this.options.modifiers).map((function(e){return C({name:e},r.options.modifiers[e])})).sort((function(e,t){return e.order-t.order})),this.modifiers.forEach((function(e){e.enabled&&s(e.onLoad)&&e.onLoad(r.reference,r.popper,r.options,e,r.state)})),this.update();var a=this.options.eventsEnabled;a&&this.enableEventListeners(),this.state.eventsEnabled=a}return O(e,[{key:"update",value:function(){return z.call(this)}},{key:"destroy",value:function(){return R.call(this)}},{key:"enableEventListeners",value:function(){return Y.call(this)}},{key:"disableEventListeners",value:function(){return G.call(this)}}]),e}();fe.Utils=("undefined"!=typeof window?window:n.g).PopperUtils,fe.placements=ee,fe.Defaults=ae;const le=fe},3379:(e,t,n)=>{"use strict";var r,i=function(){return void 0===r&&(r=Boolean(window&&document&&document.all&&!window.atob)),r},o=function(){var e={};return function(t){if(void 0===e[t]){var n=document.querySelector(t);if(window.HTMLIFrameElement&&n instanceof window.HTMLIFrameElement)try{n=n.contentDocument.head}catch(e){n=null}e[t]=n}return e[t]}}(),s=[];function a(e){for(var t=-1,n=0;n<s.length;n++)if(s[n].identifier===e){t=n;break}return t}function f(e,t){for(var n={},r=[],i=0;i<e.length;i++){var o=e[i],f=t.base?o[0]+t.base:o[0],l=n[f]||0,u="".concat(f," ").concat(l);n[f]=l+1;var c=a(u),d={css:o[1],media:o[2],sourceMap:o[3]};-1!==c?(s[c].references++,s[c].updater(d)):s.push({identifier:u,updater:v(d,t),references:1}),r.push(u)}return r}function l(e){var t=document.createElement("style"),r=e.attributes||{};if(void 0===r.nonce){var i=n.nc;i&&(r.nonce=i)}if(Object.keys(r).forEach((function(e){t.setAttribute(e,r[e])})),"function"==typeof e.insert)e.insert(t);else{var s=o(e.insert||"head");if(!s)throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");s.appendChild(t)}return t}var u,c=(u=[],function(e,t){return u[e]=t,u.filter(Boolean).join("\n")});function d(e,t,n,r){var i=n?"":r.media?"@media ".concat(r.media," {").concat(r.css,"}"):r.css;if(e.styleSheet)e.styleSheet.cssText=c(t,i);else{var o=document.createTextNode(i),s=e.childNodes;s[t]&&e.removeChild(s[t]),s.length?e.insertBefore(o,s[t]):e.appendChild(o)}}function p(e,t,n){var r=n.css,i=n.media,o=n.sourceMap;if(i?e.setAttribute("media",i):e.removeAttribute("media"),o&&"undefined"!=typeof btoa&&(r+="\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(o))))," */")),e.styleSheet)e.styleSheet.cssText=r;else{for(;e.firstChild;)e.removeChild(e.firstChild);e.appendChild(document.createTextNode(r))}}var h=null,m=0;function v(e,t){var n,r,i;if(t.singleton){var o=m++;n=h||(h=l(t)),r=d.bind(null,n,o,!1),i=d.bind(null,n,o,!0)}else n=l(t),r=p.bind(null,n,t),i=function(){!function(e){if(null===e.parentNode)return!1;e.parentNode.removeChild(e)}(n)};return r(e),function(t){if(t){if(t.css===e.css&&t.media===e.media&&t.sourceMap===e.sourceMap)return;r(e=t)}else i()}}e.exports=function(e,t){(t=t||{}).singleton||"boolean"==typeof t.singleton||(t.singleton=i());var n=f(e=e||[],t);return function(e){if(e=e||[],"[object Array]"===Object.prototype.toString.call(e)){for(var r=0;r<n.length;r++){var i=a(n[r]);s[i].references--}for(var o=f(e,t),l=0;l<n.length;l++){var u=a(n[l]);0===s[u].references&&(s[u].updater(),s.splice(u,1))}n=o}}}},5647:(e,t,n)=>{"use strict";n.r(t),n.d(t,{default:()=>f});const r={mixins:[n(2102).Z],props:{options:{required:!0,type:Array},label:{required:!0,type:String}},methods:{changeOption:function(e){this.currentValue=e,this.validate()}}};var i=n(3379),o=n.n(i),s=n(7077),a={insert:"head",singleton:!1};o()(s.Z,a);s.Z.locals;const f=(0,n(1900).Z)(r,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"flex flex-col"},[n("span",{staticClass:"font-semibold text-lg mb-2"},[e._v(e._s(e.label))]),e._v(" "),e._l(e.options,(function(t){return n("div",{staticClass:"flex items-center cursor-pointer",on:{click:function(n){return e.changeOption(t.value)}}},[n("div",{staticClass:"p-2 pl-0"},[n("div",{staticClass:"border border-grey-off bg-grey-lightest p-1 text-xl",class:t.value===e.currentValue?"text-green":"text-grey-off-light"},[n("font-awesome-icon",{attrs:{icon:["fas","check"]}})],1)]),e._v(" "),n("div",{staticClass:"flex-1"},[e._v("\n            "+e._s(t.label)+"\n        ")])])}))],2)}),[],!1,null,null,null).exports},7777:(e,t,n)=>{"use strict";n.d(t,{do:()=>o});var r=void 0;function i(){i.init||(i.init=!0,r=-1!==function(){var e=window.navigator.userAgent,t=e.indexOf("MSIE ");if(t>0)return parseInt(e.substring(t+5,e.indexOf(".",t)),10);if(e.indexOf("Trident/")>0){var n=e.indexOf("rv:");return parseInt(e.substring(n+3,e.indexOf(".",n)),10)}var r=e.indexOf("Edge/");return r>0?parseInt(e.substring(r+5,e.indexOf(".",r)),10):-1}())}var o={render:function(){var e=this.$createElement;return(this._self._c||e)("div",{staticClass:"resize-observer",attrs:{tabindex:"-1"}})},staticRenderFns:[],_scopeId:"data-v-b329ee4c",name:"resize-observer",methods:{compareAndNotify:function(){this._w===this.$el.offsetWidth&&this._h===this.$el.offsetHeight||(this._w=this.$el.offsetWidth,this._h=this.$el.offsetHeight,this.$emit("notify"))},addResizeHandlers:function(){this._resizeObject.contentDocument.defaultView.addEventListener("resize",this.compareAndNotify),this.compareAndNotify()},removeResizeHandlers:function(){this._resizeObject&&this._resizeObject.onload&&(!r&&this._resizeObject.contentDocument&&this._resizeObject.contentDocument.defaultView.removeEventListener("resize",this.compareAndNotify),delete this._resizeObject.onload)}},mounted:function(){var e=this;i(),this.$nextTick((function(){e._w=e.$el.offsetWidth,e._h=e.$el.offsetHeight}));var t=document.createElement("object");this._resizeObject=t,t.setAttribute("aria-hidden","true"),t.setAttribute("tabindex",-1),t.onload=this.addResizeHandlers,t.type="text/html",r&&this.$el.appendChild(t),t.data="about:blank",r||this.$el.appendChild(t)},beforeDestroy:function(){this.removeResizeHandlers()}};var s={version:"0.4.5",install:function(e){e.component("resize-observer",o),e.component("ResizeObserver",o)}},a=null;"undefined"!=typeof window?a=window.Vue:void 0!==n.g&&(a=n.g.Vue),a&&a.use(s)}}]);