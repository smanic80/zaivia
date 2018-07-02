<?php if(isset($data) && $data) :?>
    <?php $profileUrl = (isset($data['id']) && $data['id']) ? get_permalink($data['id']) : ""; ?>

    <?php if(isset($data['card_title']) && $data['card_title']) :?><h3><?php echo $data['card_title']?></h3><?php endif;?>

	<?php if(isset($data['need-wrap'])):?><div class="col-12 col-md-6 col-lg-4 mb-22"><?php endif;?>

    <div class="agent-item">
        <?php if(isset($data['card_profile_image_url']) && $data['card_profile_image_url']) :?><div class="image">
            <?php if($profileUrl):?><a href="<?php echo $profileUrl ?>"><?php endif;?>
                <img src="<?php echo $data['card_profile_image_url']?>" alt="">
	        <?php if($profileUrl):?></a><?php endif;?>
        </div><?php endif;?>
        <div class="text">
            <div class="center">
                <h4>
	                <?php if($profileUrl):?><a href="<?php echo $profileUrl ?>"><a href="<?php echo $profileUrl ?>"><?php endif;?>
                        <?php echo implode(" ", [$data['card_first_name'], $data['card_last_name']])?>
                    <?php if($profileUrl):?><a href="<?php echo $profileUrl ?>"></a><?php endif;?>
                </h4>
                <?php if(isset($data['card_job_title']) && $data['card_job_title']) :?><div class="role"><?php echo $data['card_job_title']?></div><?php endif;?>
                <?php if(isset($data['card_company']) && $data['card_company']) :?><div class="by">
                    <p><?php echo $data['card_company']?></p>
                    <?php if(isset($data['card_business_image_url']) && $data['card_business_image_url']) :?>
	                <?php if($profileUrl):?><a href="<?php echo $profileUrl ?>"><a href="<?php echo $profileUrl ?>"><?php endif;?>
                        <img src="<?php echo $data['card_business_image_url']?>" alt="">
                    <?php if($profileUrl):?><a href="<?php echo $profileUrl ?>"></a><?php endif;?>
                    <?php endif;?>
                </div><?php endif;?>
            </div>
        </div>
        <div class="bottom">
            <ul>
                <?php if((isset($data['card_phone']) && $data['card_phone']) || (isset($data['card_phone2']) && $data['card_phone2'])) :?><li>
                    <a href="tel:<?php echo $data['card_phone']?>">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        <span class="tooltip">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <strong><?php _e('Phone','am'); ?></strong><br>
                            <?php if((isset($data['card_phone']) && $data['card_phone'])): ?><?php echo (isset($data['card_phone_type']) && $data['card_phone_type'] === "cell") ? __('Cell','am') : __('Office','am'); ?>: <?php echo ZaiviaBusiness::formatPhone($data['card_phone']);?><br/><?php endif;?>
                            <?php if((isset($data['card_phone2']) && $data['card_phone2'])): ?><?php echo (isset($data['card_phone2_type']) && $data['card_phone2_type'] === "cell") ? __('Cell','am') : __('Office','am'); ?>: <?php echo ZaiviaBusiness::formatPhone($data['card_phone2']);?><?php endif;?>
                        </span>
                    </a>
                </li><?php endif;?>
                <?php if(isset($data['card_email']) && $data['card_email']) :?><li>
                    <a href="mailto:<?php echo $data['card_email']?>">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        <span class="tooltip">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <strong><?php _e('Mail','am'); ?></strong><br><?php echo $data['card_email']?>
                        </span>
                    </a>
                </li><?php endif;?>
                <?php if(isset($data['card_address_query'])) :?><li>
                    <a href="https://www.google.com/maps/?q=<?php echo $data['card_address_query']?>" target="_blank" >
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                        <?php if(isset($data['card_address']) && $data['card_address']) :?><span class="tooltip">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                            <strong><?php _e('Address','am'); ?></strong><br><?php echo implode(", ", [$data['card_city'], $data['card_address']]) ?>
                        </span><?php endif;?>
                    </a>
                </li><?php endif;?>
                <?php if(isset($data['card_url']) && $data['card_url']) :?><li>
                    <a href="<?php echo $data['card_url']?>" target="_blank">
                        <i class="fa fa-chain" aria-hidden="true"></i>
                        <span class="tooltip">
                            <i class="fa fa-chain" aria-hidden="true"></i>
                            <strong><?php _e('Link','am'); ?></strong><br><?php echo $data['card_url']?>
                        </span>
                    </a>
                </li><?php endif;?>
            </ul>
	        <?php if($profileUrl):?><div class="profile">
                <a href="<?php echo $profileUrl ?>"><?php _e('View Profile','am'); ?></a>
            </div><?php endif;?>
        </div>
    </div>

	<?php if(isset($data['need-wrap'])):?></div><?php endif;?>
<?php endif; ?>