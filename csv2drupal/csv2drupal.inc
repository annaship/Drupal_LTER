<?php

function get_info_from_file() {
  $filename = get_file_name();
  $content = get_content($filename);

//  dpr($content);
  return $content;
}

function get_file_name() {
//  TODO: form here
  $filename = "/Users/anna/work/drupal/lter/new/today/variable_h.csv";
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
//    dpr($content);

  $uid = get_uid();
  $variables_node = create_variable_node($content, $uid);
  dpr($variables_node);
  $dataset_node = create_dataset_node($content, $uid);
  dpr($dataset_node);
}

function get_uid() {
  global $user;
  return $user->uid;
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

function create_dataset_node($content, $uid) {


//  dpr($content);

  foreach ($content as $value) {
      $node = new StdClass();
      $node->type = "data_set";
      $node->uid = $uid;
//        $node->is_new = 1;
      $node->title = $value['Title'];
      $node->field_beg_end_date[0]['value']             = $value['Date Range'];
      $node->field_dataset_abstract[0]['value']         = $value['Abstract'];
      $node->field_dataset_add_info[0]['value']         = $value['Additional Information'];
//      $node->field_dataset_biblio_ref[0]['value']       = $value['Related Bibliography'];
//      $node->field_dataset_contact_ref[0]['value']      = $value['Contact'];
//      $node->field_dataset_datafile_ref[0]['value']     = $value['Data File Structure'];
//      $node->field_dataset_datamanager_ref[0]['value']  = $value['Data Manager'];
//      $node->field_dataset_ext_assoc_ref[0]['value']    = $value['Associated Researcher'];
//      $node->field_dataset_fieldcrew_ref[0]['value']    = $value['Field Crew'];
      $node->field_dataset_id[0]['value']               = $value['Dataset ID'];
//      $node->field_dataset_labcrew_ref[0]['value']      = $value['Lab Crew'];
      $node->field_dataset_maintenance[0]['value']      = $value['Maintenance'];
//      $node->field_dataset_owner_ref[0]['value']        = $value['Owner'];
      $node->field_dataset_publication_date[0]['value'] = $value['Publication Date'];
      $node->field_dataset_purpose[0]['value']          = $value['Purpose'];
      $node->field_dataset_related_links[0]['value']    = $value['Related Links'];
      $node->field_dataset_short_name[0]['value']       = $value['Short Name'];
//      $node->field_dataset_site_ref[0]['value']         = $value['Site'];
      $node->field_instrumentation[0]['value']          = $value['Instrumentation'];
      $node->field_methods[0]['value']                  = $value['Methods'];
      $node->field_quality[0]['value']                  = $value['Quality Assurance'];
//      dpr('NEW\n');

  }
//    dpr($node);
    return $node;

}
