jQuery(document).ready(function($) {

  if ($("#map").length) {
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 11,
      scrollwheel: false,
      navigationControl: false,
      mapTypeControl: false,
      scaleControl: false,
      disableDefaultUI: true,
      center: map1,
    });

    var image = 'images/ico_mappin.png';
    new google.maps.Marker({
      position: map1,
      map: map,
      icon: image
    });
    google.maps.event.addDomListener(window, 'resize', function() {
      var center = map.getCenter();
      google.maps.event.trigger(map, "resize");
      map.setCenter(center);
    });
    google.maps.event.addListenerOnce(map, 'idle');
  }

  if ($("#map2").length) {

    var side_bar_html = "";

    var gmarkers = [];

    var map = null;
    var circle = null;
    var geocoder = new google.maps.Geocoder();

    var loc, map, marker, infobox;

    function initMap() {
      map = new google.maps.Map(document.getElementById("map2"), {
        zoom: 12,
        scrollwheel: false,
        disableDefaultUI: true,
        center: map2Center,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });

      var infowindow = new google.maps.InfoWindow();

      function getWidth() {
        if (self.innerHeight) {
          return self.innerWidth;
        }

        if (document.documentElement && document.documentElement.clientHeight) {
          return document.documentElement.clientWidth;
        }

        if (document.body) {
          return document.body.clientWidth;
        }
      }
      var marker, i;
      infobox = new InfoBox({
        content: "",
        disableAutoPan: false,
        maxWidth: 630,
        pixelOffset: new google.maps.Size(-315, 0),
        zIndex: null,
        alignBottom: true,
        boxStyle: {
          opacity: 1,
          width: "630px"
        },
        closeBoxURL: "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==",
        infoBoxClearance: new google.maps.Size(1, 1)
      });

      if (getWidth() < 767) {
        infobox = new InfoBox({
          content: "",
          disableAutoPan: false,
          maxWidth: 300,
          pixelOffset: new google.maps.Size(-150, 0),
          zIndex: null,
          alignBottom: true,
          boxStyle: {
            opacity: 1,
            width: "300px"
          },
          closeBoxURL: "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==",
          infoBoxClearance: new google.maps.Size(1, 1)
        });
      }

      for (i = 0; i < map2Locations.length; i++) {
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(map2Locations[i][0], map2Locations[i][1]),
          map: map,
          icon: map2Locations[i][2]
        });

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
            infobox.setContent(map2Locations[i][3]);
            infobox.open(map, marker);
          }
        })(marker, i));
      }

      google.maps.event.addListener(map, "click", function(event) {
        infobox.close();
      });
      google.maps.event.addDomListener(window, 'resize', function() {
        var center = map.getCenter();
        google.maps.event.trigger(map, "resize");
        map.setCenter(center);
      });
    }
    google.maps.event.addDomListener(window, 'load', initMap);
  }

  if ($("#map3").length) {

    var side_bar_html = "";

    var gmarkers = [];

    var map = null;
    var circle = null;
    var geocoder = new google.maps.Geocoder();

    var loc, map, marker, infobox;

    function initMap() {
      map = new google.maps.Map(document.getElementById("map3"), {
        zoom: 12,
        scrollwheel: false,
        disableDefaultUI: true,
        center: map3,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });

      var infowindow = new google.maps.InfoWindow();

      var marker, i;
      infobox = new InfoBox({
        content: "",
        maxWidth: 300,
        pixelOffset: new google.maps.Size(-150, -34),
        zIndex: null,
        alignBottom: true,
        boxStyle: {
          opacity: 1,
          width: "300px"
        },
        closeBoxURL: "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==",
        infoBoxClearance: new google.maps.Size(1, 1)
      });


      for (i = 0; i < map3Locations.length; i++) {
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(map3Locations[i][0], map3Locations[i][1]),
          map: map,
          icon: map3Locations[i][2]
        });

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
            infobox.setContent("<div class=inside>"+map3Locations[i][3]+"</div>");
            infobox.open(map, marker);
          }
        })(marker, i));
      }

      google.maps.event.addListener(map, "click", function(event) {
        infobox.close();
      });
      google.maps.event.addDomListener(window, 'resize', function() {
        var center = map.getCenter();
        google.maps.event.trigger(map, "resize");
        map.setCenter(center);
      });





      var panorama = new google.maps.StreetViewPanorama(
        document.getElementById('map31'), {
          disableDefaultUI: true,
          position: map3Street,
          pov: {
            heading: 34,
            pitch: 10
          }
        });

    }
    google.maps.event.addDomListener(window, 'load', initMap);
  }

  var safari = navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1;

  if (safari) {
    $("body").addClass("safari");
  }

  function mobile() {
    $(".full-height").height("auto").each(function() {
      var cur = $(this).parent().outerHeight();
      $(this).outerHeight(cur);
    });
  };
  function is_touch_device() {
    return 'ontouchstart' in window || navigator.maxTouchPoints;
  };
  if (safari) {
    $(window).resize(mobile);
    mobile();
  }
  if (is_touch_device()) {
    $("body").addClass("touch");
  } else {
    $("body").addClass("no-touch");
  }

  $(".menu-trigger").click(function() {
    $("body").toggleClass("active-menu")
  });

  var event = (navigator.userAgent.match(/(iPad|iPhone|iPod)/g)) ? "touchstart" : "click";

  $(document).on(event, function (e) {
    if ( $(e.target).closest('.main-filter').length === 0 ) {
      $(".main-filter").removeClass("mega-hover");
      $(".select").removeClass("hover");
    }
  });


  $(".toggle").click(function() {
    $(this).parent().toggleClass("active");
    $(this).next().slideToggle(300);
  });

  $(".main-filter .dropdown.mega .close").click(function() {
    $(".select").removeClass("hover");
    $(".main-filter").removeClass("mega-hover");
    return false;
  });

  $(".mobile-filter").click(function() {
    $(".main-filter").toggleClass("mega-hover");
    return false;
  });
  $(".select > .current").click(function() {
    if ($(".main-filter").hasClass("mega-hover")) {
      if ($(this).parent().hasClass("hover")) {
        $(this).parent().toggleClass("hover");
      } else {
        $(this).parent().toggleClass("hover");
      }
    } else {
      if ($(this).parent().hasClass("hover")) {
        $(".select").removeClass("hover");
        $(".main-filter").removeClass("mega-hover");
      } else {
        $(".select").removeClass("hover");
        $(this).parent().toggleClass("hover");
      }
    }
    return false;
  });

  $(".acc-item input, .acc-item select").each(function() {
    if ($(this).val() == "") {
      $(this).addClass("placeholder");
    } else {
      $(this).removeClass("placeholder");
    }
  });

  $(".acc-item input, .acc-item select").on("change keydown keydown", function() {
    if ($(this).val() == "") {
      $(this).addClass("placeholder");
    } else {
      $(this).removeClass("placeholder");
    }
  });

  $(".modal-overlay .close, .close-modal").click(function() {
    $("body").removeClass("active-modal");
    $(".modal-overlay").removeClass("active");
    return false;
  });

  $(document).keyup(function(e) {
    if (e.keyCode === 27) {
      $("body").removeClass("active-modal");
      $(".modal-overlay").removeClass("active");
    }
  });

  $(".open-modal").click(function() {
    $("body").removeClass("active-modal");
    $(".modal-overlay").removeClass("active");
    $("body").addClass("active-modal");
    $($(this).attr("href")).addClass("active");
    return false;
  });

  if (location.hash) {
    $("body").addClass("active-modal");
    $(location.hash).addClass("active");
  }

  $(".controls a").click(function() {
    var parent = $(this).parentsUntil(".post-map").parent(".post-map");
    parent.find(".map-type").removeClass("active");
    parent.find(".controls a").removeClass("current");
    $(this).addClass("current");
    $($(this).attr("href")).addClass("active");
    return false;
  });

  $(".widget-tabs .nav a").click(function() {
    var parent = $(this).parentsUntil(".widget-tabs").parent(".widget-tabs");
    parent.find(".tab-s-c").removeClass("active");
    parent.find(".nav li").removeClass("current");
    $(this).parent().addClass("current");
    $($(this).attr("href")).addClass("active");
    return false;
  });

  $(".tab-nav a").click(function() {
    var parent = $(this).parentsUntil(".tabs-holder").parent(".tabs-holder");
    parent.find(".tab-c").removeClass("active");
    parent.find(".tab-nav li").removeClass("current");
    $(this).parent().addClass("current");
    $($(this).attr("href")).addClass("active");
    return false;
  });

  $(".inside-tabs .nav a").click(function() {
    var parent = $(this).parentsUntil(".inside-tabs").parent(".inside-tabs");
    parent.find(".tab-ic").removeClass("active");
    parent.find(".nav li").removeClass("current");
    $(this).parent().addClass("current");
    $($(this).attr("href")).addClass("active");
    return false;
  });

  $(".trigger").click(function() {
    $(this).parent().toggleClass("active");
    $(this).next().toggleClass("active");
    return false;
  });

  $('.accordion > h4').click(function() {
    if ($(this).parent().hasClass("active")) {
      $('.accordion .cc').slideUp();
      $('.accordion.active').removeClass("active");
    } else {
      $('.accordion .cc').slideUp();
      $('.accordion.active').removeClass("active");
      $(this).parent().addClass("active");
      $(this).next(".cc").slideDown()
    }
    return false;
  });


  $('.post-floor .slides').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-caret-left" aria-hidden="true"></i></button>',
    nextArrow: '<button type="button" class="slick-next"><i class="fa fa-caret-right" aria-hidden="true"></i></button>',
    fade: true,
  });

  $('.gallery-slider .slides').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    fade: true,
    prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-caret-left" aria-hidden="true"></i></button>',
    nextArrow: '<button type="button" class="slick-next"><i class="fa fa-caret-right" aria-hidden="true"></i></button>',
    asNavFor: '.gallery-slider .thumbs'
  });
  $('.gallery-slider .thumbs').slick({
    slidesToShow: 6,
    variableWidth: true,
    slidesToScroll: 1,
    asNavFor: '.gallery-slider .slides',
    dots: false,
    prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-caret-left" aria-hidden="true"></i></button>',
    nextArrow: '<button type="button" class="slick-next"><i class="fa fa-caret-right" aria-hidden="true"></i></button>',
    focusOnSelect: true
  });

});
