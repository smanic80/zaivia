<div class="main-filter">
    <div class="container">
        <div class="row-h">
            <div class="form">
                <form action="#" id="filter_form">
                    <input type="text" class="autocomplete" placeholder="Enter a city" name="city" id="search_city" value="<?php echo isset($_GET['city']) ? $_GET['city'] : '' ?>">
                    <input type="hidden" name="rad" id="hidden_rad" value="<?php echo isset($_GET['rad']) ? $_GET['rad'] : '10' ?>">
                    <input type="hidden" name="price_min" id="hidden_price_min" value="<?php echo isset($_GET['price_min']) ? $_GET['price_min'] : '' ?>">
                    <input type="hidden" name="price_max" id="hidden_price_max" value="<?php echo isset($_GET['price_max']) ? $_GET['price_max'] : '' ?>">
                    <input type="hidden" name="beds" id="hidden_beds" value="<?php echo isset($_GET['beds']) ? $_GET['beds'] : '' ?>">
                    <input type="hidden" name="propertytype" id="hidden_propertytype" class="update_checks" value="<?php echo isset($_GET['propertytype']) ? $_GET['propertytype'] : '' ?>">
                    <input type="hidden" id="page" value="1">
                    <button type="submit"></button>
                </form>
            </div>
            <div class="mobile-filter"><?php _e('Filter','am'); ?></div>

            <div class="select one rad" rel="hidden_rad">
                <div class="current">+<?php echo isset($_GET['rad']) ? $_GET['rad'] : '10' ?><?php _e('km','am'); ?></div>
                <div class="dropdown price">
                    <div class="styled-form">
                        <ul>
                            <li><a href="#" rel="10">+10<?php _e('km','am'); ?></a></li>
                            <li><a href="#" rel="25">+25<?php _e('km','am'); ?></a></li>
                            <li><a href="#" rel="50">+50<?php _e('km','am'); ?></a></li>
                            <li><a href="#" rel="100">+100<?php _e('km','am'); ?></a></li>
                            <li><a href="#" rel="200">+200<?php _e('km','am'); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="select price">
                <div class="current"><?php _e('Price','am'); ?></div>
                <div class="dropdown price">
                    <div class="styled-form">
                        <div class="row gutters-16">
                            <div class="col-6">
                                <input type="text" placeholder="Min" id="filter_price_min" value="<?php echo isset($_GET['price_min']) ? $_GET['price_min'] : '' ?>">
                            </div>
                            <div class="col-x"> -</div>
                            <div class="col-6">
                                <input type="text" placeholder="Max" id="filter_price_max" value="<?php echo isset($_GET['price_max']) ? $_GET['price_max'] : '' ?>">
                            </div>
                        </div>
                    </div>
                    <ul id="select_price_min">
                        <li><a href="#" rel="0">0</a></li>
                        <li><a href="#" rel="50000">$50,000+</a></li>
                        <li><a href="#" rel="75000">$75,000+</a></li>
                        <li><a href="#" rel="100000">$100,000+</a></li>
                        <li><a href="#" rel="200000">$200,000+</a></li>
                        <li><a href="#" rel="300000">$300,000+</a></li>
                        <li><a href="#" rel="400000">$400,000+</a></li>
                        <li><a href="#" rel="500000">$500,000+</a></li>
                    </ul>
                    <ul id="select_price_max">
                        <li><a href="#" rel="250000">$250,000</a></li>
                        <li><a href="#" rel="50000">$50,000</a></li>
                        <li><a href="#" rel="75000">$75,000+</a></li>
                        <li><a href="#" rel="100000">$100,000+</a></li>
                        <li><a href="#" rel="200000">$200,000+</a></li>
                        <li><a href="#" rel="300000">$300,000+</a></li>
                        <li><a href="#" rel="400000">$400,000+</a></li>
                        <li><a href="#" rel="500000">$500,000+</a></li>
                    </ul>
                </div>
            </div>

            <div class="select one" rel="hidden_beds">
                <div class="current"><?php _e('Beds','am'); ?></div>
                <div class="dropdown price">
                    <div class="styled-form">
                        <?php $bedrooms = get_field('bedrooms', 'option'); ?>
                        <ul>
                            <?php foreach ($bedrooms as $item): ?>
                                <li><a href="#" rel="<?php echo $item['name'] ?>"><?php echo $item['name'] ?>+</a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="select checkbox" rel="hidden_propertytype">
                <div class="current"><?php _e('Property Type','am'); ?></div>
                <div class="dropdown checks">
                    <div class="styled-form">
                        <?php $propertyTypes = get_field('property_type', 'option'); ?>
                        <ul>
                            <?php foreach ($propertyTypes as $item): ?>
                                <li>
                                    <div class="wpcf7-checkbox">
                                        <label><input type="checkbox" value="<?php echo $item['name'] ?>"><span><?php echo $item['name'] ?></span></label>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="select mega">
                <div class="current more">
                    <?php _e('More Filters','am'); ?> <i class="fa fa-plus" aria-hidden="true"></i>
                </div>
                <div class="dropdown mega">
                    <div class="container sm">
                        <div class="styled-form">
                            <div class="row">
                                <div class="col-sm-6 col-md-2 col-lg-2 col-xl-3">
                                    <fieldset>
                                        <label><?php _e('Days On Zaivia','am'); ?></label>
                                        <div class="select-h">
                                            <div class="in">
                                                <select id="days-on-select" title="">
                                                    <option value="0"><?php _e('Any','am'); ?></option>
                                                    <option value="1">1 <?php _e('day','am'); ?></option>
                                                    <option value="7">7 <?php _e('days','am'); ?></option>
                                                    <option value="14">14 <?php _e('days','am'); ?></option>
                                                    <option value="30">30 <?php _e('days','am'); ?></option>
                                                    <option value="90">90 <?php _e('days','am'); ?></option>
                                                    <option value="183">6 <?php _e('months','am'); ?></option>
                                                    <option value="365">12 <?php _e('months','am'); ?></option>
                                                    <option value="730">24 <?php _e('months','am'); ?></option>
                                                    <option value="1095">36 <?php _e('months','am'); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <label><?php _e('Bathrooms','am'); ?></label>
                                        <div class="select-h">
                                            <div class="in">
                                                <?php $bathrooms = get_field('bathrooms', 'option'); ?>
                                                <select id="baths-select" title="">
                                                    <?php foreach ($bathrooms as $item): ?>
                                                        <option value="<?php echo $item['name'] ?>"><?php echo $item['name'] ?>+</option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="max-w">
                                        <fieldset>
                                            <label><?php _e('Square Feet','am'); ?></label>
                                            <div class="row gutters-16">
                                                <div class="col-6">
                                                    <input type="text" id="sqft-min" placeholder="Min sqft">
                                                </div>
                                                <div class="col-x">x</div>
                                                <div class="col-6">
                                                    <input type="text" id="sqft-max" placeholder="Max sqft">
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset>
                                            <label><?php _e('Year Built','am'); ?></label>
                                            <div class="row gutters-16">
                                                <div class="col-6">
                                                    <input type="text" id="year-built-min" placeholder="Min Yr">
                                                </div>
                                                <div class="col-x">x</div>
                                                <div class="col-6">
                                                    <input type="text" id="year-built-max" placeholder="Max Yr">
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <?php $features_1 = get_field('features_1', 'option'); ?>
                                <div class="col-md-7 col-lg-7 col-xl-6">
                                    <label class="left"><?php _e('Show Only','am'); ?></label>
                                    <div class="row gutters-16">
                                        <div class="col-sm-6 col-md-4">
                                            <ul class="checks">
                                                <li>
                                                    <div class="wpcf7-checkbox">
                                                        <label>
                                                            <input type="checkbox" class="show_only" value="0">
                                                            <span><?php _e('For','am'); ?> <?php echo $page_type; ?> <?php _e('by agent','am'); ?></span>
                                                        </label>
                                                    </div>
                                                </li>
                                                <?php $index = 0;
                                                foreach ($features_1 as $item): if ($item['show_in_filter']): ?>
                                                    <?php $index++;
                                                    if ($index % 3 == 1): ?>
                                                        <li>
                                                            <div class="wpcf7-checkbox">
                                                                <label>
                                                                    <input type="checkbox" class="features_1" value="<?php echo $item['key']; ?>">
                                                                    <span><?php echo $item['name']; ?></span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endif; endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <ul class="checks">
                                                <li>
                                                    <div class="wpcf7-checkbox">
                                                        <label>
                                                            <input type="checkbox" class="show_only" value="1">
                                                            <span><?php _e('For','am'); ?> <?php echo $page_type; ?> <?php _e('by owner','am'); ?></span>
                                                        </label>
                                                    </div>
                                                </li>
                                                <?php $index = 0;
                                                foreach ($features_1 as $item): if ($item['show_in_filter']): ?>
                                                    <?php $index++;
                                                    if ($index % 3 == 2): ?>
                                                        <li>
                                                            <div class="wpcf7-checkbox">
                                                                <label>
                                                                    <input type="checkbox" class="features_1" value="<?php echo $item['key']; ?>">
                                                                    <span><?php echo $item['name']; ?></span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endif; endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <ul class="checks">
                                                <li>
                                                    <div class="wpcf7-checkbox">
                                                        <label>
                                                            <input type="checkbox" class="show_only" value="2">
                                                            <span><?php _e('For','am'); ?> <?php echo $page_type; ?> <?php _e('by property management','am'); ?></span>
                                                        </label>
                                                    </div>
                                                </li>
                                                <?php $index = 0;
                                                foreach ($features_1 as $item): if ($item['show_in_filter']): ?>
                                                    <?php $index++;
                                                    if ($index % 3 == 0): ?>
                                                        <li>
                                                            <div class="wpcf7-checkbox">
                                                                <label>
                                                                    <input type="checkbox" class="features_1" value="<?php echo $item['key']; ?>">
                                                                    <span><?php echo $item['name']; ?></span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endif; endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="close">
                            <i class="fa fa-times-circle" aria-hidden="true"></i> <?php _e('Close Filters','am'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>