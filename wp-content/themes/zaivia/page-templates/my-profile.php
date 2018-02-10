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
	<?php
		$userData = wp_get_current_user();
	?>
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
								<?php wp_nonce_field('zai_edit_user','edit_user_nonce', true, true ); ?>
								<div class="acc-item bb">
									<div class="btns-start pt-0">
										<a href="#" class="btn btn-primary btn-sm"><?php _e('Save Changes', 'am') ?></a>
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
														<input type="text" name="edit_firstname" id="edit_firstname"  value="<?php echo get_user_meta($userData->ID, "first_name", true)  ?>">
													</div>
												</div>
											</fieldset>
											<fieldset>
												<div class="row">
													<div class="col-12 col-md-4">
														<label><?php _e('Last Name', 'am') ?>*</label>
													</div>
													<div class="col-sm-12 col-md-6">
														<input type="text" name="edit_lastname" id="edit_lastname"  value="<?php echo get_user_meta($userData->ID, "last_name", true)  ?>">
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
											<p class="intro"><?php echo get_field('profile_information_label', 'option');?></p>
										</div>
									</div>
								</div>
							</form>
						</div>

						<div class="styled-form tabbed-content" id="edit_payment">
							<div class="acc-item bb">
								<h3>Price</h3>
								<div class="table mb-15 responsive">
									<table>
										<tbody>
										<tr>
											<th>Listing</th>
											<th>Listing</th>
											<th>Listing</th>
											<th class="text-right">Action</th>
										</tr>
										<tr>
											<td>Visa</td>
											<td>xxxx-xxxx-xxxx-xxxx</td>
											<td>02/2015</td>
											<td class="text-right"><a href="#" class="btn btn-secondary btn-sm">Edit</a><a href="#" class="btn btn-secondary btn-sm">Delete</a></td>
										</tr>
										</tbody>
									</table>
								</div>
								<hr class="mb-30">
								<div class="row">
									<div class="col-lg-8">
										<form action="#" id="edit_payment_form">
											<fieldset>
												<div class="row">
													<div class="col-12 col-md-4">
														<label>Label</label>
													</div>
													<div class="col-sm-12 col-md-6">
														<input type="text" placeholder="">
													</div>
												</div>
											</fieldset>
											<fieldset>
												<div class="row">
													<div class="col-12 col-md-4">
														<label>Label</label>
													</div>
													<div class="col-sm-12 col-md-6">
														<input type="text" placeholder="">
													</div>
												</div>
											</fieldset>
											<fieldset>
												<div class="row">
													<div class="col-12 col-md-4">
														<label>Label</label>
													</div>
													<div class="col-sm-12 col-md-6">
														<select><option>Cell</option></select>
													</div>
												</div>
											</fieldset>
											<fieldset>
												<div class="row">
													<div class="col-12 col-md-4">
														<label>Label</label>
													</div>
													<div class="col-sm-12 col-md-6">
														<div class="row">
															<div class="col-6">
																<input type="text" placeholder="">
															</div>
															<div class="col-6">
																<select><option>Cell</option></select>
															</div>
														</div>
													</div>
												</div>
											</fieldset>
											<fieldset>
												<div class="row">
													<div class="col-12 col-md-4">
														<label>Label</label>
													</div>
													<div class="col-sm-12 col-md-6">
														<div class="row">
															<div class="col-6">
																<input type="text" placeholder="">
															</div>
														</div>
													</div>
												</div>
											</fieldset>
											<a href="#" class="btn btn-primary btn-sm">Reset</a>
										</form>
									</div>
								</div>
							</div>
						</div>

						<div class="styled-form tabbed-content" id="edit_password">
							<div class="acc-item bb">
								<h3>Price</h3>
								<div class="row">
									<div class="col-lg-8">
										<form action="#" id="edit_payment_form">
											<fieldset>
												<div class="row">
													<div class="col-12 col-md-4">
														<label>Label</label>
													</div>
													<div class="col-sm-12 col-md-6">
														<input type="text" placeholder="">
													</div>
												</div>
											</fieldset>
											<fieldset>
												<div class="row">
													<div class="col-12 col-md-4">
														<label>Label</label>
													</div>
													<div class="col-sm-12 col-md-6">
														<input type="text" placeholder="">
													</div>
												</div>
											</fieldset>
											<fieldset>
												<div class="row">
													<div class="col-12 col-md-4">
														<label>Label</label>
													</div>
													<div class="col-sm-12 col-md-6">
														<input type="text" placeholder="">
													</div>
												</div>
											</fieldset>
											<a href="#" class="btn btn-primary btn-sm">Reset</a>
										</form>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>



<?php endif;?>

<?php get_footer(); ?>