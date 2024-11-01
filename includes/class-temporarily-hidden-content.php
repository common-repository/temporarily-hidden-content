<?php

	class Temporarily_Hidden_Content {

		protected $plugin_name;
		protected $plugin_slug;
		protected $plugin_version;
		protected $plugin_db_term;
		protected $loader;

		public function __construct($name, $slug, $version, $db_term) {
			$this->plugin_name = $name;
			$this->plugin_slug = $slug;
			$this->plugin_version = $version;
			$this->plugin_db_term = $db_term;
			$this->load_dependencies();
			$this->set_locale();
			$this->define_admin_hooks();
			$this->define_public_hooks();
		}

		private function load_dependencies() {
			require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-temporarily-hidden-content-loader.php';
			require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-temporarily-hidden-content-i18n.php';
			require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-temporarily-hidden-content-template.php';
			require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-temporarily-hidden-content-admin.php';
			require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-temporarily-hidden-content-public.php';
			$this->loader = new Temporarily_Hidden_Content_Loader();
		}

		private function set_locale() {
			$plugin_i18n = new Temporarily_Hidden_Content_i18n($this->plugin_slug);
			$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
		}

		private function define_admin_hooks() {
			$plugin_admin = new Temporarily_Hidden_Content_Admin(array(
				'name' => $this->plugin_name,
				'slug' => $this->plugin_slug,
				'version' => $this->plugin_version,
				'db_term' => $this->plugin_db_term
			));
			$this->loader->add_action('wp_ajax_' . $this->plugin_db_term . '_save', $plugin_admin, 'save_settings');
			$this->loader->add_action('wp_ajax_nopriv_' . $this->plugin_db_term . '_save', $plugin_admin, 'save_settings');
			$this->loader->add_action('admin_menu', $plugin_admin, 'add_button_to_settings', 9);
			$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
			$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
		}

		private function define_public_hooks() {
			$plugin_public = new Temporarily_Hidden_Content_Public(array(
				'name' => $this->plugin_name,
				'slug' => $this->plugin_slug,
				'version' => $this->plugin_version,
				'db_term' => $this->plugin_db_term
			));
			$this->loader->add_action('init', $plugin_public, 'add_shortcodes');
			$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
			$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
		}

		public function get_plugin_name() {
			return $this->plugin_name;
		}

		public function get_plugin_slug() {
			return $this->plugin_slug;
		}

		public function get_plugin_version() {
			return $this->plugin_version;
		}

		public function get_plugin_db_term() {
			return $this->plugin_db_term;
		}

		public function run() {
			$this->loader->run();
		}

	}
