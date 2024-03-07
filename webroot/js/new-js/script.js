$(document).ready(function () {
  "use strict";

  // Cache jQuery selectors
  var $sidenav = $(".sidenav");
  var $overlay = $(".overlay");
  var $toggleSearch = $(".toggle-search");
  var $liSearch = $(".li-search");

  // Event delegation for toggling the sidenav
  $(".navbar-mobile").on("click", ".toggle", function () {
    $sidenav.toggleClass("open");
    $overlay.toggleClass("visible");
  });

  // Event delegation for closing the sidenav
  $sidenav.on("click", ".close", function () {
    $sidenav.removeClass("open");
    $overlay.removeClass("visible");
  });

  $toggleSearch.on("click", function () {
    $liSearch.toggleClass("show");
  });

  // Cache the jQuery selector if .grid-subjects does not change
  var $gridSubjects = $(".grid-subjects");

  // Delegate the click event to the parent .grid-subjects
  $gridSubjects.on("click", ".subject", function () {
    // Use native classList for performance
    this.classList.add("active");

    // Get the previously active element and remove the 'active' class
    var $active = $gridSubjects.find(".subject.active").not(this);
    $active.each(function () {
      this.classList.remove("active");
    });
  });

  // Cache the jQuery selectors
  var $sideFilter = $("#sideFilter");
  var $pageOverlay = $("#pageOverlay");

  // A function to toggle the classes
  function toggleFilterAndOverlay() {
    $sideFilter.toggleClass("show");
    $pageOverlay.toggleClass("visible");
  }

  // Delegate events if there are multiple elements, otherwise, just attach events
  $(document).on(
    "click",
    ".btn-filter, #pageOverlay, .side-filter .close",
    toggleFilterAndOverlay
  );

  $(".details-user .header-details").click(function () {
    $(".drop-down-user").toggleClass("show");
  });

  // Pre-cache the image paths to avoid repetitive string operations
  var plusIconPath = "/img/new-desgin/plus-icon.svg";
  var minusIconPath = "/img/new-desgin/minus-icon.svg";

  // Use event delegation to handle dynamic or multiple .faq-question elements
  // This way, only a single event listener is needed for all current and future .faq-questions
  $(document).on("click", ".faq-question", function () {
    // Toggle the next .faq-answer element
    $(this).next(".faq-answer").slideToggle("slow");

    // Cache the jQuery selector for the .faq-icon for reuse
    var $faqIcon = $(this).find(".faq-icon");

    // Use the cached image paths and perform a boolean check instead of string includes
    // This reduces the need for accessing the DOM attribute repeatedly
    $faqIcon.attr(
      "src",
      $faqIcon.attr("src") === plusIconPath ? minusIconPath : plusIconPath
    );
  });

  // Cache the jQuery selectors
  var $tabButtons = $(".tab-button");
  var $tabContents = $(".tab-content");

  // Use event delegation
  $(document).on("click", ".tab-button", function () {
    var $this = $(this); // No need to cache this again if it's only used once
    var $target = $($this.data("tab-target")); // Cache the target content

    // Only remove 'active' class if the clicked tab isn't already active
    if (!$this.hasClass("active")) {
      $tabButtons.removeClass("active");
      $tabContents.removeClass("active");

      $this.addClass("active");
      $target.addClass("active");
    }
  });

  // function reveal() {
  //   var reveals = document.querySelectorAll(".have-animations");

  //   for (var i = 0; i < reveals.length; i++) {
  //     var windowHeight = window.innerHeight;
  //     var elementTop = reveals[i].getBoundingClientRect().top;
  //     var elementVisible = 150;

  //     if (elementTop < windowHeight - elementVisible) {
  //       reveals[i].classList.add("animated");
  //     } else {
  //       reveals[i].classList.remove("animated");
  //     }
  //   }
  // }
  // window.addEventListener("scroll", reveal);

  // Debounce function to limit the rate at which a function can fire.
  function debounce(func, wait, immediate) {
    var timeout;
    return function () {
      var context = this,
        args = arguments;
      var later = function () {
        timeout = null;
        if (!immediate) func.apply(context, args);
      };
      var callNow = immediate && !timeout;
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
      if (callNow) func.apply(context, args);
    };
  }

  // Function to initialize each slider
  function initSlider($slider) {
    var itemCount = $slider.children("li").length;
    var autoSwap = setInterval(next, 22000);
    var startItem = 1;

    function setPosition() {
      var position = startItem % itemCount || itemCount;
      return position;
    }

    function next() {
      swap($slider, "clockwise");
    }

    function prev() {
      swap($slider, "counter-clockwise");
    }

    function resetAutoSwap() {
      clearInterval(autoSwap);
      autoSwap = setInterval(next, 22000);
    }

    function swap($slider, direction) {
      var $items = $slider.children("li");
      var position = setPosition();

      $items.removeClass("left-pos main-pos right-pos back-pos");

      if (direction === "clockwise") {
        $slider.children("#" + position).addClass("left-pos");
        $slider
          .children("#" + ((position % itemCount) + 1))
          .addClass("main-pos");
        $slider
          .children("#" + (((position + 1) % itemCount) + 1))
          .addClass("right-pos");
        $slider
          .children("#" + ((position - 2 + itemCount) % itemCount || itemCount))
          .addClass("back-pos");
        startItem++;
      } else {
        $slider
          .children("#" + ((position - 2 + itemCount) % itemCount || itemCount))
          .addClass("left-pos");
        $slider.children("#" + position).addClass("main-pos");
        $slider
          .children("#" + ((position % itemCount) + 1))
          .addClass("right-pos");
        $slider
          .children("#" + ((position - 3 + itemCount) % itemCount || itemCount))
          .addClass("back-pos");
        startItem--;
      }
    }

    $slider.on(
      "hover",
      debounce(function (event) {
        if (event.type === "mouseenter") {
          clearInterval(autoSwap);
        } else {
          resetAutoSwap();
        }
      }, 300)
    );

    $slider.parent().on("click", "#next", debounce(next, 300));
    $slider.parent().on("click", "#prev", debounce(prev, 300));

    $slider.children("li").on("click", function () {
      if ($(this).hasClass("left-pos")) {
        prev();
      } else {
        next();
      }
    });
  }

  // Initialize each carousel on the page
  $(".carousel-blogs, .carousel-testimonials").each(function () {
    initSlider($(this));
  });

  // Base configuration for all carousels
  var baseCarouselConfig = {
    loop: true,
    autoplay: true,
    autoplaySpeed: 2000,
    autoplayTimeout: 2000,
    autoplayHoverPause: true,
    lazyLoad: true,
    nav: true,
    items: 1,

    navText: [
      "<div class='nav-btn prev-slide'></div>",
      "<div class='nav-btn next-slide'></div>",
    ],
  };

  // Initialize specific carousels with custom options
  $(".main-slider").owlCarousel(
    $.extend({}, baseCarouselConfig, {
      margin: 10,
      dots: false,
      navText: [
        "<img src='../img/new-desgin/prev-arrow-white.svg'>",
        "<img src='../img/new-desgin/next-arrow-white.svg'>",
      ],
    })
  );

  $(".custome-slider").owlCarousel(
    $.extend({}, baseCarouselConfig, {
      nav: false,
      dots: true,
    })
  );

  $(".ukslider").owlCarousel(
    $.extend({}, baseCarouselConfig, {
      dots: true,
      nav: false,
    })
  );

  $(".owl-lifeBesa").owlCarousel(
    $.extend({}, baseCarouselConfig, {
      dots: false,
      nav: true,
      margin: 40,
      navText: [
        "<img src='./img/chevron-right.svg'>",
        "<img src='./img/chevron-left.svg'>",
      ],
      responsive: {
        0: { items: 1 },
        600: { items: 2 },
        1000: { items: 3 },
      },
    })
  );

  $(".owl-school-tour").owlCarousel(
    $.extend({}, baseCarouselConfig, {
      dots: false,
      nav: true,
      navText: [
        "<img src='../img/new-desgin/prev-arrow.svg'>",
        "<img src='../img/new-desgin/next-arrow.svg'>",
      ],
    })
  );

  $(".owl-step-back").owlCarousel(
    $.extend({}, baseCarouselConfig, {
      dots: false ,
      nav: true,
      navText: [
        "<img src='../img/new-desgin/prev-arrow.svg'>",
        "<img src='../img/new-desgin/next-arrow.svg'>",
      ],
    })
  );

  $(".owl-small-flag-logo").owlCarousel(
    $.extend({}, baseCarouselConfig, {
      dots: false,
      nav: true,
      margin: 20,
      navText: [
        "<img src='../img/chevron-right-white.svg'>",
        "<img src='../img/chevron-left-white.svg'>",
      ],
      responsive: {
        0: { items: 1 },
        600: { items: 3 },
        1000: { items: 4 },
      },
    })
  );

  $(".owl-logos-slider").owlCarousel(
    $.extend({}, baseCarouselConfig, {
      dots: false,
      margin: 25,
      nav: true,
      navText: [
        "<img src='../img/chevron-right-white.svg'>",
        "<img src='../img/chevron-left-white.svg'>",
      ],
      responsive: {
        0: { items: 1 },
        600: { items: 3 },
        1000: { items: 4 },
      },
    })
  );

  $(".owl-topUni").owlCarousel(
    $.extend({}, baseCarouselConfig, {
      dots: true,
      nav: false,
      margin: 25,
      stagePadding: 60,
      responsive: {
        0: { items: 1 },
        600: { items: 2},
        1000: { items: 3 },
      },
    })
  );

  $(".ukslider").owlCarousel(
    $.extend({}, baseCarouselConfig, {
      dots: true,
      nav: false,
    })
  );

 

  // button scroll to top
  $("#scrollToTop").on("click", function () {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  });
  $(window)
    .scroll(function () {
      // scrollToTop is not a function - changed to scrollTop
      if ($(this).scrollTop() > 3000) {
        $("#scrollToTop").fadeIn();
      } else {
        $("#scrollToTop").fadeOut();
      }
    })
    .trigger("scroll");

 
});

function togglePasswordVisibility(inputId) {
  const passwordInput = document.getElementById(inputId);
  const eyeIcon = passwordInput.parentNode.querySelector(".toggle-password");

  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    eyeIcon.classList.remove("fa-eye");
    eyeIcon.classList.add("fa-eye-slash");
  } else {
    passwordInput.type = "password";
    eyeIcon.classList.remove("fa-eye-slash");
    eyeIcon.classList.add("fa-eye");
  }
}

var buttons = document.querySelectorAll('form button:not([type="submit"])');
for (i = 0; i < buttons.length; i++) {
  buttons[i].addEventListener("click", function (e) {
    e.preventDefault();
  });
}
$("form").on("click", 'button:not([type="submit"])', function (e) {
  e.preventDefault();
});

$(".increment, .decrement").on("click", function (e) {
  const isNegative = $(e.target).closest(".decrement").is(".decrement");
  const input = $(e.target).closest(".input-group").find("input");
  if (input.is("input")) {
    input[0][isNegative ? "stepDown" : "stepUp"]();
  }
});
