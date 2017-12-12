		</div>

        <footer class="footer">
            <div class="container">
                <div class="cols">
                    <div class="copy">
                        <div class="ce">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_template_directory_uri();?>/images/logo_f.png" alt=""></a>
                            <p>© <?php echo date('Y'); ?> Zaivia.com</p>
                        </div>
                    </div>
                    <div class="menus">
	                    <?php if ( has_nav_menu( 'footermenu1' ) ) : ?>
                            <?php wp_nav_menu( array( 'theme_location' => 'footermenu1', 'menu_class' => '', 'menu_id'=>'', 'container'=>'', 'depth'=>0) ); ?>
	                    <?php endif; ?>
	                    <?php if ( has_nav_menu( 'footermenu2' ) ) : ?>
		                    <?php wp_nav_menu( array( 'theme_location' => 'footermenu2', 'menu_class' => '', 'menu_id'=>'', 'container'=>'', 'depth'=>0) ); ?>
	                    <?php endif; ?>
                    </div>
                    <div class="follow">
                        <h5><?php _e('Follow Us', 'am') ?></h5>
                        <ul>
                            <li><a href="<?php the_field('facebook', 'option')?>" target="_blank"><i class="fa fa-facebook " aria-hidden="true"></i><?php _e('Facebook', 'am') ?></a></li>
                            <li><a href="<?php the_field('twitter', 'option')?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i><?php _e('Twitter', 'am') ?></a></li>
                        </ul>
                    </div>
                    <div class="post-free">
                        <h5><?php _e('Post On Zaivia FREE', 'am') ?></h5>
                        <p><?php the_field('footer_text', 'option')?></p>
                        <a href="#" class="btn btn-secondary"><?php _e('List Your Property', 'am') ?></a>
                        <a href="#" class="btn btn-secondary"><?php _e('List Your Business', 'am') ?></a>
                    </div>
                </div>
            </div>
            <div class="by">
	            <?php _e('Website By', 'am') ?> <a href="#"><img src="<?php echo get_template_directory_uri();?>/images/yas.png" alt=""></a>
            </div>
        </footer>

		<?php wp_footer(); ?>

	</div><!-- /wrapper -->
</body>
</html>