<?php

class Temporarily_Hidden_Content_Admin {

	private $plugin_name;
	private $plugin_slug;
	private $plugin_version;
	private $plugin_db_term;
	private $class_slug;

	public function __construct($options = array()) {
		$this->plugin_name = isset($options['name']) ? $options['name'] : null;
		$this->plugin_slug = isset($options['slug']) ? $options['slug'] : null;
		$this->plugin_version = isset($options['version']) ? $options['version'] : null;
		$this->plugin_db_term = isset($options['db_term']) ? $options['db_term'] : null;
		$this->class_slug = "{$this->plugin_slug}-admin";
	}

	public function enqueue_scripts() {
		wp_register_script($this->plugin_name, plugin_dir_url(__FILE__) . "../assets/scripts/{$this->class_slug}.min.js", array('jquery'), $this->plugin_version, false);
		wp_localize_script($this->plugin_name, $this->plugin_db_term, array(
			'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',
			'nonce' => wp_create_nonce('wp_rest')
		));
		wp_enqueue_script($this->plugin_name);
	}

	public function enqueue_styles() {
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . "../assets/styles/{$this->class_slug}.min.css", array(), $this->plugin_version, 'all');
	}

	public function add_button_to_settings() {
		add_submenu_page(
			'options-general.php',
			esc_html__($this->plugin_name, $this->plugin_slug),
			esc_html__($this->plugin_name, $this->plugin_slug),
			'administrator',
			$this->plugin_slug,
			array($this, 'admin_page')
		);
	}

	public function get_default_color_options() {
		return array(
			array(
				'TEXT' => __('Black', $this->plugin_slug),
				'VALUE' => 'black'
			),
			array(
				'TEXT' => __('Red', $this->plugin_slug),
				'VALUE' => 'red'
			),
			array(
				'TEXT' => __('Blue', $this->plugin_slug),
				'VALUE' => 'blue'
			),
			array(
				'TEXT' => __('Orange', $this->plugin_slug),
				'VALUE' => 'orange'
			),
			array(
				'TEXT' => __('Green', $this->plugin_slug),
				'VALUE' => 'green'
			),
			array(
				'TEXT' => __('Pink', $this->plugin_slug),
				'VALUE' => 'pink'
			)
		);
	}

	public function admin_page() {
		$template = new Temporarily_Hidden_Content_Template(plugin_dir_path(dirname(__FILE__)) . 'templates');
		$template->add(array(
			'PLUGIN_NAME' => $this->plugin_name,
			'PLUGIN_LOGO' => plugin_dir_url(__FILE__) . '../assets/images/logo.png',
			'TITLE_SETTINGS' => __('Settings', $this->plugin_slug),
			'TITLE_WHY' => __('Why Temporarily Hidden Content?', $this->plugin_slug),
			'TITLE_ABOUT' => __('About us', $this->plugin_slug),
			'FORM_DEFAULT_COLOR_OPTIONS' => $this->get_default_color_options(),
			'FORM_DEFAULT_COLOR_VALUE' => get_option($this->plugin_db_term . '_default_color'),
			'FORM_DEFAULT_COLOR_LABEL' => __('<strong>Change the default countdown color:</strong> Select the color you want to show the countdown with by default. You can override this select using the color attribute of the shortcode.', $this->plugin_slug),
			'BODY_WHY' => __('<p><strong>Temporarily Hidden Content</strong> is a plugin that allows you to show or hide content until a specific date. You can add or remove content from your pages and entries without edit again. In addition, you can notify your users with a countdown of when the content will be available.</p>', $this->plugin_slug),
			'BODY_ABOUT' => __('<p>We are <a href="https://codents.net" target="_blank">Codents</a>, a spanish company made up of young people who love programming and new technologies. We have been working with Wordpress and plugins for years, but it has not been until now that we have decided to upload tools as we think they can be useful for the community. If you like <strong>Temporarily Hidden Content</strong> you can rate it with <a href="https://wordpress.org/support/plugin/temporarily-hidden-content/reviews/?filter=5#new-post" target="_blank" rel="noopener noreferrer">★★★★★</a> at <a href="https://wordpress.org/support/plugin/temporarily-hidden-content/reviews/?filter=5#new-post" target="_blank" rel="noopener">WordPress.org</a>, it will help us to continue creating free plugins like this one.</p>', $this->plugin_slug),
			'FOOTER_TEXT' => __('Rate <strong>Temporarily Hidden Content</strong> with <a href="https://wordpress.org/support/plugin/temporarily-hidden-content/reviews/?filter=5#new-post" target="_blank" rel="noopener noreferrer">★★★★★</a> at <a href="https://wordpress.org/support/plugin/temporarily-hidden-content/reviews/?filter=5#new-post" target="_blank" rel="noopener">WordPress.org</a> and help us to continue creating free plugins. Thank you!', $this->plugin_slug)
		));
		$template->render('admin_panel.tpl');
	}

	public function save_settings() {
		$default_color_selected = sanitize_text_field($_POST['default_color']);
		$default_color_options = array_map(function ($option) {
			return $option['VALUE'];
		}, $this->get_default_color_options());
		if (is_admin() && in_array($default_color_selected, $default_color_options)) {
			require_once(ABSPATH . 'wp-includes/option.php');
			update_option($this->plugin_db_term . '_default_color', $default_color_selected);
			wp_send_json_success();
		} else {
			wp_send_json_error();
		}
	}
}
