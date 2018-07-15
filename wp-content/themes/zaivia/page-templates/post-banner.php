<?php
/*
Template Name: Post Banner
Template Post Type: page
*/

$item = $itemId = null;
$userId = get_current_user_id();

if($userId && isset($_GET['edit'])) {
    $itemId = (int)$_GET['edit'];
    $item = ZaiviaBusiness::getEntities(ZaiviaBusiness::$posttype_banner, $itemId, $userId);
    if(!$item) {
        wp_redirect(get_field("page_mybusiness", "option") . "#edit_" . ZaiviaBusiness::$posttype_banner);
        die;
    }
}

get_header(); ?>

<?php if(!$userId):?>
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
	<div class="sub-nav"><div class="container xs">
        <?php if ( has_nav_menu( 'accountmenu' ) ) : ?><?php wp_nav_menu( array( 'theme_location' => 'accountmenu', 'menu_class' => '', 'menu_id'=>'', 'container'=>'', 'depth'=>0) ); ?><?php endif; ?>
    </div></div>

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
						<li class="current"><a href="<?php the_field("page_mybusiness", "option")?>#edit_<?php echo ZaiviaBusiness::$posttype_banner?>" ><?php _e('Banner Ads', 'am') ?></a></li>
						<li><a href="<?php the_field("page_mybusiness", "option")?>#edit_<?php echo ZaiviaBusiness::$posttype_card?>" ><?php _e('Community Partners', 'am') ?></a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-9">
				<div class="my-ad">
					<div class="styled-form multistep-step form-step">

						<form action="#" id="add_banner_form" class="business_form" enctype="multipart/form-data">
							<?php wp_nonce_field('zai_add_banner','add_banner_nonce', true, true ); ?>
                            <input type="hidden" name="entity_id" id="entity_id" value="<?php echo isset($item['id']) ? $item['id'] : '';?>">

							<span class="saved-confirmation"><?php _e('Banner saved', 'am') ?></span>

							<div class="entry">
								<h1 class="pb-10"><?php echo ZaiviaBusiness::formatMoney(get_field("banner_price", "option"), 2)?> / <?php _e('month', 'am') ?></h1>
								<div class="row">
									<div class="col-md-6 mb-15">
										<p><?php _e('Ad Sizes Excepted', 'am') ?></p><h2><?php _e('728px by 90px', 'am') ?></h2>
									</div>
									<div class="col-md-6 mb-15">
										<p><?php _e('File Types Excepted', 'am') ?></p><h2><?php _e('JPEG & PNG', 'am') ?></h2>
									</div>
								</div>
							</div>

							<hr class="mb-30">

                            <div class="error_placeholder"></div>

							<div class="acc-item mb-15">
								<h3><?php _e('Ad Options', 'am') ?></h3>
								<div class="row">
									<div class="col-lg-10">
                                        <fieldset>
                                            <label><?php _e('Ad Name', 'am') ?></label>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6">
                                                    <input type="text" name="banner_title" id="banner_title" value="<?php echo isset($item['title']) ? $item['title'] : '';?>">
                                                </div>
                                            </div>
                                        </fieldset>
										<fieldset class="mb-15">
											<?php $key = ZaiviaListings::$image_key; ?>
                                            <input type="hidden" name="<?php echo $key?>_upload_input_media" id="<?php echo $key?>_upload_input_media" value="<?php echo isset($item[$key.'_id']) ? $item[$key.'_id'] : '';?>" rel="banner_image_error">
											<img alt="" id="<?php echo $key?>_upload_input_src" src="<?php echo isset($item[$key.'_url']) ? $item[$key.'_url'] : '';?>">
											<br class="mobile-only">
											<label class="btn btn-secondary ml-20 banner_image_error"><?php _e('Upload image', 'am') ?><input type="file" name="E" class="business_upload" id="<?php echo $key?>_upload_input"></label>
                                            <p id="<?php echo $key?>_upload_input_file-errors"></p>
										</fieldset>
										<fieldset>
											<label><?php _e('URL (Make your banner clicable so users can go directly to your website)', 'am') ?></label>
											<div class="row">
												<div class="col-sm-12 col-md-6">
													<input type="text" name="banner_url" id="banner_url" value="<?php echo isset($item['url']) ? $item['url'] : '';?>">
												</div>
											</div>
										</fieldset>
										<fieldset>
											<label><?php _e('Section', 'am') ?></label>
											<div class="row">
												<div class="col-sm-12 col-md-6">
													<select name="banner_section" id="banner_section">
														<option value="<?php echo ZaiviaListings::$for_rent?>" <?php if(isset($item['section']) && (int)$item['section']===ZaiviaListings::$for_rent) echo "selected"; ?>>
                                                            <?php _e('Rental', 'am') ?></option>
														<option value="<?php echo ZaiviaListings::$for_sale?>" <?php if(isset($item['section']) && (int)$item['section']===ZaiviaListings::$for_sale) echo "selected"; ?>>
                                                            <?php _e('Sale', 'am') ?></option>
													</select>
												</div>
											</div>
										</fieldset>
										<fieldset>
											<label><?php _e('Community (Your Ad will be displayed withing this community +50 kms)', 'am') ?></label>
											<div class="row">
												<div class="col-sm-12 col-md-6">
													<input type="text" name="banner_community" id="banner_community" value="<?php echo isset($item['community']) ? $item['community'] : '';?>">
												</div>
											</div>
										</fieldset>
									</div>
								</div>
							</div>

							<div class="acc-item mb-30">
								<h3><?php _e('Duration', 'am') ?></h3>

                                <span class="business-valid-until" style="<?php if(!$item || !$item['date_renewal']):?>display:none;<?php endif; ?>">
                                    <?php _e('Valid until: ', 'am') ?><span><?php echo ZaiviaListings::formatDate($item['date_renewal']); ?></span><br>
                                </span>
								<?php if($item && !$item['date_renewal']) : ?><p class="error"><?php _e('Not published', 'am') ?></p><?php endif;?>

								<p class="intro duration_checked_error"><?php _e('Post My Advertismant For', 'am') ?></p>
                                <input type="hidden" name="duration_checked" id="duration_checked" value="<?php echo isset($item['duration']) ? $item['duration'] : '';?>" rel="duration_checked_error">
								<?php $durations = get_field("banner_duration", "option")?>
								<?php if($durations) :?>
								<fieldset class="checkbox checked-one_holder">
									<?php foreach($durations as $duration):?>
                                        <p><span class="wpcf7-form-control-wrap"><span class="wpcf7-form-control wpcf7-checkbox"><span class="wpcf7-list-item">
                                            <label>
                                                <input type="checkbox" class="checked-one banner-date-update" rel="duration_checked" name="duration[]" id="duration-<?php echo $duration['months']?>" value="<?php echo $duration['months']?>" />&nbsp;
                                                <span class="wpcf7-list-item-label"><?php echo $duration['label']?></span>
                                            </label>
                                        </span></span></span></p>
									<?php endforeach; ?>
								</fieldset>
								<?php endif;?>
							</div>

							<div class="btn-s">
								<div class="text-right">
                                    <?php if(is_administrator()) :?>
                                        <?php if(isset($item['id'])) : ?>
                                            <a href="#" class="btn btn-primary btn-sm delete"><?php _e('Delete', 'am') ?></a>
		                                    <?php if($item['date_renewal']) : ?>
                                                <a href="#" class="btn btn-primary btn-sm disable"><?php _e('Unpublish', 'am') ?></a>
                                            <?php else :?>
                                                <a href="#" class="btn btn-primary btn-sm enable"><?php _e('Publish', 'am') ?></a>
		                                    <?php endif; ?>
                                        <?php endif; ?>
                                        <a href="#" class="btn btn-primary btn-sm submit save"><?php _e('Save', 'am') ?></a>
                                    <?php else:?>
                                        <a href="#" class="btn btn-primary btn-sm submit payment" style="display: none;"><?php _e('Payment', 'am') ?></a>
                                        <a href="#" class="btn btn-primary btn-sm submit save"><?php _e('Save', 'am') ?></a>
                                    <?php endif; ?>
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

<?php endif; ?>

<?php get_footer(); ?>
