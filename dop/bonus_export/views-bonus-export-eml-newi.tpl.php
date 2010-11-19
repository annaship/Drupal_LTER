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
                               
function print_value($tag, $arr) {
  foreach ($arr as $in_arr) {
    print_tag_line($tag, $in_arr['value']);          
  }
}

function print_person($ref_field_arr, $person_tag) {                                                         
  foreach ($ref_field_arr as $key1 => $value1){
    foreach ($value1 as $key2 => $value2){
      $person_node = node_load($value2);      
      print_open_tag($person_tag);
//        print_value("title",              $person_node->field_person_title);  //no need this in EML
        print_value("givenName",          $person_node->field_person_first_name); /
        print_value("surName",            $person_node->field_person_last_name);  //note surname->surName
        print_value("organization",       $person_node->field_person_organization);
        print_value("deliveryPoint",      $person_node->field_person_address);
        print_value("city",               $person_node->field_person_city);
        print_value("administrativeArea", $person_node->field_person_state);
        print_value("postalCode",         $person_node->field_person_zipcode);
        print_value("country",            $person_node->field_person_country);
!!!        print_value("phone",              $person_node->field_person_phone); // in reality, phone and fax are both <phone> tags in EML, the disctintion is in the attribute "phonetype (voice or fax)"
        print_value("fax",                $person_node->field_person_fax);      
        $person_role = $person_node->field_person_role;
      //   if ($person_role != "owner" AND $person_role != "creator" AND $person_role != "contact") {
      //     print_value("role",               $person_node->field_person_role);  // this only needed (and accepted in EML) when is role *is NOT* an owner(creator) or *is NOT* a contact
      // }
        foreach($person_node->field_person_email as $email) {
          print_tag_line("electronicMailAddress", $email["email"]);  // I dont think we made email multiple...
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
/* dataset
*/                                                        
      print_open_tag("dataset");  // it is lowercase (Dataset->dataset) XML is case sensitive, as you know.
        foreach ($row as $field => $content):         
          $node = node_load($content);
          // --------------------------------------
          // dpr($node);
!!!          print_value("shortName", $node->field_dataset_short_name);  // conditional (it is optional)
          print_tag_line("title", $node->title);          

          // person refs
          print_person($node->field_dataset_owner_ref,          "owner");
!!!          // HERE we need to hardcode the metadataProvider -- it has the structure of a "person"
          // but it is the same for any given LTER site.
          //
          print_open_tag("associatedParty");
            print_person($node->field_dataset_datamanager_ref,  "data_manager");
            print_person($node->field_dataset_fieldcrew_ref,    "field_crew");
            print_person($node->field_dataset_labcrew_ref,      "labcrew");
            print_person($node->field_dataset_ext_assoc,        "ext_assoc");
          print_close_tag("associatedParty");

          print_value("pubDate", $node->field_dataset_publication_date);
          print_value("abstract", $node->field_dataset_abstract);       

          //  here we would need to print the keywords from the taxonomies associated with the "Data Set" CCT
          //  hopefully, only ONE vocabulary for a given Data Set CCT
          print_open_tag("keywordSet");
!!!need example!!!            foreach (term): // obviously, needs work
              print_value("keyword", node->taxonomy->term);
            }
!!!            print_value("keywordThesaurus", node->taxonomy->vocabularyName); // needs work :)
          print_close_tag("keywordSet");
          
          //  i added additional info block in here.
          print_open_tag("additionalInfo");
            print_open_tag("para");
               print_value("literalLayout", $node->field_dataset_add_info_value);
            print_close_tag("para");
          print_close_tag("additionalInfo");
          
          //  need to hardcode the <intellectualRights> here.  usually, data policies, etc... 
          // the block structure is like this:
          //  <intellectualRights>
          //     <section>  (repeatable)
          //        <title> Data Policies </title>
!!!          //        <para>  <literalLayout> blablahblahblab </literalLayout> </para>
          //     </section>
          //  </intellectualRights>
 
          // HERE goes a URL that leads to the data OR a data catalog if there are multiple "data files" in this EML.
          //  this URL is at the "dataset" level -- aka the EML resource module.  we do not capture in Drupal CCT
          //  so we may hardcode it to the "datacatalog", or copy it from $file_data["filepath"]);
          // for now I just copy what you have below -- it wont hurt.
          //  I guess $urlBase="http://www.blah-blah-blah/"; so it can be parametrized... bla.
          //
          foreach($file_node->field_data_file as $file_data) {
                    print_open_tag("distribution");
                      print_tag_line("url", "http://www.blah-blah-blah/".$file_data["filepath"]);
                    print_close_tag("distribution");  
          }
          
          // "coverage" repeated in data_file, TODO: move to function  -ISG i concur, read notes at geoCov..below
          print_open_tag("coverage");           
          //  geographicCoverage, temporalCoverage and taxonomicCoverage
???          //  i would move here geocov from below, BUT i wont:  just waiting for the function call rather. (if any)
          
            print_open_tag("temporalCoverage");  /
                                              // we could tweak it to see whether beginDate==endDate, 
                                              // and if so, instead of range of dates it would be something like this
                                              //  print_open_tag("singleDateTime");
                                              //      print_tag_line("calendarDate", $dataset_date["value"]);          
                                              ///    print_close_tag("singleDateTime");
                                              //  wrapped up in a foreach, in case there is more than one date 
                                              // Example: in some studies the investigator goes to the field 3 or 4 random days in a year..
                                              
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
            
            //  to do -- taxonomicCoverage
            
          print_close_tag("coverage");
    
!!!put allwed tags into strip_tag above //some tweaks -- it is a textType block -- meaning it has this section/para/markup structure... 
          
          print_open_tag("purpose");
             print_open_tag("para");
                print_value("literalLayout", $node->field_dataset_purpose);
             print_close_tag("para");
          print_clsose_tag("purpose");
          
!!!put allwed tags into strip_tag above          // some tweaks -- it is a textType block -- meaning it has this section/para/markup structure... 
          
          print_open_tag("maintenance");
            print_open_tag("description");
               print_open_tag("para");
                  print_value("literalLayout", $node->field_dataset_maintenance);
               print_close_tag("para");
            print_close_tag("description");
          print_close_tag("maintenance");
          
          // contact comes here
          print_person($node->field_dataset_contact_ref,        "contact");

          // publisher here, this is harcoded to the "site" -- bears the EML structure of "person"
          // print_person_hardcode_publiser
          
          // pubPlace here, harcoded to the site. <pubPLace> Plum Island Ecosystems LTER </pubPlace>
          // print_value("pubPlace", $site);
          
          print_open_tag("methods");
???            foreach($node->field_methods){  // it is "unlimited", not sure whether the syntax is right. 
                                            // may be better to concatenate "field_methods" values? asthere is
                                            // a problem with the way we structured the CCT and how EML does it.
                                            // will explain
               print_open_tag("methodStep");  
                 print_value("description", $node->field_methods);
                 print_value("instrumentation", $node->field_instrumentation);
               print_close_tag("methodStep"); 
            }
            print_open_tag("qualityControl");
              print_value("description", $node->field_quality);
            print_close_tag("qualityControl");
          print_close_tag("methods");
         
???         // this "has to do" with the <eml:eml packageId= $node->field_dataset_id > attribute.
         // 
          print_value("field_dataset_id", $node->field_dataset_id);
          
         // this... im not sure where it maps, let me think  
         // 
!!!          print_value("related_links", $node->field_dataset_related_links);

          // take file  -- ISG it is good here.
          $file_nid = $node->field_dataset_datafile_ref;
          foreach ($file_nid as $key1 => $value1){
            foreach ($value1 as $key2 => $value2){
              $file_node = node_load($value2);
              // dpr($file_node);
              print_open_tag("dataTable");
                // todo: take once and keep filename and filepath in some array to use later, should be faster
                foreach($file_node->field_data_file as $file_data) {
???                  print_tag_line("entityName", $file_data["filename"]); //  we need the node title in the table node, field title... or better, the spreadsheetname.. it is only one value
                }
                print_value("entityDescription", $file_node->field_datafile_description);
                print_open_tag("physical");
                  print_value("objectName", $file_data["filename"]);// need this (mandatory.  it is the spreadsheet name)
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
                  foreach($file_node->field_data_file as $file_data) {
                    print_open_tag("distribution");
                      print_tag_line("url", "http://www.blah-blah-blah/".$file_data["filepath"]);  /// we may use a parameter like $urlBase..
                    print_close_tag("distribution");  
                  }
                print_close_tag("physical");

                print_open_tag("coverage");           
                  //  geo coverage here.
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
                  // taxonomic coverage here, but for now ignore - we didnt address this in drupal yet.
                print_close_tag("coverage");

                print_open_tag("method");
                  print_open_tag("methodStep");
???example                    print_value("description", $file_node->field_methods);// may be multiple values, see the methods instance upstream
                    print_value("instrumentation", $file_node->field_instrumentation);
                  print_close_tag("methodStep"); 
                  print_open_tag("qualityControl");
                    print_value("description", $file_node->field_quality);
                  print_close_tag("qualityControl");
                print_close_tag("method");

                print_open_tag("attributeList");
                  // take variables
                  $var_nid = $file_node->field_datafile_variable_ref;
                  foreach ($var_nid as $key1 => $value1){
                    foreach ($value1 as $key2 => $value2){
                      $var_node = node_load($value2);
                      print_open_tag("attribute");       
                        // print_value("attributeName", $var_node->); // this is needed, is the node title for the variable in the CCT 1.0 ((in node table))
                        print_value("attributeLabel", $var_node->field_attribute_label);
                        print_value("attributeDefinition", $var_node->field_var_definition);
                        
                        print_open_tag("measurementScale"); 
                        
!!!                        // in here is important the conditionals, 
                          // since we can only choose one type (datetime OR ration OR nominal)
                          //
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
                                // foreach.. cycle over multiple field_code_definition values.. there may be many
                                print_open_tag("codeDefinition");
                                     $codeDef=$var_node->field_code_definition);
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
                                     print_value("code",$matches["code"]);                     //                   code
                                     print_value("definition",$matches["definition"]);         //                   definition
                                print_close_tag("codeDefinition");
                                // close foreach
                              print_close_tag("enumeratedDomain");
                            print_close_tag("nonNumericDomain");
                          print_close_tag("nominal");
                          
                        print_close_tag("measurementScale");
                        
                        print_open_tag("missingValueCode");
                          print_value("missingValues", $var_node->field_var_missingvalues);
                        // similar as in codeDefinition -- but we can also tackle this at the CCT level...as we would rely on the data entry.       code
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
          ///  this "block" is reused in several parts within EML, 
          ///  may be a good idea to wrap this is a routine like you did for "person"... im ok cutting'n'pasting where needed to.
          ///
          $research_site_nid = $node->field_dataset_site_ref;
          foreach ($research_site_nid as $key1 => $value1){
            foreach ($value1 as $key2 => $value2){
              $research_site_node = node_load($value2);     
              print_open_tag("geographicCoverage");      
                print_open_tag("geographicDescription");      
                
                    //  HERE we need to concatenate all the content, as EML does not have "granularity".
                    //  I mean  concatenate ("Landform:", $research_site_node->field_research_site_landform, " Geology:", $research_site_node->field_research_site_landform...)
                    //  and all goes in the "geographicDescription" tag, so if we concat all in a $geoDesc variable, 
                    //  we would do print_value("geographicDescription", $geoDesc).  
                    //  To make it better, I would check for content before concatenating these pairs of Label-Content.
                    //
                   // print_open_tag("research_site");
                      //  print_open_tag("image");  // No photos in EML  
                      //    print_value("image",      $research_site_node->field_research_site_image);       
                      //  print_close_tag("image");
                      //  print_open_tag("landform");
                          print_value("landform",   $research_site_node->field_research_site_landform);    
                      //  print_close_tag("landform");
                      //  print_open_tag("geology");
                          print_value("geology",    $research_site_node->field_research_site_geology);     
                      //  print_close_tag("geology");
                      //  print_open_tag("soils");
                          print_value("soils",      $research_site_node->field_research_site_soils);       
                      //  print_close_tag("soils");
                      //  print_open_tag("hydrology");
                          print_value("hydrology",  $research_site_node->field_research_site_hydrology);   
                       // print_close_tag("hydrology");
                      //  print_open_tag("vegetation");
                          print_value("vegetation", $research_site_node->field_research_site_vegetation);  
                      //  print_close_tag("vegetation");
                      //  print_open_tag("climate");
                          print_value("climate",    $research_site_node->field_research_site_climate);     
                      //  print_close_tag("climate");
                      //  print_open_tag("history");
                          print_value("history",    $research_site_node->field_research_site_history);     
                      //  print_close_tag("history");
                      //  print_open_tag("siteid");
                          print_value("siteid",     $research_site_node->field_research_site_siteid);      
                      //  print_close_tag("siteid");   
                   // print_close_tag("research_site");     
                  print_close_tag("geographicDescription");
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
          }

        endforeach; //($row as $field => $content)
        print_close_tag("dataset");
      endforeach; //($themed_rows as $count => $row)
      print_close_tag("eml:eml");
?>