<?php
wp_enqueue_script( 'mysite-naver-analytics', 'https://wcs.naver.net/wcslog.js', array(), MSHOP_OWNERSHIP_VERIFICATION_VERSION );

ob_start();
?>
    <script>
        if (!wcs_add) var wcs_add={};
        wcs_add["wa"] = "<?php echo $content_id['track_content'] ?>";
        if(window.wcs) {
            wcs_do();
        }
    </script>
<?php
$inline_script = ob_get_clean();
$inline_script = trim( preg_replace( '#<script[^>]*>(.*)</script>#is', '$1', $inline_script ) );

wp_add_inline_script( 'mysite-naver-analytics', $inline_script );
wp_print_scripts( 'mysite-naver-analytics' );