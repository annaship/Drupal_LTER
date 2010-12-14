<?php

function get_info_from_file() {
//  call 5 times for each csv file?
  $filename = get_file_name();
  $content = get_content($filename);

//  dpr($content);
  return $content;
}

function get_file_name() {
//  TODO: form here
//  variable
//  $filename = "/Users/anna/work/drupal/lter/new/today/variable_h.csv";
//  dataset
  $filename = "/Users/anna/work/drupal/lter/new/today/csv_examples_hor/1982_2000gs81tusbm_DataSet.csv";

  return $filename;
}

function get_content($filename) {
  $content = csv_to_array($filename);
  return $content;
}

 function csv_to_array($filename='', $delimiter=',') {
    if(!file_exists($filename) || !is_readable($filename)) {
        return FALSE;
    }

    $header = NULL;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
        {
            if(!$header) {
                $header = $row;
                chop_field_names($header);
            }
            else {
                $data[] = array_combine($header, $row);
            }
        }
        fclose($handle);
    }
    return $data;
 }

 function chop_field_names(&$header) {
  foreach ($header as $key => $value) {
    $header[$key] = rtrim($value, " ");
  }
  return $header;
}

function create_nodes($content) {
//TODO link node references
  
  $uid            = get_uid();
  $person_nodes    = create_person_node($content, $uid);
//  dpr($person_nodes);
  $variables_nodes = create_variable_node($content, $uid);
//  dpr($variables_nodes);
  $site_nodes      = create_site_node($content, $uid);
//  dpr($site_nodes);
  $datafile_nodes  = create_datafile_node($content, $uid);
//  dpr($datafile_nodes);
  $dataset_nodes   = create_dataset_node($content, $uid);
  dpr($dataset_nodes);

//  TODO link referrer
}

function get_uid() {
  global $user;
  return $user->uid;
}

function create_person_node() {
//  dpr("create_person_node");
}

function create_variable_node($content, $uid) {

  foreach ($content as $value) {
      $node = new StdClass();
      $node->type = "variable";
      $node->uid = $uid;
      $node->title = $value['Name'];
      $node->field_attribute_label[0]['value'] = $value['Label'];
      $node->field_var_definition[0]['value'] = $value['Definition'];
      $node->field_var_missingvalues[0]['value'] = $value['Missing Values'];
      $node->field_attribute_unit[0]['value'] = $value['unit'];
      $node->field_attribute_maximum[0]['value'] = $value['Maximum Value'];
      $node->field_attribute_minimum[0]['value'] = $value['Minimum Value'];
      $node->field_attribute_precision[0]['value'] = $value['precision'];
      $node->field_attribute_formatstring[0]['value'] = $value['Date Format'];
      $node->field_code_definition[0]['value'] = $value['Code-Definition'];
      $node->field_attribute_assoc_datafile[0]['value'] = $value['Associated Data Files'];
  }

  return $node;
}

function create_site_node() {
//  dpr("create_site_node");
}

function create_datafile_node() {
//  dpr("create_datafile_node");
}

function create_dataset_node($content, $uid) {

  $dataset_values = set_dataset_values($content);
  $node = put_values_into_node($dataset_values);
  dpr($dataset_values);

//    dpr($node);
    return $node;

}

function set_dataset_values($content) {
  $dataset_values = array();
  $dataset_tags   = array(
    'Abstract',
    'Additional Information',
    'Associated Researcher',
    'Contact',
    'Data File Structure',
    'Data Manager',
    'Dataset ID',
    'Date Range',
    'Field Crew',
    'Instrumentation',
    'Lab Crew',
    'Maintenance',
    'Methods',
    'Owner',
    'Publication Date',
    'Purpose',
    'Related Bibliography',
    'Related Links',
    'Short Name',
    'Site',
    'Title',
    'Quality Assurance',
  );
  
  foreach ($content as $value) {
//    TODO take nid for references
    foreach ($dataset_tags as $dataset_tag) {
      if (!empty ($value[$dataset_tag])) $dataset_values[$dataset_tag][] = $value[$dataset_tag];
    }
  }
  dpr($dataset_values);

}

function put_values_into_node($dataset_values) {
//  print_r("UUU");
}
