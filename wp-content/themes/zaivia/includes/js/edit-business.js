(function($) {

    $(document).ready(function($) {

        $("#add_banner_form").submit(function(e){
            e.preventDefault();
            processAjaxForm(['banner_title', 'banner_url', 'banner_section', 'banner_community', 'add_banner_nonce', 'banner_image_upload_input_media'], $(this), function(id){
                $("#entity_id").val(id);

                if($(".banner-date-update:checked").length && $(".btn-primary.payment").length) {
                    $(".multistep-step").hide();
                    $(".payment-step").show();
                    initBusinessPaymentForm(id);
                } else {
                    showSavedConfirmation($("#add_banner_form"));
                }
            }, ['entity_id', 'duration_checked']);
        });



        $("#add_card_form").submit(function(e){
            e.preventDefault();
            saveCard($(this), function(id){
                $("#entity_id").val(id);

                if($(".card-date-update:checked").length && $(".btn-primary.payment").length) {
                    $(".form-step").hide();
                    $(".payment-step").show();
                    initBusinessPaymentForm(id);
                } else {
                    showSavedConfirmation($("#add_card_form"));
                }
            });
        });

        function initBusinessPaymentForm(id){
            initPaymentForm("business", id, function () {

                setPromoHndlers(id, "business", initBusinessPaymentForm);

                $("#business-pay").click(function () {

                    var $payment_error = $('#payment_error'),
                        data = {
                            'action':'activateBusiness',
                            'entity_id' : $("#entity_id").val(),
                            'payment-data': $("#payment-form").serialize()
                        };

                    $.post(amData.ajaxurl, data, function(ret){
                        $('.error').removeClass('error');
                        $payment_error.hide();

                        if(ret.errors) {
                            for (var i in ret.errors) if (ret.errors.hasOwnProperty(i)) {
                                $('#' + ret.errors[i]).addClass('error');
                            }
                        } else if(ret.payment_error) {
                            $payment_error.text(ret.payment_error).show().addClass("error");
                        } else {
                            $(".form-step").show();
                            $(".payment-step").hide();
                            showActivationConfirmation();
                        }
                    }, 'json');
                });
            });
        }

        $("#previw_card").click(function(){
            var $this = $(this);
            saveCard($("#add_card_form"), function(id) {
                var data = {
                    action : 'prepareCardPreview',
                    entity_id : id
                };

                $.ajax({
                    url: amData.ajaxurl,
                    type: 'POST',
                    data: data,
                    cache: false,
                    dataType: 'html',
                    success: function (data, textStatus, jqXHR) {
                        $("#preview_inner").html(data);
                        closeModal();
                        openModal($this);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $("#add_card_form #" + $this.attr("id") + "_file-errors").text('ERRORS: ' + textStatus);
                    }
                });
            });
        });

        function saveCard($form, callback){
            processAjaxForm(['add_card_nonce',
                'card_first_name', 'card_last_name', 'card_company', 'card_job_title', 'card_email', 'card_phone', 'card_phone_type',
                'card_industry', 'card_address', 'card_city', 'card_zip', 'card_comments',
                'card_profile_image_upload_input_media', 'card_business_image_upload_input_media'],
                $form,
                callback,
             ['entity_id', 'card_phone2', 'card_phone2_type', 'card_company_show', 'card_sponsor', 'card_url', 'card_link', 'card_featured', 'duration_checked']);
        }

        $(".banner-date-update").click(function(){
            var $this = $(this);

            setTimeout(function () {
                var $date = $(".banner-date-update:checked"),
                    data = {
                        action : 'calculateBannerDate',
                        entity_id : $("#entity_id").val(),
                        date : $date.length ? $date.val() : 0
                    };
                if($(".btn-primary.payment").length) {
                    if ($date.length) {
                        $(".btn-primary.payment").show();
                        $(".btn-primary.save").hide();
                    } else {
                        $(".btn-primary.payment").hide();
                        $(".btn-primary.save").show();
                    }
                }
                $.ajax({
                    url: amData.ajaxurl,
                    type: 'POST',
                    data: data,
                    cache: false,
                    dataType: 'json',
                    success: function(data, textStatus, jqXHR) {
                        if(data) {
                            $this.parents(".acc-item").find(".business-valid-until").show().find("span").text(data.date_renewal);
                        } else {
                            $this.parents(".acc-item").find(".business-valid-until").hide()
                        }
                    }
                });
            }, 100);
        });

        $(".card-date-update, .payed_feature").click(function(){
            setTimeout(function () {
                if(!$(".payed_feature:checked").length || !$(".card-date-update:checked").length){
                    restoreFeaturedDate($(".card_sponsor-valid_until, .card_url-valid_until, .card_featured-valid_until"));
                    return true;
                }

                var $date = $(".card-date-update:checked"),
                    data = {
                        action : 'calculateCardDate',
                        entity_id : $("#entity_id").val(),
                        date : $date.length ? $date.val() : 0,
                        card_sponsor : $("#card_sponsor:checked").length,
                        card_link : $("#card_link:checked").length,
                        card_featured : $("#card_featured:checked").length
                    };

                if($(".btn-primary.payment").length) {
                    if ($date.length) {
                        $(".btn-primary.payment").show();
                        $(".btn-primary.save").hide();
                    } else {
                        $(".btn-primary.payment").hide();
                        $(".btn-primary.save").show();
                    }
                }

                $.ajax({
                    url: amData.ajaxurl,
                    type: 'POST',
                    data: data,
                    cache: false,
                    dataType: 'json',
                    success: function(data, textStatus, jqXHR) {
                        if(data) {
                            if(data.card_sponsor_date && $("#card_sponsor:checked").length) {
                                $(".card_sponsor-valid_until").show().find("span").text(data.card_sponsor_date);
                            } else {
                                $(".card_sponsor-valid_until").hide();
                                restoreFeaturedDate($(".card_sponsor-valid_until"));
                            }

                            if(data.card_url_show_date && $("#card_link:checked").length) {
                                $(".card_url-valid_until").show().find("span").text(data.card_url_show_date);
                            } else {
                                $(".card_url-valid_until").hide();
                                restoreFeaturedDate($(".card_url-valid_until"));
                            }

                            if(data.card_featured_date && $("#card_featured:checked").length) {
                                $(".card_featured-valid_until").show().find("span").text(data.card_featured_date);
                            } else {
                                $(".card_featured-valid_until").hide();
                                restoreFeaturedDate($(".card_featured-valid_until"));
                            }
                        } else {
                            restoreFeaturedDate($(".card_sponsor-valid_until, .card_url-valid_until, .card_featured-valid_until"));
                        }
                    }
                });
            }, 100);

            function restoreFeaturedDate($items){
                $items.each(function(){
                    if($(this).data("date")) {
                        $(this).show().find("span").text($(this).data("date"));
                    } else {
                        $(this).hide();
                    }
                });
            }
        });

        $(".business_upload").change(function(event){
            var form = new FormData(),
                $this = $(this),
                error = false;

            if(!event.target.files.length) return false;

            $.each(event.target.files, function(key, value){
                var ext = value.name.split('.').pop().toLowerCase(),
                    allowed = ['jpg','jpeg','png'];

                if($.inArray(ext, allowed) === -1) {
                    $("#"+$this.attr("id")+"_file-errors").text('Invalid file type!').show();
                    error = true;
                } else {
                    form.append(key, value);
                }
            });

            if(error) return false;

            form.append('action', 'uploadBusinessFile');

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
                        $("#"+$this.attr("id")+"_media").val(data['media_id']);
                        $("#"+$this.attr("id")+"_src").attr("src", data['url'] ).show();
                        $("#"+$this.attr("id")+"_file-errors").text("").hide();
                    } else {
                        $("#"+$this.attr("id")+"_media").val("");
                        $("#"+$this.attr("id")+"_src").attr("src", "").hide();
                        $("#"+$this.attr("id")+"_file-errors").text('ERRORS: ' + data['error']);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $("#post-listing-form #"+$this.attr("id")+"_file-errors").text('ERRORS: ' + textStatus);
                }
            });
        });



        $(".items-list").on("click", ".delete-business", function (e) {
            e.preventDefault();
            delete_disableBusiness($(this).data("id"), 'delete_business', function(data){
                if(typeof data['error'] === 'undefined') {
                    $(".tabbed-content.current .delete-confirmation").show();
                    setTimeout(function () {
                        $(".tabbed-content.current .delete-confirmation").fadeOut(400);
                    }, 1000);

                    $(".tabbed-content.current .row-"+id).remove();
                } else {
                    $(".tabbed-content.current").find(".error_placeholder").text(data['error']).addClass('error').show();
                }
            });
        });
        $(".items-list").on("click", ".disable-business", function (e) {
            var $this = $(this);

            e.preventDefault();
            if($(this).hasClass("disabled")) return false;

            delete_disableBusiness($(this).data("id"), 'disable_business', function(data, $this){
                if(typeof data['error'] === 'undefined') {
                    $(".tabbed-content.current .disable-confirmation").show();
                    setTimeout(function () {
                        $(".tabbed-content.current .disable-confirmation").fadeOut(400);
                    }, 1000);
                    $this.parent().prev().text("");
                } else {
                    $(".tabbed-content.current").find(".error_placeholder").text(data['error']).addClass('error').show();
                }
            }, $this);
        });
        $(".business_form .btn-primary.delete").click(function(e){
            e.preventDefault();
            delete_disableBusiness($("#entity_id").val(), 'delete_business', function(data){
                if(typeof data['error'] === 'undefined') {
                    location.reload();
                } else {
                    $(".error_placeholder").text(data['error']).addClass('error').show();
                }
            });
        });
        $(".business_form .btn-primary.disable").click(function(e){
            e.preventDefault();
            delete_disableBusiness($("#entity_id").val(), 'disable_business', function(data){
                if(typeof data['error'] === 'undefined') {
                    location.reload();
                } else {
                    $(".error_placeholder").text(data['error']).addClass('error').show();
                }
            });
        });
        $(".business_form .btn-primary.enable").click(function(e){
            e.preventDefault();
            delete_disableBusiness($("#entity_id").val(), 'enable_business', function(data){
                if(typeof data['error'] === 'undefined') {
                    location.reload();
                } else {
                    $(".error_placeholder").text(data['error']).addClass('error').show();
                }
            });
        });


        function delete_disableBusiness(id, action, callback, $this){
            if(!confirm("Are you sure?")) return false;

            var data = {
                    action: action,
                    id: id
                };
            $.post({
                url: amData.ajaxurl,
                dataType: "json",
                data: data,
                success: function (data) {
                    callback(data, $this);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(textStatus);
                }
            });
        }

    });


    function showActivationConfirmation() {
        $(".multistep-step").hide();
        $(".confirmation-step").show();
    }
})(jQuery);
