<?php
/*
Plugin Name: Exercise Plans
Description: Exercise Plan Application
Version: 1.0.0
License: GPLv2
Plugin type: piklist
*/

add_filter('show_admin_bar', '__return_false');

register_activation_hook(__FILE__, 'exercise_add_roles');
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
add_filter('piklist_post_types', 'excercise_post_types');
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
add_filter('the_content', 'excerise_plan_output', 20);
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
 * Validation Rules
 */
add_filter('piklist_validation_rules', 'exercise_validation_rules', 12);
function exercise_validation_rules($validation_rules)
{
  $validation_rules['youtube_url'] = array(
    'rule' => "~
                ^(?:https?://)?                           # Optional protocol
                 (?:www[.])?                              # Optional sub-domain
                 (?:youtube[.]com/watch[?]v=|youtu[.]be/) # Mandatory domain name (w/ query string in .com)
                 ([^&]{11})                               # Video id of 11 characters as capture group 1
               ~x"
    ,'message' => __('is not a valid youtube url.')
  ); 
  
  return $validation_rules;
}  

/**
 * Remove entry meta for genesis
 */
add_action('init', 'exercise_remove_entry_meta', 12);
function exercise_remove_entry_meta() {
  remove_post_type_support('exercise_plan', 'genesis-entry-meta-before-content');
  
  remove_action('genesis_header', 'genesis_header_markup_open', 5);
  remove_action('genesis_header', 'genesis_do_header');
  remove_action('genesis_header', 'genesis_header_markup_close', 15);
}