<?php

//function csv2drupal_menu() {
//  $items = array();
//
//  $items['csv2drupal'] = array(
//    'title' => 'Excel Import',
//    'page callback' => 'drupal_get_form',
//    'page arguments' => array('csv2drupal_form'),
//    'access arguments' => array('access content'),
//    'type' => MENU_NORMAL_ITEM,
//  );
//
//  return $items;
//}
  return drupal_get_form('csv2drupal_form');

function csv2drupal_form() {
  $form = array();
  $form['import'] = array('#type' => 'fieldset',
    '#title' => t('Import Excel File'),
  );
  $form['import']['file'] = array('#type' => 'file',
    '#title' => t('Excel file'),
    '#size' => 50,
    '#description' => t('An Excel file.'),
  );
  $form['import']['submit'] = array('#type' => 'submit', '#value' => t('Import'));
  $form['#attributes']['enctype'] = 'multipart/form-data';

  return $form;

}