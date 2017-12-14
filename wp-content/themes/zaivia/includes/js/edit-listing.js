(function($) {

    var marker = null;
    var listingData = {
        'listing_id': $("#listing_id").val(),
        'MLSNumber':null,
        'sale_rent':null,
        'sale_by':null,
        'address':null,
        'unit_number':null,
        'city':null,
        'province':null,
        'zip':null,
        'neighbourhood':null,
        'lat':null,
        'lng':null,
        'price':null,
        'property_type':null,
        'house_type':null,
        'square_footage':null,
        'bedrooms':null,
        'bathrooms':null,
        'roof_type':null,
        'exterior_type':null,
        'parking':null,
        'driveway':null,
        'size_x':null,
        'size_y':null,
        'size_units':null,
        'year_built':null,
        'annual_taxes':null,
        'condo_fees':null,
        'partial_rent':[],
        'features_1':[],
        'features_1_custom':[],
        'features_2':[],
        'features_2_custom':[],
        'features_3':[],
        'features_3_custom':[],
        'room_features':[],
        'description':null,
        'status':null,
        'featured':null,
        'premium':null,
        'url':null,
        'bump_up':null,
        'rent_date':null,
        'rent_deposit':null,
        'rent_furnishings':null,
        'rent_pets':null,
        'rent_smoking':null,
        'rent_laundry':null,
        'rent_file':null,
        'rent_electrified_parking':null,
        'rent_secured_entry':null,
        'rent_private_entry':null,
        'rent_onsite':null,
        'rent_utilities':[],
    };

    $(document).ready(function($) {


        refreshRentSaleFields();
        $("#sale_rent").change(refreshRentSaleFields);
        $(".status").change(function(){
            $("#status").val($(this).val());
        });

        $("#rent_file_input").change(function(event){
            files = event.target.files;
            var form = new FormData();
            $.each(files, function(key, value){
                form.append(key, value);
            });
            form.append('action', 'uploadLisingFile');

            $.ajax({
                url: amData.ajaxurl,
                type: 'POST',
                data: form,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(data, textStatus, jqXHR)
                {
                    if(typeof data.error === 'undefined')
                    {
                        $("#rent_file").val(data[0]['url']);
                        var parts = data[0]['url'].split( '/' );
                        $("#rent_file_name").text(parts[parts.length-1]);
                    }
                    else
                    {
                        console.log('ERRORS: ' + data.error);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    console.log('ERRORS: ' + textStatus);
                }
            });
        });


        if ($("#map").length) {

            var map;

            $("#zip").change(function(){
                var zip = $(this).val();

                if(!postalFilter(zip)) {
                    $(this).addClass('error');
                    return;
                }
                $(this).removeClass('error');

                var geocoder = new google.maps.Geocoder;

                geocoder.geocode({
                    'address': zip, "componentRestrictions": {"country":"CA"}
                }, function (results, status) {

                    if (status == google.maps.GeocoderStatus.OK) {

                        $("#map-wrap").show();

                        map = new google.maps.Map(document.getElementById('map'), {
                            scrollwheel: true,
                            navigationControl: true,
                            mapTypeControl: true,
                            scaleControl: true,
                            disableDefaultUI: false,
                            center: results[0].geometry.location,
                            zoom: 17
                        });

                        google.maps.event.addDomListener(window, 'resize', function() {
                            var center = map.getCenter();
                            google.maps.event.trigger(map, "resize");
                            map.setCenter(center);
                        });
                        google.maps.event.addListenerOnce(map, 'idle');

                        google.maps.event.addListener(map, 'click', function(event) {
                            placeMarker(event.latLng);
                        });

                        $("#error-zip").hide();
                    } else {
                        $("#error-zip").show();
                    }
                });
            });

            if($("#zip").val()) {
                $("#zip").trigger("change");

                if($("#lat").val() && $("#lng").val()) {
                    var loc = {lat : parseFloat($("#lat").val()), lng : parseFloat($("#lng").val())};

                    var interval = setInterval(function(){
                        if(map) {
                            placeMarker(loc);
                            clearInterval(interval);
                        }
                    }, 100);
                }
            }

            function placeMarker(location) {
                if(marker) marker.setMap(null);

                marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    icon: amData.template_url+'/images/ico_mappin.png'
                });

                var latlng = {lat: parseFloat(marker.getPosition().lat()), lng: parseFloat(marker.getPosition().lng())};

                var geocoder = new google.maps.Geocoder;

                $("#lat").val(marker.getPosition().lat());
                $("#lng").val(marker.getPosition().lng());

                geocoder.geocode({'location': latlng}, function(results, status) {

                    var addr = {'unit_number':'','address':'','city':'','province':'','neighbourhood':''};

                    if (status === google.maps.GeocoderStatus.OK) {
                        if (results[1]) {
                            console.log(results[0]);
                            for(i in results[0].address_components) {
                                if(results[0].address_components[i].types[0] === 'postal_code') {
                                    if(results[0].address_components[i].long_name !== $("#zip").val().trim()){
                                        $("#error-place").show();
                                    } else {
                                        $("#error-place").hide();
                                    }
                                }

                                switch(results[0].address_components[i].types[0]) {
                                    case 'street_number': addr.unit_number = results[0].address_components[i].long_name; break;
                                    case 'route': addr.address = results[0].address_components[i].long_name; break;
                                    case 'locality': addr.city = results[0].address_components[i].long_name; break;
                                    case 'administrative_area_level_1': addr.province = results[0].address_components[i].short_name; break;
                                    case 'administrative_area_level_2': addr.neighbourhood = results[0].address_components[i].long_name; break;
                                }
                            }
                            if(!$("#error-place").is(":visible")){
                                $("#unit_number").val(addr.unit_number).removeClass("placeholder");
                                $("#address").val(addr.address).removeClass("placeholder");
                                $("#city").val(addr.city).removeClass("placeholder");
                                $("#province").val(addr.province).removeClass("placeholder");
                                $("#neighbourhood").val(addr.neighbourhood).removeClass("placeholder");
                            }
                        } else {
                            window.alert('No results found');
                        }
                    } else {
                        window.alert('Geocoder failed due to: ' + status);
                    }
                });
            }
        }

        $(".listing-step").click(function(){
            var curStep =  $(".steps-all li.cur").attr("id").split("-")[1],
                nextStep = $(this).attr("rel");

            updateListingObj();

            if(nextStep > curStep){
                validateStep($("#step"+curStep), function() {
                    gotoStep(nextStep, true);
                });
            } else {
                gotoStep(nextStep, false);
            }

            return false;
        });

        $(".save-draft").click(function(e){
            e.preventDefault();

            var curStep =  $(".steps-all li.cur").attr("id").split("-")[1];

            updateListingObj();

            listingData.to_delete = 0;
            validateStep($("#step"+curStep), function() {
                alert("Listing saved");
            });
        });


        initdatepicker($(".datepicker"));

        $(document).on('click','#add-openhouse',function(){
            var $block = $("#openhouse-block").clone();
            $block.find('.datepicker-hidden').addClass('datepicker').removeClass('datepicker-hidden');
            $block.removeAttr("id").addClass('array-row').show();
            $("#more-openhouse").before($block);
            initdatepicker($block.find(".datepicker"));

            return false;
        });
        $(document).on('click','.trigger',function(){
            $(this).prev('.datepicker').datepicker('show');
        });
        $(document).on('click','.remove-openhouse',function(){
            if($(".openhouse-block").length <= 2) {
                $(this).parents(".openhouse-block").find("input").val("").addClass('placeholder');
                $(this).parents(".openhouse-block").find("select").val("");
            } else {
                $(this).parents(".openhouse-block").remove();
            }

            return false;
        });

        function initdatepicker($obj) {
            $obj.datepicker({ dateFormat: 'mm/dd/yy' });
        }

        function updateListingObj() {
            var collect, sub={}, subkey;

            $(".tosave").each(function(){
                collect = [];
                if( $(this).hasClass("array") ) {
                    $(this).find(".array-row").each(function(){
                        var arr = {};
                        $(this).find("input,select").each(function(){
                            arr[$(this).attr('name')] = $(this).val();
                        });
                        collect.push(arr);
                    });
                    listingData[$(this).attr("id")] = collect;
                } else if( $(this).hasClass("group") ) {

                    $(this).find(".save-item").each(function(){
                        if($(this).attr("type") === 'checkbox' && $(this).is(":checked") ) collect.push($(this).val());
                        if($(this).attr("type") === 'text' && $(this).val() ) collect.push($(this).val());
                    });

                    if(collect.length) {
                        if ($(this).data("key") === 'room_features') {
                            subkey = $(this).data("subkey");
                            sub[subkey] = collect;
                            listingData[$(this).data("key")] = sub;
                        } else {
                            listingData[$(this).data("key")] = collect;
                        }
                    }

                } else {
                    if($(this).attr("id") in listingData) {
                        listingData[$(this).attr("id")] = ($(this).attr('type')==='checkbox')?($(this).prop('checked')?1:0):$(this).val();
                    } else {
                        alert("listing key not found " + $(this).attr("id"));
                    }
                }
            });

            console.log(listingData);
        }
    });



    function gotoStep(stepN, isDone){
        $(".listing-steps").hide();
        $("#step"+stepN).show();

        if(isDone) $(".steps-all li.current").addClass("done");
        $(".steps-all .cur").removeClass("cur");
        $(".steps-all li#stepbc-"+stepN).addClass("current").addClass("cur");
    }

    function refreshRentSaleFields(){
        var curClass = ".salerent_"+$("#sale_rent").val();

        $(".salerent_0, .salerent_1").hide();
        $(curClass).show();
    }



    function validateStep($form, callback) {
        var $fieldsReq = $form.find(".required"),
            $fieldsZip = $form.find(".zip"),
            data = {
                'action':'valideLisingStep',
                'required': {},
                'zip': {},
                'listing-data': JSON.stringify(listingData)
            };

        $fieldsReq.removeClass("error");
        $fieldsReq.each(function () {
            data.required[$(this).attr("id")] = $(this).val();
        });
        $fieldsZip.removeClass("error");
        $fieldsZip.each(function () {
            data.zip[$(this).attr("id")] = $(this).val();
        });

        $.post(amData.ajaxurl, data, function(ret){
            var error = false;
            for(i in ret.errors){
                if($("#"+ret.errors[i]).length){
                    $("#"+ret.errors[i]).addClass("error");
                    error = true
                }
            }
            listingData.listing_id = ret.listing_id;

            if(!error && !$(".error:visible").length) {
                callback()
            }
        }, 'json');
    }

    function postalFilter (postalCode) {
        if (! postalCode) {
            return null;
        }
        postalCode = postalCode.toString().trim();

        var ca = new RegExp(/^([a-zA-Z]\d[a-zA-Z])\ {0,1}(\d[a-zA-Z]\d)$/);

        if (ca.test(postalCode.toString().replace(/\W+/g, ''))) {
            return postalCode;
        }
        return null;
    }

})(jQuery);