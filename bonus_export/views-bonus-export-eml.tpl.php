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
    "field_dataset_abstract" 					=> "abstract",
    "field_dataset_short_name" 				=> "shortName",
    "field_dataset_id" 					      => "field_dataset_id",
    "field_dataset_purpose" 					=> "purpose",
    "field_dataset_add_info" 					=> "additionalInfo",
  "field_dataset_related_links"       => "related_links",
    "field_dataset_maintenance"       => "maintenance",
    "field_dataset_publication_date"  => "pubDate",
    "field_beg_end_date" 		       		=> "field_beg_end_date",
    "field_methods" 					        => "methodStep",
    "field_instrumentation" 					=> "instrumentation",
    "field_quality" 					        => "qualityControl"
);
$data_set_field_ref_arr = array(
    "field_dataset_datafile_ref"  => "data_file",
  // "field_dataset_biblio_ref" => "biblio_ref",
    "field_dataset_owner_ref"     => "owner",
    "field_dataset_contact_ref"   => "contact",
  "field_dataset_datamanager_ref" => "data_manager",
  "field_dataset_fieldcrew_ref"   => "field_crew",
  "field_dataset_labcrew_ref"     => "labcrew",
    "field_dataset_ext_assoc_ref" => "ext_assoc",
    "field_dataset_site_ref"      => "site"
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
    "field_datafile_description"  => "entityDescription",
    "field_data_file"             => "field_data_file",
    "field_num_header_line"       => "numHeaderLines",
    "field_num_footer_lines"      => "numFooteLines",
    "field_orientation"           => "attributeOrientation",
    "field_quote_character"       => "field_quote_character",
    "field_delimiter"             => "fieldDelimiter",
    "field_record_delimiter"      => "field_record_delimiter",
  "field_beg_end_date"            => "field_beg_end_date",
    "field_methods"               => "methodStep",
  "field_instrumentation"         => "field_instrumentation",
    "field_quality"               => "qualityControl"
);
$data_file_field_ref_arr = array(
  "field_datafile_site_ref"     => "datafile_site",
  "field_datafile_variable_ref" => "variables"
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
    "field_attribute_label" 			  => "attributeLabel",
  "field_var_definition" 			      => "definition",
    "field_var_missingvalues" 			=> "missingValues",
    "field_attribute_unit" 			    => "unit",
    "field_attribute_maximum" 			=> "maximum",
    "field_attribute_minimum" 			=> "minimum",
    "field_attribute_precision" 		=> "precision",
    "field_attribute_formatstring"  => "formatstring",
    "field_code_definition"         => "codeDefinition"
);

// "field_attribute_assoc_datafile" => "assoc_datafile", // "nodereferrer"

/*
"research_site"
*/
$site_field_arr = array(
  "field_research_site_image"       => "field_research_site_image",
    "field_research_site_pt_coords"   => "field_research_site_pt_coords",
    "field_research_site_elevation"   => "elevation",
    "field_research_site_landform"    => "field_research_site_landform",
    "field_research_site_geology"     => "field_research_site_geology",
    "field_research_site_soils"       => "field_research_site_soils",
    "field_research_site_hydrology"   => "field_research_site_hydrology",
    "field_research_site_vegetation"  => "field_research_site_vegetation",
    "field_research_site_climate"     => "field_research_site_climate",
    "field_research_site_history"     => "field_research_site_history",
  "field_research_site_siteid"      => "field_research_site_siteid"
);
/*
"person"
*/           
$person_field_arr = array(
  "field_person_first_name"   => "givenName",
  "field_person_last_name"    => "surname",
  "field_person_organization" => "organization",
  "field_person_role"         => "role",
  "field_person_title"        => "field_person_title",
  "field_person_email"        => "electronicMailAddress",
  "field_person_address"      => "deliveryPoint",
  "field_person_city"         => "city",
  "field_person_state"        => "administrativeArea",
  "field_person_zipcode"      => "postalCode",
  "field_person_country"      => "country",
  "field_person_phone"        => "phone",
  "field_person_fax"          => "fax",
  "field_person_personid"     => "personid"
);

// "field_person_pubs" => "field_person_pubs",
// "nodereference"

$person_field_ref_arr = array(
  "field_person_user"         => "field_person_user"
);
// ref to biblio, do we need put it in eml?

/*
"research_project"
*/               
$research_project_field_arr = array(
  "field_project_description"     => "field_project_description"
);

$research_project_field_ref_arr = array(
  "field_research_project_invest"   => "field_research_project_invest",
  "field_research_project_data"     => "field_research_project_data",
  "field_research_project_sites"    => "field_research_project_sites",
  "field_research_project_funding"  => "field_research_project_funding"
);


  
print '<?xml version="1.0" encoding="UTF-8" ?>';
$drupal_node_flag = 0;
?>

<eml:eml xmlns:eml="eml://ecoinformatics.org/eml-2.0.1" xmlns:stmml="http://www.xml-cml.org/schema/stmml" xmlns:sw="eml://ecoinformatics.org/software-2.0.1" xmlns:cit="eml://ecoinformatics.org/literature-2.0.1" xmlns:ds="eml://ecoinformatics.org/dataset-2.0.1" xmlns:prot="eml://ecoinformatics.org/protocol-2.0.1" xmlns:doc="eml://ecoinformatics.org/documentation-2.0.1" xmlns:res="eml://ecoinformatics.org/resource-2.0.1" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="eml://ecoinformatics.org/eml-2.0.1 eml.xsd" packageId="knb-lter-pie.3.6" system="knb">

<?php 
//======================= collect data =====================================
print_open_tag("start");         
$all_info = array();

function collect_array($double_arr, $info_array) {
  $arr    = array();
  foreach ($double_arr as $key => $value){
    // take group tag
    // $tag = $key;
    // check if we'll go recursively   
    // print "\$key = ".$key.", \$value = ".$value."<br/>";
    // $arr[$key] = $value;   
    // $arr = array($key, $value);
    $info_array1[] = array($key => $value);
    // $info_array = array($row_0, $row_1, $row_2);
    if (is_array($value)) {
      // print group tag
      // if ($tag) {
      //   print_open_tag($tag);
      //   $flag = 1;
      // }
      // if not end value, go through array again
      collect_array($value);
    }
    // else {
    //   // print out taged value
    //   // $key == "value" ? print $value : print_tag_line($key, $value);
    //   $dataset_info[$key]=$value;
    //   // if tag <value></value> is needed, than change the line above with "print_tag_line($key, $value);"
    // }
    // if ($flag == 1) {
    //   print_close_tag($tag);
    //   $flag = 0;
    // }
  }        
  dpr($info_array1);    
  return $info_array1;
}


// take node_ids
foreach ($themed_rows as $count => $row):
  // take dataset node from id
  foreach ($row as $field => $content):         
    $dataset_node = node_load($content);      
    $dataset_info['title'] = $dataset_node->title;
    foreach ($data_set_field_arr as $field_name => $tag_name):
       // foreach ($dataset_node->$field_name as $val):               
         $field_value = $dataset_node->$field_name;
         $dataset_info1 = collect_array($field_value, $dataset_info);
         // through_array($field_value);
            // dpr($field_value);
           // $dataset_info[$field_name] = $val1;
         // endforeach; //$dataset_node->$field_name -> value
       // endforeach; //$dataset_node->$field_name
     endforeach; //data_set_field_arr
      //   print_values($data_set_field_arr, $node, $drupal_node_attr);  
    // dpr($node);
  endforeach; //dataset node
endforeach; //dataset node ids     
dpr($dataset_info1);

print_close_tag("start");
// foreach ($row as $field => $content):         
//   $node = node_load($content);
//   // print out "direct" values
//   print_values($data_set_field_arr, $node, $drupal_node_attr);  
//   $all_info = array();
//   // $all_info = like print_values, but only store them in $all_info
//   // and add info for all ref
//            // dpr($node->field_dataset_owner_ref);
//            // dpr($node->field_dataset_contact_ref);
//              $datamanager = $node->field_dataset_datamanager_ref;
//              $datamanager_id = $datamanager[0][nid]; //(take id foreach $datamanager)
//              $person_node = node_load($datamanager_id);
//              $person_all_info = array();
//              foreach ($person_field_arr as $field_name => $tag_name) {
//                  foreach ($person_node->$field_name as $val) {
//                    // dpr($val);
//                    // if $val1 is array go through again (collect "organization", f.e.)
//                    foreach ($val as $val1) {
//                      $person_all_info[$field_name] = $val1;
//                      // dpr($val1); //->field_person_first_name
//                    }
//                }
//                
//              }
//              $all_info["datamanager"] = $person_all_info;
//              dpr($person_all_info["field_person_organization"]);
//              // field_person_organization - Array
//              
//              // dpr($person_node); //->field_person_first_name
//            //   dpr($person_node->title); //->field_person_first_name
//            //   //put here all fields from person_fields array
//            //   foreach ($person_node->field_person_first_name as $val) {
//            //     dpr($val);
//            //     foreach ($val as $val1) {
//            //       $person_all_info['field_person_first_name'] = $val1;
//            //       dpr($val1); //->field_person_first_name
//            //     }
//            // }
//            dpr($all_info);
//            // dpr($node->field_dataset_fieldcrew_ref);
//            // dpr($node->field_dataset_labcrew_ref);
//            // dpr($node->field_dataset_ext_assoc_ref);                   
//            //==================================



foreach ($themed_rows as $count => $row): 
/* Dataset
*/
      print_open_tag("Dataset");
        foreach ($row as $field => $content):         
          $node = node_load($content);
          // print out "direct" values
          print_values($data_set_field_arr, $node, $drupal_node_attr);  
          //==================================
          $all_info = array();
          // $all_info = like print_values, but only store them in $all_info
          // and add info for all ref
                   // dpr($node->field_dataset_owner_ref);
                   // dpr($node->field_dataset_contact_ref);
                     $datamanager = $node->field_dataset_datamanager_ref;
                     $datamanager_id = $datamanager[0][nid]; //(take id foreach $datamanager)
                     $person_node = node_load($datamanager_id);
                     $person_all_info = array();
                     foreach ($person_field_arr as $field_name => $tag_name) {
                         foreach ($person_node->$field_name as $val) {
                           // dpr($val);
                           // if $val1 is array go through again (collect "organization", f.e.)
                           foreach ($val as $val1) {
                             $person_all_info[$field_name] = $val1;
                             // dpr($val1); //->field_person_first_name
                           }
                       }
                       
                     }
                     $all_info["datamanager"] = $person_all_info;
                     // dpr($person_all_info["field_person_organization"]);
                     // field_person_organization - Array
                     
                     // dpr($person_node); //->field_person_first_name
                   //   dpr($person_node->title); //->field_person_first_name
                   //   //put here all fields from person_fields array
                   //   foreach ($person_node->field_person_first_name as $val) {
                   //     dpr($val);
                   //     foreach ($val as $val1) {
                   //       $person_all_info['field_person_first_name'] = $val1;
                   //       dpr($val1); //->field_person_first_name
                   //     }
                   // }
                   // dpr($all_info);
                   // dpr($node->field_dataset_fieldcrew_ref);
                   // dpr($node->field_dataset_labcrew_ref);
                   // dpr($node->field_dataset_ext_assoc_ref);                   
                   //==================================
                   
          foreach (array_values($data_set_field_ref_hash) as $val) {
            // print "------- !!! -----------";
            print_flat_ref_value($val[field_name], $val[tag_name], $node, ${$val[array_name]}, $drupal_node_attr);
          }                        
          
          // dpr($data_set_field_ref_hash);

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
