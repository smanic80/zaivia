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
        if($('body').hasClass('page-template-buy') || $('body').hasClass('page-template-rent')){
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
        if($('body').hasClass('page-template-listing')){
            var pos = {lat:parseFloat($('#map_lat').val()), lng:parseFloat($('#map_lng').val())};
            setSmallMap(pos, $('#map_name').val());
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
                    if(data.fav.length) {
                        for (var i in data.fav) if (data.fav.hasOwnProperty(i)) {
                            fav_list.append(listing_item(data.fav[i]));
                            $('.fa[data-id=' + data.fav[i]['listing_id'] + ']').removeClass('fav_add fa-heart-o').addClass('fav_del fa-heart');
                        }
                    } else {
                        fav_list.append('To add listings to favorites by clicking on the heart');
                    }
                    var view_list = $('#fav_tab2');
                    view_list.empty();
                    if(data.fav.view) {
                        for(var j in data.view) if (data.view.hasOwnProperty(j)){
                            view_list.append(listing_item(data.view[j]));
                        }
                    } else {
                        view_list.append('No Listings Viewed');
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
        $(document).on('click','.clear_price',function () {
            $(this).parent().remove();
            $('#hidden_price_min').val('');
            $('#hidden_price_max').val('');
            search_listings();
            return false;
        });
        $(document).on('click','.clear_beds',function () {
            $(this).parent().remove();
            $('#hidden_beds').val('');
            search_listings();
            return false;
        });
        $(document).on('click','.clear_hometype',function () {
            $('.checkbox[rel=hidden_hometype] input[value='+$(this).data('val')+']').trigger('click');
            $(this).parent().remove();
            return false;
        });
        $(document).on('click','.clear_show_only',function () {
            $('.show_only[value='+$(this).data('val')+']').trigger('click');
            $(this).parent().remove();
            return false;
        });
        $(document).on('click','.clear_features_1',function () {
            $('.features_1[value='+$(this).data('val')+']').trigger('click');
            $(this).parent().remove();
            return false;
        });
        $(document).on('click','.clear_sqft-min',function () {
            $('#sqft-min').val('');
            search_listings();
            $(this).parent().remove();
            return false;
        });
        $(document).on('click','.clear_sqft-max',function () {
            $('#sqft-max').val('');
            search_listings();
            $(this).parent().remove();
            return false;
        });
        $(document).on('click','.clear_year-built-min',function () {
            $('#year-built-min').val('');
            search_listings();
            $(this).parent().remove();
            return false;
        });
        $(document).on('click','.clear_year-built-max',function () {
            $('#year-built-max').val('');
            search_listings();
            $(this).parent().remove();
            return false;
        });
        $(document).on('click','.sub-filter li a',function () {
            $(this).parent().parent().find('.current').removeClass('current');
            $(this).parent('li').addClass('current');
            search_listings();
            return false;
        });
        if($('#market').length){
            $.ajax({
                url: amData.ajaxurl,
                dataType: "json",
                data: {
                    action: 'getMarket',
                    id: $('#listing_id').val()
                },
                success: function (data) {
                    var listing_item = wp.template( "listing-item" );
                    var list = $('#sale').find('.ad-listing');
                    list.empty();
                    for(var i in data.sale) if (data.sale.hasOwnProperty(i)){
                        list.append(listing_item(data.sale[i]));
                    }
                    list = $('#offer').find('.ad-listing');
                    list.empty();
                    for(var j in data.offer) if (data.offer.hasOwnProperty(j)){
                        list.append(listing_item(data.offer[j]));
                    }
                    list = $('#sold').find('.ad-listing');
                    list.empty();
                    for(var k in data.sold) if (data.sold.hasOwnProperty(k)){
                        list.append(listing_item(data.sold[k]));
                    }
                }
            });
        }

        $(document).on('click','.save_search',function () {
            $.ajax({
                url: amData.ajaxurl,
                dataType: "json",
                data: {
                    action: 'saveSearch',
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
                    page_id:$('#page_id').val(),
                    rent: $('body').hasClass('page-template-rent')
                },
                success: function (data) {
                    alert('success');
                }
            });
            return false;
        });
        function search_listings() {
            var filtered = $('.applied-filters ul');
            filtered.empty();
            if($('#hidden_price_min').val() && $('#hidden_price_max').val()){
                filtered.append('<li><a href="#" class="clear_price"><i class="fa fa-times" aria-hidden="true"></i></a>'+$('#hidden_price_min').val()+' - '+$('#hidden_price_max').val()+'</li>');
            }
            if($('#hidden_beds').val()){
                filtered.append('<li><a href="#" class="clear_beds"><i class="fa fa-times" aria-hidden="true"></i></a>'+$('#hidden_beds').val()+'+ Beds</li>');
            }
            var items = $('.checkbox[rel=hidden_hometype] input:checked');
            if(items.length){
                items.each(function (key,item) {
                    filtered.append('<li><a href="#" class="clear_hometype" data-val="'+$(item).val()+'"><i class="fa fa-times" aria-hidden="true"></i></a>'+$(item).val()+'</li>');
                })
            }
            items = $('.show_only:checked');
            if(items.length){
                items.each(function (key,item) {
                    filtered.append('<li><a href="#" class="clear_show_only" data-val="'+$(item).val()+'"><i class="fa fa-times" aria-hidden="true"></i></a>'+$(item).next().text()+'</li>');
                })
            }
            items = $('.features_1:checked');
            if(items.length){
                items.each(function (key,item) {
                    filtered.append('<li><a href="#" class="clear_features_1" data-val="'+$(item).val()+'"><i class="fa fa-times" aria-hidden="true"></i></a>'+$(item).next().text()+'</li>');
                })
            }
            if($('#sqft-min').val()){
                filtered.append('<li><a href="#" class="clear_sqft-min"><i class="fa fa-times" aria-hidden="true"></i></a>Square Min '+$('#sqft-min').val()+' Feet</li>');
            }
            if($('#sqft-max').val()){
                filtered.append('<li><a href="#" class="clear_sqft-max"><i class="fa fa-times" aria-hidden="true"></i></a>Square Max '+$('#sqft-max').val()+' Feet</li>');
            }
            if($('#year-built-min').val()){
                filtered.append('<li><a href="#" class="clear_year-built-min"><i class="fa fa-times" aria-hidden="true"></i></a>Year Built Min '+$('#year-built-min').val()+'</li>');
            }
            if($('#year-built-max').val()){
                filtered.append('<li><a href="#" class="clear_year-built-max"><i class="fa fa-times" aria-hidden="true"></i></a>Year Built Max '+$('#year-built-max').val()+'</li>');
            }

            if(filtered.find('li').length){
                $('.applied-filters').show();
            } else {
                $('.applied-filters').hide();
            }
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
                    page_id:$('#page_id').val(),
                    rent: $('body').hasClass('page-template-rent')
                },
                success: function (data) {
                    var type = $('.sub-filter li.current a').data('type');
                    var list = $('.ad-listing');
                    var listing_item;
                    if(type === 'grid'){
                        listing_item = wp.template( "grid-item" );
                        list.addClass('gallery');
                    } else {
                        listing_item = wp.template( "listing-item" );
                        list.removeClass('gallery');
                    }
                    var listing_ad = wp.template( "listing-ad" );
                    list.empty();
                    var pagination = $('.pagination');
                    pagination.empty();

                    if(data.featured || data.items.length) {
                        var index = 0;
                        if (data.featured) {
                            list.append(listing_item(data.featured));
                            index++;
                        }
                        for (var i in data.items) if (data.items.hasOwnProperty(i)) {
                            list.append(listing_item(data.items[i]));

                            if ((type==='grid' && index % 9 === 8) || (type==='list' && index % 5 === 4)) {
                                list.append(listing_ad(data.ads));
                            }
                        }
                        $('.found-line p').text(data.count + ' Listings Found For Sale In ' + $('#search_city').val());

                        if (data.page == 1) {
                            pagination.append('<span class="page-numbers">Previous</span>');
                        } else {
                            pagination.append('<a class="prev page-numbers" data-page="' + (data.page - 1) + '" href="#">Previous</a>');
                        }
                        var p_start = data.page - 5;
                        if (p_start < 1) {
                            p_start = 1;
                        }
                        var p_end = data.page + 5;
                        if (p_end > data.pages) {
                            p_end = data.pages;
                        }
                        for (var p = p_start; p <= p_end; p++) {
                            if (p == data.page) {
                                pagination.append('<span class="page-numbers current">' + p + '</span>');
                            } else {
                                pagination.append('<a class="page-numbers" data-page="' + p + '" href="#">' + p + '</a>');
                            }
                        }
                        if (data.page == data.pages) {
                            pagination.append('<span class="page-numbers">Next</span>');
                        } else {
                            pagination.append('<a class="prev page-numbers" data-page="' + (data.page + 1) + '" href="#">Next</a>');
                        }
                        $('.sub-filter').show();
                    } else {
                        $('.found-line p').text('');
                        $('.sub-filter').hide();
                        list.append('<div class="no-found-line"><h1>No Search Results Found</h1><p>Please try searching for properties in a different city.</p></div>');
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
        var form = $($(this).attr("href")).addClass("active");
        if($(this).data('id')) {
            form.find('input[name=listing_id]').val($(this).data('id'));
        }
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

})(jQuery);