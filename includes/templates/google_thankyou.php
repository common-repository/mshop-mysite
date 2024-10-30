<?php
wp_enqueue_script( 'mysite-google-thankyou', '//www.googleadservices.com/pagead/conversion.js', array(), MSHOP_OWNERSHIP_VERIFICATION_VERSION );

ob_start();
?>
<script>
    var google_conversion_id = '<?php echo $content_id['track_content'] ?>';
    var google_conversion_language = "en";
    var google_conversion_format = "3";
    var google_conversion_color = "ffffff";
    var google_conversion_label = "FoqTCKrnxGYQ3M-8pAM";
    var google_conversion_value = "<?php echo $order->get_total(); ?>";
    var google_conversion_currency = "KRW";
    var google_remarketing_only = false;
</script>
<?php
$inline_script = ob_get_clean();
$inline_script = trim( preg_replace( '#<script[^>]*>(.*)</script>#is', '$1', $inline_script ) );

wp_add_inline_script( 'mysite-google-thankyou', $inline_script, 'before' );
wp_print_scripts( 'mysite-google-thankyou' );
?>
<noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt=""
             src="//www.googleadservices.com/pagead/conversion/<?php echo $content_id['track_content'] ?>/?value=<?php echo $order->get_total(); ?>&amp;currency_code=KRW&amp;label=FoqTCKrnxGYQ3M-8pAM&amp;guid=ON&amp;script=0"/>
    </div>
</noscript>