<?php
/*
Plugin Name: Exercise Plans
Description: Exercise Plan Application
Version: 1.0.0
License: GPLv2
Plugin type: piklist
*/

register_activation_hook(__FILE__, 'exercise_add_roles');

add_action('init', 'exercise_remove_entry_meta', 12);

add_filter('piklist_post_types', 'excercise_post_types');
add_filter('the_content', 'excerise_plan_output', 20);
add_filter('show_admin_bar', '__return_false');

/**
 * Add custom user role
 */
function exercise_add_roles() {
	add_role(
    'customer'
    ,'Customer'
    ,array(
      'read' => true
    )
  );
}

/**
 * Register Post Types
 */
function excercise_post_types($post_types) {
  $post_types['exercise_plan'] = array(
    'labels' => piklist('post_type_labels', 'Exercise Plan')
    ,'title' => __('Enter a Plan title')
    ,'supports' => array(
      'title'
    )
    ,'public' => true
    ,'has_archive' => true
    ,'rewrite' => array(
      'slug' => 'plan'
    )
    ,'capability_type' => 'post'
    ,'edit_columns' => array(
      'title' => __('Plan')
      ,'author' => __('Created by')
    )
    ,'hide_screen_options' => true  
    ,'hide_meta_box' => array(
      'author'
    )
    ,'status' => array(
      'approved' => array(
        'label' => 'Approved'
        ,'public' => true
        ,'show_in_admin_all_list' => true
        ,'show_in_admin_status_list' => true
      )
      ,'pending' => array(
        'label' => 'Pending Review'
        ,'public' => false
      )
    )
  );

  $post_types['exercise'] = array(
    'labels' => piklist('post_type_labels', 'Exercises')
    ,'title' => __('Enter an Exercise title')
    ,'supports' => array(
      'title'
    )
    ,'public' => false
    ,'show_ui' => true
    ,'capability_type' => 'post'
    ,'edit_columns' => array(
      'title' => __('Exercise')
      ,'author' => __('Created by')
    )
    ,'hide_meta_box' => array(
      'author'
    )
    ,'hide_screen_options' => true
    ,'status' => array(
      'approved' => array(
        'label' => 'Approved'
        ,'public' => true
        ,'show_in_admin_all_list' => true
        ,'show_in_admin_status_list' => true
      )
      ,'pending' => array(
        'label' => 'Pending Review'
        ,'public' => false
      )
    )
  );

  return $post_types;
}

/**
 * Automatically show exercise_plan_output shortcode on exercise_plan
 */
function excerise_plan_output($content) {
  if (is_singular('exercise_plan')) {
    $content .= do_shortcode('[exercise_plan_output]');
  }

  return $content;
}

/**
 * Grab and parse Youtube url to get ID
 */
function exercise_parse_youtube_id($youtube_url) {
   $youtube_query_parameters = parse_url($youtube_url, PHP_URL_QUERY);
   
   parse_str($youtube_query_parameters, $query_param_array);
   
   $youtube_id = !empty($query_param_array['v']) ? $query_param_array['v'] : null;

   return $youtube_id;
}

/**
 * Remove entry meta for genesis
 */
function exercise_remove_entry_meta() {
  remove_post_type_support('exercise_plan', 'genesis-entry-meta-before-content');
  
  remove_action('genesis_header', 'genesis_header_markup_open', 5);
  remove_action('genesis_header', 'genesis_do_header');
  remove_action('genesis_header', 'genesis_header_markup_close', 15);
}