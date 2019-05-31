<?php
/*
Title: Status
Post Type: exercise, exercise_plan
Context: side
Priority: high
Order: 1
Locked: true
*/

  piklist('field', array(
    'type' => 'select'
    ,'scope' => 'post'
    ,'field' => 'post_status'
    ,'value' => $post->post_status
    ,'attributes' => array(
      'class' => 'text'
    )
    ,'choices' => array(
      'approved' => 'Approved'
      ,'pending' => 'Pending Review'
    )
  ));
?>

<div id="major-publishing-actions" class="piklist-major-publishing-actions">

  <div id="publishing-action">

    <?php echo submit_button(esc_html__('Save'), 'primary', 'submit', false); ?>

  </div>

  <div class="clear"></div>

</div>