<script type="text/html" id="tmpl-listing-item">
    <article class="ad-item<# if ( !data.featured_one && data.premium > 0 ) { #> premium<# } #>">
        <# if ( data.featured_one > 0 ) { #>
        <div class="featured"><?php _e('FEATURED LISTING','am'); ?></div>
        <# } else if ( data.premium > 0 ) { #>
        <div class="featured"><?php _e('PREMIUM LISTING','am'); ?></div>
        <# } #>
        <div class="image"<# if(data.images.card) { #> style="background-image: url('{{data.images.card}}')"<# } #>>
        <# if(data.images.card) { #><a href="<?php echo get_site_url(); ?>/listing/?id={{data.listing_id}}"><img src="{{data.images.card}}" alt=""></a><# } #>
            <div class="badges">
                <# if ( data.openhouse.length > 0 ) { #>
                <div class="open">
                    <?php _e('OPEN HOUSE','am'); ?>
                    <div class="tooltip">
                        <ul>
                            <# for ( i in data.openhouse ) { #>
                            <li><i class="fa fa-calendar-o" aria-hidden="true"></i><strong>{{data.openhouse[i].src_date}}</strong><br>{{data.openhouse[i].src_start_time}} - {{data.openhouse[i].src_end_time}}</li>
                            <# } #>
                        </ul>
                    </div>
                </div>
                <# } #>
                <# if ( data.new_listing > 0 ) { #>
                <div class="new"><?php _e('NEW LISTING','am'); ?></div>
                <# } #>
            </div>
            <div class="love">
                <a href="#"><i class="fa fa-heart-o fav_add" data-id="{{data.listing_id}}" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="text">
            <div class="left">
                <h2><a href="<?php echo get_site_url(); ?>/listing/?id={{data.listing_id}}">{{data.unit_number}} {{data.address}}</a></h2>
                <p>{{data.city}}, {{data.province}}</p>
            </div>
            <div class="price">${{data.price}}</div>
            <div class="modu">
                <h6>{{data.property_type}}</h6>
                <div class="cols">
                    <div class="col">
                        <ul>
                            <li>{{data.bedrooms}} <?php _e('Bedrooms','am'); ?></li>
                            <li>{{data.bathrooms}} <?php _e('Bathrooms','am'); ?></li>
                            <li>{{data.square_footage}} <?php _e('sq. ft.','am'); ?></li>
                            <li>{{data.parking}} <?php _e('parking','am'); ?></li>
                        </ul>
                    </div>
                    <div class="col">
                        <ul>
                            <li><?php _e('Built in','am'); ?> {{data.year_built}}</li>
                            <li>{{data.size_x}} x {{data.size_y}} <?php _e('sq.','am'); ?> {{data.size_units}}. <?php _e('lot','am'); ?></li>
                            <li>{{data.roof_type}} <?php _e('roof','am'); ?></li>
                            <li>{{data.exterior_type}} <?php _e('exterior','am'); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
            <# if ( data.sale_by != 1 ) { #>
            <div class="listed">
                <p><?php _e('Listed By','am'); ?><br>{{data.contact.contact_name}}</p>
                <div class="images">
                    <div class="ir">
                        <a href="#"><img src="{{data.contact.contact_logo.thumb}}" alt=""></a>
                    </div>
                    <div class="ir">
                        <a href="#"><img src="{{data.contact.contact_profile.thumb}}" alt=""></a>
                    </div>
                </div>
            </div>
            <# } #>
        </div>
    </article>
</script>
<script type="text/html" id="tmpl-grid-item">
    <article class="ad-item<# if ( data.featured_one > 0 ) { #> featured-l<# } else if ( data.premium > 0 ) { #> premium<# } #>">
        <div class="featured"><# if ( data.featured_one > 0 ) { #><?php _e('FEATURED LISTING','am'); ?><# } else if ( data.premium > 0 ) { #><?php _e('PREMIUM LISTING','am'); ?><# } #></div>
        <div<# if(data.images.card) { #> style="background-image: url('{{data.images.card}}')"<# } #> class="image">
        <a href="<?php echo get_site_url(); ?>/listing/?id={{data.listing_id}}"><img src="<# if(data.images.card) { #>{{data.images.card}}<# } else { #><?php echo get_template_directory_uri(); ?>/images/logo.png<# } #>" alt=""></a>
            <div class="badges">
                <# if ( data.openhouse.length > 0 ) { #>
                <div class="open">
                    <?php _e('OPEN HOUSE','am'); ?>
                    <div class="tooltip">
                        <ul>
                            <# for ( i in data.openhouse ) { #>
                            <li><i class="fa fa-calendar-o" aria-hidden="true"></i><strong>{{data.openhouse[i].src_date}}</strong><br>{{data.openhouse[i].src_start_time}} - {{data.openhouse[i].src_end_time}}</li>
                            <# } #>
                        </ul>
                    </div>
                </div>
                <# } #>
                <# if ( data.new_listing > 0 ) { #>
                <div class="new"><?php _e('NEW LISTING','am'); ?></div>
                <# } #>
            </div>
            <div class="love">
                <a href="#"><i class="fa fa-heart-o fav_add" data-id="{{data.listing_id}}" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="text">
            <div class="price">${{data.price}}</div>
            <div class="left">
                <h2><a href="<?php echo get_site_url(); ?>/listing/?id={{data.listing_id}}">{{data.unit_number}} {{data.address}}</a></h2>
                <p>{{data.city}}, {{data.province}}</p>
            </div>
            <div class="feats">
                <ul>
                    <li><strong><?php _e('Sq. ft.','am'); ?></strong> {{data.square_footage}}</li>
                    <li><strong><?php _e('Beds','am'); ?></strong> {{data.bedrooms}}</li>
                    <li><strong><?php _e('Baths','am'); ?></strong> {{data.bathrooms}}</li>
                </ul>
            </div>
            <# if ( data.sale_by != 1 ) { #>
            <div class="listed">
                <p><?php _e('Listed By','am'); ?><br>{{data.contact.contact_name}}</p>
                <div class="images">
                    <div class="ir">
                        <a href="#"><img src="{{data.contact.contact_logo.thumb}}" alt=""></a>
                    </div>
                    <div class="ir">
                        <a href="#"><img src="{{data.contact.contact_profile.thumb}}" alt=""></a>
                    </div>
                </div>
            </div>
            <# } #>
        </div>
    </article>
</script>
<script type="text/html" id="tmpl-listing-ad">
    <div class="ad-insert">
        <a href="{{data.list_banner_url}}">
            <img src="{{data.list_banner_image}}" alt="">
        </a>
    </div>
</script>
<script type="text/html" id="tmpl-listing-fav">
    <article>
        <div class="image">
            <# if(data.images.thumb) { #>
            <a href="<?php echo get_site_url(); ?>/listing/?id={{data.listing_id}}"><img src="{{data.images.thumb}}" alt=""></a>
            <# } else { #>
            &nbsp;<br>&nbsp;<br>
            <# } #>
        </div>
        <div class="text">
            <h4><a href="<?php echo get_site_url(); ?>/listing/?id={{data.listing_id}}">{{data.unit_number}} {{data.address}}</a></h4>
            <p>{{data.city}}, <br>{{data.province}}</p>
            <div class="price">${{data.price}}</div>
            <div class="fav">
                <a href="#"><i class="fa fa-heart fav_del" data-id="{{data.listing_id}}" aria-hidden="true"></i></a>
            </div>
        </div>
    </article>
</script>
<script type="text/html" id="tmpl-listing-view">
    <article>
        <div class="image">
            <# if(data.images.thumb) { #>
            <a href="<?php echo get_site_url(); ?>/listing/?id={{data.listing_id}}"><img src="{{data.images.thumb}}" alt=""></a>
            <# } else { #>
            &nbsp;<br>&nbsp;<br>
            <# } #>
        </div>
        <div class="text">
            <h4><a href="<?php echo get_site_url(); ?>/listing/?id={{data.listing_id}}">{{data.unit_number}} {{data.address}}</a></h4>
            <p>{{data.city}}, <br>{{data.province}}</p>
            <div class="price">${{data.price}}</div>
        </div>
    </article>
</script>
<script type="text/html" id="tmpl-popup-item">
    <section class="ad-listing map">
        <article class="ad-item<# if ( data.premium > 0 ) { #> premium<# } #>">
            <# if ( data.featured_one > 0 ) { #>
            <div class="featured"><?php _e('FEATURED LISTING','am'); ?></div>
            <# } else if ( data.premium > 0 ) { #>
            <div class="featured"><?php _e('PREMIUM LISTING','am'); ?></div>
            <# } #>
            <div<# if(data.images[0]) { #> style="background-image: url('{{data.images[0].card}}')"<# } #> class="image">
                <a href="<?php echo get_site_url(); ?>/listing/?id={{data.listing_id}}"><img src="<# if(data.images[0]) { #>{{data.images[0].card}}<# } else { #><?php echo get_template_directory_uri(); ?>/images/logo.png<# } #>" alt=""></a>
                <div class="badges">
                    <# if ( data.openhouse.length > 0 ) { #>
                    <div class="open">
                        <?php _e('OPEN HOUSE','am'); ?>
                        <div class="tooltip">
                            <ul>
                                <# for ( i in data.openhouse ) { #>
                                <li><i class="fa fa-calendar-o" aria-hidden="true"></i><strong>{{data.openhouse[i].src_date}}</strong><br>{{data.openhouse[i].src_start_time}} - {{data.openhouse[i].src_end_time}}</li>
                                <# } #>
                            </ul>
                        </div>
                    </div>
                    <# } #>
                    <# if ( data.new_listing > 0 ) { #>
                    <div class="new"><?php _e('NEW LISTING','am'); ?></div>
                    <# } #>
                </div>
                <div class="love">
                    <a href="#"><i class="fa fa-heart-o fav_add" data-id="{{data.listing_id}}" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="text">
                <div class="price">${{data.price}}</div>
                <h2><a href="<?php echo get_site_url(); ?>/listing/?id={{data.listing_id}}">{{data.unit_number}} {{data.address}}</a></h2>
                <p>{{data.city}}, {{data.province}}</p>
                <div class="feats">
                    <ul>
                        <li><strong><?php _e('Sq. ft.','am'); ?></strong> {{data.square_footage}}</li>
                        <li><strong><?php _e('Beds','am'); ?></strong> {{data.bedrooms}}</li>
                        <li><strong><?php _e('Baths','am'); ?></strong> {{data.bathrooms}}</li>
                    </ul>
                </div>
                <div class="listed">
                <# if ( data.sale_by != 1 ) { #>
                    <p><?php _e('Listed By','am'); ?><br>{{data.contact.contact_name}}</p>
                    <div class="images">
                        <div class="ir"><a href="#"><img src="{{data.contact.contact_logo.thumb}}" alt=""></a></div>
                        <div class="ir"><a href="#"><img src="{{data.contact.contact_profile.thumb}}" alt=""></a></div>
                    </div>
                <# } #>
                </div>
            </div>
        </article>
    </section>
</script>