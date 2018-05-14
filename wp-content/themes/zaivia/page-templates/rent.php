<?php
/*
Template Name: Rent
Template Post Type: page
*/

get_header(); ?>
    <input type="hidden" id="page_id" value="<?php the_ID(); ?>">
    <?php set_query_var('page_type', 'rent' ); ?>

<?php if(!isset($_GET['city'])) :?>
    <div class="hero no-bg">
        <div class="container">
            <div class="box">
                <h1><?php the_field("search_title", "option")?></h1>
                <form action="#">
                    <label><?php the_field("search_text", "option")?></label>
                    <div class="set">
                        <input type="text" placeholder="<?php _e('Enter a city', 'am') ?>" id="search_city">
                        <button type="submit" class="btn btn-secondary btn-lg search_city_button" rel="<?php the_field("page_rent", "option")?>"><?php _e('Rent', 'am') ?></button>
                    </div>
                    <p id="search_city_error" class="error" style="display: none;"><?php _e('Enter a city to search', 'am') ?></p>
                </form>
            </div>
        </div>
    </div>
<?php else: ?>
    <?php get_template_part('templates/listing', 'filter'); ?>
    <div class="found-line">
        <div class="container pp">
            <p><span class="result_num"></span> <?php _e('Listings Found For Rent In','am'); ?><span class="result_city_in"><?php _e(' In','am'); ?></span> <span class="result_city"></span></p>
        </div>
    </div>
    <?php get_template_part('templates/listing', 'buy_rent'); ?>
<?php endif; ?>
<?php get_footer(); ?>