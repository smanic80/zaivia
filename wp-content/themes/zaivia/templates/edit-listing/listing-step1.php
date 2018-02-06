<?php if(!$listing) :?>
    <?php $storedListings = ZaiviaListings::getUserListings(get_current_user_id());?>
    <?php if($storedListings) :?>
        <div class="acc-item bb">
            <h3><?php _e('Draft', 'am') ?></h3>
            <p class="intro3"><?php echo get_field("select_draft")?></p>
            <div class="row">
                <div class="col-md-12 col-lg-5">
                    <select id="set-draft" title="">
                        <option value=""></option>
                        <?php foreach($storedListings as $storedListing):?>
                            <option value="<?php echo $storedListing['listing_id']?>"><?php echo $storedListing['address-text']?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
        </div>
    <?php endif?>
<?php endif?>

<div class="acc-item mb-30">
	<h3><?php _e('Property Location', 'am') ?></h3>
	<div class="row">
		<div class="col-md-12 col-lg-5">
			<fieldset>
				<div class="row">
					<div class="col-12 col-lg-4">
						<label><?php _e('Property Is', 'am') ?>*</label>
					</div>
					<div class="col-sm-12 col-lg-8">
						<select name="sale_rent" id="sale_rent" class="tosave required" title="">
							<option value="0" <?php echo ($listing && (int)$listing['sale_rent'] === ZaiviaListings::$for_rent)?'selected':''; ?>><?php _e('For Rent', 'am') ?></option>
							<option value="1" <?php echo ($listing && (int)$listing['sale_rent'] === ZaiviaListings::$for_sale)?'selected':''; ?>><?php _e('For Sale', 'am') ?></option>
						</select>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="col-12 col-lg-4">
						<label class="salerent_<?php echo ZaiviaListings::$for_sale?>"><?php _e('For Sale By', 'am') ?>*</label>
						<label class="salerent_<?php echo ZaiviaListings::$for_rent?>"><?php _e('For Rent By', 'am') ?>*</label>
					</div>
					<div class="col-sm-12 col-lg-8">
						<select name="sale_by" id="sale_by" class="tosave required" title="">
							<option value=""><?php _e('-select-', 'am') ?></option>
							<option value="0" <?php echo ($listing && (int)$listing['sale_by'] === 0)?'selected':''; ?>><?php _e('Agent', 'am') ?></option>
							<option value="1" <?php echo ($listing && (int)$listing['sale_by'] === 1)?'selected':''; ?>><?php _e('Owner', 'am') ?></option>
							<option value="2" <?php echo ($listing && (int)$listing['sale_by'] === 2)?'selected':''; ?>><?php _e('Property Management', 'am') ?></option>
						</select>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="col-12 col-lg-4">
						<label><?php _e('Address', 'am') ?>*</label>
					</div>
					<div class="col-sm-12 col-lg-8">
						<input type="text" name="address" id="address" placeholder="" value="<?php echo $listing?$listing['address']:''; ?>" class="tosave required">
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="col-12 col-lg-4">
						<label><?php _e('Unit Number', 'am') ?></label>
					</div>
					<div class="col-sm-12 col-lg-8">
						<input type="text" name="unit_number" id="unit_number" placeholder="" value="<?php echo $listing?$listing['unit_number']:''; ?>" class="tosave">
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="col-12 col-lg-4">
						<label><?php _e('City/Town', 'am') ?>*</label>
					</div>
					<div class="col-sm-12 col-lg-8">
						<input type="text" name="city" id="city" placeholder="" value="<?php echo $listing?$listing['city']:''; ?>" class="tosave required">
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="col-12 col-lg-4">
						<label><?php _e('Neighbourhood', 'am') ?></label>
					</div>
					<div class="col-sm-12 col-lg-8">
						<input type="text" name="neighbourhood" id="neighbourhood" placeholder="" value="<?php echo $listing?$listing['neighbourhood']:''; ?>" class="tosave">
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="col-12 col-lg-4">
						<label><?php _e('Province', 'am') ?>*</label>
					</div>
					<div class="col-sm-12 col-lg-8">
						<?php $provinces = ZaiviaListings::$provinces; ?>
						<select name="province" id="province" class="tosave required" title="">
							<option value=""><?php _e('-select-', 'am') ?></option>
							<?php foreach($provinces as $code=>$name):?>
								<option value="<?php echo $code?>" <?php echo ($listing && $listing['province'] === $code)?'selected':''; ?>><?php echo $name?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="col-12 col-lg-4">
						<label><?php _e('Postal Code', 'am') ?>*</label>
					</div>
					<div class="col-sm-12 col-lg-8">
						<input type="text" name="zip" id="zip" placeholder="" value="<?php echo $listing?$listing['zip']:''; ?>" class="tosave required zip">
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="row">
					<div class="col-12 col-lg-4">
						<label><?php _e('Status', 'am') ?>*</label>
					</div>
					<div class="col-sm-12 col-lg-8">

						<select name="status" id="status_0" class="status salerent_<?php echo ZaiviaListings::$for_rent?>" title="">
							<option value=""><?php _e('-select-', 'am') ?></option>
							<option value="Active" <?php echo ($listing && $listing['status'] === "Active")?'selected':''; ?>><?php _e('Active', 'am') ?></option>
							<option value="Rented" <?php echo ($listing && $listing['status'] === "Rented")?'selected':''; ?>><?php _e('Rented', 'am') ?></option>
							<option value="Redused" <?php echo ($listing && $listing['status'] === "Redused")?'selected':''; ?>><?php _e('Redused', 'am') ?></option>
						</select>

                        <select name="status" id="status_1" class="status salerent_<?php echo ZaiviaListings::$for_sale?>" title="">
                            <option value=""><?php _e('-select-', 'am') ?></option>
                            <option value="Active" <?php echo ($listing && $listing['status'] === "Active")?'selected':''; ?>><?php _e('Active', 'am') ?></option>
                            <option value="Conditional Offer" <?php echo ($listing && $listing['status'] === "Conditional Offer")?'selected':''; ?> ><?php _e('Conditional Offer', 'am') ?></option>
                            <option value="Sold" <?php echo ($listing && $listing['status'] === "Sold")?'selected':''; ?>><?php _e('Sold', 'am') ?></option>
                            <option value="Redused" <?php echo ($listing && $listing['status'] === "Redused")?'selected':''; ?>><?php _e('Redused', 'am') ?></option>
                        </select>
                        <input type="hidden" name="status" id="status" value="<?php echo $listing?$listing['status']:''; ?>" class="tosave required">
					</div>
				</div>
			</fieldset>
		</div>
		<div class="col-md-12 col-lg-7" id="map-wrap">
			<p class="intro3"><?php echo get_field("map_click")?></p>
			<div class="map-h">
				<input type="hidden" name="lat" id="lat" value="<?php echo $listing?$listing['lat']:''; ?>" class="tosave">
				<input type="hidden" name="lng" id="lng" value="<?php echo $listing?$listing['lng']:''; ?>" class="tosave">
				<div class="map min-height" id="map"></div>
				<div style="display:none;" id="error-zip" class="error"><?php _e('Please set valid postal code', 'am') ?></div>
				<div style="display:none;" id="error-place" class="error"><?php _e('Selected point has wrong postal code', 'am') ?></div>
			</div>
		</div>
	</div>
</div>

<div class="btn-s">
	<div class="row">
		<div class="col-sm-12 text-right">
			<a href="<?php the_field("page_mylistings", "option")?>" class="btn btn-outline blue btn-sm"><?php _e('Previous', 'am') ?></a>
			<a href="#" class="btn btn-primary btn-sm listing-step" rel="2"><?php _e('Next Step', 'am') ?></a>
		</div>
	</div>
</div>
