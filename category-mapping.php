<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://traveloregon.com
 * @since             1.0.0
 * @package           OTIS_Mapping
 *
 * @wordpress-plugin
 * Plugin Name:       OTIS Category Mapping
 * Plugin URI:        https://traveloregon.com
 * Description:       Used to map OTIS taxonomies to custom taxonomies
 * Version:           1.0.0
 * Author:            Travel Oregon
 * Author URI:        https://traveloregon.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       otis-mapping
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-category-mapping-activator.php
 */
function activate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-category-mapping-activator.php';
	Plugin_Name_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-category-mapping-deactivator.php
 */
function deactivate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-category-mapping-deactivator.php';
	Plugin_Name_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-category-mapping.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name() {

	$plugin = new Plugin_Name();
	$plugin->run();

}
run_plugin_name();

//dynamically load repeater field otis terms
//add_filter('acf/load_field/name=otis_term', 'acf_load_otis_terms');

function acf_load_otis_terms($field) {

	 // reset choices
    $field['choices'] = array();
	$choices = [];

	if( have_rows('field_5ced58c8627e9','options') ):

	endif;

   /* if( have_rows('field_5ced58c8627e9','options') ):


	 	while( have_rows('otis_repeater', 'options') ): the_row();
	 		$chosen_terms = get_sub_field('otis_term');

	 		foreach($chosen_terms as $choice) {

	 		 	$value = $choice;
	 		 	$label = $choice;

	 		 }

            //$field['choices'][ $choice ] = $choice;
            //$field[ $value ] = $label;
            $field['value123'] = 'label123';
	 	endwhile;

	 endif;*/

    return $field;
}

//get list of OTIS taxonomies
$file_path2 = plugins_url() . '/wp-otis-bulk/acf-json/group_58250328ca2ce.json';

function get_local_file_contents( $file_path ) {
	$json = json_decode( file_get_contents( $file_path ) );
	$otis_tax_array = array('type','glocats');

	foreach($json->fields as $arr) {
		if( isset($arr->taxonomy) && !is_array($arr->taxonomy)){
			array_push($otis_tax_array,$arr->taxonomy);
		}
	}

    return $otis_tax_array;
}


$otis_taxes = get_local_file_contents( $file_path2);


//dynamically populate otis dropdown
function acf_load_otis_taxes( $field ) {

    // reset choices
    $field['choices'] = array();
    $i = 0;
    $choices = [];
    $choices[$i] = array(
    	'label' => 'Select a taxonomy',
    	'value' => 'none'
    	);
    $i++;

	  $args = array (
	    'public'   => true
    );

    $output = 'objects';

    //$taxonomy_names = get_object_taxonomies( 'poi', 'objects' );
    $taxonomy_names = get_taxonomies($args,$output);

		foreach($taxonomy_names as $tax) {

			//echo $tax->label;
			//if(($tax->name == 'amenities' )  || ($tax->name == 'type' ) || ($tax->name == 'glocats' ) || ($tax->name == 'otis_category' ) || ($tax->name == 'otis_tag' )) {
			$file_path2 = plugins_url() . '/wp-otis-bulk/acf-json/group_58250328ca2ce.json';
			$otis_taxes = get_local_file_contents( $file_path2);
			if( in_array($tax->name,$otis_taxes)) {

				//array_push($choices,$tax->label);
				$choices[$i]['value'] = $tax->name;
				$choices[$i]['label'] = $tax->label;

				$i++;
			}
		}

    // loop through array and add to field 'choices'
    if( is_array($choices) ) {
        $i = 0;
        foreach( $choices as $choice ) {

	        $value = $choice['value'];
	        $label = $choice['label'];

            //$field['choices'][ $choice ] = $choice;
            $field['choices'][ $value ] = $label;
        }

    }


    // return the field
    return $field;

}

add_filter('acf/load_field/name=otis_tax', 'acf_load_otis_taxes');

//dynamically populate NEW tax dropdown
function acf_load_new_taxes( $field ) {

    // reset choices
    $field['choices'] = array();
    $i = 0;
    $choices = [];
    $choices[$i] = array(
    	'label' => 'Select a taxonomy',
    	'value' => 'none'
    	);

    $i++;

    $args = array (
	    'public'   => true
    );

    $output = 'objects';


    //$taxonomy_names = get_object_taxonomies( 'poi', 'objects' );
    $taxonomy_names = get_taxonomies($args,$output);

		foreach($taxonomy_names as $tax) {

			//echo $tax->label;
			//if(($tax->name != 'amenities' )  && ($tax->name != 'type' ) && ($tax->name != 'glocats' ) && ($tax->name != 'otis_category' ) && ($tax->name != 'otis_tag' )) {
			$file_path2 = plugins_url() . '/wp-otis-bulk/acf-json/group_58250328ca2ce.json';
			$otis_taxes = get_local_file_contents( $file_path2);
			if( !in_array($tax->name,$otis_taxes) && ($tax->name !== 'post_format')) {

				//array_push($choices,$tax->label);
				$choices[$i]['value'] = $tax->name;
				$choices[$i]['label'] = $tax->label;

				$i++;
			}
		}

    // loop through array and add to field 'choices'
    if( is_array($choices) ) {
        $i = 0;
        foreach( $choices as $choice ) {

	        $value = $choice['value'];
	        $label = $choice['label'];

            //$field['choices'][ $choice ] = $choice;
            $field['choices'][ $value ] = $label;
        }

    }


    // return the field
    return $field;

}

function assign_categories() {
	$counter = 0;
	if( have_rows('new_otis_repeat_field','options') ):

		 	while( have_rows('new_otis_repeat_field', 'options') ): the_row();
		 		//echo $i;
		 		$chosen_otis_tax = get_sub_field('otis_tax');
		 		$chosen_new_tax = get_sub_field('select_new_taxonomy');

		 		$otis_tax = get_taxonomy($chosen_otis_tax);
		 		$otis_tax_obj = $otis_tax->object_type;

		 		$new_tax = get_taxonomy($chosen_new_tax);
		 		$new_tax_obj = $new_tax->object_type;

		 		$otis_post_type = $otis_tax_obj[0];
		 		$new_post_type = $new_tax_obj[0];

		 		$otis_terms = get_sub_field('otis_term');
		 		$new_terms = get_sub_field('new_term');

		 		//loop through POI posts and remove existing taxonomies
		 		 $args = array(
							'post_type' => $new_post_type,
							'posts_per_page' => -1
							);

				$the_query = new WP_Query( $args );
				if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
						$post_id = get_the_ID();
						//remove terms so we can remap them
						if($counter == 0) {
							wp_set_object_terms($post_id,NULL,$new_tax->name);
						}

				endwhile;
				endif;

				wp_reset_query();

		 		//loop through otis terms.
		 		//sub loop through new terms. assign each here
		 		if($otis_terms) {
		 			foreach($otis_terms as $oterm) {
			 		foreach($new_terms as $nterm) {
				 		 $args = array(
							'post_type' => $otis_post_type,
							'posts_per_page' => -1,
							'tax_query' => array(
					        	array(
						            'taxonomy' => $chosen_otis_tax,
						            'field' => 'slug',
						            'terms' => $oterm
									)
								)
							);

						$the_query = new WP_Query( $args );
						if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();

							$post_id = get_the_ID();


							//set new terms
							wp_set_object_terms($post_id,$nterm,$new_tax->name, true);
						endwhile;
						endif;

			 		}
		 		}
		 		}

		 		$counter++;

		endwhile;

		endif;

}

add_action( 'hourly_otis_run', 'assign_categories' );

add_filter('acf/load_field/name=select_new_taxonomy', 'acf_load_new_taxes');

//remap categories after options page is saved
function options_page_saved( $post_id ) {

	$hourly_run = get_field('run_assignments_hourly','option');
	//set up cron job if hourly run is checked.
	if (!empty($hourly_run)) {
		if (! wp_next_scheduled ( 'hourly_otis_run' )) {
			wp_schedule_event(time(), 'hourly', 'hourly_otis_run');
		}
	} else {
		wp_clear_scheduled_hook( 'hourly_otis_run' );
	}

	//only run if bulk run checkbox is checked.
	$bulk_run = get_field('bulk_run_assignments_now','option');
    if (!empty($bulk_run)):
    	assign_categories();

	endif; //end bulk run if statement


}

add_action('acf/save_post', 'options_page_saved', 20);


function my_acf_prepare_field( $field ) {

	if( $field['value'] ) {

		//$field['disabled'] = true;

		$field['choices'] = array();

		if( have_rows('new_otis_repeat_field','options') ):

			while( have_rows('new_otis_repeat_field', 'options') ): the_row();

				$sub_field = get_sub_field('otis_term');

				if($sub_field) {
					foreach($sub_field as $choice) {
						$label = str_replace("-", " ", $choice);
						$label = ucfirst($label);

						$field['choices'][$choice] = $label;

					}
				}

			endwhile;

		endif;

	}

    return $field;

}

add_filter('acf/prepare_field/name=otis_term', 'my_acf_prepare_field');

function my_acf_prepare_field2( $field ) {

	if( $field['value'] ) {

		//$field['disabled'] = true;

		$field['choices'] = array();

		if( have_rows('new_otis_repeat_field','options') ):

			while( have_rows('new_otis_repeat_field', 'options') ): the_row();

				$sub_field = get_sub_field('new_term');

				if($sub_field) {
					foreach($sub_field as $choice) {
						$label = str_replace("-", " ", $choice);
						$label = ucfirst($label);

						$field['choices'][$choice] = $label;

					}
				}

			endwhile;

		endif;

	}

    return $field;

}

add_filter('acf/prepare_field/name=new_term', 'my_acf_prepare_field2');
