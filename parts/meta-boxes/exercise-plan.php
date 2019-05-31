<?php
/*
Title: Exercises
Post Type: exercise_plan
Order: 20
Meta box: false
*/

piklist('field', array(
  'type' => 'select'
  ,'field' => 'excercise_list'
  ,'label' => 'Choose exercises'
  ,'description' => 'Only <a href="'.admin_url().'/edit.php?post_status=approved&post_type=exercise" target="_blank">Approved</a> exercies can be selected.'
  ,'add_more' => true
  ,'choices' => piklist(
    get_posts(
       array(
        'post_type' => 'exercise'
        ,'orderby' => 'title'
        ,'order' => 'ASC'
        ,'post_status' => 'approved'
       )
       ,'objects'
     )
     ,array(
       'ID'
       ,'post_title'
     )
  )
));