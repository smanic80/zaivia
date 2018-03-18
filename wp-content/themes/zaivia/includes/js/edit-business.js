(function($) {

    $(document).ready(function($) {

        $("#add_banner_form").submit(function(e){
            e.preventDefault();
            processAjaxForm(['banner_title', 'banner_upload_input_media', 'banner_url', 'banner_section', 'banner_community', 'duration_checked'], $(this), function(){

            });
        });

        $(".checked-one").change(function(){
            if($(this).is(":checked")) {
                $(this).parents(".checked-one_holder").find(".checked-one").not($(this)).prop("checked", false);
                $("#" + $(this).attr("rel")).val($(this).val());
            } else {
                $("#" + $(this).attr("rel")).val('');
            }
        });

        $(".banner_upload").change(function(event){
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

            form.append('action', 'uploadBannerFile');

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
                        $("#"+$this.data("id")+"_media").val(data['media_id']);
                        $("#"+$this.attr("id")+"_src").attr("src", data['url'] ).show();
                        $("#"+$this.attr("id")+"_file-errors").text("").hide();
                    } else {
                        $("#"+$this.data("id")+"_media").val("");
                        $("#"+$this.attr("id")+"_src").attr("src", "").hide();
                        $("#"+$this.attr("id")+"_file-errors").text('ERRORS: ' + data['error']);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $("#post-listing-form #"+$this.attr("id")+"_file-errors").text('ERRORS: ' + textStatus);
                }
            });
        });
    });

})(jQuery);