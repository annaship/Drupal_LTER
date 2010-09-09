<?php
// $Id: views-bonus-export-eml.tpl.php,v 1.2 2009/06/24 17:27:53 neclimdul Exp $
/**
 * Template to display a view as an eml.
 * TODO: 
 * 1) add all tags
 * 2) parameters in tag <geographicCoverage id="GEO-13"> 
 *    as print '<'.$label.' '.$id_name.'="'.$id_value.'">'.$content.'</'.$label.'>';
 *
 */

function print_tag_line($label, $content) {
    print '<'.$label.'>'.$content.'</'.$label.'>';
}

function print_open_tag($tag) {
  print '<'.$tag.'>';
}

function print_close_tag($tag) {
  print '</'.$tag.'>';
}
        
function print_values($field_arr, $node, $drupal_node_attr, $drupal_node_flag = 0) {
  // if $drupal_node_flag == 1 print out Drupal node attributes - nid, type...
  if ($drupal_node_flag == 1) {
    print_node_attr($node, $drupal_node_attr);
    $drupal_node_flag = 0;
  }
          
  // for every field name print out a tagged value
  foreach ($field_arr as $field_name => $tag_name) {
    print_open_tag($tag_name);
    $field_value = $node->$field_name;
    through_array($field_value);
    print_close_tag($tag_name);
  }
}

function through_array($double_arr) {
  foreach ($double_arr as $key => $value){
    // take group tag
    $tag = $key;
    // check if we'll go recursively
    if (is_array($value)) {
      // print group tag
      if ($tag) {
        print_open_tag($tag);
        $flag = 1;
      }
      // if not end value, go through array again
      through_array($value);
    }
    else {
      // print out taged value
      $key == "value" ? print $value : print_tag_line($key, $value);
      // if tag <value></value> is needed, than change the line above with "print_tag_line($key, $value);"
    }
    if ($flag == 1) {
      print_close_tag($tag);
      $flag = 0;
    }
  }
}

function print_flat_ref_value($field_name, $tag_name, $node, $field_arr, $drupal_node_attr) {
  print_open_tag($tag_name);
  $field_value = $node->$field_name;
  foreach ($field_value as $key1 => $value1){
    foreach ($value1 as $key2 => $value2){
      $ref_node = node_load($value2);
      print_values($field_arr, $ref_node, $drupal_node_attr);
    }
  }
  print_close_tag($tag_name);
}

function print_node_attr($node, $drupal_node_attr) {
  $label = "drupal_node_attr";
  print_open_tag($label);     
  foreach ($drupal_node_attr as $field_name => $tag_name) {      
    print_tag_line($field_name, $node->$field_name);
  }
  print_close_tag($label);
}

function print_user($ref_node) {
  $user_id   = $ref_node->field_person_user;
  $user_nid  = $user_id[0][uid];
  $user_node = user_load($user_nid);
  print_open_tag("user");
  foreach ($user_node as $key1 => $value1){
    print_tag_line($key1, $value1);
  }
  print_close_tag("user");
}

/*
To change tag label change value in right coulmn
*/    
          
// do not print out value of those:
$drupal_node_attr = array(
  "body"      => "body",
  "changed"   => "changed",
  "comment"   => "comment",
  "comment_count"			      => "comment_count",
  "created"   => "created",
  "data"      => "data",
  "format"    => "format",
  "language"  => "language",
  "last_comment_name"			  => "last_comment_name",
  "last_comment_timestamp"  => "last_comment_timestamp",
  "log"       => "log",
  "moderate"  => "moderate",
  "name"      => "name",
  "nid"       => "nid",
  "picture"   => "picture",
  "promote"   => "promote",
  "revision_timestamp"      => "revision_timestamp",
  "revision_uid"            => "revision_uid",
  "status"    => "status",
  "sticky"    => "sticky",
  "taxonomy"			          => "taxonomy",
  "teaser"    => "teaser",
  "themekey_ui_theme"			  => "themekey_ui_theme",
  "title"     => "title",
  "tnid"      => "tnid",
  "translate" => "translate",
  "type"      => "type",
  "uid"       => "uid",
  "vid"       => "vid"
  );

/*
"user"
*/
$drupal_user = array(
  // "uid"               => "uid",
  "name"							=> "name",
  // "pass"             => "pass",
  "mail"							=> "mail",
  "mode"							=> "mode",
  "sort"							=> "sort",
  "threshold"         => "threshold",
  "theme"             => "theme",
  "signature"         => "signature",
  "signature_format"  => "signature_format",
  "created"						=> "created",
  "access"						=> "access",
  "login"							=> "login",
  "status"						=> "status",
  "timezone"					=> "timezone",
  "language"					=> "language",
  "picture"						=> "picture",
  "init"							=> "init",
  // "data"             => "data",
  "timezone_name"     => "timezone_name"
);
  
/*
"data_set"
*/
$data_set_field_arr = array(
  "field_abstract"              => "abstract",
  "field_beg_end_date"          => "field_beg_end_date",
  "field_dataset_add_info"      => "field_dataset_add_info",
  "field_dataset_id"            => "field_dataset_id",
  "field_dataset_instrument"    => "field_dataset_instrument",
  "field_dataset_maintenance"   => "field_dataset_maintenance",
  "field_dataset_methods"       => "field_dataset_methods",
  "field_dataset_purpose"       => "field_dataset_purpose",
  "field_dataset_quality"       => "field_dataset_quality",
  "field_publication_date"      => "field_publication_date",
  "field_short_name"            => "field_short_name",
  "field_title"                 => "field_title"
  // "field_dataset_assct_biblio"  => "field_dataset_assct_biblio",
  // "field_dataset_sevid"         => "field_dataset_sevid",
  // "field_dataset_datamanager_ref",
  // "field_dataset_fieldcrew_ref",
  // "field_dataset_labcrew_ref",
);
$data_set_field_ref_arr = array(
  "field_dataset_contact"       => "contact",
  "field_dataset_datafile_ref"  => "data_file",
  "field_dataset_ext_assoc"     => "ext_assoc",
  "field_dataset_owner"         => "owner",
  "field_dataset_site_ref"      => "site"
); 
                                 
    $shop = array( array("rose", 1.25 , 15),
                   array("daisy", 0.75 , 25),
                   array("orchid", 1.15 , 7) 
                 );
                 
$data_set_field_ref_hash = array(
  array("field_name" => "field_dataset_contact",      "tag_name" => "contact",    "array_name" => "person_field_arr"),
  // array("field_name" => "field_dataset_datafile_ref", "tag_name" => "data_file",  "array_name" => "data_file_field_arr"),
  array("field_name" => "field_dataset_ext_assoc",    "tag_name" => "ext_assoc",  "array_name" => "person_field_arr"),
  array("field_name" => "field_dataset_owner",        "tag_name" => "owner",      "array_name" => "person_field_arr"),
  array("field_name" => "field_dataset_site_ref",     "tag_name" => "site",       "array_name" => "site_field_arr")
);

/*
"data_file"
*/
// "field_dataset_datafile_ref",
$data_file_field_arr = array(
    "field_datafile_date"         => "field_datafile_date",
    "field_datafile_description"  => "field_datafile_description",
    "field_datafile_name"         => "field_datafile_name",
    "field_data_file"             => "field_data_file",
    "field_delimiter"             => "field_delimiter",
    "field_method_description"    => "field_method_description",
    "field_num_footer_lines"      => "field_num_footer_lines",
    "field_num_header_line"       => "field_num_header_line",
    "field_orientation"           => "field_orientation",
    "field_quality_control"       => "field_quality_control",
    "field_quote_character"       => "field_quote_character",
    "field_record_delimiter"      => "field_record_delimiter",
    "field_sampling_description"  => "field_sampling_description"
);
$data_file_field_ref_arr = array(
  "field_datafile_site_ref"     => "field_datafile_site_ref",
  "field_datafile_variable_ref" => "field_datafile_variable_ref"
);               

$data_file_field_ref_hash = array(
  array("field_name" => "field_datafile_variable_ref",  "tag_name" => "variables",  "array_name" => "var_field_arr"),
  array("field_name" => "field_datafile_site_ref",      "tag_name" => "site",       "array_name" => "site_field_arr")
);

/*
"variable"
*/
// "field_datafile_variable_ref"      
$var_field_arr = array(
  "field_var_name"                  => "field_var_name_name",
// "field_attribute_assoc_datafile"  => "field_attribute_assoc_datafile", Referrers
  "field_attribute_formatstring"    => "field_attribute_formatstring",
  "field_attribute_label"           => "field_attribute_label",
  "field_attribute_maximum"         => "field_attribute_maximum",
  "field_attribute_minimum"         => "field_attribute_minimum",
  "field_attribute_precision"       => "field_attribute_precision",
  "field_attribute_unit"            => "field_attribute_unit",
  "field_code_definition"           => "field_code_definition",
  "field_var_definition"            => "field_var_definition",
  "field_var_missingvalues"         => "field_var_missingvalues"
);
/*
"research_site"
*/
$site_field_arr = array(
  "field_research_site_climate"     => "field_research_site_climate",
  "field_research_site_elevation"   => "field_research_site_elevation",
  "field_research_site_geology"     => "field_research_site_geology",
  "field_research_site_history"     => "field_research_site_history",
  "field_research_site_hydrology"   => "field_research_site_hydrology",
  "field_research_site_landform"    => "field_research_site_landform",
  "field_research_site_pt_coords"   => "field_research_site_pt_coords",
  "field_research_site_siteid"      => "field_research_site_siteid",
  "field_research_site_soils"       => "field_research_site_soils",
  "field_research_site_vegetation"  => "field_research_site_vegetation"  
);
/*
"person"
*/           
// "field_dataset_datamanager_ref",
// "field_dataset_fieldcrew_ref",
// "field_dataset_labcrew_ref",
$person_field_arr = array(
  "field_person_first_name"   => "field_person_first_name",
  "field_person_last_name"    => "field_person_last_name",
  "field_person_title"        => "field_person_title",
  "field_person_address"      => "field_person_address",
  "field_person_city"         => "field_person_city",
  "field_person_state"        => "field_person_state",
  "field_person_country"      => "field_person_country",
  "field_person_zipcode"      => "field_person_zipcode",
  "field_person_email"        => "field_person_email",
  "field_person_fax"          => "field_person_fax",
  "field_person_organization" => "field_person_organization",
  "field_person_personid"     => "field_person_personid",
  "field_person_phone"        => "field_person_phone",
// "field_person_dataset"      => "field_person_dataset", Referrers
// "field_person_proj"         => "field_person_proj",    Referrers
  "field_person_role"         => "field_person_role",
);
$person_field_ref_arr = array(
  "field_person_user"         => "field_person_user"
);
/*
"research_project"
*/               
$research_project_field_arr = array(
  "field_project_description"     => "field_project_description"
);
$research_project_field_ref_arr = array(
  "field_research_project_data"   => "field_research_project_data",
  "field_research_project_invest" => "field_research_project_invest",
  "field_research_project_sites"  => "field_research_project_sites"
  );
  
print '<?xml version="1.0" encoding="UTF-8" ?>';
$drupal_node_flag = 0;
?>

<eml:eml xmlns:eml="eml://ecoinformatics.org/eml-2.0.1" xmlns:stmml="http://www.xml-cml.org/schema/stmml" xmlns:sw="eml://ecoinformatics.org/software-2.0.1" xmlns:cit="eml://ecoinformatics.org/literature-2.0.1" xmlns:ds="eml://ecoinformatics.org/dataset-2.0.1" xmlns:prot="eml://ecoinformatics.org/protocol-2.0.1" xmlns:doc="eml://ecoinformatics.org/documentation-2.0.1" xmlns:res="eml://ecoinformatics.org/resource-2.0.1" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="eml://ecoinformatics.org/eml-2.0.1 eml.xsd" packageId="knb-lter-pie.3.6" system="knb">

<?php foreach ($themed_rows as $count => $row): 
/* Dataset
*/
      print_open_tag("Dataset");
        foreach ($row as $field => $content):         
          $node = node_load($content);
          // print out "direct" values
          print_values($data_set_field_arr, $node, $drupal_node_attr);  
                   
          foreach (array_values($data_set_field_ref_hash) as $val) {
            // print "------- !!! -----------";
            print_flat_ref_value($val[field_name], $val[tag_name], $node, ${$val[array_name]}, $drupal_node_attr);
          }                        
          
          dpr($data_set_field_ref_hash);

          // TODO: for all "print_flat_ref_value" move label names, field names and array names into one "config" array in the beginning of the file.
          // go to refs and print its values and refs out         

          // print_flat_ref_value("field_dataset_datafile_ref", "data_file", $node, $data_file_field_arr, $drupal_node_attr);
          $tag_name   = "datafile_ref";
          $field_name = "field_dataset_datafile_ref";
          $field_arr  = $data_file_field_arr;
          print_open_tag($tag_name);
          $field_value = $node->$field_name;
          foreach ($field_value as $key1 => $value1){
            foreach ($value1 as $key2 => $value2){
              $ref_node = node_load($value2);
              print_values($field_arr, $ref_node, $drupal_node_attr);
              print_flat_ref_value("field_datafile_site_ref",      "sites",     $ref_node, $site_field_arr, $drupal_node_attr);
              print_flat_ref_value("field_datafile_variable_ref",  "variables", $ref_node, $var_field_arr,  $drupal_node_attr);
            }
          }
          print_close_tag($tag_name);

        endforeach; //($row as $field => $content)
        print_close_tag("Dataset");
      endforeach; //($themed_rows as $count => $row)
      print_close_tag("eml:eml");
?>
