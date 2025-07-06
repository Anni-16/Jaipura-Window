let prevWidth = null;
(function ($) {
  "use strict";
  /*----------
    Loader
    ----------*/
  $(window).on("load", function () {
    $(".loader").fadeOut("slow", function () {
      $(this).remove();
    });
  });

  jQuery(document).ready(function () {
    // responsive header
    responsiveheader();

    // Back to top
    backToTop();

    // Slider
    setProductCarousel();

    // Update column & content in responsive
    updateColumnsAndContent();

    // category page click events
    clickEventsInCategoryPage();

    // footer
    footerExplanCollapse();

    // Highlight any found errors
    $(".text-danger").each(function () {
      var element = $(this).parent().parent();

      if (element.hasClass("form-group")) {
        element.addClass("has-error");
      }
    });

    // Menu
    $("#menu .dropdown-menu").each(function () {
      var menu = $("#menu").offset();
      var dropdown = $(this).parent().offset();
      var i =
        dropdown.left +
        $(this).outerWidth() -
        (menu.left + $("#menu").outerWidth());
      if (i > 0) {
        $(this).css("margin-left", "-" + (i + 10) + "px");
      }
    });

    // Makes tooltips work on ajax generated content
    $(document).ajaxStop(function () {
      $("[data-toggle='tooltip']").tooltip({
        container: "body",
      });
    });
  });

  jQuery(window).resize(function () {
    responsiveheader();
    updateColumnsAndContent();
  });

  /*----------
    Set header(991)
    ----------*/
  function responsiveheader() {
    var this_window_width = $(window).width();
    {
      if (this_window_width >= 1200) {
        jQuery(".header-center").insertBefore(".header-right");
      } else if (this_window_width <= 1199 && this_window_width >= 992) {
        jQuery(".header-center").insertAfter(".header-inner");
      } else {
        jQuery(".header-center").insertBefore(".search-content");
      }
      prevWidth = this_window_width;
      // prevWidth = $(window).width();
    }
  }

  /*----------
    Back to top
    ----------*/
  function backToTop() {
    //Check to see if the window is top if not then display button
    $(".scrollToTop").hide();
    $(window).scroll(function () {
      if ($(this).scrollTop() > 250) {
        $(".scrollToTop").fadeIn();
      } else {
        $(".scrollToTop").fadeOut();
      }
    });
    //Click event to scroll to top
    $(".scrollToTop").on("click", function () {
      $("html, body").animate(
        {
          scrollTop: 0,
        },
        800
      );
      return false;
    });
  }

  /*----------
    Product Slider
    ----------*/
  function setProductCarousel() {
    $(".product-carousel").each(function () {
      if (
        $(this).closest("#column-left").length == 0 &&
        $(this).closest("#column-right").length == 0
      ) {
        $(this).addClass("owl-carousel owl-theme");
        const items = $(this).data("items") || 5;
        const sliderOptions = {
          loop: false,
          rewind: false,
          autoplay: false,
          autoplayTimeout: 3000,
          nav: true,
          mouseDrag: true,
          touchDrag: true,
          navText: [
            '<i class="fa fa-angle-left"></i>',
            '<i class="fa fa-angle-right"></i>',
          ],
          dots: false,
          items: items,
          responsiveRefreshRate: 200,
          responsive: {
            0: {
              items: 1,
              margin: 10,
            },
            320: {
              items: 1,
              margin: 10,
            },
            576: {
              items: items - 2 > 1 ? items - 2 : 1,
              margin: 10,
            },
            992: {
              items: items - 1 > 1 ? items - 1 : 1,
              margin: 30,
            },
            1200: {
              items: items,
              margin: 30,
            },
          },
        };
        $(this).owlCarousel(sliderOptions);
      }
    });
  }

  /*----------
    Blog Slider
    ----------*/
  $(".blog-carousel").owlCarousel({
    loop:false,
    dots: false,
    nav: true,
    rewind: false,
    navText: [
      '<i class="fa fa-angle-left" aria-hidden="true">',
      '<i class="fa fa-angle-right" aria-hidden="true">',
    ],
    autoplay: false,
    autoplayTimeout: 3000,
    animateOut: "fadeOut",
    items: 1,
    responsiveClass: false,
    responsive: {
      320: {
        items: 1,
      },
      768: {
        items: 2,
        margin: 10,
      },
      992: {
        items: 2,
        margin: 30,
      },
      1200: {
        items: 3,
        margin: 30,
      },
    },
  });

  /*----------
    Brand Slider
    ----------*/
  $(".brand-carousel").owlCarousel({
    loop: false,
    dots: false,
    nav: true,
    rewind: false,
    navText: [
      '<i class="fa fa-angle-left" aria-hidden="true">',
      '<i class="fa fa-angle-right" aria-hidden="true">',
    ],
    autoplay: true,
    autoplayTimeout: 2000,
    responsiveRefreshRate: 200,
    items: 1,
    responsiveClass: false,
    responsive: {
      481: {
        items: 2,
        margin: 10,
      },
      576: {
        items: 3,
        margin: 10,
      },
      768: {
        items: 4,
        margin: 10,
      },
      992: {
        items: 5,
        margin: 30,
      },
      1200: {
        items: 6,
        margin: 30,
      },
    },
  });

  /*----------
    Banner Slider
    ----------*/
  $(".banner-owl-carousel").owlCarousel({
    loop: false,
    dots: false,
    nav: true,
    margin: 0,
    rewind: false,
    navText: [
      '<i class="fa fa-angle-left" aria-hidden="true">',
      '<i class="fa fa-angle-right" aria-hidden="true">',
    ],
    autoplay: true,
    autoplayTimeout: 3000,
    animateOut: "fadeOut",
    items: 1,
    responsiveClass: false,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 1,
      },
      1024: {
        items: 1,
      },
    },
  });

  /*----------
    Testimonial Slider
    ----------*/
  $(".customers-said").owlCarousel({
    loop: false,
    dots: false,
    nav: true,
    rewind: false,
    navText: [
      '<i class="fa fa-angle-left" aria-hidden="true">',
      '<i class="fa fa-angle-right" aria-hidden="true">',
    ],
    autoplay: true,
    autoplayTimeout: 4000,
    // animateOut: 'fadeOut',
    items: 1,
    responsiveClass: false,
    responsiveRefreshRate: 200,
    responsive: {
      480: {
        items: 1,
      },
    },
  });

  $(".additional-carousel").owlCarousel({
    loop: false,
    dots: false,
    nav: true,
    rewind: false,
    navText: [
      '<i class="fa fa-angle-left" aria-hidden="true">',
      '<i class="fa fa-angle-right" aria-hidden="true">',
    ],
    autoplay: false,
    autoplayTimeout: 3000,
    animateOut: "fadeOut",
    items: 5,
    responsiveClass: false,
    responsive: {
      0: {
        items: 1,
      },
      320: {
        items: 2,
        margin: 10,
      },
      426: {
        items: 3,
        margin: 10,
      },
      481: {
        items: 4,
        margin: 10,
      },
      768: {
        items: 3,
        margin: 10,
      },
      992: {
        items: 3,
        margin: 30,
      },
      1200: {
        items: 4,
        margin: 30,
      },
    },
  });

  /*----------
    Update column & content in responsive
    -----------*/
  function updateColumnsAndContent() {
    if ($(window).width() < 992) {
      $("#column-left, #column-right").insertAfter("#content");

      // menu
      if ($("#menu .dropdown.menulist .toggle-menu").length == 0) {
        $("#menu .dropdown.menulist").append(
          "<span class='toggle-menu'><i class='fa fa-plus'></i></span>"
        );
        $("#menu .dropdown.menulist .dropdown-submenu.sub-menu-item").append(
          "<span class='toggle-menu'><i class='fa fa-plus'></i></span>"
        );
        $("#topCategoryList ul.sub-menu").removeAttr("style");
        $("#topCategoryList div.dropdown-menu").removeAttr("style");
        $("#topCategoryList").hide();
        // call explan-collapse
        responsiveMenuExpandCollapse();
      }

      // left, right
      $(
        "#column-left .box-category .toggle-open, #column-right .box-category .toggle-open, #column-left .box-content .toggle-open, #column-right .box-content .toggle-open"
      ).remove();
      $(
        "#column-left .box-category h3, #column-right .box-category h3, #column-left .box-content h3, #column-right .box-content h3"
      ).append(
        "<span class='toggle-open'><i class='fa fa-chevron-down'></i></span>"
      );
      $(
        "#column-left ul.parent, #column-right ul.parent, #column-left .block_box, #column-right .block_box, #column-left .box-content ul, #column-right .box-content ul, #column-left .filter_box, #column-right .filter_box"
      ).hide();

      // footer
      if ($(".footer-top .toggle-open").length == 0) {
        $(".footer-top h5").append(
          "<span class='toggle-open'><i class='fa fa-chevron-down'></i></span>"
        );
        $(".footer-top ul.list-unstyled").hide();
      }
    } else {
      $("#column-right").insertAfter("#content");
      $("#column-left").insertBefore("#content");

      // menu
      $("#menu .dropdown.menulist .toggle-menu").remove();
      $("#topCategoryList").show();
      $("#topCategoryList ul.sub-menu").removeAttr("style");
      $("#topCategoryList div.dropdown-menu").css("display", "");

      // left, right
      $(
        "#column-left .box-category .toggle-open, #column-left .box-content .toggle-open"
      ).remove();
      $(
        "#column-right .box-category .toggle-open, #column-right .box-content .toggle-open"
      ).remove();
      $(
        "#column-left ul.parent, #column-right ul.parent, #column-left .block_box, #column-right .block_box, #column-left .box-content ul, #column-right .box-content ul, #column-left .filter_box, #column-right .filter_box"
      ).show();

      // footer
      $(".footer-top .toggle-open").remove();
      $(".footer-top ul.list-unstyled").show();
    }
  }

  /*----------
    Responsive menu
    ----------*/
  function responsiveMenuExpandCollapse() {
    // expand-collapse
    $("#topCategoryList .dropdown.menulist .toggle-menu").on(
      "click",
      function (e) {
        e.preventDefault();
        if ($(this).parent().find("> ul.sub-menu").length != 0) {
          $(this).parent().find("> ul.sub-menu").slideToggle("slow");
        } else {
          $(this).parent().find("> div.dropdown-menu").slideToggle("slow");
        }
        $(this).parent().toggleClass("active");
        $(this).toggleClass("active");
        return false;
      }
    );
  }

  /*----------
    Category page click events
    ----------*/
  function clickEventsInCategoryPage() {
    $(".box-category .toggled").on("click", function (e) {
      e.preventDefault();
      if ($(window).width() < 992) {
        $(this).toggleClass("active");
        $(this)
          .parent()
          .find("ul.parent")
          .toggleClass("active")
          .slideToggle("slow");
      }
    });

    $("#column-left .box-content .toggled").on("click", function (e) {
      e.preventDefault();
      if ($(window).width() < 992) {
        $(this).toggleClass("active");
        if ($(this).parent().find("ul").length != 0) {
          $(this).parent().find("ul").toggleClass("active").slideToggle("slow");
        } else {
          $(this)
            .parent()
            .find(".filter_box")
            .toggleClass("active")
            .slideToggle("slow");
          $(this)
            .parent()
            .find(".block_box")
            .toggleClass("active")
            .slideToggle("slow");
        }
      }
    });

    $("#column-right .box-content .toggled").on("click", function (e) {
      e.preventDefault();
      if ($(window).width() < 992) {
        $(this).toggleClass("active");
        if ($(this).parent().find("ul").length != 0) {
          $(this).parent().find("ul").toggleClass("active").slideToggle("slow");
        } else {
          $(this)
            .parent()
            .find(".filter_box")
            .toggleClass("active")
            .slideToggle("slow");
          $(this)
            .parent()
            .find(".block_box")
            .toggleClass("active")
            .slideToggle("slow");
        }
      }
    });
  }

  /*----------
    Footer Toggle
    ----------*/
  function footerExplanCollapse() {
    $(".footer-top h5").addClass("toggled");
    $(".footer-top .toggled").on("click", function (e) {
      e.preventDefault();
      if ($(window).width() < 992) {
        $(this).toggleClass("active");
        $(this).parent().find("ul").toggleClass("active").toggle("slow");
      }
    });
  }

  /*----------
    Dropdown Toggle
    ----------*/
  $(function () {
    $("#form-language .dropdown-toggle").on("click", function () {
      $(".language-dropdown").slideToggle("2000");
      $(
        ".header-cart-toggle, .currency-dropdown, .account-link-toggle"
      ).slideUp("slow");
      return false;
    });

    $("#form-currency .dropdown-toggle").on("click", function () {
      $(".currency-dropdown").slideToggle("2000");
      $(
        ".header-cart-toggle, .language-dropdown, .account-link-toggle"
      ).slideUp("slow");
      return false;
    });

    $("#cart button.dropdown-toggle").on("click", function () {
      $(".header-cart-toggle").slideToggle("2000");
      $(".account-link-toggle, .currency-dropdown, .language-dropdown").slideUp(
        "slow"
      );
      setTimeout(function () {
        set_cart_scroll();
      }, 500);
      return false;
    });

    $("#header_ac a.dropdown-toggle").on("click", function () {
      $(".account-link-toggle").slideToggle("2000");
      $(".header-cart-toggle, .currency-dropdown, .language-dropdown").slideUp(
        "slow"
      );
      return false;
    });

    $(".search-content .search-btn-outer").on("click", function () {
      $(this).toggleClass("active");
      $(".header-search").slideToggle("2000");
      $(
        ".account-link-toggle, .currency-dropdown, .header-cart-toggle, .language-dropdown"
      ).hide();
      return false;
    });
  });

  $(document).on("click", function () {
    $(
      ".header-cart-toggle, .currency-dropdown, .language-dropdown, .account-link-toggle"
    ).slideUp("slow");
  });

  /*----------
    Set Cart Dropdown Height
    ----------*/
  function set_cart_scroll() {
    var header_height = $("header").height();
    var screen_height = $(window).height();
    var cart_list_height = $("#cart .dropdown-menu .table-striped").height();
    var cart_total_height = $("#cart .dropdown-menu li+li").height();
    var cart_div_height =
      parseInt(cart_list_height) + parseInt(cart_total_height) + 10;
    var cart_div_max_height = parseInt(screen_height) - parseInt(header_height);
    var cart_total_pro = jQuery(".cart-content-product table  tr").length;
    if (screen_height < cart_div_height) {
      $("#cart .dropdown-menu").css({
        "overflow-y": "unset",
        "max-height": "unset",
      });
      $("ul.dropdown-menu.pull-right")
        .addClass("scroll_cart_dropdown")
        .css({
          "overflow-y": "auto",
          "max-height": cart_div_max_height + "px",
        });
    } else {
      $("ul.dropdown-menu.pull-right").removeClass("scroll_cart_dropdown").css({
        "overflow-y": "unset",
        "max-height": "unset",
      });
      $("#cart .dropdown-menu ul").css({
        "overflow-y": "auto",
        "max-height": "240px",
      });
    }
  }

  /*----------
    quantity seter
    ----------*/
  $(document).on("click", ".plus, .minus", function (e) {
    e.preventDefault();
    var parent = $(this).parents(".product-btn-quantity");
    var quantity = parent.find('[name="quantity"]');
    var val = quantity.val();
    if ($(this).hasClass("plus")) {
      val = parseInt(val) + 1;
    } else {
      if (val == 1) {
        val = 1;
      } else {
        val = val >= 1 ? parseInt(val) - 1 : 0;
      }
    }
    quantity.val(val);
    quantity.trigger("change");
    return false;
  });

  /*----------
    Hide Tooltip After Click
    ----------*/
  $(document).ready(function () {
    $('[data-toggle="tooltip"]').click(function () {
      $('[data-toggle="tooltip"]').tooltip("hide");
    });
  });

  /*----------
    headerfixed
    ----------*/
  var headerfixed = 1;
  if (headerfixed == 1) {
    $(window).scroll(function () {
      if ($(this).scrollTop() > 160) {
        $("header").addClass("header-fixed");
      } else {
        $("header").removeClass("header-fixed");
      }
    });
  } else {
    $("header").removeClass("header-fixed");
  }

 

  jQuery(".additional-carousel a.elevatezoom-gallery").click(function (e) {
    e.preventDefault();
    var this_img_src = jQuery(this).attr("data-zoom-image");
    jQuery("#prozoom").attr("src", this_img_src);
    return;
  });
})(jQuery);
