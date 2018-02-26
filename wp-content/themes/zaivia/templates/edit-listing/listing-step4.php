<?php $contact = $listingId ? ZaiviaListings::getListingContact($listingId) : ZaiviaListings::getStoredContact(); ?>

<div class="acc-item bb">
    <h3><?php _e('Contact Information', 'am') ?></h3>
    <p class="intro"><?php echo get_field("who_can_be_contacted")?></p>
    <div class="row">
        <div class="col-lg-8">
            <fieldset class="saleby_0">
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <label><?php _e('Title', 'am') ?></label>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <input type="text" name="contact_title" id="contact_title" value="<?php echo $contact?$contact['contact_title']:''; ?>" class="tosave">
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <label><?php _e('Name', 'am') ?>*</label>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <input type="text" name="contact_name" id="contact_name" value="<?php echo $contact?$contact['contact_name']:''; ?>" class="required tosave">
                    </div>
                    <div class="col-sm-12 col-lg-3 pt-15">
                        <p>
                            <span class="wpcf7-form-control-wrap checkbox-399">
                                <span class="wpcf7-form-control wpcf7-checkbox">
                                    <span class="wpcf7-list-item first">
                                        <label>
                                            <input type="checkbox" name="contact_name_show" id="contact_name_show" value="1" class="tosave" <?php echo ($contact && $contact['contact_name_show']) ? "checked" : ""; ?>>&nbsp;
                                            <span class="wpcf7-list-item-label"><?php _e('Include in listing', 'am') ?></span>
                                        </label>
                                    </span>
                                </span>
                            </span>
                        </p>
                    </div>
                </div>
            </fieldset>

            <fieldset class="saleby_0">
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <label><?php _e('Company Name', 'am') ?></label>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <input type="text" name="contact_company" id="contact_company" value="<?php echo $contact?$contact['contact_company']:''; ?>" class="tosave">
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <label><?php _e('Email', 'am') ?>*</label>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <input type="text" name="contact_email" id="contact_email" value="<?php echo $contact?$contact['contact_email']:''; ?>" class="required email tosave">
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <label><?php _e('Phone Number', 'am') ?>*</label>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <input type="text" name="contact_phone1" id="contact_phone1" value="<?php echo $contact?$contact['contact_phone1']:''; ?>" class="required tosave">
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <select name="contact_phone1_show" id="contact_phone1_type" class="required tosave">
                            <option value="Cell" <?php echo ($contact && $contact['contact_phone1_show'] == "Cell") ? "selected" : ""; ?>>Cell</option>
                            <option value="Office" <?php echo ($contact && $contact['contact_phone1_show'] == "Office") ? "selected" : ""; ?>>Office</option>
                        </select>
                    </div>
                    <div class="col-sm-12 col-lg-3 pt-15">
                        <p>
                            <span class="wpcf7-form-control-wrap checkbox-399">
                                <span class="wpcf7-form-control wpcf7-checkbox">
                                    <span class="wpcf7-list-item first">
                                        <label>
                                            <input type="checkbox" name="contact_phone1_show" id="contact_phone1_show" value="1" class="tosave" <?php echo ($contact && $contact['contact_phone1_show']) ? "checked" : ""; ?>>&nbsp;
                                            <span class="wpcf7-list-item-label"><?php _e('Include in listing', 'am') ?></span>
                                        </label>
                                    </span>
                                </span>
                            </span>
                        </p>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <label><?php _e('Phone Number 2', 'am') ?></label>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <input type="text" name="contact_phone2" id="contact_phone2" class="tosave" value="<?php echo $contact?$contact['contact_phone2']:''; ?>">
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <select name="contact_phone2" id="contact_phone2_type" class="tosave">
                            <option value="Cell" <?php echo ($contact && $contact['contact_phone2_type'] == "Cell") ? "selected" : ""; ?>>Cell</option>
                            <option value="Office" <?php echo ($contact && $contact['contact_phone2_type'] == "Office") ? "selected" : ""; ?>>Office</option>
                        </select>
                    </div>
                    <div class="col-sm-12 col-lg-3 pt-15">
                        <p>
                            <span class="wpcf7-form-control-wrap checkbox-399">
                                <span class="wpcf7-form-control wpcf7-checkbox">
                                    <span class="wpcf7-list-item first">
                                        <label>
                                            <input type="checkbox" name="contact_phone2_show" id="contact_phone2_show" value="1" class="tosave" <?php echo ($contact && $contact['contact_phone2_show']) ? "checked" : ""; ?>>&nbsp;
                                            <span class="wpcf7-list-item-label"><?php _e('Include in listing', 'am') ?></span>
                                        </label>
                                    </span>
                                </span>
                            </span>
                        </p>
                    </div>
                </div>
            </fieldset>

            <fieldset class="saleby_0">
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <label><?php _e('Address', 'am') ?></label>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <input type="text" name="contact_address" id="contact_address" value="<?php echo $contact?$contact['contact_address']:''; ?>" class="tosave">
                    </div>
                </div>
            </fieldset>

            <fieldset class="saleby_0">
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <label><?php _e('City', 'am') ?></label>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <input type="text" name="contact_city" id="contact_city" value="<?php echo $contact?$contact['contact_city']:''; ?>" class="tosave">
                    </div>
                </div>
            </fieldset>

            <fieldset class="saleby_0">
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <label><?php _e('Postal Code', 'am') ?></label>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <input type="text" name="contact_zip" id="contact_zip" value="<?php echo $contact?$contact['contact_zip']:''; ?>" class="tosave zip">
                    </div>
                </div>
            </fieldset>


            <fieldset class="mb-30 saleby_0">
                <input type="hidden" name="contact_profile" id="contact_profile" class="tosave" value="<?php echo ($contact && isset($contact['contact_profile']['file_id'])) ? $contact['contact_profile']['file_id'] : ''; ?>">
                <label><?php _e('Profile Image', 'am') ?></label>
                <p class="intro2"><i class="fa fa-info-circle" aria-hidden="true"></i><em><?php _e('JPG, PNG files accepted', 'am') ?></em></p>
                <p id="contact_profile_file_name"><?php echo ($contact && isset($contact['contact_profile']) && isset($contact['contact_profile']['file_name'])) ? basename($contact['contact_profile']['file_name']) : ''; ?></p>
                <label class="btn btn-secondary"><?php _e('Upload', 'am') ?>
                    <input type="file" id="contact_profile_input" class="listing_upload" data-type="<?php echo ZaiviaListings::$file_profile?>" data-file="contact_profile" data-filename="contact_profile_file_name" />
                </label>
                <p id="contact_profile_input_file-errors"></p>
            </fieldset>

            <fieldset class="mb-30 saleby_0">
                <input type="hidden" name="contact_logo" id="contact_logo" class="tosave" value="<?php echo ($contact && isset($contact['contact_logo']['file_id'])) ? $contact['contact_logo']['file_id'] : ''; ?>">
                <label><?php _e('Company Logo', 'am') ?></label>
                <p class="intro2"><i class="fa fa-info-circle" aria-hidden="true"></i><em><?php _e('JPG, PNG files accepted', 'am') ?></em></p>
                <p id="contact_logo_file_name"><?php echo ($contact && isset($contact['contact_logo']) && isset($contact['contact_logo']['file_name'])) ? basename($contact['contact_logo']['file_name']) : ''; ?></p>
                <label class="btn btn-secondary"><?php _e('Upload', 'am') ?>
                    <input type="file" id="contact_logo_input" class="listing_upload" data-type="<?php echo ZaiviaListings::$file_logo?>"  data-file="contact_logo" data-filename="contact_logo_file_name">
                </label>
                <p id="contact_logo_input_file-errors"></p>
            </fieldset>

            <div class="mb-30">
                <p class="intro"><?php echo get_field("contact_note")?></p>
            </div>
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
            <a href="#" class="btn btn-outline blue btn-sm listing-step" rel="3"><?php _e('Previous', 'am') ?></a>
            <a href="#" class="btn btn-primary btn-sm listing-step" rel="5"><?php _e('Next Step', 'am') ?></a>
        </div>
    </div>
</div>