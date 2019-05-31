<?php
/*
Title: Exercises
Post Type: exercise
Order: 10
Meta box: false
*/



piklist('field', array(
  'type' => 'group'
  ,'template' => 'field'
  ,'fields' => array(
    array(
      'type' => 'number'
      ,'field' => 'sets'
      ,'label' => 'Sets'
      ,'columns' => 2
    )
    ,array(
      'type' => 'number'
      ,'field' => 'reps'
      ,'label' => 'Reps'
      ,'columns' => 2
    )
    ,array(
      'type' => 'number'
      ,'field' => 'time'
      ,'label' => 'Time'
      ,'columns' => 2
    )
    ,array(
      'type' => 'select'
      ,'field' => 'time_type'
      ,'label' => ' '
      ,'columns' => 2
      ,'choices' => array(
        'minutes' => 'Minutes'
        ,'hours' => 'Hour'
        ,'seconds' => 'Seconds'
      )
    )
    ,array(
        'type' => 'number'
        ,'field' => 'weight'
        ,'label' => 'Weight'
        ,'columns' => 2
      )
  )
));