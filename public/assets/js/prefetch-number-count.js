(self.webpackChunk=self.webpackChunk||[]).push([[5],{2500:(t,n,e)=>{"use strict";e.r(n),e.d(n,{default:()=>r});var i=e(666),s=e.n(i);const c={props:["to"],data:function(){return{count:0,interval:null}},computed:{increment:function(){return Math.ceil(this.to/30)}},mounted:function(){var t=this;s()(this.$el,(function(){t.interval=setInterval(t.tick,40)}))},methods:{tick:function(){if(this.count+this.increment>=this.to)return this.count=this.to,clearInterval(this.interval);this.count+=this.increment}}};const r=(0,e(1900).Z)(c,(function(){var t=this,n=t.$createElement;return(t._self._c||n)("span",{domProps:{textContent:t._s(t.count)}})}),[],!1,null,null,null).exports}}]);