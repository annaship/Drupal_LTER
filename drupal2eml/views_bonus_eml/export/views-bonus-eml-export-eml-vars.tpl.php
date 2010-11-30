<?php
  require_once("views-bonus-eml-export-eml-funcions.tpl.php");

/*
 * 1) take all from db as an Obect?/Array?
 * 2) calculate vid version
 * 3) create a template
 * 4) populate data into the template
 */

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
  // TODO: there are 3 similar arrays, remove
      $dataset_reference_names = array(
        'dataset_owner',
        'dataset_contact',
        'dataset_datamanager',
        'dataset_fieldcrew',
        'dataset_labcrew',
        'dataset_ext_assoc', 
      );        
                      
      foreach ($dataset_reference_names as $dataset_reference_name) {
        unset($ref_nodes);
        $field_name = "field_" . $dataset_reference_name . "_ref";
        $ref_nid_array = $node->$field_name; 
        if ($ref_nid_array) {
          foreach ($ref_nid_array as $v) {
            foreach ($v as $ref_nid) {
              $ref_nodes[] = node_load($ref_nid); 
            }
          }
        }
        $dataset_node[$dataset_reference_name] = $ref_nodes;
      } 

      if ($node->field_dataset_site_ref[0]['nid']) {
        $site_nodes = views_bonus_eml_get_site_information($node->field_dataset_site_ref);
        $dataset_node['dataset_site'] = $site_nodes;
      }

     unset($datafile_node);

  //  datafile
      $field_dataset_datafile_ref_nid = $node->field_dataset_datafile_ref;
      if ($field_dataset_datafile_ref_nid) {
        foreach ($field_dataset_datafile_ref_nid as $v) {
          foreach ($v as $datafile_nid) {
           unset($variable_nodes);
           unset($datafile_site_nodes);
            $datafile_node = node_load($datafile_nid);
    //      variables
            $field_datafile_variable_ref_nids = $datafile_node->field_datafile_variable_ref;
            if ($field_datafile_variable_ref_nids) {
              foreach ($field_datafile_variable_ref_nids as $value) {
                foreach ($value as $var_nid) {
                  $variable_nodes[] = node_load($var_nid);
                }
              }
            }
    //      sites
            if ($datafile_node->field_datafile_site_ref[0]['nid']) {
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

    $dataset_short_name       = $dataset_node['dataset']->field_dataset_short_name;
    $dataset_title            = $dataset_node['dataset']->title;
    $dataset_publication_date = $dataset_node['dataset']->field_dataset_publication_date;
    $dataset_abstract         = $dataset_node['dataset']->field_dataset_abstract;
    $dataset_add_info         = $dataset_node['dataset']->field_dataset_add_info;
    $dataset_beg_end_date     = $dataset_node['dataset']->field_beg_end_date;
    $dataset_purpose          = $dataset_node['dataset']->field_dataset_purpose;
    $dataset_maintenance      = $dataset_node['dataset']->field_dataset_maintenance;
    $dataset_instrumentation  = $dataset_node['dataset']->field_instrumentation;
    $dataset_methods          = $dataset_node['dataset']->field_methods;
    $dataset_quality          = $dataset_node['dataset']->field_quality;
    $dataset_id               = $dataset_node['dataset']->field_dataset_id;
    $dataset_related_links    = $dataset_node['dataset']->field_dataset_related_links;
                                
    // if(user_is_logged_in()){                               
    $last_settings = prepare_settings();     
    // }
                                          
    if (!$last_settings['last_acronym']) {    
      drupal_set_message("Please provide the site specific settings");
      $dest = drupal_get_destination();
      drupal_goto('eml_config', $dest);
    } 

    $acr = $last_settings['last_acronym'];
    $metadata_provider_arr = array (node_load($last_settings['last_metadata_provider_ref']));
    $publisher_arr         = array (node_load($last_settings['last_publisher_ref']));
    $views_bonus_eml_site_name = variable_get('site_name', NULL);

    /* -----------------
     * 2) calculate vid version
     * ---------------------
     */
    $ver_vid = $dataset_node['dataset']->vid;

  //  persons and sites vid
    $dataset_ref = array(
      'dataset_owner',
      'dataset_contact',
      'dataset_datamanager',
      'dataset_fieldcrew',
      'dataset_labcrew',
      'dataset_ext_assoc',
      'dataset_sites'
    );

    foreach ($dataset_ref as $ref) {
      if ($dataset_node[$ref][0]) {
        foreach ($dataset_node[$ref] as $person_site) {
          $ver_vid += $person_site->vid;
        }
      }
    }

  // vid of datafiles + variables + datafile_sites
   $flatten_files = flatten_array($dataset_node['dataset_datafiles']);
   if ($flatten_files) {
     foreach ($flatten_files as $object_value) {
       $ver_vid += $object_value->vid;
     }
   }

   $package_id = 'knb-lter-' . $acr . '.' . $dataset_id[0]['value']  . '.' . $ver_vid;

 }
