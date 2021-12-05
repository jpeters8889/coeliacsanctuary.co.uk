(self.webpackChunk=self.webpackChunk||[]).push([[2163],{3923:(t,e,n)=>{"use strict";n.d(e,{Z:()=>o});var i=n(7484),r=n.n(i);const o={methods:{formatDate:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"D MMMM YYYY";return r()(t).format(e)}}}},7484:function(t){t.exports=function(){"use strict";var t=1e3,e=6e4,n=36e5,i="millisecond",r="second",o="minute",s="hour",a="day",c="week",l="month",u="quarter",d="year",f="date",h="Invalid Date",m=/^(\d{4})[-/]?(\d{1,2})?[-/]?(\d{0,2})[Tt\s]*(\d{1,2})?:?(\d{1,2})?:?(\d{1,2})?[.:]?(\d+)?$/,p=/\[([^\]]+)]|Y{1,4}|M{1,4}|D{1,2}|d{1,4}|H{1,2}|h{1,2}|a|A|m{1,2}|s{1,2}|Z{1,2}|SSS/g,g={name:"en",weekdays:"Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday".split("_"),months:"January_February_March_April_May_June_July_August_September_October_November_December".split("_")},v=function(t,e,n){var i=String(t);return!i||i.length>=e?t:""+Array(e+1-i.length).join(n)+t},b={s:v,z:function(t){var e=-t.utcOffset(),n=Math.abs(e),i=Math.floor(n/60),r=n%60;return(e<=0?"+":"-")+v(i,2,"0")+":"+v(r,2,"0")},m:function t(e,n){if(e.date()<n.date())return-t(n,e);var i=12*(n.year()-e.year())+(n.month()-e.month()),r=e.clone().add(i,l),o=n-r<0,s=e.clone().add(i+(o?-1:1),l);return+(-(i+(n-r)/(o?r-s:s-r))||0)},a:function(t){return t<0?Math.ceil(t)||0:Math.floor(t)},p:function(t){return{M:l,y:d,w:c,d:a,D:f,h:s,m:o,s:r,ms:i,Q:u}[t]||String(t||"").toLowerCase().replace(/s$/,"")},u:function(t){return void 0===t}},k="en",y={};y[k]=g;var $=function(t){return t instanceof _},w=function(t,e,n){var i;if(!t)return k;if("string"==typeof t)y[t]&&(i=t),e&&(y[t]=e,i=t);else{var r=t.name;y[r]=t,i=r}return!n&&i&&(k=i),i||!n&&k},S=function(t,e){if($(t))return t.clone();var n="object"==typeof e?e:{};return n.date=t,n.args=arguments,new _(n)},x=b;x.l=w,x.i=$,x.w=function(t,e){return S(t,{locale:e.$L,utc:e.$u,x:e.$x,$offset:e.$offset})};var _=function(){function g(t){this.$L=w(t.locale,null,!0),this.parse(t)}var v=g.prototype;return v.parse=function(t){this.$d=function(t){var e=t.date,n=t.utc;if(null===e)return new Date(NaN);if(x.u(e))return new Date;if(e instanceof Date)return new Date(e);if("string"==typeof e&&!/Z$/i.test(e)){var i=e.match(m);if(i){var r=i[2]-1||0,o=(i[7]||"0").substring(0,3);return n?new Date(Date.UTC(i[1],r,i[3]||1,i[4]||0,i[5]||0,i[6]||0,o)):new Date(i[1],r,i[3]||1,i[4]||0,i[5]||0,i[6]||0,o)}}return new Date(e)}(t),this.$x=t.x||{},this.init()},v.init=function(){var t=this.$d;this.$y=t.getFullYear(),this.$M=t.getMonth(),this.$D=t.getDate(),this.$W=t.getDay(),this.$H=t.getHours(),this.$m=t.getMinutes(),this.$s=t.getSeconds(),this.$ms=t.getMilliseconds()},v.$utils=function(){return x},v.isValid=function(){return!(this.$d.toString()===h)},v.isSame=function(t,e){var n=S(t);return this.startOf(e)<=n&&n<=this.endOf(e)},v.isAfter=function(t,e){return S(t)<this.startOf(e)},v.isBefore=function(t,e){return this.endOf(e)<S(t)},v.$g=function(t,e,n){return x.u(t)?this[e]:this.set(n,t)},v.unix=function(){return Math.floor(this.valueOf()/1e3)},v.valueOf=function(){return this.$d.getTime()},v.startOf=function(t,e){var n=this,i=!!x.u(e)||e,u=x.p(t),h=function(t,e){var r=x.w(n.$u?Date.UTC(n.$y,e,t):new Date(n.$y,e,t),n);return i?r:r.endOf(a)},m=function(t,e){return x.w(n.toDate()[t].apply(n.toDate("s"),(i?[0,0,0,0]:[23,59,59,999]).slice(e)),n)},p=this.$W,g=this.$M,v=this.$D,b="set"+(this.$u?"UTC":"");switch(u){case d:return i?h(1,0):h(31,11);case l:return i?h(1,g):h(0,g+1);case c:var k=this.$locale().weekStart||0,y=(p<k?p+7:p)-k;return h(i?v-y:v+(6-y),g);case a:case f:return m(b+"Hours",0);case s:return m(b+"Minutes",1);case o:return m(b+"Seconds",2);case r:return m(b+"Milliseconds",3);default:return this.clone()}},v.endOf=function(t){return this.startOf(t,!1)},v.$set=function(t,e){var n,c=x.p(t),u="set"+(this.$u?"UTC":""),h=(n={},n[a]=u+"Date",n[f]=u+"Date",n[l]=u+"Month",n[d]=u+"FullYear",n[s]=u+"Hours",n[o]=u+"Minutes",n[r]=u+"Seconds",n[i]=u+"Milliseconds",n)[c],m=c===a?this.$D+(e-this.$W):e;if(c===l||c===d){var p=this.clone().set(f,1);p.$d[h](m),p.init(),this.$d=p.set(f,Math.min(this.$D,p.daysInMonth())).$d}else h&&this.$d[h](m);return this.init(),this},v.set=function(t,e){return this.clone().$set(t,e)},v.get=function(t){return this[x.p(t)]()},v.add=function(i,u){var f,h=this;i=Number(i);var m=x.p(u),p=function(t){var e=S(h);return x.w(e.date(e.date()+Math.round(t*i)),h)};if(m===l)return this.set(l,this.$M+i);if(m===d)return this.set(d,this.$y+i);if(m===a)return p(1);if(m===c)return p(7);var g=(f={},f[o]=e,f[s]=n,f[r]=t,f)[m]||1,v=this.$d.getTime()+i*g;return x.w(v,this)},v.subtract=function(t,e){return this.add(-1*t,e)},v.format=function(t){var e=this,n=this.$locale();if(!this.isValid())return n.invalidDate||h;var i=t||"YYYY-MM-DDTHH:mm:ssZ",r=x.z(this),o=this.$H,s=this.$m,a=this.$M,c=n.weekdays,l=n.months,u=function(t,n,r,o){return t&&(t[n]||t(e,i))||r[n].substr(0,o)},d=function(t){return x.s(o%12||12,t,"0")},f=n.meridiem||function(t,e,n){var i=t<12?"AM":"PM";return n?i.toLowerCase():i},m={YY:String(this.$y).slice(-2),YYYY:this.$y,M:a+1,MM:x.s(a+1,2,"0"),MMM:u(n.monthsShort,a,l,3),MMMM:u(l,a),D:this.$D,DD:x.s(this.$D,2,"0"),d:String(this.$W),dd:u(n.weekdaysMin,this.$W,c,2),ddd:u(n.weekdaysShort,this.$W,c,3),dddd:c[this.$W],H:String(o),HH:x.s(o,2,"0"),h:d(1),hh:d(2),a:f(o,s,!0),A:f(o,s,!1),m:String(s),mm:x.s(s,2,"0"),s:String(this.$s),ss:x.s(this.$s,2,"0"),SSS:x.s(this.$ms,3,"0"),Z:r};return i.replace(p,(function(t,e){return e||m[t]||r.replace(":","")}))},v.utcOffset=function(){return 15*-Math.round(this.$d.getTimezoneOffset()/15)},v.diff=function(i,f,h){var m,p=x.p(f),g=S(i),v=(g.utcOffset()-this.utcOffset())*e,b=this-g,k=x.m(this,g);return k=(m={},m[d]=k/12,m[l]=k,m[u]=k/3,m[c]=(b-v)/6048e5,m[a]=(b-v)/864e5,m[s]=b/n,m[o]=b/e,m[r]=b/t,m)[p]||b,h?k:x.a(k)},v.daysInMonth=function(){return this.endOf(l).$D},v.$locale=function(){return y[this.$L]},v.locale=function(t,e){if(!t)return this.$L;var n=this.clone(),i=w(t,e,!0);return i&&(n.$L=i),n},v.clone=function(){return x.w(this.$d,this)},v.toDate=function(){return new Date(this.valueOf())},v.toJSON=function(){return this.isValid()?this.toISOString():null},v.toISOString=function(){return this.$d.toISOString()},v.toString=function(){return this.$d.toUTCString()},g}(),D=_.prototype;return S.prototype=D,[["$ms",i],["$s",r],["$m",o],["$H",s],["$W",a],["$M",l],["$y",d],["$D",f]].forEach((function(t){D[t[1]]=function(e){return this.$g(e,t[0],t[1])}})),S.extend=function(t,e){return t.$i||(t(e,_,S),t.$i=!0),S},S.locale=w,S.isDayjs=$,S.unix=function(t){return S(1e3*t)},S.en=y[k],S.Ls=y,S.p={},S}()},4792:(t,e,n)=>{"use strict";n.r(e),n.d(e,{default:()=>r});const i={components:{loader:function(){return n.e(8540).then(n.bind(n,6676))},"form-input":function(){return Promise.all([n.e(5816),n.e(1531)]).then(n.bind(n,6189))},modal:function(){return n.e(5441).then(n.bind(n,1024))}},mixins:[n(3923).Z],data:function(){return{isLoading:!0,scrapbooks:[],scrapbookItems:[],viewScrapbook:null,isHoveringOn:null,isEditing:null,isAdding:!1,editingName:"",addingName:"",confirmDelete:null}},watch:{viewScrapbook:function(){this.viewScrapbook?this.getScrapbookItems():this.scrapbookItems=[]}},mounted:function(){var t=this;this.loadScrapbooks(),this.$root.$on("modal-closed",(function(e){"delete-scrapbook"===e&&(t.confirmDelete=null),"view-scrapbook"===e&&(t.viewScrapbook=null,t.loadScrapbooks())}))},methods:{loadScrapbooks:function(){var t=this;coeliac().request().get("/api/member/dashboard/scrapbooks").then((function(e){t.scrapbooks=e.data})).catch((function(){})).finally((function(){t.isLoading=!1}))},triggerAddScrapbook:function(){var t=this;this.isAdding=!0,this.$root.$on("add-name-change",(function(e){t.addingName=e}))},addScrapbook:function(){var t=this;""!==this.addingName?coeliac().request().post("/api/member/dashboard/scrapbooks",{name:this.addingName}).then((function(){t.loadScrapbooks(),coeliac().success("Scrapbook Updated")})).catch((function(){coeliac().error("There was an error adding your scrapbook")})).finally((function(){t.isAdding=!1,t.addingName=""})):coeliac().error("Please enter a name for your new scrapbook")},editTitle:function(t){var e=this;this.editingName=t.name,this.isEditing=t.id,coeliac().$emit("editing-name-set-value",this.editingName),this.$root.$on("editing-name-change",(function(t){e.editingName=t}))},updateTitle:function(){var t=this;if(this.isEditing){if(""===this.editingName)return this.isEditing=null,void(this.editingName=null);this.isLoading=!0,coeliac().request().patch("/api/member/dashboard/scrapbooks/".concat(this.isEditing),{name:this.editingName}).then((function(){t.loadScrapbooks(),coeliac().success("Scrapbook Updated")})).catch((function(){coeliac().error("There was an error updating your scrapbook")})).finally((function(){t.isEditing=null,t.editingName=null}))}},deleteScrapbook:function(){var t=this;coeliac().request().delete("/api/member/dashboard/scrapbooks/".concat(this.confirmDelete)).then((function(){t.loadScrapbooks(),coeliac().success("Scrapbook Deleted")})).catch((function(){coeliac().error("There was an error removing your scrapbook")})).finally((function(){t.confirmDelete=null}))},getScrapbookItems:function(){var t=this;coeliac().request().get("/api/member/dashboard/scrapbooks/".concat(this.viewScrapbook.id)).then((function(e){0===e.data.length&&(coeliac().error("There was an error opening this scrapbook"),t.viewScrapbook=null),t.scrapbookItems=e.data})).catch((function(){coeliac().error("There was an error opening this scrapbook"),t.viewScrapbook=null}))},removeItem:function(t){var e=this;coeliac().request().delete("/api/member/dashboard/scrapbooks/".concat(this.viewScrapbook.id,"/").concat(t)).then((function(){e.loadScrapbooks(),e.getScrapbookItems(),e.viewScrapbook=null})).catch((function(){coeliac().error("There was an error removing this item from your scrapbook")}))}}};const r=(0,n(1900).Z)(i,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[t.isLoading?n("div",{staticClass:"relative w-full h-32"},[n("loader",{attrs:{show:!0}})],1):n("div",{staticClass:"mt-2 flex flex-col space-y-2 sm:flex-wrap sm:flex-row justify-between sm:-mx-1"},[n("div",{staticClass:"bg-gradient-to-br from-blue/30 to-blue-light/30 rounded p-2 flex flex-col w-full sm:mx-1"},[n("strong",{staticClass:"block font-semibold text-lg flex items-center cursor-pointer hover:underline",on:{click:function(e){return t.triggerAddScrapbook()}}},[t._v("\n        Create new Scrapbook\n      ")]),t._v(" "),t.isAdding?n("div",{staticClass:"flex"},[n("form-input",{staticClass:"flex-1",attrs:{small:"",name:"add-name",value:t.addingName,placeholder:"Scrapbook Name","on-enter":t.addScrapbook}}),t._v(" "),n("a",{staticClass:"ml-2 flex items-center leading-none bg-yellow text-sm rounded py-1 px-3 cursor-pointer hover:bg-yellow-light transition-all",on:{click:function(e){return t.addScrapbook()}}},[t._v("\n          Add\n        ")])],1):t._e()]),t._v(" "),t._l(t.scrapbooks,(function(e){return n("div",{key:e.id,staticClass:"sm:w-1/2 sm:px-1",on:{mouseenter:function(n){t.isHoveringOn=e.id},mouseleave:function(e){t.isHoveringOn=null}}},[n("div",{staticClass:"bg-gradient-to-br from-blue/30 to-blue-light/30 rounded p-2 flex cursor-pointer",on:{click:function(n){if(n.stopPropagation(),n.ctrlKey||n.shiftKey||n.altKey||n.metaKey)return null;t.viewScrapbook=e}}},[n("div",{staticClass:"flex-1 flex flex-col"},[n("strong",{staticClass:"font-semibold text-lg flex items-center"},[e.id===t.isEditing?n("div",{staticClass:"flex"},[n("form-input",{attrs:{small:"",name:"editing-name",value:t.editingName,"on-enter":t.updateTitle}}),t._v(" "),n("a",{staticClass:"ml-2 flex items-center leading-none bg-yellow text-sm rounded py-1 px-3 cursor-pointer hover:bg-yellow-light transition-all",on:{click:function(e){return e.stopPropagation(),e.ctrlKey||e.shiftKey||e.altKey||e.metaKey?null:t.updateTitle()}}},[t._v("\n                Update\n              ")])],1):[t._v("\n              "+t._s(e.name)+"\n              "),n("span",{directives:[{name:"show",rawName:"v-show",value:t.isHoveringOn===e.id,expression:"isHoveringOn === scrapbook.id"}],staticClass:"text-grey-off hover:text-grey-dark cursor-pointer text-base pl-2"},[n("font-awesome-icon",{attrs:{icon:["fas","pen"]},on:{click:function(n){return n.stopPropagation(),n.ctrlKey||n.shiftKey||n.altKey||n.metaKey?null:t.editTitle(e)}}})],1)]],2),t._v(" "),n("span",[t._v(t._s(e.items_count)+" items.")])]),t._v(" "),t.scrapbooks.length>1?n("div",{directives:[{name:"show",rawName:"v-show",value:t.isHoveringOn===e.id,expression:"isHoveringOn === scrapbook.id"}],staticClass:"text-2xl text-right text-grey-off hover:text-grey-dark cursor-pointer transition-all"},[n("font-awesome-icon",{attrs:{icon:["far","trash-alt"]},on:{click:function(n){if(n.stopPropagation(),n.ctrlKey||n.shiftKey||n.altKey||n.metaKey)return null;t.confirmDelete=e.id}}})],1):t._e()])])}))],2),t._v(" "),t.viewScrapbook?n("portal",{attrs:{to:"modal"}},[n("modal",{attrs:{"modal-classes":"w-full",name:"view-scrapbook",title:t.viewScrapbook.name}},[n("div",{staticClass:"w-full min-h-map p-3"},[0===t.scrapbookItems.length?n("loader",{attrs:{show:!0}}):n("div",{staticClass:"flex flex-col space-y-4"},t._l(t.scrapbookItems,(function(e){return n("div",{key:e.id,staticClass:"flex flex-col bg-gradient-to-br from-blue/50 to-blue-light/50 rounded-lg md:flex-row"},[n("a",{staticClass:"md:w-1/3 md:p-1",attrs:{href:e.item.link,target:"_blank"}},[n("img",{staticClass:"rounded-t-lg md:rounded-lg",attrs:{src:e.item.image,alt:e.item.title}})]),t._v(" "),n("div",{staticClass:"p-2 flex-1 md:p-1 flex flex-col"},[n("a",{attrs:{href:e.item.link,target:"_blank"}},[n("h2",{staticClass:"text-lg font-semibold hover:text-blue-dark transition-all md:leading-none"},[t._v("\n                  "+t._s(e.item.area)+" - "+t._s(e.item.title)+"\n                ")])]),t._v(" "),n("p",{staticClass:"flex-1",domProps:{innerHTML:t._s(e.item.description)}}),t._v(" "),n("div",{staticClass:"mt-2 flex justify-between text-sm"},[n("p",[t._v("\n                  Added "+t._s(t.formatDate(e.added))+"\n                ")]),t._v(" "),n("a",{staticClass:"font-semibold hover:text-blue-dark transition-all cursor-pointer",on:{click:function(n){return t.removeItem(e.id)}}},[t._v("\n                  Remove\n                ")])])])])})),0)],1)])],1):t._e(),t._v(" "),t.confirmDelete?n("portal",{attrs:{to:"modal"}},[n("modal",{attrs:{small:"",name:"delete-scrapbook",title:"Are you sure you want to delete this scrapbook? Any items saved will be lost."}},[n("div",{staticClass:"flex space-x-4 justify-center mt-2 p-3"},[n("a",{staticClass:"rounded leading-none px-4 py-2 bg-blue hover:bg-blue-light hover:shadow cursor-pointer",on:{click:function(e){t.confirmDelete=null}}},[t._v("\n          No, don't delete\n        ")]),t._v(" "),n("a",{staticClass:"rounded leading-none px-4 py-2 bg-yellow hover:bg-yellow-light hover:shadow cursor-pointer",on:{click:function(e){return t.deleteScrapbook()}}},[t._v("\n          Yes, delete it\n        ")])])])],1):t._e()],1)}),[],!1,null,null,null).exports}}]);