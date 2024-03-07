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

   // Function to initialize each slider
   function initSlider(slider) {
    // Local variables for this slider
    var autoSwap = setInterval(function () {
      swap(slider, "clockwise");
    }, 22000);
    var startItem = 1;
    var position = 0;
    var itemCount = slider.find(">li").length;
    var leftpos = itemCount;
    var resetCount = itemCount;

    // Swap function specific to a slider
    function swap(slider, action) {
      var direction = action;
      var carouselItems = slider.find(">li");
      var itemCount = carouselItems.length;

      // Moving carousel backwards
      if (direction == "counter-clockwise") {
        var leftitem = slider.find(".left-pos").attr("id") - 1;
        if (leftitem == 0) {
          leftitem = itemCount;
        }

        slider.find(".right-pos").removeClass("right-pos").addClass("back-pos");
        slider.find(".main-pos").removeClass("main-pos").addClass("right-pos");
        slider.find(".left-pos").removeClass("left-pos").addClass("main-pos");
        slider
          .find("#" + leftitem)
          .removeClass("back-pos")
          .addClass("left-pos");

        startItem--;
        if (startItem < 1) {
          startItem = itemCount;
        }
      }

      // Moving carousel forward
      if (direction == "clockwise" || direction == "" || direction == null) {
        function pos(positionvalue) {
          if (positionvalue != "leftposition") {
            //increment image list id
            position++;

            //if final result is greater than image count, reset position.
            if (startItem + position > resetCount) {
              position = 1 - startItem;
            }
          }

          //setting the left positioned item
          if (positionvalue == "leftposition") {
            //left positioned image should always be one left than main positioned image.
            position = startItem - 1;

            //reset last image in list to left position if first image is in main position
            if (position < 1) {
              position = itemCount;
            }
          }

          return position;
        }

        slider
          .find("#" + startItem)
          .removeClass("main-pos")
          .addClass("left-pos");
        slider
          .find("#" + (startItem + pos()))
          .removeClass("right-pos")
          .addClass("main-pos");
        slider
          .find("#" + (startItem + pos()))
          .removeClass("back-pos")
          .addClass("right-pos");
        slider
          .find("#" + pos("leftposition"))
          .removeClass("left-pos")
          .addClass("back-pos");

        startItem++;
        position = 0;
        if (startItem > itemCount) {
          startItem = 1;
        }
      }
    }

    // Event handlers for this slider
    slider.hover(
      function () {
        clearInterval(autoSwap);
      },
      function () {
        autoSwap = setInterval(function () {
          swap(slider, "clockwise");
        }, 7000);
      }
    );

    slider
      .parent()
      .find("#next")
      .click(function () {
        swap(slider, "clockwise");
      });

    slider
      .parent()
      .find("#prev")
      .click(function () {
        swap(slider, "counter-clockwise");
      });

    slider.find(">li").click(function () {
      if ($(this).hasClass("left-pos")) {
        swap(slider, "counter-clockwise");
      } else {
        swap(slider, "clockwise");
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
