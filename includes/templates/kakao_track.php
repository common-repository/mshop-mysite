<?php
wp_enqueue_script( 'kakao-track', '//t1.daumcdn.net/adfit/static/kp.js', array(), MSHOP_OWNERSHIP_VERIFICATION_VERSION, true );

ob_start();
?>
<script>
	kakaoPixel('<?php echo $content_id['track_content'] ?>').pageView();

<?php if ( function_exists('is_product') && is_product() ) : ?>
	<?php
	global $product;
	$product_id = $product->get_id();
	?>
		kakaoPixel('<?php echo $content_id['track_content'] ?>').viewContent({
			id: '<?php echo "$product_id" ?>'
		});
<?php elseif ( function_exists('is_cart') && is_cart() ) : ?>
	<?php
	$cart_items = WC()->cart->get_cart_contents();
	?>
		kakaoPixel('<?php echo $content_id['track_content'] ?>').viewCart({
			total_quantity: '<?php echo WC()->cart->get_cart_contents_count(); ?>',
			total_price: '<?php echo WC()->cart->get_cart_contents_total() + WC()->cart->get_cart_contents_tax() ?>',
			products: [
				<?php foreach($cart_items as $cart_item) : ?>
				{
					id: "<?php echo empty( $cart_item['variation_id'] ) ? $cart_item['product_id'] : $cart_item['variation_id']; ?>",
					quantity: "<?php echo $cart_item['quantity'] ?>",
					price: "<?php echo $cart_item['line_total'] ?>"
				},
				<?php endforeach; ?>
			]
		});
<?php elseif ( function_exists('is_order_received_page') && is_order_received_page() ) : ?>
	<?php
	global $wp_query;
	$order_id    = $wp_query->query_vars['order-received'];
	$order       = wc_get_order( $order_id );
	$order_items = $order->get_items();
	?>
	<?php if ( $order ) : ?>
			kakaoPixel('<?php echo $content_id['track_content'] ?>').purchase({
				total_quantity: "<?php echo $order->get_item_count(); ?>",
				total_price: "<?php echo $order->get_total();?>",
				currency: "<?php echo $order->get_currency();?>",
				products: [
					<?php

					foreach( $order_items as $order_item ) :
					?>
					{
						name: "<?php echo $order_item->get_name();?>",
						quantity: "<?php echo $order_item->get_quantity();?>",
						price: "<?php echo $order_item->get_total();?>"
					},
					<?php endforeach; ?>
				]
			});
	<?php endif; ?>
<?php endif; ?>
</script>
<?php
$inline_script = ob_get_clean();
$inline_script = trim( preg_replace( '#<script[^>]*>(.*)</script>#is', '$1', $inline_script ) );

wp_add_inline_script( 'kakao-track', $inline_script );
wp_print_scripts( 'kakao-track' );

