(function($) {

    var marker = null;
    var listingData = {
        'listing_id': $("#listing_id").val(),
        'MLSNumber':'',
        'sale_rent':'',
        'sale_by':'',
        'address':'',
        'unit_number':'',
        'city':'',
        'province':'',
        'zip':'',
        'neighbourhood':'',
        'lat':'',
        'lng':'',
        'price':'',
        'property_type':'',
        'house_type':'',
        'square_footage':'',
        'bedrooms':'',
        'bathrooms':'',
        'roof_type':'',
        'exterior_type':'',
        'parking':'',
        'driveway':'',
        'size_x':'',
        'size_y':'',
        'size_units':'',
        'year_built':'',
        'annual_taxes':'',
        'condo_fees':'',
        'partial_rent':[],
        'features_1':[],
        'features_1_custom':[],
        'features_2':[],
        'features_2_custom':[],
        'features_3':[],
        'features_3_custom':[],
        'room_features':[],
        'description':'',
        'status':'',
        'featured':'',
        'premium':'',
        'url':'',
        'bump_up':'',
        'rent_date':'',
        'rent_deposit':'',
        'rent_furnishings':'',
        'rent_pets':'',
        'rent_smoking':'',
        'rent_laundry':'',
        'rent_file':'',
        'rent_electrified_parking':'',
        'rent_secured_entry':'',
        'rent_private_entry':'',
        'rent_onsite':'',
        'rent_utilities':[],

        'contact_title':'',
        'contact_name':'',
        'contact_name_show':'',
        'contact_email':'',
        'contact_phone1':'',
        'contact_phone1_type':'',
        'contact_phone1_show':'',
        'contact_phone2':'',
        'contact_phone2_type':'',
        'contact_phone2_show':'',
        'contact_company':'',
        'contact_address':'',
        'contact_city':'',
        'contact_zip':'',

        'contact_profile':'',
        'contact_logo':'',

        'prop_img':[],
        'prop_blue':[]
    };

    $(document).ready(function($) {

        refreshRentSaleFields();
        $("#post-listing-form #sale_rent").change(refreshRentSaleFields);

        refreshSaleByFields();
        $("#post-listing-form #sale_by").change(refreshSaleByFields);

        $("#post-listing-form .status").change(function(){
            $("#status").val($(this).val());
        });

        $("#post-listing-form #price").keyup(function(){
            var num = parseInt($(this).val(), 10);
            if(isNaN(num)) $(this).val('');
        });

        $("#post-listing-form #set_url").change(function(){
            if($(this).prop("checked")) {
                $("#post-listing-form #url").removeAttr("disabled");
            } else {
                $("#post-listing-form #url").attr("disabled", "disabled");
            }
        });

        $("#post-listing-form #set-draft").change(function(){
            if(!$(this).val()) return false;

            var data = {
                    'action':'preloadLising',
                    'listing_to': $('#listing_id').val() || listingData['listing_id'] || 0,
                    'listing_from': $(this).val()
                },
                item = items = values = null,
                i,j,k;

            $.post(amData.ajaxurl, data, function(ret){

                //console.log(listingData);

                for(i in listingData) if(listingData.hasOwnProperty(i)){
                    if(i in ret) if(['premium','featured','url','bump_up'].indexOf(i)===-1){
                        listingData[i] = ret[i]
                    }

                    item = $('#'+i);
                    if(i === 'contact_profile' || i === 'contact_logo') {
                        setContactFileData(i);
                    } else if(i === 'room_features') {
                        for(j in listingData[i]){
                            items = $('.'+j);
                            items.each(function(k){
                                if(listingData[i][j][k]) {
                                    $(this).val(listingData[i][j][k]).removeClass('placeholder');
                                } else {
                                    $(this).val("");
                                }
                            });
                        }
                    } else if(item.length){

                        if(item[0].tagName === "INPUT"){
                            if(item[0].type === "hidden" || item[0].type === "text"){
                                item.val(listingData[i]).removeClass('placeholder');
                            }else if(item[0].type === "checkbox"){
                                item.prop('checked', listingData[i]>0).removeClass('placeholder');
                            } else {
                                console.log(item[0].type, item);
                            }
                        } else if(item[0].tagName === "SELECT"){
                            item.val(listingData[i]).removeClass('placeholder');
                        } else if(item[0].tagName === "TEXTAREA" || item[0].tagName === "P"){
                            item.text(listingData[i]).removeClass('placeholder');
                        } else {
                            console.log(item[0].tagName, item);
                        }
                    } else {
                        items = $('.'+i);
                        if(items.length) {

                            if(items[0].tagName === "INPUT"){
                                if(items[0].type === "hidden" || items[0].type === "text"){
                                    items.each(function(j){
                                        if(listingData[i][j]) {
                                            $(this).val(listingData[i][j]).removeClass('placeholder');
                                        } else {
                                            $(this).val("");
                                        }
                                    });
                                } else if(items[0].type === "checkbox"){
                                    items.prop("checked", false);

                                    for(j in listingData[i]){
                                        item = items.filter("[value='"+listingData[i][j]+"']");
                                        if(item.length) {
                                            item.prop("checked", true).removeClass('placeholder');
                                        }
                                    }
                                } else {
                                    console.log(item[0].type, item);
                                }
                            }
                        }
                    }
                }
                initMarker();
            }, 'json');

            function setContactFileData(fileType) {
                if(listingData[fileType]) {
                    $("#"+fileType).val(listingData[fileType].file_id);
                    $("#"+fileType+"_file_name").text(listingData[fileType].file_name);
                }
            }
        });

        $("#post-listing-form .listing_upload").change(function(event){
            var form = new FormData(),
                $this = $(this),
                error = false;

            if(!event.target.files.length) return false;

            $.each(event.target.files, function(key, value){
                var ext = value.name.split('.').pop().toLowerCase(),
                    allowed = ['jpg','png'];

                if($this.attr("id") === "rent_file_input") {
                    allowed = ['doc','docx','pdf'];
                }
                if($.inArray(ext, allowed) === -1) {
                    $("#"+$this.attr("id")+"_file-errors").text('Invalid file type!');
                    error = true;
                } else {
                    form.append(key, value);
                }
            });

            if(error) return false;

            form.append('action', 'uploadLisingFile');
            form.append('listing_id', listingData['listing_id']);
            form.append('file_type', $(this).data("type"));

            $.ajax({
                url: amData.ajaxurl,
                type: 'POST',
                data: form,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(data, textStatus, jqXHR) {

                    if(typeof data['error'] === 'undefined') {
                        $("#post-listing-form #"+$this.data("file")).val(data['id']);
                        $("#post-listing-form #"+$this.data("filename")).text(data['name']);
                        $("#post-listing-form #"+$this.attr("id")+"_file-errors").text("").hide();
                    } else {
                        $("#post-listing-form #"+$this.attr("id")+"_file-errors").text('ERRORS: ' + data['error']);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $("#post-listing-form #"+$this.attr("id")+"_file-errors").text('ERRORS: ' + textStatus);
                }
            });
        });
        if($('#prop_img').length) {
            $('#prop_img').orakuploader({
                orakuploader: true,
                orakuploader_type: 1,
                orakuploader_path: amData.uploader_path,
                orakuploader_url: amData.ajaxurl,
                orakuploader_use_sortable: true,
                orakuploader_use_dragndrop: true,
                orakuploader_thumbnail_size: 150
            });
        }
        if($('#prop_blue').length) {
            $('#prop_blue').orakuploader({
                orakuploader: true,
                orakuploader_type: 0,
                orakuploader_path: amData.uploader_path,
                orakuploader_url: amData.ajaxurl,
                orakuploader_use_sortable: true,
                orakuploader_use_dragndrop: true,
                orakuploader_thumbnail_size: 150
            });
        }

        if ($("#post-listing-form #map").length) {
            var map;

            $("#post-listing-form #zip").change(function(){
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

                        $("#post-listing-form #map-wrap").show();

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
                        // google.maps.event.addListenerOnce(map, 'idle');

                        google.maps.event.addListener(map, 'click', function(event) {
                            placeMarker(event.latLng);
                        });

                        $("#post-listing-form #error-zip").hide();
                    } else {
                        $("#post-listing-form #error-zip").show();
                    }
                });
            });

            if($("#post-listing-form #zip").val()) {
                initMarker();
            }

            function initMarker(){
                $("#post-listing-form #zip").trigger("change");

                if($("#post-listing-form #lat").val() && $("#post-listing-form #lng").val()) {
                    var loc = {lat : parseFloat($("#post-listing-form #lat").val()), lng : parseFloat($("#post-listing-form #lng").val())};

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



                $("#post-listing-form #lat").val(marker.getPosition().lat());
                $("#post-listing-form #lng").val(marker.getPosition().lng());

                geocoder.geocode({'location': latlng}, function(results, status) {

                    var addr = {'unit_number':'','address':'','city':'','province':'','neighbourhood':''};

                    if (status === google.maps.GeocoderStatus.OK) {
                        if (results[1]) {

                            map.setCenter(latlng);

                            for(i in results[0].address_components) {
                                if(results[0].address_components[i].types[0] === 'postal_code') {
                                    if(results[0].address_components[i].long_name !== $("#post-listing-form #zip").val().trim()){
                                        $("#post-listing-form #error-place").show();
                                    } else {
                                        $("#post-listing-form #error-place").hide();
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
                            if(!$("#post-listing-form #error-place").is(":visible")){
                                $("#post-listing-form #unit_number").val(addr.unit_number).removeClass("placeholder");
                                $("#post-listing-form #address").val(addr.address).removeClass("placeholder");
                                $("#post-listing-form #city").val(addr.city).removeClass("placeholder");
                                $("#post-listing-form #province").val(addr.province).removeClass("placeholder");
                                $("#post-listing-form #neighbourhood").val(addr.neighbourhood).removeClass("placeholder");
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

        $("#post-listing-form .listing-step").click(function(){
            var curStep =  $("#post-listing-form .steps-all li.cur").attr("id").split("-")[1],
                nextStep = $(this).attr("rel");

            updateListingObj();

            if(parseInt(nextStep, 10) === 6) {
                confirmListing();
            } else {
                if (nextStep > curStep) {
                    validateStep($("#post-listing-form #step" + curStep), function () {
                        gotoStep(nextStep, true);
                    });
                } else {
                    gotoStep(nextStep, false);
                }
            }

            return false;
        });

        $("#post-listing-form .save-draft").click(function(e){
            e.preventDefault();

            var curStep =  $("#post-listing-form .steps-all li.cur").attr("id").split("-")[1];

            updateListingObj();

            listingData.to_delete = 0;
            validateStep($("#post-listing-form #step"+curStep), function() {
                alert("Listing saved");
            });
        });


        initdatepicker($(".datepicker"));

        $(document).on('click','#post-listing-form #add-openhouse',function(){
            var $block = $("#post-listing-form #openhouse-block").clone();
            $block.find('.datepicker-hidden').addClass('datepicker').removeClass('datepicker-hidden');
            $block.removeAttr("id").addClass('array-row').css('display','');
            $("#post-listing-form #more-openhouse").before($block);
            initdatepicker($block.find(".datepicker"));

            return false;
        });
        $(document).on('click','.trigger',function(){
            $(this).prev('#post-listing-form .datepicker').datepicker('show');
        });
        $(document).on('click','#post-listing-form .remove-openhouse',function(){
            if($("#post-listing-form .openhouse-block").length <= 2) {
                $(this).parents("#post-listing-form .openhouse-block").find("input").val("").addClass('placeholder');
                $(this).parents("#post-listing-form .openhouse-block").find("select").val("");
            } else {
                $(this).parents("#post-listing-form .openhouse-block").remove();
            }

            return false;
        });

        function initdatepicker($obj) {
            $obj.datepicker({ dateFormat: 'mm/dd/yy', currentText: "", minDate: new Date() });
        }

        function updateListingObj() {
            var collect, sub={}, subkey;

            $("#post-listing-form .tosave").each(function(){
                collect = [];
                if( $(this).hasClass("array") ) {
                    $(this).find(".array-row").each(function(){
                        var arr = {};
                        var found = true;
                        $(this).find("input,select").each(function(){
                            if(!$(this).val()) {
                                found = false;
                            } else {
                                arr[$(this).attr('name')] = $(this).val();
                            }
                        });
                        if(found) collect.push(arr);
                    });
                    listingData[$(this).attr("id")] = collect;
                } else if( $(this).hasClass("group") ) {

                    $(this).find(".save-item").each(function(){
                        if($(this).attr("type") === 'checkbox' && $(this).is(":checked") ) {
                            collect.push($(this).val());
                        }
                        if(['text', 'hidden'].indexOf($(this).attr("type")) != -1 && $(this).val() ) {
                            collect.push($(this).val());
                        }
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
                        listingData[$(this).attr("id")] = ( ($(this).attr('type')==='checkbox') ? ($(this).prop('checked')?1:0) : $(this).val() );
                    } else {
                        alert("listing key not found " + $(this).attr("id"));
                    }
                }
            });
        }

    });



    function gotoStep(stepN, isDone){
        $("#post-listing-form  .listing-steps").hide();
        $("#step"+stepN).show();

        if(isDone) {
            $(".steps-all li.current").addClass("done");
        }

        $(".steps-all .cur").removeClass("cur");
        $(".steps-all li#stepbc-"+stepN).addClass("current").addClass("cur");
    }
    if(window.location.hash === '#step5') {
        $(".steps-all li:not(#stepbc-5):not(#stepbc-6)").addClass("current");
        gotoStep(5,true);
        window.location.hash = '';
    }
    if(window.location.hash === '#step6') {
        confirmListing();
        window.location.hash = '';
    }
    function refreshRentSaleFields(){
        var key = $("#sale_rent").val();

        $(".salerent_0, .salerent_1").hide();
        $(".salerent_"+key).show();


        if($("#post-listing-form .wrapped.unwrap_"+key).length) {
            $(".wrapped.unwrap_"+key).each(function(){
                var $item = $(this);

                $.each( $(this).data("wrap").split(";"), function( index, value ){
                    $item.unwrap();
                });

                $item.removeClass("wrapped").addClass("unwrapped");
            });
        } else {
            $("#post-listing-form .unwrapped.wrap_"+key).each(function(){
                var $item = $(this),
                    $startItem = $item;

                $.each( $(this).data("wrap").split(";"), function( index, value ){
                    if(index == 0) {
                        $item.siblings(".wrap_"+key).addBack().wrapAll("<div class='"+value+"'></div>");
                    } else {
                        $item = $item.parent();
                        $item.wrap("<div class='"+value+"'></div>");
                    }
                });

                $startItem.removeClass("unwrapped").addClass("wrapped");
            });
        }
    }

    function refreshSaleByFields(){
        var key = parseInt($("#sale_by").val(), 10);

        if(key !== 1) key = 0;

        $(".saleby_0, .saleby_1").hide();
        $(".saleby_"+key).show();
    }

    function confirmListing(){
        var data = {
                'action':'processLising',
                'listing-data': JSON.stringify(listingData)
            };
        $.post(amData.ajaxurl, data, function(ret){
            if(data) {
                gotoStep(6, true);
                $(".steps-all, .btns-start").hide();
            }
        }, 'json');
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
        $("#status_0, #status_1").removeClass("error");

        $fieldsZip.removeClass("error");
        $fieldsZip.each(function () {
            data.zip[$(this).attr("id")] = $(this).val();
        });

        $.post(amData.ajaxurl, data, function(ret){
            var error = false;
            for(i in ret.errors){
                if($("#"+ret.errors[i]).length){

                    if(ret.errors[i] === 'status') {
                        $("#status_0, #status_1").addClass("error");
                    }
                    $("#"+ret.errors[i]).addClass("error");

                    error = true
                }
            }

            listingData.listing_id = ret.listing_id;
            listingData.contact_profile = ret.contact_profile;
            listingData.contact_logo = ret.contact_logo;

            $("#listing_id").val(listingData.listing_id);

            $("#contact_profile").val(listingData.contact_profile ? listingData.contact_profile['file_id']: '');
            $("#contact_profile_file_name").val(listingData.contact_profile ? listingData.contact_profile['file_name']: '');

            $("#contact_logo").val(listingData.contact_logo ? listingData.contact_logo['file_id']: '');
            $("#contact_logo_file_name").val(listingData.contact_logo ? listingData.contact_logo['file_name']: '');

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