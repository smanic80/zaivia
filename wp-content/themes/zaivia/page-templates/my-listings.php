<?php
/*
Template Name: My Listings
Template Post Type: page
*/

get_header(); ?>
<?php if(!get_current_user_id()):?>
    <div class="container sm mb-35">
        <div class="row gutters-40">
            <div class="col-md-85">
                <div class="single-post">
                    <div class="title">
                        <h1>Please, Login first</h1>
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
                <h2><?php echo get_field("button_title")?></h2>
                <a href="<?php the_field("page_postlisting", "option")?>" class="btn btn-primary"><?php echo get_field("button_text")?></a>
            </div>
            <div class="acc-item bb">
                <h3><?php echo get_field("table_title")?></h3>
                <?php $listings = ZaiviaListings::getUserListings(get_current_user_id());?>

                <?php if($listings) :?>
                <div class="table mb-15 responsive full">
                    <table>
                        <tbody>
                        <tr>
                            <th><?php _e('Address', 'am') ?></th>
                            <th><?php _e('Type', 'am') ?></th>
                            <th><?php _e('Date Listing', 'am') ?></th>
                            <th><?php _e('Renewal Date', 'am') ?></th>
                            <th><?php _e('Status', 'am') ?></th>
                            <th><?php _e('Activated', 'am') ?></th>
                            <th><?php _e('Action', 'am') ?></th>
                        </tr>
                        <?php foreach($listings as $listing):?>
                        <tr>
                            <td><?php echo $listing['address-text']?></td>
                            <td><?php echo $listing['sale_rent-text']; ?></td>
                            <td><?php echo date('m/d/Y', $listing['date_created']); ?></td>
                            <td><?php echo $listing['date_published']?date('m/d/Y', $listing['date_published']):''; ?></td>
                            <td><?php echo $listing['status']; ?></td>
                            <td><?php echo $listing['active-text']; ?></td>
                            <td><a href="<?php the_field("page_postlisting", "option")?>?edit-listing=<?php echo $listing['listing_id']?>" class="btn btn-secondary btn-sm"><?php _e('Edit', 'am') ?></a>
                                <a href="#delete" class="btn btn-secondary btn-sm open-modal"><?php _e('Delete', 'am') ?></a>
                                <a href="#" class="btn btn-secondary btn-sm"><?php _e('Promotes', 'am') ?></a>
                                <a href="#" class="btn btn-secondary btn-sm"><?php _e('Renew', 'am') ?></a>
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

<?php endif;?>

<?php get_footer(); ?>