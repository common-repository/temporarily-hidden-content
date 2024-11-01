<?php

	class Temporarily_Hidden_Content_Public {

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
			$this->class_slug = "{$this->plugin_slug}-public";
		}

		public function enqueue_scripts() {
			wp_register_script($this->class_slug, plugin_dir_url(__FILE__) . "../assets/scripts/{$this->class_slug}.min.js", array('jquery'), $this->plugin_version, false);
			wp_localize_script($this->class_slug, $this->plugin_db_term, array(
				'class_main' => $this->plugin_slug,
				'class_prefix' => $this->plugin_db_term,
				'translations' => array(
					'day' => __('day', $this->plugin_slug),
					'days' => __('days', $this->plugin_slug),
					'hour' => __('hour', $this->plugin_slug),
					'hours' => __('hours', $this->plugin_slug),
					'minute' => __('minute', $this->plugin_slug),
					'minutes' => __('minutes', $this->plugin_slug),
					'second' => __('second', $this->plugin_slug),
					'seconds' => __('seconds', $this->plugin_slug),
					'and' => __('and', $this->plugin_slug),
					'refreshButton' => __('Refresh to view this content', $this->plugin_slug)
				)
			));
			wp_enqueue_script($this->class_slug);
		}

		public function enqueue_styles() {
			wp_enqueue_style($this->class_slug, plugin_dir_url(__FILE__) . "../assets/styles/{$this->class_slug}.min.css", array(), $this->plugin_version, 'all');
		}

		public function add_shortcodes() {
			add_shortcode("{$this->plugin_db_term}-start", array($this, 'shortcode_start'));
			add_shortcode("{$this->plugin_db_term}-end", array($this, 'shortcode_end'));
		}

		public function shortcode_start($options = array(), $content) {
			if ($this->show_content($options)) {
				return apply_shortcodes($content);
			}
			return $this->show_countdown($options);
		}

		public function shortcode_end($options = array(), $content) {
			return !$this->show_content($options) ? $content : '';
		}

		public function show_countdown($options = array()) {
			if (isset($options['countdown']) && (
				$options['countdown'] === true || $options['countdown'] === 'true'
			)) {
				$template = new Temporarily_Hidden_Content_Template(plugin_dir_path(dirname(__FILE__)) . 'templates');
				$template->add(array(
					'YEAR' => date('Y', $options['timestamp']),
					'MONTH' => date('m', $options['timestamp']),
					'DAY' => date('d', $options['timestamp']),
					'HOUR' => date('H', $options['timestamp']),
					'MINUTE' => date('i', $options['timestamp']),
					'SECOND' => date('s', $options['timestamp']),
					'TIMESTAMP' => current_time('timestamp'),
					'COLOR' => isset($options['color']) ? $options['color'] : get_option($this->plugin_db_term . '_default_color'),
					'MESSAGE' => isset($options['message']) ? $options['message'] : __('to unlock this content', $this->class_slug)
				));
				return $template->getSource('countdown_view.tpl');
			}
			return '';
		}

		public function show_content(&$options = array()) {
			$selectedDate = isset($options['on']) ? $options['on'] : date('Y-m-d');
			$selectedTime = isset($options['at']) ? $options['at'] : date('H:i:s');
			$selectedDatetime = strtotime("{$selectedDate} {$selectedTime}");
			$options['timestamp'] = $selectedDatetime;
			$currentDatetime = strtotime(date('Y-m-d H:i:s', current_time('timestamp')));
			return $currentDatetime >= $selectedDatetime ? true : false;
		}

	}
