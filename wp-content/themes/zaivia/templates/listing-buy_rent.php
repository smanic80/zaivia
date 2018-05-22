<div class="container pp">
    <div class="row gutters-44">
        <div class="col-xl-9">
            <div class="sub-filter">
                <select class="custom-sort" id="sort_by" title="">
                    <option value="date_new_old"><?php _e('Date Posted: New to Old','am'); ?></option>
                    <option value="date_old_new"><?php _e('Date Posted: Old to New','am'); ?></option>
                    <option value="price_high_low"><?php _e('Price: High To Low','am'); ?></option>
                    <option value="price_low_high"><?php _e('Price: Low To High','am'); ?></option>
                </select>
                <ul>
                    <li class="current"><a href="#" data-type="list"><i class="fa fa-list-ul" aria-hidden="true"></i><?php _e('List View','am'); ?></a></li>
                    <li><a href="#" data-type="grid"><i class="fa fa-th" aria-hidden="true"></i><?php _e('Grid View','am'); ?></a></li>
                    <li><a href="#" data-type="map"><i class="fa fa-map-marker" aria-hidden="true"></i><?php _e('Map View','am'); ?></a></li>
                </ul>
            </div>

            <?php get_template_part('templates/listing', 'filters-applied'); ?>
            <?php get_template_part('templates/listing', 'item'); ?>
            <section class="ad-listing"></section>

            <div class="pagination-holder mb-30">
                <div class="pagination pagination-full">
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <aside class="side-widgets">
                <div class="widget widget-map">
                    <div class="map-h">
                        <div class="map" id="map"></div>
                    </div>
                </div>
                <div class="widget widget-need">
	                <?php echo ZaiviaBusiness::renderCard(ZaiviaBusiness::findRandomCard(isset($_GET['city']) ? $_GET['city'] : ""));?>
                </div>
                <div class="widget widget-promo">
                    <h3><?php _e('PROMOTE YOUR BUSINESS','am'); ?><br><span class="or"><?php _e('on','am'); ?></span><br><strong><?php _e('ZAIVIA FOR FREE!','am'); ?></strong></h3>
                    <a href="<?php the_field("page_postcard", "option")?>" class="btn btn-secondary"><?php _e('List Your Business','am'); ?></a>
                </div>
                <div class="widget widget-tabs">
                    <ul class="nav">
                        <li class="current"><a href="#fav_tab1"><?php _e('My Faves','am'); ?></a></li>
                        <li><a href="#fav_tab2"><?php _e('Recently Viewed','am'); ?></a></li>
                    </ul>
                    <section class="tab-s-c active" id="fav_tab1"><?php _e('To add listings to favorites by clicking on the heart','am'); ?></section>
                    <section class="tab-s-c" id="fav_tab2"><?php _e('No Listings Viewed','am'); ?></section>
                </div>
                <?php if (get_field('sidebar_banner_url')): ?>
                    <div class="widget widget-ad">
                        <a href="<?php the_field('sidebar_banner_url'); ?>">
                            <img src="<?php the_field('sidebar_banner_image'); ?>" alt="">
                        </a>
                    </div>
                <?php endif; ?>
            </aside>
        </div>
    </div>
</div>
<div class="map-full-holder hidden">
    <div class="sub-filter">
        <ul>
            <li><a href="#" data-type="list"><i class="fa fa-list-ul" aria-hidden="true"></i><?php _e('List View','am'); ?></a></li>
            <li><a href="#" data-type="grid"><i class="fa fa-th" aria-hidden="true"></i><?php _e('Grid View','am'); ?></a></li>
            <li class="current"><a href="#" data-type="map"><i class="fa fa-map-marker" aria-hidden="true"></i><?php _e('Map View','am'); ?></a></li>
        </ul>
        <div class="save">
            <a href="#"><i class="fa fa-home" aria-hidden="true"></i> <?php _e('Save This Search','am'); ?></a>
        </div>
    </div>
    <div class="map-holder" id="map2"></div>
</div>
<?php if(!is_user_logged_in()):?>
<div class="modal-overlay" id="email_modal">
    <div class="table">
        <div class="center">
            <div class="box">
                <div class="close"><i class="fa fa-times" aria-hidden="true"></i></div>
                <h3><?php _e('Email me listings that match this search criteriea','am'); ?></h3>
                <div class="error_placeholder"></div>
                <div class="styled-form">
                    <form action="#" id="saveSearchEmail">
                        <input type="email" name="save_email" id="save_email" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email" placeholder="Email" aria-required="true" aria-invalid="false">
                        <div class="space"></div>
                        <p>
                            <span class="wpcf7-form-control-wrap checkbox-399">
                                <span class="wpcf7-form-control wpcf7-checkbox">
                                    <span class="wpcf7-list-item first">
                                        <label>
                                            <input type="checkbox" name="send_email" id="send_email" value="1">&nbsp;
                                            <span class="wpcf7-list-item-label"><?php _e('By checking this box, I consent to receive emails from Zaivia','am'); ?></span>
                                        </label>
                                    </span>
                                </span>
                            </span>
                        </p>
                        <div class="g-recaptcha" id="recaptcha2" data-sitekey="6Le5j0sUAAAAABC0PwDA8hjfUWT-Te_nhf-fYluN"></div>
                        <input type="submit" value="Save Search" class="wpcf7-form-control wpcf7-submit">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script src='https://www.google.com/recaptcha/api.js'></script>
<?php endif; ?>

<div class="modal-overlay" id="save_search_modal">
    <div class="table">
        <div class="center">
            <div class="box">
                <div class="close"><i class="fa fa-times" aria-hidden="true"></i></div>
                <h3><?php the_field("save_search_success", "option") ?></h3>

            </div>
        </div>
    </div>
</div>
