<?php 
/**
 * @package Expose_Endpoint
 * @version 1.0.0
 */
/*
Plugin Name: Expose Future Events EventOn Endpoint
Plugin URI: https://orcafinweb.com/
Description: This plugin adds a function to expose all upcoming events using EventOn to wp-json @ /wp-json/events/all-events
Author: Robbie Carragher
Version: 1.0.0
Author URI: https://orcafinweb.com
*/

add_action('rest_api_init', 'custom_api_events');
function custom_api_events(){
    register_rest_route( 
        'events', 
        '/all-events', 
        array(
            'methods' => 'GET',
            'callback' => 'custom_events_callback',
            'permission_callback' => '__return_true',
        )
    );
}

function custom_events_callback($request){
		$posts = get_posts( array(
		  'post_type'       => 'ajde_events',
		  'status'          => 'published',
		  'posts_per_page'  => '-1',
		  'orderby'         => 'date',
		  'order'           => 'DESC',
		));
		foreach($posts as $post){

		    if (get_field('evcal_srow', $post->ID) > time()) {
    		    $id = $post->ID;
    		    if (has_post_thumbnail($id)){
            		$attachment_id = get_post_thumbnail_id( $post->ID );
            		$imageurl = wp_get_attachment_image_src($attachment_id, 'full')[0];
    		    }
    		    $subtitle = get_field('evcal_subtitle', $id);
    		    $sdate = get_field('evcal_srow', $id);
    		    $edate = get_field('evcal_erow', $id);
    		    $url = get_field('evcal_lmlink', $id);
    		    $urltarget = get_field('evcal_lmlink_target', $id);
    		    $featured = get_field('_featured', $id);
    		    $location_link = get_field('evcal_location_link', $id);
    		    $location_name = get_field('evcal_location_name', $id);
    		    $location_address = get_field('location_address', $id);
                $terms_cat_nums = get_the_terms($id,"event_type");
                $terms_cat = join(',', wp_list_pluck( $terms_cat_nums , 'slug') );
                $terms_cat_nums = join(',', wp_list_pluck( $terms_cat_nums , 'term_id') );
                
    		    $posts_data[] = (object)array(
    		        'id' => $id,
            		'title' => $post->post_title,
            		'content' => $post->post_content,
            		'category' => $terms_cat,
            		'category_ids' => $terms_cat_nums,
            		'featured' => $featured,
            		'img_src' => $imageurl,
            		'sdate' => $sdate,
            		'edate' => $edate,
            		'url' => $url,
            		'urltarget' => $urltarget,
                    'location_name' => $location_name, 
                    'location_link' => $location_link,
                    'location_address' => $location_address
            	);
		    }
		}
		return $posts_data;
}