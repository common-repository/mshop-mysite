<!-- Facebook Pixel Code-->
<script>
    !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
        n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
        document,'script','https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '<?php
        echo $content_id['track_content'] ?>');
    fbq('track', 'PageView');
    <?php
    if( function_exists('is_cart') && is_cart() ) {
        echo "fbq('track', 'AddToCart');";
    }
    if( function_exists('is_checkout') && ( is_checkout() && ! is_order_received_page() ) ) {
        echo "fbq('track', 'InitiateCheckout');";
    }
    ?>
</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?php echo $content_id['track_content'] ?>&ev=PageView&noscript=1"/></noscript>
<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code -->
