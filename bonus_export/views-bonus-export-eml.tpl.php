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
      // $key == "value" ? print $value : print_tag_line($key, $value);
      // if tag <value></value> is needed, than change the line above with "print_tag_line($key, $value);"
      print_tag_line($key, $value);
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

function print_tag_val($tag, $value) {
  print_open_tag($tag);
  through_array($value);
  print_close_tag($tag);
}                       

function print_value($tag, $arr) {
  foreach ($arr as $in_arr) {
    print_tag_line($tag, $in_arr['value']);          
  }
}
/*
To change tag label change value in right coulmn
*/    
          
// do not print out value of those:
$drupal_node_attr = array(
  "body"      => "body",
  "changed"   => "changed",
  "comment"   => "comment",
  "comment_count"            => "comment_count",
  "created"   => "created",
  "data"      => "data",
  "format"    => "format",
  "language"  => "language",
  "last_comment_name"        => "last_comment_name",
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
  "taxonomy"                => "taxonomy",
  "teaser"    => "teaser",
  "themekey_ui_theme"        => "themekey_ui_theme",
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
  "name"              => "name",
  // "pass"             => "pass",
  "mail"              => "mail",
  "mode"              => "mode",
  "sort"              => "sort",
  "threshold"         => "threshold",
  "theme"             => "theme",
  "signature"         => "signature",
  "signature_format"  => "signature_format",
  "created"            => "created",
  "access"            => "access",
  "login"              => "login",
  "status"            => "status",
  "timezone"          => "timezone",
  "language"          => "language",
  "picture"            => "picture",
  "init"              => "init",
  // "data"             => "data",
  "timezone_name"     => "timezone_name"
);
  
/*
"data_set"
*/
$data_set_field_arr = array(
    "field_dataset_abstract"           => "abstract",
    "field_dataset_short_name"         => "shortName",
    "field_dataset_id"                 => "field_dataset_id",
    "field_dataset_purpose"           => "purpose",
    "field_dataset_add_info"           => "additionalInfo",
  "field_dataset_related_links"       => "related_links",
    "field_dataset_maintenance"       => "maintenance",
    "field_dataset_publication_date"  => "pubDate",
    "field_beg_end_date"                => "field_beg_end_date",
    "field_methods"                   => "methodStep",
    "field_instrumentation"           => "instrumentation",
    "field_quality"                   => "qualityControl"
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
  // array("field_name" => "field_dataset_datafile_ref", "tag_name" => "data_file",  "array_name" => "data_file_field_arr"),
  array("field_name" => "field_dataset_owner_ref",        "tag_name" => "owner",        "array_name" => "person_field_arr"),
  array("field_name" => "field_dataset_contact_ref",      "tag_name" => "contact",      "array_name" => "person_field_arr"),
  array("field_name" => "field_dataset_datamanager_ref",  "tag_name" => "data_manager", "array_name" => "person_field_arr"),
  array("field_name" => "field_dataset_fieldcrew_ref",    "tag_name" => "field_crew",   "array_name" => "person_field_arr"),
  array("field_name" => "field_dataset_labcrew_ref",      "tag_name" => "labcrew",      "array_name" => "person_field_arr"),
  array("field_name" => "field_dataset_ext_assoc",        "tag_name" => "ext_assoc",    "array_name" => "person_field_arr"),
  array("field_name" => "field_dataset_site_ref",         "tag_name" => "site",         "array_name" => "site_field_arr")
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
    "field_quote_character"       => "QuoteCharacter",
    "field_delimiter"             => "fieldDelimiter",
    "field_record_delimiter"      => "recordDelimiter",
  "field_beg_end_date"            => "field_beg_end_date",
    "field_methods"               => "methodStep",
  "field_instrumentation"         => "field_instrumentation",
    "field_quality"               => "qualityControl"
);
$data_file_field_ref_arr = array(
  "field_datafile_variable_ref" => "variables",
  "field_datafile_site_ref"     => "site"
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
    "field_attribute_label"         => "attributeLabel",
  "field_var_definition"             => "definition",
    "field_var_missingvalues"       => "missingValues",
    "field_attribute_unit"           => "unit",
    "field_attribute_maximum"       => "maximum",
    "field_attribute_minimum"       => "minimum",
    "field_attribute_precision"     => "precision",
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

foreach ($themed_rows as $count => $row): 
/* Dataset
*/
      print_open_tag("Dataset");
        foreach ($row as $field => $content):         
          $node = node_load($content);
          // --------------------------------------
          // dpr($node);
          print_value("shortName", $node->field_dataset_short_name);
          print_tag_line("title", $node->title);          
          print_value("pubDate", $node->field_dataset_publication_date);
          print_value("abstract", $node->field_dataset_abstract);       
          print_open_tag("coverage");           
            print_open_tag("temporalCoverage");
              print_open_tag("rangeOfDates");
                foreach($node->field_beg_end_date as $dataset_date) {
                  print_open_tag("beginDate");
                    print_tag_line("calendarDate", $dataset_date["value"]);          
                  print_close_tag("beginDate");
                  print_open_tag("endDate");
                    print_tag_line("calendarDate", $dataset_date["value2"]);          
                  print_close_tag("endDate");
                }
              print_close_tag("rangeOfDates");
            print_close_tag("temporalCoverage");
          print_close_tag("coverage");
          print_value("purpose", $node->field_dataset_purpose);
          print_value("maintenance", $node->field_dataset_maintenance);

          print_open_tag("methods");
            print_open_tag("methodStep");
              print_value("instrumentation", $node->field_instrumentation);
              print_value("description", $node->field_methods);
            print_close_tag("methodStep"); 
            print_open_tag("qualityControl");
              print_value("description", $node->field_quality);
            print_close_tag("qualityControl");
          print_close_tag("methods");
         
          print_value("field_dataset_id", $node->field_dataset_id);
          print_value("additionalInfo", $node->field_dataset_add_info);
          print_value("related_links", $node->field_dataset_related_links);


          // take file
          $file_nid = $node->field_dataset_datafile_ref;
          foreach ($file_nid as $key1 => $value1){
            foreach ($value1 as $key2 => $value2){
              $file_node = node_load($value2);
              // dpr($file_node);
              print_open_tag("dataTable");
                // todo: take once and keep filename and filepath in some array to use later, should be faster
                foreach($file_node->field_data_file as $file_data) {
                  print_tag_line("entityName", $file_data["filename"]);
                }
                print_value("entityDescription", $file_node->field_datafile_description);
                print_open_tag("physical");
                  print_open_tag("dataFormat");
                    print_open_tag("textFormat");
                      print_value("numHeaderLines", $file_node->field_num_header_line);
                      print_value("numFooterLines", $file_node->field_num_footer_lines);
                      print_value("recordDelimiter", $file_node->field_record_delimiter);
                      print_value("attributeOrientation", $file_node->field_orientation);
                      print_open_tag("simpleDelimited");
                        print_value("fieldDelimiter", $file_node->field_delimiter);
                        print_value("QuoteCharacter", $file_node->field_quote_character);
                      print_close_tag("simpleDelimited");
                    print_close_tag("textFormat");
                  print_close_tag("dataFormat");
                  foreach($file_node->field_data_file as $file_data) {
                    print_open_tag("distribution");
                      print_tag_line("url", "http://www.blah-blah-blah/".$file_data["filepath"]);
                    print_close_tag("distribution");  
                  }
                print_close_tag("physical");

                print_open_tag("coverage");           
                  print_open_tag("temporalCoverage");
                    print_open_tag("rangeOfDates");
                      foreach($file_node->field_beg_end_date as $dataset_date) {
                        print_open_tag("beginDate");
                          print_tag_line("calendarDate", $dataset_date["value"]);          
                        print_close_tag("beginDate");
                        print_open_tag("endDate");
                          print_tag_line("calendarDate", $dataset_date["value2"]);          
                        print_close_tag("endDate");
                      }
                    print_close_tag("rangeOfDates");
                  print_close_tag("temporalCoverage");
                print_close_tag("coverage");

                print_open_tag("methods");
                  print_open_tag("methodStep");
                    print_value("instrumentation", $file_node->field_instrumentation);
                    print_value("description", $file_node->field_methods);
                  print_close_tag("methodStep"); 
                  print_open_tag("qualityControl");
                    print_value("description", $file_node->field_quality);
                  print_close_tag("qualityControl");
                print_close_tag("methods");

                print_open_tag("attributeList");
                  // take variables
                  $var_nid = $file_node->field_datafile_variable_ref;
                  foreach ($var_nid as $key1 => $value1){
                    foreach ($value1 as $key2 => $value2){
                      $var_node = node_load($value2);
                      print_open_tag("attribute");
                        print_tag_val("attributeName", $var_node->field_var_name);
                        print_value("attributeLabel", $var_node->field_attribute_label);
                        print_value("attributeDefinition", $var_node->field_var_definition);
                        print_open_tag("measurementScale");
                          print_open_tag("datatime");
                            print_value("formatstring", $var_node->field_attribute_formatstring);
                          print_close_tag("datatime");
                          print_open_tag("ratio");
                            print_open_tag("numericDomain");
                              print_open_tag("bounds");
                                print_value("maximum", $var_node->field_attribute_maximum);
                                print_value("minimum", $var_node->field_attribute_minimum);
                              print_close_tag("bounds");
                            print_close_tag("numericDomain");
                            print_value("precision", $var_node->field_attribute_precision);
                            print_open_tag("unit");
                              print_value("standardUnit", $var_node->field_attribute_unit);
                            print_close_tag("unit");
                          print_close_tag("ratio");
                          print_open_tag("nominal");
                            print_open_tag("nonNumericDomain");
                              print_open_tag("enumeratedDomain");
                                print_value("codeDefinition", $var_node->field_code_definition);
                              //                   code
                              //                   definition
                              print_close_tag("enumeratedDomain");
                            print_close_tag("nonNumericDomain");
                          print_close_tag("nominal");
                        print_close_tag("measurementScale");
                        print_open_tag("missingValueCode");
                          print_value("missingValues", $var_node->field_var_missingvalues);
                        //           code
                        //           value
                        print_close_tag("missingValueCode");
                      print_close_tag("attribute");
                    }
                  }                
                print_close_tag("attributeList");
              print_close_tag("dataTable");
            }
          }  
          // TODO: move repeated parts into function print_person and call 
          // take owner
          $owner_nid = $node->field_dataset_owner_ref;
          foreach ($owner_nid as $key1 => $value1){
            foreach ($value1 as $key2 => $value2){
              $owner_node = node_load($value2);      
              print_open_tag("owner");
                print_value("title",              $owner_node->field_person_title);
                print_value("givenName",          $owner_node->field_person_first_name);
                print_value("surname",            $owner_node->field_person_last_name);
                print_value("organization",       $owner_node->field_person_organization);
                print_value("role",               $owner_node->field_person_role);
                print_value("deliveryPoint",      $owner_node->field_person_address);
                print_value("city",               $owner_node->field_person_city);
                print_value("administrativeArea", $owner_node->field_person_state);
                print_value("postalCode",         $owner_node->field_person_zipcode);
                print_value("country",            $owner_node->field_person_country);
                print_value("phone",              $owner_node->field_person_phone);
                print_value("fax",                $owner_node->field_person_fax);
                foreach($owner_node->field_person_email as $email) {
                  print_tag_line("electronicMailAddress", $email["email"]);
                }
                print_value("personid",           $owner_node->field_person_personid);              
            }
            print_close_tag("owner");
          }
          
          // array("field_name" => "field_dataset_contact_ref",      "tag_name" => "contact",      "array_name" => "person_field_arr"),
          // take contact
          $contact_nid = $node->field_dataset_contact_ref;
          foreach ($contact_nid as $key1 => $value1){
            foreach ($value1 as $key2 => $value2){
              $contact_node = node_load($value2);
              print_open_tag("contact");
              print_close_tag("contact");
            }
          }
          // array("field_name" => "field_dataset_datamanager_ref",  "tag_name" => "data_manager", "array_name" => "person_field_arr"),
          // take data_manager
          $datamanager_nid = $node->field_dataset_datamanager_ref;
          foreach ($datamanager_nid as $key1 => $value1){
            foreach ($value1 as $key2 => $value2){
              $datamanager_node = node_load($value2);
              print_open_tag("data_manager");
              print_close_tag("data_manager");
            }
          }
          // array("field_name" => "field_dataset_fieldcrew_ref",    "tag_name" => "field_crew",   "array_name" => "person_field_arr"),
          // take field_crew
          $fieldcrew_nid = $node->field_dataset_fieldcrew_ref;
          foreach ($fieldcrew_nid as $key1 => $value1){
            foreach ($value1 as $key2 => $value2){
              $fieldcrew_node = node_load($value2);
              print_open_tag("field_crew");
              print_close_tag("field_crew");
            }
          }
          // array("field_name" => "field_dataset_labcrew_ref",      "tag_name" => "labcrew",      "array_name" => "person_field_arr"),
          // take labcrew
          $labcrew_nid = $node->field_dataset_labcrew_ref;
          foreach ($labcrew_nid as $key1 => $value1){
            foreach ($value1 as $key2 => $value2){
              $labcrew_node = node_load($value2);
              print_open_tag("labcrew");
              print_close_tag("labcrew");
            }
          }
          // array("field_name" => "field_dataset_ext_assoc",        "tag_name" => "ext_assoc",    "array_name" => "person_field_arr"),
          // take ext_assoc
          $ext_assoc_nid = $node->field_dataset_ext_assoc_ref;
          foreach ($ext_assoc_nid as $key1 => $value1){
            foreach ($value1 as $key2 => $value2){
              $ext_assoc_node = node_load($value2);
              print_open_tag("ext_assoc");
              print_close_tag("ext_assoc");
            }
          }
          // array("field_name" => "field_dataset_site_ref",         "tag_name" => "site",         "array_name" => "site_field_arr")
          // take research_site
          $research_site_nid = $node->field_dataset_site_ref;
          foreach ($research_site_nid as $key1 => $value1){
            foreach ($value1 as $key2 => $value2){
              $research_site_node = node_load($value2);
              print_open_tag("research_site");
                print_open_tag("image");
                print_close_tag("image");
                print_open_tag("pt_coords");
                print_close_tag("pt_coords");
                print_open_tag("elevation");
                print_close_tag("elevation");
                print_open_tag("landform");
                print_close_tag("landform");
                print_open_tag("geology");
                print_close_tag("geology");
                print_open_tag("soils");
                print_close_tag("soils");
                print_open_tag("hydrology");
                print_close_tag("hydrology");
                print_open_tag("vegetation");
                print_close_tag("vegetation");
                print_open_tag("climate");
                print_close_tag("climate");
                print_open_tag("history");
                print_close_tag("history");
                print_open_tag("siteid");
                print_close_tag("siteid");
                
              // dpr($research_site_node);
                // print_value("image",      $research_site_node->field_research_site_image);       
                // print_value("pt_coords",  $research_site_node->field_research_site_pt_coords);   
                // print_value("elevation",  $research_site_node->field_research_site_elevation);   
                // print_value("landform",   $research_site_node->field_research_site_landform);    
                // print_value("geology",    $research_site_node->field_research_site_geology);     
                // print_value("soils",      $research_site_node->field_research_site_soils);       
                // print_value("hydrology",  $research_site_node->field_research_site_hydrology);   
                // print_value("vegetation", $research_site_node->field_research_site_vegetation);  
                // print_value("climate",    $research_site_node->field_research_site_climate);     
                // print_value("history",    $research_site_node->field_research_site_history);     
                // print_value("siteid",     $research_site_node->field_research_site_siteid);      
              print_close_tag("research_site");
            }
          }

          //  "field_datafile_date" => "field_datafile_date", 
          // //ISG changed ckkField, reusing previous file(PATH eml/dataset/dataTable/coverage/temporalCoverage)

          // --------------------------------------


          // // print out "direct" values:
          // print_values($data_set_field_arr, $node, $drupal_node_attr);  
          // 
          // // print out references:
          // //datafile going differently, because of variables as subref
          // // print_flat_ref_value("field_dataset_datafile_ref", "data_file", $node, $data_file_field_arr, $drupal_node_attr);
          // $tag_name   = "datafile_ref";
          // $field_name = "field_dataset_datafile_ref";
          // $field_arr  = $data_file_field_arr;
          // print_open_tag($tag_name);
          // $field_value = $node->$field_name;
          // foreach ($field_value as $key1 => $value1){
          //   foreach ($value1 as $key2 => $value2){
          //     $ref_node = node_load($value2);
          //     print_values($field_arr, $ref_node, $drupal_node_attr);
          //     print_flat_ref_value("field_datafile_site_ref",      "sites",     $ref_node, $site_field_arr, $drupal_node_attr);
          //     print_flat_ref_value("field_datafile_variable_ref",  "variables", $ref_node, $var_field_arr,  $drupal_node_attr);
          //   }
          // }
          // print_close_tag($tag_name);
          // 
          // // print out all other references:
          // foreach (array_values($data_set_field_ref_hash) as $val) {
          //   print_flat_ref_value($val[field_name], $val[tag_name], $node, ${$val[array_name]}, $drupal_node_attr);
          // }                        
          // 

        endforeach; //($row as $field => $content)
        print_close_tag("Dataset");
      endforeach; //($themed_rows as $count => $row)
      print_close_tag("eml:eml");
?>
