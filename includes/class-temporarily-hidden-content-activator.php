<?php

	class Temporarily_Hidden_Content_Activator {

		private $version;
		private $db_term;
		private $options;

		public function __construct($version, $db_term, $options = array()) {
			$this->version = $version;
			$this->db_term = $db_term;
			$this->options = $options;
		}

		public function activate() {
			$this->create_options();
		}

		public function deactivate() {}

		private function create_options() {
			add_option('version', $this->version);
			add_option('default_color', null);
		}

		private function add_option($option, $value) {
			if (!get_option("{$this->db_term}_{$option}")) {
				add_option("{$this->db_term}_{$option}", $value);
			}
		}

		private function remove_options() {
			global $wpdb;
			$table_name = $wpdb->prefix . 'options';
			$wpdb->query("DELETE FROM {$table_name} WHERE
				option_name LIKE '{$db_term}_%'");
		}

		private function create_table_db() {}

		private function alter_table_db() {}

		private function drop_table_db() {}

	}
