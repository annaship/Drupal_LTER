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

// put allowed HTML tags here
function my_strip_tags($content) {
  return strip_tags($content, "<p><h1><h2><h3><h4><h5><a><pre><para>");
}

function print_tag_line($label, $content) {  
  if (isset($content) && !empty($content)) {
    print '<'.$label.'>'.my_strip_tags($content).'</'.$label.'>';
  }
}

function print_attr_line($label, $content, $attribute_name, $attribute_value) {    
  if (isset($content) && !empty($content)) {
    print '<'.$label.' '.$attribute_name.'="'.$attribute_value.'">'.my_strip_tags($content).'</'.$label.'>';
    
  }
}

function print_open_tag($tag) {
  print '<'.$tag.'>';
}

function print_close_tag($tag) {
  print '</'.$tag.'>';
}
                               
function print_value($tag, $content) {
  if (isset($content) && !empty($content)) {
    foreach ($content as $in_arr) {
      // open when tree will be settled
      // if (!empty($in_arr['value'])) {    
        print_tag_line($tag, my_strip_tags($in_arr['value']));
      // }
    }
  }
}

function get_uniq_value($content) {
  if (isset($content) && !empty($content)) {
    // foreach ($content as $in_arr) {
      // open when tree will be settled
      // if (!empty($in_arr['value'])) {    
        return my_strip_tags($content[0]['value']);
      // }
    // }
  }
}

// first time make $comma_flag = 0, to skip comma
function get_geo($label, $content, $comma_flag = 1) {
  if (isset($content) && !empty($content)) {
    foreach($content as $value) {  
      if (!empty($value['value'])) {   
        if ($comma_flag == 1) {
          $geoDesc .= ", ".$label.": ".$value['value']; 
        }
        else {
          $geoDesc .= $label.": ".$value['value'];
        }
      }
    }             
  }
  return $geoDesc;
}

function print_person($ref_field_arr, $person_tag)
{                                                         
  if (isset($ref_field_arr) && !empty($ref_field_arr)) {
    foreach ($ref_field_arr as $key1 => $value1){
      foreach ($value1 as $key2 => $value2){
        $person_node = node_load($value2);      
        print_open_tag($person_tag);
          print_value("givenName",          $person_node->field_person_first_name);
          print_value("surname",            $person_node->field_person_last_name);
          print_value("organization",       $person_node->field_person_organization);
          print_value("deliveryPoint",      $person_node->field_person_address);
          print_value("city",               $person_node->field_person_city);
          print_value("administrativeArea", $person_node->field_person_state);
          print_value("postalCode",         $person_node->field_person_zipcode);
          print_value("country",            $person_node->field_person_country);
          print_attr_line('phone', get_uniq_value($person_node->field_person_phone),
                          'phonetype', 'voice');
          print_attr_line('phone', get_uniq_value($person_node->field_person_fax),
                          'phonetype', 'fax');
          $person_role_arr = $person_node->field_person_role;         
          $person_role     = $person_role_arr[0][value];   
          $not_show_role   = array ("owner", "creator", "contact");    
          if (!in_array($person_role, $not_show_role)) {
            print_tag_line("role",          $person_role);
          }
          foreach($person_node->field_person_email as $email) {
            print_tag_line("electronicMailAddress", $email["email"]);
          }
          print_value("personid",           $owner_node->field_person_personid);              
      }
      print_close_tag($person_tag);
    }
  }
} 
       
function print_temporal_coverage($beg_end_date) {
  print_open_tag("temporalCoverage");        
  foreach($beg_end_date as $dataset_date) {         
    $first_date  = $dataset_date["value"];
    $second_date = $dataset_date["value2"];
    if ($first_date== $second_date) {
       print_open_tag("singleDateTime");
         print_tag_line("calendarDate", $first_date);          
       print_close_tag("singleDateTime");
    } 
    else {
      print_open_tag("rangeOfDates");
        print_open_tag("beginDate");
          print_tag_line("calendarDate", $first_date);          
        print_close_tag("beginDate");
        print_open_tag("endDate");
          print_tag_line("calendarDate", $second_date);          
        print_close_tag("endDate");
      print_close_tag("rangeOfDates");
    }
  }
  print_close_tag("temporalCoverage");
}       
       
// url for datafile urls
$urlBase="http://".$_SERVER['HTTP_HOST']."/";

// ---------- end of config section ----------
  
print '<?xml version="1.0" encoding="UTF-8" ?>';

?>

<eml:eml xmlns:eml="eml://ecoinformatics.org/eml-2.0.1" xmlns:stmml="http://www.xml-cml.org/schema/stmml" xmlns:sw="eml://ecoinformatics.org/software-2.0.1" xmlns:cit="eml://ecoinformatics.org/literature-2.0.1" xmlns:ds="eml://ecoinformatics.org/dataset-2.0.1" xmlns:prot="eml://ecoinformatics.org/protocol-2.0.1" xmlns:doc="eml://ecoinformatics.org/documentation-2.0.1" xmlns:res="eml://ecoinformatics.org/resource-2.0.1" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="eml://ecoinformatics.org/eml-2.0.1 eml.xsd" packageId="knb-lter-pie.3.6" system="knb">

<?php 

// ??? packageId="knb-lter-pie.3.6" above ???

foreach ($themed_rows as $count => $row): 
/* dataset
*/                                                        
      print_open_tag("dataset");      

        foreach ($row as $field => $content):         
          $node = node_load($content);             
          print_value("shortName", $node->field_dataset_short_name);
          print_tag_line("title", $node->title);    
          
          // TODO, hardcode the metadataProvider
          print_open_tag("metadataProvider");
            print_tag_line("givenName",             "");
            print_tag_line("surname",               "");
            print_tag_line("organization",          "");
            print_tag_line("deliveryPoint",         "");
            print_tag_line("city",                  "");
            print_tag_line("administrativeArea",    "");
            print_tag_line("postalCode",            "");
            print_tag_line("country",               "");
            print_tag_line("phone",                 "");
            print_tag_line("fax",                   "");
            print_tag_line("role",                  "");
            print_tag_line("electronicMailAddress", "");
            print_tag_line("personid",              "");              
          print_close_tag("metadataProvider");
          
          // person refs
          print_person($node->field_dataset_owner_ref,          "owner");
          print_open_tag("associatedParty");
            print_person($node->field_dataset_datamanager_ref,  "data_manager");
            print_person($node->field_dataset_fieldcrew_ref,    "field_crew");
            print_person($node->field_dataset_labcrew_ref,      "labcrew");
            print_person($node->field_dataset_ext_assoc,        "ext_assoc");
          print_close_tag("associatedParty");
          
          print_value("pubDate", $node->field_dataset_publication_date);
          print_value("abstract", $node->field_dataset_abstract);         
          
          print_open_tag("keywordSet");   
            // dpr($node->taxonomy);
            // print_value("keyword", node->taxonomy->term);
            // print_value("keywordThesaurus", node->taxonomy->vocabularyName); 
          print_close_tag("keywordSet");
                  
          print_open_tag("additionalInfo");
            print_open_tag("para");
               print_value("literalLayout", $node->field_dataset_add_info);
            print_close_tag("para");
          print_close_tag("additionalInfo");
          
          print_open_tag("intellectualRights");
            print_open_tag("section");
            print_tag_line("title", "Data Policies");          
            print_open_tag("para");  
              // TODO: change!!!
              print_tag_line("literalLayout", "blablahblahbla");          
            print_close_tag("para");
            print_close_tag("section");
          print_close_tag("intellectualRights");
                                                         
          // take a file, result used here and in DataTable
          $file_nid = $node->field_dataset_datafile_ref;
          foreach ($file_nid as $key1 => $value1){
            foreach ($value1 as $key2 => $value2){
              $file_node = node_load($value2);
              $file_node_arr[] = $file_node;
              foreach($file_node->field_data_file as $file_data) {
                $file_data_arr[] = $file_data;
              }
            }
          }

          print_open_tag("distribution");    
                    // ??? if there are several files from different dirs?
                    /*
                    <distribution>
                    −
                    <url>
                    http://127.0.0.1/sites/default/files/dataModelComparison.xlsx
                    </url>
                    −
                    <url>
                    http://127.0.0.1/sites/default/files/EST-PR-NUT.xml
                    </url>
                    </distribution>
                    */
          // or
                    /*
                    <distribution>
                    −
                    <url>
                    http://127.0.0.1/sites/default/files/dataModelComparison.xlsx
                    </url>
                    </distribution>
                    −
                    <distribution>
                    −
                    <url>
                    http://127.0.0.1/sites/default/files/EST-PR-NUT.xml
                    </url>
                    </distribution>
                    */          
          
            foreach ($file_data_arr as $file_data) {
              if (isset($file_data) && !empty($file_data["filepath"])) {
                  print_tag_line("url", $urlBase.$file_data["filepath"]);
              } 
            }
          print_close_tag("distribution");  


          // "coverage" repeated in data_file, TODO: move to function
          print_open_tag("coverage");           
            print_temporal_coverage($node->field_beg_end_date);
          print_close_tag("coverage");        
          
          print_open_tag("purpose");
             print_open_tag("para");
                print_value("literalLayout", $node->field_dataset_purpose);
             print_close_tag("para");
          print_close_tag("purpose");
          
          print_open_tag("maintenance");
            print_open_tag("description");
               print_open_tag("para");
                  print_value("literalLayout", $node->field_dataset_maintenance);
               print_close_tag("para");
            print_close_tag("description");
          print_close_tag("maintenance");
                                     
          print_person($node->field_dataset_contact_ref, "contact");
          
          // print_person_hardcode_publiser
          print_open_tag("publiser");
            print_tag_line("givenName",             "");
            print_tag_line("surname",               "");
            print_tag_line("organization",          "");
            print_tag_line("deliveryPoint",         "");
            print_tag_line("city",                  "");
            print_tag_line("administrativeArea",    "");
            print_tag_line("postalCode",            "");
            print_tag_line("country",               "");
            print_tag_line("phone",                 "");
            print_tag_line("fax",                   "");
            print_tag_line("role",                  "");
            print_tag_line("electronicMailAddress", "");
            print_tag_line("personid",              "");              
          print_close_tag("publiser");
          
          // pubPlace here, harcoded??? to the site. <pubPLace> Plum Island Ecosystems LTER </pubPlace>
          $site_name = variable_get("site_name", NULL);
          print_tag_line("pubPlace", $site_name);

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
          
          print_value("related_links", $node->field_dataset_related_links);
          
          
          // data_file
            foreach ($file_node_arr as $file_node) {
              print_open_tag("dataTable");
                foreach ($file_node->field_data_file as $file_data) {
                  print_tag_line("entityName", $file_data["filename"]);
                }
                print_value("entityDescription", $file_node->field_datafile_description);
                print_open_tag("physical");   
                  foreach ($file_node->field_data_file as $file_data) {
                    print_tag_line("objectName", $file_data["filename"]);
                  }
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
                  foreach ($file_node->field_data_file as $file_data) {
                    if (!empty($file_data["filepath"])) {
                      print_open_tag("distribution");                      
                        print_tag_line("url", $urlBase.$file_data["filepath"]);
                      print_close_tag("distribution");  
                    }
                  }
                print_close_tag("physical");
          
                print_open_tag("coverage");          
                //  geo coverage here
                // ??? all the same as for dataset? repeat geo info?
                print_temporal_coverage($file_node->field_datafile_date);
                // taxonomic coverage here, but for now ignore - we didnt address this in drupal yet.
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
                        print_value("attributeName", $var_node->title);
                        print_value("attributeLabel", $var_node->field_attribute_label);
                        print_value("attributeDefinition", $var_node->field_var_definition);       
                        
                        print_open_tag("measurementScale");
                          // $a = $var_node->field_attribute_maximum;
                          // dpr(!empty($a[0]['value']));
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
                                print_open_tag("codeDefinition");
                                  print_value("codeDefinition", $var_node->field_code_definition);
                                  $codeDef = $var_node->field_code_definition;     
  // example???
                                  // dpr($codeDef);
                                  // <codeDefinition>G=five-points grass core site</codeDefinition>
                                  // <codeDefinition>C=Rio Salado</codeDefinition>
                                  // −
                                  // <pre>
                                  // Array
                                  // (
                                  //     [0] => Array
                                  //         (
                                  //             [value] => G=five-points grass core site
                                  //         )
                                  // 
                                  //     [1] => Array
                                  //         (
                                  //             [value] => C=Rio Salado
                                  //         )
                                  // 
                                  // )
                                  // </pre>
                                  preg_match('/(?<code>\w+)=(?<definition>\w+)/', $codeDef, $matches);
                                  print_value("code", $matches["code"]);                     //                   code
                                  print_value("definition", $matches["definition"]);         //                   definition
                                print_close_tag("codeDefinition");
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
            // }
          // }  
          
          // take research_site
          // ??? what move into "coverage"? all that?:
          $research_site_nid = $node->field_dataset_site_ref;
          foreach ($research_site_nid as $key1 => $value1):
            foreach ($value1 as $key2 => $value2){
              $research_site_node = node_load($value2);      
              print_open_tag("geographicCoverage");      
                $geoDesc  = get_geo("Landform",   $research_site_node->field_research_site_landform, 0);
                $geoDesc .= get_geo("Geology",    $research_site_node->field_research_site_geology);
                $geoDesc .= get_geo("Soils",      $research_site_node->field_research_site_soils);
                $geoDesc .= get_geo("Hydrology",  $research_site_node->field_research_site_hydrology);
                $geoDesc .= get_geo("Vegetation", $research_site_node->field_research_site_vegetation);
                $geoDesc .= get_geo("Climate",    $research_site_node->field_research_site_climate);
                $geoDesc .= get_geo("History",    $research_site_node->field_research_site_history);
                $geoDesc .= get_geo("siteid",     $research_site_node->field_research_site_siteid);
                print_tag_line("geographicDescription", $geoDesc);

                //                 example!!!
                print_open_tag("boundingCoordinates");
                  print_value("westBoundingCoordinate", $research_site_node->field_research_site_pt_coords);   //there is some parsing to do here, need the longitude only
                  print_value("eastBoundingCoordinate", $research_site_node->field_research_site_pt_coords);   //there is some parsing to do here, need the longitude only
                  print_value("northBoundingCoordinate", $research_site_node->field_research_site_pt_coords);   //there is some parsing to do here, need the longitude only
                  print_value("southBoundingCoordinate", $research_site_node->field_research_site_pt_coords);   //there is some parsing to do here, need the longitude only
                  print_open_tag("boundingAltitudes"); //conditional on content
                    print_value("altitudeMinimum",  $research_site_node->field_research_site_elevation);   
                    print_value("altitudeMaximum",  $research_site_node->field_research_site_elevation);   
                  print_close_tag("boundingAltitudes");
                print_close_tag("boundingCoordinates");
              print_close_tag("geographicCoverage");
            }
          endforeach; //research_site_nid
        endforeach; //($row as $field => $content)
        print_close_tag("dataset");
      endforeach; //($themed_rows as $count => $row)
      print_close_tag("eml:eml");
?>
