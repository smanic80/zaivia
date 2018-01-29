<script type="text/html" id="tmpl-listing-item">
    <article class="ad-item<# if ( !data.featured_one && data.premium > 0 ) { #> premium<# } #>">
        <# if ( data.featured_one > 0 ) { #>
        <div class="featured">FEATURED LISTING</div>
        <# } else if ( data.premium > 0 ) { #>
        <div class="featured">PREMIUM LISTING</div>
        <# } #>
        <div class="image"<# if(data.images.file_url) { #> style="background-image: url('{{data.images.file_url}}')"<# } #>>
        <# if(data.images.file_url) { #><a href="#"><img src="{{data.images.file_url}}" alt=""></a><# } #>
            <div class="badges">
                <# if ( data.openhouse.length > 0 ) { #>
                <div class="open">
                    OPEN HOUSE
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
                <div class="new">NEW LISTING</div>
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
                            <li>{{data.bedrooms}} Bedrooms</li>
                            <li>{{data.bathrooms}} Bathrooms</li>
                            <li>{{data.square_footage}} sq. ft.</li>
                            <li>{{data.parking}} parking</li>
                        </ul>
                    </div>
                    <div class="col">
                        <ul>
                            <li>Built in {{data.year_built}}</li>
                            <li>{{data.size_x}} x {{data.size_y}} sq. {{data.size_units}}. lot</li>
                            <li>{{data.roof_type}} roof</li>
                            <li>{{data.exterior_type}} exterior</li>
                        </ul>
                    </div>
                </div>
            </div>
            <# if ( data.sale_by != 1 ) { #>
            <div class="listed">
                <p>Listed By<br>{{data.contact.contact_name}}</p>
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
            <a href="#"><img src="{{data.images.thumb}}" alt=""></a>
            <# } else { #>
            &nbsp;<br>&nbsp;<br>
            <# } #>
        </div>
        <div class="text">
            <h4><a href="#">{{data.unit_number}} {{data.address}}</a></h4>
            <p>{{data.city}}, <br>{{data.province}}</p>
            <div class="price">${{data.price}}</div>
            <div class="fav">
                <a href="#"><i class="fa fa-heart fav_del" data-id="{{data.listing_id}}" aria-hidden="true"></i></a>
            </div>
        </div>
    </article>
</script>