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
  return function() {
    var context = this, args = arguments;
    var later = function() {
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
  var itemCount = $slider.children('li').length;
  var autoSwap = setInterval(next, 22000);
  var startItem = 1;

  function setPosition() {
    var position = (startItem % itemCount) || itemCount;
    return position;
  }

  function next() {
    swap($slider, 'clockwise');
  }

  function prev() {
    swap($slider, 'counter-clockwise');
  }

  function resetAutoSwap() {
    clearInterval(autoSwap);
    autoSwap = setInterval(next, 22000);
  }

  function swap($slider, direction) {
    var $items = $slider.children('li');
    var position = setPosition();

    $items.removeClass('left-pos main-pos right-pos back-pos');

    if (direction === 'clockwise') {
      $slider.children('#' + position).addClass('left-pos');
      $slider.children('#' + ((position % itemCount) + 1)).addClass('main-pos');
      $slider.children('#' + (((position + 1) % itemCount) + 1)).addClass('right-pos');
      $slider.children('#' + ((position - 2 + itemCount) % itemCount || itemCount)).addClass('back-pos');
      startItem++;
    } else {
      $slider.children('#' + ((position - 2 + itemCount) % itemCount || itemCount)).addClass('left-pos');
      $slider.children('#' + position).addClass('main-pos');
      $slider.children('#' + ((position % itemCount) + 1)).addClass('right-pos');
      $slider.children('#' + ((position - 3 + itemCount) % itemCount || itemCount)).addClass('back-pos');
      startItem--;
    }
  }

  $slider.on('hover', debounce(function(event) {
    if (event.type === 'mouseenter') {
      clearInterval(autoSwap);
    } else {
      resetAutoSwap();
    }
  }, 300));

  $slider.parent().on('click', '#next', debounce(next, 300));
  $slider.parent().on('click', '#prev', debounce(prev, 300));

  $slider.children('li').on('click', function() {
    if ($(this).hasClass('left-pos')) {
      prev();
    } else {
      next();
    }
  });
}

// Initialize each carousel on the page
$('.carousel-blogs, .carousel-testimonials').each(function() {
  initSlider($(this));
});

  // Define a common options object for similar sliders
var commonSliderOptions = {
  loop: true,
  margin: 10,
  dots: false,
  nav: true,
  autoplay: true,
  autoplaySpeed: 2000,
  autoplayTimeout: 2000,
  autoplayHoverPause: true,
  navText: [
    "<img src='../img/new-desgin/prev-arrow-white.svg' alt='Previous'>",
    "<img src='../img/new-desgin/next-arrow-white.svg' alt='Next'>",
  ]
};

// Initialize sliders with common options
$(".main-slider, .ukslider, .owl-step-back, .owl-small-flag-logo").owlCarousel(commonSliderOptions);

// Override options for specific sliders when needed
$(".custome-slider").owlCarousel($.extend({}, commonSliderOptions, {
  dots: true,
  nav: false
}));

$(".owl-lifeBesa").owlCarousel($.extend({}, commonSliderOptions, {
  margin: 40,
  responsive: {
    0: { items: 1 },
    600: { items: 2 },
    1000: { items: 3 },
  }
}));

// Continue for other sliders...

// Consider lazy loading for all sliders
$("img").attr("loading", "lazy");

// Defer the slider initialization if it's not in the viewport
$(window).on("load scroll", function() {
  if ($(".owl-defer").length && isElementInViewport($(".owl-defer"))) {
    $(".owl-defer").owlCarousel(commonSliderOptions);
    $(window).off("load scroll"); // Remove event listener once initialized
  }
});

function isElementInViewport(el) {
  var rect = el.get(0).getBoundingClientRect();
  return (
    rect.top >= 0 &&
    rect.left >= 0 &&
    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
  );
}

  /*
  // Handle image clicks
  $(".image-box img").click(function () {
    var imageUrl = $(this).attr("src");
    $("#largeImage").attr("src", imageUrl);
  });

 
  // Handle custom navigation buttons
  $(".custom-next").click(function () {
    owl.trigger("next.owl.carousel");
  });

  $(".custom-prev").click(function () {
    owl.trigger("prev.owl.carousel");
  });*/

  // jQuery animated number counter from zero to value
  var counterAbout = $(".about-us");
  var counterBanner = $(".main-banner");
  var winHeight = $(window).height();
  if (counterAbout.length) {
    var firEvent = false,
      objectPosTop = $(".about-us").offset().top;
    //when element shows at bottom
    var elementViewInBottom = objectPosTop - winHeight;
    $(window).on("scroll", function () {
      var currentPosition = $(document).scrollTop();
      //when element position starting in viewport
      if (currentPosition > elementViewInBottom && firEvent === false) {
        firEvent = true;
        animationCounter();
      }
    });
  } else if (counterBanner.length) {
    var firEvent = false,
      objectPosTop = $(".main-banner").offset().top;
    //when element shows at bottom
    var elementViewInBottom = objectPosTop - winHeight;
    $(window).on("scroll", function () {
      var currentPosition = $(document).scrollTop();
      //when element position starting in viewport
      if (currentPosition > elementViewInBottom && firEvent === false) {
        firEvent = true;
        animationCounter();
      }
    });
  }

  //counter function will animate by using external js also add seprator "."
  function animationCounter() {
    $(".number-count").each(function () {
      $(this)
        .prop("Counter", 0)
        .animate(
          {
            Counter: $(this).text(),
          },
          {
            duration: 3000,
            easing: "swing",
            step: function (now) {
              $(this).text(Math.ceil(now));
            },
          }
        );
    });
  }

  // Triger  Slider accordion
  // $(function () {
  //   accordion.init({
  //     id: "accordion",
  //   });
  // });

  // Jumping to sections of the same page
  $(".arrow-bottomGoSection a").on("click", function (event) {
    event.preventDefault();
    var hash = this.hash;
    $("html, body").animate(
      {
        scrollTop: $(hash).offset().top,
      },
      1000,
      function () {
        window.location.hash = hash;
      }
    );
  });

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

  //   // Triger  timeline slider
  //   $(".custome-timeline").Timeline({
  //     itemClass: "timeline-item",
  //     dotsPosition: "top",
  //     autoplaySpeed: 20,
  //   });
  //   var $cols = $(".timeline-horizontal .timeline-dots li");
  //   var numberOfCols = $cols.length;
  //   $cols.css("width", 100 / numberOfCols + "%");

  //   // On next click, if the slide-next element exists, trigger the click event on it
  //   $(".nav-timeline .next").click(function (e) {
  //     e.preventDefault();
  //     if ($(".slide-next").length) {
  //       $(".slide-next").trigger("click");
  //     }
  //   });

  //   // Attach a click event listener to elements with the class "nav-timeline" and "prev"
  //   $(".nav-timeline .prev").click(function (e) {
  //     // Prevent the default behavior of the click event (i.e. following a link, submitting a form, etc.)
  //     e.preventDefault();

  //     // Check if there is an element on the page with the class "slide-prev"
  //     if ($(".slide-prev").length) {
  //       // If such an element exists, trigger a click event on it
  //       $(".slide-prev").trigger("click");
  //     }
  //   });
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
// Get the search input element
// const searchInput = document.querySelector(".search");

// // Get the search list element
// const searchList = document.querySelector(".search-list");

// // Add event listeners to the search input for clicks, focus, and blur events
// searchInput.addEventListener("click", toggleSearchList);
// searchInput.addEventListener("focus", toggleSearchList);
// searchInput.addEventListener("blur", toggleSearchList);

// // Add a click event listener to the document object
// document.addEventListener("click", function (event) {
//   // Check if the click event did not originate from the search input or search list
//   if (
//     !searchInput.contains(event.target) &&
//     !searchList.contains(event.target)
//   ) {
//     // Hide the search list by removing the 'show' class
//     searchList.classList.remove("show");
//   }
// });

// // Function to toggle the 'show' class on the search list
// function toggleSearchList() {
//   searchList.classList.add("show");
// }

// const rangeContainer = document.querySelector(".range-container");
// rangeContainer.addEventListener("input", (ev) => {
//   const rangeInput = ev.target;
//   const valueSpan = rangeContainer.querySelector(`#${rangeInput.id}-value`);
//   const sliderWidth = rangeInput.clientWidth;
//   const sliderPosition = rangeInput.value;
//   const sliderMaxValue = rangeInput.max;
//   const sliderPositionPercentage = (sliderPosition / sliderMaxValue) * 100;
//   rangeInput.style.backgroundImage = `linear-gradient(to right, #33CA94 ${
//     (sliderPositionPercentage * sliderWidth) / 100
//   }px, #B4BEC8 ${(sliderPositionPercentage * sliderWidth) / 100}px)`;
//   rangeInput.id === "age"
//     ? (valueSpan.textContent = sliderPosition + " year")
//     : (valueSpan.textContent = "$" + sliderPosition);
// });
// rangeContainer
//   .querySelectorAll('input[type="range"]')
//   .forEach((rangeInput) => (rangeInput.value = 0));

// // Set event listener on rangeContainer element
// rangeContainer.addEventListener("input", (ev) => {
//   // Declare variables
//   const rangeInput = ev.target;
//   const valueSpan = rangeContainer.querySelector(`#${rangeInput.id}-value`);
//   const sliderWidth = rangeInput.clientWidth;
//   const sliderPosition = rangeInput.value;
//   const sliderMaxValue = rangeInput.max;
//   const sliderPositionPercentage = (sliderPosition / sliderMaxValue) * 100;
//   // Set rangeInput style
//   rangeInput.style.backgroundImage = `linear-gradient(to right, #33CA94 ${
//     (sliderPositionPercentage * sliderWidth) / 100
//   }px, #f5f5f5 ${(sliderPositionPercentage * sliderWidth) / 100}px)`;
//   // Set textContent depending on rangeInput.id
//   rangeInput.id === "age"
//     ? (valueSpan.textContent = sliderPosition + " year")
//     : (valueSpan.textContent = "$" + sliderPosition);
// });
// // Set all rangeInput values to 0
// rangeContainer
//   .querySelectorAll('input[type="range"]')
//   .forEach((rangeInput) => (rangeInput.value = 0));
