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


<?php if(!is_user_logged_in()):?>
    <div class="modal-overlay" id="login">
        <div class="table">
            <div class="center">
                <div class="box">
                    <div class="close"><i class="fa fa-times" aria-hidden="true"></i></div>
                    <div class="tabs-holder">
                        <div class="tab-nav">
                            <ul>
                                <li><a href="#create"><?php _e('Create account', 'am') ?></a></li>
                                <li class="current"><a href="#log"><?php _e('Log in', 'am') ?></a></li>
                            </ul>
                        </div>
                        <div class="styled-form pb">
                            <div class="tab-c active" id="log">
                                <form action="#" id="login_form">
                                    <input type="text" placeholder="Email" name="login_email" id="login_email">
                                    <input type="password" placeholder="Password" name="login_password" id="login_password">
                                    <div class="error_placeholder"></div>
                                    <div class="extra-link">
                                        <a href="#forgot" class="open-modal"><?php _e('Forgot?', 'am') ?></a>
                                    </div>
                                    <input type="submit" value="<?php _e('Login', 'am') ?>" class="wpcf7-form-control wpcf7-submit left">
                                </form>
                            </div>

                            <div class="tab-c" id="create">
                                <h3><?php the_field('create_account_title', 'option')?> </h3>
                                <div class="head-desc">
                                    <p><?php the_field('create_account_text', 'option')?></p>
                                </div>
                                <form action="#" id="create_form">
	                                <?php wp_nonce_field('zai_create_user','create_user_nonce', true, true ); ?>
                                    <input type="text" class="half" name="create_firstname" id="create_firstname" placeholder="<?php _e('First Name*', 'am') ?>">
                                    <input type="text" class="half-r" name="create_lastname" id="create_lastname" placeholder="<?php _e('Last Name*', 'am') ?>">
                                    <input type="text" name="create_email" id="create_email" placeholder="<?php _e('Email*', 'am') ?>">
                                    <input type="text" class="half" name="create_phone" id="create_phone" placeholder="<?php _e('Phone Number*', 'am') ?>">
                                    <select class="half-r" name="create_phonetype" id="create_phonetype">
                                        <option value="cell"><?php _e('Cell', 'am') ?></option>
                                        <option value="office"><?php _e('Office', 'am') ?></option>
                                    </select>
                                    <input type="password" name="create_pass" id="create_pass" placeholder="<?php _e('Password*', 'am') ?>">
                                    <input type="password" name="create_pass_confirm" id="create_pass_confirm" placeholder="<?php _e('Confirm Password*', 'am') ?>">
                                    <div class="space"></div>
                                    <p>
                                        <span class="wpcf7-form-control-wrap checkbox-399">
                                          <span class="wpcf7-form-control wpcf7-checkbox">
                                            <span class="wpcf7-list-item first">
                                              <label><input type="checkbox" name="create_subscribe" id="create_subscribe" value="1">&nbsp;<span class="wpcf7-list-item-label"><?php the_field('create_account_subscribe', 'option')?></span></label>
                                            </span>
                                          </span>
                                        </span>
                                    </p>
                                    <div class="error_placeholder"></div>
                                    <input type="submit" value="<?php _e('Create', 'am') ?>" class="wpcf7-form-control wpcf7-submit left">
                                    <p class="note"><?php the_field('create_account_terms', 'option')?></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="confirmation_modal">
        <div class="table">
            <div class="center">
                <div class="box">
                    <div class="close"><i class="fa fa-times" aria-hidden="true"></i></div>
                    <div class="tabs-holder">
                        <h3><?php _e('Activate Account', 'am') ?></h3>
                        <div class="head-desc">
                            <p>
								<?php _e('An activation email was sent to ', 'am') ?><br>
                                <span id="confirmation_emial"></span>
                            </p>
                            <p><?php _e('Please click the link in the email to activate your account.', 'am') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="forgot">
        <div class="table">
            <div class="center">
                <div class="box">
                    <div class="close"><i class="fa fa-times" aria-hidden="true"></i></div>
                    <div class="tabs-holder">
                        <h3><?php the_field('restore_pass_title', 'option')?></h3>
                        <div class="step1">
                            <div class="head-desc">
                                <p><?php the_field('restore_pass_text', 'option')?></p>
                            </div>
                            <div class="styled-form pb">
                                <form action="#" id="restore_form">
                                    <input type="text" placeholder="Email" name="restore_email" id="restore_email">
                                    <div class="extra-link">
                                        <a href="#login" class="open-modal"><?php _e('Cancel', 'am') ?></a>
                                    </div>
                                    <div class="error_placeholder"></div>
                                    <input type="submit" value="<?php _e('Reset', 'am') ?>" class="wpcf7-form-control wpcf7-submit left">
                                </form>
                            </div>
                        </div>
                        <div class="step2">
                            <p><?php the_field('restore_confirmation', 'option')?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif;?>

<?php wp_footer(); ?>

</div><!-- /wrapper -->
</body>
</html>