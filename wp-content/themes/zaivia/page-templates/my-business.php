<?php
/*
Template Name: My Business
Template Post Type: page
*/

if(get_current_user_id() && isset($_REQUEST['delete-card']) && $_REQUEST['delete-card']){
	ZaiviaListings::deleteCard((int)$_REQUEST['delete-card']);
	wp_redirect($_SERVER['HTTP_REFERER']);
	die;
}
if(get_current_user_id() && isset($_REQUEST['delete-card']) && $_REQUEST['delete-banner']){
	ZaiviaListings::deleteBanner((int)$_REQUEST['delete-banner']);
	wp_redirect($_SERVER['HTTP_REFERER']);
	die;
}

get_header(); ?>
<?php if(!get_current_user_id()):?>
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
        <div class="row">
            <div class="col-md-3">
                <div class="my-ad widget widget_archive">
                    <ul>
                        <li class="tab-control current"><a href="#edit_banners" ><?php _e('Banner Ads', 'am') ?></a></li>
                        <li class="tab-control"><a href="#edit_cards" ><?php _e('Community Partners', 'am') ?></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="my-ad">
                    <div class="styled-form tabbed-content current" id="edit_banners">
                        <div class="entry text-center mb-30">
                            <h2><?php the_field("banner_button_title")?></h2>
                            <p><?php the_field("banner_button_subtitle")?></p>
                            <a href="<?php the_field("page_postbanner", "option")?>" class="btn btn-primary"><?php the_field("banner_button_text")?></a>
                        </div>
                        <div class="acc-item bb">
                            <h3><?php the_field("banner_table_title")?></h3>
                            <?php $banners = ZaiviaBusiness::getUserEntities(get_current_user_id(), ZaiviaBusiness::$posttype_banner);?>

                            <?php if($banners) :?>
                            <div class="table mb-15 responsive full">
                                <table>
                                    <tbody>
                                    <tr>
                                        <th><?php _e('Ad Name', 'am') ?></th>
                                        <th><?php _e('Date Listed', 'am') ?></th>
                                        <th><?php _e('Renewal Date', 'am') ?></th>
                                        <th class="text-right"><?php _e('Action', 'am') ?></th>
                                    </tr>
                                    <?php foreach($banners as $banner):?>
                                    <tr>
                                        <td><?php echo $banner['title']?></td>
                                        <td><?php echo ZaiviaBusiness::formatDate($listing['date_created']); ?></td>
                                        <td><?php echo $listing['date_published'] ? ZaiviaBusiness::formatDate($listing['date_renewal']) : ''; ?></td>
                                        <td class="text-right">
                                            <a href="<?php the_field("page_postlisting", "option")?>?edit-listing=<?php echo $listing['listing_id']?>" class="btn btn-secondary btn-sm"><?php _e('Edit', 'am') ?></a>
                                            <a href="#delete" class="btn btn-secondary btn-sm open-modal" data-id="<?php echo $banner['listing_id']?>"><?php _e('Delete', 'am') ?></a>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                                <p><?php _e('No banners added yet', 'am') ?></p>
                            <?php endif?>
                        </div>
                    </div>
                    <div class="styled-form tabbed-content" id="edit_cards">
                        <div class="entry text-center mb-30">
                            <h2><?php the_field("card_button_title")?></h2>
                            <p><?php the_field("card_button_subtitle")?></p>
                            <a href="<?php the_field("page_postcard", "option")?>" class="btn btn-primary"><?php the_field("card_button_text")?></a>
                        </div>
                        <div class="acc-item bb">
                            <h3><?php the_field("card_table_title")?></h3>
                            <?php $banners = ZaiviaBusiness::getUserEntities(get_current_user_id(), ZaiviaBusiness::$posttype_card);?>

                            <?php if($banners) :?>
                                <div class="table mb-15 responsive full">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <th><?php _e('Name', 'am') ?></th>
                                            <th><?php _e('Date Listed', 'am') ?></th>
                                            <th><?php _e('Renewal Date', 'am') ?></th>
                                            <th><?php _e('Status', 'am') ?></th>
                                            <th style="min-width: 335px;"><?php _e('Action', 'am') ?></th>
                                        </tr>
                                        <?php foreach($banners as $banner):?>
                                            <tr>
                                                <td><?php echo $banner['title']?></td>
                                                <td><?php echo ZaiviaBusiness::formatDate($listing['date_created']); ?></td>
                                                <td><?php echo $listing['date_published'] ? ZaiviaBusiness::formatDate($listing['date_renewal']) : ''; ?></td>
                                                <td><?php echo $banner['status']?></td>
                                                <td>
                                                    <a href="<?php the_field("page_postlisting", "option")?>?edit-listing=<?php echo $listing['listing_id']?>" class="btn btn-secondary btn-sm"><?php _e('Edit', 'am') ?></a>
                                                    <a href="#delete" class="btn btn-secondary btn-sm open-modal" data-id="<?php echo $listing['listing_id']?>"><?php _e('Delete', 'am') ?></a>
                                                    <a href="<?php the_field("page_postlisting", "option")?>?edit-listing=<?php echo $listing['listing_id']?>#step5" class="btn btn-secondary btn-sm"><?php _e('Promotes', 'am') ?></a>
                                                    <a href="<?php the_field("page_postlisting", "option")?>?edit-listing=<?php echo $listing['listing_id']?>#step6" class="btn btn-secondary btn-sm"><?php _e('Renew', 'am') ?></a>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p><?php _e('No contact cards added yet', 'am') ?></p>
                            <?php endif?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif;?>

<?php get_footer(); ?>