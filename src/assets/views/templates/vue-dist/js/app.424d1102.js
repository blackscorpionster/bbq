(function(e){function t(t){for(var o,c,i=t[0],s=t[1],l=t[2],f=0,d=[];f<i.length;f++)c=i[f],Object.prototype.hasOwnProperty.call(a,c)&&a[c]&&d.push(a[c][0]),a[c]=0;for(o in s)Object.prototype.hasOwnProperty.call(s,o)&&(e[o]=s[o]);u&&u(t);while(d.length)d.shift()();return r.push.apply(r,l||[]),n()}function n(){for(var e,t=0;t<r.length;t++){for(var n=r[t],o=!0,i=1;i<n.length;i++){var s=n[i];0!==a[s]&&(o=!1)}o&&(r.splice(t--,1),e=c(c.s=n[0]))}return e}var o={},a={app:0},r=[];function c(t){if(o[t])return o[t].exports;var n=o[t]={i:t,l:!1,exports:{}};return e[t].call(n.exports,n,n.exports,c),n.l=!0,n.exports}c.m=e,c.c=o,c.d=function(e,t,n){c.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},c.r=function(e){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},c.t=function(e,t){if(1&t&&(e=c(e)),8&t)return e;if(4&t&&"object"===typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(c.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)c.d(n,o,function(t){return e[t]}.bind(null,o));return n},c.n=function(e){var t=e&&e.__esModule?function(){return e["default"]}:function(){return e};return c.d(t,"a",t),t},c.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},c.p="/";var i=window["webpackJsonp"]=window["webpackJsonp"]||[],s=i.push.bind(i);i.push=t,i=i.slice();for(var l=0;l<i.length;l++)t(i[l]);var u=s;r.push([0,"chunk-vendors"]),n()})({0:function(e,t,n){e.exports=n("56d7")},"23f3":function(e,t,n){},"56d7":function(e,t,n){"use strict";n.r(t);n("e260"),n("e6cf"),n("cca6"),n("a79d");var o=n("2b0e"),a=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("MobileMain")},r=[],c=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"h-100 d-flex flex-column",staticStyle:{"overflow-y":"hidden"},attrs:{id:"app"}},[e.token?e._e():n("div",[e._v(" You cannot access this page ")]),e.token?n("TopMenu",{on:{"current-page":function(t){return e.setCurrentPage(t)}}}):e._e(),e.token?n("b-container",{staticClass:"h-100",attrs:{fluid:"lg"}},[n("b-row",{staticClass:"h-100",staticStyle:{"overflow-y":"hidden"},attrs:{id:"contentArea"}},[n("b-col",{staticClass:"h-100 justify-content-center flex-grow-1",staticStyle:{"overflow-y":"scroll"}},[n("ContentArea",{attrs:{"current-page":e.currentPage}})],1)],1)],1):e._e()],1)},i=[],s=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("b-navbar",{attrs:{toggleable:"lg",type:"dark",variant:"dark"}},[n("b-navbar-brand",[e._v(e._s(e.user.firstName))]),n("b-navbar-toggle",{staticStyle:{"z-index":"90"},attrs:{target:"nav-collapse"}}),n("b-collapse",{attrs:{id:"nav-collapse","is-nav":""}},[n("b-navbar-nav",{staticClass:"ml-auto"},[n("div",[n("b-icon",{staticStyle:{margin:"15px"},attrs:{icon:"upc-scan","font-scale":"2"},on:{":click":function(t){return e.getScan("aaa")}}}),n("b-icon",{staticStyle:{margin:"15px"},attrs:{icon:"person-circle","font-scale":"2"},on:{click:function(t){return e.selectMenuOption("account")}}}),n("b-icon",{staticStyle:{margin:"15px"},attrs:{icon:"folder","font-scale":"2"},on:{click:function(t){return e.selectMenuOption("collections")}}}),n("b-icon",{staticStyle:{margin:"15px"},attrs:{icon:"heart","font-scale":"2"},on:{click:function(t){return e.selectMenuOption("favourites")}}}),n("b-icon",{staticStyle:{margin:"15px"},attrs:{icon:"power","font-scale":"2"},on:{click:function(t){return e.selectMenuOption("shutDown")}}})],1)])],1)],1)},l=[],u=(n("baa5"),n("ac1f"),n("466d"),n("1276"),n("bc3a")),f=n.n(u),d=o["default"].observable({token:null,user:{}}),p={setToken:function(e){d.token=e},serUser:function(e){d.user=e}},b=o["default"].extend({name:"TopMenu",data:function(){return{changingHash:!1,currentPage:"favourites"}},computed:{token:function(){return d.token},user:function(){return d.user}},mounted:function(){window.addEventListener("hashchange",this.onbarcode,!1),"zx"==window.location.hash.substr(1,2)&&(alert("Location ZX"),localStorage["barcode"]=decodeURI(window.location.hash.substr(3)),window.close(),self.close(),window.location.href="about:blank")},methods:{selectMenuOption:function(e){console.log("Opening >>> ",e),this.currentPage=e,this.$emit("current-page",e)},processBarcode:function(e){var t=this,n=JSON.stringify({code:e});return console.log("Data",n),f.a.post("http://10.1.1.52:8000/barcode/save",n,{headers:{"Content-Type":"application/json"}}).then((function(e){console.log(e.data),t.makeToast("Success","success")})).catch((function(e){console.error(e),t.makeToast("Error","danger")})),!0},getScan:function(){var e=window.location.href,t=e.lastIndexOf("#");t>0&&(e=e.substr(0,t)),window.addEventListener("storage",this.onbarcode,!1),setTimeout('window.removeEventListener("storage", onbarcode, false)',15e3),localStorage.removeItem("barcode"),navigator.userAgent.match(/Firefox/i)?window.location.href="zxing://scan/?ret="+encodeURIComponent(e+"#zx{CODE}"):navigator.userAgent.match(/Safari/i)&&!navigator.userAgent.match(/Chrome/i)?window.location.href="qrafter://scan/?browser=external&ret="+encodeURIComponent(e+"#zx{CODE}"):window.open("zxing://scan/?ret="+encodeURIComponent(e+"#zx{CODE}"))},onbarcode:function(e){switch(e.type){case"hashchange":if(1==this.changingHash)return;var t=window.location.hash;"#zx"==t.substr(0,3)&&(t=window.location.hash.substr(3),this.changingHash=!0,window.location.hash=e.oldURL.split("#")[1]||"",this.changingHash=!1,this.processBarcode(t));break;case"storage":alert("storage"),window.focus(),"barcode"==e.key&&(window.removeEventListener("storage",this.onbarcode,!1),this.processBarcode(e.newValue));break;default:console.log(e);break}},makeToast:function(e,t){console.log("Generating "+t+"toast"),this.$bvToast.toast(e,{title:"Barcode",variant:t,solid:!0,autoHideDelay:3e3})}}}),g=b,h=n("2877"),v=Object(h["a"])(g,s,l,!1,null,"55749c4d",null),m=v.exports,w=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",["collections"==e.currentPage?n("Collections"):e._e(),"favourites"==e.currentPage?n("Favourites"):e._e(),"account"==e.currentPage?n("Account"):e._e()],1)},y=[],x=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticStyle:{"text-align":"left"}},[n("b-row",[n("b-col",{staticStyle:{"text-align":"right"}},[n("b-icon",{staticStyle:{margin:"15px"},attrs:{icon:"folder-plus","font-scale":"2"}})],1)],1),e._l(10,(function(t){return n("b-row",{key:t},[n("b-col",[n("b-icon",{staticStyle:{margin:"15px"},attrs:{icon:"folder","font-scale":"4"}})],1),n("b-col",{attrs:{"align-self":"center"}},[e._v("new "+e._s(t))]),n("b-col",{attrs:{"align-self":"center"}},[n("b-icon",{attrs:{icon:"heart","font-scale":"2"}})],1)],1)}))],2)},_=[],k=o["default"].extend({name:"Collections"}),S=k,O=(n("c570"),Object(h["a"])(S,x,_,!1,null,"a154c570",null)),C=O.exports,j=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticStyle:{"text-align":"left"}},[n("b-row",[n("b-col",[n("b-icon",{staticStyle:{margin:"15px"},attrs:{icon:"folder","font-scale":"4"}})],1),n("b-col",{attrs:{"align-self":"center"}},[e._v("Restaurants")])],1),n("b-row",[n("b-col",[n("b-icon",{staticStyle:{margin:"15px"},attrs:{icon:"upc","font-scale":"4"}})],1),n("b-col",{attrs:{"align-self":"center"}},[e._v("Woollies points")])],1)],1)},M=[],P=o["default"].extend({name:"Favourites"}),E=P,T=Object(h["a"])(E,j,M,!1,null,"092f8c40",null),A=T.exports,$=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticStyle:{"text-align":"left"}},[n("b-row",[n("b-col",[e._v("Name:")]),n("b-col",[e._v("Guillermo")])],1),n("b-row",[n("b-col",[e._v("Email:")]),n("b-col",[e._v("ebuneli@gmail.com")])],1)],1)},z=[],D=o["default"].extend({name:"Account"}),U=D,I=Object(h["a"])(U,$,z,!1,null,"5f4d0d32",null),L=I.exports,R=o["default"].extend({name:"ContenArea",components:{Collections:C,Favourites:A,Account:L},props:{currentPage:{type:String,default:"favourites"}},mounted:function(){console.log("Content area started, page = ",this.currentPage)}}),H=R,B=Object(h["a"])(H,w,y,!1,null,"90b0d4ee",null),F=B.exports,J=o["default"].extend({name:"MobileMain",data:function(){return{currentPage:"favourites",token:null}},mounted:function(){var e=this;f.a.get("/init").then((function(t){console.log(t),e.token=t.data.token,p.setToken(e.token),p.serUser(t.data.user)})).catch((function(e){console.error(e)}))},components:{TopMenu:m,ContentArea:F},methods:{setCurrentPage:function(e){console.log("Main received page change value",e),"shutDown"===e?f.a.post("/logout",JSON.stringify({token:this.token}),{headers:{"Content-Type":"application/json"}}).then((function(e){console.log("Success",e),window.location.href="/"})).catch((function(e){alert("Cannot terminate session, contact support"),console.error(e)})):this.currentPage=e}}}),N=J,G=(n("bb0e"),Object(h["a"])(N,c,i,!1,null,"3a2ed7ba",null)),q=G.exports,V={name:"App",components:{MobileMain:q},mounted:function(){}},W=V,X=(n("8044"),Object(h["a"])(W,a,r,!1,null,"3e14ae4c",null)),Y=X.exports,Z=n("5f5b"),K=n("b1e0"),Q=(n("f9e3"),n("2dd8"),n("498a")),ee=n("f9bc"),te=n("331b"),ne=n("67b0"),oe=n("51c2");o["default"].config.productionTip=!1,o["default"].use(Z["a"]),o["default"].use(K["a"]),o["default"].use(Q["a"]),o["default"].use(ee["a"]),o["default"].use(te["a"]),o["default"].use(ne["a"]),o["default"].use(oe["a"]),new o["default"]({render:function(e){return e(Y)}}).$mount("#app")},8044:function(e,t,n){"use strict";var o=n("e08e"),a=n.n(o);a.a},bb0e:function(e,t,n){"use strict";var o=n("23f3"),a=n.n(o);a.a},c570:function(e,t,n){"use strict";var o=n("cdaf"),a=n.n(o);a.a},cdaf:function(e,t,n){},e08e:function(e,t,n){}});
//# sourceMappingURL=app.424d1102.js.map