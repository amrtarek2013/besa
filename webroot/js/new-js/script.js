$(document).ready(function () {
  "use strict";

  // open sidenave in mobile
  $(".navbar-mobile .toggle").on("click", function () {
    $(".sidenav").toggleClass("open");
    $(".overlay").toggleClass("visible");
  });
  // colse sidenave in mobile
  $(".sidenav .colse").on("click", function () {
    $(".sidenav").toggleClass("open");
    $(".overlay").toggleClass("visible");
  });

  $(".toggle-search").on("click", function () {
    $(".li-search").toggleClass("show");
  });

  $(".grid-subjects .subject").on("click", function () {
    $(this).addClass("active").siblings().removeClass("active");
  });

  $(".btn-filter").click(function () {
    $("#sideFilter").toggleClass("show");
    $("#pageOverlay").toggleClass("visible");
  });

  $("#pageOverlay").click(function () {
    $("#sideFilter").toggleClass("show");
    $("#pageOverlay").toggleClass("visible");
  });
  $(".side-filter .close").click(function () {
    $("#sideFilter").toggleClass("show");
    $("#pageOverlay").toggleClass("visible");
  });

  $(".details-user .header-details").click(function () {
    $(".drop-down-user").toggleClass("show");
  });

  // Add click event listener to each question
  $(".faq-question").click(function () {
    // This toggles the faq-answer slide up/down
    $(this).next(".faq-answer").slideToggle("slow");

    // This changes the image from plus to minus and vice versa
    var imgSrc = $(this).find(".faq-icon").attr("src");
    if (imgSrc.includes("plus-icon")) {
      $(this)
        .find(".faq-icon")
        .attr(
          "src",
          imgSrc.replace(
            "img/new-desgin/plus-icon.svg",
            "img/new-desgin/minus-icon.svg"
          )
        );
    } else {
      $(this)
        .find(".faq-icon")
        .attr(
          "src",
          imgSrc.replace(
            "img/new-desgin/minus-icon.svg",
            "img/new-desgin/plus-icon.svg"
          )
        );
    }
  });

  $(".tab-button").click(function () {
    var $this = $(this);
    var $target = $($this.data("tab-target"));

    $(".tab-button").removeClass("active");
    $(".tab-content").removeClass("active");

    $this.addClass("active");
    $target.addClass("active");
  });
  function reveal() {
    var reveals = document.querySelectorAll(".have-animations");

    for (var i = 0; i < reveals.length; i++) {
      var windowHeight = window.innerHeight;
      var elementTop = reveals[i].getBoundingClientRect().top;
      var elementVisible = 150;

      if (elementTop < windowHeight - elementVisible) {
        reveals[i].classList.add("animated");
      } else {
        reveals[i].classList.remove("animated");
      }
    }
  }
  window.addEventListener("scroll", reveal);

  // opstions owl slider

  /*
  sliderTestimonials.owlCarousel({
    items: 1,
    loop: true,
    nav: false,
    autoplay: true,
    autoplayTimeout: 3000,
    autoPlaySpeed: 3000,
    autoplayHoverPause: true,
    navText: [
      "<i class='fa-solid fa-chevron-left'></i>",
      "<i class='fa-solid fa-chevron-right'></i>",
    ],
  });


  /*
  var owlBlogs = $(".owl-blogs");
  owlBlogs.owlCarousel({
      items: 3,
      loop: true,
      margin: 10,
      dots: false,
      nav: true,
      autoWidth:true,

      navText: [
          "<img src='./img/new-desgin/prev-arrow.png'>",
          "<img src='./img/new-desgin/next-arrow.png'>",
      ],
      autoplay: true,
      autoPlaySpeed: 2000,
      autoPlayTimeout: 2000,
      autoplayHoverPause: true,
      onInitialized: resizeMiddleItem,
      onTranslated: resizeMiddleItem
  });
*/

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
  $(".carousel-blogs").each(function () {
    initSlider($(this));
  });

  $(".carousel-testimonials").each(function () {
    initSlider($(this));
  });
  // More sliders can be initialized similarly
  var mainSlider = $(".main-slider");
  mainSlider.owlCarousel({
    items: 1,
    loop: true,
    margin: 10,
    dots: false,
    nav: true,
    navText: [
      "<img src='../img/new-desgin/prev-arrow-white.svg'>",
      "<img src='../img/new-desgin/next-arrow-white.svg'>",
    ],
    autoplay: true,
    autoPlaySpeed: 2000,
    autoPlayTimeout: 2000,
    autoplayHoverPause: true,
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
