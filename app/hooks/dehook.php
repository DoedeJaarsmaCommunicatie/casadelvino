<?php

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
