<?php
/*
Shortcode: exercise_plan_output
*/
?>

<?php

  $current_user = wp_get_current_user();

  $plan_assigned_to = get_post_meta($post->ID, 'assigned_to', true);
  $plan_assigned_to_info = get_userdata($plan_assigned_to);



  // if($current_user->ID != $plan_assigned_to_info->ID) {
  //   echo '<h1>Not for you</h1>';
  //   return;
  // }

  echo '<p>Plan for: ' . $plan_assigned_to_info->data->display_name . '</p>';


  // Show plan description
  $description = get_post_meta($post->ID, 'description', true);
  echo !empty($description) ? '<p>' . $description . '</p>' : null;

  // Get the current exercise step from the url
  $exercise_plan_step = isset($_GET['step']) ? $_GET['step'] : 1;

  // Get the list of exercises
  $exercise_list_ids = get_post_meta($post->ID, 'excercise_list', false);

  // Pull the Post ID for the current exercise
  $exercise_id = $exercise_list_ids[$exercise_plan_step-1];

?>

<ul id="exercise-grid">

  <?php

  // Exercise fields we want to display
  $exercise_fields = array(
    'sets'
    ,'reps'
    ,'time'
    ,'weight'
  );

  foreach ($exercise_fields as $field) {

    $field_data = get_post_meta($exercise_id, $field, true);

    if(!empty($field_data)) {

      // Append time_type to time field
      $time_type = $field == 'time' ? "&nbsp;" . get_post_meta($exercise_id, 'time_type', true) : '';

      echo '<li>' . ucfirst($field) . ': ' . $field_data . $time_type . '</li>';

    }

  }

  ?>

</ul>

<?php

  // Show exercise notes
  $notes = get_post_meta($exercise_id, 'notes', true);
  echo !empty($notes) ? '<p>NOTES: ' . $notes . '</p>' : null;


  $youtube_url = get_post_meta($exercise_id, 'video', true);

?>

<?php if($youtube_url) : ?>

  <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo exercise_parse_youtube_id($youtube_url);?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

<?php endif; ?>



<div>
  <?php // if the previous step isset, show Previous button ?>
  <?php $previous_step = $exercise_plan_step-1; ?>

  <?php if(isset($exercise_list_ids[$previous_step]) && $previous_step != 0) : ?>

    <?php $url = esc_url_raw( add_query_arg( array(
            'step' => $previous_step
          ), get_permalink() ) ); ?>

    <a class="button" href="<?php echo $url; ?>">Previous</a>

  <?php endif;?>


  <?php // if the next step isset, show Next button ?>
  <?php $next_step = $exercise_plan_step + 1; ?>

  <?php if(isset($exercise_list_ids[$exercise_plan_step])) : ?>

    <?php $url = esc_url_raw( add_query_arg( array(
            'step' => $next_step
          ), get_permalink() ) ); ?>

    <a class="button" href="<?php echo $url; ?>">Next</a>

  <?php endif;?>
</div>




<style>
#exercise-grid {
  --auto-grid-min-size: 9rem;
  display: grid;
  grid-template-columns: auto auto auto auto;
}

#exercise-grid li {
  list-style: none;
}

</style>