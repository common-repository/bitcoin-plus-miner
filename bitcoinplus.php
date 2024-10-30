<?php
/*
Plugin Name: Bitcoin Plus Miner
Plugin URI: http://www.bitcoinplus.com/miner/plugins/wordpress
Description: The Bitcoin Plus plugin lets you make money by having your visitors mine bitcoin for you. This can be done in the background without taking up any screen space ("hidden mode"), or it can show up as a widget with a start/stop button so your visitors can control the bitcoin miner.
Version: 1.1
Author: Donny Nadolny
Author URI: http://www.bitcoinplus.com
*/

register_activation_hook( __FILE__, 'bitcoinplus_activated' );

function bitcoinplus_activated() {
	if (get_option('bitcoinplus_settings')) {
		$options = get_option('bitcoinplus_settings');
		$options['ignore_setup_notice'] = 0;
		update_option('bitcoinplus_settings', $options);
	}
}

add_action('admin_notices', 'bitcoinplus_admin_notices');

function bitcoinplus_admin_notices() {
	$options = get_option('bitcoinplus_settings');
	if (!$options['ignore_setup_notice']) {
		echo '<div class="updated fade"><p><strong>Bitcoin Plus</strong>: <a href="http://www.bitcoinplus.com/register" target="_blank">register at Bitcoin Plus</a> and then drag and drop the <strong>Bitcoin Plus widget</strong> to your sidebar from your <a href="widgets.php">widgets page</a>.</p></div>';
		$options['ignore_setup_notice'] = 1;
		update_option('bitcoinplus_settings', $options);
	}
}

include_once dirname( __FILE__ ) . '/widget.php';

?>
