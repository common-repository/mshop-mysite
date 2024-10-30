<?php
wp_enqueue_script( 'mysite-gtag', sprintf( 'https://www.googletagmanager.com/gtag/js?id=%s', $content_id['track_content'] ), array(), MSHOP_OWNERSHIP_VERIFICATION_VERSION );

ob_start();
?>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push( arguments );
    }

    gtag( 'js', new Date() );

    gtag( 'config', '<?php echo $content_id['track_content'] ?>' );
</script>
<?php
$inline_script = ob_get_clean();
$inline_script = trim( preg_replace( '#<script[^>]*>(.*)</script>#is', '$1', $inline_script ) );

wp_add_inline_script( 'mysite-gtag', $inline_script );
wp_print_scripts( 'mysite-gtag' );
