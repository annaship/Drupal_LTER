<?php

//function _AcademicStaff_Salutations() {
//  return array('Professor','Dr','Mr','Ms');
//}

function _person_tags() {
   return array (
    'Address',
    'City',
    'Country',
    'Email',
    'Fax',
    'First Name',
    'Last Name',
    'Organization',
    'personid',
    'Phone',
    'Publications',
    'Role',
    'State',
    'Title',
    'person_uid',
    'Zip Code',      
  );
}

function _person_field_names() {
  return array (
    field_person_address,
    field_person_city,
    field_person_country,
    field_person_email,
    field_person_fax,
    field_person_first_name,
    field_person_last_name,
    field_person_organization,
    field_person_personid,
    field_person_phone,
    field_person_pubs,
    field_person_role,
    field_person_state,
    field_person_title,
    field_person_uid,
    field_person_zipcode,
  );
}

function _person_field_name_tag() {
  static $person_field_name_tag;
  $person_field_names = _person_field_names();
  $person_tags = _person_tags();
  if (empty($person_field_name_tag)) {
    $person_field_name_tag =  array_combine($person_field_names, $person_tags);
  }
//  dpr($person_field_name_tag);
  return $person_field_name_tag;
}
  

function get_info_from_file() {
//  call 5 times for each csv file?
  $filename = get_file_name();
  $content = get_content($filename);
  return $content;
}

function get_file_name() {
//  TODO: form here
//  variable
//  $filename = "/Users/anna/work/drupal/lter/new/today/variable_h.csv";
//  dataset
  $module_name = "csv2drupal";
  $module_path = drupal_get_path('module', $module_name);

  $filename = $module_path . "/files/csv_examples_hor/1982_2000gs81tusbm_Person.csv";
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
//  $variables_nodes = create_variable_node($content, $uid);
//  dpr($variables_nodes);
//  $site_nodes      = create_site_node($content, $uid);
//  dpr($site_nodes);
//  $datafile_nodes  = create_datafile_node($content, $uid);
//  dpr($datafile_nodes);
//  $dataset_nodes   = create_dataset_node($content, $uid);
//  dpr($dataset_nodes);

//  TODO link referrer
}

function get_uid() {
  global $user;
  return $user->uid;
}

function create_person_node($content, $uid) {
//  dpr("create_person_node");

  $person_values = set_person_values($content);
  $node = put_person_values_into_node($person_values, $uid);
//  dpr($person_values);

    return $node;
}

function set_person_values($content) {
  $person_values_all = array();
  $person_tags   = _person_tags();
  foreach ($content as $value) {
//    TODO take nid for references
    $person_values = array();
    foreach ($person_tags as $person_tag) {      
      if (!empty ($value[$person_tag])) $person_values[$person_tag]['value'] = $value[$person_tag];
    }
    $person_values_all[] = $person_values;
  }
//  dpr($person_values_all);
  return $person_values_all;
}

function put_person_values_into_node($person_values, $uid) {
 $person_field_name_tags = _person_field_name_tag();
  foreach ($person_values as $person_value) {
//    TODO create a combined array and take key value to not repeat all below
      $node = new StdClass();
      $node->type = "person";
      $node->uid = $uid;
      $node->title = $person_value['First Name']['value'] . " " . $person_value['Last Name']['value']; 
      //TODO First + Last Name!
      if (!empty($person_value['First Name'])) {
        $node->field_person_first_name = array($person_value['First Name']);
      }
//    TODO  do the same, to avoid empty array with [0] or
    foreach ($person_field_name_tags as $key => $value) {
      $node->$key = array($person_value[$value]);
    }
      $node->field_person_last_name = array($person_value['Last Name']);
      $node->field_person_organization = array($person_value['Organization']);
      $node->field_person_role = array($person_value['Role']);
      $node->field_person_title = array($person_value['Title']);
      $node->field_person_email = array(array('email' => $person_value['Email']['value']));
      $node->field_person_address = array($person_value['Address']);
      $node->field_person_city = array($person_value['City']);
      $node->field_person_state = array($person_value['State']);
      $node->field_person_zipcode = array($person_value['Zip Code']);
      $node->field_person_country = array($person_value['Country']);
      $node->field_person_phone = array($person_value['Phone']);
      $node->field_person_fax = array($person_value['Fax']);
      $node->field_person_personid = array($person_value['personid']);
      $node->field_person_uid = array(array('uid' => $person_value['person_uid']['value']));
//     TODO what if not one?
      $node->field_person_pubs = array(array('nid' => $person_value['Publications']['value']));

//      dpr($node);
  }

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
  $node = put_dataset_values_into_node($dataset_values, $uid);
//  dpr($dataset_values);

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
      if (!empty ($value[$dataset_tag])) $dataset_values[$dataset_tag]['value'] = $value[$dataset_tag];
    }
  }
  return $dataset_values;
}

//taking person id (they should be created first)
// TODO the same for files and other refs (bib, sites)
function taking_person_ids($persons) {
  if (isset ($persons)) {
    $persons_arr = array();
    foreach ($persons as $persons_value) {
      $sql = "SELECT nid FROM {node} WHERE type = 'person' and title = '%s'";
      $q = db_query($sql, $persons_value);
        while ($nid = db_result($q)) {
        $persons_arr[][nid] = $nid;
      }
    }
    return $persons_arr;
  }
}

function put_dataset_values_into_node($dataset_values, $uid) {
//  print_r("UUU");
//Abstract] => Array
//        (
//            [0
    $node = new StdClass();
    $node->type                                       = "data_set";
    $node->uid                                        = $uid;
    $node->title                                      = $dataset_values['Title']['value'];
    $node->field_beg_end_date                         = array($dataset_values['Date Range']); //!!!
// TODO parse and format date
//    [field_beg_end_date] => Array
//        (
//            [0] => Array
//                (
//                    [value] => 2009-02-15T00:00:00
//                    [value2] => 2009-02-15T00:00:00
//                    [timezone] => America/New_York
//                    [timezone_db] => America/New_York
//                    [date_type] => date
//                )
//
//        )
//    [field_beg_end_date] => Array
//        (
//            [0] => Array
//                (
//                    [0] => 6/1/1982 - 7-31-2010
//                )
//
//        )
    $node->field_dataset_abstract         = array($dataset_values['Abstract']);
//    TODO add format
//    field_dataset_abstract] => Array
//        (
//            [0] => Array
//                (
//                    [value] => Let...
//
//                    [format] => 3
//                )
//
//        )       
//    [field_dataset_abstract] => Array
//        (
//            [0] => Array
//                (
//                    [value] => Above ground plant biomass and leaf area were measured in a moist acidic tussock tundra experimental site. The plots were set up in 1981 and have been harvested in periodical (See Shaver and Chapin Ecological Monographs, 61(1), 1991 pp.1-31.  Mack, et al, Nature 2004 431:440-443)  This file contains the biomass numbers for each harvested quadrat and per cent carbon and nitrogen summaries for harvests through 2000. Leaf area data is presented in other data files (see http://ecosystems.mbl.edu/arc).
//                )
//
//        )


    $node->field_dataset_add_info         = array($dataset_values['Additional Information']);
//    $node->field_dataset_biblio_ref[0]['value']       = $related_bibliography; //!!!
//    $node->field_dataset_contact_ref[0]['value']      = $contact; //!!!
//    $node->field_dataset_datafile_ref[0]['value']     = $data_file_structure; //!!!
//    $node->field_dataset_datamanager_ref[0]['value']  = $data_manager; //!!!
//    $node->field_dataset_ext_assoc_ref                = $ext_assoc_arr; //!!!
//    $node->field_dataset_fieldcrew_ref[0]['value']    = $field_crew; //!!!
    $node->field_dataset_id               = array($dataset_values['Dataset ID']); //good
//    $node->field_dataset_labcrew_ref[0]['value']      = $lab_crew; //!!!
    $node->field_dataset_maintenance      = array($dataset_values['Maintenance']);
//    TODO add format
//    [field_dataset_maintenance] => Array
//        (
//            [0] => Array
//                (
//                    [value] => Merged the 1982 through 2000 harvest files into a single file. JL Oct2005
//Version 1:  Created and eml document.  Jim 3Oct06
//Version 2: Added LTERNET Data Access server proxy for Excel and comma delimited data files.
//Version 3: Upadte LTERNET Data Access server proxy link for Excel and comma delimited data files. Changed from knb to das in url.
//                )
//
//        )
//    [field_dataset_maintenance] => Array
//        (
//            [0] => Array
//                (
//                    [value] => Damnum veniam singularis verto adipiscing. Laoreet euismod hos. Autem neque olim persto. Huic euismod abbas te vel metuo laoreet zelus te os. Validus sagaciter laoreet populus te ea enim. Olim verto paulatim tego melior. Cogo singularis sit. Facilisis tation erat vindico autem. Suscipit enim iustum pala iusto eligo fere ille eligo ideo. Causa quidem pertineo lobortis dignissim euismod aptent.
//
//Scisco luptatum pala erat olim i...
//                    [format] => 3
//                )
//
//        )

//    $node->field_dataset_owner_ref[0]['value']        = $owner; //!!!
    $node->field_dataset_publication_date =  array($dataset_values['Publication Date']);
//  TODO  add fields
//        [field_dataset_publication_date] => Array
//        (
//            [0] => Array
//                (
//                    [value] => 2008-03-09 11:27:12
//                    [timezone] => America/New_York
//                    [timezone_db] => America/New_York
//                    [date_type] => datetime
//                )
//
//        )
//    [field_dataset_publication_date] => Array
//        (
//            [0] => Array
//                (
//                    [value] => 2006
//                )
//
//        )

    $node->field_dataset_purpose          = array($dataset_values['Purpose']);
//  TODO add [format] => 1
    $node->field_dataset_related_links    = array($dataset_values['Related Links']); //!!!
    //TODO all empty should not have [0]! check above
//        [field_dataset_related_links] => Array
//        (
//        )
//    [field_dataset_related_links] => Array
//        (
//            [0] =>
//        )

    $node->field_dataset_short_name       = array($dataset_values['Short Name']); // good
//    $node->field_dataset_site_ref[0]['value']         = $site; //!!!
    $node->field_instrumentation          = array($dataset_values['Instrumentation']); //!!!
    $node->field_methods                  = array($dataset_values['Methods']); //!!!
// TODO add format
    $node->field_quality                  = array($dataset_values['Quality Assurance']);
// TODO add format
//    dpr($node);
}

