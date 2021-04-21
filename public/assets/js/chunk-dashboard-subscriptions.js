(self.webpackChunk=self.webpackChunk||[]).push([[8640],{3923:(t,e,n)=>{"use strict";n.d(e,{Z:()=>r});var s=n(7484),i=n.n(s);const r={methods:{formatDate:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"D MMMM YYYY";return i()(t).format(e)}}}},7484:function(t){t.exports=function(){"use strict";var t="millisecond",e="second",n="minute",s="hour",i="day",r="week",o="month",a="quarter",u="year",c="date",l=/^(\d{4})[-/]?(\d{1,2})?[-/]?(\d{0,2})[^0-9]*(\d{1,2})?:?(\d{1,2})?:?(\d{1,2})?[.:]?(\d+)?$/,f=/\[([^\]]+)]|Y{1,4}|M{1,4}|D{1,2}|d{1,4}|H{1,2}|h{1,2}|a|A|m{1,2}|s{1,2}|Z{1,2}|SSS/g,d={name:"en",weekdays:"Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday".split("_"),months:"January_February_March_April_May_June_July_August_September_October_November_December".split("_")},h=function(t,e,n){var s=String(t);return!s||s.length>=e?t:""+Array(e+1-s.length).join(n)+t},m={s:h,z:function(t){var e=-t.utcOffset(),n=Math.abs(e),s=Math.floor(n/60),i=n%60;return(e<=0?"+":"-")+h(s,2,"0")+":"+h(i,2,"0")},m:function t(e,n){if(e.date()<n.date())return-t(n,e);var s=12*(n.year()-e.year())+(n.month()-e.month()),i=e.clone().add(s,o),r=n-i<0,a=e.clone().add(s+(r?-1:1),o);return+(-(s+(n-i)/(r?i-a:a-i))||0)},a:function(t){return t<0?Math.ceil(t)||0:Math.floor(t)},p:function(l){return{M:o,y:u,w:r,d:i,D:c,h:s,m:n,s:e,ms:t,Q:a}[l]||String(l||"").toLowerCase().replace(/s$/,"")},u:function(t){return void 0===t}},b="en",p={};p[b]=d;var $=function(t){return t instanceof g},v=function(t,e,n){var s;if(!t)return b;if("string"==typeof t)p[t]&&(s=t),e&&(p[t]=e,s=t);else{var i=t.name;p[i]=t,s=i}return!n&&s&&(b=s),s||!n&&b},y=function(t,e){if($(t))return t.clone();var n="object"==typeof e?e:{};return n.date=t,n.args=arguments,new g(n)},_=m;_.l=v,_.i=$,_.w=function(t,e){return y(t,{locale:e.$L,utc:e.$u,x:e.$x,$offset:e.$offset})};var g=function(){function d(t){this.$L=v(t.locale,null,!0),this.parse(t)}var h=d.prototype;return h.parse=function(t){this.$d=function(t){var e=t.date,n=t.utc;if(null===e)return new Date(NaN);if(_.u(e))return new Date;if(e instanceof Date)return new Date(e);if("string"==typeof e&&!/Z$/i.test(e)){var s=e.match(l);if(s){var i=s[2]-1||0,r=(s[7]||"0").substring(0,3);return n?new Date(Date.UTC(s[1],i,s[3]||1,s[4]||0,s[5]||0,s[6]||0,r)):new Date(s[1],i,s[3]||1,s[4]||0,s[5]||0,s[6]||0,r)}}return new Date(e)}(t),this.$x=t.x||{},this.init()},h.init=function(){var t=this.$d;this.$y=t.getFullYear(),this.$M=t.getMonth(),this.$D=t.getDate(),this.$W=t.getDay(),this.$H=t.getHours(),this.$m=t.getMinutes(),this.$s=t.getSeconds(),this.$ms=t.getMilliseconds()},h.$utils=function(){return _},h.isValid=function(){return!("Invalid Date"===this.$d.toString())},h.isSame=function(t,e){var n=y(t);return this.startOf(e)<=n&&n<=this.endOf(e)},h.isAfter=function(t,e){return y(t)<this.startOf(e)},h.isBefore=function(t,e){return this.endOf(e)<y(t)},h.$g=function(t,e,n){return _.u(t)?this[e]:this.set(n,t)},h.unix=function(){return Math.floor(this.valueOf()/1e3)},h.valueOf=function(){return this.$d.getTime()},h.startOf=function(t,a){var l=this,f=!!_.u(a)||a,d=_.p(t),h=function(t,e){var n=_.w(l.$u?Date.UTC(l.$y,e,t):new Date(l.$y,e,t),l);return f?n:n.endOf(i)},m=function(t,e){return _.w(l.toDate()[t].apply(l.toDate("s"),(f?[0,0,0,0]:[23,59,59,999]).slice(e)),l)},b=this.$W,p=this.$M,$=this.$D,v="set"+(this.$u?"UTC":"");switch(d){case u:return f?h(1,0):h(31,11);case o:return f?h(1,p):h(0,p+1);case r:var y=this.$locale().weekStart||0,g=(b<y?b+7:b)-y;return h(f?$-g:$+(6-g),p);case i:case c:return m(v+"Hours",0);case s:return m(v+"Minutes",1);case n:return m(v+"Seconds",2);case e:return m(v+"Milliseconds",3);default:return this.clone()}},h.endOf=function(t){return this.startOf(t,!1)},h.$set=function(r,a){var l,f=_.p(r),d="set"+(this.$u?"UTC":""),h=(l={},l[i]=d+"Date",l[c]=d+"Date",l[o]=d+"Month",l[u]=d+"FullYear",l[s]=d+"Hours",l[n]=d+"Minutes",l[e]=d+"Seconds",l[t]=d+"Milliseconds",l)[f],m=f===i?this.$D+(a-this.$W):a;if(f===o||f===u){var b=this.clone().set(c,1);b.$d[h](m),b.init(),this.$d=b.set(c,Math.min(this.$D,b.daysInMonth())).$d}else h&&this.$d[h](m);return this.init(),this},h.set=function(t,e){return this.clone().$set(t,e)},h.get=function(t){return this[_.p(t)]()},h.add=function(t,a){var c,l=this;t=Number(t);var f=_.p(a),d=function(e){var n=y(l);return _.w(n.date(n.date()+Math.round(e*t)),l)};if(f===o)return this.set(o,this.$M+t);if(f===u)return this.set(u,this.$y+t);if(f===i)return d(1);if(f===r)return d(7);var h=(c={},c[n]=6e4,c[s]=36e5,c[e]=1e3,c)[f]||1,m=this.$d.getTime()+t*h;return _.w(m,this)},h.subtract=function(t,e){return this.add(-1*t,e)},h.format=function(t){var e=this;if(!this.isValid())return"Invalid Date";var n=t||"YYYY-MM-DDTHH:mm:ssZ",s=_.z(this),i=this.$locale(),r=this.$H,o=this.$m,a=this.$M,u=i.weekdays,c=i.months,l=function(t,s,i,r){return t&&(t[s]||t(e,n))||i[s].substr(0,r)},d=function(t){return _.s(r%12||12,t,"0")},h=i.meridiem||function(t,e,n){var s=t<12?"AM":"PM";return n?s.toLowerCase():s},m={YY:String(this.$y).slice(-2),YYYY:this.$y,M:a+1,MM:_.s(a+1,2,"0"),MMM:l(i.monthsShort,a,c,3),MMMM:l(c,a),D:this.$D,DD:_.s(this.$D,2,"0"),d:String(this.$W),dd:l(i.weekdaysMin,this.$W,u,2),ddd:l(i.weekdaysShort,this.$W,u,3),dddd:u[this.$W],H:String(r),HH:_.s(r,2,"0"),h:d(1),hh:d(2),a:h(r,o,!0),A:h(r,o,!1),m:String(o),mm:_.s(o,2,"0"),s:String(this.$s),ss:_.s(this.$s,2,"0"),SSS:_.s(this.$ms,3,"0"),Z:s};return n.replace(f,(function(t,e){return e||m[t]||s.replace(":","")}))},h.utcOffset=function(){return 15*-Math.round(this.$d.getTimezoneOffset()/15)},h.diff=function(t,c,l){var f,d=_.p(c),h=y(t),m=6e4*(h.utcOffset()-this.utcOffset()),b=this-h,p=_.m(this,h);return p=(f={},f[u]=p/12,f[o]=p,f[a]=p/3,f[r]=(b-m)/6048e5,f[i]=(b-m)/864e5,f[s]=b/36e5,f[n]=b/6e4,f[e]=b/1e3,f)[d]||b,l?p:_.a(p)},h.daysInMonth=function(){return this.endOf(o).$D},h.$locale=function(){return p[this.$L]},h.locale=function(t,e){if(!t)return this.$L;var n=this.clone(),s=v(t,e,!0);return s&&(n.$L=s),n},h.clone=function(){return _.w(this.$d,this)},h.toDate=function(){return new Date(this.valueOf())},h.toJSON=function(){return this.isValid()?this.toISOString():null},h.toISOString=function(){return this.$d.toISOString()},h.toString=function(){return this.$d.toUTCString()},d}(),M=g.prototype;return y.prototype=M,[["$ms",t],["$s",e],["$m",n],["$H",s],["$W",i],["$M",o],["$y",u],["$D",c]].forEach((function(t){M[t[1]]=function(e){return this.$g(e,t[0],t[1])}})),y.extend=function(t,e){return t.$i||(t(e,g,y),t.$i=!0),y},y.locale=v,y.isDayjs=$,y.unix=function(t){return y(1e3*t)},y.en=p[b],y.Ls=p,y.p={},y}()},3831:(t,e,n)=>{"use strict";n.r(e),n.d(e,{default:()=>i});const s={mixins:[n(3923).Z],components:{loader:function(){return n.e(8540).then(n.bind(n,1337))},modal:function(){return n.e(5441).then(n.bind(n,3516))}},data:function(){return{isLoading:!0,subscriptions:[],confirmUnsubscribe:null}},mounted:function(){this.loadSubscriptions()},methods:{closeConfirmationModal:function(){this.confirmUnsubscribe=null,document.querySelector("body").classList.remove("overflow-hidden")},loadSubscriptions:function(){var t=this;coeliac().request().get("/api/member/dashboard/daily-updates").then((function(e){t.subscriptions=e.data})).catch((function(){})).finally((function(){t.isLoading=!1}))},unsubscribe:function(){var t=this;coeliac().request().delete("/api/member/dashboard/daily-updates/".concat(this.confirmUnsubscribe.id)).then((function(){coeliac().success("You're now unsubscribed from getting daily updates about ".concat(t.confirmUnsubscribe.type.name," ").concat(t.confirmUnsubscribe.subscribable.name)),t.loadSubscriptions()})).catch((function(){coeliac().error("There was an error unsubscribing you from ".concat(t.confirmUnsubscribe.subscribable.name))})).finally((function(){t.confirmUnsubscribe=null}))}}};const i=(0,n(1900).Z)(s,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[t.isLoading?n("div",{staticClass:"relative w-full h-32"},[n("loader",{attrs:{show:!0}})],1):n("div",{staticClass:"mt-2 flex flex-col space-y-2 sm:flex-wrap sm:flex-row justify-between sm:-mx-1"},t._l(t.subscriptions,(function(e){return n("div",{staticClass:"w-full bg-blue-gradient-30 rounded p-2 flex"},[n("div",{staticClass:"flex flex-col flex-1"},[n("h2",{staticClass:"text-lg font-semibold"},[t._v(t._s(e.type.name))]),t._v(" "),n("p",{staticClass:"mb-2"},[t._v(t._s(e.type.description))]),t._v(" "),n("p",{staticClass:"text-sm"},[n("strong",[t._v("Subscribed To: ")]),t._v(" "),n("a",{staticClass:"font-semibold text-blue-dark hover:underline",attrs:{href:e.updatable.link,target:"_blank"}},[t._v("\n                        "+t._s(e.updatable.name)+"\n                    ")])]),t._v(" "),n("p",{staticClass:"text-sm"},[n("strong",[t._v("Subscribed Since:")]),t._v("\n                    "+t._s(t.formatDate(e.created_at,"DD/MM/YY HH:mm"))+"\n                ")])]),t._v(" "),n("div",{staticClass:"ml-2 flex flex-col items-center cursor-pointer pt-2 text-grey opacity-50 hover:opacity-100 hover:text-blue-dark transition-colour",on:{click:function(n){t.confirmUnsubscribe=e}}},[n("font-awesome-icon",{staticClass:"text-5xl",attrs:{icon:["far","trash-alt"]}}),t._v(" "),n("span",{staticClass:"text-xs pt-1 font-semibold"},[t._v("Unsubscribe")])],1)])})),0),t._v(" "),t.confirmUnsubscribe?n("portal",{attrs:{to:"modal"}},[n("modal",{attrs:{small:"",name:"delete-scrapbook"}},[n("p",[t._v("Are you sure you want to delete your "+t._s(t.confirmUnsubscribe.type.name)+" daily update subscription to\n                '"+t._s(t.confirmUnsubscribe.subscribable.name)+"'?")]),t._v(" "),n("div",{staticClass:"flex space-x-4 justify-center mt-2"},[n("a",{staticClass:"rounded leading-none px-4 py-2 bg-blue hover:bg-blue-light hover:shadow cursor-pointer",on:{click:t.closeConfirmationModal}},[t._v("\n                    No\n                ")]),t._v(" "),n("a",{staticClass:"rounded leading-none px-4 py-2 bg-yellow hover:bg-yellow-light hover:shadow cursor-pointer",on:{click:function(e){return t.unsubscribe()}}},[t._v("\n                    Yes\n                ")])])])],1):t._e()],1)}),[],!1,null,null,null).exports},1900:(t,e,n)=>{"use strict";function s(t,e,n,s,i,r,o,a){var u,c="function"==typeof t?t.options:t;if(e&&(c.render=e,c.staticRenderFns=n,c._compiled=!0),s&&(c.functional=!0),r&&(c._scopeId="data-v-"+r),o?(u=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),i&&i.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(o)},c._ssrRegister=u):i&&(u=a?function(){i.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:i),u)if(c.functional){c._injectStyles=u;var l=c.render;c.render=function(t,e){return u.call(e),l(t,e)}}else{var f=c.beforeCreate;c.beforeCreate=f?[].concat(f,u):[u]}return{exports:t,options:c}}n.d(e,{Z:()=>s})}}]);