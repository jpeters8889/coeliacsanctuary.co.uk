(self.webpackChunk=self.webpackChunk||[]).push([[218],{3923:(t,e,r)=>{"use strict";r.d(e,{Z:()=>s});var n=r(7484),i=r.n(n);const s={methods:{formatDate:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"D MMMM YYYY";return i()(t).format(e)}}}},1560:(t,e,r)=>{"use strict";r.d(e,{Z:()=>n});const n={methods:{formatPrice:function(t){return t=(t/100).toFixed(2),"&pound;".concat(t)}}}},7484:function(t){t.exports=function(){"use strict";var t=1e3,e=6e4,r=36e5,n="millisecond",i="second",s="minute",a="hour",o="day",u="week",c="month",d="quarter",l="year",f="date",h="Invalid Date",m=/^(\d{4})[-/]?(\d{1,2})?[-/]?(\d{0,2})[Tt\s]*(\d{1,2})?:?(\d{1,2})?:?(\d{1,2})?[.:]?(\d+)?$/,$=/\[([^\]]+)]|Y{1,4}|M{1,4}|D{1,2}|d{1,4}|H{1,2}|h{1,2}|a|A|m{1,2}|s{1,2}|Z{1,2}|SSS/g,g={name:"en",weekdays:"Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday".split("_"),months:"January_February_March_April_May_June_July_August_September_October_November_December".split("_")},p=function(t,e,r){var n=String(t);return!n||n.length>=e?t:""+Array(e+1-n.length).join(r)+t},v={s:p,z:function(t){var e=-t.utcOffset(),r=Math.abs(e),n=Math.floor(r/60),i=r%60;return(e<=0?"+":"-")+p(n,2,"0")+":"+p(i,2,"0")},m:function t(e,r){if(e.date()<r.date())return-t(r,e);var n=12*(r.year()-e.year())+(r.month()-e.month()),i=e.clone().add(n,c),s=r-i<0,a=e.clone().add(n+(s?-1:1),c);return+(-(n+(r-i)/(s?i-a:a-i))||0)},a:function(t){return t<0?Math.ceil(t)||0:Math.floor(t)},p:function(t){return{M:c,y:l,w:u,d:o,D:f,h:a,m:s,s:i,ms:n,Q:d}[t]||String(t||"").toLowerCase().replace(/s$/,"")},u:function(t){return void 0===t}},b="en",M={};M[b]=g;var D=function(t){return t instanceof S},_=function(t,e,r){var n;if(!t)return b;if("string"==typeof t)M[t]&&(n=t),e&&(M[t]=e,n=t);else{var i=t.name;M[i]=t,n=i}return!r&&n&&(b=n),n||!r&&b},y=function(t,e){if(D(t))return t.clone();var r="object"==typeof e?e:{};return r.date=t,r.args=arguments,new S(r)},w=v;w.l=_,w.i=D,w.w=function(t,e){return y(t,{locale:e.$L,utc:e.$u,x:e.$x,$offset:e.$offset})};var S=function(){function g(t){this.$L=_(t.locale,null,!0),this.parse(t)}var p=g.prototype;return p.parse=function(t){this.$d=function(t){var e=t.date,r=t.utc;if(null===e)return new Date(NaN);if(w.u(e))return new Date;if(e instanceof Date)return new Date(e);if("string"==typeof e&&!/Z$/i.test(e)){var n=e.match(m);if(n){var i=n[2]-1||0,s=(n[7]||"0").substring(0,3);return r?new Date(Date.UTC(n[1],i,n[3]||1,n[4]||0,n[5]||0,n[6]||0,s)):new Date(n[1],i,n[3]||1,n[4]||0,n[5]||0,n[6]||0,s)}}return new Date(e)}(t),this.$x=t.x||{},this.init()},p.init=function(){var t=this.$d;this.$y=t.getFullYear(),this.$M=t.getMonth(),this.$D=t.getDate(),this.$W=t.getDay(),this.$H=t.getHours(),this.$m=t.getMinutes(),this.$s=t.getSeconds(),this.$ms=t.getMilliseconds()},p.$utils=function(){return w},p.isValid=function(){return!(this.$d.toString()===h)},p.isSame=function(t,e){var r=y(t);return this.startOf(e)<=r&&r<=this.endOf(e)},p.isAfter=function(t,e){return y(t)<this.startOf(e)},p.isBefore=function(t,e){return this.endOf(e)<y(t)},p.$g=function(t,e,r){return w.u(t)?this[e]:this.set(r,t)},p.unix=function(){return Math.floor(this.valueOf()/1e3)},p.valueOf=function(){return this.$d.getTime()},p.startOf=function(t,e){var r=this,n=!!w.u(e)||e,d=w.p(t),h=function(t,e){var i=w.w(r.$u?Date.UTC(r.$y,e,t):new Date(r.$y,e,t),r);return n?i:i.endOf(o)},m=function(t,e){return w.w(r.toDate()[t].apply(r.toDate("s"),(n?[0,0,0,0]:[23,59,59,999]).slice(e)),r)},$=this.$W,g=this.$M,p=this.$D,v="set"+(this.$u?"UTC":"");switch(d){case l:return n?h(1,0):h(31,11);case c:return n?h(1,g):h(0,g+1);case u:var b=this.$locale().weekStart||0,M=($<b?$+7:$)-b;return h(n?p-M:p+(6-M),g);case o:case f:return m(v+"Hours",0);case a:return m(v+"Minutes",1);case s:return m(v+"Seconds",2);case i:return m(v+"Milliseconds",3);default:return this.clone()}},p.endOf=function(t){return this.startOf(t,!1)},p.$set=function(t,e){var r,u=w.p(t),d="set"+(this.$u?"UTC":""),h=(r={},r[o]=d+"Date",r[f]=d+"Date",r[c]=d+"Month",r[l]=d+"FullYear",r[a]=d+"Hours",r[s]=d+"Minutes",r[i]=d+"Seconds",r[n]=d+"Milliseconds",r)[u],m=u===o?this.$D+(e-this.$W):e;if(u===c||u===l){var $=this.clone().set(f,1);$.$d[h](m),$.init(),this.$d=$.set(f,Math.min(this.$D,$.daysInMonth())).$d}else h&&this.$d[h](m);return this.init(),this},p.set=function(t,e){return this.clone().$set(t,e)},p.get=function(t){return this[w.p(t)]()},p.add=function(n,d){var f,h=this;n=Number(n);var m=w.p(d),$=function(t){var e=y(h);return w.w(e.date(e.date()+Math.round(t*n)),h)};if(m===c)return this.set(c,this.$M+n);if(m===l)return this.set(l,this.$y+n);if(m===o)return $(1);if(m===u)return $(7);var g=(f={},f[s]=e,f[a]=r,f[i]=t,f)[m]||1,p=this.$d.getTime()+n*g;return w.w(p,this)},p.subtract=function(t,e){return this.add(-1*t,e)},p.format=function(t){var e=this,r=this.$locale();if(!this.isValid())return r.invalidDate||h;var n=t||"YYYY-MM-DDTHH:mm:ssZ",i=w.z(this),s=this.$H,a=this.$m,o=this.$M,u=r.weekdays,c=r.months,d=function(t,r,i,s){return t&&(t[r]||t(e,n))||i[r].substr(0,s)},l=function(t){return w.s(s%12||12,t,"0")},f=r.meridiem||function(t,e,r){var n=t<12?"AM":"PM";return r?n.toLowerCase():n},m={YY:String(this.$y).slice(-2),YYYY:this.$y,M:o+1,MM:w.s(o+1,2,"0"),MMM:d(r.monthsShort,o,c,3),MMMM:d(c,o),D:this.$D,DD:w.s(this.$D,2,"0"),d:String(this.$W),dd:d(r.weekdaysMin,this.$W,u,2),ddd:d(r.weekdaysShort,this.$W,u,3),dddd:u[this.$W],H:String(s),HH:w.s(s,2,"0"),h:l(1),hh:l(2),a:f(s,a,!0),A:f(s,a,!1),m:String(a),mm:w.s(a,2,"0"),s:String(this.$s),ss:w.s(this.$s,2,"0"),SSS:w.s(this.$ms,3,"0"),Z:i};return n.replace($,(function(t,e){return e||m[t]||i.replace(":","")}))},p.utcOffset=function(){return 15*-Math.round(this.$d.getTimezoneOffset()/15)},p.diff=function(n,f,h){var m,$=w.p(f),g=y(n),p=(g.utcOffset()-this.utcOffset())*e,v=this-g,b=w.m(this,g);return b=(m={},m[l]=b/12,m[c]=b,m[d]=b/3,m[u]=(v-p)/6048e5,m[o]=(v-p)/864e5,m[a]=v/r,m[s]=v/e,m[i]=v/t,m)[$]||v,h?b:w.a(b)},p.daysInMonth=function(){return this.endOf(c).$D},p.$locale=function(){return M[this.$L]},p.locale=function(t,e){if(!t)return this.$L;var r=this.clone(),n=_(t,e,!0);return n&&(r.$L=n),r},p.clone=function(){return w.w(this.$d,this)},p.toDate=function(){return new Date(this.valueOf())},p.toJSON=function(){return this.isValid()?this.toISOString():null},p.toISOString=function(){return this.$d.toISOString()},p.toString=function(){return this.$d.toUTCString()},g}(),O=S.prototype;return y.prototype=O,[["$ms",n],["$s",i],["$m",s],["$H",a],["$W",o],["$M",c],["$y",l],["$D",f]].forEach((function(t){O[t[1]]=function(e){return this.$g(e,t[0],t[1])}})),y.extend=function(t,e){return t.$i||(t(e,S,y),t.$i=!0),y},y.locale=_,y.isDayjs=D,y.unix=function(t){return y(1e3*t)},y.en=M[b],y.Ls=M,y.p={},y}()},8419:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>a});var n=r(3923),i=r(1560);const s={components:{pagination:function(){return r.e(7929).then(r.bind(r,4032))},modal:function(){return r.e(5441).then(r.bind(r,1024))},"members-dashboard-modals-order-details":function(){return r.e(6337).then(r.bind(r,1597))}},mixins:[n.Z,i.Z],data:function(){return{error:!1,results:[],currentPage:1,lastPage:1,loading:!0,showOrderDetails:!1}},mounted:function(){var t=this;this.getData(),this.$root.$on("pagination-click",(function(e){"next"===e&&(e=t.currentPage+1),"prev"===e&&(e=t.currentPage-1),t.currentPage=e,t.getData(),t.$scrollTo(t.$refs.items,500,{offset:-200})})),this.$root.$on("modal-closed",(function(){t.showOrderDetails=!1}))},methods:{getData:function(){var t=this;coeliac().request().get("/api/member/dashboard/orders?page=".concat(this.currentPage)).then((function(e){t.results=e.data.data,t.lastPage=e.data.last_page})).catch((function(){t.error=!0})).finally((function(){t.loading=!1}))},orderParameters:function(){var t=this;return[{label:"Order Date",prop:"order_date",format:function(e){return t.formatDate(e,"D MMMM YYYY HH:mm")}},{label:"Reference",prop:"reference"},{label:"Number of Items",prop:"number_of_items"},{label:"Order Status",prop:"state"},{label:"Shipped On",prop:"shipped_at",condition:function(t){return t.shipped_at},format:function(e){return t.formatDate(e,"D MMMM YYYY HH:mm")}},{label:"Total Cost",prop:"total_cost",format:function(e){return t.formatPrice(e)}}]}}};const a=(0,r(1900).Z)(s,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",[r("pagination",{attrs:{current:t.currentPage,"last-page":t.lastPage,"can-go-back":t.currentPage>1,"can-go-forward":t.currentPage<t.lastPage}}),t._v(" "),r("div",{ref:"items",staticClass:"main-body"},[t._l(t.results,(function(e){return r("div",{key:e.reference,staticClass:"my-4 border-2 border-blue rounded-lg flex flex-col leading-none lg:hidden"},[!t.params.condition||t.params.condition(e)?t._l(t.orderParameters(),(function(n,i){return r("div",{key:i,staticClass:"flex"},[r("div",{staticClass:"w-1/2 bg-blue text-white font-semibold p-2 border-white",class:i===t.orderParameters().length-1?"border-0":"border-b"},[t._v("\n            "+t._s(n.label)+"\n          ")]),t._v(" "),r("div",{staticClass:"w-1/2 p-2 border-blue",class:i===t.orderParameters().length-1?"border-0":"border-b",domProps:{innerHTML:t._s(n.format?n.format(e[n.prop]):e[n.prop])}})])})):t._e(),t._v(" "),r("div",{staticClass:"bg-blue text-white font-semibold p-2 hover:bg-blue-light cursor-pointer text-lg text-center border-t border-white transition-all",on:{click:function(r){t.showOrderDetails=e.reference}}},[t._v("\n        More Info\n      ")])],2)})),t._v(" "),r("table",{staticClass:"hidden lg:table order-dashboard mt-4"},[r("thead",[r("tr",[t._l(t.orderParameters(),(function(e,n){return r("th",{key:n},[t._v("\n            "+t._s(e.label)+"\n          ")])})),t._v(" "),r("th")],2)]),t._v(" "),r("tbody",t._l(t.results,(function(e){return r("tr",{key:e.reference},[t._l(t.orderParameters(),(function(n,i){return r("td",{key:i,domProps:{innerHTML:t._s(!n.condition||n.condition(e)?n.format?n.format(e[n.prop]):e[n.prop]:"")}})})),t._v(" "),r("td",[r("div",{staticClass:"bg-blue rounded px-3 py-1 text-white font-semibold cursor-pointer",on:{click:function(r){t.showOrderDetails=e.reference}}},[t._v("\n              More Info\n            ")])])],2)})),0)])],2),t._v(" "),r("pagination",{attrs:{current:t.currentPage,"last-page":t.lastPage,"can-go-back":t.currentPage>1,"can-go-forward":t.currentPage<t.lastPage}}),t._v(" "),t.showOrderDetails?r("portal",{attrs:{to:"modal"}},[r("modal",{attrs:{"modal-classes":"w-full",small:"",title:"Order #"+t.showOrderDetails}},[r("members-dashboard-modals-order-details",{attrs:{id:t.showOrderDetails}})],1)],1):t._e()],1)}),[],!1,null,null,null).exports}}]);