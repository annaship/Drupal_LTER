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
    print '<'.$label.'>'.strip_tags($content).'</'.$label.'>';
}

function print_open_tag($tag) {
  print '<'.$tag.'>';
}

function print_close_tag($tag) {
  print '</'.$tag.'>';
}
                               
function print_value($tag, $arr) {
  foreach ($arr as $in_arr) {
    print_tag_line($tag, strip_tags($in_arr['value'], "<p>"));
  }
}

function print_person($ref_field_arr, $person_tag)
{                                                         
  foreach ($ref_field_arr as $key1 => $value1){
    foreach ($value1 as $key2 => $value2){
      $person_node = node_load($value2);      
      print_open_tag($person_tag);
        print_value("title",              $person_node->field_person_title);
        print_value("givenName",          $person_node->field_person_first_name);
        print_value("surname",            $person_node->field_person_last_name);
        print_value("organization",       $person_node->field_person_organization);
        print_value("role",               $person_node->field_person_role);
        print_value("deliveryPoint",      $person_node->field_person_address);
        print_value("city",               $person_node->field_person_city);
        print_value("administrativeArea", $person_node->field_person_state);
        print_value("postalCode",         $person_node->field_person_zipcode);
        print_value("country",            $person_node->field_person_country);
        print_value("phone",              $person_node->field_person_phone);
        print_value("fax",                $person_node->field_person_fax);
        foreach($person_node->field_person_email as $email) {
          print_tag_line("electronicMailAddress", $email["email"]);
        }
        print_value("personid",           $owner_node->field_person_personid);              
    }
    print_close_tag($person_tag);
  }
} 
       
  
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
          // print_r(node_load($content));
          print_value("shortName", $node->field_dataset_short_name);
          print_tag_line("title", $node->title);          
          
          // person refs
          print_person($node->field_dataset_owner_ref,          "owner");
          print_person($node->field_dataset_contact_ref,        "contact");
          print_open_tag("associatedParty");
            print_person($node->field_dataset_datamanager_ref,  "data_manager");
            print_person($node->field_dataset_fieldcrew_ref,    "field_crew");
            print_person($node->field_dataset_labcrew_ref,      "labcrew");
            print_person($node->field_dataset_ext_assoc,        "ext_assoc");
          print_close_tag("associatedParty");
          
          print_value("pubDate", $node->field_dataset_publication_date);
          print_value("abstract", $node->field_dataset_abstract);       
          // "coverage" repeated in data_file, TODO: move to function
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
              // print_r(strip_tags($node->field_methods));
              // foreach($node->field_methods as $val) {
              //   foreach($val as $val1) {
              //     print_r(strip_tags($val1));
              //   }
              // }
              print_value("description", strip_tags($node->field_methods));
            print_close_tag("methodStep"); 
            print_open_tag("qualityControl");
              // print_value("description", $node->field_quality);
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
                        // print_value("attributeName", $var_node->);
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
          
          // take research_site
          $research_site_nid = $node->field_dataset_site_ref;
          foreach ($research_site_nid as $key1 => $value1){
            foreach ($value1 as $key2 => $value2){
              $research_site_node = node_load($value2);     
              print_open_tag("geographicCoverage");      
                print_open_tag("geographicDescription");      
              
                print_close_tag("geographicDescription");
              
              print_close_tag("geographicCoverage");
              
              print_open_tag("research_site");
                print_open_tag("image");  
                  print_value("image",      $research_site_node->field_research_site_image);       
                print_close_tag("image");
                print_open_tag("pt_coords");
                  print_value("pt_coords",  $research_site_node->field_research_site_pt_coords);   
                print_close_tag("pt_coords");
                print_open_tag("elevation");
                  print_value("elevation",  $research_site_node->field_research_site_elevation);   
                print_close_tag("elevation");
                print_open_tag("landform");
                  print_value("landform",   $research_site_node->field_research_site_landform);    
                print_close_tag("landform");
                print_open_tag("geology");
                  print_value("geology",    $research_site_node->field_research_site_geology);     
                print_close_tag("geology");
                print_open_tag("soils");
                  print_value("soils",      $research_site_node->field_research_site_soils);       
                print_close_tag("soils");
                print_open_tag("hydrology");
                  print_value("hydrology",  $research_site_node->field_research_site_hydrology);   
                print_close_tag("hydrology");
                print_open_tag("vegetation");
                  print_value("vegetation", $research_site_node->field_research_site_vegetation);  
                print_close_tag("vegetation");
                print_open_tag("climate");
                  print_value("climate",    $research_site_node->field_research_site_climate);     
                print_close_tag("climate");
                print_open_tag("history");
                  print_value("history",    $research_site_node->field_research_site_history);     
                print_close_tag("history");
                print_open_tag("siteid");
                  print_value("siteid",     $research_site_node->field_research_site_siteid);      
                print_close_tag("siteid");
                
              print_close_tag("research_site");
            }
          }
          
        endforeach; //($row as $field => $content)
        print_close_tag("Dataset");
      endforeach; //($themed_rows as $count => $row)
      print_close_tag("eml:eml");
?>
