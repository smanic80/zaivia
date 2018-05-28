<?php
/*
Template Name: Community Partners
Template Post Type: page
*/

get_header(); ?>

    <?php if(isset($_GET['industry'])) $industry = ZaiviaBusiness::getIndustry($_GET['industry']); ?>

    <?php if(isset($industry) && $industry) :?>
        <div class="category-head">
            <div class="container sm">
                <div class="left">
                    <h1><?php $title = get_field('custom_title'); if(!empty($title)) : echo $title; else : the_title(); endif; ?></h1>
                    <p><?php the_field("industry_text")?></p>
                </div>
                <h2><?php echo $industry['plural_name']?></h2>
            </div>
        </div>

        <div class="featured-agents">
            <div class="container sm">
                <h3><?php echo _e("Featured Agents")?></h3>
                <section>
                    <div class="row" id="featured-placeholder"></div>
                </section>
            </div>

            <div class="partners-category-list">
                <div class="container sm">
                    <div class="filter-bar">
                        <select class="custom-blue" id="agents-sort">
                            <option value="card_first_name__asc"><?php echo _e("Sort By Name A-Z")?></option>
                            <option value="card_first_name__desc"><?php echo _e("Sort By Name Z-A")?></option>
                            <option value="card_company__asc"><?php echo _e("Sort By Company Name A-Z")?></option>
                            <option value="card_company__desc"><?php echo _e("Sort By Company Name Z-A")?></option>
                        </select>
                    </div>
                    <section>
                        <div class="row" id="common-placeholder"></div>
                    </section>
                </div>
                <div class="pagination-holder">
                    <div class="container">
                        <div class="pagination pagination-full" id="common-agets-pagination"></div>
                    </div>
                </div>
            </div>
        </div>

    <?php else :?>
        <div class="page-head">
            <div class="container">
                <h1><?php $title = get_field('custom_title'); if(!empty($title)) : echo $title; else : the_title(); endif; ?></h1>
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php the_content(__('Read more', 'am')); ?>
                <?php endwhile; endif; ?>
            </div>
        </div>

        <div class="partners-list">
            <div class="container sm">
                <section>
                    <div class="row" id="industries-placeholder"></div>
                </section>
            </div>
        </div>

        <script type="text/html" id="tmpl-industries-item">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <article class="full-height">
                    <a href="<?php the_field("page_industry", "option")?>?industry={{data.key }}">
                        <div class="ico">
                            <img src="{{data.logo}}" alt="">
                        </div>
                        <h2>{{data.label_plural}}</h2>
                        <div class="count">({{ data.cards.length }})</div>
                    </a>
                </article>
            </div>
        </script>
<?php endif; ?>
<?php get_footer(); ?>