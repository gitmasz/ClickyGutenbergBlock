<?php
/**
 * Plugin Name:       Clicky Block
 * Description:       Plugin with example Gutenberg block named Clicky scaffolded with Create Block tool.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Marcin Szczepkowski
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       imaszclicky
 *
 * @package           create-block
 */

 namespace iMaSzPlugins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */

final class iMaSzClicky {
	static function init(){
		add_action( 'init', function(){
			register_block_type( __DIR__ . '/build/blocks/clickyGroup' );
			register_block_type( __DIR__ . '/build/blocks/clickyButton' );
		});

		register_block_pattern_category('imaszclicky', array(
			'label' => __('iMaSz Clicky', 'imaszclicky')
		));
		register_block_pattern('imaszclicky/clicky-example', array(
			'categories' => array('call-to-action', 'imaszclicky'),
			'title' => __('Clicky CTA', 'imaszclicky'),
			'description' => __('A heading, paragraph, and clicky button block', 'imaszclicky'),
			'content' => '<!-- wp:heading -->
			<h2 class="wp-block-heading">Example Title</h2>
			<!-- /wp:heading -->
			
			<!-- wp:paragraph -->
			<p>Example lorem ipsum text.</p>
			<!-- /wp:paragraph -->
			
			<!-- wp:imaszclicky/clicky-group -->
			<!-- wp:imaszclicky/clicky-button {"labelText":"Call to action","style":{"color":{"background":"#000000","text":"#FFFFFF"},"spacing":{"padding":{"top":"10px","bottom":"10px","left":"20px","right":"20px"}}}} /-->
			<!-- /wp:imaszclicky/clicky-group -->'
		));
	}

	static function convert_custom_properties($value)
	{
		$prefix     = 'var:';
		$prefix_len = strlen($prefix);
		$token_in   = '|';
		$token_out  = '--';
		if (str_starts_with($value, $prefix)) {
			$unwrapped_name = str_replace(
				$token_in,
				$token_out,
				substr($value, $prefix_len)
			);
			$value          = "var(--wp--$unwrapped_name)";
		}

		return $value;
	}
}

iMaSzClicky::init();
