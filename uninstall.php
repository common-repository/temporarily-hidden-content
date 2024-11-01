<?php

	if (!defined('WP_UNINSTALL_PLUGIN')) {
		exit;
	}

	// delete plugin options
	global $wpdb;
	$db_term = 'tmphc';
	$table_name = $wpdb->prefix . 'options';
	$wpdb->query("DELETE FROM {$table_name}
		WHERE option_name LIKE '{$db_term}_%'");
