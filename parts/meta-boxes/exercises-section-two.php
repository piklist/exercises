<?php
/*
Title: Exercises
Post Type: exercise
Order: 20
Meta box: false
*/


piklist('field', array(
  'type' => 'textarea'
  ,'field' => 'notes'
  ,'label' => 'Notes'
  ,'attributes' => array(
    'class' => 'large-text'
  )
));

piklist('field', array(
  'type' => 'text'
  ,'field' => 'video'
  ,'label' => 'Video'
  ,'description' => 'YouTube url'
  ,'help' => 'Enter the FULL YouTube url'
  ,'attributes' => array(
    'class' => 'large-text'
  )
  ,'validate' => array(
    array(
      'type' => 'youtube_url'
    )
  )
));

?>

<?php $youtube_url = get_post_meta($post->ID, 'video', true);?>

<?php if ($youtube_url) : ?>

  <iframe width="560" height="315" style="margin-left: 240px;" src="https://www.youtube.com/embed/<?php echo exercise_parse_youtube_id($youtube_url);?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

<?php endif; ?>