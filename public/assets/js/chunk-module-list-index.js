(self.webpackChunk=self.webpackChunk||[]).push([[5377],{4437:(e,t,s)=>{"use strict";function r(e){return(r="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}s.d(t,{Z:()=>i});const i={methods:{buildUrl:function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:1,s=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null,i=arguments.length>3&&void 0!==arguments[3]?arguments[3]:null,n=arguments.length>4&&void 0!==arguments[4]&&arguments[4],l="page=".concat(t);if(s&&(l+="&search=".concat(s)),i){var a=[];Object.keys(i).forEach((function(e){null!==i[e]&&("object"===r(i[e])?a.push("filter["+e+"]="+i[e].join(",")):a.push("filter["+e+"]="+i[e]))})),l+="&"+a.join("&")}return n&&(l="o="+btoa(l)),e+"?"+l}}}},3923:(e,t,s)=>{"use strict";s.d(t,{Z:()=>n});var r=s(7484),i=s.n(r);const n={methods:{formatDate:function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"D MMMM YYYY";return i()(e).format(t)}}}},9081:(e,t,s)=>{"use strict";s.d(t,{Z:()=>r});const r={methods:{googleEvent:function(e,t){var s=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};window.gtag&&window.gtag(e,t,s)}}}},2394:(e,t,s)=>{"use strict";s.d(t,{Z:()=>r});s(2732);const r={methods:{loadLazyImages:function(){coeliac().updateLazyloader()}},computed:{lazyLoadSrc:function(){return"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"}}}},6143:(e,t,s)=>{"use strict";s.r(t),s.d(t,{default:()=>F});const r={blogs:[{label:"Tag",value:"tags"},{label:"Year",value:"year"}],recipes:[{label:"Features",value:"feature"},{label:"Free From",value:"freefrom"},{label:"Meal",value:"meal"}],reviews:[{label:"Rating",value:"ratings"},{label:"County",value:"counties"}]};var i=s(4437),n=s(2394),l=s(9081);const a={mixins:[i.Z],props:{currentFilters:{type:Object|Array},currentSearch:{type:String,default:""}},data:function(){return{tags:[],selectedTags:[],years:[],selectedYear:null,searchText:"",accordions:{tags:!1,year:!1}}},mounted:function(){var e=this;this.getData(),this.$root.$on("accordion-toggled",(function(t){void 0!==e.accordions[t.name]&&e.$set(e.accordions,t.name,t.visible)})),this.$root.$on("clear-filters",(function(){e.selectedTags=[],e.selectedYear=""}))},methods:{getData:function(){var e=this;coeliac().request().get(this.buildUrl("/api/blogs/tags",1,this.currentSearch,this.currentFilters)).then((function(t){e.tags=t.data.data,e.selectedTags=[],e.currentFilters&&e.currentFilters.tags.forEach((function(t){e.selectedTags.push(e.tags.filter((function(e){return e.slug===t}))[0])}))})),coeliac().request().get(this.buildUrl("/api/blogs/years",1,this.currentSearch,this.currentFilters)).then((function(t){e.years=t.data.data,e.selectedYear=e.currentFilters.year[0]||null}))},selectTag:function(e){this.selectedTags.push(e),this.$root.$emit("add-filter",{name:"tags",value:e.slug})},selectYear:function(e){this.selectedYear=e,this.$root.$emit("add-filter",{name:"year",value:e,single:!0})},removeTag:function(e){this.selectedTags=this.selectedTags.filter((function(t){return t.slug!==e.slug})),this.$root.$emit("remove-filter",{name:"tags",value:e.slug})},removeYear:function(){var e=this.selectedYear;this.selectedYear=null,this.$root.$emit("remove-filter",{name:"year",value:e})},iconFor:function(e){return this.accordions[e]?"chevron-up":"chevron-down"}},computed:{filteredTags:function(){var e=this;return this.tags.filter((function(t){return""!==e.searchText?t.title.toLowerCase().includes(e.searchText)&&-1===e.selectedTags.indexOf(t):-1===e.selectedTags.indexOf(t)})).slice(0,14)}},watch:{currentFilters:{deep:!0,handler:function(){this.getData()}},currentSearch:{deep:!0,handler:function(){this.getData()}}}};var o=s(1900);const c=(0,o.Z)(a,(function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",[s("accordion",{attrs:{group:"filters",name:"tags"},scopedSlots:e._u([{key:"title",fn:function(){return[s("div",{staticClass:"border-b border-grey-light p-2"},[s("div",{staticClass:"flex flex-col"},[s("h3",{staticClass:"cursor-pointer text-lg font-medium mt-1 flex justify-between items-center"},[s("span",[e._v("Blog Tags")]),e._v(" "),s("font-awesome-icon",{staticClass:"text-blue",attrs:{icon:["fas",e.iconFor("tags")]}})],1)]),e._v(" "),e.selectedTags.length>0?s("div",{staticClass:"text-grey-dark"},[s("ul",{staticClass:"flex flex-wrap text-sm -m-2px leading-none"},e._l(e.selectedTags,(function(t){return s("li",{staticClass:"rounded-lg bg-blue-light m-2px flex overflow-hidden"},[s("span",{staticClass:"px-3 py-1"},[e._v(e._s(t.title))]),e._v(" "),s("span",{staticClass:"block bg-yellow px-2 py-1 cursor-pointer",on:{click:function(s){return s.stopPropagation(),e.removeTag(t)}}},[s("font-awesome-icon",{attrs:{icon:["fas","times"]}})],1)])})),0)]):e._e()])]},proxy:!0},{key:"body",fn:function(){return[s("div",{staticClass:"p-2"},[s("div",{staticClass:"w-full flex mb-1"},[s("input",{directives:[{name:"model",rawName:"v-model",value:e.searchText,expression:"searchText"}],staticClass:"text-sm p-1 flex-1 bg-grey-lightest border border-grey-off rounded w-full",attrs:{type:"search",placeholder:"Search Tags..."},domProps:{value:e.searchText},on:{input:function(t){t.target.composing||(e.searchText=t.target.value)}}})]),e._v(" "),s("ul",e._l(e.filteredTags,(function(t){return s("li",{staticClass:"py-1 border-b border-dashed border-grey-off-dark transition-bg cursor-pointer hover:bg-grey-off-dark",on:{click:function(s){return s.preventDefault(),e.selectTag(t)}}},[s("span",[e._v(e._s(t.title))]),e._v(" "),s("span",{staticClass:"text-xs"},[e._v("("+e._s(t.blogs_count)+" Blogs)")])])})),0)])]},proxy:!0}])}),e._v(" "),s("accordion",{attrs:{group:"filters",name:"year"},scopedSlots:e._u([{key:"title",fn:function(){return[s("div",{staticClass:"border-b border-grey-light p-2"},[s("div",{staticClass:"flex flex-col"},[s("h3",{staticClass:"cursor-pointer text-lg font-medium mt-1 flex justify-between items-center"},[s("span",[e._v("Year Posted")]),e._v(" "),s("font-awesome-icon",{staticClass:"text-blue",attrs:{icon:["fas",e.iconFor("year")]}})],1)]),e._v(" "),e.selectedYear?s("div",{staticClass:"text-grey-dark"},[s("ul",{staticClass:"flex flex-wrap text-sm -m-2px leading-none"},[s("li",{staticClass:"rounded-lg bg-blue-light m-2px flex overflow-hidden"},[s("span",{staticClass:"px-3 py-1"},[e._v(e._s(e.selectedYear))]),e._v(" "),s("span",{staticClass:"block bg-yellow px-2 py-1 cursor-pointer",on:{click:function(t){return t.stopPropagation(),e.removeYear()}}},[s("font-awesome-icon",{attrs:{icon:["fas","times"]}})],1)])])]):e._e()])]},proxy:!0},{key:"body",fn:function(){return[s("div",{staticClass:"p-2"},[e.years.length>0?s("ul",e._l(e.years,(function(t){return s("li",{staticClass:"py-1 border-b border-dashed border-grey-off-dark transition-bg cursor-pointer hover:bg-grey-off-dark",on:{click:function(s){return s.preventDefault(),e.selectYear(t.year)}}},[s("span",[e._v(e._s(t.year))]),e._v(" "),s("span",{staticClass:"text-xs"},[e._v("("+e._s(t.blogs_count)+" Blogs)")])])})),0):e._e()])]},proxy:!0}])})],1)}),[],!1,null,null,null).exports;const u={mixins:[i.Z],props:{currentFilters:{type:Object|Array},currentSearch:{type:String,default:""}},data:function(){return{allergens:[],selectedAllergens:[],features:[],selectedFeatures:[],meals:[],selectedMeals:[],accordions:{freefrom:!1,meals:!1,features:!1}}},mounted:function(){var e=this;this.getData(),this.$root.$on("accordion-toggled",(function(t){void 0!==e.accordions[t.name]&&e.$set(e.accordions,t.name,t.visible)})),this.$root.$on("clear-filters",(function(){e.selectedTags=[],e.selectedYear=""}))},methods:{getData:function(){var e=this;coeliac().request().get(this.buildUrl("/api/recipes/allergens",1,this.currentSearch,this.currentFilters)).then((function(t){e.allergens=t.data.data,e.selectedAllergens=[],e.currentFilters&&e.currentFilters.freefrom.forEach((function(t){e.selectedAllergens.push(e.allergens.filter((function(e){return e.title===t}))[0])}))})),coeliac().request().get(this.buildUrl("/api/recipes/features",1,this.currentSearch,this.currentFilters)).then((function(t){e.features=t.data.data,e.selectedFeatures=[],e.currentFilters&&e.currentFilters.feature.forEach((function(t){e.selectedFeatures.push(e.features.filter((function(e){return e.title===t}))[0])}))})),coeliac().request().get(this.buildUrl("/api/recipes/meals",1,this.currentSearch,this.currentFilters)).then((function(t){e.meals=t.data.data,e.selectedMeals=[],e.currentFilters&&e.currentFilters.meal.forEach((function(t){e.selectedMeals.push(e.meals.filter((function(e){return e.title===t}))[0])}))}))},selectAllergen:function(e){this.$root.$emit("add-filter",{name:"freefrom",value:e.title})},removeAllergen:function(e){this.selectedAllergens=this.selectedAllergens.filter((function(t){return t.title!==e.title})),this.$root.$emit("remove-filter",{name:"freefrom",value:e.title})},selectFeature:function(e){this.$root.$emit("add-filter",{name:"feature",value:e.title})},removeFeature:function(e){this.selectedFeatures=this.selectedFeatures.filter((function(e){return e.title!=e.title})),this.$root.$emit("remove-filter",{name:"feature",value:e.title})},selectMeal:function(e){this.$root.$emit("add-filter",{name:"meal",value:e.title})},removeMeal:function(e){this.selectedMeals=this.selectedMeals.filter((function(t){return t.title!==e.title})),this.$root.$emit("remove-filter",{name:"meal",value:e.title})},iconFor:function(e){return this.accordions[e]?"chevron-up":"chevron-down"}},computed:{filteredAllergens:function(){var e=this;return this.allergens.filter((function(t){return-1===e.selectedAllergens.indexOf(t)})).slice(0,14)},filteredFeatures:function(){var e=this;return this.features.filter((function(t){return-1===e.selectedFeatures.indexOf(t)})).slice(0,14)},filteredMeals:function(){var e=this;return this.meals.filter((function(t){return-1===e.selectedMeals.indexOf(t)})).slice(0,14)}},watch:{currentFilters:{deep:!0,handler:function(){this.getData()}},currentSearch:{deep:!0,handler:function(){this.getData()}}}};const f=(0,o.Z)(u,(function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",[s("accordion",{attrs:{group:"filters",name:"freefrom"},scopedSlots:e._u([{key:"title",fn:function(){return[s("div",{staticClass:"border-b border-grey-light p-2"},[s("div",{staticClass:"flex flex-col"},[s("h3",{staticClass:"cursor-pointer text-lg font-medium mt-1 flex justify-between items-center"},[s("span",[e._v("Free From")]),e._v(" "),s("font-awesome-icon",{staticClass:"text-blue",attrs:{icon:["fas",e.iconFor("freefrom")]}})],1)]),e._v(" "),e.selectedAllergens.length>0?s("div",{staticClass:"text-grey-dark"},[s("ul",{staticClass:"flex flex-wrap text-sm -m-2px leading-none"},e._l(e.selectedAllergens,(function(t){return s("li",{staticClass:"rounded-lg bg-blue-light m-2px flex overflow-hidden"},[s("span",{staticClass:"px-3 py-1"},[e._v(e._s(t.title))]),e._v(" "),s("span",{staticClass:"block bg-yellow px-2 py-1 cursor-pointer",on:{click:function(s){return s.stopPropagation(),e.removeAllergen(t)}}},[s("font-awesome-icon",{attrs:{icon:["fas","times"]}})],1)])})),0)]):e._e()])]},proxy:!0},{key:"body",fn:function(){return[s("div",{staticClass:"p-2"},[s("ul",e._l(e.filteredAllergens,(function(t){return s("li",{staticClass:"py-1 border-b border-dashed border-grey-off-dark transition-bg cursor-pointer hover:bg-grey-off-dark",on:{click:function(s){return s.preventDefault(),e.selectAllergen(t)}}},[s("span",[e._v(e._s(t.title))]),e._v(" "),s("span",{staticClass:"text-xs"},[e._v("("+e._s(t.recipes_count)+" Recipes)")])])})),0)])]},proxy:!0}])}),e._v(" "),s("accordion",{attrs:{group:"filters",name:"meals"},scopedSlots:e._u([{key:"title",fn:function(){return[s("div",{staticClass:"border-b border-grey-light p-2"},[s("div",{staticClass:"flex flex-col"},[s("h3",{staticClass:"cursor-pointer text-lg font-medium mt-1 flex justify-between items-center"},[s("span",[e._v("Meal")]),e._v(" "),s("font-awesome-icon",{staticClass:"text-blue",attrs:{icon:["fas",e.iconFor("meals")]}})],1)]),e._v(" "),e.selectedMeals.length>0?s("div",{staticClass:"text-grey-dark"},[s("ul",{staticClass:"flex flex-wrap text-sm -m-2px leading-none"},e._l(e.selectedMeals,(function(t){return s("li",{staticClass:"rounded-lg bg-blue-light m-2px flex overflow-hidden"},[s("span",{staticClass:"px-3 py-1"},[e._v(e._s(t.title))]),e._v(" "),s("span",{staticClass:"block bg-yellow px-2 py-1 cursor-pointer",on:{click:function(s){return s.stopPropagation(),e.removeMeal(t)}}},[s("font-awesome-icon",{attrs:{icon:["fas","times"]}})],1)])})),0)]):e._e()])]},proxy:!0},{key:"body",fn:function(){return[s("div",{staticClass:"p-2"},[s("ul",e._l(e.filteredMeals,(function(t){return s("li",{staticClass:"py-1 border-b border-dashed border-grey-off-dark transition-bg cursor-pointer hover:bg-grey-off-dark",on:{click:function(s){return s.preventDefault(),e.selectMeal(t)}}},[s("span",[e._v(e._s(t.title))]),e._v(" "),s("span",{staticClass:"text-xs"},[e._v("("+e._s(t.recipes_count)+" Recipes)")])])})),0)])]},proxy:!0}])}),e._v(" "),s("accordion",{attrs:{group:"filters",name:"features"},scopedSlots:e._u([{key:"title",fn:function(){return[s("div",{staticClass:"border-b border-grey-light p-2"},[s("div",{staticClass:"flex flex-col"},[s("h3",{staticClass:"cursor-pointer text-lg font-medium mt-1 flex justify-between items-center"},[s("span",[e._v("Features")]),e._v(" "),s("font-awesome-icon",{staticClass:"text-blue",attrs:{icon:["fas",e.iconFor("meals")]}})],1)]),e._v(" "),e.selectedFeatures.length>0?s("div",{staticClass:"text-grey-dark"},[s("ul",{staticClass:"flex flex-wrap text-sm -m-2px leading-none"},e._l(e.selectedFeatures,(function(t){return s("li",{staticClass:"rounded-lg bg-blue-light m-2px flex overflow-hidden"},[s("span",{staticClass:"px-3 py-1"},[e._v(e._s(t.title))]),e._v(" "),s("span",{staticClass:"block bg-yellow px-2 py-1 cursor-pointer",on:{click:function(s){return s.stopPropagation(),e.removeFeature(t)}}},[s("font-awesome-icon",{attrs:{icon:["fas","times"]}})],1)])})),0)]):e._e()])]},proxy:!0},{key:"body",fn:function(){return[s("div",{staticClass:"p-2"},[s("ul",e._l(e.filteredFeatures,(function(t){return s("li",{staticClass:"py-1 border-b border-dashed border-grey-off-dark transition-bg cursor-pointer hover:bg-grey-off-dark",on:{click:function(s){return s.preventDefault(),e.selectFeature(t)}}},[s("span",[e._v(e._s(t.title))]),e._v(" "),s("span",{staticClass:"text-xs"},[e._v("("+e._s(t.recipes_count)+" Recipes)")])])})),0)])]},proxy:!0}])})],1)}),[],!1,null,null,null).exports;const d={mixins:[i.Z],props:{currentFilters:{type:Object|Array},currentSearch:{type:String,default:""}},data:function(){return{counties:{},selectedCounties:[],ratings:{},selectedRatings:{},accordions:{counties:!1,ratings:!1}}},mounted:function(){var e=this;this.getData(),this.$root.$on("accordion-toggled",(function(t){void 0!==e.accordions[t.name]&&e.$set(e.accordions,t.name,t.visible)})),this.$root.$on("clear-filters",(function(){e.selectedTags=[],e.selectedYear=""}))},methods:{getData:function(){var e=this;coeliac().request().get(this.buildUrl("/api/reviews/counties",1,this.currentSearch,this.currentFilters)).then((function(t){e.counties=t.data.data,e.selectedCounties=[],e.currentFilters&&e.currentFilters.counties.forEach((function(t){Object.keys(e.counties).forEach((function(s){Object.keys(e.counties[s]).forEach((function(r){r===t&&e.selectedCounties.push({country:s,county:r})}))}))}))})),coeliac().request().get(this.buildUrl("/api/reviews/ratings",1,this.currentSearch,this.currentFilters)).then((function(t){e.ratings=t.data.data,e.selectedRatings=[],e.currentFilters&&e.currentFilters.ratings.forEach((function(t){Object.keys(e.ratings).forEach((function(s){s===t&&e.selectedCounties.push(s)}))}))}))},selectCounty:function(e,t){this.selectedCounties.push({county:e,country:t}),this.$root.$emit("add-filter",{name:"counties",value:e})},removeCounty:function(e){this.selectedCounties=this.selectedCounties.filter((function(t){return t.county!==e.county})),this.$root.$emit("remove-filter",{name:"counties",value:e.county})},selectRating:function(e){this.selectedRatings.push(e),this.$root.$emit("add-filter",{name:"ratings",value:e})},removeRating:function(e){this.selectedRatings=this.selectedRatings.filter((function(t){return t!==e})),this.$root.$emit("remove-filter",{name:"ratings",value:e})},iconFor:function(e){return this.accordions[e]?"chevron-up":"chevron-down"}},computed:{filteredCountries:function(){var e=this,t={};return Object.keys(this.counties).forEach((function(s){var r={};Object.keys(e.counties[s]).forEach((function(t){-1===JSON.stringify(e.selectedCounties).indexOf(JSON.stringify({country:s,county:t}))&&e.$set(r,t,e.counties[s][t])})),e.$set(t,s,r)})),t},filteredRatings:function(){var e=this,t={};return Object.keys(this.ratings).forEach((function(s){-1===e.selectedRatings.indexOf(s)&&e.$set(t,s,e.ratings[s])})),t}},watch:{currentFilters:{deep:!0,handler:function(){this.getData()}},currentSearch:{deep:!0,handler:function(){this.getData()}}}};const g=(0,o.Z)(d,(function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",[s("accordion",{attrs:{group:"filters",name:"counties"},scopedSlots:e._u([{key:"title",fn:function(){return[s("div",{staticClass:"border-b border-grey-light p-2"},[s("div",{staticClass:"flex flex-col"},[s("h3",{staticClass:"cursor-pointer text-lg font-medium mt-1 flex justify-between items-center"},[s("span",[e._v("Counties")]),e._v(" "),s("font-awesome-icon",{staticClass:"text-blue",attrs:{icon:["fas",e.iconFor("counties")]}})],1)]),e._v(" "),e.selectedCounties.length>0?s("div",{staticClass:"text-grey-dark"},[s("ul",{staticClass:"flex flex-wrap text-sm -m-2px leading-none"},e._l(e.selectedCounties,(function(t){return s("li",{staticClass:"rounded-lg bg-blue-light m-2px flex overflow-hidden"},[s("span",{staticClass:"px-3 py-1"},[e._v(e._s(t.county)+", "+e._s(t.country))]),e._v(" "),s("span",{staticClass:"block bg-yellow px-2 py-1 cursor-pointer",on:{click:function(s){return s.stopPropagation(),e.removeCounty(t)}}},[s("font-awesome-icon",{attrs:{icon:["fas","times"]}})],1)])})),0)]):e._e()])]},proxy:!0},{key:"body",fn:function(){return[s("div",{staticClass:"p-2"},[s("ul",e._l(e.filteredCountries,(function(t,r){return s("li",{staticClass:"py-1"},[s("h3",{staticClass:"w-full font-semibold text-xl text-blue-dark"},[e._v(e._s(r))]),e._v(" "),s("ul",e._l(t,(function(t,i){return s("li",{staticClass:"py-1 border-b border-dashed border-grey-off-dark transition-bg cursor-pointer hover:bg-grey-off-dark",on:{click:function(t){return t.preventDefault(),e.selectCounty(i,r)}}},[s("span",[e._v(e._s(i))]),e._v(" "),s("span",{staticClass:"text-xs"},[e._v("("+e._s(t)+" Reviews)")])])})),0)])})),0)])]},proxy:!0}])}),e._v(" "),s("accordion",{attrs:{group:"filters",name:"ratings"},scopedSlots:e._u([{key:"title",fn:function(){return[s("div",{staticClass:"border-b border-grey-light p-2"},[s("div",{staticClass:"flex flex-col"},[s("h3",{staticClass:"cursor-pointer text-lg font-medium mt-1 flex justify-between items-center"},[s("span",[e._v("Rating")]),e._v(" "),s("font-awesome-icon",{staticClass:"text-blue",attrs:{icon:["fas",e.iconFor("ratings")]}})],1)]),e._v(" "),e.selectedRatings.length>0?s("div",{staticClass:"text-grey-dark"},[s("ul",{staticClass:"flex flex-wrap text-sm -m-2px leading-none"},e._l(e.selectedRatings,(function(t){return s("li",{staticClass:"rounded-lg bg-blue-light m-2px flex overflow-hidden"},[s("span",{staticClass:"px-3 py-1"},[e._v(e._s(t))]),e._v(" "),s("span",{staticClass:"block bg-yellow px-2 py-1 cursor-pointer",on:{click:function(s){return s.stopPropagation(),e.removeRating(t)}}},[s("font-awesome-icon",{attrs:{icon:["fas","times"]}})],1)])})),0)]):e._e()])]},proxy:!0},{key:"body",fn:function(){return[s("div",{staticClass:"p-2"},[s("ul",e._l(e.filteredRatings,(function(t,r){return s("li",{staticClass:"py-1 border-b border-dashed border-grey-off-dark transition-bg cursor-pointer hover:bg-grey-off-dark",on:{click:function(t){return t.preventDefault(),e.selectRating(r)}}},[s("span",[e._v(e._s(r))]),e._v(" "),s("span",{staticClass:"text-xs"},[e._v("("+e._s(t)+" Reviews)")])])})),0)])]},proxy:!0}])})],1)}),[],!1,null,null,null).exports,h={mixins:[l.Z],components:{"blogs-filter":c,"recipes-filter":f,"reviews-filter":g},props:{show:{type:Boolean,default:!1},title:{type:String,required:!0},totalResults:{type:Number,required:!0},currentFilters:{type:Object|Array},currentSearch:{type:String,default:""}},methods:{closeFilterBar:function(){this.$root.$emit("toggle-filter-bar")},clearFilters:function(){this.$root.$emit("clear-filters")}},computed:{component:function(){return this.title.toLowerCase()+"-filter"}},watch:{show:function(e){e?(this.googleEvent("event","modules",{event_category:"opened-filter-bar",event_label:this.title}),document.querySelector("html").classList.add("bg-black-80","overflow-hidden"),document.querySelector("html").classList.remove("bg-grey-light")):(document.querySelector("html").classList.add("bg-grey-light"),document.querySelector("html").classList.remove("bg-black-80","overflow-hidden"))}}};const p=(0,o.Z)(h,(function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{directives:[{name:"show",rawName:"v-show",value:e.show,expression:"show"}],staticClass:"w-screen h-screen fixed inset-0 bg-black-80 z-max",on:{click:function(t){return t.target!==t.currentTarget?null:e.closeFilterBar()}}},[s("div",{staticClass:"w-11/12 h-full absolute top-0 right-0 bg-white border-l border-grey-off-dark z-20 shadow-lg flex flex-col overflow-y-scroll",staticStyle:{"max-width":"350px"}},[s("div",{staticClass:"flex mb-1 items-center p-2"},[s("h2",{staticClass:"flex-1 text-xl font-medium"},[e._v("Filter "+e._s(e.title))]),e._v(" "),s("div",{staticClass:"cursor-pointer",on:{click:function(t){return e.closeFilterBar()}}},[s("font-awesome-icon",{attrs:{icon:["fas","times"]}})],1)]),e._v(" "),s("div",{staticClass:"bg-blue-light-20 p-2 text-md"},[e._v("\n            "+e._s(e.totalResults)+" "+e._s(e.title)+" shown...\n        ")]),e._v(" "),s(e.component,{tag:"component",attrs:{"current-filters":e.currentFilters,"current-search":e.currentSearch}}),e._v(" "),s("div",{staticClass:"flex justify-between p-2"},[s("button",{staticClass:"px-4 inline-block leading-none p-2 bg-blue rounded",on:{click:function(t){return e.clearFilters()}}},[e._v("Clear")]),e._v(" "),s("button",{staticClass:"px-4 inline-block leading-none p-2 bg-blue rounded",on:{click:function(t){return e.closeFilterBar()}}},[e._v("Apply")])])],1)])}),[],!1,null,null,null).exports;const m={mixins:[s(3923).Z,n.Z],props:{module:{required:!0,validator:function(e){return-1!==["blogs","collection","recipes","reviews"].indexOf(e)}},item:{required:!0,type:Object},index:{required:!0,type:Number},page:{required:!0,type:Number},layout:{type:String,default:"tiles",validator:function(e){return-1!==["tiles","list"].indexOf(e)}},hasFilters:{type:Boolean,default:!1}},mounted:function(){var e=this;this.loadLazyImages(),this.$root.$on("layout-change",(function(t){setTimeout((function(){e.loadLazyImages()}),200)}))},methods:{commentsText:function(e){return 0===e?"No Comments":1===e?"1 Comment":"".concat(e," comments")},collectionItemsText:function(e){return 1===e?"1 item in this collection":"".concat(e," items in this collection")}},computed:{description:function(){return 1===this.page&&0===this.index&&this.item.description||this.item.meta_description},wrapperClasses:function(){if("list"===this.layout)return["w-full"];if(1===this.page&&!this.hasFilters){if(0===this.index)return["w-full","p-2"];if(this.index>0&&this.index<3)return["w-full","md:w-1/2","p-2"]}return["w-full","md:w-1/3","p-2"]},innerWrapperClasses:function(){return"list"===this.layout?["flex","flex-col","py-3","border-b","border-grey-off","sm:flex-row"]:["bg-blue-gradient-30","shadow","curved","rounded-lg","overflow-hidden","mb-4","md:h-full","flex","flex-col"]},imageClasses:function(){return"list"===this.layout?["w-full","mb-2","sm:w-1/2","sm:mr-2","sm:mb-0","lg:w-1/4"]:["w-full"]},textClasses:function(){return"list"===this.layout?["flex-1","flex","flex-col"]:["flex-1","flex","flex-col","p-2"]},headerClasses:function(){return"list"===this.layout?["text-2xl","text-blue","hover:text-grey-dark","transition-color","font-semibold","font-coeliac","leading-tight"]:["text-2xl","text-black","hover:text-grey-dark","transition-color","text-semibold","leading-tight","text-center","mb-1"]}}};const v=(0,o.Z)(m,(function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{class:e.wrapperClasses},[s("div",{class:e.innerWrapperClasses},[s("div",{staticClass:"flex flex-col",class:e.imageClasses},[s("a",{attrs:{href:e.item.link}},["recipes"!==e.module?s("img",{staticClass:"lazy w-full",attrs:{"data-src":e.item.main_image,alt:e.item.title,loading:"lazy",src:e.lazyLoadSrc}}):s("recipe-image",{attrs:{src:e.item.main_image,alt:e.item.title}})],1),e._v(" "),"recipes"===e.module&&"list"===e.layout?[s("ul",{staticClass:"flex flex-wrap justify-center -mx-2 sm:justify-start"},e._l(e.item.features,(function(t){return s("li",{staticClass:"w-1/6 m-2 flex flex-col max-w-recipe-feature text-xs leading-none text-center"},[s("img",{staticClass:"lazy",attrs:{"data-src":t.image,loading:"lazy",alt:t.feature,src:e.lazyLoadSrc}}),e._v(" "),s("span",{staticClass:"font-semibold mt-1"},[e._v(e._s(t.feature))])])})),0)]:e._e()],2),e._v(" "),s("div",{class:e.textClasses},[s("a",{class:e.headerClasses,attrs:{href:e.item.link}},[s("h2",{domProps:{innerHTML:e._s(e.item.title)}})]),e._v(" "),"reviews"===e.module?[s("span",{staticClass:"font-semibold text-xs",class:"tiles"===e.layout?"text-center":""},[e._v("\n                    "+e._s(e.item.eatery.type.name)+" in "+e._s(e.item.eatery.town.town)+", "+e._s(e.item.eatery.county.county)+"\n                ")]),e._v(" "),s("stars",{staticClass:"my-2",attrs:{stars:e.item.overall_rating}})]:e._e(),e._v(" "),"recipes"===e.module?["grid"===e.layout?s("ul",{staticClass:"flex flex-wrap justify-center -mx-2"},e._l(e.item.features,(function(t){return s("li",{staticClass:"w-1/4 m-2 flex flex-col max-w-recipe-feature text-xs leading-none text-center"},[s("img",{staticClass:"lazy",attrs:{loading:"lazy","data-src":t.image,alt:t.feature,src:e.lazyLoadSrc}}),e._v(" "),s("span",{staticClass:"font-semibold mt-1"},[e._v(e._s(t.feature))])])})),0):e._e(),e._v(" "),s("p",{staticClass:"mb-1 flex font-semibold"},[e._v("\n                    Makes "+e._s(e.item.serving_size)),s("br"),e._v("\n                    "+e._s(e.item.nutrition.calories)+" Calories per "+e._s(e.item.per)+"\n                ")])]:e._e(),e._v(" "),s("p",{staticClass:"mb-1 flex-1 h-full",domProps:{innerHTML:e._s(e.description)}}),e._v(" "),s("div",{staticClass:"text-sm flex flex-wrap justify-between"},[s("p",[e._v(e._s(e.formatDate(e.item.created_at)))]),e._v(" "),"collection"!==e.module?s("p",{staticClass:"text-right",domProps:{textContent:e._s(e.commentsText(e.item.comments_count))}}):s("p",{staticClass:"text-right",domProps:{textContent:e._s(e.collectionItemsText(e.item.items_count))}})])],2)])])}),[],!1,null,null,null).exports;var x=s(538),y=s(3034);x.default.use(y.ZP);const b={data:function(){return{layout:"tiles",searchText:"",searchTimeout:null}},props:{title:{required:!0,type:String},currentLayout:{type:String,default:"tiles",validator:function(e){return-1!==["tiles","list"].indexOf(e)}},currentSearch:{type:String,default:""},urlPrefix:{required:!0,type:String},showFilterBar:{type:Boolean,default:function(){return!1}}},mounted:function(){var e=this;this.layout=this.currentLayout,this.searchText=this.currentSearch,this.$root.$on("reset-search",(function(){e.searchText=""}))},methods:{changeLayout:function(e){this.layout=e,this.$root.$emit("layout-change",e)},toggleFilter:function(){this.$root.$emit("toggle-filter-bar")}},watch:{searchText:function(e){var t=this;clearTimeout(this.searchTimeout),this.searchTimeout=setTimeout((function(){t.$root.$emit("module-search",e)}),500)},currentSearch:function(e){this.searchText=e}},computed:{feedUrl:function(){return"/".concat(this.urlPrefix,"/feed")}}};const _=(0,o.Z)(b,(function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"flex flex-col"},[s("div",{staticClass:"flex justify-between items-center p-2 text-2xl bg-blue-gradient-30 border-b-4 border-yellow rounded-t-lg leading-none"},[s("h1",{staticClass:"font-semibold font-coeliac pt-2"},[e._v("Coeliac Sanctuary "+e._s(e.title))]),e._v(" "),s("a",{directives:[{name:"tooltip",rawName:"v-tooltip.left",value:{content:"RSS Feed",classes:["bg-social-rss","text-white","rounded-lg","text-sm"]},expression:"{content: 'RSS Feed', classes: ['bg-social-rss', 'text-white', 'rounded-lg', 'text-sm']}",modifiers:{left:!0}}],staticClass:"pt-1 text-social-rss",attrs:{href:e.feedUrl,target:"_blank"}},[s("font-awesome-icon",{attrs:{icon:["fas","rss-square"]}})],1)]),e._v(" "),s("div",{staticClass:"w-full flex my-2 flex-col sm:flex-row"},[e.showFilterBar?s("div",{staticClass:"w-full flex items-center mb-1 sm:w-1/2 sm:mr-2 sm:mb-0 lg:w-1/3"},[s("input",{directives:[{name:"model",rawName:"v-model",value:e.searchText,expression:"searchText"}],staticClass:"text-sm p-1 flex-1 bg-grey-lightest border border-grey-off rounded",attrs:{type:"search",placeholder:"Search..."},domProps:{value:e.searchText},on:{input:function(t){t.target.composing||(e.searchText=t.target.value)}}})]):e._e(),e._v(" "),s("div",{staticClass:"flex justify-between items-center flex-1"},[s("div",{staticClass:"w-auto hidden md:block"},[s("div",{staticClass:"flex"},[s("div",{staticClass:"text-sm leading-none flex rounded-l-lg",class:"tiles"===e.layout?"bg-blue text-grey-lightest":"bg-white text-grey border border-blue cursor-pointer",on:{click:function(t){return e.changeLayout("tiles")}}},[s("span",{staticClass:"p-2 border-r",class:"tiles"===e.layout?"border-grey-lightest":"border-blue"},[e._v("Grid View")]),e._v(" "),s("span",{staticClass:"p-2"},[s("font-awesome-icon",{attrs:{icon:["fas","th"]}})],1)]),e._v(" "),s("div",{staticClass:"flex text-sm leading-none rounded-r-lg",class:"list"===e.layout?"bg-blue text-grey-lightest":"bg-white text-grey border border-blue cursor-pointer",on:{click:function(t){return e.changeLayout("list")}}},[s("span",{staticClass:"p-2 border-r",class:"list"===e.layout?"border-grey-lightest":"border-blue"},[e._v("List View")]),e._v(" "),s("span",{staticClass:"p-2"},[s("font-awesome-icon",{attrs:{icon:["fas","th-list"]}})],1)])])]),e._v(" "),s("div",{staticClass:"w-full sm:text-right md:w-auto md:p-2"},[e.showFilterBar?s("button",{staticClass:"w-full inline-block leading-none p-2 bg-blue rounded sm:w-auto",on:{click:function(t){return t.preventDefault(),e.toggleFilter()}}},[e._v("\n                    Filter "+e._s(e.title)+"\n                ")]):e._e()])])])])}),[],!1,null,null,null).exports;function C(e,t){return function(e){if(Array.isArray(e))return e}(e)||function(e,t){if("undefined"==typeof Symbol||!(Symbol.iterator in Object(e)))return;var s=[],r=!0,i=!1,n=void 0;try{for(var l,a=e[Symbol.iterator]();!(r=(l=a.next()).done)&&(s.push(l.value),!t||s.length!==t);r=!0);}catch(e){i=!0,n=e}finally{try{r||null==a.return||a.return()}finally{if(i)throw n}}return s}(e,t)||function(e,t){if(!e)return;if("string"==typeof e)return w(e,t);var s=Object.prototype.toString.call(e).slice(8,-1);"Object"===s&&e.constructor&&(s=e.constructor.name);if("Map"===s||"Set"===s)return Array.from(e);if("Arguments"===s||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(s))return w(e,t)}(e,t)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function w(e,t){(null==t||t>e.length)&&(t=e.length);for(var s=0,r=new Array(t);s<t;s++)r[s]=e[s];return r}const k={mixins:[i.Z,l.Z,n.Z],components:{loader:function(){return s.e(8540).then(s.bind(s,2287))},"module-filter-slider":p,"module-list-item":v,"module-list-top-bar":_,pagination:function(){return s.e(7929).then(s.bind(s,9720))}},props:{module:{required:!0,validator:function(e){return-1!==["blogs","collection","recipes","reviews"].indexOf(e)}},title:{required:!0,type:String},urlPrefix:{required:!0,type:String},showFilterBar:{type:Boolean,default:function(){return!0}}},data:function(){return{response:{current_page:1,last_page:1,prev_page_url:"",next_page_url:"",total:0},isLoading:!0,currentPage:1,layout:"tiles",showFilters:!1,availableFilters:[],filters:{},searchText:""}},mounted:function(){var e=this;this.showFilterBar&&(this.availableFilters=r[this.module],this.availableFilters.forEach((function(t){e.$set(e.filters,t.value,[])}))),this.parseUrl(),this.events(),this.loadData()},methods:{loadData:function(){var e=this;this.showFilters||(this.isLoading=!0),coeliac().request().get(this.buildUrl("/api/".concat(this.module),this.currentPage,this.searchText,this.filters)).then((function(t){e.response=t.data.data,e.isLoading=!1,window.history.pushState(null,null,e.buildUrl(window.location.href.split("?")[0],e.currentPage,e.searchText,e.filters,!0))}))},removeFilter:function(e,t){this.$root.$emit("remove-filter",{name:e,value:t})},clearSearch:function(){this.searchText="",this.$root.$emit("reset-search","")},events:function(){var e=this;this.$root.$on("pagination-click",(function(t){e.googleEvent("event",e.title,{event_category:"navigate-page",event_label:t}),"next"===t&&(t=e.currentPage+1),"prev"===t&&(t=e.currentPage-1),e.currentPage=t,e.loadData(),e.$scrollTo(e.$refs.items,500,{offset:-200})})),this.$root.$on("layout-change",(function(t){e.googleEvent("event",e.title,{event_category:"layout-change",event_label:t}),e.layout=t,e.loadLazyImages()})),this.$root.$on("add-filter",(function(t){e.googleEvent("event",e.title,{event_category:"added-filter",event_label:t.name}),t.single&&(e.filters[t.name]=[]),e.filters[t.name].push(t.value),e.currentPage=1,e.loadData()})),this.$root.$on("clear-filters",(function(){e.googleEvent("event",e.title,{event_category:"cleared-filters"}),e.availableFilters.forEach((function(t){e.filters[t.value]=[]})),e.currentPage=1,e.loadData()})),this.$root.$on("remove-filter",(function(t){e.googleEvent("event",e.title,{event_category:"removed-filter",event_label:t.name}),e.filters[t.name]=e.filters[t.name].filter((function(e){return e!==t.value})),e.loadData()})),this.$root.$on("toggle-filter-bar",(function(){e.showFilters=!e.showFilters})),this.$root.$on("module-search",(function(t){e.googleEvent("event",e.title,{event_category:"used-search",event_label:t}),e.searchText=t,e.loadData()}))},parseUrl:function(){var e=this,t=window.location.href.split("?o=");t.length>1&&atob(t[1]).split("&").forEach((function(t){var s=C(t.split("="),2),r=s[0],i=s[1];if("page"===r&&(e.currentPage=parseInt(i)),"search"===r&&(e.searchText=i),""!==i&&null!==/filter\[([a-z\-]+)\]/m.exec(r)){var n=/filter\[([a-z\-]+)\]/m.exec(r);e.filters[n[1]]=i.split(",")}}))}},computed:{hasFilters:function(){var e=this,t=!1;return""!==this.searchText&&(t=!0),Object.keys(this.filters).forEach((function(s){e.filters[s]&&e.filters[s].length>0&&(t=!0)})),t}}};const F=(0,o.Z)(k,(function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"page-box"},[e.showFilterBar?s("module-filter-slider",{attrs:{show:e.showFilters,title:e.title,"total-results":e.response.total,"current-filters":e.filters,"current-search":e.searchText}}):e._e(),e._v(" "),s("module-list-top-bar",{attrs:{title:e.title,currentLayout:e.layout,"url-prefix":e.urlPrefix,"show-filter-bar":e.showFilterBar,currentSearch:e.searchText}}),e._v(" "),s("pagination",{attrs:{current:e.response.current_page,lastPage:e.response.last_page,"can-go-back":!!e.response.prev_page_url,"can-go-forward":!!e.response.next_page_url}}),e._v(" "),e.showFilters?s("div",[s("ul",{staticClass:"flex -m-1"},[""!==e.searchText?s("li",{staticClass:"m-1 bg-blue-light rounded-lg text-xs overflow-hidden flex justify-between"},[s("div",{staticClass:"py-1 px-3"},[e._v("Search: "+e._s(e.searchText))]),e._v(" "),s("div",{staticClass:"bg-yellow py-1 px-3 cursor-pointer",on:{click:e.clearSearch}},[s("font-awesome-icon",{attrs:{icon:["fas","times"]}})],1)]):e._e(),e._v(" "),e._l(e.availableFilters,(function(t){return e._l(e.filters[t.value],(function(r){return s("li",{staticClass:"m-1 bg-blue-light rounded-lg text-xs overflow-hidden flex justify-between"},[s("div",{staticClass:"py-1 px-3"},[e._v(e._s(t.label)+": "+e._s(r))]),e._v(" "),s("div",{staticClass:"bg-yellow py-1 px-3 cursor-pointer",on:{click:function(s){return e.removeFilter(t.value,r)}}},[s("font-awesome-icon",{attrs:{icon:["fas","times"]}})],1)])}))}))],2)]):e._e(),e._v(" "),e.isLoading?s("div",{staticClass:"relative h-64"},[s("loader",{attrs:{show:!0}})],1):s("div",[s("div",{ref:"items",staticClass:"flex flex-col my-2 md:flex-row md:flex-wrap -mx-2"},e._l(e.response.data,(function(t,r){return s("module-list-item",{key:t.id,attrs:{module:e.module,item:t,index:r,page:e.currentPage,layout:e.layout,"has-filters":e.hasFilters}})})),1)]),e._v(" "),s("pagination",{attrs:{current:e.response.current_page,lastPage:e.response.last_page,"can-go-back":!!e.response.prev_page_url,"can-go-forward":!!e.response.next_page_url}})],1)}),[],!1,null,null,null).exports}}]);