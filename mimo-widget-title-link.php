<?php
/**
 * Plugin Name:  MIMO Widget Title link
 * Plugin URI:
 * Description: MIMO Widget Title link
 * Version:     0.9.1
 * Author:      Surakrai Nookong
 * Author URI:  https://www.facebook.com/surakraisam
 * Donate link: -
 * License:     GPLv2
 */

/**
 * Copyright (c) 2016 Surakrai Nookong (email : surakraisam@gmail.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MIMO_Widget_Title_Link' ) ) {


	class MIMO_Widget_Title_Link {

		private static $instance;

		public function __construct() {

			add_action( 'plugins_loaded', array( $this, 'add_hooks' ) );

			register_activation_hook( __FILE__, array( $this, 'plugin_activate') );
			register_deactivation_hook( __FILE__, array( $this, 'plugin_deactivate') );

		}

		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function add_hooks() {

			add_filter( 'widget_title' , array( $this, 'widget_display' ), 10, 3 );
			add_filter( 'in_widget_form', array( $this, 'widget_form' ), 10, 3 );
			add_filter( 'widget_update_callback', array( $this, 'widget_update' ), 10, 3 );

		}

		public function plugin_activate() {}
		public function plugin_deactivate() {}

		public function widget_display($title, $instance, $id_base) {

		  if ( !empty($instance['link']) ){
		    $title = "<a href='". $instance['link'] ."'>"  . $title . "</a>";
		  }
		  return $title;

		}
		public function widget_form( $widget, $return, $instance ) {
		  if ( !isset($instance['link']) )
		    $instance['link'] = null;
		  echo "<p><label for='widget-{$widget->id_base}-{$widget->number}-link'>Link :</label>";
		  echo "<input type='text' name='widget-{$widget->id_base}[{$widget->number}][link]' id='widget-{$widget->id_base}-{$widget->number}-link' class='widefat' value='{$instance['link']}'/></p>";
		}

		public function widget_update( $instance, $new_instance ) {
		  $instance['link'] = $new_instance['link'];
		  return $instance;
		}

	}

	MIMO_Widget_Title_Link::get_instance();

}
