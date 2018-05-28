<script type="text/html" id="tmpl-payment">
    <div <# if(data.total_num > 0) { #>class="row"<# } #>>

    <# if(data.total_num > 0) { #>
        <div class="col-lg-6">
            <div class="acc-item mb-15">
                <form id="payment-form" method="post" action="#">
                    <h3><?php _e('Payment Details', 'am') ?></h3>
                    <div id="payment_error"></div>
                    <fieldset>
                        <?php $cards = am_getCurrentUserCCs(); ?>
                        <label><?php _e('Saved Credit Card', 'am') ?></label>
                        <select id="saved_card" name="saved_card" title="" class="tosave">
                            <option></option>
                            <?php foreach ($cards as $card): ?>
                                <option value="<?php echo $card['cc_uid']?>"><?php echo $card['cc_type']?> <?php echo $card['cc_number_safe']?></option>
                            <?php endforeach; ?>
                        </select>
                    </fieldset>
                    <div id="card_info">
                        <fieldset>
                            <label><?php _e('Cardholder Name', 'am') ?></label>
                            <input type="text" id="cardholder_name" name="cardholder_name" title="" class="tosave">
                        </fieldset>
                        <fieldset>
                            <label><?php _e('Credit Card Number', 'am') ?></label>
                            <input type="text" id="cc_number" name="cc_number" title="" class="tosave">
                        </fieldset>
                        <fieldset>
                            <label><?php _e('Credit Card Type', 'am') ?></label>
                            <select title="" id="cc_type" name="cc_type" class="tosave">
                                <option value=""></option>
                                <option value="visa"><?php _e('Visa', 'am') ?></option>
                                <option value="mastercard"><?php _e('Master Card', 'am') ?></option>
                                <option value="amex"><?php _e('American Express', 'am') ?></option>
                                <option value="maestro"><?php _e('Maestro', 'am') ?></option>
                            </select>
                        </fieldset>
                        <fieldset>
                            <label><?php _e('Expiration Date', 'am') ?></label>
                            <div class="row">
                                <div class="col-6">
                                    <select name="cc_date_m" id="cc_date_m" class="tosave" >
                                        <option value=""></option>
                                        <?php for ($i=1;$i<=12;$i++):?>
                                            <option value="<?php echo $i?>"><?php echo $i?></option>
                                        <?php endfor;?>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <?php $cur_year = date('Y'); ?>
                                    <select name="cc_date_y" id="cc_date_y" title="" class="tosave">
                                        <?php for ($i=$cur_year; $i < $cur_year + 20; $i++): ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <label><?php _e('CVV', 'am') ?></label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" id="cvv" title="" class="tosave">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="acc-item mb-15">
                <h3><?php _e('Order Summary', 'am') ?></h3>
                <div class="table">
                    <table>
                        <thead id="payment_list">
                        <# for ( i in data.items ) { #>
                        <tr>
                            <th>{{data.items[i].label}}</th>
                            <th></th>
                            <th class="text-right">{{data.items[i].price}}</th>
                        </tr>
                        <# } #>
                        </thead>
                        <tbody>
                        <tr>
                            <td></td>
                            <td class="text-right"><?php _e('Sub-Total', 'am') ?></td>
                            <td class="text-right" id="sub_total">{{data.subtotal}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-right"><?php _e('Discounts', 'am') ?></td>
                            <td class="text-right" id="discount">{{data.discount}}</td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td></td>
                            <td class="text-right"><strong><?php _e('Total', 'am') ?></strong>&nbsp;</td>
                            <td class="text-right"><strong id="total">{{data.total}}</strong></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="acc-item mb-15">
                <h3><?php _e('Promo Code', 'am') ?></h3>
                <fieldset>
                    <# if ( data.coupon_name ) { #>
                    <div class="row gutters-16">
                        <div class="col-8">
                            <div class="col-8">{{data.coupon_name}}&nbsp;<a href="#" id="remove-promo">[X]</a></div>
                        </div>
                    </div>
                    <# } else { #>
                    <div class="row gutters-16">
                        <div class="col-8">
                            <input type="text" id="promo_code" title="" class="tosave">
                        </div>
                        <div class="col-4">
                            <button class="btn btn-outline blue btn-md btn-block" id="apply-promo"><?php _e('Apply', 'am') ?></button>
                        </div>
                    </div>
                    <div class="row gutters-16" id="promo_code_error" style="display: none;">
                        <div class="col-8 error"></div>
                    </div>
                    <# } #>
                </fieldset>
            </div>
	        <?php if(isset($business)) :?>
                <div class="text-right">
                    <a href="#" class="btn btn-primary btn-sm" id="business-pay"><?php _e('Purchase', 'am') ?></a>
                </div>
	        <?php endif; ?>
        </div>
    <# } else { #>
        <div class="acc-item mb-30">
            <h3><?php _e('Order Summary', 'am') ?></h3>
            <div class="table">
                <table>
                    <thead>
                    <# for ( i in data.items ) { #>
                    <tr>
                        <th>{{data.items[i].label}}</th>
                        <th></th>
                        <th class="text-right">{{data.items[i].price}}</th>
                    </tr>
                    <# } #>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td class="text-right"><?php _e('Sub-Total', 'am') ?></td>
                        <td class="text-right">{{data.subtotal}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="text-right"><?php _e('Discounts', 'am') ?></td>
                        <td class="text-right">{{data.discount}}</td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td></td>
                        <td class="text-right"><strong><?php _e('Total', 'am') ?></strong></td>
                        <td class="text-right"><strong>{{data.total}}</strong></td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <# if ( data.coupon_name ) { #>
            <div class="acc-item mb-15">
                <h3><?php _e('Promo Code', 'am') ?></h3>
                <fieldset>
                    <div class="row gutters-16">
                        <div class="col-8">
                            <div class="col-8">{{data.coupon_name}}&nbsp;<a href="#" id="remove-promo">[X]</a></div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <# } #>
        </div>
    <# } #>
    </div>
    <div id="payment-error" class="error"></div>
    <?php if(!isset($business) && !get_user_meta(get_current_user_id(), "listing_source")) :?>
        <div class="col-lg-6 ml-auto mr-auto">
            <div class="acc-item mb-30">
                <h3><?php _e('How did you hear about us?', 'am') ?></strong></h3>
                <fieldset>
                    <?php $options = get_field("how_did_you_hear_about_us", "option"); ?>
                    <select id="source" title="" class="tosave">
                        <?php foreach($options as $option):?>
                        <option value="<?php echo $option['option'] ?>"><?php echo $option['option'] ?></strong></option>
                        <?php endforeach; ?>
                    </select>
                </fieldset>
            </div>
        </div>
    <?php endif; ?>
</script>

<div id="payment"></div>
