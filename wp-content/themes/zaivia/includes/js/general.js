(function($) {

    $(document).ready(function($) {
        function setSmallMap(pos, label) {
            if($('#map').length){
                var small_map = new google.maps.Map(document.getElementById('map'), {
                    scrollwheel: true,
                    navigationControl: true,
                    mapTypeControl: true,
                    scaleControl: true,
                    disableDefaultUI: false,
                    center: pos,
                    zoom: 13
                });
                new google.maps.Marker({
                    position: pos,
                    map: small_map,
                    title: label
                });
            }
        }
        if ($("#search_city").length) {
            $("#search_city").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "http://geogratis.gc.ca/services/geoname/en/geonames.json",
                        dataType: "jsonp",
                        data: {
                            concise: 'CITY,TOWN',
                            'sort-field': 'name',
                            q: request.term + '*'
                        },
                        success: function (data) {
                            var res = [];
                            for (var i in data[0].items) if (data[0].items.hasOwnProperty(i)) {
                                res.push({label: data[0].items[i].name, value: data[0].items[i].id, lat: data[0].items[i].latitude, lng: data[0].items[i].longitude});
                            }
                            response(res);
                        }
                    });
                },
                minLength: 3,
                select: function (event, ui) {
                    $(event.target).val(ui.item.label);
                    var pos = {lat:ui.item.lat, lng:ui.item.lng};
                    setSmallMap(pos,ui.item.label);
                    return false;
                }
            });
            $(".search_city").click(function(e){
                e.preventDefault();

                if($("#search_city").val()) {
                    $("#search_city_error").hide();
                    window.location.href = $(this).attr("rel")+"?city="+$("#search_city").val();
                } else {
                    $("#search_city_error").show();
                }

            });
        }



      if ($("#map2").length) {

        var side_bar_html = "";

        var gmarkers = [];

        var map = null;
        var circle = null;
        var geocoder = new google.maps.Geocoder();

        var loc, marker, infobox;

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
          $(window).resize(mobile);
          mobile();
      }

      function mobile() {
        $(".full-height").height("auto").each(function() {
          var cur = $(this).parent().outerHeight();
          $(this).outerHeight(cur);
        });
      }
      function is_touch_device() {
        return 'ontouchstart' in window || navigator.maxTouchPoints;
      }
      if (is_touch_device()) {
        $("body").addClass("touch");
      } else {
        $("body").addClass("no-touch");
      }



      var event = (navigator.userAgent.match(/(iPad|iPhone|iPod)/g)) ? "touchstart" : "click";
      $(document).on(event, function (e) {
        if ( $(e.target).closest('.main-filter').length === 0 ) {
          $(".main-filter").removeClass("mega-hover");
          $(".select").removeClass("hover");
        }
      });

      $(".menu-trigger").click(function() {
        $("body").toggleClass("active-menu")
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


        $(".select.one ul li a").click(function(){
            var $sel = $(this).parents('.select');

            $("#"+$sel.attr("rel")).val($(this).attr("rel"));
            search_listings();

            if($sel.hasClass("rad")){
                $sel.find(".current").text($(this).text()).trigger("click");
            } else {
                $sel.find(".current").trigger("click");
            }

            return false;
        });


        $("#select_price_min li a").click(function(){
          var v = parseInt($(this).attr("rel"));
          var step = 25000;
          if(v>100000){step = 50000}
          $("#filter_price_min,#hidden_price_min").val(v);
          search_listings();
          $("#select_price_min").hide();
          var val = v+step;
          $("#select_price_max li a").each(function () {
              $(this).attr('rel',val).text('$'+parseInt(val/1000)+',000+');
              val+=step;
          });
          $("#select_price_max").show();
          return false;
        });
        $("#select_price_max li a").click(function(){
            $("#filter_price_max,#hidden_price_max").val($(this).attr("rel"));
            search_listings();
            $("#select_price_max").hide();
            $("#select_price_min").show();
            $(".select.price > .current").trigger('click');
            return false;
        });
        $("#filter_price_min, #filter_price_max").change(function(){
            var id = $(this).attr("id").split("_"),
                val = parseInt($(this).val());
            if(isNaN(val)) val = '';

            $(this).val(val);
            $("#hidden_"+id[1]+"_"+id[2]).val(val);
            search_listings();
        });
        $('#filter_form').submit(function (){
            search_listings();
            return false;
        });
        $('.main-filter input,.main-filter select,#sort_by').change(function (){
            search_listings();
            return false;
        });
        $(document).on('click','a.page-numbers',function (){
            $('#page').val($(this).data('page'));
            search_listings();
            return false;
        });
        if($('body').hasClass('page-template-buy')){
            search_listings();
            update_fav();
            if($('#search_city').val()){
                $.ajax({
                    url: "http://geogratis.gc.ca/services/geoname/en/geonames.json",
                    dataType: "jsonp",
                    data: {
                        concise: 'CITY,TOWN',
                        'sort-field': 'name',
                        q: $('#search_city').val()
                    },
                    success: function (data) {
                        var res = data[0].items[0];
                        var pos = {lat:res.latitude, lng:res.longitude};
                        setSmallMap(pos,res.name);
                    }
                });
            }
        }
        function update_fav(id, action){
            var d = {action: 'getFavListings'};
            if(id>0 && action){
                d[action] = id;
            }
            $.ajax({
                url: amData.ajaxurl,
                dataType: "json",
                data: d,
                success: function (data) {
                    var listing_item = wp.template( "listing-fav" );

                    var fav_list = $('#fav_tab1');
                    fav_list.empty();
                    for(var i in data.fav) if (data.fav.hasOwnProperty(i)){
                        fav_list.append(listing_item(data.fav[i]));
                        $('.fa[data-id='+data.fav[i]['listing_id']+']').removeClass('fav_add fa-heart-o').addClass('fav_del fa-heart');
                    }

                    var view_list = $('#fav_tab2');
                    view_list.empty();
                    for(var j in data.view) if (data.view.hasOwnProperty(j)){
                        view_list.append(listing_item(data.view[j]));
                    }
                }
            });
        }
        $(document).on('click','.fav_add',function () {
            var id = $(this).data('id');
            update_fav(id,'add');
            $('.fa[data-id='+id+']').removeClass('fav_add fa-heart-o').addClass('fav_del fa-heart');
            return false;
        });
        $(document).on('click','.fav_del',function () {
            var id = $(this).data('id');
            update_fav(id,'del');
            $('.fa[data-id='+id+']').addClass('fav_add fa-heart-o').removeClass('fav_del fa-heart');
            return false;
        });
        function search_listings() {
            $.ajax({
                url: amData.ajaxurl,
                dataType: "json",
                data: {
                    action: 'getListings',
                    city: $('#search_city').val(),
                    rad: $('#hidden_rad').val(),
                    price_min: $('#hidden_price_min').val(),
                    price_max: $('#hidden_price_max').val(),
                    beds: $('#hidden_beds').val(),
                    hometype: $('#hidden_hometype').val(),
                    days_on: $('#days-on-select').val(),
                    baths: $('#baths-select').val(),
                    sqft_min: $('#sqft-min').val(),
                    sqft_max: $('#sqft-max').val(),
                    year_min: $('#year-built-min').val(),
                    year_max: $('#year-built-max').val(),
                    sale_by: $('.show_only:checked').map(function(){return $(this).val()}).get().join(','),
                    features_1: $('.features_1:checked').map(function(){return $(this).val()}).get().join(','),
                    sort_by:$('#sort_by').val(),
                    page:$('#page').val(),
                    page_id:$('#page_id').val()
                },
                success: function (data) {
                    var list = $('.ad-listing');
                    var listing_item = wp.template( "listing-item" );
                    var listing_ad = wp.template( "listing-ad" );
                    list.empty();
                    var index = 0;
                    for(var i in data.items) if (data.items.hasOwnProperty(i)){
                        list.append(listing_item(data.items[i]));
                        if(index % 5 === 4){
                            list.append(listing_ad(data.ads));
                        }
                    }
                    $('.found-line p').text(data.count + ' Listings Found For Sale In '+$('#search_city').val());

                    var pagination = $('.pagination');
                    pagination.empty();
                    if(data.page == 1){
                        pagination.append('<span class="page-numbers">Previous</span>');
                    } else {
                        pagination.append('<a class="prev page-numbers" data-page="'+(data.page-1)+'" href="#">Previous</a>');
                    }
                    var p_start = data.page - 5;
                    if(p_start<1){
                        p_start = 1;
                    }
                    var p_end = data.page + 5;
                    if(p_end > data.pages){
                        p_end = data.pages;
                    }
                    for (var p=p_start; p <= p_end; p++){
                        if(p == data.page){
                            pagination.append('<span class="page-numbers current">'+p+'</span>');
                        } else {
                            pagination.append('<a class="page-numbers" data-page="'+p+'" href="#">'+p+'</a>');
                        }
                    }
                    if(data.page == data.pages){
                        pagination.append('<span class="page-numbers">Next</span>');
                    } else {
                        pagination.append('<a class="prev page-numbers" data-page="'+(data.page+1)+'" href="#">Next</a>');
                    }
                }
            });
        }
        $("input.update_checks").each(function(){
            var checks = [];

            if($(this).val()){
                checks = $(this).val().split(",");
                $(".select.checkbox[rel="+$(this).attr("id")+"]").find("input[type=checkbox]").each(function(){
                    if(checks.indexOf($(this).val()) !== -1) {
                        $(this).prop('checked', true);
                    }
                });
            }
        });
        $(".select.checkbox input[type=checkbox]").click(function(){
            var res = [],
                $section = $(this).parents(".select");

            $section.find("input[type=checkbox]:checked").each(function(){
                res.push($(this).val())
            });

            $("#"+$section.attr("rel")).val(res.join(","))
        });

      $(".acc-item input, .acc-item select").each(function() {
        if ($(this).val() == "") {
          $(this).addClass("placeholder");
        } else {
          $(this).removeClass("placeholder");
        }
      });

      $(document).on("change keydown keydown",".acc-item input, .acc-item select", function() {
        if ($(this).val() == "") {
          $(this).addClass("placeholder");
        } else {
          $(this).removeClass("placeholder");
        }
      });

      $(".modal-overlay .close, .close-modal").click(function() {
          closeModal();
          return false;
      });

      $(document).keyup(function(e) {
        if (e.keyCode === 27) {
            closeModal();
        }
      });



      $("a.open-modal, .open-modal a").click(function() {
          closeModal();
          openModal($(this).attr("href"));
          return false;
      });

      if (location.hash) {
          openModal(location.hash);
      }

        function closeModal(){
            $("body").removeClass("active-modal");
            $(".modal-overlay").removeClass("active");
        }
        function openModal(id){
            $(id).find(".step1").show();
            $(id).find(".step2").hide();
            $(id).find("input[type=text], input[type=password]").val("");
            $(id).find("input[type=checkbox]").prop("checked", false);

            $("body").addClass("active-modal");
            $(id).addClass("active");
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

      // $(".trigger").click(function() {
      //   $(this).parent().toggleClass("active");
      //   $(this).next().toggleClass("active");
      //   return false;
      // });

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
        fade: true
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


        $("#login_form").submit(function(e){
            e.preventDefault();
            processAjaxForm(['login_email', 'login_password'], $(this));
        });

        $("#create_form").submit(function(e){
            e.preventDefault();
            var fields = [
                'create_firstname', 'create_lastname', 'create_email',
                'create_phone', 'create_phonetype',
                'create_pass', 'create_pass_confirm', 'create_subscribe',
                'create_user_nonce'
            ];
            processAjaxForm(fields, $(this), function (){
                $("#confirmation_emial").text($("#create_email").val());

                closeModal();
                openModal("#confirmation_modal");
            });
        });

        $("#restore_form").submit(function(e){
            e.preventDefault();
            var $this = $(this);

            var fields = ['restore_email'];
            processAjaxForm(fields, $(this), function (){
                $this.find(".step1").hide();
                $this.find(".step2").show();
            });
        });

    });


    function processAjaxForm(fields, $form, callback) {
        var data = {},
            cur;

        $(".error_placeholder").removeClass('error').hide();
        for(var i in fields) {
            $cur = $("#"+fields[i]);

            if($cur[0].type === "hidden" || $cur[0].type === "text" || $cur[0].type === "password") {
                $cur.removeClass("error");
                if(!$cur.val()) {
                    $cur.addClass("error");
                }
            } else if($cur[0].type === "checkbox") {
                $cur.parent().removeClass("error");
                if(!$cur.prop('checked')) {
                    $cur.parent().addClass("error");
                }
            }

            data[fields[i]] = $cur.val();
        }

        if($form.find(".error").length ){
            return false;
        }

        data['action'] = $form.attr("id");

        $.post({
            url: amData.ajaxurl,
            dataType: "json",
            data: data,
            success: function (data) {
                if(typeof data['error'] === 'undefined') {
                    if(callback) {
                        callback();
                    } else {
                        location.reload();
                    }
                } else {
                    $(".error_placeholder").text(data['error']).addClass('error').show();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(".error_placeholder").text('ERRORS: ' + textStatus).addClass('error').show();;
            }
        });
    }


})(jQuery);