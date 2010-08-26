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
        
function print_node_attr($node, $drupal_node_attr) {
  $label = "drupal_node_attr";
  print_open_tag($label);
  foreach ($drupal_node_attr as $field_name => $tag_name) {
    print_tag_line($field_name, $node->$field_name);                 
  }
  print_close_tag($label);
}

function print_all_fields($field_arr, $node, $drupal_node_attr) {     
  // Uncomment the next line if drupal node attributes have to be printed out
  // print_node_attr($node, $drupal_node_attr);
  foreach ($field_arr as $field_name => $tag_name) {
    print_open_tag($tag_name);
    $a = $node->$field_name;
    foreach ($a as $key1 => $value1){
      foreach ($value1 as $key2 => $value2){  
        $key2 == "value" ? print $value2
        : print_tag_line($key2, $value2);
        // 
        // print_tag_line($key2, $value2);                 
      }
    }
    print_close_tag($tag_name);
  }
}           

/*
To change tag label change value in right coulmn
*/    

$drupal_node_attr = array(
  "nid"       => "nid",
  "type"      => "type",
  "language"  => "language",
  "uid"       => "uid",
  "status"    => "status",
  "created"   => "created",
  "changed"   => "changed",
  "comment"   => "comment",
  "promote"   => "promote",
  "moderate"  => "moderate",
  "sticky"    => "sticky",
  "tnid"      => "tnid",
  "translate" => "translate",
  "vid"       => "vid",
  "revision_uid" => "revision_uid",
  "title"     => "title",
  "body"      => "body",
  "teaser"    => "teaser",
  "log"       => "log",
  "revision_timestamp" => "revision_timestamp",
  "format"    => "format",
  "name"      => "name",
  "picture"   => "picture",
  "data"      => "data"
  );
             
/*
"data_set"
*/
$data_set_field_arr = array(
  "field_abstract"              => "field_abstract",
  "field_beg_end_date"          => "field_beg_end_date",
  "field_dataset_add_info"      => "field_dataset_add_info",
  "field_dataset_assct_biblio"  => "field_dataset_assct_biblio",
  "field_dataset_contact"       => "field_dataset_contact",
  "field_dataset_ext_assoc"     => "field_dataset_ext_assoc",
  "field_dataset_id"            => "field_dataset_id",
  "field_dataset_instrument"    => "field_dataset_instrument",
  "field_dataset_maintenance"   => "field_dataset_maintenance",
  "field_dataset_methods"       => "field_dataset_methods",
  "field_dataset_owner"         => "field_dataset_owner",
  "field_dataset_purpose"       => "field_dataset_purpose",
  "field_dataset_quality"       => "field_dataset_quality",
  "field_dataset_sevid"         => "field_dataset_sevid",
  "field_publication_date"      => "field_publication_date",
  "field_short_name"            => "field_short_name"
  // "field_dataset_datafile_ref", 
  // "field_dataset_datamanager_ref", 
  // "field_dataset_fieldcrew_ref", 
  // "field_dataset_labcrew_ref", 
  // "field_dataset_site_ref", 
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
  // "field_datafile_site_ref", 
  // "field_datafile_variable_ref"
  ); 
                              
/*
"variable"
*/
// "field_datafile_variable_ref"      
$var_field_arr = array(
  "field_var_name"                  => "field_var_name_name",
  "field_attribute_assoc_datafile"  => "field_attribute_assoc_datafile", 
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
// "field_datafile_site_ref", 
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
  "field_person_dataset"      => "field_person_dataset",
  "field_person_proj"         => "field_person_proj",
  "field_person_role"         => "field_person_role",
  "field_person_user"         => "field_person_user"
);   
  
/*
"research_project"
*/               
$research_project_field_arr = array(
  "field_project_description"     => "field_project_description", 
  "field_research_project_data"   => "field_research_project_data", 
  "field_research_project_invest" => "field_research_project_invest", 
  "field_research_project_sites"  => "field_research_project_sites"
  );

print '<?xml version="1.0" encoding="UTF-8" ?>';
?>

<eml:eml xmlns:eml="eml://ecoinformatics.org/eml-2.0.1" xmlns:stmml="http://www.xml-cml.org/schema/stmml" xmlns:sw="eml://ecoinformatics.org/software-2.0.1" xmlns:cit="eml://ecoinformatics.org/literature-2.0.1" xmlns:ds="eml://ecoinformatics.org/dataset-2.0.1" xmlns:prot="eml://ecoinformatics.org/protocol-2.0.1" xmlns:doc="eml://ecoinformatics.org/documentation-2.0.1" xmlns:res="eml://ecoinformatics.org/resource-2.0.1" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="eml://ecoinformatics.org/eml-2.0.1 eml.xsd" packageId="knb-lter-pie.3.6" system="knb">

<?php foreach ($themed_rows as $count => $row): 
/* Dataset
*/
      print_open_tag("Dataset");
        foreach ($row as $field => $content):          
          $node = node_load($content);
          print_all_fields($data_set_field_arr, $node, $drupal_node_attr);
          if($node->type == "data_set"):
            $datafiles_ref = $node->field_dataset_datafile_ref;  
            print_open_tag("datafiles");
            foreach ($datafiles_ref as &$datafile):   
              print_open_tag("datafile");
              $datafile_nid = $datafile[nid];      
              $datafiles    = node_load($datafile_nid);   
              // dpr($datafiles);
              print_all_fields($data_file_field_arr, $datafiles, $drupal_node_attr);
              $vars  = $datafiles->field_datafile_variable_ref;     
              $label = "DatafileNid";
              print_tag_line($label, $datafiles->nid); 
              print_open_tag("variables");              
              foreach ($vars as &$var):    
                print_open_tag("variable");   
                unset($var_nid);
                $var_node = node_load($var[nid]);
                print_all_fields($var_field_arr, $var_node, $drupal_node_attr);   
                // $var_nid  = $var[nid];
                // $label    = "VarNid";
                // print_tag_line($label, $var_nid); 
                // $maximum  = $var_node->field_attribute_maximum[0][value];   
                // $label    = "maximum";
                // print_tag_line($label, $maximum); 
                print_close_tag("variable");              
              endforeach; //($vars as &$var)
              unset($datafiles);
              print_close_tag("variables");              
              print_close_tag("datafile");              
            endforeach; //($datafiles_ref as &$datafile)
            print_close_tag("datafiles");              
          endif; //($type == "data_set")
        endforeach; //($row as $field => $content)
        print_close_tag("Dataset");              
      endforeach; //($themed_rows as $count => $row)
      print_close_tag("eml:eml");              
?>
