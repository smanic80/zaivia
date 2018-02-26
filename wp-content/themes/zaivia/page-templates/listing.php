<?php
/*
Template Name: Listing
Template Post Type: page
*/

$listing_id = isset($_GET['id'])?$_GET['id']:0;
$listing = ZaiviaListings::getListing($listing_id, false);

if($listing) {
    ZaiviaListings::updateLastViewed($listing_id);
	$listing = ZaiviaListings::prepareRenderListingData($listing);
}
get_header();


if($listing): ?>
<div class="body grey-bg">
    <div class="single-title">
        <div class="container sm">
            <div class="left">
                <h1><?php echo $listing['unit_number'].' '.$listing['address']; ?></h1>
                <p><?php echo $listing['city'].', '.$listing['province']; ?></p>
            </div>
            <div class="price"><?php echo $listing['price']; ?><div class="time"><?php echo $listing['price_per_month'] ?></div></div>
        </div>
    </div>
    <div class="back-line">
        <div class="container sm">
            <a href="#" class="btn-back"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i><?php _e('Back To Listings','am') ?></a>
        </div>
    </div>
    <div class="container sm">
        <div class="row gutters-40">
            <div class="col-md-85">
                <div class="singe-list">
                    <div class="gallery-slider">
                        <div class="slides">
                            <?php foreach ($listing['images'] as $image): ?>
                            <div class="item">
                                <img src="<?php echo $image['big']; ?>" alt="">
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="thumbs" <?php if(count($listing['images'])<=1):?>style="display:none;"<?php endif;?>>
                            <?php foreach ($listing['images'] as $image): ?>
                            <div class="item">
                                <img src="<?php echo $image['thumb']; ?>" alt="">
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="tabs-holder">
                        <div class="tab-nav ll">
                            <ul>
                                <li class="current"><a href="#details"><?php _e('DETAILS','am') ?></a></li>
                                <li><a href="#map-t"><?php _e('MAP','am') ?></a></li>
                                <li><a href="#floor"><?php _e('FLOORPLAN','am') ?></a></li>
                                <li><a href="#market"><?php _e('MARKET INFO','am') ?></a></li>
                            </ul>
                        </div>
                        <div class="tab-c active" id="details">
                            <div class="post-detail">
                                <div class="date">
                                    <?php _e('Posted on:','am') ?> <?php echo $listing['date_published']; ?>
                                    <?php if($listing['sale_rent'] == ZaiviaListings::$for_sale): ?><br/><?php echo $listing['MLSNumber']; ?><?php endif; ?>
                                </div>
                                <div class="entry">

                                    <h3><?php _e('Key Features','am') ?></h3>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <h4><?php echo $listing['listing_type_title']; ?></h4>
                                        </div>
                                        <div class="col-sm-4 text-right">
                                            <h4><?php echo $listing['price']; ?><?php if($listing['sale_rent'] == ZaiviaListings::$for_rent): ?> / <?php _e('month','am') ?><?php endif; ?></h4>
                                        </div>
                                    </div>

                                    <div class="features">
                                        <div class="row no-gutters">
                                            <div class="col-md-5">
                                                <dl>
                                                    <dt><?php _e('Bedrooms','am') ?>:</dt><dd><?php echo $listing['bedrooms']; ?></dd>
                                                    <dt><?php _e('Bathrooms','am') ?>:</dt><dd><?php echo $listing['bathrooms']; ?></dd>
                                                    <dt><?php _e('Parking','am') ?>:</dt><dd><?php echo $listing['parking']?></dd>
                                                    <dt><?php _e('Square Footage','am') ?>:</dt><dd><?php echo $listing['square_footage']?> </dd>
                                                    <dt><?php _e('Year Built','am') ?>:</dt><dd><?php echo $listing['year_built']; ?></dd>

	                                                <?php if($listing['sale_rent'] == ZaiviaListings::$for_rent): ?>
                                                        <dt><?php _e('Date Available','am') ?>:</dt><dd><?php echo $listing['rent_date'] ?></dd>
                                                        <dt><?php _e('Security Deposit','am') ?>:</dt><dd><?php echo $listing['rent_deposit'] ?></dd>
                                                        <dt><?php _e('Furnishings','am') ?>:</dt><dd><?php echo $listing['rent_furnishings'] ?></dd>
	                                                <?php else: ?>
                                                        <dt><?php _e('Driveway','am') ?>:</dt><dd><?php echo $listing['driveway']; ?></dd>
	                                                <?php endif; ?>
                                                </dl>
                                            </div>
                                            <div class="col-md-7">
                                                <dl>
	                                                <?php if($listing['sale_rent'] == ZaiviaListings::$for_rent): ?>
                                                        <dt><?php _e('Pets','am') ?>:</dt><dd><?php echo $listing['rent_pets']; ?></dd>
                                                        <dt><?php _e('Smoking','am') ?>:</dt><dd><?php echo $listing['rent_smoking']; ?></dd>
                                                        <dt><?php _e('Laundry','am') ?>:</dt><dd><?php echo $listing['rent_laundry']; ?></dd>
                                                        <dt><?php _e('Electrified Parking','am') ?>:</dt><dd><?php echo $listing['rent_electrified_parking']; ?></dd>
                                                        <dt><?php _e('Secured Entry','am') ?>:</dt><dd><?php echo $listing['rent_secured_entry']; ?></dd>
                                                        <dt><?php _e('Private Entry','am') ?>:</dt><dd><?php echo $listing['rent_private_entry']; ?></dd>
                                                        <dt><?php _e('Onsite Management','am') ?>:</dt><dd><?php echo $listing['rent_onsite']; ?></dd>
	                                                <?php else: ?>
                                                        <dt><?php _e('Lot Size','am') ?>:</dt><dd><?php echo $listing['lot_size']; ?></dd>
                                                        <dt><?php _e('Basement','am') ?>:</dt><dd><?php echo $listing['finished_basement']; ?></dd>
                                                        <dt><?php _e('Exterior','am') ?>:</dt><dd><?php echo $listing['exterior_type']; ?></dd>
                                                        <dt><?php _e('Roof Type','am') ?>:</dt><dd><?php echo $listing['roof_type']; ?></dd>
                                                        <dt><?php _e('Taxes','am') ?>:</dt><dd><?php echo $listing['annual_taxes']; ?></dd>
	                                                <?php endif; ?>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if(isset($listing['rent']['rent_utilities']) && $listing['rent']['rent_utilities']): ?>
                                    <?php
                                    $rent_utilities = array();
                                    $res = get_field('rent_utilities', 'option');
                                    foreach ($res as $el){
                                        $rent_utilities[$el['key']] = $el['name'];
                                    }
                                    ?>
                                    <h3><?php _e('Utilities Included','am') ?></h3>
                                    <div class="row">
                                        <div class="col-6 col-lg-3">
                                            <ul>
                                                <?php $index=0; foreach($listing['rent']['rent_utilities'] as $item): ?>
                                                    <?php if($index++ % 3 == 0):?>
                                                        <li><?php echo $rent_utilities[$item]; ?></li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <ul>
                                                <?php $index=0; foreach($listing['rent']['rent_utilities'] as $item): ?>
                                                    <?php if($index++ % 3 == 1):?>
                                                        <li><?php echo $rent_utilities[$item]; ?></li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="col-6 col-lg-4">
                                            <ul>
                                                <?php $index=0; foreach($listing['rent']['rent_utilities'] as $item): ?>
                                                    <?php if($index++ % 3 == 2):?>
                                                        <li><?php echo $rent_utilities[$item]; ?></li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($listing['features_1']): ?>
                                    <?php
                                    $features_1 = array();
                                    $res = get_field('features_1', 'option');
                                    foreach ($res as $el){
                                        $features_1[$el['key']] = $el['name'];
                                    }
                                    ?>
                                    <h3><?php _e('Other Features','am') ?></h3>
                                    <div class="row">
                                        <div class="col-6 col-lg-3">
                                            <ul>
                                                <?php $index=0; foreach($listing['features_1'] as $item): ?>
                                                    <?php if($index++ % 4 == 0):?>
                                                        <li><?php echo $features_1[$item]; ?></li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <ul>
                                                <?php $index=0; foreach($listing['features_1'] as $item): ?>
                                                    <?php if($index++ % 4 == 1):?>
                                                        <li><?php echo $features_1[$item]; ?></li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <ul>
                                                <?php $index=0; foreach($listing['features_1'] as $item): ?>
                                                    <?php if($index++ % 4 == 2):?>
                                                        <li><?php echo $features_1[$item]; ?></li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <ul>
                                                <?php $index=0; foreach($listing['features_1'] as $item): ?>
                                                    <?php if($index++ % 4 == 3):?>
                                                        <li><?php echo $features_1[$item]; ?></li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php $listing['features_3'] = array_merge($listing['features_3'], $listing['features_3_custom']); ?>
                                    <?php if ($listing['features_3']): ?>
                                    <h3><?php _e('Outdoor Amenities','am') ?></h3>
                                    <div class="row">
                                        <div class="col-6 col-lg-3">
                                            <ul>
                                                <?php $index=0; foreach($listing['features_3'] as $item): ?>
                                                    <?php if($index++ % 4 == 0):?>
                                                        <li><?php echo $item; ?></li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <ul>
                                                <?php $index=0; foreach($listing['features_3'] as $item): ?>
                                                    <?php if($index++ % 4 == 1):?>
                                                        <li><?php echo $item; ?></li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <ul>
                                                <?php $index=0; foreach($listing['features_3'] as $item): ?>
                                                    <?php if($index++ % 4 == 2):?>
                                                        <li><?php echo $item; ?></li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <ul>
                                                <?php $index=0; foreach($listing['features_3'] as $item): ?>
                                                    <?php if($index++ % 4 == 3):?>
                                                        <li><?php echo $item; ?></li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($listing['room_features']): ?>
                                    <h3><?php _e('Room Descriptions','am') ?></h3>
                                    <div class="row">
                                        <?php
                                        $names = array();
                                        $res = get_field('room_features', 'option');
                                        foreach ($res as $el){
                                            $names[$el['key']] = $el['name'];
                                        }
                                        ?>
                                        <?php foreach ($listing['room_features'] as $room => $features): ?>
                                        <div class="col-6 col-lg-3">
                                            <h5><?php echo $names[$room]; ?></h5>
                                            <ul>
                                                <?php foreach ($features as $feature): ?>
                                                <li><?php echo $feature; ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php $listing['features_2'] = array_merge($listing['features_2'], $listing['features_2_custom']); ?>
                                    <?php if ($listing['features_2']): ?>
                                    <h3><?php _e('Appliances Included','am') ?></h3>
                                    <div class="row">
                                        <div class="col-6 col-lg-4">
                                            <ul>
                                                <?php $index=0; foreach($listing['features_2'] as $item): ?>
                                                    <?php if($index++ % 3 == 0):?>
                                                        <li><?php echo $item; ?></li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="col-6 col-lg-4">
                                            <ul>
                                                <?php $index=0; foreach($listing['features_2'] as $item): ?>
                                                    <?php if($index++ % 3 == 1):?>
                                                        <li><?php echo $item; ?></li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="col-6 col-lg-4">
                                            <ul>
                                                <?php $index=0; foreach($listing['features_2'] as $item): ?>
                                                    <?php if($index++ % 3 == 2):?>
                                                        <li><?php echo $item; ?></li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($listing['description']): ?>
                                    <h3><?php _e('Description','am') ?></h3>
                                    <p><?php echo $listing['description']; ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-c" id="map-t">
                            <div class="post-map post-detail">
                                <div class="map-h">
                                    <div class="controls">
                                        <a href="#view" class="current"><i class="fa fa-map-o" aria-hidden="true"></i><?php _e('Map View','am') ?></a>
                                        <a href="#road"><i class="fa fa-road" aria-hidden="true"></i><?php _e('Street View','am') ?></a>
                                    </div>
                                    <div class="map-type active" id="view">
                                        <div class="map" id="map3"></div>
                                    </div>
                                    <div class="map-type" id="road">
                                        <div class="map" id="map31"></div>
                                    </div>
                                    <script>
                                        var position = {lat: <?php echo $listing['lat']; ?>, lng: <?php echo $listing['lng']; ?>};
                                    </script>
                                </div>
                                <div class="row" id="marker_type">
                                    <div class="col-sm-6 col-xl-4">
                                        <div class="ico green">
                                            <i data-class="fa fa-graduation-cap" data-type="school" aria-hidden="true"></i>
                                        </div>
                                        <div class="label"><?php _e('Show Nearby Schools','am') ?></div>
                                    </div>
                                    <div class="col-sm-6 col-xl-4 ml-1">
                                        <div class="ico purple">
                                            <i data-class="fa fa-shopping-cart" data-type="store" aria-hidden="true"></i>
                                        </div>
                                        <div class="label"><?php _e('Show Nearby Grocerie Stores','am') ?></div>
                                    </div>
                                    <div class="col-sm-6 col-xl-4">
                                        <div class="ico dgreen">
                                            <i data-class="fa fa-shopping-cart" data-type="bank" aria-hidden="true"></i>
                                        </div>
                                        <div class="label"><?php _e('Show Nearby Banks','am') ?></div>
                                    </div>
                                    <div class="col-sm-6 col-xl-4">
                                        <div class="ico yellow">
                                            <i data-class="fa fa-cutlery" data-type="restaurant" aria-hidden="true"></i>
                                        </div>
                                        <div class="label"><?php _e('Show Nearby Restaurants','am') ?></div>
                                    </div>
                                    <div class="col-sm-6 col-xl-4 ml-1">
                                        <div class="ico blue">
                                            <i data-class="fa fa-shopping-bag" data-type="supermarket" aria-hidden="true"></i>
                                        </div>
                                        <div class="label"><?php _e('Show Nearby Shopping','am') ?></div>
                                    </div>
                                    <div class="col-sm-6 col-xl-4">
                                        <div class="ico red">
                                            <i data-class="fa fa-shopping-bag" data-type="gym" aria-hidden="true"></i>
                                        </div>
                                        <div class="label"><?php _e('Show Nearby Gyms','am') ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-c" id="floor">
                            <div class="post-floor post-detail">
                                <div class="slides">
                                    <?php foreach ($listing['blueprint'] as $image): ?>
                                    <div class="item">
                                        <img src="<?php echo $image['file_url']; ?>" alt="">
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-c" id="market">
                            <input type="hidden" id="listing_id" value="<?php echo $listing_id; ?>">
                            <script type="text/html" id="tmpl-listing-item">
                                <article class="ad-item<# if ( data.premium > 0 ) { #> premium<# } #>">
                                    <# if ( data.premium > 0 ) { #>
                                    <div class="featured"><?php _e('PREMIUM LISTING','am') ?></div>
                                    <# } #>
                                    <div class="image"<# if(data.images.card) { #> style="background-image: url('{{data.images.card}}')"<# } #>>
                                        <# if(data.images.card) { #><a href="#"><img src="{{data.images.card}}" alt=""></a><# } #>
                                        <div class="badges">
                                            <# if ( data.openhouse.length > 0 ) { #>
                                            <div class="open">
                                                <?php _e('OPEN HOUSE','am') ?>
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
                                            <div class="new"><?php _e('NEW LISTING','am') ?></div>
                                            <# } #>
                                        </div>
                                        <div class="love">
                                            <a href="#">
                                                <i class="fa <# if ( data.faved ) { #>fa-heart fav_del<# } else {#>fa-heart-o fav_add<# } #>" data-id="{{data.listing_id}}" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="text">
                                        <div class="left">
                                            <h2><a href="<?php echo get_site_url(); ?>/listing/?id={{data.listing_id}}">{{data.unit_number}} {{data.address}}</a></h2>
                                            <p>{{data.city}}, {{data.province}}</p>
                                        </div>
                                        <div class="price">{{data.price}}</div>
                                        <div class="modu">
                                            <h6>{{data.property_type}}</h6>
                                            <div class="cols">
                                                <div class="col">
                                                    <ul>
                                                        <li>{{data.bedrooms}} <?php _e('Bedrooms','am') ?></li>
                                                        <li>{{data.bathrooms}} <?php _e('Bathrooms','am') ?></li>
                                                        <li>{{data.square_footage}} <?php _e('sq. ft.','am') ?></li>
                                                        <li>{{data.parking}} <?php _e('parking','am') ?></li>
                                                    </ul>
                                                </div>
                                             </div>
                                        </div>
                                        <# if ( data.sale_by != 1 ) { #>
                                        <div class="listed">
                                            <p><?php _e('Listed By','am') ?><br>{{data.contact.contact_name}}</p>
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
                            <div class="post-market post-detail">
                                <div class="inside-tabs">
                                    <ul class="nav">
                                        <li class="current"><a href="#sale"><?php _e('For Sale','am') ?></a></li>
                                        <li><a href="#offer"><?php _e('Conditional Offer','am') ?></a></li>
                                        <li><a href="#sold"><?php _e('Recently Sold','am') ?></a></li>
                                    </ul>
                                    <div class="tab-ic active" id="sale">
                                        <section class="ad-listing"></section>
                                    </div>
                                    <div class="tab-ic" id="offer">
                                        <section class="ad-listing"></section>
                                    </div>
                                    <div class="tab-ic" id="sold">
                                        <section class="ad-listing"></section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-35">
                <div class="widget widget-map">
                    <div class="map-h">
                        <div class="map" id="map"></div>
                        <input type="hidden" id="map_lat" value="<?php echo $listing['lat']; ?>">
                        <input type="hidden" id="map_lng" value="<?php echo $listing['lng']; ?>">
                        <input type="hidden" id="map_name" value="<?php echo $listing['city']; ?>">
                    </div>
                </div>
                <div class="widget widget-need">
                    <h3><?php _e('Listed By Agent','am') ?></h3>
                    <div class="agent-item">
                        <div class="image">
                            <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/p1.jpg" alt=""></a>
                        </div>
                        <div class="text">
                            <div class="center">
                                <h4><a href="#">John Smith</a></h4>
                                <div class="role">
                                    Web Designer
                                </div>
                                <div class="by text-left">
                                    <h6>Bisiness</h6>
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
                                            <strong><?php _e('Phone','am') ?></strong><br>Office: 306-123-4567
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="mailto:">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                        <span class="tooltip">
                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                            <strong><?php _e('Mail','am') ?></strong><br>email.com
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                                        <span class="tooltip">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            <strong><?php _e('Address','am') ?></strong><br>Street
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-chain" aria-hidden="true"></i>
                                        <span class="tooltip">
                                            <i class="fa fa-chain" aria-hidden="true"></i>
                                            <strong><?php _e('Link','am') ?></strong><br>www.com
                                        </span>
                                    </a>
                                </li>
                            </ul>
                            <div class="profile">
                                <a href="#"><?php _e('View Profile','am') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget widget-listing">
                    <a href="#"><?php _e('View Other Listings','am') ?></a>
                </div>
                <div class="widget widget-report">
                    <h3><a href="#report" class="open-modal"><i class="fa fa-flag-o" aria-hidden="true"></i><?php _e('Report Listing','am') ?></a></h3>
                </div>
                <div class="widget widget-social">
                    <h3><?php _e('Share with Friends','am') ?></h3>
                    <ul>
                        <li><a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-pinterest-square" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
                    </ul>
                    <div class="save save-favs">
                        <a href="#" data-id="<?php echo $listing['listing_id'] ?>" >
                            <span <?php if( !$listing['faved'] ): ?>style="display:none;"<?php endif; ?>><i class="fa fa-heart fav_del" aria-hidden="true" ></i><?php _e('Remove from Favorites','am') ?></span>
                            <span <?php if( $listing['faved'] ): ?>style="display:none;"<?php endif; ?>><i class="fa fa-heart-o fav_add" aria-hidden="true" ></i><?php _e('Save as Favorite','am') ?></span>
                        </a>
                    </div>
                    <?php if($listing['rent'] && $listing['rent']['rent_file']): ?>
                    <div class="dl">
                        <a href="<?php echo $listing['rent']['rent_file']['file_url']; ?>"><i class="fa fa-file-text-o" aria-hidden="true"></i><?php _e('Download Rental Application','am') ?></a>
                    </div>
                    <?php endif; ?>
                </div>
                <?php if(get_field('sidebar_banner_url')): ?>
                <div class="widget widget-ad">
                    <a href="<?php echo get_field('sidebar_banner_url'); ?>"><img src="<?php echo get_field('sidebar_banner_image'); ?>" alt=""></a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; get_footer(); ?>
