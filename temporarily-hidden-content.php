<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Temporarily Hidden Content
 * Description:       Hide or show content until specific date.
 * Version:           1.0.6
 * Author:            Codents
 * Author URI:        https://codents.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       temporarily-hidden-content
 * Domain Path:       /languages
 */

if (!defined('WPINC')) {
	die;
}

define('TEMPHC_NAME', 'Temporarily Hidden Content');
define('TEMPHC_SLUG', 'temporarily-hidden-content');
define('TEMPHC_VERSION', '1.0.6');
define('TEMPHC_DB_TERM', 'temphc');

function activate_temporarily_hidden_content() {
	require_once plugin_dir_path(__FILE__) . 'includes/class-temporarily-hidden-content-activator.php';
	$activator = new Temporarily_Hidden_Content_Activator(TEMPHC_VERSION, TEMPHC_DB_TERM);
	$activator->activate();
}

function deactivate_temporarily_hidden_content() {
	require_once plugin_dir_path(__FILE__) . 'includes/class-temporarily-hidden-content-activator.php';
	$activator = new Temporarily_Hidden_Content_Activator(TEMPHC_VERSION, TEMPHC_DB_TERM);
	$activator->deactivate();
}

register_activation_hook(__FILE__, 'activate_temporarily_hidden_content');
register_deactivation_hook(__FILE__, 'deactivate_temporarily_hidden_content');

require plugin_dir_path(__FILE__) . 'includes/class-temporarily-hidden-content.php';

function run_temporarily_hidden_content() {
	$plugin = new Temporarily_Hidden_Content(TEMPHC_NAME, TEMPHC_SLUG, TEMPHC_VERSION, TEMPHC_DB_TERM);
	$plugin->run();
}

run_temporarily_hidden_content();
