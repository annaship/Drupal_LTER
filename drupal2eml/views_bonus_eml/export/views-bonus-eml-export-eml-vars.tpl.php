<?php
// $Id: views-bonus-eml-export-eml-vars.tpl.php, v 3.0 11/09/10 ashipunova Exp $
/*
 * 1) Create an array $dataset_node with all data related to this dataset
 * 2) Calculate vid version 
 */                           
                                      
  require_once("views-bonus-eml-export-eml-funcions.tpl.php");

  foreach ($themed_rows as $row) {

    unset($ver_vid);
    unset($dataset_node);
    unset($node);
    unset($owner_nodes);
    unset($contact_nodes);
    unset($datamanager_nodes);
    unset($fieldcrew_nodes);
    unset($labcrew_nodes);
    unset($ext_assoc_nodes);
    unset($site_nodes);

    //   1) take all from db in one Array $dataset_node
    foreach ($row as $row_nid) {
      $node = node_load($row_nid);
      $dataset_node['dataset'] = $node;

      //  refs                  
      $dataset_reference_names = array(
        'dataset_owner',
        'dataset_contact',
        'dataset_datamanager',
        'dataset_fieldcrew',
        'dataset_labcrew',
        'dataset_ext_assoc',
        'dataset_site', 
      );        
                      
      foreach ($dataset_reference_names as $dataset_reference_name) {
        $ref_nodes = Array();
        $field_name = "field_" . $dataset_reference_name . "_ref";
        if (isset($node->$field_name)) {
          $ref_nid_array = $node->$field_name; 
          if ($dataset_reference_name == 'dataset_site' &&
            $node->field_dataset_site_ref[0]['nid']) {
            $ref_nodes = views_bonus_eml_get_site_information($ref_nid_array);
          } 
          else {
            foreach ($ref_nid_array as $v) {
              foreach ($v as $ref_nid) {
                $ref_nodes[] = node_load($ref_nid); 
              }
            }
          }
        }
        $dataset_node[$dataset_reference_name] = $ref_nodes;
      } 

      // if ($node->field_dataset_site_ref[0]['nid']) {
      //   $site_nodes = views_bonus_eml_get_site_information($node->field_dataset_site_ref);
      //   $dataset_node['dataset_site'] = $site_nodes;
      // }

     unset($datafile_node);

  //  datafile
      $field_dataset_datafile_ref_nid = $node->field_dataset_datafile_ref;
      if ($field_dataset_datafile_ref_nid) {
        foreach ($field_dataset_datafile_ref_nid as $v) {
          foreach ($v as $datafile_nid) {
            $variable_nodes      = Array();
            $datafile_site_nodes = Array();
            $datafile_node       = node_load($datafile_nid);
    //      variables
            if (isset($datafile_node->field_datafile_variable_ref)) {
              $field_datafile_variable_ref_nids = $datafile_node->field_datafile_variable_ref;
              foreach ($field_datafile_variable_ref_nids as $value) {
                foreach ($value as $var_nid) {
                  $variable_nodes[] = node_load($var_nid);
                }
              }
            }
    //      sites
            if (isset($datafile_node->field_datafile_site_ref[0]['nid'])) {
              $datafile_site_nodes = views_bonus_eml_get_site_information($datafile_node->field_datafile_site_ref);
            }
    //      all file related data
            $datafile_nodes[] = array ('datafile'       => $datafile_node,
                                       'variables'      => $variable_nodes,
                                       'datafile_sites' => $datafile_site_nodes);
          }
        }
      }
      $dataset_node['dataset_datafiles'] = $datafile_nodes;
    }

  /*
   * 1a) create dataset variables here
   */

    $dataset_short_name        = $dataset_node['dataset']->field_dataset_short_name;
    $dataset_title             = $dataset_node['dataset']->title;
    $dataset_publication_date  = $dataset_node['dataset']->field_dataset_publication_date;
    $dataset_abstract          = $dataset_node['dataset']->field_dataset_abstract;
    $dataset_add_info          = $dataset_node['dataset']->field_dataset_add_info;
    $dataset_beg_end_date      = $dataset_node['dataset']->field_beg_end_date;
    $dataset_purpose           = $dataset_node['dataset']->field_dataset_purpose;
    $dataset_maintenance       = $dataset_node['dataset']->field_dataset_maintenance;
    $dataset_methods           = $dataset_node['dataset']->field_methods;
    $dataset_id                = $dataset_node['dataset']->field_dataset_id;
    $dataset_related_links     = $dataset_node['dataset']->field_dataset_related_links;
    // have to check those two fields due to strange Notice after reinstall
    // TODO: find why those and only those?
    if (isset($dataset_node['dataset']->field_instrumentation)){
      $dataset_instrumentation = $dataset_node['dataset']->field_instrumentation;
    }
    if (isset($dataset_node['dataset']->field_quality)){
      $dataset_quality         = $dataset_node['dataset']->field_quality;
    }
                                
    $last_settings = prepare_settings();     

    global $user;

    $current_destination = drupal_get_destination();
    if (empty($user->uid)) {
      drupal_set_message('Please login in');
      drupal_goto('user/login', $current_destination);
    }
    elseif (!$last_settings['last_acronym']) {
      drupal_set_message("Please provide the site specific settings");
      drupal_goto('eml_config', $current_destination);
    }

    $acr = $last_settings['last_acronym'];
    $metadata_provider_arr     = array (node_load($last_settings['last_metadata_provider_ref']));
    $publisher_arr             = array (node_load($last_settings['last_publisher_ref']));
    $views_bonus_eml_site_name = variable_get('site_name', NULL);

    /* -----------------
     * 2) calculate vid version
     * ---------------------
     */
    $ver_vid = $dataset_node['dataset']->vid;

  //  persons and sites vid          
    foreach ($dataset_reference_names as $ref) {
      if (isset($dataset_node[$ref][0])) {
        foreach ($dataset_node[$ref] as $person_site) {
          if (isset($person_site->vid)) {
            $ver_vid += $person_site->vid;
          }
        }
      }
    }

  // vid of datafiles + variables + datafile_sites
   $flatten_files = flatten_array($dataset_node['dataset_datafiles']);
   if ($flatten_files) {
     foreach ($flatten_files as $object_value) {   
       if (isset($object_value->vid)) {
         $ver_vid += $object_value->vid; 
       }
     }
   }

   $package_id = 'knb-lter-' . $acr . '.' . $dataset_id[0]['value']  . '.' . $ver_vid;
   $realNumber = 'real';

 }
