<?php
/*
Title: Exercises
Post Type: exercise_plan
Order: 20
Meta box: false
Context: side
*/

piklist('field', array(
  'type' => 'select'
  ,'field' => 'assigned_to'
  ,'label' => 'Assigned to'
  ,'columns' => 12
  ,'choices' => piklist(
    get_users(
      array(
       'orderby' => 'display_name'
       ,'order' => 'asc'
       ,'role' => 'customer'
      )
      ,'objects'
    )
    ,array(
      'ID'
      ,'display_name'
    )
  )
));