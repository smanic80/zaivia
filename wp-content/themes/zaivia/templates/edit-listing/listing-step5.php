
<div class="acc-item bb">
    <h3><?php _e('Promote the Listing', 'am') ?></h3>
    <p class="intro"><?php the_field("promote_title")?></p>
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 mb-30">
            <?php $traits = ["premium"=>["label" => __('Premium Listing', 'am'), "class"=>"yellow"],
                             "featured"=>["label" => __('Featured Listing', 'am'), "class"=>"blue"],
                              "url"=>["label" => __('Website URL', 'am'), "class"=>""]];?>
            <?php foreach($traits as $trait=>$traitData):?>
                <fieldset>
                    <p>
                  <span class="wpcf7-form-control-wrap checkbox-399">
                    <span class="wpcf7-form-control wpcf7-checkbox">
                      <span class="wpcf7-list-item first">
                        <label class="big <?php echo $traitData['class'] ?>">
                            <input type="checkbox" name="<?php echo $trait?>" id="<?php echo $trait?>" value="1" class="tosave trait-date-update"  />
                            <span class="wpcf7-list-item-label"><span class="price"><?php echo ZaiviaListings::formatMoney(get_field($trait . "_price", "option"), 2)?></span>
                                <strong><?php echo $traitData['label'] ?></strong><br>
                                <span class="trait-valid-until" style="<?php if(!$listing || !$listing[$trait . '_date']):?>display:none;<?php endif; ?>">
                                    <?php _e('Valid until: ', 'am') ?><span><?php echo ZaiviaListings::formatDate($listing[$trait . '_date']); ?></span><br>
                                </span>
                                <span class="trait-description"><?php the_field($trait . "_description")?></span>
                            </span>
                        </label>
                      </span>
                    </span>
                  </span>
                    </p>
                    <?php if($trait === "url"):?>
                    <div class="row mt--10">
                        <div class="col-2 col-md-1 col-lg-2"></div>
                        <div class="col-10 col-md-8">
                            <input type="text" name="url_value" id="url_value" class="tosave" value="<?php echo $listing?$listing['url_value']:''; ?>" >
                        </div>
                    </div>
                    <?php endif; ?>
                </fieldset>
            <?php endforeach;?>

            <!--<hr>
            <fieldset>
                <p>
                  <span class="wpcf7-form-control-wrap checkbox-399">
                    <span class="wpcf7-form-control wpcf7-checkbox">
                      <span class="wpcf7-list-item first">
                        <label class="big"><input type="checkbox" name="bump_up" id="bump_up" value="1" <?php if($listing && $listing['bump_up']):?>checked disabled<?php endif; ?> class="tosave">&nbsp;
                            <span class="wpcf7-list-item-label"><span class="price"><?php echo ZaiviaListings::formatMoney(get_field("bump_price", "option"), 2)?></span>
                                <strong><?php _e('Bump Up', 'am') ?></strong><br><?php the_field("bump_description")?>
                            </span>
                        </label>
                      </span>
                    </span>
                  </span>
                </p>
            </fieldset>-->

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
            <a href="#" class="btn btn-outline blue btn-sm listing-step" rel="4"><?php _e('Previous', 'am') ?></a>
            <a href="#" class="btn btn-primary btn-sm listing-step" rel="6"><?php _e('Next Step', 'am') ?></a>
        </div>
    </div>
</div>