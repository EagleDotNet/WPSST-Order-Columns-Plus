<?php

/*
Plugin Name:  WPSST Order Columns Plus
Plugin URI:   https://www.syriasmart.net
Description:  Add more columns on admin oreder page. 
Version:      1.0
Author:       Syria Smart Technology 
Author URI:   https://www.syriasmart.net
License:      GPL v2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wpsst-order-columns-plus
Domain Path:  /languages
*/

// Add custom columns to orders table
add_filter('manage_edit-shop_order_columns', 'add_custom_order_columns');
function add_custom_order_columns($columns)
{
    $columns['total_order'] = __('تكلفة الطلب', 'woocommerce');
    $columns['shipping_cost'] = __('تكلفة الشحن', 'woocommerce');
    return $columns;
}

// Populate custom columns with shipping cost and total order data
add_action('manage_shop_order_posts_custom_column', 'populate_custom_order_columns', 2);
function populate_custom_order_columns($column)
{
    global $post;

    if ($column === 'shipping_cost') {
        $order = wc_get_order($post->ID);
        $shipping_total = $order->get_shipping_total();
        echo '<span class="shipping-cost">' . wc_price($shipping_total) . '</span>';
    }

    if ($column === 'total_order') {
        $order = wc_get_order($post->ID);
        $total_order = $order->get_total() - $order->get_shipping_total();
        echo '<span class="total-order">' . wc_price($total_order) . '</span>';
    }
}
?>