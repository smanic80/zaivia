<?php $profileUrl = (isset($data['ID']) && $data['ID']) ? get_permalink($data['ID']) : "#"; ?>

<div class="agent-item">
	<?php if(isset($data['card_profile_image_url']) && $data['card_profile_image_url']) :?><div class="image">
        <a href="<?php echo $profileUrl ?>"><img src="<?php echo $data['card_profile_image_url']?>" alt=""></a>
    </div><?php endif;?>
    <div class="text">
        <div class="center">
            <h4><a href="<?php echo $profileUrl ?>#"><?php echo implode(" ", [$data['card_first_name'], $data['card_last_name']])?></a></h4>
	        <?php if(isset($data['card_job_title']) && $data['card_job_title']) :?><div class="role"><?php echo $data['card_job_title']?></div><?php endif;?>
            <?php if(isset($data['card_company']) && $data['card_company']) :?><div class="by">
                <p><?php echo $data['card_company']?></p>
		        <?php if(isset($data['card_business_image_url']) && $data['card_business_image_url']) :?><a href="<?php echo $profileUrl ?>"><img src="<?php echo $data['card_business_image_url']?>" alt=""></a><?php endif;?>
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
        <div class="profile">
            <a href="<?php echo $profileUrl ?>"><?php _e('View Profile','am'); ?></a>
        </div>
    </div>
</div>
