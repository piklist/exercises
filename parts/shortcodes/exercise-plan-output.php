<?php
/*
Shortcode: exercise_plan_output
*/

$current_user = wp_get_current_user();

$plan_assigned_to = get_post_meta($post->ID, 'assigned_to', true);
$plan_assigned_to_info = get_userdata($plan_assigned_to);

if ($current_user->ID != $plan_assigned_to_info->ID):
?>
  <h2><?php _e('Not for you'); ?></h2>
<?php 
else:
  // Show plan description
  $description = get_post_meta($post->ID, 'description', true);
  if (!empty($description)):
  ?>
    <p><?php echo $description; ?></p>
  <?php
  endif;

  // Get the current exercise step from the url
  $exercise_plan_step = isset($_GET['step']) ? (int) $_GET['step'] : 1;

  // Get the list of exercises
  $exercise_list_ids = get_post_meta($post->ID, 'excercise_list', false);

  // Pull the Post ID for the current exercise
  $exercise_id = $exercise_list_ids[$exercise_plan_step-1];
?>
  <h2><?php _e('Plan for'); ?>: <?php echo $plan_assigned_to_info->data->display_name; ?></h2>
  
  <ul id="exercise-grid">
    <?php
      // Exercise fields we want to display
      $exercise_fields = array(
        'sets'
        ,'reps'
        ,'time'
        ,'weight'
      );
      foreach ($exercise_fields as $field):
        $field_data = get_post_meta($exercise_id, $field, true);
        if (!empty($field_data)):
          // Append time_type to time field
          $time_type = $field == 'time' ? "&nbsp;" . get_post_meta($exercise_id, 'time_type', true) : '';
        ?>
          <li><?php echo ucfirst($field) . ': ' . $field_data . $time_type; ?></li>
        <?php
        endif; 
      endforeach;
    ?>
  </ul>

  <?php
    // Show exercise notes
    $notes = get_post_meta($exercise_id, 'notes', true);
    if (!empty($notes)):
  ?>
    <p><?php echo $notes; ?></p>
  <?php
    endif;

    $youtube_url = get_post_meta($exercise_id, 'video', true);
    if ($youtube_url): 
  ?>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo exercise_parse_youtube_id($youtube_url);?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
  <?php endif; ?>

  <div>
    <?php 
      // If the previous step isset, show Previous button 
      $previous_step = $exercise_plan_step - 1; 
      
      if (isset($exercise_list_ids[$previous_step]) && $previous_step != 0):
      $url = esc_url_raw(add_query_arg(array(
               'step' => $previous_step
             ), get_permalink())); 
    ?>
      <a class="button" href="<?php echo $url; ?>"><?php _e('Previous'); ?></a>
    <?php 
      endif;
    
      // If the next step isset, show Next button 
      $next_step = $exercise_plan_step + 1;  
      if (isset($exercise_list_ids[$exercise_plan_step])): 
        $url = esc_url_raw(add_query_arg(array(
                 'step' => $next_step
               ), get_permalink())); 
    ?>
      <a class="button" href="<?php echo $url; ?>"><?php _e('Next'); ?></a>
    <?php endif;?>
  </div>

  <style type="text/css">
    #exercise-grid {
      --auto-grid-min-size: 9rem;
      display: grid;
      grid-template-columns: auto auto auto auto;
    }

    #exercise-grid li {
      list-style: none;
    }
  </style>
<?php endif; ?>