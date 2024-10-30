<?php
if ( ! class_exists( 'MSOV_conversation' ) ) {
	class MSOV_conversation {
		static function init() {
			add_action( 'wp_head', array( __CLASS__, 'mshop_headtrack_code' ), 1 );
			add_action( 'wp_footer', array( __CLASS__, 'mshop_footertrack_code' ), 999 );
			add_action( 'woocommerce_thankyou', array( __CLASS__, 'mshop_thankyou_code' ), 1 );
		}

		static function conversation_track_enabled() {
			return 'yes' == get_option( 'msov_track_enabled', 'no' );
		}

		static function get_coversation_params() {
			return get_option( 'msov_conversation_params', array() );
		}

        static function is_ajax() {
            return function_exists( 'wp_doing_ajax' ) ? wp_doing_ajax() : defined( 'DOING_AJAX' );
        }

		static function mshop_footertrack_code() {
			if ( self::conversation_track_enabled() && ! is_admin() && ! self::is_ajax() ) {
				$content_ids = self::get_coversation_params();

				if ( ! empty( $content_ids ) ) {
					foreach ( $content_ids as $content_id ) {
						if ( ! empty( $content_id['track_service'] ) && ! empty( $content_id['track_content'] ) && ( $content_id['track_service'] == 'naver' || $content_id['track_service'] == 'google' || $content_id['track_service'] == 'kakao' ) ) {
							ob_start();
							include_once( MSOV()->plugin_path() . '/includes/templates/' . $content_id['track_service'] . '_track.php' );
							echo ob_get_clean();
						}
					}
				}
			}
		}

		static function mshop_headtrack_code() {
			if ( self::conversation_track_enabled() && ! is_admin() && ! self::is_ajax() ) {
				$content_ids = self::get_coversation_params();

				if ( ! empty( $content_ids ) ) {
					foreach ( $content_ids as $content_id ) {
						if ( ! empty( $content_id['track_service'] ) && ! empty( $content_id['track_content'] ) && ( $content_id['track_service'] != 'naver' && $content_id['track_service'] != 'google' && $content_id['track_service'] != 'kakao' ) ) {
							ob_start();
							include_once( MSOV()->plugin_path() . '/includes/templates/' . $content_id['track_service'] . '_track.php' );
							echo ob_get_clean();
						}
					}
				}
			}
		}

		static function mshop_thankyou_code( $order_id ) {

			if ( class_exists( 'WooCommerce' ) ) {

				$output   = '';
				$arr_list = array();

				if ( ! empty( $order_id ) ) {
					$order = new WC_Order( $order_id );
					$items = $order->get_items();

					foreach ( $items as $item_id => $item ) {
						if ( $item instanceof WC_Order_Item_Product ) {
							$product = $item->get_product();

							if ( $product ) {
								if ( ! empty( $product->get_sku() ) ) {
									$p_id = $product->get_sku() . '_1';
								} else {
									$p_id = $item->get_product_id() . '_1';
								}
							} else {
								$p_id = $item->get_id();
							}

							$arr_list[] = array(
								'i' => $p_id,
								't' => $item->get_name(),
								'p' => $item->get_total() / $item->get_quantity(),
								'q' => $item->get_quantity()
							);
						} else {
							$product = wc_get_product( $item['product_id'] );

							if ( $product ) {
								if ( ! empty( $product->sku ) ) {
									$p_id = $product->sku . '_1';
								} else {
									$p_id = $item['product_id'] . '_1';
								}
							}

							$arr_list[] = array(
								'i' => $p_id,
								't' => $product->get_title(),
								'p' => $product->get_price(),
								'q' => $item['qty']
							);
						}
					}

					$data = json_encode( $arr_list, JSON_UNESCAPED_UNICODE );

					if ( self::conversation_track_enabled() ) {
						$content_ids = self::get_coversation_params();

						if ( ! empty( $content_ids ) ) {

							foreach ( $content_ids as $content_id ) {
								if ( ! empty( $content_id['track_service'] ) && ! empty( $content_id['track_content'] ) ) {
									$filename = MSOV()->plugin_path() . '/includes/templates/' . $content_id['track_service'] . '_thankyou.php';

									if ( file_exists( $filename ) ) {
										ob_start();
										include_once( MSOV()->plugin_path() . '/includes/templates/' . $content_id['track_service'] . '_thankyou.php' );
										echo ob_get_clean();
									}
								}
							}
						}
					}
				}
			}
		}
	}

	MSOV_conversation::init();
}


