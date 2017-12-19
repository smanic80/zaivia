
<div class="acc-item bb">
    <h3><?php _e('Promote the Listing', 'am') ?></h3>
    <p class="intro"><?php echo get_field("promote_title")?></p>
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 mb-30">
            <fieldset>
                <p>
                  <span class="wpcf7-form-control-wrap checkbox-399">
                    <span class="wpcf7-form-control wpcf7-checkbox">
                      <span class="wpcf7-list-item first">
                        <label class="big yellow"><input type="checkbox" name="premium" id="premium" value="1" <?php if($listing && $listing['premium']):?>checked<?php endif; ?> class="tosave">&nbsp;
                            <span class="wpcf7-list-item-label"><span class="price">$<?php echo ZaiviaListings::format_price(get_field("premium_price"))?></span>
                                <strong><?php _e('Premium Listing', 'am') ?></strong><br><?php echo get_field("premium_description")?>
                            </span>
                        </label>
                      </span>
                    </span>
                  </span>
                </p>
            </fieldset>
            <fieldset>
                <p>
                  <span class="wpcf7-form-control-wrap checkbox-399">
                    <span class="wpcf7-form-control wpcf7-checkbox">
                      <span class="wpcf7-list-item first">
                        <label class="big blue"><input type="checkbox" name="featured" id="featured" value="1" <?php if($listing && $listing['featured']):?>checked<?php endif; ?> class="tosave">&nbsp;
                            <span class="wpcf7-list-item-label"><span class="price">$<?php echo ZaiviaListings::format_price(get_field("featured_price"))?></span>
                                <strong><?php _e('Featured Listing', 'am') ?></strong><br><?php echo get_field("featured_description")?>
                            </span>
                        </label>
                      </span>
                    </span>
                  </span>
                </p>
            </fieldset>
            <fieldset>
                <p>
                  <span class="wpcf7-form-control-wrap checkbox-399">
                    <span class="wpcf7-form-control wpcf7-checkbox">
                      <span class="wpcf7-list-item first">
                        <label class="big"><input type="checkbox" name="set_url" id="set_url" value="1" <?php if($listing && $listing['url']):?>checked<?php endif; ?>>&nbsp;
                            <span class="wpcf7-list-item-label"><span class="price">$<?php echo ZaiviaListings::format_price(get_field("url_price"))?></span>
                                <strong><?php _e('Website URL', 'am') ?></strong><br><?php echo get_field("url_description")?>
                            </span>
                        </label>
                      </span>
                    </span>
                  </span>
                </p>
                <div class="row mt--10">
                    <div class="col-2 col-md-1 col-lg-2"></div>
                    <div class="col-10 col-md-8">
                        <input type="text" name="url" id="url" class="tosave" value="<?php echo $listing?$listing['url']:''; ?>" <?php if(!$listing || ($listing && !$listing['url'])):?>disabled<?php endif; ?>>
                    </div>
                </div>
            </fieldset>
            <hr>
            <fieldset>
                <p>
                  <span class="wpcf7-form-control-wrap checkbox-399">
                    <span class="wpcf7-form-control wpcf7-checkbox">
                      <span class="wpcf7-list-item first">
                        <label class="big"><input type="checkbox" name="bump_up" id="bump_up" value="1" <?php if($listing && $listing['bump_up']):?>checked<?php endif; ?> class="tosave">&nbsp;
                            <span class="wpcf7-list-item-label"><span class="price">$<?php echo ZaiviaListings::format_price(get_field("bump_price"))?></span>
                                <strong><?php _e('Bump Up', 'am') ?></strong><br><?php echo get_field("bump_description")?>
                            </span>
                        </label>
                      </span>
                    </span>
                  </span>
                </p>
            </fieldset>

        </div>
    </div>
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
            <a href="#" class="btn btn-outline blue btn-sm listing-step" rel="6"><?php _e('Previous', 'am') ?></a>
            <a href="#" class="btn btn-primary btn-sm listing-step" rel="4"><?php _e('Next Step', 'am') ?></a>
        </div>
    </div>
</div>