$(document).ready(function () {
  "use strict";

  // Cache selectors
  var $document = $(document),
      $window = $(window),
      $body = $('body'),
      $sidenav = $('.sidenav'),
      $overlay = $('.overlay'),
      $liSearch = $('.li-search'),
      $sideFilter = $('#sideFilter'),
      $pageOverlay = $('#pageOverlay'),
      $dropDownUser = $('.drop-down-user'),
      $tabButton = $('.tab-button'),
      $tabContent = $('.tab-content'),
      $scrollToTop = $('#scrollToTop'),
      $faqQuestion = $('.faq-question'),
      $faqIcon = $('.faq-icon');

  // Throttle function to limit how often a function can fire
  function throttle(func, limit) {
    var lastFunc,
        lastRan;
    return function () {
      var context = this,
          args = arguments;
      if (!lastRan) {
        func.apply(context, args);
        lastRan = Date.now();
      } else {
        clearTimeout(lastFunc);
        lastFunc = setTimeout(function () {
          if ((Date.now() - lastRan) >= limit) {
            func.apply(context, args);
            lastRan = Date.now();
          }
        }, limit - (Date.now() - lastRan));
      }
    }
  }

  // Delegated events
  $body.on('click', function (e) {
    var $target = $(e.target);
    
    // Toggle side navigation for mobile
    if ($target.closest('.navbar-mobile .toggle').length || $target.closest('.sidenav .close').length) {
      $sidenav.toggleClass('open');
      $overlay.toggleClass('visible');
    }

    // Toggle search visibility
    else if ($target.is('.toggle-search')) {
      $liSearch.toggleClass('show');
    }

    // Toggle subject active class
    else if ($target.is('.grid-subjects .subject')) {
      $target.addClass('active').siblings().removeClass('active');
    }

    // Toggle filter and overlay visibility
    else if ($target.is('.btn-filter') || $target.is('#pageOverlay') || $target.closest('.side-filter .close').length) {
      $sideFilter.toggleClass('show');
      $pageOverlay.toggleClass('visible');
    }

    // User dropdown toggle
    else if ($target.closest('.details-user .header-details').length) {
      $dropDownUser.toggleClass('show');
    }

    // FAQ toggle
    else if ($target.closest('.faq-question').length) {
      $target.next('.faq-answer').slideToggle('slow');
      var imgSrc = $target.find($faqIcon).attr('src');
      $target.find($faqIcon).attr('src', imgSrc.includes('plus-icon') 
        ? imgSrc.replace('plus-icon.svg', 'minus-icon.svg')
        : imgSrc.replace('minus-icon.svg', 'plus-icon.svg')
      );
    }

    // Tab activation
    else if ($target.is('.tab-button')) {
      var $this = $target,
          $targetContent = $($this.data('tab-target'));

      $tabButton.removeClass('active');
      $tabContent.removeClass('active');

      $this.addClass('active');
      $targetContent.addClass('active');
    }

    // Scroll to top functionality
    else if ($target.is('#scrollToTop')) {
      $('html, body').animate({ scrollTop: 0 }, 'smooth');
    }

    // Increment and decrement functionality
    else if ($target.is('.increment, .decrement')) {
      const isDecrement = $target.is('.decrement');
      const $input = $target.closest('.input-group').find('input');
      if ($input.is('input')) {
        $input[0][isDecrement ? 'stepDown' : 'stepUp']();
      }
    }

    // Prevent form non-submit buttons from doing anything
    else if ($target.is('form button:not([type="submit"])')) {
      e.preventDefault();
    }
  });

  // Reveal on scroll
  function revealOnScroll() {
    $('.have-animations').each(function () {
      var $this = $(this),
          windowHeight = $window.height(),
          elementTop = $this.offset().top,
          elementVisible = 150;

      if (elementTop < windowHeight - elementVisible) {
        $this.addClass('animated');
      } else {
        $this.removeClass('animated');
      }
    });
  }

  // Scroll event with throttling
  $window.scroll(throttle(revealOnScroll, 100));

   // Slider initializations
   $('.main-slider').owlCarousel({
    items: 1,
    loop: true,
    margin: 10,
    nav: true,
    autoplay: true,
    autoplayTimeout: 2000,
    navText: ["<img src='../img/new-desgin/prev-arrow-white.svg'>", "<img src='../img/new-desgin/next-arrow-white.svg'>"]
  });
  var customeSlider = $(".custome-slider");
  customeSlider.owlCarousel({
    loop: true,
    margin: 10,
    dots: true,
    nav: false,
    items: 1,
  });

  var ukslider = $(".ukslider");
  ukslider.owlCarousel({
    items: 1,
    loop: true,
    margin: 10,
    dots: true,
    nav: false,
    autoplay: true,
    autoPlaySpeed: 2000,
    autoPlayTimeout: 2000,
    autoplayHoverPause: true,
  });
  var lifeBesaslider = $(".owl-lifeBesa");

  lifeBesaslider.owlCarousel({
    loop: true,
    margin: 40,
    dots: true,
    nav: true,
    navText: [
      "<img src='./img/chevron-right.svg'>",
      "<img src='./img/chevron-left.svg'>",
    ],
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 2,
      },
      1000: {
        items: 3,
      },
    },
  });
  var owlSchoolTour = $(".owl-school-tour");

  owlSchoolTour.owlCarousel({
    items: 1,
    loop: true,
    nav: true,
    navText: [
      "<img src='../img/new-desgin/prev-arrow.svg'>",
      "<img src='../img/new-desgin/next-arrow.svg'>",
    ],
  });

  var owlStepBack = $(".owl-step-back");
  owlStepBack.owlCarousel({
    items: 1,
    loop: true,
    nav: true,
    autoplay: true,
    autoPlaySpeed: 2000,
    autoPlayTimeout: 2000,
    autoplayHoverPause: true,
    navText: [
      "<img src='../img/new-desgin/prev-arrow.svg'>",
      "<img src='../img/new-desgin/next-arrow.svg'>",
    ],
  });
  var owlSmallFlag = $(".owl-small-flag-logo");
  owlSmallFlag.owlCarousel({
    loop: true,
    margin: 20,
    nav: true,
    dots: false,
    autoplay: true,
    autoPlaySpeed: 2000,
    autoPlayTimeout: 2000,
    autoplayHoverPause: true,
    navText: [
      "<img src='../img/chevron-right-white.svg'>",
      "<img src='../img/chevron-left-white.svg'>",
    ],
    responsive: {
      0: {
        items: 3,
      },
      600: {
        items: 3,
      },
      1000: {
        items: 4,
      },
    },
  });
  var owlLogosSlider = $(".owl-logos-slider");
  owlLogosSlider.owlCarousel({
    loop: true,
    margin: 25,
    nav: false,
    navText: [
      "<img src='../img/chevron-right-white.svg'>",
      "<img src='../img/chevron-left-white.svg'>",
    ],
    autoplay: true,
    autoPlaySpeed: 2100,
    autoPlayTimeout: 2100,
    autoplayHoverPause: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 4,
      },
      1000: {
        items: 4,
      },
    },
  });

  var owlTopUniversities = $(".owl-topUni");
  owlTopUniversities.owlCarousel({
    loop: true,
    margin: 25,
    nav: false,
    stagePadding: 60,
    autoplay: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 1,
      },
      1000: {
        items: 3,
      },
    },
  });

  // Function to initialize a generic slider
  function initOwlCarousel(selector, options) {
    $(selector).owlCarousel(options);
  }

  // Call this function to initialize all your sliders
  function initAllSliders() {
    initOwlCarousel('.custome-slider', {
      loop: true,
      margin: 10,
      nav: false,
      dots: true,
      items: 1
    });

    initOwlCarousel('.ukslider', {
      items: 1,
      loop: true,
      margin: 10,
      dots: true,
      nav: false,
      autoplay: true,
      autoplayTimeout: 2000
    });

    initOwlCarousel('.owl-school-tour', {
      items: 1,
      loop: true,
      nav: true,
      navText: ["<img src='../img/new-desgin/prev-arrow.svg'>", "<img src='../img/new-desgin/next-arrow.svg'>"]
    });

    // Continue initializing other sliders with the 'initOwlCarousel' function
    // ...
  }

  // Initialize all sliders
  initAllSliders();

});
