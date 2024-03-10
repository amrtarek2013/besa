!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):e("object"==typeof module&&module.exports?require("jquery"):jQuery)}(function(e,s){"use strict";var t={background:"rgba(255, 255, 255, 0.8)",backgroundClass:"",image:'<svg> <image width="100" height="100" xlink:href="/img/1ea71_Loading_GIF_white.gif?v=11"/> </svg>',imageAnimation:"",imageAutoResize:!0,imageResizeFactor:1,imageColor:"#202020",imageClass:"",imageOrder:1,fontawesome:"",fontawesomeAnimation:"",fontawesomeAutoResize:!0,fontawesomeResizeFactor:1,fontawesomeColor:"#202020",fontawesomeOrder:2,custom:"",customAnimation:"",customAutoResize:!0,customResizeFactor:1,customOrder:3,text:"",textAnimation:"",textAutoResize:!0,textResizeFactor:.5,textColor:"#202020",textClass:"",textOrder:4,progress:!1,progressAutoResize:!0,progressResizeFactor:.25,progressColor:"#a0a0a0",progressClass:"",progressOrder:5,progressFixedPosition:"",progressSpeed:200,progressMin:0,progressMax:100,size:50,maxSize:120,minSize:20,direction:"column",fade:!0,resizeInterval:50,zIndex:2147483647},a={overlay:{"box-sizing":"border-box",position:"relative",display:"flex","flex-wrap":"nowrap","align-items":"center","justify-content":"center"},element:{"box-sizing":"border-box",overflow:"visible",flex:"0 0 auto",display:"flex","justify-content":"center","align-items":"center"},element_svg:{width:"100%",height:"100%"},progress_fixed:{position:"absolute",left:"0",width:"100%"},progress_wrapper:{position:"absolute",top:"0",left:"0",width:"100%",height:"100%"},progress_bar:{position:"absolute",left:"0"}},o={count:0,container:s,settings:s,wholePage:s,resizeIntervalId:s,text:s,progress:s},i={animations:["rotate_right","rotate_left","fadein","pulse"],progressPosition:["top","bottom"]},r={animations:{name:"rotate_right",time:"2000ms"},fade:[400,200]};function n(s,t){s=e(s),t.size=x(t.size),t.maxSize=parseInt(t.maxSize,10)||0,t.minSize=parseInt(t.minSize,10)||0,t.resizeInterval=parseInt(t.resizeInterval,10)||0;var i=$(s),n=f(s);if(!1===n){if((n=e.extend({},o)).container=s,n.wholePage=s.is("body"),i=e("<div>",{class:"loadingoverlay"}).css(a.overlay).css("flex-direction","row"===t.direction.toLowerCase()?"row":"column"),t.backgroundClass?i.addClass(t.backgroundClass):i.css("background",t.background),n.wholePage&&i.css({position:"fixed",top:0,left:0,width:"100%",height:"100%"}),void 0!==t.zIndex&&i.css("z-index",t.zIndex),t.image){e.isArray(t.imageColor)?0===t.imageColor.length?t.imageColor=!1:1===t.imageColor.length?t.imageColor={fill:t.imageColor[0]}:t.imageColor={fill:t.imageColor[0],stroke:t.imageColor[1]}:t.imageColor&&(t.imageColor={fill:t.imageColor});var l=p(i,t.imageOrder,t.imageAutoResize,t.imageResizeFactor,t.imageAnimation);"<svg"===t.image.slice(0,4).toLowerCase()&&"</svg>"===t.image.slice(-6).toLowerCase()?(l.append(t.image),l.children().css(a.element_svg),!t.imageClass&&t.imageColor&&l.find("*").css(t.imageColor)):".svg"===t.image.slice(-4).toLowerCase()||"data:image/svg"===t.image.slice(0,14).toLowerCase()?e.ajax({url:t.image,type:"GET",dataType:"html",global:!1}).done(function(e){l.html(e),l.children().css(a.element_svg),!t.imageClass&&t.imageColor&&l.find("*").css(t.imageColor)}):l.css({"background-image":"url("+t.image+")","background-position":"center","background-repeat":"no-repeat","background-size":"cover"}),t.imageClass&&l.addClass(t.imageClass)}if(t.fontawesome){var l=p(i,t.fontawesomeOrder,t.fontawesomeAutoResize,t.fontawesomeResizeFactor,t.fontawesomeAnimation).addClass("loadingoverlay_fa");e("<div>",{class:t.fontawesome}).appendTo(l),t.fontawesomeColor&&l.css("color",t.fontawesomeColor)}if(t.custom)var l=p(i,t.customOrder,t.customAutoResize,t.customResizeFactor,t.customAnimation).append(t.custom);if(t.text&&(n.text=p(i,t.textOrder,t.textAutoResize,t.textResizeFactor,t.textAnimation).addClass("loadingoverlay_text").text(t.text),t.textClass?n.text.addClass(t.textClass):t.textColor&&n.text.css("color",t.textColor)),t.progress){var l=p(i,t.progressOrder,t.progressAutoResize,t.progressResizeFactor,!1).addClass("loadingoverlay_progress"),g=e("<div>").css(a.progress_wrapper).appendTo(l);n.progress={bar:e("<div>").css(a.progress_bar).appendTo(g),fixed:!1,margin:0,min:parseFloat(t.progressMin),max:parseFloat(t.progressMax),speed:parseInt(t.progressSpeed,10)};var d=(t.progressFixedPosition+"").replace(/\s\s+/g," ").toLowerCase().split(" ");2===d.length&&_(d[0])?(n.progress.fixed=d[0],n.progress.margin=x(d[1])):2===d.length&&_(d[1])?(n.progress.fixed=d[1],n.progress.margin=x(d[0])):1===d.length&&_(d[0])&&(n.progress.fixed=d[0],n.progress.margin=0),"top"===n.progress.fixed?l.css(a.progress_fixed).css("top",n.progress.margin?n.progress.margin.value+(n.progress.margin.fixed?n.progress.margin.units:"%"):0):"bottom"===n.progress.fixed&&l.css(a.progress_fixed).css("top","auto"),t.progressClass?n.progress.bar.addClass(t.progressClass):t.progressColor&&n.progress.bar.css("background",t.progressColor)}t.fade?!0===t.fade?t.fade=r.fade:"string"==typeof t.fade||"number"==typeof t.fade?t.fade=[t.fade,t.fade]:e.isArray(t.fade)&&t.fade.length<2&&(t.fade=[t.fade[0],t.fade[0]]):t.fade=[0,0],t.fade=[parseInt(t.fade[0],10),parseInt(t.fade[1],10)],n.settings=t,i.data("loadingoverlay_data",n),s.data("loadingoverlay",i),i.fadeTo(0,.01).appendTo("body"),c(s,!0),t.resizeInterval>0&&(n.resizeIntervalId=setInterval(function(){c(s,!1)},t.resizeInterval)),i.fadeTo(t.fade[0],1)}n.count++}function l(s,t){s=e(s);var a=$(s),o=f(s);!1!==o&&(o.count--,(t||o.count<=0)&&a.animate({opacity:0},o.settings.fade[1],function(){o.resizeIntervalId&&clearInterval(o.resizeIntervalId),e(this).remove(),s.removeData("loadingoverlay")}))}function g(s){c(e(s),!0)}function d(s,t){s=e(s);var a=f(s);!1!==a&&a.text&&(!1===t?a.text.hide():a.text.show().text(t))}function m(s,t){s=e(s);var a=f(s);if(!1!==a&&a.progress){if(!1===t)a.progress.bar.hide();else{var o=((parseFloat(t)||0)-a.progress.min)*100/(a.progress.max-a.progress.min);o<0&&(o=0),o>100&&(o=100),a.progress.bar.show().animate({width:o+"%"},a.progress.speed)}}}function c(s,t){var a=$(s),o=f(s);if(!1!==o){if(!o.wholePage){var i="fixed"===s.css("position"),r=i?s[0].getBoundingClientRect():s.offset();a.css({position:i?"fixed":"absolute",top:r.top+parseInt(s.css("border-top-width"),10),left:r.left+parseInt(s.css("border-left-width"),10),width:s.innerWidth(),height:s.innerHeight()})}if(o.settings.size){var n=o.wholePage?e(window):s,l=o.settings.size.value;!o.settings.size.fixed&&(l=Math.min(n.innerWidth(),n.innerHeight())*l/100,o.settings.maxSize&&l>o.settings.maxSize&&(l=o.settings.maxSize),o.settings.minSize&&l<o.settings.minSize&&(l=o.settings.minSize)),a.children(".loadingoverlay_element").each(function(){var s=e(this);if(t||s.data("loadingoverlay_autoresize")){var a=s.data("loadingoverlay_resizefactor");s.hasClass("loadingoverlay_fa")||s.hasClass("loadingoverlay_text")?s.css("font-size",l*a+o.settings.size.units):s.hasClass("loadingoverlay_progress")?(o.progress.bar.css("height",l*a+o.settings.size.units),o.progress.fixed?"bottom"===o.progress.fixed&&s.css("bottom",o.progress.margin?o.progress.margin.value+(o.progress.margin.fixed?o.progress.margin.units:"%"):0).css("bottom","+="+l*a+o.settings.size.units):o.progress.bar.css("top",s.position().top).css("top","-="+l*a*.5+o.settings.size.units)):s.css({width:l*a+o.settings.size.units,height:l*a+o.settings.size.units})}})}}}function $(e){return e.data("loadingoverlay")}function f(t){var a=$(t),o=void 0===a?s:a.data("loadingoverlay_data");return void 0===o?(e(".loadingoverlay").each(function(){var s=e(this),t=s.data("loadingoverlay_data");document.body.contains(t.container[0])||(t.resizeIntervalId&&clearInterval(t.resizeIntervalId),s.remove())}),!1):(a.toggle(t.is(":visible")),o)}function p(s,t,o,i,n){var l=e("<div>",{class:"loadingoverlay_element",css:{order:t}}).css(a.element).data({loadingoverlay_autoresize:o,loadingoverlay_resizefactor:i}).appendTo(s);if(!0===n&&(n=r.animations.time+" "+r.animations.name),"string"==typeof n){var g,d,m=n.replace(/\s\s+/g," ").toLowerCase().split(" ");2===m.length&&u(m[0])&&v(m[1])?(g=m[1],d=m[0]):2===m.length&&u(m[1])&&v(m[0])?(g=m[0],d=m[1]):1===m.length&&u(m[0])?(g=r.animations.name,d=m[0]):1===m.length&&v(m[0])&&(g=m[0],d=r.animations.time),l.css({"animation-name":"loadingoverlay_animation__"+g,"animation-duration":d,"animation-timing-function":"linear","animation-iteration-count":"infinite"})}return l}function u(e){return!isNaN(parseFloat(e))&&("s"===e.slice(-1)||"ms"===e.slice(-2))}function v(e){return i.animations.indexOf(e)>-1}function _(e){return i.progressPosition.indexOf(e)>-1}function x(e){return!!e&&!(e<0)&&("string"==typeof e&&["vmin","vmax"].indexOf(e.slice(-4))>-1?{fixed:!0,units:e.slice(-4),value:e.slice(0,-4)}:"string"==typeof e&&["rem"].indexOf(e.slice(-3))>-1?{fixed:!0,units:e.slice(-3),value:e.slice(0,-3)}:"string"==typeof e&&["px","em","cm","mm","in","pt","pc","vh","vw"].indexOf(e.slice(-2))>-1?{fixed:!0,units:e.slice(-2),value:e.slice(0,-2)}:{fixed:!1,units:"px",value:parseFloat(e)})}e.LoadingOverlaySetup=function(s){e.extend(!0,t,s)},e.LoadingOverlay=function(s,a){switch(s.toLowerCase()){case"show":n("body",e.extend(!0,{},t,a));break;case"hide":l("body",a);break;case"resize":g("body",a);break;case"text":d("body",a);break;case"progress":m("body",a)}},e.fn.LoadingOverlay=function(s,a){switch(s.toLowerCase()){case"show":var o=e.extend(!0,{},t,a);return this.each(function(){n(this,o)});case"hide":return this.each(function(){l(this,a)});case"resize":return this.each(function(){g(this,a)});case"text":return this.each(function(){d(this,a)});case"progress":return this.each(function(){m(this,a)})}},e(function(){e("head").append("<style> @-webkit-keyframes loadingoverlay_animation__rotate_right { to { -webkit-transform : rotate(360deg); transform : rotate(360deg); } } @keyframes loadingoverlay_animation__rotate_right { to { -webkit-transform : rotate(360deg); transform : rotate(360deg); } } @-webkit-keyframes loadingoverlay_animation__rotate_left { to { -webkit-transform : rotate(-360deg); transform : rotate(-360deg); } } @keyframes loadingoverlay_animation__rotate_left { to { -webkit-transform : rotate(-360deg); transform : rotate(-360deg); } } @-webkit-keyframes loadingoverlay_animation__fadein { 0% { opacity   : 0; -webkit-transform : scale(0.1, 0.1); transform : scale(0.1, 0.1); } 50% { opacity   : 1; } 100% { opacity   : 0; -webkit-transform : scale(1, 1); transform : scale(1, 1); } } @keyframes loadingoverlay_animation__fadein { 0% { opacity   : 0; -webkit-transform : scale(0.1, 0.1); transform : scale(0.1, 0.1); } 50% { opacity   : 1; } 100% { opacity   : 0; -webkit-transform : scale(1, 1); transform : scale(1, 1); } } @-webkit-keyframes loadingoverlay_animation__pulse { 0% { -webkit-transform : scale(0, 0); transform : scale(0, 0); } 50% { -webkit-transform : scale(1, 1); transform : scale(1, 1); } 100% { -webkit-transform : scale(0, 0); transform : scale(0, 0); } } @keyframes loadingoverlay_animation__pulse { 0% { -webkit-transform : scale(0, 0); transform : scale(0, 0); } 50% { -webkit-transform : scale(1, 1); transform : scale(1, 1); } 100% { -webkit-transform : scale(0, 0); transform : scale(0, 0); } } </style>")})});