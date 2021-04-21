/*! For license information please see chunk-dashboard-user-details.js.LICENSE.txt */
(self.webpackChunk=self.webpackChunk||[]).push([[4809],{8981:(e,t,n)=>{"use strict";n.d(t,{Z:()=>le});var r="undefined"!=typeof window&&"undefined"!=typeof document&&"undefined"!=typeof navigator,o=function(){for(var e=["Edge","Trident","Firefox"],t=0;t<e.length;t+=1)if(r&&navigator.userAgent.indexOf(e[t])>=0)return 1;return 0}();var i=r&&window.Promise?function(e){var t=!1;return function(){t||(t=!0,window.Promise.resolve().then((function(){t=!1,e()})))}}:function(e){var t=!1;return function(){t||(t=!0,setTimeout((function(){t=!1,e()}),o))}};function s(e){return e&&"[object Function]"==={}.toString.call(e)}function a(e,t){if(1!==e.nodeType)return[];var n=e.ownerDocument.defaultView.getComputedStyle(e,null);return t?n[t]:n}function d(e){return"HTML"===e.nodeName?e:e.parentNode||e.host}function l(e){if(!e)return document.body;switch(e.nodeName){case"HTML":case"BODY":return e.ownerDocument.body;case"#document":return e.body}var t=a(e),n=t.overflow,r=t.overflowX,o=t.overflowY;return/(auto|scroll|overlay)/.test(n+o+r)?e:l(d(e))}function c(e){return e&&e.referenceNode?e.referenceNode:e}var u=r&&!(!window.MSInputMethodContext||!document.documentMode),f=r&&/MSIE 10/.test(navigator.userAgent);function p(e){return 11===e?u:10===e?f:u||f}function h(e){if(!e)return document.documentElement;for(var t=p(10)?document.body:null,n=e.offsetParent||null;n===t&&e.nextElementSibling;)n=(e=e.nextElementSibling).offsetParent;var r=n&&n.nodeName;return r&&"BODY"!==r&&"HTML"!==r?-1!==["TH","TD","TABLE"].indexOf(n.nodeName)&&"static"===a(n,"position")?h(n):n:e?e.ownerDocument.documentElement:document.documentElement}function m(e){return null!==e.parentNode?m(e.parentNode):e}function v(e,t){if(!(e&&e.nodeType&&t&&t.nodeType))return document.documentElement;var n=e.compareDocumentPosition(t)&Node.DOCUMENT_POSITION_FOLLOWING,r=n?e:t,o=n?t:e,i=document.createRange();i.setStart(r,0),i.setEnd(o,0);var s,a,d=i.commonAncestorContainer;if(e!==d&&t!==d||r.contains(o))return"BODY"===(a=(s=d).nodeName)||"HTML"!==a&&h(s.firstElementChild)!==s?h(d):d;var l=m(e);return l.host?v(l.host,t):v(e,m(t).host)}function b(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"top",n="top"===t?"scrollTop":"scrollLeft",r=e.nodeName;if("BODY"===r||"HTML"===r){var o=e.ownerDocument.documentElement,i=e.ownerDocument.scrollingElement||o;return i[n]}return e[n]}function g(e,t){var n=arguments.length>2&&void 0!==arguments[2]&&arguments[2],r=b(t,"top"),o=b(t,"left"),i=n?-1:1;return e.top+=r*i,e.bottom+=r*i,e.left+=o*i,e.right+=o*i,e}function w(e,t){var n="x"===t?"Left":"Top",r="Left"===n?"Right":"Bottom";return parseFloat(e["border"+n+"Width"])+parseFloat(e["border"+r+"Width"])}function y(e,t,n,r){return Math.max(t["offset"+e],t["scroll"+e],n["client"+e],n["offset"+e],n["scroll"+e],p(10)?parseInt(n["offset"+e])+parseInt(r["margin"+("Height"===e?"Top":"Left")])+parseInt(r["margin"+("Height"===e?"Bottom":"Right")]):0)}function x(e){var t=e.body,n=e.documentElement,r=p(10)&&getComputedStyle(n);return{height:y("Height",t,n,r),width:y("Width",t,n,r)}}var _=function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")},E=function(){function e(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}return function(t,n,r){return n&&e(t.prototype,n),r&&e(t,r),t}}(),C=function(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e},O=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var r in n)Object.prototype.hasOwnProperty.call(n,r)&&(e[r]=n[r])}return e};function A(e){return O({},e,{right:e.left+e.width,bottom:e.top+e.height})}function D(e){var t={};try{if(p(10)){t=e.getBoundingClientRect();var n=b(e,"top"),r=b(e,"left");t.top+=n,t.left+=r,t.bottom+=n,t.right+=r}else t=e.getBoundingClientRect()}catch(e){}var o={left:t.left,top:t.top,width:t.right-t.left,height:t.bottom-t.top},i="HTML"===e.nodeName?x(e.ownerDocument):{},s=i.width||e.clientWidth||o.width,d=i.height||e.clientHeight||o.height,l=e.offsetWidth-s,c=e.offsetHeight-d;if(l||c){var u=a(e);l-=w(u,"x"),c-=w(u,"y"),o.width-=l,o.height-=c}return A(o)}function k(e,t){var n=arguments.length>2&&void 0!==arguments[2]&&arguments[2],r=p(10),o="HTML"===t.nodeName,i=D(e),s=D(t),d=l(e),c=a(t),u=parseFloat(c.borderTopWidth),f=parseFloat(c.borderLeftWidth);n&&o&&(s.top=Math.max(s.top,0),s.left=Math.max(s.left,0));var h=A({top:i.top-s.top-u,left:i.left-s.left-f,width:i.width,height:i.height});if(h.marginTop=0,h.marginLeft=0,!r&&o){var m=parseFloat(c.marginTop),v=parseFloat(c.marginLeft);h.top-=u-m,h.bottom-=u-m,h.left-=f-v,h.right-=f-v,h.marginTop=m,h.marginLeft=v}return(r&&!n?t.contains(d):t===d&&"BODY"!==d.nodeName)&&(h=g(h,t)),h}function M(e){var t=arguments.length>1&&void 0!==arguments[1]&&arguments[1],n=e.ownerDocument.documentElement,r=k(e,n),o=Math.max(n.clientWidth,window.innerWidth||0),i=Math.max(n.clientHeight,window.innerHeight||0),s=t?0:b(n),a=t?0:b(n,"left"),d={top:s-r.top+r.marginTop,left:a-r.left+r.marginLeft,width:o,height:i};return A(d)}function $(e){var t=e.nodeName;if("BODY"===t||"HTML"===t)return!1;if("fixed"===a(e,"position"))return!0;var n=d(e);return!!n&&$(n)}function T(e){if(!e||!e.parentElement||p())return document.documentElement;for(var t=e.parentElement;t&&"none"===a(t,"transform");)t=t.parentElement;return t||document.documentElement}function P(e,t,n,r){var o=arguments.length>4&&void 0!==arguments[4]&&arguments[4],i={top:0,left:0},s=o?T(e):v(e,c(t));if("viewport"===r)i=M(s,o);else{var a=void 0;"scrollParent"===r?"BODY"===(a=l(d(t))).nodeName&&(a=e.ownerDocument.documentElement):a="window"===r?e.ownerDocument.documentElement:r;var u=k(a,s,o);if("HTML"!==a.nodeName||$(s))i=u;else{var f=x(e.ownerDocument),p=f.height,h=f.width;i.top+=u.top-u.marginTop,i.bottom=p+u.top,i.left+=u.left-u.marginLeft,i.right=h+u.left}}var m="number"==typeof(n=n||0);return i.left+=m?n:n.left||0,i.top+=m?n:n.top||0,i.right-=m?n:n.right||0,i.bottom-=m?n:n.bottom||0,i}function N(e){return e.width*e.height}function F(e,t,n,r,o){var i=arguments.length>5&&void 0!==arguments[5]?arguments[5]:0;if(-1===e.indexOf("auto"))return e;var s=P(n,r,i,o),a={top:{width:s.width,height:t.top-s.top},right:{width:s.right-t.right,height:s.height},bottom:{width:s.width,height:s.bottom-t.bottom},left:{width:t.left-s.left,height:s.height}},d=Object.keys(a).map((function(e){return O({key:e},a[e],{area:N(a[e])})})).sort((function(e,t){return t.area-e.area})),l=d.filter((function(e){var t=e.width,r=e.height;return t>=n.clientWidth&&r>=n.clientHeight})),c=l.length>0?l[0].key:d[0].key,u=e.split("-")[1];return c+(u?"-"+u:"")}function L(e,t,n){var r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:null,o=r?T(t):v(t,c(n));return k(n,o,r)}function S(e){var t=e.ownerDocument.defaultView.getComputedStyle(e),n=parseFloat(t.marginTop||0)+parseFloat(t.marginBottom||0),r=parseFloat(t.marginLeft||0)+parseFloat(t.marginRight||0);return{width:e.offsetWidth+r,height:e.offsetHeight+n}}function j(e){var t={left:"right",right:"left",bottom:"top",top:"bottom"};return e.replace(/left|right|bottom|top/g,(function(e){return t[e]}))}function H(e,t,n){n=n.split("-")[0];var r=S(e),o={width:r.width,height:r.height},i=-1!==["right","left"].indexOf(n),s=i?"top":"left",a=i?"left":"top",d=i?"height":"width",l=i?"width":"height";return o[s]=t[s]+t[d]/2-r[d]/2,o[a]=n===a?t[a]-r[l]:t[j(a)],o}function q(e,t){return Array.prototype.find?e.find(t):e.filter(t)[0]}function W(e,t,n){return(void 0===n?e:e.slice(0,function(e,t,n){if(Array.prototype.findIndex)return e.findIndex((function(e){return e[t]===n}));var r=q(e,(function(e){return e[t]===n}));return e.indexOf(r)}(e,"name",n))).forEach((function(e){e.function&&console.warn("`modifier.function` is deprecated, use `modifier.fn`!");var n=e.function||e.fn;e.enabled&&s(n)&&(t.offsets.popper=A(t.offsets.popper),t.offsets.reference=A(t.offsets.reference),t=n(t,e))})),t}function B(){if(!this.state.isDestroyed){var e={instance:this,styles:{},arrowStyles:{},attributes:{},flipped:!1,offsets:{}};e.offsets.reference=L(this.state,this.popper,this.reference,this.options.positionFixed),e.placement=F(this.options.placement,e.offsets.reference,this.popper,this.reference,this.options.modifiers.flip.boundariesElement,this.options.modifiers.flip.padding),e.originalPlacement=e.placement,e.positionFixed=this.options.positionFixed,e.offsets.popper=H(this.popper,e.offsets.reference,e.placement),e.offsets.popper.position=this.options.positionFixed?"fixed":"absolute",e=W(this.modifiers,e),this.state.isCreated?this.options.onUpdate(e):(this.state.isCreated=!0,this.options.onCreate(e))}}function R(e,t){return e.some((function(e){var n=e.name;return e.enabled&&n===t}))}function z(e){for(var t=[!1,"ms","Webkit","Moz","O"],n=e.charAt(0).toUpperCase()+e.slice(1),r=0;r<t.length;r++){var o=t[r],i=o?""+o+n:e;if(void 0!==document.body.style[i])return i}return null}function I(){return this.state.isDestroyed=!0,R(this.modifiers,"applyStyle")&&(this.popper.removeAttribute("x-placement"),this.popper.style.position="",this.popper.style.top="",this.popper.style.left="",this.popper.style.right="",this.popper.style.bottom="",this.popper.style.willChange="",this.popper.style[z("transform")]=""),this.disableEventListeners(),this.options.removeOnDestroy&&this.popper.parentNode.removeChild(this.popper),this}function Y(e){var t=e.ownerDocument;return t?t.defaultView:window}function U(e,t,n,r){var o="BODY"===e.nodeName,i=o?e.ownerDocument.defaultView:e;i.addEventListener(t,n,{passive:!0}),o||U(l(i.parentNode),t,n,r),r.push(i)}function V(e,t,n,r){n.updateBound=r,Y(e).addEventListener("resize",n.updateBound,{passive:!0});var o=l(e);return U(o,"scroll",n.updateBound,n.scrollParents),n.scrollElement=o,n.eventsEnabled=!0,n}function Z(){this.state.eventsEnabled||(this.state=V(this.reference,this.options,this.state,this.scheduleUpdate))}function G(){var e,t;this.state.eventsEnabled&&(cancelAnimationFrame(this.scheduleUpdate),this.state=(e=this.reference,t=this.state,Y(e).removeEventListener("resize",t.updateBound),t.scrollParents.forEach((function(e){e.removeEventListener("scroll",t.updateBound)})),t.updateBound=null,t.scrollParents=[],t.scrollElement=null,t.eventsEnabled=!1,t))}function X(e){return""!==e&&!isNaN(parseFloat(e))&&isFinite(e)}function K(e,t){Object.keys(t).forEach((function(n){var r="";-1!==["width","height","top","right","bottom","left"].indexOf(n)&&X(t[n])&&(r="px"),e.style[n]=t[n]+r}))}var J=r&&/Firefox/i.test(navigator.userAgent);function Q(e,t,n){var r=q(e,(function(e){return e.name===t})),o=!!r&&e.some((function(e){return e.name===n&&e.enabled&&e.order<r.order}));if(!o){var i="`"+t+"`",s="`"+n+"`";console.warn(s+" modifier is required by "+i+" modifier in order to work, be sure to include it before "+i+"!")}return o}var ee=["auto-start","auto","auto-end","top-start","top","top-end","right-start","right","right-end","bottom-end","bottom","bottom-start","left-end","left","left-start"],te=ee.slice(3);function ne(e){var t=arguments.length>1&&void 0!==arguments[1]&&arguments[1],n=te.indexOf(e),r=te.slice(n+1).concat(te.slice(0,n));return t?r.reverse():r}var re="flip",oe="clockwise",ie="counterclockwise";function se(e,t,n,r){var o=[0,0],i=-1!==["right","left"].indexOf(r),s=e.split(/(\+|\-)/).map((function(e){return e.trim()})),a=s.indexOf(q(s,(function(e){return-1!==e.search(/,|\s/)})));s[a]&&-1===s[a].indexOf(",")&&console.warn("Offsets separated by white space(s) are deprecated, use a comma (,) instead.");var d=/\s*,\s*|\s+/,l=-1!==a?[s.slice(0,a).concat([s[a].split(d)[0]]),[s[a].split(d)[1]].concat(s.slice(a+1))]:[s];return(l=l.map((function(e,r){var o=(1===r?!i:i)?"height":"width",s=!1;return e.reduce((function(e,t){return""===e[e.length-1]&&-1!==["+","-"].indexOf(t)?(e[e.length-1]=t,s=!0,e):s?(e[e.length-1]+=t,s=!1,e):e.concat(t)}),[]).map((function(e){return function(e,t,n,r){var o=e.match(/((?:\-|\+)?\d*\.?\d*)(.*)/),i=+o[1],s=o[2];if(!i)return e;if(0===s.indexOf("%")){var a=void 0;switch(s){case"%p":a=n;break;case"%":case"%r":default:a=r}return A(a)[t]/100*i}if("vh"===s||"vw"===s)return("vh"===s?Math.max(document.documentElement.clientHeight,window.innerHeight||0):Math.max(document.documentElement.clientWidth,window.innerWidth||0))/100*i;return i}(e,o,t,n)}))}))).forEach((function(e,t){e.forEach((function(n,r){X(n)&&(o[t]+=n*("-"===e[r-1]?-1:1))}))})),o}var ae={placement:"bottom",positionFixed:!1,eventsEnabled:!0,removeOnDestroy:!1,onCreate:function(){},onUpdate:function(){},modifiers:{shift:{order:100,enabled:!0,fn:function(e){var t=e.placement,n=t.split("-")[0],r=t.split("-")[1];if(r){var o=e.offsets,i=o.reference,s=o.popper,a=-1!==["bottom","top"].indexOf(n),d=a?"left":"top",l=a?"width":"height",c={start:C({},d,i[d]),end:C({},d,i[d]+i[l]-s[l])};e.offsets.popper=O({},s,c[r])}return e}},offset:{order:200,enabled:!0,fn:function(e,t){var n=t.offset,r=e.placement,o=e.offsets,i=o.popper,s=o.reference,a=r.split("-")[0],d=void 0;return d=X(+n)?[+n,0]:se(n,i,s,a),"left"===a?(i.top+=d[0],i.left-=d[1]):"right"===a?(i.top+=d[0],i.left+=d[1]):"top"===a?(i.left+=d[0],i.top-=d[1]):"bottom"===a&&(i.left+=d[0],i.top+=d[1]),e.popper=i,e},offset:0},preventOverflow:{order:300,enabled:!0,fn:function(e,t){var n=t.boundariesElement||h(e.instance.popper);e.instance.reference===n&&(n=h(n));var r=z("transform"),o=e.instance.popper.style,i=o.top,s=o.left,a=o[r];o.top="",o.left="",o[r]="";var d=P(e.instance.popper,e.instance.reference,t.padding,n,e.positionFixed);o.top=i,o.left=s,o[r]=a,t.boundaries=d;var l=t.priority,c=e.offsets.popper,u={primary:function(e){var n=c[e];return c[e]<d[e]&&!t.escapeWithReference&&(n=Math.max(c[e],d[e])),C({},e,n)},secondary:function(e){var n="right"===e?"left":"top",r=c[n];return c[e]>d[e]&&!t.escapeWithReference&&(r=Math.min(c[n],d[e]-("right"===e?c.width:c.height))),C({},n,r)}};return l.forEach((function(e){var t=-1!==["left","top"].indexOf(e)?"primary":"secondary";c=O({},c,u[t](e))})),e.offsets.popper=c,e},priority:["left","right","top","bottom"],padding:5,boundariesElement:"scrollParent"},keepTogether:{order:400,enabled:!0,fn:function(e){var t=e.offsets,n=t.popper,r=t.reference,o=e.placement.split("-")[0],i=Math.floor,s=-1!==["top","bottom"].indexOf(o),a=s?"right":"bottom",d=s?"left":"top",l=s?"width":"height";return n[a]<i(r[d])&&(e.offsets.popper[d]=i(r[d])-n[l]),n[d]>i(r[a])&&(e.offsets.popper[d]=i(r[a])),e}},arrow:{order:500,enabled:!0,fn:function(e,t){var n;if(!Q(e.instance.modifiers,"arrow","keepTogether"))return e;var r=t.element;if("string"==typeof r){if(!(r=e.instance.popper.querySelector(r)))return e}else if(!e.instance.popper.contains(r))return console.warn("WARNING: `arrow.element` must be child of its popper element!"),e;var o=e.placement.split("-")[0],i=e.offsets,s=i.popper,d=i.reference,l=-1!==["left","right"].indexOf(o),c=l?"height":"width",u=l?"Top":"Left",f=u.toLowerCase(),p=l?"left":"top",h=l?"bottom":"right",m=S(r)[c];d[h]-m<s[f]&&(e.offsets.popper[f]-=s[f]-(d[h]-m)),d[f]+m>s[h]&&(e.offsets.popper[f]+=d[f]+m-s[h]),e.offsets.popper=A(e.offsets.popper);var v=d[f]+d[c]/2-m/2,b=a(e.instance.popper),g=parseFloat(b["margin"+u]),w=parseFloat(b["border"+u+"Width"]),y=v-e.offsets.popper[f]-g-w;return y=Math.max(Math.min(s[c]-m,y),0),e.arrowElement=r,e.offsets.arrow=(C(n={},f,Math.round(y)),C(n,p,""),n),e},element:"[x-arrow]"},flip:{order:600,enabled:!0,fn:function(e,t){if(R(e.instance.modifiers,"inner"))return e;if(e.flipped&&e.placement===e.originalPlacement)return e;var n=P(e.instance.popper,e.instance.reference,t.padding,t.boundariesElement,e.positionFixed),r=e.placement.split("-")[0],o=j(r),i=e.placement.split("-")[1]||"",s=[];switch(t.behavior){case re:s=[r,o];break;case oe:s=ne(r);break;case ie:s=ne(r,!0);break;default:s=t.behavior}return s.forEach((function(a,d){if(r!==a||s.length===d+1)return e;r=e.placement.split("-")[0],o=j(r);var l=e.offsets.popper,c=e.offsets.reference,u=Math.floor,f="left"===r&&u(l.right)>u(c.left)||"right"===r&&u(l.left)<u(c.right)||"top"===r&&u(l.bottom)>u(c.top)||"bottom"===r&&u(l.top)<u(c.bottom),p=u(l.left)<u(n.left),h=u(l.right)>u(n.right),m=u(l.top)<u(n.top),v=u(l.bottom)>u(n.bottom),b="left"===r&&p||"right"===r&&h||"top"===r&&m||"bottom"===r&&v,g=-1!==["top","bottom"].indexOf(r),w=!!t.flipVariations&&(g&&"start"===i&&p||g&&"end"===i&&h||!g&&"start"===i&&m||!g&&"end"===i&&v),y=!!t.flipVariationsByContent&&(g&&"start"===i&&h||g&&"end"===i&&p||!g&&"start"===i&&v||!g&&"end"===i&&m),x=w||y;(f||b||x)&&(e.flipped=!0,(f||b)&&(r=s[d+1]),x&&(i=function(e){return"end"===e?"start":"start"===e?"end":e}(i)),e.placement=r+(i?"-"+i:""),e.offsets.popper=O({},e.offsets.popper,H(e.instance.popper,e.offsets.reference,e.placement)),e=W(e.instance.modifiers,e,"flip"))})),e},behavior:"flip",padding:5,boundariesElement:"viewport",flipVariations:!1,flipVariationsByContent:!1},inner:{order:700,enabled:!1,fn:function(e){var t=e.placement,n=t.split("-")[0],r=e.offsets,o=r.popper,i=r.reference,s=-1!==["left","right"].indexOf(n),a=-1===["top","left"].indexOf(n);return o[s?"left":"top"]=i[n]-(a?o[s?"width":"height"]:0),e.placement=j(t),e.offsets.popper=A(o),e}},hide:{order:800,enabled:!0,fn:function(e){if(!Q(e.instance.modifiers,"hide","preventOverflow"))return e;var t=e.offsets.reference,n=q(e.instance.modifiers,(function(e){return"preventOverflow"===e.name})).boundaries;if(t.bottom<n.top||t.left>n.right||t.top>n.bottom||t.right<n.left){if(!0===e.hide)return e;e.hide=!0,e.attributes["x-out-of-boundaries"]=""}else{if(!1===e.hide)return e;e.hide=!1,e.attributes["x-out-of-boundaries"]=!1}return e}},computeStyle:{order:850,enabled:!0,fn:function(e,t){var n=t.x,r=t.y,o=e.offsets.popper,i=q(e.instance.modifiers,(function(e){return"applyStyle"===e.name})).gpuAcceleration;void 0!==i&&console.warn("WARNING: `gpuAcceleration` option moved to `computeStyle` modifier and will not be supported in future versions of Popper.js!");var s=void 0!==i?i:t.gpuAcceleration,a=h(e.instance.popper),d=D(a),l={position:o.position},c=function(e,t){var n=e.offsets,r=n.popper,o=n.reference,i=Math.round,s=Math.floor,a=function(e){return e},d=i(o.width),l=i(r.width),c=-1!==["left","right"].indexOf(e.placement),u=-1!==e.placement.indexOf("-"),f=t?c||u||d%2==l%2?i:s:a,p=t?i:a;return{left:f(d%2==1&&l%2==1&&!u&&t?r.left-1:r.left),top:p(r.top),bottom:p(r.bottom),right:f(r.right)}}(e,window.devicePixelRatio<2||!J),u="bottom"===n?"top":"bottom",f="right"===r?"left":"right",p=z("transform"),m=void 0,v=void 0;if(v="bottom"===u?"HTML"===a.nodeName?-a.clientHeight+c.bottom:-d.height+c.bottom:c.top,m="right"===f?"HTML"===a.nodeName?-a.clientWidth+c.right:-d.width+c.right:c.left,s&&p)l[p]="translate3d("+m+"px, "+v+"px, 0)",l[u]=0,l[f]=0,l.willChange="transform";else{var b="bottom"===u?-1:1,g="right"===f?-1:1;l[u]=v*b,l[f]=m*g,l.willChange=u+", "+f}var w={"x-placement":e.placement};return e.attributes=O({},w,e.attributes),e.styles=O({},l,e.styles),e.arrowStyles=O({},e.offsets.arrow,e.arrowStyles),e},gpuAcceleration:!0,x:"bottom",y:"right"},applyStyle:{order:900,enabled:!0,fn:function(e){var t,n;return K(e.instance.popper,e.styles),t=e.instance.popper,n=e.attributes,Object.keys(n).forEach((function(e){!1!==n[e]?t.setAttribute(e,n[e]):t.removeAttribute(e)})),e.arrowElement&&Object.keys(e.arrowStyles).length&&K(e.arrowElement,e.arrowStyles),e},onLoad:function(e,t,n,r,o){var i=L(o,t,e,n.positionFixed),s=F(n.placement,i,t,e,n.modifiers.flip.boundariesElement,n.modifiers.flip.padding);return t.setAttribute("x-placement",s),K(t,{position:n.positionFixed?"fixed":"absolute"}),n},gpuAcceleration:void 0}}},de=function(){function e(t,n){var r=this,o=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};_(this,e),this.scheduleUpdate=function(){return requestAnimationFrame(r.update)},this.update=i(this.update.bind(this)),this.options=O({},e.Defaults,o),this.state={isDestroyed:!1,isCreated:!1,scrollParents:[]},this.reference=t&&t.jquery?t[0]:t,this.popper=n&&n.jquery?n[0]:n,this.options.modifiers={},Object.keys(O({},e.Defaults.modifiers,o.modifiers)).forEach((function(t){r.options.modifiers[t]=O({},e.Defaults.modifiers[t]||{},o.modifiers?o.modifiers[t]:{})})),this.modifiers=Object.keys(this.options.modifiers).map((function(e){return O({name:e},r.options.modifiers[e])})).sort((function(e,t){return e.order-t.order})),this.modifiers.forEach((function(e){e.enabled&&s(e.onLoad)&&e.onLoad(r.reference,r.popper,r.options,e,r.state)})),this.update();var a=this.options.eventsEnabled;a&&this.enableEventListeners(),this.state.eventsEnabled=a}return E(e,[{key:"update",value:function(){return B.call(this)}},{key:"destroy",value:function(){return I.call(this)}},{key:"enableEventListeners",value:function(){return Z.call(this)}},{key:"disableEventListeners",value:function(){return G.call(this)}}]),e}();de.Utils=("undefined"!=typeof window?window:n.g).PopperUtils,de.placements=ee,de.Defaults=ae;const le=de},2181:(e,t,n)=>{"use strict";n.r(t),n.d(t,{default:()=>f});const r={components:{"form-input":function(){return Promise.all([n.e(5816),n.e(1531)]).then(n.bind(n,9339))},loader:function(){return n.e(8540).then(n.bind(n,1337))}},props:{name:{required:!0,type:String},email:{required:!0,type:String},phone:{required:!1,type:String}},data:function(){return{form:[{label:"Your Name",field:"name",required:!0,type:"text"},{label:"Email Address",help:"If you change your email address, you will need to verify it.",field:"email",required:!0,type:"email"},{label:"Phone Number",help:"This is only used if there's a problem with any of your orders through our shop.",field:"phone",required:!1,type:"phone"}],submittingDetails:!1,fields:{name:"",email:"",phone:""},validity:{name:!1,email:!1,phone:!0}}},mounted:function(){this.configureMainFormEvents()},methods:{configureMainFormEvents:function(){var e=this;Object.keys(this.fields).forEach((function(t){e.fields[t]=e[t],coeliac().$emit("".concat(t,"-set-value"),e.fields[t]),e.$root.$on("".concat(t,"-error"),(function(){e.validity[t]=!1})),e.$root.$on("".concat(t,"-valid"),(function(){e.validity[t]=!0})),e.$root.$on("".concat(t,"-change"),(function(n){e.fields[t]=n}))}))},updateDetails:function(){var e=this;this.validateForm()&&(this.submittingDetails=!0,coeliac().request().post("/api/member/dashboard/details",this.fields).then((function(){coeliac().success("Your details have been updated.")})).catch((function(){coeliac().error("There was an error updating your details, please try again"),e.validateForm()})).finally((function(){e.submittingDetails=!1})))},validateForm:function(){var e=this;Object.keys(this.validity).forEach((function(t){e.$root.$emit("".concat(t,"-get-value"))}));var t=!0;return Object.keys(this.validity).forEach((function(n){!1===e.validity[n]&&(t=!1)})),t}}};var o=n(1900);const i=(0,o.Z)(r,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("form",{staticClass:"bg-blue-gradient-30 p-2 rounded-lg",on:{submit:function(t){return t.preventDefault(),e.updateDetails(t)}}},[n("div",[n("p",{staticClass:"text-sm"},[e._v("\n            Here you can change your name and email address, scroll down to manage your addresses and your\n            password.\n        ")]),e._v(" "),e._l(e.form,(function(t){return n("div",{staticClass:"py-4 border-b border-blue last:border-0"},[n("label",{staticClass:"text-blue-dark font-semibold mb-1",attrs:{for:t.field}},[e._v(e._s(t.label))]),e._v(" "),n("form-input",{attrs:{id:t.field,type:t.type,name:t.field,required:t.required,value:e.fields[t.field],autocomplete:t.field}}),e._v(" "),t.help?n("span",{staticClass:"text-sm font-semibold leading-tight"},[e._v(e._s(t.help))]):e._e()],1)}))],2),e._v(" "),n("div",{staticClass:"flex justify-end my-2"},[n("button",{staticClass:"bg-blue rounded leading-none px-6 text-xl cursor-pointer transition-bg hover:bg-blue-light hover:shadow",staticStyle:{"min-width":"130px",height:"50px"},attrs:{disabled:e.submittingDetails},on:{click:function(t){return t.preventDefault(),e.updateDetails(t)}}},[e.submittingDetails?n("loader",{attrs:{"background-position":"",show:!0,height:"25px",width:"25px","border-width":"3px","faded-border-color":"border-black-50","primary-border-color":"black"}}):n("span",[e._v("Update!")])],1)])])}),[],!1,null,null,null).exports;const s={components:{"form-input":function(){return Promise.all([n.e(5816),n.e(1531)]).then(n.bind(n,9339))},loader:function(){return n.e(8540).then(n.bind(n,1337))}},data:function(){return{submittingPassword:!1,fields:{current:"",new:"",new_confirmation:""},validity:{current:!0,new:!0,new_confirmation:!0}}},mounted:function(){this.configurePasswordFormEvents()},methods:{configurePasswordFormEvents:function(){var e=this;Object.keys(this.fields).forEach((function(t){e.$root.$on("".concat(t,"-error"),(function(){e.validity[t]=!1})),e.$root.$on("".concat(t,"-valid"),(function(){e.validity[t]=!0})),e.$root.$on("".concat(t,"-change"),(function(n){e.fields[t]=n}))}))},updatePassword:function(){var e=this;this.validatePassword()&&(this.submittingPassword=!0,coeliac().request().patch("/api/member/dashboard/details",this.fields).then((function(){coeliac().success("Your password has been updated.")})).catch((function(){coeliac().error("There was an error changing your password, please try again")})).finally((function(){e.resetPasswordForm(),e.submittingPassword=!1})))},resetPasswordForm:function(){var e=this;Object.keys(this.fields).forEach((function(t){e.$root.$emit("".concat(t,"-set-value"),""),e.fields[t]="",e.validity[t]=!0}))},validatePassword:function(){var e=this;if(!this.fields.current)return!1;Object.keys(this.validity).forEach((function(t){e.$root.$emit("".concat(t,"-get-value"))}));var t=!0;return Object.keys(this.validity).forEach((function(n){!1===e.validity[n]&&(t=!1)})),t}}};const a=(0,o.Z)(s,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("form",{staticClass:"bg-blue-gradient-30 p-2 rounded-lg mt-2",on:{submit:function(t){return t.preventDefault(),e.updatePassword(t)}}},[n("h2",{staticClass:"text-lg text-blue-dark font-semibold"},[e._v("Your Password")]),e._v(" "),n("p",{staticClass:"text-sm "},[e._v("\n        If you want to change your password please enter your current password below along with your new\n        Password.\n    ")]),e._v(" "),n("div",{staticClass:"py-4 border-b border-blue last:border-0"},[n("label",{staticClass:"text-blue-dark font-semibold mb-1",attrs:{for:"current_password"}},[e._v("\n            Current Password\n        ")]),e._v(" "),n("form-input",{attrs:{id:"current_password",type:"password",name:"current",min:8,autocomplete:"current_password"}})],1),e._v(" "),n("div",{staticClass:"py-4 border-b border-blue last:border-0"},[n("label",{staticClass:"text-blue-dark font-semibold mb-1",attrs:{for:"new_password"}},[e._v("\n            New Password\n        ")]),e._v(" "),n("form-input",{attrs:{id:"new_password",type:"password",name:"new",min:8,autocomplete:"new_password"}})],1),e._v(" "),n("div",{staticClass:"py-4"},[n("label",{staticClass:"text-blue-dark font-semibold mb-1",attrs:{for:"new_password_confirmation"}},[e._v("\n            Confirm New Password\n        ")]),e._v(" "),n("form-input",{attrs:{id:"new_password_confirmation",type:"password",name:"new_confirmation",min:8,autocomplete:"new_password_confirmation",match:e.fields.new}})],1),e._v(" "),n("div",{staticClass:"flex justify-end my-2"},[n("button",{staticClass:"leading-none px-6 text-xl transition-bg",class:e.fields.current?"bg-blue hover:bg-blue-light hover:shadow cursor-pointer":"bg-blue-light-50 cursor-not-allowed",staticStyle:{"min-width":"215px",height:"50px"},attrs:{disabled:!e.fields.current||e.submittingPassword},on:{click:function(t){return t.preventDefault(),e.updatePassword(t)}}},[e.submittingPassword?n("loader",{attrs:{"background-position":"",show:!0,height:"25px",width:"25px","border-width":"3px","faded-border-color":"border-black-50","primary-border-color":"black"}}):n("span",[e._v("Update Password")])],1)])])}),[],!1,null,null,null).exports;var d=n(538),l=n(1147);d.default.use(l.ZP);const c={components:{"form-input":function(){return Promise.all([n.e(5816),n.e(1531)]).then(n.bind(n,9339))},"form-select":function(){return Promise.all([n.e(5816),n.e(4014)]).then(n.bind(n,7449))},loader:function(){return n.e(8540).then(n.bind(n,1337))},modal:function(){return n.e(5441).then(n.bind(n,3516))}},data:function(){return{addresses:[],countries:[],showEditAddressModal:!1,showDeleteAddressModal:!1,editingAddress:{},deletingAddress:{},submittingDetails:!1,validity:{name:!1,line_1:!1,line_2:!0,line_3:!0,town:!1,postcode:!1,country:!1}}},mounted:function(){var e=this;this.loadAddresses(),this.loadCountries(),this.$root.$on("modal-closed",(function(t){"edit-address"===t&&e.closeEditModal(),"delete-address"===t&&e.closeDeleteModal()}))},methods:{formatAddress:function(e){return Array.from(["line_1","line_2","line_3","town","postcode","country"].map((function(t){return e[t]}))).filter((function(e){return null!==e&&""!==e})).join(", ")},loadAddresses:function(){var e=this;this.addresses=[],coeliac().request().get("/api/member/addresses").then((function(t){e.addresses=t.data})).catch((function(){e.addresses=[]}))},loadCountries:function(){var e=this;coeliac().request().get("/api/shop/countries").then((function(t){e.countries=t.data}))},deleteAddress:function(){var e=this;coeliac().request().delete("/api/member/addresses/".concat(this.deletingAddress.id)).then((function(){coeliac().success("Address Deleted")})).catch((function(){coeliac().error("There was an error deleting your address")})).then((function(){e.closeDeleteModal()}))},saveAddress:function(){var e=this;this.validateEditForm()&&(this.submittingDetails=!0,coeliac().request().post("/api/member/addresses/".concat(this.editingAddress.id),this.editingAddress).then((function(){coeliac().success("Address Saved"),e.closeEditModal()})).catch((function(){coeliac().error("There was an error saving your address")})).finally((function(){e.submittingDetails=!1})))},validateEditForm:function(){var e=this;Object.keys(this.validity).forEach((function(t){e.$root.$emit("editing_".concat(t,"-get-value"))}));var t=!0;return Object.keys(this.validity).forEach((function(n){!1===e.validity[n]&&(t=!1)})),t},openEditModal:function(e){var t=this;this.editingAddress=e,this.showEditAddressModal=!0,Object.keys(this.validity).forEach((function(e){coeliac().$emit("editing_".concat(e,"-set-value"),t.editingAddress[e]),t.$root.$on("editing_".concat(e,"-error"),(function(){t.validity[e]=!1})),t.$root.$on("editing_".concat(e,"-valid"),(function(){t.validity[e]=!0})),t.$root.$on("editing_".concat(e,"-change"),(function(n){t.editingAddress[e]=n}))})),this.validateEditForm()},closeEditModal:function(){this.loadAddresses(),this.showEditAddressModal=!1,this.editingAddress={},document.querySelector("body").classList.remove("overflow-hidden")},openDeleteModal:function(e){this.deletingAddress=e,this.showDeleteAddressModal=!0},closeDeleteModal:function(){this.loadAddresses(),this.showDeleteAddressModal=!1,this.deletingAddress={},document.querySelector("body").classList.remove("overflow-hidden")},addressEditableFields:function(){var e=this;return[{label:"Your Name",type:"form-input",prop:"name",required:!0},{label:"Address 1",type:"form-input",prop:"line_1",required:!0},{label:"Address 2",type:"form-input",prop:"line_2",required:!1},{label:"Address 3",type:"form-input",prop:"line_3",required:!1},{label:"Town",type:"form-input",prop:"town",required:!0},{label:"Postcode",type:"form-input",prop:"postcode",required:!0,pattern:function(){return"Shipping"===e.editingAddress.type&&"United Kingdom"===e.editingAddress.country?/^[A-Z]{1,2}\d[A-Z\d]? ?\d[A-Z]{2}$/i:/.*/}},{label:"Country",type:"Shipping"===this.editingAddress.type?"form-select":"form-input",prop:"country",required:!0,options:function(){return e.countries.map((function(e){return{value:e.label,label:e.label}}))}}]}}};const u={components:{"intro-form":i,"address-details":(0,o.Z)(c,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"bg-blue-gradient-30 p-2 mt-2 rounded-lg"},[n("h2",{staticClass:"text-lg text-blue-dark font-semibold"},[e._v("Your Addresses")]),e._v(" "),n("p",{staticClass:"text-sm"},[e._v("\n        Here you can manage your saved addresses from our online shop.\n    ")]),e._v(" "),n("div",{staticClass:"flex flex-col space-y-2"},e._l(e.addresses,(function(t){return n("div",{staticClass:"flex flex-col p-2 bg-white-50 rounded"},[n("strong",[e._v(e._s(t.name))]),e._v(" "),n("span",[e._v(e._s(e.formatAddress(t)))]),e._v(" "),n("div",{staticClass:"flex justify-between mt-2"},[n("div",{staticClass:"flex"},[n("strong",{staticClass:"mr-1"},[e._v("Address Type:")]),e._v(" "),n("span",[e._v(e._s(t.type))])]),e._v(" "),n("div",{staticClass:"flex space-x-2"},[n("font-awesome-icon",{directives:[{name:"tooltip",rawName:"v-tooltip.left",value:{content:"Edit",classes:["bg-blue","border-blue","text-white"]},expression:"{content: 'Edit', classes: ['bg-blue', 'border-blue', 'text-white']}",modifiers:{left:!0}}],staticClass:"cursor-pointer",attrs:{icon:["fas","pen"]},on:{click:function(n){return e.openEditModal(t)}}}),e._v(" "),n("font-awesome-icon",{directives:[{name:"tooltip",rawName:"v-tooltip.left",value:{content:"Delete",classes:["bg-blue","border-blue","text-white"]},expression:"{content: 'Delete', classes: ['bg-blue', 'border-blue', 'text-white']}",modifiers:{left:!0}}],staticClass:"cursor-pointer",attrs:{icon:["far","trash-alt"]},on:{click:function(n){return e.openDeleteModal(t)}}})],1)])])})),0),e._v(" "),e.showEditAddressModal?n("portal",{attrs:{to:"modal"}},[n("modal",{attrs:{name:"edit-address","modal-classes":"w-full",small:""}},[n("form",{staticClass:"flex flex-col",on:{submit:function(t){return t.preventDefault(),e.saveAddress()}}},[e._l(e.addressEditableFields(),(function(t){return n("div",{staticClass:"py-4 border-b border-blue last:border-0"},[n("label",{staticClass:"text-blue-dark font-semibold mb-1",attrs:{for:"editing_"+t.prop},domProps:{innerHTML:e._s(t.label)}}),e._v(" "),n(t.type,{tag:"component",attrs:{value:e.editingAddress[t.prop],id:"editing_"+t.prop,name:"editing_"+t.prop,required:t.required,pattern:t.pattern?t.pattern():null,options:t.options?t.options():null}})],1)})),e._v(" "),n("div",{staticClass:"flex space-x-4 justify-center mt-2"},[n("button",{staticClass:"rounded leading-none px-4 py-2 bg-blue hover:bg-blue-light hover:shadow cursor-pointer",on:{click:function(t){return t.preventDefault(),e.closeEditModal(t)}}},[e._v("\n                        Cancel\n                    ")]),e._v(" "),n("button",{staticClass:"rounded leading-none px-4 py-2 bg-yellow hover:bg-yellow-light hover:shadow cursor-pointer",staticStyle:{width:"170px",height:"50px"},on:{click:function(t){return t.preventDefault(),e.saveAddress()}}},[e.submittingDetails?n("loader",{attrs:{"background-position":"",show:!0,height:"25px",width:"25px","border-width":"3px","faded-border-color":"border-black-50","primary-border-color":"black"}}):n("span",[e._v("Save Address")])],1)])],2)])],1):e._e(),e._v(" "),e.showDeleteAddressModal?n("portal",{attrs:{to:"modal"}},[n("modal",{attrs:{name:"delete-address"}},[n("h3",[e._v("Are you sure you want to delete this address?")]),e._v(" "),n("div",{staticClass:"flex space-x-4 justify-center mt-2"},[n("a",{staticClass:"rounded leading-none px-4 py-2 bg-blue hover:bg-blue-light hover:shadow cursor-pointer",on:{click:e.closeDeleteModal}},[e._v("\n                    No\n                ")]),e._v(" "),n("a",{staticClass:"rounded leading-none px-4 py-2 bg-yellow hover:bg-yellow-light hover:shadow cursor-pointer",on:{click:function(t){return e.deleteAddress()}}},[e._v("\n                    Yes\n                ")])])])],1):e._e()],1)}),[],!1,null,null,null).exports,"password-form":a},props:{name:{required:!0,type:String},email:{required:!0,type:String},phone:{required:!1,type:String}}};const f=(0,o.Z)(u,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"flex flex-col"},[n("intro-form",{attrs:{name:e.name,email:e.email,phone:e.phone}}),e._v(" "),n("address-details"),e._v(" "),n("password-form")],1)}),[],!1,null,null,null).exports},1900:(e,t,n)=>{"use strict";function r(e,t,n,r,o,i,s,a){var d,l="function"==typeof e?e.options:e;if(t&&(l.render=t,l.staticRenderFns=n,l._compiled=!0),r&&(l.functional=!0),i&&(l._scopeId="data-v-"+i),s?(d=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),o&&o.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(s)},l._ssrRegister=d):o&&(d=a?function(){o.call(this,(l.functional?this.parent:this).$root.$options.shadowRoot)}:o),d)if(l.functional){l._injectStyles=d;var c=l.render;l.render=function(e,t){return d.call(t),c(e,t)}}else{var u=l.beforeCreate;l.beforeCreate=u?[].concat(u,d):[d]}return{exports:e,options:l}}n.d(t,{Z:()=>r})},7777:(e,t,n)=>{"use strict";n.d(t,{do:()=>i});var r=void 0;function o(){o.init||(o.init=!0,r=-1!==function(){var e=window.navigator.userAgent,t=e.indexOf("MSIE ");if(t>0)return parseInt(e.substring(t+5,e.indexOf(".",t)),10);if(e.indexOf("Trident/")>0){var n=e.indexOf("rv:");return parseInt(e.substring(n+3,e.indexOf(".",n)),10)}var r=e.indexOf("Edge/");return r>0?parseInt(e.substring(r+5,e.indexOf(".",r)),10):-1}())}var i={render:function(){var e=this.$createElement;return(this._self._c||e)("div",{staticClass:"resize-observer",attrs:{tabindex:"-1"}})},staticRenderFns:[],_scopeId:"data-v-b329ee4c",name:"resize-observer",methods:{compareAndNotify:function(){this._w===this.$el.offsetWidth&&this._h===this.$el.offsetHeight||(this._w=this.$el.offsetWidth,this._h=this.$el.offsetHeight,this.$emit("notify"))},addResizeHandlers:function(){this._resizeObject.contentDocument.defaultView.addEventListener("resize",this.compareAndNotify),this.compareAndNotify()},removeResizeHandlers:function(){this._resizeObject&&this._resizeObject.onload&&(!r&&this._resizeObject.contentDocument&&this._resizeObject.contentDocument.defaultView.removeEventListener("resize",this.compareAndNotify),delete this._resizeObject.onload)}},mounted:function(){var e=this;o(),this.$nextTick((function(){e._w=e.$el.offsetWidth,e._h=e.$el.offsetHeight}));var t=document.createElement("object");this._resizeObject=t,t.setAttribute("aria-hidden","true"),t.setAttribute("tabindex",-1),t.onload=this.addResizeHandlers,t.type="text/html",r&&this.$el.appendChild(t),t.data="about:blank",r||this.$el.appendChild(t)},beforeDestroy:function(){this.removeResizeHandlers()}};var s={version:"0.4.5",install:function(e){e.component("resize-observer",i),e.component("ResizeObserver",i)}},a=null;"undefined"!=typeof window?a=window.Vue:void 0!==n.g&&(a=n.g.Vue),a&&a.use(s)}}]);