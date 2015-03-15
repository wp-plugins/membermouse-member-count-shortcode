<?php
/*
 * Plugin Name: MemberMouse Member Count Shortcode
 * Plugin URI: http://wpdev.co/
 * Description: Display the total count of active members in MemberMouse (with optional Membership Level attribute). Output is cached for 24 hours. Examples: [mm-active-member-count] or [mm-active-member-count level="1"]
 * Version: 1.0.1
 * Author: wpdev.co
 * Author URI: http://wpdev.co/
 */

/*********
 * Exit if accessed directly.
 ***/
if ( !defined( 'ABSPATH' ) ) { 
	
	exit; 
}

/*********
 * Add shortcode.
 ***/
if ( class_exists( 'MemberMouse' ) ) {
	
	add_shortcode( 'mm-active-member-count', 'wpdevco_mm_active_member_count_sc' );
}

/*********
 * MemberMouse total active member count shortcode.
 *
 * Supported shortcode attributes:
 *   - level (MemberMouse 'Membership Level' ID)
 *
 * Output passes through 'mm_active_member_count_shortcode' filter before returning.
 *
 * @since 1.0.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output. Active member count.
 ***/
function wpdevco_mm_active_member_count_sc( $atts ) {
	
	$defaults = array(
		'level' => ''
	);
	
	$atts = shortcode_atts( $defaults, $atts, 'mm-member-count' );
	
	if ( empty( $atts['level'] ) ) {
		
		$transient_name = 'mm_count_results';
	}
	else {
		
		$transient_name = 'mm_count_results_' . $atts['level'];
	}

	if ( false === ( $active_member_count = get_transient( $transient_name ) ) ) {
		
		global $wpdb;
		
		$sql = "SELECT COUNT(*) ";
		$sql .= "FROM $wpdb->users u, mm_user_data mmu ";
		$sql .= "WHERE u.ID = mmu.wp_user_id AND mmu.status IN (%d)";
		
		if ( empty( $atts['level'] ) ) {
			
			$active_member_count = number_format( $wpdb->get_var( $wpdb->prepare( $sql, 1 ) ) );
		}
		else {
			
			$sql .= "  AND mmu.membership_level_id IN (%d)";
			$active_member_count = number_format( $wpdb->get_var( $wpdb->prepare( $sql, 1, $atts['level'] ) ) );
		}
		
		set_transient( $transient_name, $active_member_count, DAY_IN_SECONDS );
	}
	
	if ( empty( $atts['level'] ) ) {
		
		$output = '<span class="mm-active-member-count">' . $active_member_count . '</span>';
	}
	else {
		
		$output = '<span class="mm-active-member-count mm-level-' . $atts['level'] . '">' . $active_member_count . '</span>';
	}
	
	return apply_filters( 'mm_active_member_count_shortcode', $output, $atts );
}