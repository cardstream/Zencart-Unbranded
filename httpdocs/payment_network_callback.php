<?php
/*
 * Always replace POST action because Zen Cart often thinks
 * the variable is for itself (and will want a session) but it's not!
 *
 * As found in /includes/init_includes/init_sanitize.php (Line 30).
 * It checks to see if $_GET['action'] or $_POST['action'] are
 * present and if the session is valid by checking securityToken and
 * redirecting to a defined constant FILENAME_TIME_OUT as time_out
 * a code word for time_out for a URL (e.g /index.php?main_page=time_out)
 */
//Unset the variable since Zen Cart uses this for itself.
$post = $_POST;
$_POST = array();
//Load in Zen Cart
require('includes/application_top.php');
//Specify that we're a callback
define('PAYMENT_NETWORK_CALLBACK', 1);
//Load in payment library
require_once('includes/modules/payment/payment_network.php');
//Let's see if it's a valid payment response
if (payment_network::has_keys($post, payment_network::get_response_template())) {
	//Finally try to update our order through the callback
	$results = $db->Execute("SELECT * FROM payment_network_temp_carts WHERE payment_network_orderRef = \"" . $post['orderRef'] . "\"");
	if ($results->fields['payment_network_orderID'] == null) {
		payment_network::import_session(json_decode($results->fields['payment_network_session'], true));
		require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/checkout_process.php');
		$_POST = $post;
		require('includes/modules/checkout_process.php');
	} else {
		//Otherwise the order has already been completed
		error_log(MODULE_PAYMENT_PAYMENT_NETWORK_CALLBACK_DUPLICATE_LOG);
	}
} else {
	//Otherwise the keys could not be validated
	error_log(MODULE_PAYMENT_PAYMENT_NETWORK_CALLBACK_INVALID_RESPONSE_LOG);
}
?>