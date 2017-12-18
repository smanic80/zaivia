<?php
$img_files = $listingId ? ZaiviaListings::getListingFiles($listingId, ZaiviaListings::$file_image) : [];
$blueprint_files = $listingId ? ZaiviaListings::getListingFiles($listingId, ZaiviaListings::$file_blueprint) : [];
?>
<div class="acc-item bb">
    <h3>Property Images</h3>
    <p class="intro">Having high quality images as critical for generating interest in your property. Follow our photography tips to enhance your pictures, or check out our Community Partners page to hire a professional photographer. You can upload up to a maximum 30 images.</p>
    <p class="intro">We encourage you to see an external picture of your property as the first picture.</p>
    <fieldset>
        <div id="prop_img_to_clone" class="clone_item"><div class="multibox file"><div class="loading"><img src="<?php echo get_theme_file_uri(); ?>/includes/js/orakuploader/images/loader.gif" alt="loader"/></div></div></div>
        <div class="upload-area" id="prop_imgDDArea">
            <div id="prop_img" class="tosave group" data-key="prop_img">
                <?php foreach($img_files as $item):?>
                <div class="multibox file" style="cursor: move;" id="<?php echo $item['file_id'] ?>" filename="<?php echo $item['url'] ?>">
                    <div class="picture_delete"></div>
                    <img src="<?php echo $item['url'] ?>" alt="" class="picture_uploaded">
                    <input type="hidden" class="save-item" value="<?php echo $item['file_id'] ?>" name="prop_img[]">
                </div>
                <?php endforeach; ?>
            </div>
            <label class="btn btn-secondary uploadButton">Upload images<input type="file" class="prop_imgInput orakuploaderFileInput" accept="image/*" multiple></label>
        </div>
    </fieldset>
</div>
<div class="acc-item bb">
    <h3>Property Blueprints</h3>
    <p class="intro">Upload property blueprints</p>
    <fieldset>
        <div id="prop_blue_to_clone" class="clone_item"><div class="multibox file"><div class="loading"><img src="<?php echo get_theme_file_uri(); ?>/includes/js/orakuploader/images/loader.gif" alt="loader"/></div></div></div>
        <div class="upload-area" id="prop_blueDDArea">
            <div id="prop_blue" class="tosave group" data-key="prop_blue">
                <?php foreach($blueprint_files as $item):?>
                    <div class="multibox file" style="cursor: move;" id="<?php echo $item['file_id'] ?>" filename="<?php echo $item['url'] ?>">
                        <div class="picture_delete"></div>
                        <img src="<?php echo $item['url'] ?>" alt="" class="picture_uploaded">
                        <input type="hidden" class="save-item" value="<?php echo $item['file_id'] ?>" name="prop_img[]">
                    </div>
                <?php endforeach; ?>
            </div>
            <label class="btn btn-secondary uploadButton">Upload images<input type="file" class="prop_blueInput orakuploaderFileInput" accept="image/*" multiple></label>
        </div>
    </fieldset>
</div>
<div class="btn-s">
    <div class="row">
        <div class="col-sm-6">
            <?php if($listing) :?>
                <a href="#" class="btn btn-secondary btn-sm save-draft"><?php _e('Save', 'am') ?></a>
                <a href="#" class="btn btn-secondary btn-sm"><?php _e('Preview', 'am') ?></a>
            <?php else:?>
                <a href="#" class="btn btn-secondary btn-sm save-draft"><?php _e('Save Draft', 'am') ?></a>
            <?php endif; ?>
        </div>
        <div class="col-sm-6 text-right">
            <a href="#" class="btn btn-outline blue btn-sm listing-step" rel="2"><?php _e('Previous', 'am') ?></a>
            <a href="#" class="btn btn-primary btn-sm listing-step" rel="4"><?php _e('Next Step', 'am') ?></a>
        </div>
    </div>
</div>