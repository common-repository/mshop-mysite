<?php
wp_enqueue_script( 'mysite-naver-thankyou', '//wcs.naver.net/wcslog.js', array(), MSHOP_OWNERSHIP_VERIFICATION_VERSION );

ob_start();
?>
<script>
var _nasa={};
    _nasa["cnv"] = wcs.cnv("1","<?php echo $order->get_total(); ?>"); // 전환유형, 전환가치 설정해야함. 설치매뉴얼 참고
</script>
<?php
$inline_script = ob_get_clean();
$inline_script = trim( preg_replace( '#<script[^>]*>(.*)</script>#is', '$1', $inline_script ) );

wp_add_inline_script( 'mysite-naver-thankyou', $inline_script );
wp_print_scripts( 'mysite-naver-thankyou' );