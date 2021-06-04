<?php
/**
 * Plugin Name:       Display Florida Charity Copy
 * Description:       Florida&#39;s registered charities need to display mandatory copy on their websites when soliciting donations. This plugin provides the block and block-patterns. 
 * Requires at least: 5.7
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Birgit Pauli-Haack
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       forflcharity
 *
 * @package           wp4good
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/writing-your-first-block-type/
 */
function wp_4_good_forflcharity_block_init() {
	register_block_type_from_metadata( __DIR__,
			array (
				//need render callback for dynamic block
				'render_callback' => 'forflcharity_display_block',
			));
}
add_action( 'init', 'wp_4_good_forflcharity_block_init' );

function forflcharity_display_block ( $attributes, $content ){
		$text = get_option( 'forflcharity_text' );
		$number = get_option( 'forflcharity_number' );

		$markup = '<div class="flstyles">';
		$markup .="<p><span class='flnumber'><strong>Florida Registration: {$number} </strong></span><br/> {$text} ";

		return "{$markup}</p></div>";	
}

/**
 * register settings with the REST API, no need for customend point.
 * https://developer.wordpress.org/reference/functions/register_setting/
 *  
 */


 function forflorida_register_settings(){
	$fltext = "A COPY OF THE OFFICIAL REGISTRATION AND FINANCIAL INFORMATION MAYBE BE OBTAINED FROM THE DIVISION OF CONSUMER SERVICES BY CALLING TOLL-FREE (800-435-7352) WITHIN THE STATE. REGISTRATION DOES NOT IMPLY ENDORSEMENT, APPROVAL, OR RECOMMENDATION BY THE STATE. Website: <a href='https://floridaconsumerhelp.com\'>FloridaConsumerHelp</a>";

	 register_setting (
		 'forflcharity_settings',
		 'forflcharity_number',
		 [
			 'default'      => '',
			 'show_in_rest' => true,
			 'type'			=> 'string',

		 ]

		 );
	register_setting (
		'forflcharity_settings',
		'forflcharity_text',
		[
			'default' 		=> $fltext,
			'show_in_rest'	=> true,
			'type'			=> 'string'
		]
		);
 }
add_action( 'init', 'forflorida_register_settings' );

// Setup Global Block Setting Options Setting
//include __DIR__ . '/wp-options.php';

// Register REST API Endpoint
//include __DIR__ . '/rest-api-endpoint.php';