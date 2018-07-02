<div class="widget widget-report">
	<h3><a href="#report" class="open-modal"><i class="fa fa-flag-o" aria-hidden="true"></i>Report Listing</a></h3>
</div>
<div class="modal-overlay" id="report">
	<div class="table">
		<div class="center">
			<div class="box">
				<div class="close"><i class="fa fa-times" aria-hidden="true"></i></div>
				<h3 class="report"><i class="fa fa-flag-o" aria-hidden="true"></i><?php _e('Report Listing','am') ?></h3>
				<div class="styled-form">
					<form action="#" method="post" id="reportListing">
						<input type="hidden" id="report_url" name="report_url" value="<?php echo am_full_url();?>">
						<input type="text" placeholder="<?php _e('Full Name','am') ?>" id="report_full_name">
						<input type="email" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email half" placeholder="<?php _e('Email','am') ?>" aria-required="true" aria-invalid="false" id="report_email">
						<input type="text" class="half-r" placeholder="<?php _e('Phone','am') ?>" id="report_phone">
						<select id="report_reason" title=""><option value="1"><?php _e('Reason For Reporting','am') ?></option></select>
						<textarea placeholder="Please Describe The Problem" id="report_text"></textarea>
						<p>
                            <span class="wpcf7-form-control-wrap checkbox-399">
                                <span class="wpcf7-form-control wpcf7-checkbox">
                                    <span class="wpcf7-list-item first">
                                        <label><input type="checkbox" value="1" id="report_send_copy">&nbsp;<span class="wpcf7-list-item-label"><?php _e('Send me a copy of the email','am') ?></span></label>
                                    </span>
                                </span>
                            </span>
						</p>
						<div class="g-recaptcha" data-sitekey="<?php the_field('recaptcha_key', "option"); ?>"></div>
						<input type="submit" value="Send Message" class="wpcf7-form-control wpcf7-submit">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src='https://www.google.com/recaptcha/api.js'></script>