<?php

/////////////////////////////////////////////////
// Woocommerce


// Woocommerce - Add theme support
function my_theme_add_woocommerce_support() {
	add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'my_theme_add_woocommerce_support');


// Woocommerce - Force to use WooCommerce's archive-product.php
add_filter('template_include', function($template) {
	if (is_shop()) {
			// Use WooCommerce's archive-product.php
			$shop_template = locate_template('woocommerce/archive-product.php');
			if ($shop_template) {
					return $shop_template;
			}
	}
	return $template;
});

// Woocommerce - Force to use WooCommerce's single-product.php
add_filter('template_include', function($template) {
  if (is_singular('product')) {
      $custom_template = locate_template('woocommerce/single-product-custom.php');
      if ($custom_template) {
          return $custom_template;
      }
  }
  return $template;
});

?>