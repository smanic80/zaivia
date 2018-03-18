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
                    <h3><?php _e('Do You Need A Designer?','am'); ?></h3>
                    <div class="agent-item">
                        <div class="image">
                            <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/p1.jpg" alt=""></a>
                        </div>
                        <div class="text">
                            <div class="center">
                                <h4><a href="#">John Smith</a></h4>
                                <div class="role">Web Designer</div>
                                <div class="by">
                                    <p>YasTech Developments</p>
                                    <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/a1.png" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <div class="bottom">
                            <ul>
                                <li>
                                    <a href="tel:3061234567">
                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                        <span class="tooltip">
                                            <i class="fa fa-phone" aria-hidden="true"></i>
                                            <strong><?php _e('Phone','am'); ?></strong><br>Office: 306-123-4567
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="mailto:">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                        <span class="tooltip">
                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                            <strong><?php _e('Mail','am'); ?></strong><br>email.com
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                                        <span class="tooltip">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            <strong><?php _e('Address','am'); ?></strong><br>Street
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-chain" aria-hidden="true"></i>
                                        <span class="tooltip">
                                            <i class="fa fa-chain" aria-hidden="true"></i>
                                            <strong><?php _e('Link','am'); ?></strong><br>www.com
                                        </span>
                                    </a>
                                </li>
                            </ul>
                            <div class="profile">
                                <a href="#"><?php _e('View Profile','am'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget widget-promo">
                    <h3><?php _e('PROMOTE YOUR BUSINESS','am'); ?><br><span class="or"><?php _e('on','am'); ?></span><br><strong><?php _e('ZAIVIA FOR FREE!','am'); ?></strong></h3>
                    <a href="#" class="btn btn-secondary"><?php _e('List Your Business','am'); ?></a>
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