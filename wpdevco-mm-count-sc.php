<?php
/*
 * Plugin Name: MemberMouse Member Count
 * Plugin URI: http://wpdev.co/
 * Description: Display the total count of active members in MemberMouse (with optional Membership Level and Bundle attribute) via shortcode. Output is cached for 24 hours.
 * Version: 1.2.0
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
 *
 * @since 1.1.0
 ***/
add_action( 'plugins_loaded', 'wpdevco_mm_active_member_count_sc_init' );
function wpdevco_mm_active_member_count_sc_init() {
	
	if ( class_exists( 'MemberMouse' ) ) {
 
		add_shortcode( 'mm-active-member-count', 'wpdevco_mm_active_member_count_sc' );
	}
}

/*********
 * MemberMouse total active member count shortcode.
 *
 * Supported shortcode attributes:
 *   - level (MemberMouse 'Membership Level' ID)
 *   - bundle (MemberMouse 'Bundle' ID)
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
		'level' => '',
		'bundle' => ''
	);
	
	$atts = shortcode_atts( $defaults, $atts, 'mm-member-count' );
	
	if ( empty( $atts['level'] ) && empty( $atts['bundle'] ) ) {
		
		$transient_name = 'mm_count_results';
	}
	elseif ( !empty( $atts['level'] ) && empty( $atts['bundle'] ) ) {
		
		$transient_name = 'mm_count_results_' . $atts['level'];
	}
	elseif ( empty( $atts['level'] ) && !empty( $atts['bundle'] ) ) {
		
		$transient_name = 'mm_count_results_' . $atts['bundle'];
	}
	else {
		
		$transient_name = 'mm_count_results_' . $atts['level'] . '_' . $atts['bundle'];
	}

	if ( false === ( $active_member_count = get_transient( $transient_name ) ) ) {
		
		global $wpdb;
		
		$sql = "SELECT COUNT(*) ";
		$sql .= "FROM mm_user_data mmu ";
		
		if ( !empty( $atts['bundle'] ) ) {
			
			$sql .= ", mm_applied_bundles mmb ";
		}
		
		$sql .= "WHERE mmu.status IN (%d)";
		
		
		if ( empty( $atts['level'] ) && empty( $atts['bundle'] ) ) {
		
			$active_member_count = number_format( $wpdb->get_var( $wpdb->prepare( $sql, 1 ) ) );
		}
		elseif ( !empty( $atts['level'] ) && empty( $atts['bundle'] ) ) {
			
			$sql .= " AND mmu.membership_level_id IN (%d)";
			$active_member_count = number_format( $wpdb->get_var( $wpdb->prepare( $sql, 1, $atts['level'] ) ) );
		}
		elseif ( empty( $atts['level'] ) && !empty( $atts['bundle'] ) ) {
			
			$sql .= " AND mmu.wp_user_id = mmb.access_type_id AND mmb.access_type = (%s) AND mmb.bundle_id IN (%d)";
			$active_member_count = number_format( $wpdb->get_var( $wpdb->prepare( $sql, 1, 'user', $atts['bundle'] ) ) );
		}
		else {
			
			$sql .= " AND mmu.membership_level_id IN (%d)";
			$sql .= " AND mmu.wp_user_id = mmb.access_type_id AND mmb.access_type = (%s) AND mmb.bundle_id IN (%d)";
			$active_member_count = number_format( $wpdb->get_var( $wpdb->prepare( $sql, 1, $atts['level'], 'user', $atts['bundle'] ) ) );
		}
		
		set_transient( $transient_name, $active_member_count, DAY_IN_SECONDS );
	}
	
	if ( empty( $atts['level'] ) && empty( $atts['bundle'] ) ) {
		
		$output = '<span class="mm-active-member-count">' . $active_member_count . '</span>';
	}
	elseif ( !empty( $atts['level'] ) && empty( $atts['bundle'] ) ) {
		
		$output = '<span class="mm-active-member-count mm-level-' . $atts['level'] . '">' . $active_member_count . '</span>';
	}
	elseif ( empty( $atts['level'] ) && !empty( $atts['bundle'] ) ) {
		
		$output = '<span class="mm-active-member-count mm-bundle-' . $atts['bundle'] . '">' . $active_member_count . '</span>';
	}
	else {
		
		$output = '<span class="mm-active-member-count mm-level-' . $atts['level'] . ' mm-bundle-' . $atts['bundle'] . '">' . $active_member_count . '</span>';
	}
	
	return apply_filters( 'mm_active_member_count_shortcode', $output, $atts );
}