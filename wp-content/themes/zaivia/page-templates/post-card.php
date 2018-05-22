<?php
/*
Template Name: Post Contact Card
Template Post Type: page
*/


get_header(); ?>

<?php if(!get_current_user_id()):?>
	<div class="container sm mb-35">
		<div class="row gutters-40">
			<div class="col-md-85">
				<div class="single-post">
					<div class="title">
						<h1><?php _e('Please, Login first','am') ?></h1>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php else: ?>


	<div class="sub-nav">
		<div class="container xs">
			<?php if ( has_nav_menu( 'accountmenu' ) ) : ?>
				<?php wp_nav_menu( array( 'theme_location' => 'accountmenu', 'menu_class' => '', 'menu_id'=>'', 'container'=>'', 'depth'=>0) ); ?>
			<?php endif; ?>
		</div>
	</div>

	<div class="category-head">
		<div class="container xs">
			<div class="left">
				<h1><?php $title = get_field('custom_title'); if(!empty($title)) : echo $title; else : the_title(); endif; ?></h1>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php the_content(__('Read more', 'am')); ?>
				<?php endwhile; endif; ?>
			</div>
		</div>
	</div>

	<div class="container xs">
		<div class="row">
			<div class="col-md-3">
				<div class="my-ad widget widget_archive">
					<ul>
						<li><a href="<?php the_field("page_mybusiness", "option")?>#edit_<?php echo ZaiviaBusiness::$posttype_banner?>" ><?php _e('Banner Ads', 'am') ?></a></li>
						<li class="current"><a href="<?php the_field("page_mybusiness", "option")?>#edit_<?php echo ZaiviaBusiness::$posttype_card?>" ><?php _e('Community Partners', 'am') ?></a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-9">
				<div class="my-ad">
					<div class="row">
						<div class="col-lg-6">
							<div class="entry text-center pt-50">
								<h1><?php _e("It's Free") ?></h1><h2><?php _e('Example Contact Card','am') ?></h2>
							</div>
						</div>
						<div class="col-lg-6">
							<?php
								$data = [
									"card_profile_image_url" => get_template_directory_uri() . "/images/p1.jpg",
									"card_first_name" => "John",
									"card_last_name" => "Smith",
									"card_job_title" => "Web Designer",
									"card_company" => "YasTech Developments",
                                    "card_company_show" => "1",
									"card_business_image_url" => get_template_directory_uri() . "/images/a1.png",
									"card_phone" => "3061234567",
                                    "card_phone_type" => "office",
									"card_email" => "mail@email.com",
									"card_address" => "Street",
                                    "card_city"=> "City",
									"card_lat" => "52.141944",
									"card_lng" => "-106.657855",
									"card_url" => "google.com",
								];
							?>
							<?php echo ZaiviaBusiness::renderCard($data);?>

						</div>
					</div>

					<?php
					$item = $ietmId = null;
					if(isset($_GET['edit'])) {
						$ietmId = (int)$_GET['edit'];
						$item = ZaiviaBusiness::getEntities(ZaiviaBusiness::$posttype_card, $ietmId, get_current_user_id());
					}
					?>
					<div class="styled-form multistep-step form-step">
						<form action="#" id="add_card_form" enctype="multipart/form-data">
							<?php wp_nonce_field('zai_add_card','add_card_nonce', true, true ); ?>
							<input type="hidden" name="entity_id" id="entity_id" value="<?php echo isset($item['id']) ? $item['id'] : '';?>">
							<span class="saved-confirmation"><?php _e('Contact card saved', 'am') ?></span>

                            <div class="error_placeholder"></div>

							<div class="acc-item bb">
								<h3><?php _e('Contact Card Information', 'am') ?></h3>
								<p class="intro"><?php the_field("page_description")?></p>
								<fieldset>
									<div class="row">
										<div class="col-12 col-lg-4">
											<label><?php _e('First Name', 'am') ?></label>
										</div>
										<div class="col-sm-12 col-lg-6">
											<input type="text" name="card_first_name" id="card_first_name" placeholder="" value="<?php echo isset($item['card_first_name']) ? $item['card_first_name'] : '';?>">
										</div>
									</div>
								</fieldset>
								<fieldset>
									<div class="row">
										<div class="col-12 col-lg-4">
                                            <label><?php _e('Last Name', 'am') ?></label>
										</div>
										<div class="col-sm-12 col-lg-6">
                                            <input type="text" name="card_last_name" id="card_last_name" placeholder="" value="<?php echo isset($item['card_last_name']) ? $item['card_last_name'] : '';?>">
										</div>
									</div>
								</fieldset>
								<fieldset>
									<div class="row">
										<div class="col-12 col-lg-4">
                                            <label><?php _e('Company Name', 'am') ?></label>
										</div>
										<div class="col-sm-12 col-lg-6">
                                            <input type="text" name="card_company" id="card_company" placeholder="" value="<?php echo isset($item['card_company']) ? $item['card_company'] : '';?>">
											<p><span class="wpcf7-form-control-wrap">
                                                <span class="wpcf7-form-control wpcf7-checkbox"><span class="wpcf7-list-item">
                                                    <label>
                                                        <input type="checkbox" name="card_company_show" id="card_company_show" value="1" <?php echo isset($item['card_company_show']) ? "checked" : '';?>>&nbsp;
                                                        <span class="wpcf7-list-item-label"><?php _e('Show company name on contact card', 'am') ?></span>
                                                    </label>
                                                </span></span>
                                            </span></p>
										</div>
									</div>
								</fieldset>
								<fieldset>
									<div class="row">
										<div class="col-12 col-lg-4">
											<label><?php _e('Your Title', 'am') ?></label>
										</div>
										<div class="col-sm-12 col-lg-6">
                                            <input type="text" name="card_job_title" id="card_job_title" placeholder="" value="<?php echo isset($item['card_job_title']) ? $item['card_job_title'] : '';?>">
										</div>
									</div>
								</fieldset>
								<fieldset>
									<div class="row">
										<div class="col-12 col-lg-4">
                                            <label><?php _e('Email', 'am') ?></label>
										</div>
										<div class="col-sm-12 col-lg-6">
                                            <input type="text" name="card_email" id="card_email" placeholder="" value="<?php echo isset($item['card_email']) ? $item['card_email'] : '';?>">
										</div>
									</div>
								</fieldset>
								<fieldset>
									<div class="row">
										<div class="col-12 col-lg-4">
											<label><?php _e('Phone Number', 'am') ?></label>
										</div>
                                        <div class="col-sm-12 col-lg-6">
                                            <div class="row">
                                                <div class="col-6">
                                                    <input type="text" name="card_phone" id="card_phone" placeholder="" value="<?php echo isset($item['card_phone']) ? $item['card_phone'] : '';?>">
                                                </div>
                                                <div class="col-6">
	                                                <?php $phoneType = isset($item['card_phone_type']) ? $item['card_phone_type'] : ""; ?>
                                                    <select name="card_phone_type" id="card_phone_type">
                                                        <option value="cell" <?php if($phoneType === 'cell') echo 'selected'?>><?php _e('Cell', 'am') ?></option>
                                                        <option value="office" <?php if($phoneType === 'office') echo 'selected'?>><?php _e('Office', 'am') ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
									</div>
								</fieldset>
								<fieldset>
									<div class="row">
										<div class="col-12 col-lg-4">
                                            <label><?php _e('Phone Number 2', 'am') ?></label>
										</div>
										<div class="col-sm-12 col-lg-6">
											<div class="row">
												<div class="col-6">
                                                    <input type="text" name="card_phone2" id="card_phone2" placeholder="" value="<?php echo isset($item['card_phone2']) ? $item['card_phone2'] : '';?>">
												</div>
												<div class="col-6">
													<?php $phoneType = isset($item['card_phone2_type']) ? $item['card_phone2_type'] : ""; ?>
                                                    <select name="card_phone2_type" id="card_phone2_type">
                                                        <option value="cell" <?php if($phoneType === 'cell') echo 'selected'?>><?php _e('Cell', 'am') ?></option>
                                                        <option value="office" <?php if($phoneType === 'office') echo 'selected'?>><?php _e('Office', 'am') ?></option>
                                                    </select>
												</div>
											</div>
										</div>
									</div>
								</fieldset>
								<fieldset>
									<div class="row">
										<div class="col-12 col-lg-4">
                                            <label><?php _e('Industry', 'am') ?></label>
										</div>
										<div class="col-sm-12 col-lg-6">
                                            <?php $card_industry_options = get_field("card_industry_options", "option") ?>
											<?php $card_industry = isset($item['card_industry']) ? $item['card_industry'] : ""; ?>
                                            <select name="card_industry" id="card_industry">
                                                <option value=""></option>
                                                <?php foreach($card_industry_options as $card_industry_option) :?>
                                                <option value="<?php echo $card_industry_option['label_singular']?>" <?php if($card_industry === $card_industry_option['label_singular']) echo 'selected'?>><?php echo $card_industry_option['label_singular']?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <p><span class="wpcf7-form-control-wrap">
                                                <span class="wpcf7-form-control wpcf7-checkbox"><span class="wpcf7-list-item">
                                                    <label>
                                                        <input type="checkbox" name="card_sponsor" id="card_sponsor" value="1" class="payed_feature">&nbsp;
                                                        <span class="wpcf7-list-item-label"><?php the_field("card_sponsor_price_label") ?> (<?php echo ZaiviaBusiness::formatMoney(get_field("card_sponsor_price", "option"), 2)?> / <?php _e('month', 'am') ?>)</span>
                                                    </label>
                                                </span></span>
                                            </span></p>
                                            <p><span class="card_sponsor-valid_until"
                                                     style="<?php if(!$item || !$item['card_sponsor_date']):?>display:none;<?php endif; ?>"
                                                     data-date="<?php if($item && $item['card_sponsor_date']) echo ZaiviaListings::formatDate($item['card_sponsor_date']) ?>">
                                                <?php _e('Your mortgage broker sponsorship is valid until: ', 'am') ?><span><?php echo ZaiviaListings::formatDate($item['card_sponsor_date']); ?></span><br>
                                            </span></p>
										</div>
									</div>
								</fieldset>
								<fieldset>
									<div class="row">
										<div class="col-12 col-lg-4">
											<label><?php _e('Street Address', 'am') ?></label>
										</div>
										<div class="col-sm-12 col-lg-6">
                                            <input type="text" name="card_address" id="card_address" placeholder="" value="<?php echo isset($item['card_address']) ? $item['card_address'] : '';?>">
											<p class="desc"><?php the_field("card_address_note") ?></p>
										</div>
									</div>
								</fieldset>
								<fieldset>
									<div class="row">
										<div class="col-12 col-lg-4">
                                            <label><?php _e('City', 'am') ?></label>
										</div>
										<div class="col-sm-12 col-lg-6">
                                            <input type="text" name="card_city" id="card_city" placeholder="" value="<?php echo isset($item['card_city']) ? $item['card_city'] : '';?>">
                                            <p class="desc"><?php the_field("card_city_note") ?></p>
										</div>
									</div>
								</fieldset>
								<fieldset>
									<div class="row">
										<div class="col-12 col-lg-4">
                                            <label><?php _e('Postal Code', 'am') ?></label>
										</div>
										<div class="col-sm-12 col-lg-6">
                                            <input type="text" name="card_zip" id="card_zip" placeholder="" value="<?php echo isset($item['card_zip']) ? $item['card_zip'] : '';?>">
										</div>
									</div>
								</fieldset>
								<fieldset>
									<div class="row">
										<div class="col-12 col-lg-4">
                                            <label><?php _e('Website', 'am') ?></label>
										</div>
										<div class="col-sm-12 col-lg-6">
                                            <p><span class="wpcf7-form-control-wrap">
                                                <span class="wpcf7-form-control wpcf7-checkbox"><span class="wpcf7-list-item">
                                                    <label>
                                                        <input type="checkbox" name="card_link" id="card_link" value="1" class="payed_feature">&nbsp;
                                                        <span class="wpcf7-list-item-label"><?php the_field("card_link_price_label") ?> (<?php echo ZaiviaBusiness::formatMoney(get_field("card_link_price", "option"), 2)?> / <?php _e('month', 'am') ?>)</span>
                                                    </label>
                                                </span></span>
                                            </span></p>
                                            <p><span class="card_url-valid_until"
                                                     style="<?php if(!$item || !$item['card_url_show_date']):?>display:none;<?php endif; ?>"
                                                     data-date="<?php if($item && $item['card_url_show_date']) echo ZaiviaListings::formatDate($item['card_url_show_date']) ?>">
                                                <?php _e('Link to your website is active until: ', 'am') ?><span><?php echo ZaiviaListings::formatDate($item['card_url_show_date']); ?></span><br>
                                            </span></p>
                                            <input type="text" name="card_url" id="card_url" placeholder="" value="<?php echo isset($item['card_url']) ? $item['card_url'] : '';?>">
										</div>
									</div>
								</fieldset>
								<fieldset>
									<div class="row">
										<div class="col-12 col-lg-4">
											<label><?php _e('Business Information', 'am') ?></label>
										</div>
										<div class="col-sm-12 col-lg-6">
											<textarea class="big" name="card_comments" id="card_comments"><?php echo isset($item['card_comments']) ? $item['card_comments'] : '';?></textarea>
										</div>
									</div>
								</fieldset>
							</div>



                            <div class="acc-item bb">
                                <h3><?php _e('Contact Card Images', 'am') ?></h3>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-12 col-lg-4">
                                            <label class="profile_image_error"><?php _e('Profile Image', 'am') ?></label>
                                        </div>
                                        <div class="col-sm-12 col-lg-6">
                                            <?php $key = ZaiviaBusiness::$image_key_profile; ?>
                                            <input type="hidden" name="<?php echo $key?>_upload_input_media" id="<?php echo $key?>_upload_input_media" value="<?php echo isset($item[$key.'_id']) ? $item[$key.'_id'] : '';?>" rel="profile_image_error">
                                            <fieldset>
                                                <img id="<?php echo $key?>_upload_input_src" src="<?php echo isset($item[$key.'_url']) ? $item[$key.'_url'] : '';?>" width="130" />
                                            </fieldset>
                                            <label class="btn btn-secondary mb-15"><?php _e('Upload image', 'am') ?><input type="file" name="E" class="business_upload" id="<?php echo $key?>_upload_input"></label>
                                            <p id="<?php echo $key?>_upload_input_file-errors"></p>
                                            <p class="intro"><i class="fa fa-info-circle" aria-hidden="true"></i><?php the_field("card_profile_image_note") ?></p>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-12 col-lg-4">
                                            <label class="business_logo_error"><?php _e('Business Logo', 'am') ?></label>
                                        </div>
                                        <div class="col-sm-12 col-lg-6">
	                                        <?php $key = ZaiviaBusiness::$image_key_logo; ?>
                                            <input type="hidden" name="<?php echo $key?>_upload_input_media" id="<?php echo $key?>_upload_input_media" value="<?php echo isset($item[$key.'_id']) ? $item[$key.'_id'] : '';?>" rel="business_logo_error">
                                            <fieldset>
                                                <img id="<?php echo $key?>_upload_input_src" src="<?php echo isset($item[$key.'_url']) ? $item[$key.'_url'] : '';?>" width="130" />
                                            </fieldset>
                                            <label class="btn btn-secondary mb-15"><?php _e('Upload image', 'am') ?><input type="file" name="E" class="business_upload" id="<?php echo $key?>_upload_input" ></label>
                                            <p id="<?php echo $key?>_upload_input_file-errors"></p>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="acc-item bb">
                                <h3><?php _e('Featured Community Partner', 'am') ?></h3>
                                <p class="intro"><?php the_field("card_featured_price_description") ?></p>
                                <fieldset class="checkbox"><p>
                                    <span class="wpcf7-form-control-wrap"><span class="wpcf7-form-control wpcf7-checkbox"><span class="wpcf7-list-item">
                                        <label><input type="checkbox" name="card_featured" id="card_featured" value="1" class="payed_feature">&nbsp;<span class="wpcf7-list-item-label"><?php the_field("card_featured_price_label") ?> (<?php echo ZaiviaBusiness::formatMoney(get_field("card_featured_price", "option"), 2)?> / <?php _e('month', 'am') ?>)</span></label>
                                    </span></span></span>
                                </p>
                                    <p><span class="card_featured-valid_until"
                                             style="<?php if(!$item || !$item['card_featured_date']):?>display:none;<?php endif; ?>"
                                             data-date="<?php if($item && $item['card_featured_date']) echo ZaiviaListings::formatDate($item['card_featured_date']) ?>">
                                        <?php _e('Your featured partnership is valid until: ', 'am') ?><span><?php echo ZaiviaListings::formatDate($item['card_featured_date']); ?></span><br>
                                    </span></p>
                                </fieldset>
                            </div>

                            <div class="acc-item bb">
                                <h3><?php _e('Duration', 'am') ?></h3>
                                <p class="intro duration_checked_error"><?php _e('Make me a Community Partner for', 'am') ?></p>
                                <input type="hidden" name="duration_checked" id="duration_checked" value="<?php echo isset($item['duration']) ? $item['duration'] : '';?>" rel="duration_checked_error">
								<?php $durations = get_field("card_duration", "option")?>
								<?php if($durations) :?>
                                    <fieldset class="checkbox checked-one_holder">
										<?php foreach($durations as $duration):?>
                                            <p><span class="wpcf7-form-control-wrap"><span class="wpcf7-form-control wpcf7-checkbox"><span class="wpcf7-list-item">
                                            <label>
                                                <input type="checkbox" class="checked-one card-date-update" rel="duration_checked" name="duration[]" id="duration-<?php echo $duration['months']?>" value="<?php echo $duration['months']?>" />
                                                &nbsp;<span class="wpcf7-list-item-label"><?php echo $duration['label']?></span>
                                            </label>
                                        </span></span></span></p>
										<?php endforeach; ?>
                                    </fieldset>
								<?php endif;?>
                            </div>

							<div class="btn-s">
								<div class="row">
									<div class="col-6">
										<a href="#preview" class="btn btn-secondary btn-sm open-modal" id="previw_card"><?php _e('Preview', 'am') ?></a>
									</div>
									<div class="col-6 text-right">
										<a href="#" class="btn btn-primary btn-sm submit payment" style="display: none;"><?php _e('Payment', 'am') ?></a>
										<a href="#" class="btn btn-primary btn-sm submit save"><?php _e('Save', 'am') ?></a>
									</div>
								</div>
							</div>
						</form>
					</div>

                    <div class="styled-form multistep-step payment-step">
						<?php $business = true;?>
						<?php include(locate_template('templates/payment.php')); ?>
					</div>

                    <div class="styled-form multistep-step confirmation-step">
                        <div class="box-center">
                            <i class="fa fa-check-circle " aria-hidden="true"></i>
                            <div class="entry">
                                <h2><?php the_field("confirmation_title")?></h2>
                                <p><?php the_field("confirmation_text")?></p>
                                <a href="<?php the_field("page_mybusiness", "option")?>" class="btn btn-primary btn-block"><?php the_field("confirmation_button")?></a>
                            </div>
                        </div>
                    </div>

				</div>
			</div>
		</div>
	</div>


	<div class="modal-overlay" id="preview">
		<div class="table">
			<div class="center">
				<div class="box max-375">
					<div class="close"><i class="fa fa-times" aria-hidden="true"></i></div>
					<h3>Account preview</h3>
					<div id="preview_inner"></div>
				</div>
			</div>
		</div>
	</div>

<?php endif; ?>

<?php get_footer(); ?>
