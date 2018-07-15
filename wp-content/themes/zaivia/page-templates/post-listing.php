<?php
/*
Template Name: Post Listing
Template Post Type: page
*/
    $listing = $listingId = null;
    $userId = get_current_user_id();
    if(isset($_GET['edit-listing'])) {
        $listingId = (int)$_GET['edit-listing'];
        $userId = is_administrator() ? false : $userId;
        $listing = ZaiviaListings::getListings($listingId, $userId);
	    if(!$listing) {
		    wp_redirect(get_field("page_mylistings", "option"));
		    die;
	    }
    }

get_header(); ?>
<?php if(!get_current_user_id()): ?>
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
        <?php if ( has_nav_menu( 'mainmenu' ) ) : ?><?php wp_nav_menu( array( 'theme_location' => 'accountmenu', 'menu_class' => '', 'menu_id'=>'', 'container'=>'', 'depth'=>0) ); ?><?php endif; ?>
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


    <form action="#" id="post-listing-form">
        <input type="hidden" name="listing_id" id="listing_id" value="<?php echo $listingId?>">
        <div class="container xs">
            <div class="my-ad">

	            <?php include(locate_template('templates/edit-listing/listing-steps.php')); ?>

                <div class="btns-start">
		            <?php if($listing) :?>
			            <?php if(is_administrator()) :?>
                            <a href="<?php the_field("page_mylistings", "option")?>?delete=<?php echo $listing['listing_id']?>" class="btn btn-primary btn-sm"><?php _e('Delete', 'am') ?></a>
                            <a href="#" class="btn btn-primary btn-sm enable" <?php if($listing['activated']): ?>style="display:none;"<?php endif;?>><?php _e('Publish', 'am') ?></a>
                            <a href="#" class="btn btn-primary btn-sm disable" <?php if(!$listing['activated']): ?>style="display:none;"<?php endif;?>><?php _e('Unpublish', 'am') ?></a>
			            <?php endif; ?>

                        <a href="#" class="btn btn-secondary btn-sm save-draft"><?php _e('Save', 'am') ?></a>
                        <a href="<?php echo esc_url( home_url( '/listing/?id=' . $listingId ) ); ?>" target="_blank" class="btn btn-secondary btn-sm"><?php _e('Preview', 'am') ?></a>

		            <?php else:?>
                        <a href="#" class="btn btn-secondary btn-sm save-draft"><?php _e('Save Draft', 'am') ?></a>
		            <?php endif; ?>
                </div>
                <div id="common-error" class="error" style="display:none;"></div>
                <div class="styled-form listing-steps" id="step1">
	                <?php include(locate_template('templates/edit-listing/listing-step1.php')); ?>
                </div>
                <div class="styled-form listing-steps" id="step2" style="display:none;">
	                <?php include(locate_template('templates/edit-listing/listing-step2.php')); ?>
                </div>
                <div class="styled-form listing-steps" id="step3" style="display:none;">
	                <?php include(locate_template('templates/edit-listing/listing-step3.php')); ?>
                </div>
                <div class="styled-form listing-steps" id="step4" style="display:none;">
		            <?php include(locate_template('templates/edit-listing/listing-step4.php')); ?>
                </div>
                <div class="styled-form listing-steps" id="step5" style="display:none;">
		            <?php include(locate_template('templates/edit-listing/listing-step5.php')); ?>
                </div>
                <div class="styled-form listing-steps" id="step6" style="display:none;">
		            <?php include(locate_template('templates/edit-listing/listing-step6.php')); ?>
                </div>
                <div class="styled-form listing-steps" id="step7" style="display:none;">
		            <?php include(locate_template('templates/edit-listing/listing-step7.php')); ?>
                </div>
            </div>
        </div>
    </form>

<?php endif;?>

<?php get_footer(); ?>