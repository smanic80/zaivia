<?php
/*
Template Name: Post Listing
Template Post Type: page
*/

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

    <?php
        $listing = $listingId = null;
        if(isset($_GET['edit-listing'])) {
            $listingId = (int)$_GET['edit-listing'];
	        $listing = ZaiviaListings::getUserListings(get_current_user_id(), $listingId);
        }
    ?>

    <div class="sub-nav">
        <div class="container xs">
	        <?php if ( has_nav_menu( 'mainmenu' ) ) : ?>
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

    <form action="#" id="post-listing-form">
        <input type="hidden" name="listing_id" id="listing_id" value="<?php echo $listingId?>">
        <div class="container xs">
            <div class="my-ad">

	            <?php include(locate_template('templates/edit-listing/listing-steps.php')); ?>

                <div class="btns-start">
		            <?php if($listing) :?>
                        <a href="#" class="btn btn-secondary btn-sm save-draft"><?php _e('Save', 'am') ?></a>
                        <a href="#" class="btn btn-secondary btn-sm"><?php _e('Preview', 'am') ?></a>
		            <?php else:?>
                        <a href="#" class="btn btn-secondary btn-sm save-draft"><?php _e('Save Draft', 'am') ?></a>
		            <?php endif; ?>
                </div>

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
            </div>
        </div>
    </form>

<?php endif;?>

<?php get_footer(); ?>