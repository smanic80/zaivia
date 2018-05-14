<?php
/*
Template Name: My Profile
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

	<?php $userData = wp_get_current_user(); ?>

	<div class="sub-nav">
		<div class="container xs">
			<?php if ( has_nav_menu( 'mainmenu' ) ) : ?>
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
							<li class="tab-control current"><a href="#edit_account" ><?php _e('Profile Information', 'am') ?></a></li>
							<li class="tab-control"><a href="#edit_payment" ><?php _e('Payment Information', 'am') ?></a></li>
							<li class="tab-control"><a href="#edit_password" ><?php _e('Change Password', 'am') ?></a></li>
						</ul>
					</div>
				</div>
				<div class="col-md-9">
					<div class="my-ad">

						<div class="styled-form tabbed-content current" id="edit_account">

							<form action="#" id="edit_account_form">
								<span class="saved-confirmation"><?php _e('Account data saved', 'am') ?></span>
                                <div class="error_placeholder"></div>

                                <?php wp_nonce_field('zai_edit_user','edit_user_nonce', true, true ); ?>

								<div class="acc-item bb">
									<div class="btns-start pt-0">
										<a href="#" class="btn btn-primary btn-sm submit"><?php _e('Save Changes', 'am') ?></a>
									</div>
									<h3><?php _e('Profile Information', 'am') ?></h3>
									<div class="row">
										<div class="col-lg-8">
											<fieldset>
												<div class="row">
													<div class="col-12 col-md-4">
														<label><?php _e('First Name', 'am') ?>*</label>
													</div>
													<div class="col-sm-12 col-md-6">
														<input type="text" name="edit_firstname" id="edit_firstname"  value="<?php echo $userData->first_name  ?>">
													</div>
												</div>
											</fieldset>
											<fieldset>
												<div class="row">
													<div class="col-12 col-md-4">
														<label><?php _e('Last Name', 'am') ?>*</label>
													</div>
													<div class="col-sm-12 col-md-6">
														<input type="text" name="edit_lastname" id="edit_lastname"  value="<?php echo $userData->last_name  ?>">
													</div>
												</div>
											</fieldset>
											<fieldset>
												<div class="row">
													<div class="col-12 col-md-4">
														<label><?php _e('Email', 'am') ?>*</label>
													</div>
													<div class="col-sm-12 col-md-6">
														<input type="text" name="edit_email" id="edit_email"  value="<?php echo $userData->user_email  ?>">
													</div>
												</div>
											</fieldset>
											<fieldset>
												<div class="row">
													<div class="col-12 col-md-4">
														<label><?php _e('Phone Number', 'am') ?>*</label>
													</div>
													<div class="col-sm-12 col-md-6">
														<div class="row">
															<div class="col-6">
																<input type="text" name="edit_phone" id="edit_phone"  value="<?php echo get_user_meta($userData->ID, "phone", true) ?>">
															</div>
															<div class="col-6">
																<?php $phoneType = get_user_meta($userData->ID, "phone_type", true)?>
																<select name="edit_phonetype" id="edit_phonetype">
																	<option value="cell" <?php if($phoneType === 'cell') echo 'selected'?>><?php _e('Cell', 'am') ?></option>
																	<option value="office" <?php if($phoneType === 'office') echo 'selected'?>><?php _e('Office', 'am') ?></option>
																</select>
															</div>
														</div>
													</div>
												</div>
											</fieldset>
											<p class="intro"><?php the_field('profile_information_label', 'option');?></p>
										</div>
									</div>
								</div>
							</form>
						</div>

						<div class="styled-form tabbed-content" id="edit_payment">
                            <form action="#" id="edit_payment_form">

                                <span class="saved-confirmation"><?php _e('Payment Information saved', 'am') ?></span>
                                <span class="delete-confirmation"><?php _e('Payment Information deleted', 'am') ?></span>
                                <div class="error_placeholder"></div>

                                <div class="acc-item bb">
                                    <h3><?php _e('Payment Information', 'am') ?></h3>
                                    <?php $ccs = am_getCurrentUserCCs(); ?>

                                    <div class="table mb-15 responsive">
                                        <table id="cc-list">
                                            <tbody>
                                            <tr>
                                                <th><?php _e('Card Type', 'am') ?></th>
                                                <th><?php _e('Card #', 'am') ?></th>
                                                <th><?php _e('Expires', 'am') ?></th>
                                                <th class="text-right"><?php _e('Action', 'am') ?></th>
                                            </tr>

                                            <?php if(!$ccs) :?>
                                                <tr id="no-cards"><td colspan="4"><?php _e('No Credit Cards added', 'am') ?></td></tr>
                                            <?php else:?>
                                                <?php foreach($ccs as $cc):?>
                                                    <tr class="row-<?php echo $cc['cc_uid']?>">
                                                        <td><?php echo $cc['cc_type']?></td>
                                                        <td><?php echo $cc['cc_number_safe']?></td>
                                                        <td><?php echo $cc['cc_date_m'] .'/'.$cc['cc_date_y']?></td>
                                                        <td class="text-right"><a href="#" class="btn btn-secondary btn-sm edit-cc" data-id="<?php echo $cc['cc_uid']?>">Edit</a>
                                                            <a href="#" class="btn btn-secondary btn-sm delete-cc" data-id="<?php echo $cc['cc_uid']?>">Delete</a></td>
                                                    </tr>
                                                <?php endforeach;?>
                                            <?php endif; ?>

                                            </tbody>
                                        </table>
                                    </div>

                                    <hr class="mb-30">
                                    <div class="row">

                                        <input type="hidden" name="cc_uid" id="cc_uid"/>

                                        <div class="col-lg-8">
                                            <fieldset>
                                                <div class="row">
                                                    <div class="col-12 col-md-4">
                                                        <label><?php _e('Cardholder Name', 'am') ?></label>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <input type="text" name="cardholder_name" id="cardholder_name"  value="">
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <div class="row">
                                                    <div class="col-12 col-md-4">
                                                        <label><?php _e('Credit Card Number', 'am') ?></label>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <input type="text" name="cc_number" id="cc_number"  value="">
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <div class="row">
                                                    <div class="col-12 col-md-4">
                                                        <label><?php _e('Credit Card Type', 'am') ?></label>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <select name="cc_type" id="cc_type" >
                                                            <option value=""></option>
                                                            <option value="visa"><?php _e('Visa', 'am') ?></option>
                                                            <option value="mastercard"><?php _e('Master Card', 'am') ?></option>
                                                            <option value="amex"><?php _e('American Express', 'am') ?></option>
                                                            <option value="maestro"><?php _e('Maestro', 'am') ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <div class="row">
                                                    <div class="col-12 col-md-4">
                                                        <label><?php _e('Expiriation Date', 'am') ?></label>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <select name="cc_date_m" id="cc_date_m" >
                                                                    <option value=""></option>
                                                                    <?php for ($i=1;$i<=12;$i++):?>
                                                                        <option value="<?php echo $i?>"><?php echo $i?></option>
                                                                    <?php endfor;?>
                                                                </select>
                                                            </div>
                                                            <div class="col-6">
	                                                            <?php $curYear = date("Y");?>
                                                                <select name="cc_date_y" id="cc_date_y" >
                                                                    <option value=""></option>
                                                                    <?php for ($i=$curYear;$i<=$curYear+20;$i++):?>
                                                                        <option value="<?php echo $i?>"><?php echo $i?></option>
                                                                    <?php endfor;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <div class="row">
                                                    <div class="col-12 col-md-4">
                                                        <label><?php _e('CVV', 'am') ?></label>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <input type="text" name="cvv" id="cvv"  value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <a href="#" class="btn btn-primary btn-sm submit"><label><?php _e('Save Credit Card', 'am') ?></label></a>
                                        </div>
                                    </div>
                                </div>
                            </form>
						</div>

						<div class="styled-form tabbed-content" id="edit_password">
                            <form action="#" id="edit_password_form">
                                <span class="saved-confirmation"><?php _e('Password changed', 'am') ?></span>
                                <div class="error_placeholder"></div>

                                <div class="acc-item bb">
                                    <h3><?php _e('Change Password', 'am') ?></h3>
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <form action="#" id="edit_payment_form">
                                                <fieldset>
                                                    <div class="row">
                                                        <div class="col-12 col-md-4">
                                                            <label><?php _e('Old Password', 'am') ?></label>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6">
                                                            <input type="text" name="old_password" id="edit_old_password" >
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="row">
                                                        <div class="col-12 col-md-4">
                                                            <label><?php _e('New Password', 'am') ?></label>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6">
                                                            <input type="text" name="new_password" id="edit_new_password" >
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="row">
                                                        <div class="col-12 col-md-4">
                                                            <label><?php _e('Confirm Password', 'am') ?></label>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6">
                                                            <input type="text" name="confirm_password" id="edit_confirm_password" >
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <a href="#" class="btn btn-primary btn-sm submit"><?php _e('Reset', 'am') ?></a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </form>
						</div>

					</div>
				</div>
			</div>
		</div>



<?php endif;?>

<?php get_footer(); ?>