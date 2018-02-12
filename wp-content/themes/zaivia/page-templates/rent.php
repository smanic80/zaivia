<?php
/*
Template Name: Rent
Template Post Type: page
*/

get_header(); ?>
    <input type="hidden" id="page_id" value="<?php the_ID(); ?>">
    <?php set_query_var('page_type', 'rent' ); ?>
    <?php get_template_part('templates/listing', 'filter'); ?>
    <div class="found-line">
        <div class="container pp">
            <p><span class="result_num"></span> <?php _e('Listings Found For Rent In','am'); ?> <span class="result_city"></span></p>
        </div>
    </div>
    <?php get_template_part('templates/listing', 'buy_rent'); ?>
<?php get_footer(); ?>