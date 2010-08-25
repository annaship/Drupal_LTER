<?php
// $Id: views-bonus-export-eml.tpl.php,v 1.2 2009/06/24 17:27:53 neclimdul Exp $
/**
 * Template to display a view as an eml.
 * TODO: 
 * 1) add all tags
 * 2) 
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
 
print '<?xml version="1.0" encoding="UTF-8" ?>';
?>

<eml:eml xmlns:eml="eml://ecoinformatics.org/eml-2.0.1" xmlns:stmml="http://www.xml-cml.org/schema/stmml" xmlns:sw="eml://ecoinformatics.org/software-2.0.1" xmlns:cit="eml://ecoinformatics.org/literature-2.0.1" xmlns:ds="eml://ecoinformatics.org/dataset-2.0.1" xmlns:prot="eml://ecoinformatics.org/protocol-2.0.1" xmlns:doc="eml://ecoinformatics.org/documentation-2.0.1" xmlns:res="eml://ecoinformatics.org/resource-2.0.1" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="eml://ecoinformatics.org/eml-2.0.1 eml.xsd" packageId="knb-lter-pie.3.6" system="knb">

<?php foreach ($themed_rows as $count => $row): 
/* Dataset
field_abstract
field_beg_end_date
field_dataset_add_info
field_dataset_assct_biblio
field_dataset_contact
field_dataset_datafile_ref
field_dataset_datamanager_ref
field_dataset_ext_assoc
field_dataset_fieldcrew_ref
field_dataset_id
field_dataset_instrument
field_dataset_labcrew_ref
field_dataset_maintenance
field_dataset_methods
field_dataset_owner
field_dataset_purpose
field_dataset_quality
field_dataset_sevid
field_dataset_site_ref
field_publication_date
field_short_name
field_var_ref
*/
      print_open_tag("Dataset");
        foreach ($row as $field => $content):
          $field_arr = array("nid", 
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
          "field_short_name");
          foreach ($field_arr as &$value) {
            $label = $value;
            // print_r($value);
          }
          
          $label = "DatasetId";
          print_tag_line($label, $content); 
          $node = node_load($content);
          if($node->type == "data_set"):
            $datafiles = $node->field_dataset_datafile_ref;   
            print_open_tag("datafiles");
            foreach ($datafiles as &$datafile):   
              print_open_tag("datafile");
              $datafile_nid = $datafile[nid];      
              $dd    = node_load($datafile_nid);
              $vars  = $dd->field_datafile_variable_ref;     
              $label = "DatafileNid";
              print_tag_line($label, $dd->nid); 
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
              unset($dd);
              print_close_tag("variables");              
              print_close_tag("datafile");              
            endforeach; //($datafiles as &$datafile)
            print_close_tag("datafiles");              
          endif; //($type == "data_set")
        endforeach; //($row as $field => $content)
        print_close_tag("Dataset");              
      endforeach; //($themed_rows as $count => $row)
      print_close_tag("eml:eml");              
?>
