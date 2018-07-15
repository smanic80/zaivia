<?php
/*
Template Name: My Business
Template Post Type: page
*/

get_header();?>
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
                        <li class="tab-control current"><a href="#edit_<?php echo ZaiviaBusiness::$posttype_banner?>" ><?php _e('Banner Ads', 'am') ?></a></li>
                        <li class="tab-control"><a href="#edit_<?php echo ZaiviaBusiness::$posttype_card?>" ><?php _e('Community Partners', 'am') ?></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="my-ad">
                    <div class="styled-form tabbed-content current" id="edit_<?php echo ZaiviaBusiness::$posttype_banner?>">
                        <div class="entry text-center mb-30">
                            <h2><?php the_field("banner_button_title")?></h2>
                            <p><?php the_field("banner_button_subtitle")?></p>
                            <a href="<?php the_field("page_postbanner", "option")?>" class="btn btn-primary"><?php the_field("banner_button_text")?></a>
                            <span class="delete-confirmation"><?php _e('Advertisment deleted', 'am') ?></span>
                            <span class="disable-confirmation"><?php _e('Advertisment disabled', 'am') ?></span>
                        </div>
                        <div class="acc-item bb">
                            <h3><?php the_field("banner_table_title");?></h3>
                            <?php $items = ZaiviaBusiness::getEntities(ZaiviaBusiness::$posttype_banner, null, get_current_user_id());?>

                            <?php if($items) :?>
                            <div class="table mb-15 responsive">
                                <table id="banner-list" class="items-list">
                                    <tbody>
                                    <tr>
                                        <th><?php _e('Ad Name', 'am') ?></th>
                                        <th><?php _e('Date Listed', 'am') ?></th>
                                        <th><?php _e('Renewal Date', 'am') ?></th>
                                        <th class="text-right"><?php _e('Action', 'am') ?></th>
                                    </tr>
                                    <?php foreach($items as $item):?>
                                    <tr class="row-<?php echo $item['id']?>">
                                        <td><?php echo $item['title']?></td>
                                        <td><?php echo ZaiviaBusiness::formatDate($item['date_created']); ?></td>
                                        <td><?php echo $item['date_renewal'] ? ZaiviaBusiness::formatDate($item['date_renewal']) : __('Not published', 'am'); ?></td>
                                        <td class="text-right">
                                            <a href="<?php the_field("page_postbanner", "option")?>?edit=<?php echo $item['id']?>" class="btn btn-secondary btn-sm"><?php _e('Edit', 'am') ?></a>
                                            <a href="#delete" class="btn btn-secondary btn-sm delete-business" data-id="<?php echo $item['id']?>"><?php _e('Delete', 'am') ?></a>
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
                    <div class="styled-form tabbed-content" id="edit_<?php echo ZaiviaBusiness::$posttype_card?>">
                        <div class="entry text-center mb-30">
                            <h2><?php the_field("card_button_title"); ?></h2>
                            <p><?php the_field("card_button_subtitle")?></p>
                            <a href="<?php the_field("page_postcard", "option")?>" class="btn btn-primary"><?php the_field("card_button_text")?></a>
                            <span class="delete-confirmation"><?php _e('Contact Card deleted', 'am') ?></span>
                            <span class="disable-confirmation"><?php _e('Contact Card disabled', 'am') ?></span>
                        </div>
                        <div class="acc-item bb">
                            <h3><?php the_field("card_table_title");?></h3>
                            <?php $items = ZaiviaBusiness::getEntities(ZaiviaBusiness::$posttype_card, null, get_current_user_id());?>
                            <?php if($items) :?>
                                <div class="table mb-15 responsive">
                                    <table id="cards-list" class="items-list">
                                        <tbody>
                                        <tr>
                                            <th><?php _e('Name', 'am') ?></th>
                                            <th><?php _e('Date Listed', 'am') ?></th>
                                            <th><?php _e('Renewal Date', 'am') ?></th>
                                            <th class="text-right"><?php _e('Action', 'am') ?></th>
                                        </tr>
                                        <?php foreach($items as $item):?>
                                            <tr class="row-<?php echo $item['id']?>">
                                                <td><?php echo $item['title']?></td>
                                                <td><?php echo ZaiviaBusiness::formatDate($item['date_created']); ?></td>
                                                <td><?php echo $item['date_renewal'] ? ZaiviaBusiness::formatDate($item['date_renewal']) :  __('Not published', 'am'); ?></td>
                                                <td class="text-right">
                                                    <a href="<?php the_field("page_postcard", "option")?>?edit=<?php echo $item['id']?>" class="btn btn-secondary btn-sm"><?php _e('Edit', 'am') ?></a>
                                                    <a href="#delete" class="btn btn-secondary btn-sm delete-business" data-id="<?php echo $item['id']?>" ><?php _e('Delete', 'am') ?></a>
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