<?php

$contact = $listingId ? ZaiviaListings::getListingContact($listingId) : [];
$contact_profile = $listingId ? ZaiviaListings::getListingFiles($listingId, ZaiviaListings::$file_logo) : [];
$contact_profile = isset($contact_profile[0])?$contact_profile[0]:[];
$contact_logo = $listingId ? ZaiviaListings::getListingFiles($listingId, ZaiviaListings::$file_profile) : [];
$contact_logo = isset($contact_logo[0])?$contact_logo[0]:[];
?>

<div class="styled-form">
	<div class="acc-item bb">
		<h3>Price</h3>
		<p class="intro"><?php _e('Who can be contacted about this property? Please ensure the following information is correct and complete', 'am') ?></p>
		<div class="row">
			<div class="col-lg-8">
				<fieldset>
					<div class="row">
						<div class="col-12 col-lg-3">
							<label><?php _e('Title', 'am') ?></label>
						</div>
						<div class="col-sm-12 col-lg-6">
							<input type="text" name="contact_title" id="contact_title" value="" class="tosave">
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="row">
						<div class="col-12 col-lg-3">
							<label><?php _e('Name', 'am') ?>*</label>
						</div>
						<div class="col-sm-12 col-lg-6">
							<input type="text" name="contact_name" id="contact_name" class="required tosave">
						</div>
						<div class="col-sm-12 col-lg-3 pt-15">
							<p>
								<span class="wpcf7-form-control-wrap checkbox-399">
									<span class="wpcf7-form-control wpcf7-checkbox">
										<span class="wpcf7-list-item first">
											<label>
												<input type="checkbox" name="contact_name_show" id="contact_name_show" value="1" class="tosave">&nbsp;
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
							<label><?php _e('Email', 'am') ?>*</label>
						</div>
						<div class="col-sm-12 col-lg-6">
							<input type="text" name="contact_email" id="contact_email" class="required email tosave">
						</div>
					</div>
				</fieldset>
				<fieldset>
					<div class="row">
						<div class="col-12 col-lg-3">
							<label><?php _e('Phone Number', 'am') ?>*</label>
						</div>
						<div class="col-sm-6 col-lg-3">
							<input type="text" name="contact_phone1" is="contact_phone1" class="required tosave">
						</div>
						<div class="col-sm-6 col-lg-3">
							<select name="contact_phone1" is="contact_phone1" class="required tosave">
								<option>Select</option>
							</select>
						</div>
						<div class="col-sm-12 col-lg-3 pt-15">
							<p>
								<span class="wpcf7-form-control-wrap checkbox-399">
									<span class="wpcf7-form-control wpcf7-checkbox">
										<span class="wpcf7-list-item first">
											<label><input type="checkbox" name="checkbox-399[]" value="1">&nbsp;<span class="wpcf7-list-item-label">Send me a copy</span></label>
										</span>
									</span>
								</span>
							</p>
						</div>
					</div>
				</fieldset>

				<div class="mb-30">
					<p class="intro"><?php _e('Note this contact information does not change any other contact information on other listings / contact cards.', 'am') ?></p>
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
</div>