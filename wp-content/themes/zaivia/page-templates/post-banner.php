<?php
/*
Template Name: Post Banner
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
						<li class="current"><a href="<?php the_field("page_postbusiness", "option")?>#edit_banners" ><?php _e('Banner Ads', 'am') ?></a></li>
						<li><a href="<?php the_field("page_postbusiness", "option")?>#edit_cards" ><?php _e('Community Partners', 'am') ?></a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-9">
				<div class="my-ad">
					<div class="styled-form">
						<form action="#" id="add_banner_form" enctype="multipart/form-data">
							<span class="saved-confirmation"><?php _e('Banner added', 'am') ?></span>


							<?php wp_nonce_field('zai_add_banner','add_banner_nonce', true, true ); ?>

							<div class="entry">
								<h1 class="pb-10"><?php echo ZaiviaBusiness::formatMoney(get_field("banner_price", "option"))?> / <?php _e('month', 'am') ?></h1>
								<div class="row">
									<div class="col-md-6 mb-15">
										<p><?php _e('Ad Sizes Excepted', 'am') ?></p>
										<h2>728px by 90px</h2>
									</div>
									<div class="col-md-6 mb-15">
										<p><?php _e('File Types Excepted', 'am') ?></p>
										<h2>JPEG & PNG</h2>
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
                                                    <input type="text" name="banner_title" id="banner_title"  value="">
                                                </div>
                                            </div>
                                        </fieldset>
										<fieldset class="mb-15">
                                            <input type="hidden" name="banner_upload_input_media" id="banner_upload_input_media" value="">
											<img alt="" id="banner_upload_input_src">
											<br class="mobile-only">
											<label class="btn btn-secondary ml-20">Upload image<input type="file" name="E" class="banner_upload" id="banner_upload_input"></label>
                                            <p id="banner_upload_input_file-errors"></p>
										</fieldset>
										<fieldset>
											<label><?php _e('URL (Make your banner clicable so users can go directly to your website)', 'am') ?></label>
											<div class="row">
												<div class="col-sm-12 col-md-6">
													<input type="text" name="banner_url" id="banner_url"  value="">
												</div>
											</div>
										</fieldset>
										<fieldset>
											<label><?php _e('Section', 'am') ?></label>
											<div class="row">
												<div class="col-sm-12 col-md-6">
													<select name="banner_section" id="banner_section">
														<option value="<?php echo ZaiviaListings::$for_rent?>"><?php _e('Rental', 'am') ?></option>
														<option value="<?php echo ZaiviaListings::$for_sale?>"><?php _e('Sale', 'am') ?></option>
													</select>
												</div>
											</div>
										</fieldset>
										<fieldset>
											<label><?php _e('Community (Your Ad will be displayed withing this community +50 kms)', 'am') ?></label>
											<div class="row">
												<div class="col-sm-12 col-md-6">
													<input type="text" name="banner_community" id="banner_community"  value="">
												</div>
											</div>
										</fieldset>
									</div>
								</div>
							</div>

							<div class="acc-item mb-30">
								<h3><?php _e('Duration', 'am') ?></h3>
								<p class="intro duration_checked_error"><?php _e('Post My Advertismant For*', 'am') ?></p>
                                <input type="hidden" name="duration_checked" id="duration_checked" value="" rel="duration_checked_error">
								<?php $durations = get_field("banner_duration", "option")?>
								<?php if($durations) :?>
								<fieldset class="checkbox checked-one_holder">
									<?php foreach($durations as $duration):?>
									<p>
				                      <span class="wpcf7-form-control-wrap">
				                        <span class="wpcf7-form-control wpcf7-checkbox">
				                          <span class="wpcf7-list-item">
				                            <label><input type="checkbox" class="checked-one" rel="duration_checked" name="duration[]" id="duration-<?php echo $duration['months']?>" value="<?php echo $duration['months']?>">&nbsp;<span class="wpcf7-list-item-label"><?php echo $duration['label']?></span></label>
				                          </span>
				                        </span>
				                      </span>
									</p>
									<?php endforeach; ?>
								</fieldset>
								<?php endif;?>
							</div>

							<div class="btn-s">
								<div class="text-right">
									<a href="#" class="btn btn-primary btn-sm submit"><?php _e('Payment', 'am') ?></a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php endif; ?>

<?php get_footer(); ?>
