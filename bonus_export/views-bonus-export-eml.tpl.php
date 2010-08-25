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

function print_all_fields($field_arr, $node) {
  // dpr($node);
  foreach ($field_arr as &$value) {
    $label = $value;
    print_open_tag($label);
    $a = $node->$value;
    foreach ($a as $key1 => $value1){
      foreach ($value1 as $key2 => $value2){
        print_tag_line($key2, $value2);                 
      }
    }
    print_close_tag($label);
  }
}

$dataset_arr = array("nid", 
  "field_abstract", 
  "field_beg_end_date", 
  "field_dataset_add_info", 
  "field_dataset_assct_biblio", 
  "field_dataset_contact", 
  "field_dataset_ext_assoc", 
  "field_dataset_id", 
  "field_dataset_instrument", 
  "field_dataset_maintenance", 
  "field_dataset_methods", 
  "field_dataset_owner", 
  "field_dataset_purpose", 
  "field_dataset_quality", 
  "field_dataset_sevid", 
  "field_publication_date", 
  "field_short_name"
  // "field_dataset_datafile_ref", 
  // "field_dataset_datamanager_ref", 
  // "field_dataset_fieldcrew_ref", 
  // "field_dataset_labcrew_ref", 
  // "field_dataset_site_ref", 
  // "field_var_ref"
);


$datafile_arr = array("nid",
  "vid",
  "field_datafile_date", 
  "field_datafile_description", 
  "field_datafile_name", 
  // "field_datafile_site_ref", 
  // "field_datafile_variable_ref", 
  "field_data_file", 
  "field_delimiter", 
  "field_method_description", 
  "field_num_footer_lines", 
  "field_num_header_line", 
  "field_orientation", 
  "field_quality_control", 
  "field_quote_character", 
  "field_record_delimiter", 
  "field_sampling_description"
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
          print_all_fields($dataset_arr, $node);
          if($node->type == "data_set"):
            $datafiles_ref = $node->field_dataset_datafile_ref;  
            print_open_tag("datafiles");
            foreach ($datafiles_ref as &$datafile):   
              print_open_tag("datafile");
              $datafile_nid = $datafile[nid];      
              $datafiles    = node_load($datafile_nid);
              print_all_fields($datafile_arr, $datafiles);
              $vars  = $datafiles->field_datafile_variable_ref;     
              $label = "DatafileNid";
              print_tag_line($label, $datafiles->nid); 
              print_open_tag("variables");              
              foreach ($vars as &$var):    
                print_open_tag("variable");              
                unset($var_nid);
                $var_node = node_load($var[nid]);
                $var_nid  = $var[nid];
                $label    = "VarNid";
                print_tag_line($label, $var_nid); 
                $maximum  = $var_node->field_attribute_maximum[0][value];   
                $label    = "maximum";
                print_tag_line($label, $maximum); 
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
