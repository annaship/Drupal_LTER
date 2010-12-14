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
  dpr($content);
  $ext_assoc_names = array();
    foreach ($content as $value) {

//    TODO all !!! value collect as $associated_researcher
    $title = get_value($value, 'title');
    $date_range             = get_array_of_values($value, 'Date Range');
    $abstract               = get_array_of_values($value, 'Abstract');
    $additional_information = get_array_of_values($value, 'Additional Information');
    $related_bibliography   = get_array_of_values($value, 'Related Bibliography');
    $contact                = get_array_of_values($value, 'Contact');
    $data_file_structure    = get_array_of_values($value, 'Data File Structure');
    $data_manager           = get_array_of_values($value, 'Data Manager');
    $associated_researcher  = get_array_of_values($value, 'Associated Researcher');
    $field_crew             = get_array_of_values($value, 'Field Crew');
    $dataset_id             = get_value($value, 'Dataset ID');
    $lab_crew               = get_array_of_values($value, 'Lab Crew');
    $maintenance            = get_value($value, 'Maintenance');
    $owner                  = get_array_of_values($value, 'Owner');
    $publication_date       = get_array_of_values($value, 'Publication Date');
    $purpose                = get_value($value, 'Purpose');
    $related_links          = get_array_of_values($value, 'Related Links');
    $short_name             = get_array_of_values($value, 'Short Name');
    $site                   = get_array_of_values($value, 'Site');
    $instrumentation        = get_array_of_values($value, 'Instrumentation');
    $methods                = get_array_of_values($value, 'Methods');
    $quality_assurance      = get_value($value, 'Quality Assurance');
  }
//  dpr($associated_researcher);

}

function get_value($value, $name) {
  $res = '';
  isset (${$name}) ? ${$name} = ${$name} : ${$name} = $value[$name];
  $res = ${$name};
//  TODO function to tr \n with <br/>
//  and other text changing if needed

  return $res;
}

function get_array_of_values($value, $name) {
  $res = '';

  if (!empty($value[$name])) {
    ${$name}[] = $value[$name];
  }
  $res = ${$name};
  dpr($res);
  return $res;

}

function put_values_into_node($dataset_values) {
//  print_r("UUU");
}
