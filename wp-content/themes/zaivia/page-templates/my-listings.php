<?php
/*
Template Name: My Listings
Template Post Type: page
*/

$userId = get_current_user_id();
if($userId && isset($_REQUEST['delete']) && $_REQUEST['delete']){
	$request = $_REQUEST;
    if(!is_administrator() || isset($_REQUEST['listing_id'])) {
	    $listing_id = (int)$_REQUEST['listing_id'];
	    unset($request['listing_id']);
	    unset($request['delete']);
    } else {
	    $listing_id = (int)$_REQUEST['delete'];
    }


	if(ZaiviaListings::isOwner($userId, $listing_id)) {
		ZaiviaListings::deleteListing($listing_id, $request);
    }
	wp_redirect($_SERVER['HTTP_REFERER']);
	die;
}

get_header(); ?>
<?php if(!$userId):?>
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
    <div class="my-ad">
        <div class="styled-form">
            <div class="entry text-center mb-30">
                <h2><?php the_field("button_title")?></h2>
                <a href="<?php the_field("page_postlisting", "option")?>" class="btn btn-primary"><?php the_field("button_text")?></a>
            </div>
            <div class="acc-item bb">
                <h3><?php the_field("table_title")?></h3>
                <?php $listings = ZaiviaListings::getListings(null, $userId);?>

                <?php if($listings) :?>
                <div class="table mb-15 responsive full">
                    <table>
                        <tbody>
                        <tr>
                            <th><?php _e('Address', 'am') ?></th>
                            <th><?php _e('Type', 'am') ?></th>
                            <th><?php _e('Date Listed', 'am') ?></th>
                            <th><?php _e('Renewal Date', 'am') ?></th>
                            <th><?php _e('Status', 'am') ?></th>
                            <th><?php _e('Activated', 'am') ?></th>
                            <th style="min-width: 335px;"><?php _e('Action', 'am') ?></th>
                        </tr>
                        <?php foreach($listings as $listing):?>
                        <tr>
                            <td><?php echo $listing['address-text']?></td>
                            <td><?php echo $listing['sale_rent-text']; ?></td>
                            <td><?php echo ZaiviaListings::formatDate($listing['date_created']); ?></td>
                            <td><?php echo $listing['renewal_date'] ? ZaiviaListings::formatDate($listing['renewal_date']) : ''; ?></td>

                            <td><?php echo $listing['status']; ?></td>
                            <td><?php echo $listing['active-text']; ?></td>

                            <td><a href="<?php the_field("page_postlisting", "option")?>?edit-listing=<?php echo $listing['listing_id']?>" class="btn btn-secondary btn-sm"><?php _e('Edit', 'am') ?></a>
                                <a href="#delete<?php echo $listing['sale_rent'] == ZaiviaListings::$for_rent ? '2' : '' ?>" class="btn btn-secondary btn-sm open-modal" data-id="<?php echo $listing['listing_id']?>"><?php _e('Delete', 'am') ?></a>
                                <a href="<?php the_field("page_postlisting", "option")?>?edit-listing=<?php echo $listing['listing_id']?>#step5" class="btn btn-secondary btn-sm"><?php _e('Promotes', 'am') ?></a>
                                <a href="<?php the_field("page_postlisting", "option")?>?edit-listing=<?php echo $listing['listing_id']?>#step5" class="btn btn-secondary btn-sm"><?php _e('Renew', 'am') ?></a>
                            </td>
                        </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                    <p><?php _e('No listings added yet', 'am') ?></p>
                <?php endif?>
            </div>
        </div>
    </div>
</div>
<div class="modal-overlay" id="delete">
    <div class="table">
        <div class="center">
            <div class="box">
                <div class="close"><i class="fa fa-times" aria-hidden="true"></i></div>
                <div class="tabs-holder">
                    <h3><?php _e('Delete Listing','am') ?></h3>
                    <div class="styled-form pb">
                        <form action="" method="post">
                            <input type="hidden" name="listing_id">
                            <fieldset>
                                <label class="mb-15"><strong><?php _e('Can you please tell us why you are deleting your listing?','am') ?></strong></label>
                                <p>
                                    <span class="wpcf7-form-control-wrap checkbox-399">
                                        <span class="wpcf7-form-control wpcf7-checkbox">
                                            <span class="wpcf7-list-item first">
                                                <label><input type="radio" name="is_sold" value="0">&nbsp;<span class="wpcf7-list-item-label"><?php _e('I did not find a buyer','am') ?></span></label>
                                            </span>
                                        </span>
                                    </span>
                                </p>
                                <p>
                                    <span class="wpcf7-form-control-wrap checkbox-399">
                                        <span class="wpcf7-form-control wpcf7-checkbox">
                                            <span class="wpcf7-list-item first">
                                                <label><input type="radio" name="is_sold" value="1">&nbsp;<span class="wpcf7-list-item-label"><?php _e('I sold my home','am') ?></span></label>
                                            </span>
                                        </span>
                                    </span>
                                </p>
                            </fieldset>
                            <fieldset class="mb-15">
                                <label class="mb-15"><?php _e('As a service to the community Zaivia likes to support buyers and sellers with home sale price data. Would you be willing to share your sale price with other','am') ?></label>
                                <p>
                                    <span class="wpcf7-form-control-wrap checkbox-399">
                                        <span class="wpcf7-form-control wpcf7-checkbox">
                                            <span class="wpcf7-list-item first">
                                                <label><input type="radio" name="is_share_price" value="1">&nbsp;<span class="wpcf7-list-item-label"><?php _e('Yes','am') ?></span></label>
                                            </span>
                                        </span>
                                    </span>
                                </p>
                                <p>
                                    <span class="wpcf7-form-control-wrap checkbox-399">
                                        <span class="wpcf7-form-control wpcf7-checkbox">
                                            <span class="wpcf7-list-item first">
                                                <label><input type="radio" name="is_share_price" value="0">&nbsp;<span class="wpcf7-list-item-label"><?php _e('No','am') ?></span></label>
                                            </span>
                                        </span>
                                    </span>
                                </p>
                                <label for="price"><?php _e('Sale Price','am') ?></label>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <input type="text" id="price" name="price">
                                    </div>
                                </div>
                            </fieldset>
                            <hr class="mb-30">
                            <fieldset>
                                <label class="mb-15"><?php _e('Were you satisfied with Zaivia?','am') ?></label>
                                <p>
                                    <span class="wpcf7-form-control-wrap checkbox-399">
                                        <span class="wpcf7-form-control wpcf7-checkbox">
                                            <span class="wpcf7-list-item first">
                                                <label><input type="radio" name="is_satisfied" value="1">&nbsp;<span class="wpcf7-list-item-label"><?php _e('Yes','am') ?></span></label>
                                            </span>
                                        </span>
                                    </span>
                                </p>
                                <p>
                                    <span class="wpcf7-form-control-wrap checkbox-399">
                                        <span class="wpcf7-form-control wpcf7-checkbox">
                                            <span class="wpcf7-list-item first">
                                                <label><input type="radio" name="is_satisfied" value="0">&nbsp;<span class="wpcf7-list-item-label"><?php _e('No','am') ?></span></label>
                                            </span>
                                        </span>
                                    </span>
                                </p>
                            </fieldset>
                            <fieldset>
                                <label for="comments"><?php _e('Comments','am') ?></label>
                                <textarea id="comments" name="comments"></textarea>
                            </fieldset>
                            <div class="extra-link">
                                <a href="#" class="close-modal"><?php _e('Cancel','am') ?></a>
                            </div>
                            <input type="submit" value="Delete Listing" name="delete" class="wpcf7-form-control wpcf7-submit left">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-overlay" id="delete2">
    <div class="table">
        <div class="center">
            <div class="box">
                <div class="close"><i class="fa fa-times" aria-hidden="true"></i></div>
                <div class="tabs-holder">
                    <h3><?php _e('Delete Listing','am') ?></h3>
                    <div class="styled-form pb">
                        <form action="" method="post">
                            <input type="hidden" name="listing_id">
                            <fieldset>
                                <label class="mb-15"><strong><?php _e('Can you please tell us why you are deleting your listing?','am') ?></strong></label>
                                <p>
                                    <span class="wpcf7-form-control-wrap checkbox-399">
                                        <span class="wpcf7-form-control wpcf7-checkbox">
                                            <span class="wpcf7-list-item first">
                                                <label><input type="radio" name="is_sold" value="0">&nbsp;<span class="wpcf7-list-item-label"><?php _e('I did not find a renter','am') ?></span></label>
                                            </span>
                                        </span>
                                    </span>
                                </p>
                                <p>
                                    <span class="wpcf7-form-control-wrap checkbox-399">
                                        <span class="wpcf7-form-control wpcf7-checkbox">
                                            <span class="wpcf7-list-item first">
                                                <label><input type="radio" name="is_sold" value="1">&nbsp;<span class="wpcf7-list-item-label"><?php _e('I found a renter','am') ?></span></label>
                                            </span>
                                        </span>
                                    </span>
                                </p>
                            </fieldset>
                            <hr class="mb-30">
                            <fieldset>
                                <label class="mb-15"><?php _e('Were you satisfied with Zaivia?','am') ?></label>
                                <p>
                                    <span class="wpcf7-form-control-wrap checkbox-399">
                                        <span class="wpcf7-form-control wpcf7-checkbox">
                                            <span class="wpcf7-list-item first">
                                                <label><input type="radio" name="satisfied" value="1">&nbsp;<span class="wpcf7-list-item-label"><?php _e('Yes','am') ?></span></label>
                                            </span>
                                        </span>
                                    </span>
                                </p>
                                <p>
                                    <span class="wpcf7-form-control-wrap checkbox-399">
                                        <span class="wpcf7-form-control wpcf7-checkbox">
                                            <span class="wpcf7-list-item first">
                                                <label><input type="radio" name="satisfied" value="0">&nbsp;<span class="wpcf7-list-item-label"><?php _e('No','am') ?></span></label>
                                            </span>
                                        </span>
                                    </span>
                                </p>
                            </fieldset>
                            <fieldset>
                                <label for="comments2"><?php _e('Comments','am') ?></label>
                                <textarea id="comments2" name="comments"></textarea>
                            </fieldset>
                            <div class="extra-link">
                                <a href="#" class="close-modal"><?php _e('Cancel','am') ?></a>
                            </div>
                            <input type="submit" value="Delete Listing" name="delete" class="wpcf7-form-control wpcf7-submit left">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif;?>

<?php get_footer(); ?>