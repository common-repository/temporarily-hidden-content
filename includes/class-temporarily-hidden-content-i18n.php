<?php

	class Temporarily_Hidden_Content_i18n {

		private $plugin_slug;

		public function _construct($slug) {
			$this->plugin_slug = $slug;
		}

		public function load_plugin_textdomain() {
			load_plugin_textdomain(
				$this->plugin_slug,
				false,
				dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
			);
		}

	}
