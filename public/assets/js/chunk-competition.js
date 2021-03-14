(self.webpackChunk=self.webpackChunk||[]).push([[8840],{2612:(t,e,o)=>{"use strict";o.r(e),o.d(e,{default:()=>n});const i={components:{"form-input":function(){return Promise.all([o.e(931),o.e(1531)]).then(o.bind(o,511))},loader:function(){return o.e(8540).then(o.bind(o,2287))},modal:function(){return o.e(5441).then(o.bind(o,931))}},props:{uuid:{required:!0,type:String},facebookLike:{required:!0,type:Boolean|Number},facebookShare:{required:!0,type:Boolean|Number},twitterFollow:{required:!0,type:Boolean|Number},twitterTweet:{required:!0,type:Boolean|Number},shopPurchase:{required:!0,type:Boolean|Number}},data:function(){return{entryId:null,hasEntered:!1,isSubmitting:!1,viewTermsModal:!1,terms:null,additionalEntries:[],form:{data:{name:"",email:""},validation:{name:!1,email:!1}}}},mounted:function(){var t=this;Object.keys(this.form.validation).forEach((function(e){t.$root.$on("".concat(e,"-error"),(function(){t.form.validation[e]=!1})),t.$root.$on("".concat(e,"-valid"),(function(){t.form.validation[e]=!0})),t.$root.$on("".concat(e,"-change"),(function(o){t.form.data[e]=o})),t.$root.$on("".concat(e,"-value"),(function(o){t.form.data[e]=o}))})),this.$root.$on("modal-closed",(function(){return t.viewTermsModal=!1}))},methods:{viewTerms:function(){var t=this;this.viewTermsModal=!0,this.terms||coeliac().request().get("/api/competition/".concat(this.uuid,"/terms")).then((function(e){t.terms=e.data}))},submitForm:function(){var t=this;this.validateForm()?(this.isSubmitting=!0,coeliac().request().post("/api/competition/".concat(this.uuid),this.form.data).then((function(e){t.entryId=e.data.id,t.hasEntered=!0})).catch((function(t){var e="There was an error submitting your entry.";"duplicate entry"===t.response.data.error&&(e="You've already entered this competition!"),coeliac().error(e)})).finally((function(){t.isSubmitting=!1}))):coeliac.error("Please complete your entry form!")},addAdditionalEntry:function(t){var e=this;coeliac().request().put("/api/competition/".concat(this.uuid),{id:this.entryId,type:t}).then((function(){coeliac().success("Thanks, you've now got an additional chance in our competition!"),e.additionalEntries.push(t)})).catch((function(){coeliac().error("Sorry, there was an error processing your additional entry")}))},validateForm:function(){var t=this;Object.keys(this.form.validation).forEach((function(e){t.$root.$emit("".concat(e,"-get-value"))}));var e=!0;return Object.keys(this.form.validation).forEach((function(o){!1===t.form.validation[o]&&(e=!1)})),e},openPopup:function(t,e){window.open(t,e,"height=480,width=640,toolbar=no,menubar=no,scrollbars=no,resizable=no,location=no,directories=no,status=no")},extraEntryOptions:function(){var t=this,e=[];return this.facebookLike&&e.push({id:"facebook_like",label:"Visit and like our Facebook Page",icon:["fab","facebook-square"],classes:["text-grey-off-light hover:text-white bg-social-facebook-light hover:bg-social-facebook transition-bg"],click:function(){window.open("https://www.facebook.com/coeliacsanctuary"),t.addAdditionalEntry("facebook_like")}}),this.twitterFollow&&e.push({id:"twitter_follow",label:"Visit and follow us on our Twitter Page",icon:["fab","twitter-square"],classes:["text-grey-off-light hover:text-white bg-social-twitter-light hover:bg-social-twitter transition-bg"],click:function(){window.open("https://twitter.com/coeliacsanc"),t.addAdditionalEntry("twitter_follow")}}),this.facebookShare&&e.push({id:"facebook_share",label:"Share our competition on Facebook",icon:["fab","facebook-square"],classes:["text-grey-off-light hover:text-white bg-social-facebook-light hover:bg-social-facebook transition-bg"],click:function(){t.openPopup("https://www.facebook.com/sharer.php?u="+window.location.href,"Share On Facebook"),t.addAdditionalEntry("facebook_share")}}),this.twitterTweet&&e.push({id:"twitter_tweet",label:"Share our competition on Twitter",icon:["fab","twitter-square"],classes:["text-grey-off-light hover:text-white bg-social-twitter-light hover:bg-social-twitter transition-bg"],click:function(){t.openPopup("https://twitter.com/intent/tweet?text="+document.querySelector("meta[name=description]").getAttribute("content")+"&via=CoeliacSanc&url="+window.location.href,"Share on Twitter"),t.addAdditionalEntry("twitter_tweet")}}),this.shopPurchase&&e.push({id:"shop_purchase",label:"Purchase from the Coeliac Sanctuary Shop",component:"coeliac-icon",classes:["text-grey-off-light hover:text-white bg-yellow-50 hover:bg-yellow transition-bg"],click:function(){window.open("https://www.coeliacsanctuary.co.uk/shop"),t.addAdditionalEntry("shop_purchase")}}),e},extraEntriesCount:function(){var t=this;return[{key:"facebook_like",value:this.facebookLike},{key:"facebook_share",value:this.facebookShare},{key:"twitter_tweet",value:this.twitterTweet},{key:"twitter_follow",value:this.twitterFollow},{key:"shop_purchase",value:this.shopPurchase}].filter((function(t){return 1===t.value})).filter((function(e){return!t.additionalEntries.includes(e.key)})).length}},computed:{hasMoreEntries:function(){return[this.facebookLike,this.facebookShare,this.twitterTweet,this.twitterFollow,this.shopPurchase].includes(1)}}};const n=(0,o(1900).Z)(i,(function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",[o("div",{staticClass:"bg-blue-gradient-30 border border-blue rounded-lg p-4 m-2 lg:mx-auto",staticStyle:{"max-width":"1000px"}},[t.hasEntered?o("div",[o("p",{staticClass:"text-xl font-semibold text-center"},[t._v("\n                Thanks for entering our competition, good luck!\n            ")]),t._v(" "),t.hasMoreEntries&&t.extraEntriesCount()>0?o("div",{staticClass:"mt-2"},[o("p",{staticClass:"font-semibold text-center"},[t._v("\n                    Do you want up to "+t._s(t.extraEntriesCount())+" more chances to win?\n                ")]),t._v(" "),o("ul",{staticClass:"mt-4"},t._l(t.extraEntryOptions(),(function(e){return o("li",{directives:[{name:"show",rawName:"v-show",value:!t.additionalEntries.includes(e.id),expression:"!additionalEntries.includes(entry.id)"}],staticClass:"flex items-center p-2 cursor-pointer",class:e.classes,on:{click:function(t){return e.click()}}},[o("span",{staticClass:"text-5xl mr-2 sm:mr-4 leading-none",staticStyle:{width:"42px"}},[e.icon?o("font-awesome-icon",{attrs:{icon:e.icon}}):t._e(),t._v(" "),e.component?o(e.component,{tag:"component"}):t._e()],1),t._v(" "),o("span",{staticClass:"flex-1"},[t._v(t._s(e.label))]),t._v(" "),t._m(0,!0)])})),0)]):t._e()]):o("div",[o("p",{staticClass:"font-semibold text-lg mb-5 text-center"},[t._v("\n                To enter our competition just enter your name and email below!\n            ")]),t._v(" "),o("div",{staticClass:"mb-5 flex-1"},[o("form-input",{attrs:{required:"",name:"name",value:t.form.data.name,placeholder:"Your Name..."}})],1),t._v(" "),o("div",{staticClass:"mb-5 flex-1"},[o("form-input",{attrs:{required:"",name:"email",type:"email",value:t.form.data.email,placeholder:"Your email..."}})],1),t._v(" "),o("div",{staticClass:"mb-5 flex-1"},[o("p",[t._v("\n                    By entering this competition you agree to the competition "),o("a",{staticClass:"font-semibold hover:text-blue-dark hover:underline cursor-pointer",on:{click:t.viewTerms}},[t._v("Terms\n                    and Conditions")]),t._v(".\n                ")])]),t._v(" "),o("div",{staticClass:"w-full flex justify-center"},[o("button",{staticClass:"mt-2 bg-blue-50 border border-blue rounded-lg px-6 py-2 text-xl text-black transition-bg hover:bg-blue-20",staticStyle:{width:"285px",height:"59px"},attrs:{disabled:t.isSubmitting},on:{click:function(e){return e.preventDefault(),t.submitForm()}}},[t.isSubmitting?o("loader",{attrs:{show:"","background-position":"relative",width:"30px",height:"30px"}}):o("span",[t._v("Enter Competition!")])],1)])])]),t._v(" "),t.viewTermsModal?o("portal",{attrs:{to:"modal"}},[o("modal",{attrs:{"modal-classes":"w-full"}},[t.terms?o("div",{staticClass:"text-xs main-body",domProps:{innerHTML:t._s(t.terms)}}):o("div",{staticClass:"h-48"},[o("loader",{attrs:{show:""}})],1)])],1):t._e()],1)}),[function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",{staticClass:"flex flex-col justify-center items-center leading-none"},[o("span",{staticClass:"text-3xl"},[t._v("+1")]),t._v(" "),o("span",{staticClass:"text-xs font-semibold"},[t._v("ENTRY")])])}],!1,null,null,null).exports}}]);