(function($) {

    $(document).ready(function($) {
        $('.us-price').mask("000,000,000,000", {reverse: true});

        $(".history-back").click(function(){
            window.history.back()
            return false;
        });

        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(function(){
                console.log(location);
            });

        }

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
                minLength: 3,
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
                select: function (event, ui) {
                    $(event.target).val(ui.item.label);
                    var pos = {lat:ui.item.lat, lng:ui.item.lng};

                    setSmallMap(pos, ui.item.label);
                    search_listings();

                    return false;
                }
            });
            $(".search_city_button").click(function(e){
                e.preventDefault();

                if($("#search_city").val()) {
                    $("#search_city_error").hide();
                    window.location.href = $(this).attr("rel")+"?city="+$("#search_city").val();
                } else {
                    $("#search_city_error").show();
                }

            });
        }


        var map2 = null;
        var infobox = null;
        if ($("#map2").length) {
            var markers = [];
            var markerCluster = null;
            google.maps.event.addDomListener(window, 'load', function () {
                map2 = new google.maps.Map(document.getElementById('map2'), {
                    zoom: 14,
                    scrollwheel: false,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
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

                var InfoBoxData = {
                    maxWidth: 630,
                    pixelOffset: new google.maps.Size(-315, 0),
                    boxStyle: {
                        opacity: 1,
                        width: "630px"
                    },

                    content: "",
                    disableAutoPan: false,
                    zIndex: null,
                    alignBottom: true,
                    closeBoxURL: "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==",
                    infoBoxClearance: new google.maps.Size(1, 1)
                };

                if (getWidth() < 767) {
                    InfoBoxData.maxWidth = 300;
                    InfoBoxData.pixelOffset = new google.maps.Size(-150, 0),
                        InfoBoxData.boxStyle.width = "300px";
                }
                infobox = new InfoBox(InfoBoxData);


                google.maps.event.addListener(map2, "click", function (event) {
                    infobox.close();
                });
                google.maps.event.addDomListener(window, 'resize', function () {
                    var center = map2.getCenter();
                    google.maps.event.trigger(map2, "resize");
                    map2.setCenter(center);
                    infobox.close();
                });
            });
        }

        if ($("#map3").length) {
            google.maps.event.addDomListener(window, 'load', function () {
                var map = new google.maps.Map(document.getElementById("map3"), {
                    zoom: 16,
                    scrollwheel: false,
                    //disableDefaultUI: true,
                    center: position,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                new google.maps.Marker({
                    map: map,
                    position: position,
                    icon: amData.template_url+'/images/ico_mappin.png'
                });
                var service = new google.maps.places.PlacesService(map);
                var types = ['school','store','bank','gym','restaurant','supermarket'];
                var selected_types = ['school'];
                var markers = [];

                $(document).on('click','#marker_type .ico',function () {
                    var v = $(this).find("i").data('type');
                    var i = selected_types.indexOf(v);
                    if(i > -1){
                        selected_types.splice(i,1);
                    } else {
                        selected_types.push(v);
                    }
                    refresh_map();
                });

                function callback(results, status) {
                    if (status === google.maps.places.PlacesServiceStatus.OK) {
                        for (var i = 0; i < results.length; i++) {
                            var icon = null;
                            if (results[i].types.indexOf('school') !== -1) {
                                icon = amData.template_url + '/images/mgreen.png';
                            } else if (results[i].types.indexOf('supermarket') !== -1) {
                                icon = amData.template_url + '/images/mblue.png';
                            } else if (results[i].types.indexOf('restaurant') !== -1) {
                                icon = amData.template_url + '/images/myellow.png';
                            } else if (results[i].types.indexOf('bank') !== -1) {
                                icon = amData.template_url + '/images/mdgreen.png';
                            } else if (results[i].types.indexOf('store') !== -1) {

                                icon = amData.template_url + '/images/mpurple.png';
                            } else if (results[i].types.indexOf('gym') !== -1) {
                                icon = amData.template_url + '/images/mred.png';
                            }
                            if(icon){
                                createMarker(results[i], icon);
                            }
                        }
                    }
                }
                function createMarker(place,icon) {
                    var marker = new google.maps.Marker({
                        map: map,
                        position: place.geometry.location,
                        icon: icon
                    });
                    markers.push(marker);
                    google.maps.event.addListener(marker, 'click', function() {
                        infobox.setContent("<div class=inside>" + place.name + "</div>");
                        infobox.open(map, this);
                        google.maps.event.trigger(map, "resize");
                    });
                }

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

                google.maps.event.addListener(map, "click", function (event) {
                    infobox.close();
                });
                google.maps.event.addDomListener(window, 'resize', function () {
                    var center = map.getCenter();
                    google.maps.event.trigger(map, "resize");
                    map.setCenter(center);
                });
                function refresh_map() {
                    var mt = $('#marker_type');
                    mt.find('i[data-class]').each(function () {
                        $(this).attr('class', $(this).data('class'));
                    });
                    for(var m in markers) {
                        markers[m].setMap(null);
                    }
                    markers = [];
                    for(var t in types) {
                        if(selected_types.length && selected_types.indexOf(types[t])>=0) {
                            service.nearbySearch({
                                bounds: map.getBounds(),
                                type: types[t]
                            }, callback);
                            mt.find('i[data-type='+types[t]+']').attr('class','fa fa-check');
                        }
                    }
                }
                refresh_map();
                google.maps.event.addListener(map, 'dragend', refresh_map);
                google.maps.event.addListener(map, 'zoom_changed', refresh_map);

                var panorama = new google.maps.StreetViewPanorama(
                    document.getElementById('map31'), {
                        disableDefaultUI: true,
                        position: position,
                        pov: {
                            heading: 34,
                            pitch: 10
                        }
                    }
                );
            });
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

        if($('body').hasClass('page-template-listing')){
            var pos = {lat:parseFloat($('#map_lat').val()), lng:parseFloat($('#map_lng').val())};
            setSmallMap(pos, $('#map_name').val());
        }

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

        $(document).on('click', '.fav_add', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            update_fav(id, 'add');
            $('.fa[data-id='+id+']').removeClass('fav_add fa-heart-o').addClass('fav_del fa-heart');
        });

        $(document).on('click', '.fav_del', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            update_fav(id, 'del');
            $('.fa[data-id='+id+']').addClass('fav_add fa-heart-o').removeClass('fav_del fa-heart');
        });

        $(".save-favs a").click(function(e){
            e.preventDefault();

            var $item = $(this).find("i:visible"),
                id = $(this).data('id');

            if($item.hasClass("fav_add")) {
                update_fav(id, 'add');
                $(this).find("i.fav_add").parent().hide();
                $(this).find("i.fav_del").parent().show();
            } else {
                update_fav(id, 'del');
                $(this).find("i.fav_add").parent().show();
                $(this).find("i.fav_del").parent().hide();
            }
        });


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
                    var fav_listing_item = wp.template( "listing-fav" ),
                        view_listing_item = wp.template( "listing-view" ),
                        fav_list = $('#fav_tab1'),
                        view_list = $('#fav_tab2');
                    if(!fav_list.length ) {
                        return true;
                    }

                    view_list.empty();

                    if(data.view.length) {
                        for(var j in data.view) if (data.view.hasOwnProperty(j)){
                            view_list.append(view_listing_item(data.view[j]));
                        }
                    } else {
                        view_list.append('No Listings Viewed');
                    }

                    fav_list.empty();
                    if(data.fav.length) {
                        for (var i in data.fav) if (data.fav.hasOwnProperty(i)) {
                            fav_list.append(fav_listing_item(data.fav[i]));
                            $('.fa[data-id=' + data.fav[i]['listing_id'] + ']').removeClass('fav_add fa-heart-o').addClass('fav_del fa-heart');
                        }
                    } else {
                        fav_list.append('To add listings to favorites by clicking on the heart');
                    }
                }
            });
        }


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
        $(document).on('click','.clear_propertytype',function () {
            $('.checkbox[rel=hidden_propertytype] input[value='+$(this).data('val')+']').trigger('click');
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
        var view_type = 'list';
        $(document).on('click','.sub-filter li a',function () {
            view_type = $(this).data('type');
            $('.sub-filter li.current').removeClass('current');
            $('[data-type='+view_type+']').parent('li').addClass('current');
            if(view_type === 'map'){
                $('.map-full-holder').removeClass('hidden');
                $('.container.pp,.found-line').addClass('hidden');
            } else {
                $('.map-full-holder').addClass('hidden');
                $('.container.pp,.found-line').removeClass('hidden');
            }
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
        function addFilterData(data){
            if(!data) data = {};

            data['city'] = $('#search_city').val();
            data['rad'] = $('#hidden_rad').val();
            data['price_min'] = $('#hidden_price_min').val();
            data['price_max'] = $('#hidden_price_max').val();
            data['beds'] = $('#hidden_beds').val();
            data['propertytype'] = $('#hidden_propertytype').val();
            data['days_on'] = $('#days-on-select').val();
            data['baths'] = $('#baths-select').val();
            data['sqft_min'] = $('#sqft-min').val();
            data['sqft_max'] = $('#sqft-max').val();
            data['year_min'] = $('#year-built-min').val();
            data['year_max'] = $('#year-built-max').val();
            data['sale_by'] = $('.show_only:checked').map(function(){return $(this).val()}).get().join(',');
            data['features_1'] = $('.features_1:checked').map(function(){return $(this).val()}).get().join(',');
            data['sort_by'] = $('#sort_by').val();
            data['page'] = $('#page').val();
            data['page_id'] = $('#page_id').val();
            data['rent'] = $('body').hasClass('page-template-rent');

            return data;
        }
        $(document).on('click','.save_search',function () {
            if($('#email_modal').length){
                openModal('#email_modal');
            } else {
                $.ajax({
                    url: amData.ajaxurl,
                    dataType: "json",
                    data: addFilterData({
                        action: 'saveSearch'
                    }),
                    success: function (data) {
                        closeModal();
                        openModal('#save_search_modal');
                    }
                });
            }
            return false;
        });
        $('#saveSearchEmail').submit(function (e) {
            e.preventDefault();

            processAjaxForm(
                ['save_email', 'send_email', 'g-recaptcha-response'],
                $(this),
                function (data){
                    closeModal();
                    openModal('#save_search_modal');
                }, [], addFilterData()
            );
        });
        function search_listings() {
            if(!$('body').hasClass('page-template-buy') && !$('body').hasClass('page-template-rent')){
                return false;
            }
            var view_type = $(".container .sub-filter li.current a").data('type');

            if(!$('.ad-listing').length && view_type !== 'map'){
                return false;
            }
            $.ajax({
                url: amData.ajaxurl,
                dataType: "json",
                data: addFilterData({
                    action: 'getListings',
                    type: view_type
                }),
                success: function (data) {
                    if(view_type === 'map') {
                        if(markerCluster){
                            markerCluster.setMap(null);
                        }

                        if(data.items.length){
                            var bounds = new google.maps.LatLngBounds();
                            for(var c in data.items) if(data.items.hasOwnProperty(c)) {
                                bounds.extend(new google.maps.LatLng({lat: parseFloat(data.items[c].lat), lng: parseFloat(data.items[c].lng)}));
                            }

                            google.maps.event.trigger(map2, 'resize');
                            map2.fitBounds(bounds);
                            map2.setZoom(map2.getZoom()-2);

                            markers = data.items.map(function(l) {
                                var marker = new google.maps.Marker({
                                    position: {lat:parseFloat(l.lat), lng:parseFloat(l.lng)},
                                    icon: amData.template_url+'/images/ico_mappin.png'
                                });
                                marker.listing_id = l.listing_id;
                                google.maps.event.addListener(marker, 'click', (function(m) {

                                    return function() {
                                        $.ajax({
                                            url: amData.ajaxurl,
                                            dataType: "json",
                                            data: {
                                                action: 'getListingItem',
                                                'listing_id': m.listing_id
                                            },
                                            success: function (data) {
                                                listing_item = wp.template( "popup-item" );
                                                infobox.setContent(listing_item(data));
                                                infobox.open(map2, m);
                                                google.maps.event.trigger(map2, "resize");
                                            }
                                        });
                                    }
                                })(marker));
                                return marker;
                            });
                            markerCluster = new MarkerClusterer(map2, markers, {imagePath: amData.template_url+'/images/m'});
                        }
                    } else {
                        var list = $('.ad-listing'),
                            listing_ad = wp.template( "listing-ad" ),
                            pagination = $('.pagination'),
                            filtered = $('.applied-filters ul'),
                            listing_item;

                        if(view_type === 'grid'){
                            listing_item = wp.template( "grid-item" );
                            list.addClass('gallery');
                        } else {
                            listing_item = wp.template( "listing-item" );
                            list.removeClass('gallery');
                        }
                        list.empty();


                        filtered.empty();
                        if (data.filtered) {
                            filtered.append(data.filtered);
                            $('.applied-filters').show();
                        } else {
                            $('.applied-filters').hide();
                        }

                        pagination.empty();
                        if(data.pagination) {
                            pagination.append(data.pagination);
                            $(".pagination-holder").show();
                        } else {
                            $(".pagination-holder").hide();
                        }

                        if(data.featured.listing_id || data.items.length) {
                            var index = 0;
                            if (data.featured.listing_id) {
                                list.append(listing_item(data.featured));
                                index++;
                            }
                            for (var i in data.items) if (data.items.hasOwnProperty(i)) {
                                list.append(listing_item(data.items[i]));

                                if ((view_type==='grid' && index % 9 === 8) || (view_type==='list' && index % 5 === 4)) {
                                    list.append(listing_ad(data.ads));
                                }
                            }

                            $('.found-line p .result_num').text(data.count + (data.featured?1:0));
                            if($('#search_city').val()) {
                                $('.found-line p .result_city_in').show();
                                $('.found-line p .result_city').text($('#search_city').val());
                            } else {
                                $('.found-line p .result_city_in').hide();
                                $('.found-line p .result_city').text('');
                            }

                            $('.found-line p').removeClass('hidden');
                            $('.sub-filter').show();
                        } else {
                            list.append(data.no_result);

                            $('.found-line p').addClass('hidden');
                            $('.sub-filter').hide();
                        }
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

            var form = $($(this).attr("href")).addClass("active");
            if($(this).data('id')) {
                form.find('input[name=listing_id]').val($(this).data('id'));
            }
            return false;
        });

        if(window.location.hash) {
            activateTab($('.tab-control a[href$="'+window.location.hash+'"]'));
            openModal(location.hash);
        }

        function closeModal(){
            $("body").removeClass("active-modal");
            $(".modal-overlay").removeClass("active");
        }
        function openModal(id){
            if($(id).find(".step1").length) {
                $(id).find(".step1").show();
                $(id).find(".step2").hide();
                $(id).find("input[type=text], input[type=password]").val("");
                $(id).find("input[type=checkbox]").prop("checked", false);

                $("body").addClass("active-modal");
                $(id).addClass("active");
            }
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

        $(".tab-control a").click(function() {
            activateTab($(this));
            return false;
        });
        function activateTab($link){
            if(!$link.length) return false;
            var $parent = $link.parents("ul");

            $($parent.find("li.current a").attr("href")).removeClass("current");
            $parent.find("li.current").removeClass("current");

            $link.parent().addClass("current");
            $($link.attr("href")).addClass("current");
        }


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


        $(".submit").click(function (e) {
            e.preventDefault();

            var $form = $(this).parents('form');
            if($form.length) {
                $form.submit();
            }
        });

        $("#login_form").submit(function(e){
            e.preventDefault();
            processAjaxForm(['login_email', 'login_password'], $(this));
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

        $("#create_form").submit(function(e){
            e.preventDefault();
            var fields = [
                'create_firstname', 'create_lastname', 'create_email',
                'create_phone', 'create_phonetype',
                'create_pass', 'create_pass_confirm', 'create_subscribe'
            ];
            processAjaxForm(fields, $(this), function (){
                $("#confirmation_emial").text($("#create_email").val());

                closeModal();
                openModal("#confirmation_modal");
            }, ['create_user_nonce']);
        });

        $("#edit_account_form").submit(function(e){
            e.preventDefault();
            var fields = [
                'edit_firstname', 'edit_lastname', 'edit_email',
                'edit_phone', 'edit_phonetype'
            ];
            processAjaxForm(fields, $(this), function (){
                showSavedConfirmation($("#edit_account_form"));
            }, ['edit_user_nonce']);
        });

        $("#edit_payment_form").submit(function(e){
            e.preventDefault();
            var fields = [
                'cardholder_name', 'cc_number', 'cc_type', 'cvv',
                'cc_date_m', 'cc_date_y'
            ];

            processAjaxForm(fields, $(this), function (data){
                showSavedConfirmation($("#edit_payment_form"));
                $("#cardholder_name, #cc_number, #cc_type, #cc_date_m, #cc_date_y, #cc_uid, #cvv").val('');
                addUpdateCCRow(data);
            }, ['edit_user_nonce', 'cc_uid']);

            function addUpdateCCRow(data) {
                var $row = $("#cc-list .row-"+data['cc_uid']),
                    rowHtml = '<td>'+data['cc_type']+'</td>\n' +
                        '<td>'+data['cc_number_safe']+'</td>\n' +
                        '<td>'+data['cc_date_m'] + '/' + data['cc_date_y']+'</td>\n' +
                        '<td class="text-right"><a href="#" class="btn btn-secondary btn-sm edit-cc" data-id="'+data['cc_uid']+'">Edit</a>\n' +
                        '<a href="#" class="btn btn-secondary btn-sm delete-cc" data-id="'+data['cc_uid']+'">Delete</a></td>\n';

                if($row.length) {
                    $row.html(rowHtml);
                } else {
                    $("#no-cards").hide();
                    $("#cc-list").append('<tr class="row-'+data['cc_uid']+'">\n' + rowHtml + '</tr>');
                }
            }
        });
        $("#cc-list").on("click", ".edit-cc", function (e) {
            e.preventDefault();

            var data = {'action':'edit_cc','cc_uid':$(this).data("id")};
            $.post({
                url: amData.ajaxurl,
                dataType: "json",
                data: data,
                success: function (data) {
                    if(typeof data['error'] === 'undefined') {
                        $("#cardholder_name").val(data['cardholder_name']).removeClass("placeholder");
                        $("#cc_number").val(data['cc_number']).removeClass("placeholder");
                        $("#cc_type").val(data['cc_type']).removeClass("placeholder");
                        $("#cc_date_m").val(data['cc_date_m']).removeClass("placeholder");
                        $("#cc_date_y").val(data['cc_date_y']).removeClass("placeholder");
                        $("#cvv").val(data['cvv']).removeClass("placeholder");
                        $("#cc_uid").val(data['cc_uid']).removeClass("placeholder");
                    } else {
                        $("#cc-list").find(".error_placeholder").text(data['error']).addClass('error').show();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $("#cc-list").find(".error_placeholder").text('ERRORS: ' + textStatus).addClass('error').show();
                }
            });
        });
        $("#cc-list").on("click", ".delete-cc", function (e) {
            e.preventDefault();
            if(!confirm("Are you sure?")) return false;

            var uid = $(this).data("id"),
                data = {'action':'delete_cc','cc_uid':uid};
            $.post({
                url: amData.ajaxurl,
                dataType: "json",
                data: data,
                success: function (data) {
                    if(typeof data['error'] === 'undefined') {
                        $("#edit_payment_form .delete-confirmation").show();
                        setTimeout(function () {
                            $("#edit_payment_form .delete-confirmation").fadeOut(400);
                        }, 1000);

                        $("#cc-list .row-"+uid).remove();
                    } else {
                        $("#cc-list").find(".error_placeholder").text(data['error']).addClass('error').show();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $("#cc-list").find(".error_placeholder").text('ERRORS: ' + textStatus).addClass('error').show();
                }
            });
        });


        $("#edit_password_form").submit(function(e){
            e.preventDefault();
            var fields = [
                'edit_old_password', 'edit_new_password', 'edit_confirm_password',
                'edit_user_nonce'
            ];
            processAjaxForm(fields, $(this), function (){
                showSavedConfirmation($("#edit_password_form"));
                $("#edit_old_password, #edit_new_password, #edit_confirm_password").val('');
            });
        });
    });

    $('#reportListing').submit(function (e) {
        e.preventDefault();
        processAjaxForm(
            ['report_url', 'report_full_name','report_email','report_reason','report_text','g-recaptcha-response'],
            $(this),
            function (data){
                if(data['ok']){
                    $('#report .close').trigger('click');
                }
            },
            ['report_phone','report_send_copy']
        );
    });

    $(".checked-one").change(function(){
        if($(this).is(":checked")) {
            $(this).parents(".checked-one_holder").find(".checked-one").not($(this)).prop("checked", false);
            $("#" + $(this).attr("rel")).val($(this).val());
        } else {
            $("#" + $(this).attr("rel")).val('');
        }
    });

    $('.mortage-calc').keyup(function () {
        processAjaxForm(['calc_price','calc_deposit','calc_rate','calc_period'],
            $("#getMortage"),
            function (data){
                if(data){
                    $('.calc_payment').text(data);
                } else {
                    $('.calc_payment').text("");
                }
            }
        );

    });

    if (navigator.geolocation && $("body").hasClass("page-template-community-partners")) {
        var key = "",
            html_key = [];

        if($(".page-head").length) {
            key = "industries";
            html_key = ["industries"];
        }
        if($(".category-head").length) {
            key = "partners";
            html_key = ["common", "featured", "pagination"];

        }

        navigator.geolocation.getCurrentPosition(function (position) {
            //renderPartnes(position.coords.latitude, position.coords.longitude, key, html_key);
            renderPartnes(0, 0, key, html_key);
        }, function () {
            renderPartnes(0, 0, key, html_key);
        });
    }

    function renderPartnes(lat, lng, key, html_key) {
        if($("body").hasClass("page-template-community-partners")) {
            var data = {action: "get_"+key, lat:lat, lng:lng};
                if($("#agents-sort").length) {
                    data["sort"] = $("#agents-sort").val();
                }

            $.post({
                url: amData.ajaxurl,
                dataType: "json",
                data: data,
                success: function (data) {
                    for(var data_key in html_key) {

                        if(data.hasOwnProperty(html_key[data_key])) {
                            if($( '#tmpl-' + html_key[data_key] + "-item").length) {
                                var tpl_item = wp.template(html_key[data_key] + "-item");
                                var list = $('#' + html_key[data_key] + '-placeholder');
                                list.empty();
                                for (var i in data[html_key[data_key]]) if (data[html_key[data_key]].hasOwnProperty(i)) {
                                    list.append(tpl_item(data[html_key[data_key]][i]));
                                }
                            } else {
                                $('#' + html_key[data_key] + '-placeholder').html(data[html_key[data_key]]);
                                if($('#' + html_key[data_key] + '-rel').length) $('#' + html_key[data_key] + '-rel').show();
                            }
                        } else {
                            if($('#' + html_key[data_key] + '-rel').length) $('#' + html_key[data_key] + '-rel').hide();
                        }
                    }
                }
            }).fail(function(){
                for(var data_key in html_key) {
                    if ($('#' + html_key[data_key] + '-rel').length) $('#' + html_key[data_key] + '-rel').hide();
                }
            })
        }
    }

})(jQuery);


function processAjaxForm(requiredFields, $form, callback, additionalFiels, initialData) {

    if(vaidateAjaxForm(requiredFields, $form)) {
        return false;
    }

    var data = buildDataAjaxForm(requiredFields, $form, additionalFiels, initialData);

    jQuery.post({
        url: amData.ajaxurl,
        dataType: "json",
        data: data,
        success: function (data) {
            if(data) {
                if (typeof data['error'] === 'undefined') {
                    if (callback) {
                        callback(data);
                    } else {
                        location.reload();
                    }
                } else {
                    $form.find(".error_placeholder").text(data['error']).addClass('error').show();
                    jQuery('html, body').animate({
                        scrollTop: jQuery(".error_placeholder").eq(0).offset().top-100
                    }, 500);
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $form.find(".error_placeholder").text('ERRORS: ' + textStatus).addClass('error').show();
        }
    });
}

function vaidateAjaxForm(requiredFields, $form) {
    var error = false, i;

    $form.find(".error_placeholder").removeClass('error').hide();

    for(i in requiredFields) {
        if (requiredFields.hasOwnProperty(i)) {
            $cur = jQuery("#" + requiredFields[i]);

            if ($cur[0].type === "hidden" || $cur[0].type === "text" || $cur[0].type === "email" || $cur[0].type === "password" || $cur[0].tagName === "SELECT" || $cur[0].tagName === "TEXTAREA") {

                var $target = $cur;
                if ($cur.attr("rel")) {
                    $target = jQuery("." + $cur.attr("rel"));
                }
                if ($cur.hasClass('g-recaptcha-response')) {
                    $target = $cur.parent();
                }

                $target.removeClass("error");
                if (!$cur.val()) {
                    $target.addClass("error");
                    error = true;
                }

            } else if ($cur[0].type === "checkbox") {
                $cur.parent().removeClass("error");
                if (!$cur.prop('checked')) {
                    $cur.parent().addClass("error");
                    error = true;
                }
            }
        }
    }

    if(error) {
        jQuery('html, body').animate({
            scrollTop: jQuery(".error").eq(0).offset().top-100
        }, 500);
    }
    return error;
}

function buildDataAjaxForm(requiredFields, $form, additionalFiels, data) {
    var $cur, i;

    if(!data) data = {};
    for(i in requiredFields) {
        if (requiredFields.hasOwnProperty(i)) {
            $cur = jQuery("#" + requiredFields[i]);
            data[requiredFields[i]] = $cur.val();
        }

    }

    if(additionalFiels) {
        for(i in additionalFiels) {
            if (additionalFiels.hasOwnProperty(i)) {
                $cur = jQuery("#" + additionalFiels[i]);
                if($cur.length) {
                    if ($cur[0].type !== "checkbox" || $cur.prop('checked')) {
                        data[additionalFiels[i]] = $cur.val();
                    } else {
                        data[additionalFiels[i]] = '';
                    }
                } else {
                    console.log(additionalFiels[i]);
                }
            }
        }
    }

    data['action'] = $form.attr("id");

    return data;
}


function initPaymentForm(type, id, callback) {
    var payment_form = wp.template( "payment" );
    jQuery.post(amData.ajaxurl, {
        'action':'getPaymentForm',
        'type':type,
        'id':id
    }, function(ret){
        jQuery('#payment').empty().append(payment_form(ret));
        if(callback) {
            callback();
        }
    }, 'json');
}

function showSavedConfirmation($section) {
    jQuery(".saved-confirmation").hide();
    $section.find(".saved-confirmation").show();
    setTimeout(function () {
        $section.find(".saved-confirmation").fadeOut(400);
    }, 1000);
    window.scrollTo(0,0);
}

function setPromoHndlers(id, entityType, callback){
    jQuery("#apply-promo").click(function (e) {
        e.preventDefault();
        if(!jQuery("#promo_code").val()) return false;
        updatePromo(id, entityType, callback, jQuery("#promo_code").val());
    });

    jQuery("#remove-promo").click(function(e){
        e.preventDefault();
        updatePromo(id, entityType, callback, "");
    });

    function updatePromo(id, entityType, callback, code) {
        var data = {
            'action':'updatePromo',
            'entity_id' : id,
            'entity_type' : entityType,
            'promo_code': code
        };
        jQuery.post(amData.ajaxurl, data, function(ret){
            if(ret.errors) {
                jQuery("#promo_code_error ").show().find("div").text(ret.errors);
            } else {
                callback(id);
            }
        }, 'json');
    }
}