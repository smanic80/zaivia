<div class="acc-item bb">
	<h3><?php _e('Price', 'am') ?></h3>
	<div class="row">
		<div class="col-md-6 col-lg-3">
			<fieldset>
				<label class="salerent_0"><?php _e('Monthly Rent ($)', 'am') ?>*</label>
				<label class="salerent_1"><?php _e('Asking Price ($)', 'am') ?>*</label>
				<input type="text" placeholder="349000" name="price" id="price" value="<?php echo $listing?$listing['price']:''; ?>" class="tosave required">
			</fieldset>
		</div>
	</div>
</div>


<div class="acc-item bb">
	<h3>Key Features</h3>
	<div class="row">

        <div class="col-sm-12 col-lg-8">
            <div class="row">

		<div class="col-md-6 col-lg-4">
			<fieldset>
				<?php $items = get_field('home_type', 'option'); ?>
				<label><?php _e('Property Type', 'am') ?>*</label>
				<select name="property_type" id="property_type" class="tosave required">
					<option value=""><?php _e('-select-', 'am') ?></option>
					<?php foreach($items as $item):?>
					<option value="<?php echo $item['name']?>" <?php echo ($listing && $listing['property_type'] === $item['name'])?'selected':''; ?>><?php echo $item['name']?></option>
					<?php endforeach; ?>
				</select>
			</fieldset>
		</div>
		<div class="col-md-6 col-lg-4">
			<fieldset>
				<label><?php _e('Year Built', 'am') ?></label>
				<input type="text" placeholder="1956" name="year_built" id="year_built" value="<?php echo $listing?$listing['year_built']:''; ?>" class="tosave">
			</fieldset>
		</div>
        <div class="col-md-6 col-lg-4 salerent_1">
            <fieldset>
				<?php $items = get_field('roof_type', 'option'); ?>
                <label><?php _e('Roof Type', 'am') ?></label>
                <select name="roof_type" id="roof_type" class="tosave">
                    <option value=""><?php _e('-select-', 'am') ?></option>
					<?php foreach($items as $item):?>
                        <option value="<?php echo $item['name']?>" <?php echo ($listing && $listing['roof_type'] === $item['name'])?'selected':''; ?>><?php echo $item['name']?></option>
					<?php endforeach; ?>
                </select>
            </fieldset>
        </div>
        <div class="col-md-6 col-lg-4 salerent_1">
            <fieldset>
				<?php $items = get_field('type_of_house', 'option'); ?>
                <label><?php _e('Type of House', 'am') ?></label>
                <select name="house_type" id="house_type" class="tosave">
                    <option value=""><?php _e('-select-', 'am') ?></option>
					<?php foreach($items as $item):?>
                        <option value="<?php echo $item['name']?>" <?php echo ($listing && $listing['house_type'] === $item['name'])?'selected':''; ?>><?php echo $item['name']?></option>
					<?php endforeach; ?>
                </select>
            </fieldset>
        </div>
        <div class="col-md-6 col-lg-4 salerent_1">
            <fieldset>
                <label><?php _e('Annual Taxes ($)', 'am') ?></label>
                <input type="text" placeholder="1825" name="annual_taxes" id="annual_taxes" value="<?php echo $listing?$listing['annual_taxes']:''; ?>" class="tosave">
            </fieldset>
        </div>
        <div class="col-md-6 col-lg-4 salerent_1">
            <fieldset>
				<?php $items = get_field('exterior_type', 'option'); ?>
                <label><?php _e('Exterior Type', 'am') ?></label>
                <select name="exterior_type" id="exterior_type" class="tosave">
                    <option value=""><?php _e('-select-', 'am') ?></option>
					<?php foreach($items as $item):?>
                        <option value="<?php echo $item['name']?>" <?php echo ($listing && $listing['exterior_type'] === $item['name'])?'selected':''; ?>><?php echo $item['name']?></option>
					<?php endforeach; ?>
                </select>
            </fieldset>
        </div>
		<div class="col-md-6 col-lg-4">
			<fieldset>
				<label><?php _e('Square Footage', 'am') ?></label>
				<input type="text" placeholder="1234" name="square_footage" id="square_footage" value="<?php echo $listing?$listing['square_footage']:''; ?>" class="tosave">
			</fieldset>
		</div>
        <div class="col-md-6 col-lg-4 salerent_1">
            <fieldset>
                <label><?php _e('Condo Fees ($)', 'am') ?></label>
                <input type="text" placeholder="300" name="condo_fees" id="condo_fees" value="<?php echo $listing?$listing['condo_fees']:''; ?>" class="tosave">
            </fieldset>
        </div>
		<div class="col-md-6 col-lg-4">
			<fieldset>
				<?php $items = get_field('parking', 'option'); ?>
				<label><?php _e('Parking', 'am') ?></label>
				<select name="parking" id="parking" class="tosave">
					<option value=""><?php _e('-select-', 'am') ?></option>
					<?php foreach($items as $item):?>
						<option value="<?php echo $item['name']?>" <?php echo ($listing && $listing['parking'] === $item['name'])?'selected':''; ?>><?php echo $item['name']?></option>
					<?php endforeach; ?>
				</select>
			</fieldset>
		</div>




		<div class="col-md-6 col-lg-4">
			<div class="row gutters-16">
				<div class="col-6 col-lg-5">
					<fieldset>
						<?php $items = get_field('bedrooms', 'option'); ?>
						<label><?php _e('Bedrooms', 'am') ?></label>
                        <select name="bedrooms" id="bedrooms" class="tosave">
                            <option value=""><?php _e('-select-', 'am') ?></option>
							<?php foreach($items as $item):?>
                                <option value="<?php echo $item['name']?>" <?php echo ($listing && $listing['bedrooms'] === $item['name'])?'selected':''; ?>><?php echo $item['name']?></option>
							<?php endforeach; ?>
                        </select>
					</fieldset>
				</div>
				<div class="col-6 col-lg-5">
					<fieldset>
						<?php $items = get_field('bathrooms', 'option'); ?>
						<label><?php _e('Bathrooms', 'am') ?></label>
                        <select name="bathrooms" id="bathrooms" class="tosave">
                            <option value=""><?php _e('-select-', 'am') ?></option>
							<?php foreach($items as $item):?>
                                <option value="<?php echo $item['name']?>" <?php echo ($listing && $listing['bathrooms'] === $item['name'])?'selected':''; ?>><?php echo $item['name']?></option>
							<?php endforeach; ?>
                        </select>
					</fieldset>
				</div>
			</div>
		</div>

        <div class="col-md-6 col-lg-4 salerent_1">
            <fieldset>
                <label><?php _e('MLS#', 'am') ?></label>
                <input type="text" placeholder="" name="MLSNumber" id="MLSNumber" value="<?php echo $listing?$listing['MLSNumber']:''; ?>" class="tosave">
            </fieldset>
        </div>

		<div class="col-md-6 col-lg-4 salerent_1">
			<fieldset>
				<?php $items = get_field('driveway', 'option'); ?>
				<label><?php _e('Driveway', 'am') ?></label>
                <select name="driveway" id="driveway" class="tosave">
                    <option value=""><?php _e('-select-', 'am') ?></option>
					<?php foreach($items as $item):?>
                        <option value="<?php echo $item['name']?>" <?php echo ($listing && $listing['driveway'] === $item['name'])?'selected':''; ?>><?php echo $item['name']?></option>
					<?php endforeach; ?>
                </select>
			</fieldset>
		</div>


		<div class="col-md-6 col-lg-4 salerent_1">
			<div class="row gutters-16">
				<div class="col-12">
					<label><?php _e('Lot Size', 'am') ?></label>
				</div>
				<div class="col-3">
					<fieldset>
                        <input type="text" placeholder="50" name="size_x" id="size_x" value="<?php echo $listing?$listing['size_x']:''; ?>" class="tosave center">
					</fieldset>
				</div>
				<div class="col-x"> x </div>
				<div class="col-3">
					<fieldset>
                        <input type="text" placeholder="50" name="size_y" id="size_y" value="<?php echo $listing?$listing['size_y']:''; ?>" class="tosave center">
					</fieldset>
				</div>
				<div class="col-6">
					<fieldset>
						<?php $items = get_field('size_units', 'option'); ?>
                        <select name="size_units" id="size_units" class="tosave">
							<?php foreach($items as $item):?>
                                <option value="<?php echo $item['name']?>" <?php echo ($listing && $listing['size_units'] === $item['name'])?'selected':''; ?>><?php echo $item['name']?></option>
							<?php endforeach; ?>
                        </select>
					</fieldset>
				</div>
			</div>
		</div>
            </div>
        </div>

        <div class="col-sm-12 col-lg-4 salerent_0">
            <p class="intro"><?php _e('Partial Space for Rent', 'am') ?></p>
	        <?php
                $items = get_field('partial_rent', 'option');
	            $partial_rent = $listing ? explode(";", $listing['partial_rent']) : [];
	        ?>
            <fieldset class="checkbox tosave group" data-key="partial_rent" >
	            <?php foreach($items as $item):?>
                <p>
                  <span class="wpcf7-form-control-wrap">
                    <span class="wpcf7-form-control wpcf7-checkbox">
                      <span class="wpcf7-list-item">
                        <label>
                            <input type="checkbox" name="partial_rent[]" <?php echo ($listing && in_array($item['name'], $partial_rent))?'checked':''; ?> value="<?php echo $item['name']?>" class="save-item">&nbsp;
                            <span class="wpcf7-list-item-label"><?php echo $item['name']?></span>
                        </label>
                      </span>
                    </span>
                  </span>
                </p>
	            <?php endforeach; ?>
            </fieldset>
        </div>
	</div>
</div>


<?php
    $type = 1;
    $items = get_field('features_'.$type, 'option');
    $features = $listingId ? ZaiviaListings::getListingFeatures($listingId, $type) : [];
    $features_custom = $listingId ? ZaiviaListings::getListingFeatures($listingId, $type, true) : [];
?>
<div class="acc-item">
	<h3 class="toggle"><?php _e('Other Features', 'am') ?></h3>
	<div class="acc-cc">
		<p class="intro"><?php _e('Click on all of the items that apply', 'am') ?></p>
		<div class="row">
			<div class="col-sm-6 col-lg-8">
				<div class="row tosave group" data-key="features_<?php echo $type?>" >
                    <?php $cnt = 1; $perColumn = ceil(count($items) / 3);?>
					<?php foreach($items as $item):?>
                        <?php if($cnt % $perColumn == 1):?><div class="col-lg-4"><?php endif; ?>
                        <fieldset class="checkbox">
                            <p>
                            <span class="wpcf7-form-control-wrap">
                              <span class="wpcf7-form-control wpcf7-checkbox">
                                <span class="wpcf7-list-item">
                                  <label>
                                      <input type="checkbox" name="features_<?php echo $type?>[]" value="<?php echo $item['name']?>" <?php echo ($listing && am_array_search($item['name'], "feature", $features)!==null)?'checked':''; ?> class="save-item">&nbsp;
                                      <span class="wpcf7-list-item-label"><?php echo $item['name']?></span></label>
                                </span>
                              </span>
                            </span>
                            </p>
                        </fieldset>
						<?php if($cnt % $perColumn == 0 || $cnt == count($items)):?></div><?php endif; ?>
						<?php $cnt++;?>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="col-sm-6 col-lg-4">
				<fieldset class="tosave group" data-key="features_<?php echo $type?>_custom"  >
					<label><?php _e('Other', 'am') ?></label>
                    <?php for ($i=0;$i<5;$i++):?>
                        <input name="features_<?php echo $type?>_custom[]" type="text" value="<?php echo isset($features_custom[$i])?$features_custom[$i]['feature']:''?>" class="save-item">
                    <?php endfor;?>
				</fieldset>
			</div>
		</div>
	</div>
</div>

<?php
    $type = 2;
    $items = get_field('features_'.$type, 'option');
    $features = $listingId ? ZaiviaListings::getListingFeatures($listingId, $type) : [];
    $features_custom = $listingId ? ZaiviaListings::getListingFeatures($listingId, $type, true) : [];
?>
<div class="acc-item">
    <h3 class="toggle"><?php _e('Appliances Included', 'am') ?></h3>
    <div class="acc-cc">
        <p class="intro"><?php _e('Click on all of the items that apply', 'am') ?></p>
        <div class="row">
            <div class="col-sm-6 col-lg-8">
                <div class="row tosave group" data-key="features_<?php echo $type?>" >
					<?php $cnt = 1; $perColumn = ceil(count($items) / 3);?>
					<?php foreach($items as $item):?>
						<?php if($cnt % $perColumn == 1):?><div class="col-lg-4"><?php endif; ?>
                        <fieldset class="checkbox">
                            <p>
                            <span class="wpcf7-form-control-wrap">
                              <span class="wpcf7-form-control wpcf7-checkbox">
                                <span class="wpcf7-list-item">
                                  <label>
                                      <input type="checkbox" name="features_<?php echo $type?>[]" value="<?php echo $item['name']?>" <?php echo ($listing && am_array_search($item['name'], "feature", $features)!==null)?'checked':''; ?> class="save-item">&nbsp;
                                      <span class="wpcf7-list-item-label"><?php echo $item['name']?></span>
                                  </label>
                                </span>
                              </span>
                            </span>
                            </p>
                        </fieldset>
						<?php if($cnt % $perColumn == 0 || $cnt == count($items)):?></div><?php endif; ?>
						<?php $cnt++;?>
					<?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
$type = 3;
$items = get_field('features_'.$type, 'option');
$features = $listingId ? ZaiviaListings::getListingFeatures($listingId, $type) : [];
$features_custom = $listingId ? ZaiviaListings::getListingFeatures($listingId, $type, true) : [];
?>
<div class="acc-item">
    <h3 class="toggle"><?php _e('Outdoor Amenities', 'am') ?></h3>
    <div class="acc-cc">
        <p class="intro"><?php _e('Click on all of the items that apply', 'am') ?></p>
        <div class="row">
            <div class="col-sm-6 col-lg-8">
                <div class="row tosave group" data-key="features_<?php echo $type?>" >
					<?php $cnt = 1; $perColumn = ceil(count($items) / 3);?>
					<?php foreach($items as $item):?>
						<?php if($cnt % $perColumn == 1):?><div class="col-lg-4"><?php endif; ?>
                        <fieldset class="checkbox">
                            <p>
                            <span class="wpcf7-form-control-wrap">
                              <span class="wpcf7-form-control wpcf7-checkbox">
                                <span class="wpcf7-list-item">
                                  <label>
                                      <input type="checkbox" name="features_<?php echo $type?>[]" value="<?php echo $item['name']?>" <?php echo ($listing && am_array_search($item['name'], "feature", $features)!==null)?'checked':''; ?> class="save-item">&nbsp;
                                      <span class="wpcf7-list-item-label"><?php echo $item['name']?></span>
                                  </label>
                                </span>
                              </span>
                            </span>
                            </p>
                        </fieldset>
						<?php if($cnt % $perColumn == 0 || $cnt == count($items)):?></div><?php endif; ?>
						<?php $cnt++;?>
					<?php endforeach; ?>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <fieldset class="tosave group" data-key="features_<?php echo $type?>_custom" >
                    <label><?php _e('Other', 'am') ?></label>
			        <?php for ($i=0;$i<5;$i++):?>
                        <input name="features_<?php echo $type?>_custom[]" type="text" value="<?php echo isset($features_custom[$i])?$features_custom[$i]['feature']:''?>" class="save-item">
			        <?php endfor;?>
                </fieldset>
            </div>
        </div>
    </div>
</div>
<?php
$items = get_field('rent_utilities', 'option');
$rent = $listingId ? ZaiviaListings::getListingRent($listingId) : [];
$rent_file = $listingId ? ZaiviaListings::getListingFiles($listingId,1) : [];
?>
<div class="acc-item salerent_0">
    <h3 class="toggle">Rental Options</h3>
    <div class="acc-cc">
        <div class="row">
            <div class="col-sm-6 col-lg-4">
                <fieldset>
                    <label>Date Available</label>
                    <div class="datepick">
                        <input type="text" placeholder="June 23" class="datepicker tosave" id="rent_date" title="" value="<?php echo $rent['rent_date']; ?>">
                        <div class="trigger">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <label>Security Deposit</label>
                    <input type="text" id="rent_deposit" title="" class="tosave" value="<?php echo $rent['rent_deposit']; ?>">
                </fieldset>
                <fieldset>
                    <label>Furnishings</label>
                    <select id="rent_furnishings" title="" class="tosave">
                        <option<?php echo $rent['rent_furnishings']?' selected':''; ?> value="1">Yes</option>
                        <option<?php echo !$rent['rent_furnishings']?' selected':''; ?> value="0">No</option>
                    </select>
                </fieldset>
                <fieldset>
                    <label>Pets</label>
                    <select id="rent_pets" title="" class="tosave">
                        <option<?php echo $rent['rent_pets']?' selected':''; ?> value="1">Yes</option>
                        <option<?php echo !$rent['rent_pets']?' selected':''; ?> value="0">No</option>
                    </select>
                </fieldset>
                <fieldset>
                    <label>Smoking</label>
                    <select id="rent_smoking" title="" class="tosave">
                        <option<?php echo $rent['rent_smoking']?' selected':''; ?> value="1">Yes</option>
                        <option<?php echo !$rent['rent_smoking']?' selected':''; ?> value="0">No</option>
                    </select>
                </fieldset>
                <fieldset>
                    <label>Laundry</label>
                    <select id="rent_laundry" title="" class="tosave">
                        <option<?php echo $rent['rent_laundry']?' selected':''; ?> value="1">Yes</option>
                        <option<?php echo !$rent['rent_laundry']?' selected':''; ?> value="0">No</option>
                    </select>
                </fieldset>
                <fieldset class="mb-30">
                    <input type="hidden" id="rent_file" class="tosave" value="">
                    <label>Rental Application Upload</label>
                    <p class="intro2"><i class="fa fa-info-circle" aria-hidden="true"></i><em>DOC, DOCX, PDF files accepted</em></p>
                    <p id="rent_file_name"><?php echo basename($rent_file[0]['file_name']); ?></p>
                    <label class="btn btn-secondary">Upload<input type="file" id="rent_file_input"></label>
                </fieldset>
            </div>
            <div class="col-sm-6 col-lg-4">
                <fieldset class="checkbox">
                    <p>
                        <span class="wpcf7-form-control-wrap">
                            <span class="wpcf7-form-control wpcf7-checkbox">
                                <span class="wpcf7-list-item">
                                    <label>
                                        <input type="checkbox"<?php echo $rent['rent_electrified_parking']?' checked':''; ?> id="rent_electrified_parking" class="tosave" value="1">&nbsp;
                                        <span class="wpcf7-list-item-label">Electrified Parking</span>
                                    </label>
                                </span>
                            </span>
                        </span>
                    </p>
                    <p>
                        <span class="wpcf7-form-control-wrap">
                            <span class="wpcf7-form-control wpcf7-checkbox">
                                <span class="wpcf7-list-item">
                                    <label>
                                        <input type="checkbox"<?php echo $rent['rent_secured_entry']?' checked':''; ?> id="rent_secured_entry" class="tosave" value="1">&nbsp;
                                        <span class="wpcf7-list-item-label">Secured Entry</span>
                                    </label>
                                </span>
                            </span>
                        </span>
                    </p>
                    <p>
                        <span class="wpcf7-form-control-wrap">
                            <span class="wpcf7-form-control wpcf7-checkbox">
                                <span class="wpcf7-list-item">
                                    <label>
                                        <input type="checkbox"<?php echo $rent['rent_private_entry']?' checked':''; ?> id="rent_private_entry" class="tosave" value="1">&nbsp;
                                        <span class="wpcf7-list-item-label">Private Entry</span>
                                    </label>
                                </span>
                            </span>
                        </span>
                    </p>
                    <p>
                        <span class="wpcf7-form-control-wrap">
                            <span class="wpcf7-form-control wpcf7-checkbox">
                                <span class="wpcf7-list-item">
                                    <label>
                                        <input type="checkbox"<?php echo $rent['rent_onsite']?' checked':''; ?> id="rent_onsite" class="tosave" value="1">&nbsp;
                                        <span class="wpcf7-list-item-label">Onsite Management</span>
                                    </label>
                                </span>
                            </span>
                        </span>
                    </p>
                </fieldset>
            </div>
            <div class="col-sm-6 col-lg-4">
                <p class="intro">Utilities Included</p>
                <fieldset class="checkbox tosave group" data-key="rent_utilities">
                    <?php foreach($items as $item):?>
                    <p>
                        <span class="wpcf7-form-control-wrap">
                            <span class="wpcf7-form-control wpcf7-checkbox">
                                <span class="wpcf7-list-item">
                                    <label>
                                        <input type="checkbox" value="<?php echo $item['key']?>"<?php echo (in_array($item['key'], $rent['rent_utilities']))?' checked':''; ?> class="save-item">&nbsp;
                                        <span class="wpcf7-list-item-label"><?php echo $item['name']?></span>
                                    </label>
                                </span>
                            </span>
                        </span>
                    </p>
                    <?php endforeach; ?>
                </fieldset>
            </div>
        </div>
    </div>
</div>

<?php
    $items = get_field('room_features', 'option');
    $features = $listingId ? unserialize($listing['room_features']): [];
?>
<div class="acc-item">
	<h3 class="toggle"><?php _e('Room Features', 'am') ?></h3>
	<div class="acc-cc">
		<p class="intro2"><?php _e('List up to three items for each of the following areas', 'am') ?></p>
        <?php foreach($items as $item): ?>
		<fieldset>
			<div class="row tosave group" data-key="room_features" data-subkey="<?php echo $item['key']?>" >
				<div class="col-12">
					<label><?php echo $item['name']?></label>
				</div>
                <?php for ($i=0;$i<3;$i++):?>
                    <div class="col-sm-6 col-md-4">
                        <input type="text" name="<?php echo $item['key']?>[]" value="<?php echo isset($features[$item['key']][$i])?$features[$item['key']][$i]:''?>" class="save-item">
                    </div>
                <?php endfor;?>
			</div>
		</fieldset>
        <?php endforeach; ?>
	</div>
</div>

<div class="acc-item">
	<h3 class="toggle"><?php _e('Description', 'am') ?></h3>
	<div class="acc-cc">
		<fieldset>
			<div class="row ">
				<div class="col-12">
					<label><?php _e('Provide a written description of the property', 'am') ?></label>
				</div>
				<div class="col-sm-12 col-lg-8">
					<textarea class="big" name="description" id="description" class="tosave"><?php echo $listing?$listing['description']:''; ?></textarea>
				</div>
			</div>
		</fieldset>
	</div>
</div>

<div class="acc-item salerent_1 tosave array" id="openhouse">
	<h3 class="toggle"><?php _e('Open Houses', 'am') ?></h3>
	<div class="acc-cc">
		<p class="intro3"><?php _e('Planning an Open House? Why not add this to your listing! If you are not sure of open dates now, you can always add them later through My Zaivia<br>Provide open house information', 'am') ?></p>

        <?php $open_houses = $listingId ? ZaiviaListings::getListingOpenhouse($listingId) : []; ?>
        <?php foreach($open_houses as $open_house):?>
            <div class="row gutters-16 openhouse-block array-row">
                <div class="col-12 col-sm-5 col-lg-4">
                    <fieldset>
                        <label><?php _e('Date', 'am') ?></label>
                        <div class="datepick">
                            <input type="text" placeholder="<?php _e('June 23', 'am') ?>" name="openhouse_date[]" class="datepicker" value="<?php echo $open_house['date'] ?>">
                            <div class="trigger">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-5 col-sm-3 col-lg-2">
                    <fieldset>
                        <label><?php _e('Start Time', 'am') ?></label>
                        <select name="openhouse_time_start[]">
                            <?php  foreach(ZaiviaListings::$time as $key=>$val): ?>
                            <option <?php echo $open_house['start_time'] == $key?' selected':'' ?> value="<?php echo $key; ?>"><?php echo $val; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </fieldset>
                </div>
                <div class="col-5 col-sm-3 col-lg-2">
                    <fieldset>
                        <label><?php _e('End Time', 'am') ?></label>
                        <select name="openhouse_time_end[]">
		                    <?php  foreach(ZaiviaListings::$time as $key=>$val): ?>
                                <option <?php echo $open_house['end_time'] == $key?' selected':'' ?> value="<?php echo $key; ?>"><?php echo $val; ?></option>
		                    <?php endforeach; ?>
                        </select>
                    </fieldset>
                </div>
                <div class="col-2 col-md-1 col-lg-2">
                    <a href="#" class="remove remove-openhouse"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>
                </div>
            </div>
        <?php endforeach; ?>

		<?php if(!count($open_houses)):?>
            <div class="row gutters-16 openhouse-block array-row">
                <div class="col-12 col-sm-5 col-lg-4">
                    <fieldset>
                        <label><?php _e('Date', 'am') ?></label>
                        <div class="datepick">
                            <input type="text" placeholder="<?php _e('June 23', 'am') ?>" name="openhouse_date[]" class="datepicker">
                            <div class="trigger">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-5 col-sm-3 col-lg-2">
                    <fieldset>
                        <label><?php _e('Start Time', 'am') ?></label>
                        <select name="openhouse_time_start[]">
                            <?php  foreach(ZaiviaListings::$time as $key=>$val): ?>
                                <option value="<?php echo $key?>"><?php echo $val?></option>
                            <?php endforeach; ?>
                        </select>
                    </fieldset>
                </div>
                <div class="col-5 col-sm-3 col-lg-2">
                    <fieldset>
                        <label><?php _e('End Time', 'am') ?></label>
                        <select name="openhouse_time_end[]">
                            <?php  foreach(ZaiviaListings::$time as $key=>$val): ?>
                                <option value="<?php echo $key?>"><?php echo $val?></option>
                            <?php endforeach; ?>
                        </select>
                    </fieldset>
                </div>
                <div class="col-2 col-md-1 col-lg-2">
                    <a href="#" class="remove remove-openhouse"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>
                </div>
            </div>
        <?php endif; ?>
        <div id="more-openhouse"></div>
        <div class="row gutters-16 openhouse-block" style="display:none" id="openhouse-block">
            <div class="col-12 col-sm-5 col-lg-4">
                <fieldset>
                    <label><?php _e('Date', 'am') ?></label>
                    <div class="datepick">
                        <input type="text" placeholder="<?php _e('June 23', 'am') ?>" name="openhouse_date[]" class="datepicker-hidden">
                        <div class="trigger">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-5 col-sm-3 col-lg-2">
                <fieldset>
                    <label><?php _e('Start Time', 'am') ?></label>
                    <select name="openhouse_time_start[]">
						<?php  foreach(ZaiviaListings::$time as $key=>$val): ?>
                            <option value="<?php echo $key?>"><?php echo $val?></option>
						<?php endforeach; ?>
                    </select>
                </fieldset>
            </div>
            <div class="col-5 col-sm-3 col-lg-2">
                <fieldset>
                    <label><?php _e('End Time', 'am') ?></label>
                    <select name="openhouse_time_end[]">
						<?php  foreach(ZaiviaListings::$time as $key=>$val): ?>
                            <option value="<?php echo $key?>"><?php echo $val?></option>
						<?php endforeach; ?>
                    </select>
                </fieldset>
            </div>
            <div class="col-2 col-md-1 col-lg-2">
                <a href="#" class="remove remove-openhouse"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>
            </div>
        </div>

        <div class="add-row">
			<a href="#" id="add-openhouse"><i class="fa fa-plus-circle" aria-hidden="true"></i>Add Another Date</a>
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
			<a href="#" class="btn btn-outline blue btn-sm listing-step" rel="1"><?php _e('Previous', 'am') ?></a>
			<a href="#" class="btn btn-primary btn-sm listing-step" rel="3"><?php _e('Next Step', 'am') ?></a>
		</div>
	</div>
</div>