<?php
wp_enqueue_script( 'mysite-google-track', '//www.googleadservices.com/pagead/conversion.js', array(), MSHOP_OWNERSHIP_VERIFICATION_VERSION, true );

ob_start();
?>
<script>
    var google_conversion_id = <?php echo $content_id['track_content'] ?>;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
</script>
<?php
$inline_script = ob_get_clean();
$inline_script = trim( preg_replace( '#<script[^>]*>(.*)</script>#is', '$1', $inline_script ) );

wp_add_inline_script( 'mysite-google-track', $inline_script, 'before' );
wp_print_scripts( 'mysite-google-track' );
?>
<noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/<?php echo $content_id['track_content'] ?>/?value=0&amp;guid=ON&amp;script=0"/>
    </div>
</noscript>
