function togglePasswordVisibility(e){const s=document.getElementById(e),t=s.parentNode.querySelector(".toggle-password");"password"===s.type?(s.type="text",t.classList.remove("fa-eye"),t.classList.add("fa-eye-slash")):(s.type="password",t.classList.remove("fa-eye-slash"),t.classList.add("fa-eye"))}$(document).ready(function(){"use strict";var e=$(".sidenav"),s=$(".overlay"),t=$(".toggle-search"),o=$(".li-search");$(".navbar-mobile").on("click",".toggle",function(){e.toggleClass("open"),s.toggleClass("visible")}),e.on("click",".close",function(){e.removeClass("open"),s.removeClass("visible")}),t.on("click",function(){o.toggleClass("show")});var i=$(".grid-subjects");i.on("click",".subject",function(){this.classList.add("active"),i.find(".subject.active").not(this).each(function(){this.classList.remove("active")})});var n=$("#sideFilter"),a=$("#pageOverlay");$(document).on("click",".btn-filter, #pageOverlay, .side-filter .close",function(){n.toggleClass("show"),a.toggleClass("visible")}),$(".details-user .header-details").click(function(){$(".drop-down-user").toggleClass("show")});$(document).on("click",".faq-question",function(){$(this).next(".faq-answer").slideToggle("slow");var e=$(this).find(".faq-icon");e.attr("src","/img/new-desgin/plus-icon.svg"===e.attr("src")?"/img/new-desgin/minus-icon.svg":"/img/new-desgin/plus-icon.svg")});var l=$(".tab-button"),r=$(".tab-content");$(document).on("click",".tab-button",function(){var e=$(this),s=$(e.data("tab-target"));e.hasClass("active")||(l.removeClass("active"),r.removeClass("active"),e.addClass("active"),s.addClass("active"))}),$(".carousel-blogs, .carousel-testimonials").each(function(){!function(e){var s=setInterval(function(){a(e,"clockwise")},22e3),t=1,o=0,i=e.find(">li").length,n=i;function a(e,s){var i=s,a=e.find(">li").length;if("counter-clockwise"==i){var l=e.find(".left-pos").attr("id")-1;0==l&&(l=a),e.find(".right-pos").removeClass("right-pos").addClass("back-pos"),e.find(".main-pos").removeClass("main-pos").addClass("right-pos"),e.find(".left-pos").removeClass("left-pos").addClass("main-pos"),e.find("#"+l).removeClass("back-pos").addClass("left-pos"),--t<1&&(t=a)}if("clockwise"==i||""==i||null==i){function r(e){return"leftposition"!=e&&t+ ++o>n&&(o=1-t),"leftposition"==e&&(o=t-1)<1&&(o=a),o}e.find("#"+t).removeClass("main-pos").addClass("left-pos"),e.find("#"+(t+r())).removeClass("right-pos").addClass("main-pos"),e.find("#"+(t+r())).removeClass("back-pos").addClass("right-pos"),e.find("#"+r("leftposition")).removeClass("left-pos").addClass("back-pos"),o=0,++t>a&&(t=1)}}e.hover(function(){clearInterval(s)},function(){s=setInterval(function(){a(e,"clockwise")},7e3)}),e.parent().find("#next").click(function(){a(e,"clockwise")}),e.parent().find("#prev").click(function(){a(e,"counter-clockwise")}),e.find(">li").click(function(){$(this).hasClass("left-pos")?a(e,"counter-clockwise"):a(e,"clockwise")})}($(this))});var c={loop:!0,autoplay:!0,autoplaySpeed:2e3,autoplayTimeout:2e3,autoplayHoverPause:!0,lazyLoad:!0,nav:!0,items:1,navText:["<div class='nav-btn prev-slide'></div>","<div class='nav-btn next-slide'></div>"]};$(".main-slider").owlCarousel($.extend({},c,{margin:10,dots:!1,navText:["<img src='../img/new-desgin/prev-arrow-white.svg'>","<img src='../img/new-desgin/next-arrow-white.svg'>"]})),$(".custome-slider").owlCarousel($.extend({},c,{nav:!1,dots:!0})),$(".ukslider").owlCarousel($.extend({},c,{dots:!0,nav:!1})),$(".owl-lifeBesa").owlCarousel($.extend({},c,{dots:!1,nav:!0,margin:40,navText:["<img src='./img/chevron-right.svg'>","<img src='./img/chevron-left.svg'>"],responsive:{0:{items:1},600:{items:2},1000:{items:3}}})),$(".owl-school-tour").owlCarousel($.extend({},c,{dots:!1,nav:!0,navText:["<img src='../img/new-desgin/prev-arrow.svg'>","<img src='../img/new-desgin/next-arrow.svg'>"]})),$(".owl-step-back").owlCarousel($.extend({},c,{dots:!1,nav:!0,navText:["<img src='../img/new-desgin/prev-arrow.svg'>","<img src='../img/new-desgin/next-arrow.svg'>"]})),$(".owl-small-flag-logo").owlCarousel($.extend({},c,{dots:!1,nav:!0,margin:20,navText:["<img src='../img/chevron-right-white.svg'>","<img src='../img/chevron-left-white.svg'>"],responsive:{0:{items:1},600:{items:3},1000:{items:4}}})),$(".owl-logos-slider").owlCarousel($.extend({},c,{dots:!1,margin:25,nav:!0,navText:["<img src='../img/chevron-right-white.svg'>","<img src='../img/chevron-left-white.svg'>"],responsive:{0:{items:1},600:{items:3},1000:{items:4}}})),$(".owl-topUni").owlCarousel($.extend({},c,{dots:!0,nav:!1,margin:25,stagePadding:60,responsive:{0:{items:1},600:{items:2},1000:{items:3}}})),$(".ukslider").owlCarousel($.extend({},c,{dots:!0,nav:!1})),$("#scrollToTop").on("click",function(){window.scrollTo({top:0,behavior:"smooth"})}),$(window).scroll(function(){$(this).scrollTop()>3e3?$("#scrollToTop").fadeIn():$("#scrollToTop").fadeOut()}).trigger("scroll")});var buttons=document.querySelectorAll('form button:not([type="submit"])');for(i=0;i<buttons.length;i++)buttons[i].addEventListener("click",function(e){e.preventDefault()});$("form").on("click",'button:not([type="submit"])',function(e){e.preventDefault()}),$(".increment, .decrement").on("click",function(e){const s=$(e.target).closest(".decrement").is(".decrement"),t=$(e.target).closest(".input-group").find("input");t.is("input")&&t[0][s?"stepDown":"stepUp"]()});