<?php
// $Id: views-bonus-export-eml.tpl.php,v 1.2 2009/06/24 17:27:53 neclimdul Exp $
/**
 * Template to display a view as an eml.
 * TODO: 
 * 1) add all tags
 * 2) parameters in tag <geographicCoverage id="GEO-13"> 
 *    as print '<'.$label.' '.$id_name.'="'.$id_value.'">'.$content.'</'.$label.'>';
 * 3) add ifs to maintenance, 
 *
 */

// put allowed HTML tags here
function my_strip_tags($content) {
  return strip_tags($content, "<p><h1><h2><h3><h4><h5><a><pre><para>");
}

function print_tag_line($label, $content) {  
  if ($content) {
    print '<'.$label.'>'.my_strip_tags($content).'</'.$label.'>';
  }
}

function print_attr_line($label, $content, $attribute_name, $attribute_value) {    
  if ($content) {
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
  if ($content[0]['value']) {
    foreach ($content as $in_arr) {
        print_tag_line($tag, my_strip_tags($in_arr['value']));
    }
  }
}

function get_uniq_value($content) {
  if ($content[0]['value']) {
    return my_strip_tags($content[0]['value']);
  }
}

// first time make $comma_flag = 0, to skip comma
function get_geo($label, $content, $comma_flag = 1) {   
  if ($content[0]['value']) {
    foreach($content as $value) {  
      if ($comma_flag == 1) {
        $geoDesc .= ", ".$label.": ".$value['value']; 
      }
      else {
        $geoDesc .= $label.": ".$value['value'];
      }
    }
  }             
  return $geoDesc;
}

function print_person($person_tag, $ref_field_arr) {                 
  if ($ref_field_arr[0]['nid']) {
    foreach ($ref_field_arr as $key1 => $value1){
      foreach ($value1 as $key2 => $value2){
        $person_node          = node_load($value2);                                    
        $person_first_name    = $person_node->field_person_first_name;
        $person_last_name     = $person_node->field_person_last_name;
        $person_organization  = $person_node->field_person_organization;
        $person_address       = $person_node->field_person_address;
        $person_city          = $person_node->field_person_city;
        $person_state         = $person_node->field_person_state;
        $person_zipcode       = $person_node->field_person_zipcode;
        $person_country       = $person_node->field_person_country;
        $person_phone         = $person_node->field_person_phone;
        $person_fax           = $person_node->field_person_fax;
        $person_email         = $person_node->field_person_email;
        $person_personid      = $owner_node->field_person_personid;
        $person_role_arr      = $person_node->field_person_role;         
        $person_role          = $person_role_arr[0]['value'];   
        $not_show_role        = array ("owner", "creator", "contact");    

        print_open_tag($person_tag);
          print_value("givenName",          $person_first_name); 
          print_value("surName",            $person_last_name);
          print_value("organization",       $person_organization);      
          print_value("deliveryPoint",      $person_address);
          print_value("city",               $person_city);
          print_value("administrativeArea", $person_state);
          print_value("postalCode",         $person_zipcode);
          print_value("country",            $person_country);
          print_attr_line('phone', get_uniq_value($person_phone),
                          'phonetype', 'voice');
          print_attr_line('phone', get_uniq_value($person_fax),
                          'phonetype', 'fax');
          if (!in_array($person_role, $not_show_role)) {
            print_tag_line("role", $person_role);
          }              
          if ($person_email[0]['email']) {
            foreach($person_email as $email) {
              print_tag_line("electronicMailAddress", $email["email"]);
            }
          }
          print_value("personid", $person_personid);              
      }
      print_close_tag($person_tag);
    }
  }
} 
       
function print_temporal_coverage($beg_end_date) { 
  if ($beg_end_date[0]['value']) {
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
}       

// take research_site as geographicCoverage
// ??? what move into "coverage"? all that?:
function print_geographic_coverage($research_site_nid) {       
  if ($research_site_nid[0]['nid']) { 
    // $research_site_nid = $node->field_dataset_site_ref;
    foreach ($research_site_nid as $key1 => $value1):
      foreach ($value1 as $key2 => $value2){
        $research_site_node = node_load($value2);    
        $research_site_landform   = $research_site_node->field_research_site_landform;
        $research_site_geology    = $research_site_node->field_research_site_geology;
        $research_site_soils      = $research_site_node->field_research_site_soils;
        $research_site_hydrology  = $research_site_node->field_research_site_hydrology;
        $research_site_vegetation = $research_site_node->field_research_site_vegetation;
        $research_site_climate    = $research_site_node->field_research_site_climate;
        $research_site_history    = $research_site_node->field_research_site_history;
        $research_site_siteid     = $research_site_node->field_research_site_siteid;
        $research_site_pt_coords  = $research_site_node->field_research_site_pt_coords;
        $research_site_elevation  = $research_site_node->field_research_site_elevation;        
        if ($research_site_landform[0]['value']   || $research_site_geology[0]['value'] || 
            $research_site_soils[0]['value']      || $research_site_hydrology[0]['value'] || 
            $research_site_vegetation[0]['value'] || $research_site_climate[0]['value'] || 
            $research_site_history[0]['value']    || $research_site_siteid[0]['value'] || 
            !empty($research_site_pt_coords)      || $research_site_elevation[0]['value']) {
          print_open_tag("geographicCoverage");      
            $geoDesc  = get_geo("Landform",   $research_site_landform, 0);
            $geoDesc .= get_geo("Geology",    $research_site_geology);
            $geoDesc .= get_geo("Soils",      $research_site_soils);
            $geoDesc .= get_geo("Hydrology",  $research_site_hydrology);
            $geoDesc .= get_geo("Vegetation", $research_site_vegetation);
            $geoDesc .= get_geo("Climate",    $research_site_climate);
            $geoDesc .= get_geo("History",    $research_site_history);
            $geoDesc .= get_geo("siteid",     $research_site_siteid);
            print_tag_line("geographicDescription", $geoDesc);

            //                 example!!!                
            if (!empty($research_site_pt_coords) || ($research_site_elevation[0]['value'])) {
              print_open_tag("boundingCoordinates");
                print_value("westBoundingCoordinate",   $research_site_pt_coords);   //there is some parsing to do here, need the longitude only
                print_value("eastBoundingCoordinate",   $research_site_pt_coords);   //there is some parsing to do here, need the longitude only
                print_value("northBoundingCoordinate",  $research_site_pt_coords);   //there is some parsing to do here, need the longitude only
                print_value("southBoundingCoordinate",  $research_site_pt_coords);   //there is some parsing to do here, need the longitude only
                                            
                print_open_tag("boundingAltitudes"); //conditional on content
                  print_value("altitudeMinimum",  $research_site_elevation);   
                  print_value("altitudeMaximum",  $research_site_elevation);   
                print_close_tag("boundingAltitudes");    
              print_close_tag("boundingCoordinates");
            }
          print_close_tag("geographicCoverage");
        }
      }
    endforeach; //research_site_nid     
  } 
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
          
          // collect all values here to use in a conditions 
          $dataset_short_name       = $node->field_dataset_short_name;   
          $dataset_title            = $node->title;
          $dataset_owner_ref        = $node->field_dataset_owner_ref;
          $dataset_datamanager_ref  = $node->field_dataset_datamanager_ref;
          $dataset_fieldcrew_ref    = $node->field_dataset_fieldcrew_ref;
          $dataset_labcrew_ref      = $node->field_dataset_labcrew_ref;  
          // ??? no such field ?
          $dataset_ext_assoc        = $node->field_dataset_ext_assoc;
          $dataset_publication_date = $node->field_dataset_publication_date;
          $dataset_abstract         = $node->field_dataset_abstract;
          $dataset_add_info         = $node->field_dataset_add_info;
          $dataset_site_ref         = $node->field_dataset_site_ref;
          $dataset_beg_end_date     = $node->field_beg_end_date;
          $dataset_purpose          = $node->field_dataset_purpose;
          $dataset_maintenance      = $node->field_dataset_maintenance;
          $dataset_contact_ref      = $node->field_dataset_contact_ref;
          $dataset_instrumentation  = $node->field_instrumentation;
          $dataset_methods          = $node->field_methods;
          $dataset_quality          = $node->field_quality;
          $dataset_id               = $node->field_dataset_id;
          $dataset_related_links    = $node->field_dataset_related_links;

          // take file, a result used here and in DataTable
          $file_nid = $node->field_dataset_datafile_ref; 
          if ($file_nid[0]['nid']) {
            foreach ($file_nid as $key1 => $value1){
              foreach ($value1 as $key2 => $value2){
                $file_node = node_load($value2);
                $file_node_arr[] = $file_node;
                foreach($file_node->field_data_file as $file_data) {
                  $file_data_arr[] = $file_data;
                }
              }
            }
          }

          if ($dataset_short_name[0]['value']) {
            print_value("shortName", $dataset_short_name);
          }
          print_tag_line("title", $dataset_title);    
          
          // person refs
          print_person("owner", $dataset_owner_ref);
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
                                               
          if ($dataset_datamanager_ref[0]['nid'] || $dataset_fieldcrew_ref[0]['nid'] || 
              $dataset_labcrew_ref[0]['nid'] || $dataset_ext_assoc[0]['nid']) {                     
            // ??? empty tags, because all field_person are empty, but 
            // ['title'] => Hap Garritt
            // ['name'] => admin
            print_open_tag("associatedParty");
              print_person("data_manager",  $dataset_datamanager_ref);
              print_person("field_crew",    $dataset_fieldcrew_ref);
              print_person("labcrew",       $dataset_labcrew_ref);
              print_person("ext_assoc",     $dataset_ext_assoc);
            print_close_tag("associatedParty");
          }          
          
          print_value("pubDate",  $dataset_publication_date);
          print_value("abstract", $dataset_abstract);         
                     
          // TODO: add if, depend of structure
          print_open_tag("keywordSet");   
            // dpr($node->taxonomy);
            // print_value("keyword", node->taxonomy->term);
            // print_value("keywordThesaurus", node->taxonomy->vocabularyName); 
          print_close_tag("keywordSet");  
          
          if ($dataset_add_info[0]['value']) {
            print_open_tag("additionalInfo");
              print_open_tag("para");
                 print_value("literalLayout", $dataset_add_info);
              print_close_tag("para");
            print_close_tag("additionalInfo");
          }
          
          print_open_tag("intellectualRights");
            print_open_tag("section");
            print_tag_line("title", "Data Policies");          
            print_open_tag("para");  
              // TODO: change!!!
              print_tag_line("literalLayout", "blablahblahbla");          
            print_close_tag("para");
            print_close_tag("section");
          print_close_tag("intellectualRights");
                                                         
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
                    
                    /*
                    $path_parts = pathinfo('/www/htdocs/inc/lib.inc.php');

                    echo $path_parts['dirname'], "\n";
                    echo $path_parts['basename'], "\n";
                    echo $path_parts['extension'], "\n";
                    echo $path_parts['filename'], "\n"; // since PHP 5.2.0
                    */
          
            // foreach ($file_data_arr as $file_data) {
            //   if (isset($file_data) && !empty($file_data["filepath"])) {
            //       print_tag_line("url", $urlBase.dirname($file_data["filepath"]));
            //   } 
            // }
            // ??? what if dirname is different for dif. files?
                print_tag_line("url", $urlBase.dirname($file_data_arr[0]["filepath"]));
          print_close_tag("distribution");  
                                  
          if ($dataset_site_ref[0]['nid'] || $dataset_beg_end_date[0]['value']) {
            print_open_tag("coverage");           
              print_geographic_coverage($dataset_site_ref);
              print_temporal_coverage($dataset_beg_end_date);
              // taxonomicCoverage
            print_close_tag("coverage");        
          }
                                 
          if ($dataset_purpose[0]['value']) {
            print_open_tag("purpose");
               print_open_tag("para");
                  print_value("literalLayout", $dataset_purpose);
               print_close_tag("para");
            print_close_tag("purpose");
          }
                                               
          if ($dataset_maintenance[0]['value']) {
            print_open_tag("maintenance");
              print_open_tag("description");
                 print_open_tag("para");
                    print_value("literalLayout", $dataset_maintenance);
                 print_close_tag("para");
              print_close_tag("description");
            print_close_tag("maintenance");
          }
                                     
          print_person("contact", $dataset_contact_ref);
          
          // print_person_hardcode_publisher
          print_open_tag("publisher");
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
          print_close_tag("publisher");
          
          // pubPlace here, harcoded??? to the site. <pubPLace> Plum Island Ecosystems LTER </pubPlace>
          $site_name = variable_get("site_name", NULL);
          print_tag_line("pubPlace", $site_name);

          if ($dataset_instrumentation[0]['value'] || $dataset_methods[0]['value'] || $dataset_quality[0]['value']) {
            print_open_tag("methods");
            if ($dataset_instrumentation[0]['value'] || $dataset_methods[0]['value']) {
              print_open_tag("methodStep");
                print_value("instrumentation",  $dataset_instrumentation); 
                print_value("description",      $dataset_methods);
              print_close_tag("methodStep");                    
            }
            
            if ($dataset_quality[0]['value']) {
              print_open_tag("qualityControl");
                print_value("description",      $dataset_quality);
              print_close_tag("qualityControl");
            }
            print_close_tag("methods");
          }
                                          
          // ??? are it and next one optional?
          print_value("field_dataset_id", $dataset_id);     
          
          print_value("related_links",    $dataset_related_links);
          
          
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
                        print_value("quoteCharacter", $file_node->field_quote_character);
                      print_close_tag("simpleDelimited");
                    print_close_tag("textFormat");
                  print_close_tag("dataFormat");
                  foreach ($file_node->field_data_file as $file_data) {
                    if ($file_data["filepath"]) {
                      print_open_tag("distribution");                      
                        print_tag_line("url", $urlBase.$file_data["filepath"]);
                      print_close_tag("distribution");  
                    }
                  }
                print_close_tag("physical");
                
                $datafile_site_ref  = $file_node->field_datafile_site_ref;
                $datafile_date      = $file_node->field_datafile_date;
                if ($datafile_site_ref[0]['nid'] || $datafile_date[0]['nid']) {
                  print_open_tag("coverage");             
                    // if several sites? see localhost
                    print_geographic_coverage($datafile_site_ref);
                    print_temporal_coverage($datafile_date);
                    // taxonomic coverage here, but for now ignore - we didnt address this in drupal yet.
                  print_close_tag("coverage");
                }
                                                    
                $instrumentation  = $file_node->field_instrumentation;
                $methods          = $file_node->field_methods;
                $quality          = $file_node->field_quality;
                
                if ($instrumentation[0]['value'] || $methods[0]['value'] || $quality[0]['value']) {
                  print_open_tag("method");
                  if ($instrumentation[0]['value'] || $methods[0]['value']) {
                    print_open_tag("methodStep");
                      print_value("instrumentation",  $file_node->field_instrumentation);
                      print_value("description",      $file_node->field_methods);
                    print_close_tag("methodStep"); 
                  }
                  if ($quality[0]['value']) {
                    print_open_tag("qualityControl");
                      print_value("description",      $file_node->field_quality);
                    print_close_tag("qualityControl");
                  }
                  print_close_tag("method");
                }
          
                print_open_tag("attributeList");
                  // take variables
                  $var_nid = $file_node->field_datafile_variable_ref;
                  foreach ($var_nid as $key1 => $value1){
                    foreach ($value1 as $key2 => $value2){
                      $var_node = node_load($value2);
                      
                      $var_title              = $var_node->title;
                      $attribute_label        = $var_node->field_attribute_label;
                      $var_definition         = $var_node->field_var_definition;
                      $attribute_formatstring = $var_node->field_attribute_formatstring;
                      $attribute_maximum      = $var_node->field_attribute_maximum;
                      $attribute_minimum      = $var_node->field_attribute_minimum;
                      $attribute_precision    = $var_node->field_attribute_precision;
                      $attribute_unit         = $var_node->field_attribute_unit;    
                      $code_definition        = $var_node->field_code_definition;
                      $var_missingvalues      = $var_node->field_var_missingvalues;
                      
                      print_open_tag("attribute");      
                        print_tag_line("attributeName",    $var_title);
                        if ($attribute_label[0]['value']) {
                          print_value("attributeLabel",    $attribute_label);
                        }
                        print_value("attributeDefinition", $var_definition);       
                                                            
                        /* ??? measurementScale, datatime, ratio, nominal are obligate, but missing in prototype
                        ??? put if???
                        for what else in "measurementScale"???     (all but "precision" is obligate)
                        */                                                        

                        print_open_tag("measurementScale");
                          print_open_tag("datatime");
                            print_value("formatstring",   $attribute_formatstring);
                          print_close_tag("datatime");
                          print_open_tag("ratio");
                            print_open_tag("numericDomain");
                              print_open_tag("bounds");
                                print_value("maximum",    $attribute_maximum);
                                print_value("minimum",    $attribute_minimum);
                              print_close_tag("bounds");
                            print_close_tag("numericDomain");
                            print_value("precision",      $attribute_precision);
                            print_open_tag("unit");        
                              print_value("standardUnit", $attribute_unit);
                            print_close_tag("unit");
                          print_close_tag("ratio");
                          print_open_tag("nominal");
                            print_open_tag("nonNumericDomain");
                              print_open_tag("enumeratedDomain");    
                              // codeDefinition is obligate
                                print_open_tag("codeDefinition");
                                  print_value("codeDefinition", $code_definition);
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
                                  //             ['value'] => G=five-points grass core site
                                  //         )
                                  // 
                                  //     [1] => Array
                                  //         (
                                  //             ['value'] => C=Rio Salado
                                  //         )
                                  // 
                                  // )
                                  // </pre>
                                  # warning: preg_match() expects parameter 2 to be string, array given in /var/www/prototype/sites/all/modules/views_bonus/export/views-bonus-export-eml.tpl.php on line 556.
                                  // move into foreach cycle:
                                  // preg_match('/(?<code>\w+)=(?<definition>\w+)/', $code_definition, $matches);
                                  // ???what if there're no matches?
                                  print_value("code", $matches["code"]);                     //                   code
                                  print_value("definition", $matches["definition"]);         //                   definition
                                print_close_tag("codeDefinition");
                              print_close_tag("enumeratedDomain");
                            print_close_tag("nonNumericDomain");
                          print_close_tag("nominal");
                        print_close_tag("measurementScale");
                                                 
                        if ($var_missingvalues[0]['value']) {
                          print_open_tag("missingValueCode");
                            print_value("missingValues", $var_missingvalues);
                          //           code
                          //           value
                          print_close_tag("missingValueCode");
                        }
                      print_close_tag("attribute");
                    }
                  }                
                print_close_tag("attributeList");
              print_close_tag("dataTable");
            }
            // }
          // }  
          
        endforeach; //($row as $field => $content)
        print_close_tag("dataset");
      endforeach; //($themed_rows as $count => $row)
      print_close_tag("eml:eml");
?>
