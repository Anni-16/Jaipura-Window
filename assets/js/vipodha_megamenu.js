var active = false;
var hover = false;
$(document).ready(function () {
  $("ul.vipodha_megamenu li .sub-menu .content .hover-menu ul li").hover(
    function () {
      $(this).children("ul").show();
    },
    function () {
      $(this).children("ul").hide();
    }
  );

  var wd_width = $(window).width();
  if (wd_width <= 991) {
    $("ul.vipodha_megamenu > li.hover").unbind("mouseenter mouseleave");
    removeWidthSubmenu();
    clickMegaMenu();
  } else {
    $("ul.vipodha_megamenu > li.hover").unbind("click");
    hoverMegaMenu();
    renderWidthSubmenu();
    sidebar_megamenu();
  }

  $(window).resize(function () {
    var sp_width = $(window).width();
    if (sp_width <= 991) {
      $("ul.vipodha_megamenu > li.hover").unbind("mouseenter mouseleave");
      removeWidthSubmenu();
      clickMegaMenu();
    } else {
      $("ul.vipodha_megamenu > li.hover").unbind("click");
      hoverMegaMenu();
      renderWidthSubmenu();
      sidebar_megamenu();
    }
  });

  $("ul.vipodha_megamenu > li.click").click(function () {
    if ($(this).find(".content").is(":visible")) {
      return;
    }
    active = $(this);
    hover = true;
    var transition = $(this).closest(".vipodha_megamenu").data("transition");
    var animation_time = $(this)
      .closest(".vipodha_megamenu")
      .data("animationtime");
    $("ul.vipodha_megamenu > li").removeClass("active");
    $(this).addClass("active");
    $("ul.vipodha_megamenu > li").children(".sub-menu").hide();
    $("ul.vipodha_megamenu > li").find(".content").hide();
    $(this).children(".sub-menu").show();
    if (transition == "slide") {
      $(this).find(".content").show();
      $(this).find(".content").css("height", "auto");
      var originalHeight = $(this).find(".content").height();
      $(this).find(".content").css("height", 0);
      $(this).find(".content").stop(true, true).animate(
        {
          height: originalHeight,
        },
        animation_time
      );
    } else if (transition == "fade") {
      $(this).find(".content").fadeIn(animation_time);
    } else {
      $(this).find(".content").show();
    }
    $(this).children(".sub-menu").css("right", "auto");
    if ($("html").css("direction").toLowerCase() == "rtl") {
      var $whatever = $(this).children(".sub-menu");
      var $whatever2 = $($whatever).closest("ul.vipodha_megamenu");
      if ($whatever.offset().left > $whatever2.offset().left) {
        $(this).children(".sub-menu").css("right", "auto");
      } else if ($whatever.offset().left < 5) {
        $(this).children(".sub-menu").css("right", "0");
      } else {
        $(this).children(".sub-menu").css("left", "0");
      }
      if ($whatever.offset().left == $whatever2.offset().left) {
        $(this).children(".sub-menu").css("left", "auto");
        $(this).children(".sub-menu").css("right", "inherit");
      }
    } else {
      var $whatever = $(this).children(".sub-menu");
      var ending_right =
        $(window).width() - ($whatever.offset().left + $whatever.outerWidth());
      var $whatever2 = $($whatever).closest("ul.vipodha_megamenu");
      var ending_right2 =
        $(window).width() -
        ($whatever2.offset().left + $whatever2.outerWidth());
      // if (ending_right2 > ending_right) {
      //     $(this).children(".sub-menu").css("right", "0");
      // }

      if (ending_right < 5) {
        $(this).children(".sub-menu").css("left", "0");
      } else if (ending_right2 > ending_right) {
      }
    }

    return false;
  });

  /*-----------
    Responsive Horizontal Menu
    ----------*/
  $("#show-vipodha_megamenu").click(function () {
    if ($(this).parents("header").hasClass("header-fixed")) {
      $(this).toggleClass("active");
    } else {
      $("#show-vipodha_megamenu").removeClass("active");
    }
    $("body").toggleClass("active");
    $(".vipodha_megamenu-wrapper").toggleClass("vipodha_megamenu-active");
  });

  $("#remove-vipodha_megamenu").click(function () {
    $("body").removeClass("active");
    $(".vipodha_megamenu-wrapper").removeClass("vipodha_megamenu-active");
    return false;
  });

  $("#show-verticalmenu").click(function () {
    $("body").toggleClass("active");
    $(".vertical-wrapper").addClass("vipodha_megamenu-active");
  });
  $("#remove-verticalmenu").click(function () {
    $("body").removeClass("active");
    $(".vertical-wrapper").removeClass("vipodha_megamenu-active");
    return false;
  });

  $("html").on("click", function () {
    $("ul.vipodha_megamenu > li.click").removeClass("active");
    $("ul.vipodha_megamenu > li.click").children(".sub-menu").hide();
    $("ul.vipodha_megamenu > li.click").find(".content").hide();
  });
  $(".close-menu").on("click", function () {
    $(this).parent().removeClass("active");
    $(this).parent().children(".sub-menu").hide();
    $(this).parent().find(".content").hide();
    return false;
  });
});

function renderWidthSubmenu() {
  $(".vertical .sub-menu").each(function () {
    value = $(this).data("subwidth");
    if (value) {
      var container_width = $(".container").width();
      var vertical_width = $(".vertical").width();
      var full_width = container_width - vertical_width;
      var width_submenu = (full_width * value) / 100;
      $(this).css("width", width_submenu + "px");
    }
  });
}

function removeWidthSubmenu() {
  $(".vertical .sub-menu").each(function () {
    $(this).css("width", "100%");
  });
}

function clickMegaMenu() {
  $("ul.vipodha_megamenu > li.hover").click(function () {
    if ($(this).find(".content").is(":visible")) {
      return;
    }
    var this_menu_id = $(this).parent(".vipodha_megamenu").attr("id");
    active = $(this);
    hover = true;
    var transition = $(this).closest(".vipodha_megamenu").data("transition");
    var animation_time = $(this)
      .closest(".vipodha_megamenu")
      .data("animationtime");
    $("ul.vipodha_megamenu > li").removeClass("active");
    $(this).addClass("active");
    $("ul.vipodha_megamenu > li").children(".sub-menu").hide();
    $("ul.vipodha_megamenu > li").find(".content").hide();
    $(this).children(".sub-menu").show();
    if (transition == "slide") {
      $(this).find(".content").show();
      $(this).find(".content").css("height", "auto");
      var originalHeight = $(this).find(".content").height();
      $(this).find(".content").css("height", 0);
      $(this).find(".content").stop(true, true).animate(
        {
          height: originalHeight,
        },
        animation_time
      );
    } else if (transition == "fade") {
      $(this).find(".content").fadeIn(animation_time);
    } else {
      $(this).find(".content").show();
    }
    $(this).children(".sub-menu").css("right", "auto");
    if ($("html").css("direction").toLowerCase() == "rtl") {
      var $whatever = $(this).children(".sub-menu");
      var $whatever2 = $($whatever).closest("ul.vipodha_megamenu");
      if ($whatever.offset().left < $whatever2.offset().left) {
        $(this).children(".sub-menu").css("right", "0");
      }
    } else {
      var $whatever = $(this).children(".sub-menu");
      var ending_right =
        $(window).width() - ($whatever.offset().left + $whatever.outerWidth());
      var $whatever2 = $($whatever).closest("ul.vipodha_megamenu");
      var ending_right2 =
        $(window).width() -
        ($whatever2.offset().left + $whatever2.outerWidth());
      if (ending_right2 > ending_right) {
        $(this).children(".sub-menu").css("right", "0");
      }
    }
  });
}

function hoverMegaMenu() {
  $("ul.vipodha_megamenu > li.hover").hover(
    function () {
      active = $(this);
      hover = true;
      var transition = $(this).closest(".vipodha_megamenu").data("transition");
      var animation_time = $(this)
        .closest(".vipodha_megamenu")
        .data("animationtime");
      $("ul.vipodha_megamenu > li").removeClass("active");
      $(this).addClass("active");
      $("ul.vipodha_megamenu > li").children(".sub-menu").hide();
      $("ul.vipodha_megamenu > li").find(".content").hide();
      $(this).children(".sub-menu").show();
      if (transition == "slide") {
        $(this).find(".content").show();
        $(this).find(".content").css("height", "auto");
        var originalHeight = $(this).find(".content").height();
        $(this).find(".content").css("height", 0);
        $(this).find(".content").stop(true, true).animate(
          {
            height: originalHeight,
          },
          animation_time
        );
      } else if (transition == "fade") {
        $(this).find(".content").fadeIn(animation_time);
      } else {
        $(this).find(".content").show();
      }
      $(this).children(".sub-menu").css("right", "auto");
      if ($("html").css("direction").toLowerCase() == "rtl") {
        var $whatever = $(this).children(".sub-menu");
        var $whatever2 = $($whatever).closest("ul.vipodha_megamenu");
        if ($whatever.offset().left < $whatever2.offset().left) {
          $(this).children(".sub-menu").css("right", "0");
        }
      } else {
        var $whatever = $(this).children(".sub-menu");
        var ending_right =
          $(window).width() -
          ($whatever.offset().left + $whatever.outerWidth());
        var $whatever2 = $($whatever).closest("ul.vipodha_megamenu");
        var ending_right2 =
          $(window).width() -
          ($whatever2.offset().left + $whatever2.outerWidth());
        if (ending_right2 > ending_right) {
          $(this).children(".sub-menu").css("right", "0");
        }
      }
    },
    function () {
      var rel = $(this).attr("title");
      hover = false;
      var transition = $(this).closest(".vipodha_megamenu").data("transition");
      var animation_time = $(this)
        .closest(".vipodha_megamenu")
        .data("animationtime");
      if (rel == "hover-intent") {
        var hoverintent = $(this);
        setTimeout(function () {
          if (hover == false) {
            if (transition == "slide") {
              $(hoverintent)
                .find(".content")
                .stop(true, true)
                .animate(
                  {
                    height: "hide",
                  },
                  animation_time,
                  function () {
                    if (hover == false) {
                      $(hoverintent).removeClass("active");
                      $(hoverintent).children(".sub-menu").hide();
                    }
                  }
                );
            } else if (transition == "fade") {
              $(hoverintent).removeClass("active");
              $(hoverintent)
                .find(".content")
                .fadeOut(animation_time, function () {
                  if (hover == false) {
                    $(hoverintent).children(".sub-menu").hide();
                  }
                });
            } else {
              $(hoverintent).removeClass("active");
              $(hoverintent).children(".sub-menu").hide();
              $(hoverintent).find(".content").hide();
            }
          }
        }, 500);
      } else {
        if (transition == "slide") {
          $(this)
            .find(".content")
            .stop(true, true)
            .animate(
              {
                height: "hide",
              },
              animation_time,
              function () {
                if (hover == false) {
                  $(active).removeClass("active");
                  $(active).children(".sub-menu").hide();
                }
              }
            );
        } else if (transition == "fade") {
          $(active).removeClass("active");
          $(this)
            .find(".content")
            .fadeOut(animation_time, function () {
              if (hover == false) {
                $(active).children(".sub-menu").hide();
              }
            });
        } else {
          $(this).removeClass("active");
          $(this).children(".sub-menu").hide();
          $(this).find(".content").hide();
        }
      }
    }
  );
}

function sidebar_megamenu() {
  setTimeout(function () {
    jQuery("#column-left,#column-right")
      .find("ul.vipodha_megamenu")
      .addClass("megamenu_in_sidebar");
    if ($("ul.vipodha_megamenu").hasClass("megamenu_in_sidebar")) {
      jQuery("#column-left,#column-right").addClass("megamenu_sidebar_column");

      // vertical-wrapper
      $("ul.vipodha_megamenu > li.hover").unbind("mouseenter mouseleave");
      removeWidthSubmenu();
      clickMegaMenu();
    }
  }, 500);
}

$(document).ready(function () {
  var wd_width = $(window).width();
  if (wd_width <= 991) {
    sidebar_megamenu();
  } else {
    var sub_menu_width = 900;
    var sub_menu_col_width = 250;
    jQuery(".horizontal .vipodha_megamenu li.with-sub-menu").each(function () {
      jQuery(this).find(".sub-menu").width(sub_menu_width);
    });
    jQuery(".horizontal .vipodha_megamenu li.with-sub-menu")
      .find(".sub-menu.sub-menu-1-col")
      .width(sub_menu_col_width);
  }

  jQuery(".horizontal .vipodha_megamenu li.with-sub-menu").each(function () {
    var first_submenu_width = jQuery(this).find(".sub-menu").width();
    if (first_submenu_width > 300) {
      jQuery(this)
        .find(".content ul li a .fa.fa-angle-right")
        .parents(".row")
        .addClass("sub_sub_menu");
    }
  });
});
