<?php
/*
Template Name: Listing
Template Post Type: page
*/

get_header();

$listing_id = isset($_GET['id'])?$_GET['id']:0;
$listing = ZaiviaListings::getListing($listing_id);
?>
<div class="body grey-bg">
    <div class="single-title">
        <div class="container sm">
            <div class="left">
                <h1><?php echo $listing['unit_number'].' '.$listing['address']; ?></h1>
                <p><?php echo $listing['city'].', '.$listing['province']; ?></p>
            </div>
            <div class="price">$<?php echo $listing['price']; ?><div class="time"><?php if($listing['sale_rent'] == ZaiviaListings::$for_rent): ?>per month<?php else: ?>Est. Mortage: $<?php echo '---'; ?>/mth<?php endif; ?></div></div>
        </div>
    </div>
    <div class="back-line">
        <div class="container sm">
            <a href="#" class="btn-back"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i>Back To Listings</a>
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
                                <img src="<?php echo $image['file_url']; ?>" alt="">
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="thumbs">
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
                                <li class="current"><a href="#details">DETAILS</a></li>
                                <li><a href="#map-t">MAP</a></li>
                                <li><a href="#floor">FLOORPLAN</a></li>
                                <li><a href="#market">MARKET INFO</a></li>
                            </ul>
                        </div>
                        <div class="tab-c active" id="details">
                            <div class="post-detail">
                                <div class="date">Posted on: <?php echo date('M d, Y',strtotime($listing['date_published'])); ?></div>
                                <div class="entry">
                                    <h3>Key Features</h3>
                                    <div class="row">
                                        <?php if($listing['sale_rent'] == ZaiviaListings::$for_rent): ?>
                                        <div class="col-sm-8">
                                            <h4><?php echo $listing['property_type']; ?> - <?php echo implode(', ',$listing['partial_rent']); ?> For Rent</h4>
                                        </div>
                                        <div class="col-sm-4 text-right">
                                            <h4>$<?php echo $listing['price']; ?> / month</h4>
                                        </div>
                                        <?php else: ?>
                                        <div class="col-sm-8">
                                            <h4><?php echo $listing['property_type'].($listing['house_type']?' ('.$listing['house_type'].')':''); ?> - For Sale</h4>
                                        </div>
                                        <div class="col-sm-4 text-right">
                                            <h4>$<?php echo $listing['price']; ?></h4>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="features">
                                        <div class="row no-gutters">
                                            <?php if($listing['rent']): ?>
                                            <div class="col-md-5">
                                                <dl>
                                                    <dt>Bedrooms:</dt>
                                                    <dd><?php echo $listing['bedrooms']; ?></dd>
                                                    <dt>Bathrooms:</dt>
                                                    <dd><?php echo $listing['bathrooms']; ?></dd>
                                                    <dt>Parking:</dt>
                                                    <dd><?php echo $listing['parking']; ?></dd>
                                                    <dt>Square Footage:</dt>
                                                    <dd><?php echo $listing['square_footage']; ?> sq. ft</dd>
                                                    <dt>Year Built:</dt>
                                                    <dd><?php echo $listing['year_built']; ?></dd>
                                                    <dt>Date Available:</dt>
                                                    <dd><?php echo $listing['rent_date']?date('M d, Y',strtotime($listing['rent_date'])):'-'; ?></dd>
                                                    <dt>Security Deposit:</dt>
                                                    <dd><?php echo $listing['rent_deposit']?'$'.$listing['rent_deposit']:'-'; ?></dd>
                                                    <dt>Furnishings:</dt>
                                                    <dd><?php if($listing['rent']['rent_furnishings']){ ?>Yes<?php } else { ?>No<?php } ?></dd>
                                                </dl>
                                            </div>
                                            <div class="col-md-7">
                                                <dl>
                                                    <dt>Pets:</dt>
                                                    <dd><?php if($listing['rent']['rent_pets']){ ?>Yes<?php } else { ?>No pets<?php } ?></dd>
                                                    <dt>Smoking:</dt>
                                                    <dd><?php if($listing['rent']['rent_smoking']){ ?>Yes<?php } else { ?>Non-smoking<?php } ?></dd>
                                                    <dt>Laundry:</dt>
                                                    <dd><?php if($listing['rent']['rent_laundry']){ ?>Yes<?php } else { ?>No<?php } ?></dd>
                                                    <dt>Electrified Parking:</dt>
                                                    <dd><?php if($listing['rent']['rent_electrified_parking']){ ?>Yes<?php } else { ?>No<?php } ?></dd>
                                                    <dt>Secured Entry:</dt>
                                                    <dd><?php if($listing['rent']['rent_secured_entry']){ ?>Yes<?php } else { ?>No<?php } ?></dd>
                                                    <dt>Private Entry:</dt>
                                                    <dd><?php if($listing['rent']['rent_private_entry']){ ?>Yes<?php } else { ?>No<?php } ?></dd>
                                                    <dt>Onsite Management:</dt>
                                                    <dd><?php if($listing['rent']['rent_onsite']){ ?>Yes<?php } else { ?>No<?php } ?></dd>
                                                </dl>
                                            </div>
                                            <?php else: ?>
                                            <div class="col-md-5">
                                                <dl>
                                                    <dt>Bedrooms:</dt>
                                                    <dd><?php echo $listing['bedrooms']; ?></dd>
                                                    <dt>Bathrooms:</dt>
                                                    <dd><?php echo $listing['bathrooms']; ?></dd>
                                                    <dt>Floor Size:</dt>
                                                    <dd>--- ft</dd>
                                                    <dt>Parking:</dt>
                                                    <dd><?php echo $listing['parking']; ?></dd>
                                                    <dt>Driveway:</dt>
                                                    <dd><?php echo $listing['driveway']; ?></dd>
                                                    <dt>Year Built:</dt>
                                                    <dd><?php echo $listing['year_built']; ?></dd>
                                                </dl>
                                            </div>
                                            <div class="col-md-7">
                                                <dl>
                                                    <dt>Lot Size:</dt>
                                                    <dd><?php echo $listing['size_x']; ?> x <?php echo $listing['size_y']; ?> <?php echo $listing['size_units']; ?></dd>
                                                    <dt>Basement:</dt>
                                                    <dd><?php if(in_array('finished_basement',$listing['features_1'])): ?>Finished<?php else: ?>Not Finished<?php endif; ?></dd>
                                                    <dt>Exterior:</dt>
                                                    <dd><?php echo $listing['exterior_type']; ?></dd>
                                                    <dt>Roof Type:</dt>
                                                    <dd><?php echo $listing['roof_type']; ?></dd>
                                                    <dt>Taxes:</dt>
                                                    <dd><?php echo $listing['annual_taxes']?'$'.$listing['annual_taxes']:'-'; ?></dd>
                                                </dl>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php if($listing['rent']): ?>
                                    <?php
                                    $rent_utilities = array();
                                    $res = get_field('rent_utilities', 'option');
                                    foreach ($res as $el){
                                        $rent_utilities[$el['key']] = $el['name'];
                                    }
                                    ?>
                                    <h3>Utilites Included</h3>
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
                                    <?php
                                    $features_1 = array();
                                    $res = get_field('features_1', 'option');
                                    foreach ($res as $el){
                                        $features_1[$el['key']] = $el['name'];
                                    }
                                    ?>
                                    <h3>Other Features</h3>
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
                                    <h3>Outdoor Amenities</h3>
                                    <?php $listing['features_3'] = array_merge($listing['features_3'], $listing['features_3_custom']); ?>
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
                                    <h3>Room Descriptions</h3>
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
                                    <h3>Appliances Included</h3>
                                    <?php $listing['features_2'] = array_merge($listing['features_2'], $listing['features_2_custom']); ?>
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
                                    <h3>Description</h3>
                                    <p><?php echo $listing['description']; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-c" id="map-t">
                            <div class="post-map post-detail">
                                <div class="map-h">
                                    <div class="controls">
                                        <a href="#view" class="current"><i class="fa fa-map-o" aria-hidden="true"></i>Map View</a>
                                        <a href="#road"><i class="fa fa-road" aria-hidden="true"></i>Street View</a>
                                    </div>
                                    <div class="map-type active" id="view">
                                        <div class="map" id="map3"></div>
                                    </div>
                                    <div class="map-type" id="road">
                                        <div class="map" id="map31"></div>
                                    </div>
                                    <script>
                                        var map3 = {lat: 52.0797723, lng: -106.6608851};
                                        var map3Street = {lat: 37.869260, lng: -122.254811};
                                        var map3Locations = [
                                            [52.0797723,-106.6608851,'images/ico_mappin.png','Public School Name'],
                                            [52.0797723,-106.7608851,'images/mblue.png','Public School Name'],
                                            [52.1797723,-106.5608851,'images/mgreen.png','Public School Name'],
                                            [52.0997723,-106.6608851,'images/mdgreen.png','Public School Name'],
                                            [52.0997723,-106.6608851,'images/mpurple.png','Public School Name'],
                                            [52.1797723,-106.7608851,'images/myellow.png','Public School Name'],
                                        ];
                                    </script>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-xl-4">
                                        <div class="ico green">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                        </div>
                                        <div class="label">Show Nearby Schools</div>
                                    </div>
                                    <div class="col-sm-6 col-xl-4 ml-1">
                                        <div class="ico purple">
                                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                        </div>
                                        <div class="label">Show Nearby Grocerie Stores</div>
                                    </div>
                                    <div class="col-sm-6 col-xl-4">
                                        <div class="ico dgreen">
                                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                        </div>
                                        <div class="label">Show Nearby Banks</div>
                                    </div>
                                    <div class="col-sm-6 col-xl-4">
                                        <div class="ico yellow">
                                            <i class="fa fa-cutlery " aria-hidden="true"></i>
                                        </div>
                                        <div class="label">Show Nearby Restaurants</div>
                                    </div>
                                    <div class="col-sm-6 col-xl-4 ml-1">
                                        <div class="ico blue">
                                            <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                        </div>
                                        <div class="label">Show Nearby Shopping</div>
                                    </div>
                                    <div class="col-sm-6 col-xl-4">
                                        <div class="ico red">
                                            <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                        </div>
                                        <div class="label">Show Nearby Gyms</div>
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
                            <div class="post-market post-detail">
                                <div class="inside-tabs">
                                    <ul class="nav">
                                        <li class="current"><a href="#sale">For Sale</a></li>
                                        <li><a href="#offer">Conditonal Offer</a></li>
                                        <li><a href="#sold">Recently Sold</a></li>
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
                    <h3>Listed By Agent</h3>
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
                                            <strong>Phone</strong><br>Office: 306-123-4567
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="mailto:">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                        <span class="tooltip">
                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                            <strong>Mail</strong><br>email.com
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                                        <span class="tooltip">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            <strong>Address</strong><br>Street
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-chain" aria-hidden="true"></i>
                                        <span class="tooltip">
                                            <i class="fa fa-chain" aria-hidden="true"></i>
                                            <strong>Link</strong><br>www.com
                                        </span>
                                    </a>
                                </li>
                            </ul>
                            <div class="profile">
                                <a href="#">View Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget widget-listing">
                    <a href="#">View Other Listings</a>
                </div>
                <div class="widget widget-report">
                    <h3><a href="#report" class="open-modal"><i class="fa fa-flag-o" aria-hidden="true"></i>Report Listing</a></h3>
                </div>
                <div class="widget widget-social">
                    <h3>Share with Friends</h3>
                    <ul>
                        <li><a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-pinterest-square" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
                    </ul>
                    <div class="save">
                        <a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i>Save as Favorite</a>
                    </div>
                    <?php if($listing['rent'] && $listing['rent']['rent_file']): ?>
                    <div class="dl">
                        <a href="<?php echo $listing['rent']['rent_file']; ?>"><i class="fa fa-file-text-o" aria-hidden="true"></i>Download Rental Application</a>
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
<?php get_footer(); ?>