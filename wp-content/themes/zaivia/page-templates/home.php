<?php
/*
Template Name: Home
Template Post Type: page
*/

get_header(); ?>

    <div class="hero">
        <div class="container">
            <div class="box">
                <h1><?php the_field("search_title", "option")?></h1>
                <form action="#">
                    <label><?php the_field("search_text", "option")?></label>
                    <div class="set">
                        <input type="text" placeholder="Enter a city" id="search_city">
                        <button type="submit" class="btn btn-secondary btn-lg search_city_button" rel="<?php the_field("page_buy", "option")?>"><?php _e('Buy', 'am') ?></button>
                        <button type="submit" class="btn btn-secondary btn-lg search_city_button" rel="<?php the_field("page_rent", "option")?>"><?php _e('Rent', 'am') ?></button>
                    </div>
                    <p id="search_city_error" class="error" style="display: none;"><?php _e('Enter a city to search', 'am') ?></p>
                </form>
            </div>
        </div>
    </div>

    <div class="intro-h">
        <div class="container">
            <h2><?php the_field("intro_title")?></h2>
            <p><?php the_field("intro_text")?></p>
            <ul class="steps">
                <li><?php _e('BUY', 'am') ?></li>
                <li><?php _e('SELL', 'am') ?></li>
                <li><?php _e('RENT', 'am') ?></li>
                <li class="free"><?php _e('FOR<br>FREE', 'am') ?></li>
            </ul>
        </div>
    </div>

    <?php if($options = get_field("options")):?>
    <div class="features-h">
        <div class="image"></div>
        <div class="container">
            <section>
                <?php foreach($options as $option):?>
                <article>
                    <div class="ico">
                        <img src="<?php echo $option['image']?>" alt="">
                    </div>
                    <div class="text">
                        <h3><?php echo $option['title']?></h3>
                        <p><?php echo $option['text']?></p>
                    </div>
                    <div class="btn-h">
                        <a href="<?php echo $option['button_url']?>" class="btn btn-outline"><?php _e('Learn More', 'am') ?></a>
                    </div>
                </article>
                <?php endforeach; ?>
            </section>
        </div>
    </div>
    <?php endif; ?>

    <?php if($options = get_field("banner_options")):?>
    <div class="win-box">
        <div class="container">
            <div class="box">
                <h2><?php the_field("banner_title")?></h2>
                <div class="pic">
                    <img src="<?php echo get_template_directory_uri();?>/images/h3.png" alt="">
                </div>
                <h4><?php the_field("banner_subtitle")?></h4>
                <ul>
	                <?php foreach($options as $option):?>
                    <li><?php echo $option['text']?></li>
	                <?php endforeach; ?>
                </ul>
                <p><?php the_field("banner_text")?></p>
                <div class="btns">
                    <a href="#" class="btn btn-facebook"><?php _e('Share On Facebook', 'am') ?></a>
                    <a href="<?php the_field("page_postlisting", "option")?>" class="btn btn-secondary"><?php _e('List Your Property', 'am') ?></a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

<?php get_footer(); ?>