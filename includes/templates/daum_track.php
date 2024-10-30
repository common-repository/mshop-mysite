<?php
global $wp_query;
$order_id    = $wp_query->query_vars['order-received'];
$order       = wc_get_order( $order_id );
?>
<?php if ( is_order_received_page() ) : ?>
<script type="text/javascript">
	//<![CDATA[
	var DaumConversionDctSv="type=P,orderID=<?php echo $order->get_order_number(); ?>,amount=<?php echo $order->get_total();?>";
	var DaumConversionAccountID="<?php echo $content_id['track_content'] ?>";
	if(typeof DaumConversionScriptLoaded=="undefined"&&location.protocol!="file:"){
		var DaumConversionScriptLoaded=true;
		document.write(unescape("%3Cscript%20type%3D%22text/javas"+"cript%22%20src%3D%22"+(location.protocol=="https:"?"https":"http")+"%3A//t1.daumcdn.net/cssjs/common/cts/vr200/dcts.js%22%3E%3C/script%3E"));
	}
	//]]>
</script>
<?php endif; ?>
