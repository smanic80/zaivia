<?php
/*
Template Name: Buy
Template Post Type: page
*/

get_header(); ?>
<input type="hidden" id="page_id" value="<?php the_ID(); ?>">
<?php set_query_var( 'page_type', 'sale' ); ?>
<?php get_template_part('templates/listing', 'filter');?>

<div class="found-line">
  <div class="container pp">
    <p>1,000 Listings Found For Sale In Saskatoon </p>
  </div>
</div>
    
    <div class="container pp">
      <div class="row gutters-44">
        <div class="col-xl-9">

        
          <div class="sub-filter">
            <select class="custom-sort" id="sort_by" title="">
                <option value="date_new_old">Date Posted: New to Old</option>
                <option value="date_old_new">Date Posted: Old to New</option>
                <option value="price_high_low">Price: High To Low</option>
                <option value="price_low_high">Price: Low To High</option>
            </select>
            <ul>
              <li class="current"><a href="#" data-type="list"><i class="fa fa-list-ul" aria-hidden="true"></i>List View</a></li>
              <li><a href="#" data-type="grid"><i class="fa fa-th" aria-hidden="true"></i>Grid View</a></li>
              <li><a href="#" data-type="map"><i class="fa fa-map-marker" aria-hidden="true"></i>Map View</a></li>
            </ul>
          </div>

          <?php get_template_part('templates/listing', 'filters-applied');?>
          <?php get_template_part('templates/listing', 'item');?>
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
              <h3>Do You Need A Designer?</h3>
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
            <div class="widget widget-promo">
              <h3>PROMOTE YOUR BUSINESS<br><span class="or">on</span><br><strong>ZAIVIA FOR FREE!</strong></h3>
              <a href="#" class="btn btn-secondary">List Your Business</a>
            </div>
            <div class="widget widget-tabs">
              <ul class="nav">
                <li class="current"><a href="#fav_tab1">My Faves</a></li>
                <li><a href="#fav_tab2">Recently Viewed</a></li>
              </ul>
              <section class="tab-s-c active" id="fav_tab1">To add listings to favorites by clicking on the heart</section>
              <section class="tab-s-c" id="fav_tab2">No Listings Viewed</section>
            </div>
            <?php if(get_field('sidebar_banner_url')): ?>
            <div class="widget widget-ad">
              <a href="<?php echo get_field('sidebar_banner_url'); ?>"><img src="<?php echo get_field('sidebar_banner_image'); ?>" alt=""></a>
            </div>
            <?php endif; ?>
          </aside>
        </div>
        
      </div>
    </div>
    <div class="map-full-holder hidden">
        <div class="sub-filter">
            <ul>
                <li><a href="#" data-type="list"><i class="fa fa-list-ul" aria-hidden="true"></i>List View</a></li>
                <li><a href="#" data-type="grid"><i class="fa fa-th" aria-hidden="true"></i>Grid View</a></li>
                <li class="current"><a href="#" data-type="map"><i class="fa fa-map-marker" aria-hidden="true"></i>Map View</a></li>
            </ul>
            <div class="save">
                <a href="#"><i class="fa fa-home" aria-hidden="true"></i> Save This Search</a>
            </div>
        </div>
        <div class="map-holder" id="map2"></div>
    </div>
<?php get_footer(); ?>