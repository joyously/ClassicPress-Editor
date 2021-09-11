<?php

/**
 * -----------------------------------------------------------------------------
 * Plugin Name: ClassicPress Editor - Experimental
 * Description: An integration of TinyMCE (v5) that brings a modern editing experience to ClassicPress while preserving the familiarity and function that users have grown to love. This plugin is not yet intended for production use.
 * Version: 1.0.0-alpha
 * Author: John Alarcon, Joy Reynolds, and ClassicPress Contributors
 * Author URI: https://www.classicpress.net
 * Text Domain: classicpress-editor
 * Domain Path: /languages
 * -----------------------------------------------------------------------------
 * This is free software released under the terms of the General Public License,
 * version 2, or later. It is distributed WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. Full
 * text of the license is available at https://www.gnu.org/licenses/gpl-2.0.txt.
 * -----------------------------------------------------------------------------
 * Copyright 2021, John Alarcon
 * -----------------------------------------------------------------------------
 */

namespace ClassicPress\TinyMce5;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Editor {

	public function __construct() {

		global $tinymce_version;

		$tinymce_version = '591-20210827';

		// Ensure TinyMCE is loading from within this plugin, not core.
		add_filter( 'includes_url', [ $this, 'filter_tinymce_includes_url' ], 10, 2 );

		// Filter the TinyMCE config objects.
		add_filter( 'tiny_mce_before_init', [ $this, 'filter_tinymce_init' ], 10, 2 );
		add_filter( 'teeny_mce_before_init', [ $this, 'filter_teenymce_init' ], 10, 2 );

	}

	public function filter_tinymce_includes_url( $url, $path ) {

		if ( strpos( $path, 'tinymce' ) !== false ) {
			$url = plugins_url( $path, __FILE__ );
		}

		return $url;

	}

	public function filter_tinymce_init( $mceInit, $editor_id ) {

		$mceInit['theme'] = 'silver'; //renaming silver folder to modern doesn't work
		$mceInit['height'] = 700 + 75; //height now includes menu
		$mceInit['min_height'] = 100 + 75;
		$mceInit['resize'] = true; //old value 'vertical' not available
		$mceInit['toolbar_location'] = 'top';
		$mceInit['toolbar_persist'] = true;
		$mceInit['custom_ui_selector'] = '.wp-editor-tools';
		
		// Plugins to load.
		$mceInit['plugins'] = 'charmap, hr, lists, media, paste, tabfocus, fullscreen, wpeditimage, wpemoji, wpgallery, wpdialogs, wptextpattern, wpview, searchreplace';
		// wordpress, wplink, colorpicker, textcolor, wpautoresize, autoresize
		
		// Toolbar layouts.
		$mceInit['toolbar1'] = 'formatselect | bold italic | bullist numlist | blockquote | alignleft aligncenter alignright | wp_more | dfv | wp_adv | fullscreen ';
		$mceInit['toolbar2'] = 'strikethrough hr | forecolor | pastetext | removeformat | charmap | outdent indent | undo redo | searchreplace ';
		
		// Filter plugins and toolbars.
		$mceInit['plugins']  = apply_filters('mce_plugins',   $mceInit['plugins']);
		$mceInit['toolbar1'] = apply_filters('mce_buttons',   $mceInit['toolbar1']);
		$mceInit['toolbar2'] = apply_filters('mce_buttons_2', $mceInit['toolbar2']);
		
		// Return Tiny config.
		return $mceInit;

	}

	public function filter_teenymce_init( $mceInit, $editor_id ) {

		return $mceInit;

	}

}

// Make beautiful all the things.
new Editor;
