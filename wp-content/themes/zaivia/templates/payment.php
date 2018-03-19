<script type="text/html" id="tmpl-payment">
    <# if(data.total > 0) { #>
    <div class="row">
        <div class="col-lg-6">
            <div class="acc-item mb-15">
                <h3><?php _e('Payment Details', 'am') ?></h3>
                <?php $cards = am_getCurrentUserCCs(); ?>
                <fieldset>
                    <label><?php _e('Saved Credit Card', 'am') ?></label>
                    <select id="saved_card" title="">
                        <option></option>
                        <?php foreach ($cards as $card): ?>
                            <option value="<?php echo $card['cc_uid']?>"><?php echo $card['cc_type']?> <?php echo $card['cc_number_safe']?></option>
                        <?php endforeach; ?>
                    </select>
                </fieldset>
                <div id="card_info">
                    <fieldset>
                        <label><?php _e('Cardholder Name', 'am') ?></label>
                        <input type="text" id="cardholder_name" title="" class="tosave">
                    </fieldset>
                    <fieldset>
                        <label><?php _e('Credit Card Number', 'am') ?></label>
                        <input type="text" id="card_number" title="" class="tosave">
                    </fieldset>
                    <fieldset>
                        <label><?php _e('Credit Card Type', 'am') ?></label>
                        <select title="" id="card_type" class="tosave">
                            <option><?php _e('Visa', 'am') ?></option>
                            <option><?php _e('Master Card', 'am') ?></option>
                        </select>
                    </fieldset>
                    <fieldset>
                        <label><?php _e('Expiration Date', 'am') ?></label>
                        <div class="row">
                            <div class="col-6">
                                <select id="exp_month" title="" class="tosave">
                                    <option value="1"><?php _e('January', 'am') ?></option>
                                    <option value="2"><?php _e('February', 'am') ?></option>
                                    <option value="3"><?php _e('March', 'am') ?></option>
                                    <option value="4"><?php _e('April', 'am') ?></option>
                                    <option value="5"><?php _e('May', 'am') ?></option>
                                    <option value="6"><?php _e('June', 'am') ?></option>
                                    <option value="7"><?php _e('July', 'am') ?></option>
                                    <option value="8"><?php _e('August', 'am') ?></option>
                                    <option value="9"><?php _e('September', 'am') ?></option>
                                    <option value="10"><?php _e('October', 'am') ?></option>
                                    <option value="11"><?php _e('November', 'am') ?></option>
                                    <option value="12"><?php _e('December', 'am') ?></option>
                                </select>
                            </div>
                            <div class="col-6">
                                <select id="exp_year" title="" class="tosave">
                                    <?php $cur_year = date('Y'); ?>
                                    <?php for ($y = $cur_year;$y < $cur_year + 20; $y++): ?>
                                        <option value="<?php echo $y-2000; ?>"><?php echo $y; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <label><?php _e('CVV', 'am') ?></label>
                        <div class="row">
                            <div class="col-6">
                                <input type="text" id="card_cvv" title="" class="tosave">
                            </div>
                        </div>
                    </fieldset>
                </div>
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
                            <td class="text-right" id="sub_total">${{data.subtotal}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-right"><?php _e('Discounts', 'am') ?></td>
                            <td class="text-right" id="discount">${{data.discounts}}</td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td></td>
                            <td class="text-right"><strong><?php _e('Total', 'am') ?></strong></td>
                            <td class="text-right"><strong id="total">${{data.total}}</strong></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="acc-item mb-15">
                <h3><?php _e('Promo Code', 'am') ?></h3>
                <fieldset>
                    <div class="row gutters-16">
                        <div class="col-8">
                            <input type="text" id="promo_code" title="" class="tosave">
                        </div>
                        <div class="col-4">
                            <button class="btn btn-outline blue btn-md btn-block"><?php _e('Apply', 'am') ?></button>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="col-lg-6 ml-auto mr-auto">
            <div class="acc-item mb-30">
                <h3><?php _e('How did you hear about us?', 'am') ?></strong></h3>
                <fieldset>
                    <select id="source" title="" class="tosave">
                        <option><?php _e('Friend', 'am') ?></strong></option>
                    </select>
                </fieldset>
            </div>
        </div>
    </div>
    <# } else { #>
    <div>
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
                        <td class="text-right">${{data.subtotal}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="text-right"><?php _e('Discounts', 'am') ?></td>
                        <td class="text-right">${{data.discounts}}</td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td></td>
                        <td class="text-right"><strong><?php _e('Total', 'am') ?></strong></td>
                        <td class="text-right"><strong>${{data.total}}</strong></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="acc-item mb-30">
            <h3><?php _e('How did you hear about us?', 'am') ?></strong></h3>
            <fieldset>
                <select id="source2" title="" class="tosave">
                    <option><?php _e('Friend', 'am') ?></strong></option>
                </select>
            </fieldset>
        </div>
    </div>
    <# } #>
</script>
<div id="payment"></div>