<?php
// $Id: views-bonus-eml-export-eml.tpl.php, v 3.0 11/09/10 ashipunova Exp $
/*
 * Template to display a view as an eml.
 */                                                                
 
 require_once("views-bonus-eml-export-eml-vars.tpl.php");
 
  /*
   * 3) create and populate a template
   */
    print '<?xml version="1.0" encoding="UTF-8" ?>';

  ?>

    <eml:eml xmlns:eml='eml://ecoinformatics.org/eml-2.0.1'
             xmlns:stmml='http://www.xml-cml.org/schema/stmml'
             xmlns:sw='eml://ecoinformatics.org/software-2.0.1'
             xmlns:cit='eml://ecoinformatics.org/literature-2.0.1'
             xmlns:ds='eml://ecoinformatics.org/dataset-2.0.1'
             xmlns:prot='eml://ecoinformatics.org/protocol-2.0.1'
             xmlns:doc='eml://ecoinformatics.org/documentation-2.0.1'
             xmlns:res='eml://ecoinformatics.org/resource-2.0.1'
             xmlns:xs='http://www.w3.org/2001/XMLSchema'
             xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'
             xsi:schemaLocation='eml://ecoinformatics.org/eml-2.0.1 eml.xsd'
             packageId='<?php print($package_id)?>'
             system='knb'>

  <?php

    /*
     * dataset start
     */


      views_bonus_eml_print_open_tag('dataset');
        views_bonus_eml_print_value('shortName', $dataset_short_name);
        views_bonus_eml_print_attributed_line('title', $dataset_title);

        // Person refs start
        views_bonus_eml_print_person('creator', $dataset_node['dataset_owner']);
        // metadataProvider from settings
        views_bonus_eml_print_person('metadataProvider', $metadata_provider_arr);

        $associated_party_arr = array (
          'data manager'         => 'dataset_datamanager',
          'field crew'           => 'dataset_fieldcrew',
          'labcrew'              => 'dataset_labcrew',
          'associate researcher' => 'dataset_ext_assoc',
        );

        if ($associated_party_arr) {
          foreach ($associated_party_arr as $key => $value) {
            if ($dataset_node[$value][0]->nid) {
                views_bonus_eml_print_person($key, $dataset_node[$value]);
            }
          }
        }    
        
        //pubDate
        views_bonus_eml_print_value('pubDate',  $dataset_publication_date);

        views_bonus_eml_print_attributed_line('language', $last_settings['last_language']);

        if ($dataset_abstract[0]['value']) {
          views_bonus_eml_print_open_tag('abstract');
           views_bonus_eml_print_open_tag('para');
            views_bonus_eml_print_value('literalLayout', $dataset_abstract);
           views_bonus_eml_print_close_tag('para');
          views_bonus_eml_print_close_tag('abstract');
        }

        // TODO: add if, depend of structure
        views_bonus_eml_print_open_tag('keywordSet');
          // dpr($node->taxonomy);
          // views_bonus_eml_print_value('keyword', node->taxonomy->term);
          // views_bonus_eml_print_value('keywordThesaurus', node->taxonomy->vocabularyName);
        views_bonus_eml_print_close_tag('keywordSet');

        if ($dataset_add_info[0]['value']) {
          views_bonus_eml_print_open_tag('additionalInfo');
            views_bonus_eml_print_open_tag('para');
               views_bonus_eml_print_value('literalLayout', $dataset_add_info);
               views_bonus_eml_print_value('related_links', $dataset_related_links);
            views_bonus_eml_print_close_tag('para');
          views_bonus_eml_print_close_tag('additionalInfo');
        }

        // $intellectual_rights from config file
        views_bonus_eml_print_open_tag('intellectualRights');
          views_bonus_eml_print_open_tag('section');
          views_bonus_eml_print_attributed_line('title', 'Data Policies');
            views_bonus_eml_print_open_tag('para');
              views_bonus_eml_print_attributed_line('literalLayout', $last_settings['last_intellectual_rights']);
            views_bonus_eml_print_close_tag('para');
          views_bonus_eml_print_close_tag('section');
        views_bonus_eml_print_close_tag('intellectualRights');

        // if there is one and only one file take path from it
        $dataset_datafile_path = $dataset_node['dataset_datafiles'][0]['datafile']->field_data_file[0]['filepath'];
        if ($dataset_datafile_path && !$dataset_node['dataset_datafiles'][1]) {
          views_bonus_eml_print_open_tag('distribution');
            views_bonus_eml_print_attributed_line('url', $urlBase . dirname($dataset_datafile_path));
          views_bonus_eml_print_close_tag('distribution');
        }

        if ($dataset_node['dataset_site'][0]['site_node']->nid || $dataset_beg_end_date[0]['value']) {
          views_bonus_eml_print_open_tag('coverage');
            views_bonus_eml_print_geographic_coverage($dataset_node['dataset_site']);
            views_bonus_eml_print_temporal_coverage($dataset_beg_end_date);
            // taxonomicCoverage here
          views_bonus_eml_print_close_tag('coverage');
        }

        if ($dataset_purpose[0]['value']) {
          views_bonus_eml_print_open_tag('purpose');
             views_bonus_eml_print_open_tag('para');
                views_bonus_eml_print_value('literalLayout', $dataset_purpose);
             views_bonus_eml_print_close_tag('para');
          views_bonus_eml_print_close_tag('purpose');
        }

        if ($dataset_maintenance[0]['value']) {
          views_bonus_eml_print_open_tag('maintenance');
            views_bonus_eml_print_open_tag('description');
               views_bonus_eml_print_open_tag('para');
                  views_bonus_eml_print_value('literalLayout', $dataset_maintenance);
               views_bonus_eml_print_close_tag('para');
            views_bonus_eml_print_close_tag('description');
          views_bonus_eml_print_close_tag('maintenance');
        }

        views_bonus_eml_print_person('contact', $dataset_node['dataset_contact']);
        //publisher, specific for every given site from config file,
        views_bonus_eml_print_person('publisher', $publisher_arr);
        views_bonus_eml_print_attributed_line('pubPlace', $views_bonus_eml_site_name);

        if ($dataset_methods[0]['value']) {
          views_bonus_eml_print_open_tag('methods');
            views_bonus_eml_print_open_tag('methodStep');
              views_bonus_eml_print_open_tag('description');  
                 views_bonus_eml_print_open_tag('section');
                   views_bonus_eml_print_open_tag('para');    // TODO: !!! ISG in the future, we may need to parse HTML (like h1,h2,h3, and translate it to EML markup)
                                                              //!!! if we could detect paragraphs, and translate them into <para>s, better...
                      views_bonus_eml_print_value('literalLayout', $dataset_methods);
                   views_bonus_eml_print_close_tag('para');
                 views_bonus_eml_print_close_tag('section');
              views_bonus_eml_print_close_tag('description');
              if ($dataset_instrumentation[0]['value']) {
                views_bonus_eml_print_value('instrumentation', $dataset_instrumentation);
              }
            views_bonus_eml_print_close_tag('methodStep');
            if ($dataset_quality[0]['value']) {
               views_bonus_eml_print_open_tag('qualityControl');
                  views_bonus_eml_print_open_tag('description');
                     views_bonus_eml_print_open_tag('para');
                         views_bonus_eml_print_value('literalLayout', $dataset_quality);
                     views_bonus_eml_print_close_tag('para');
                  views_bonus_eml_print_close_tag('description');
               views_bonus_eml_print_close_tag('qualityControl');
            }
          views_bonus_eml_print_close_tag('methods');
        }

       //TODO:  project (from CCT research_project). !!! ISG

       //TODO: access tag group - from config file, or from site variable, or... here is my take !!!
      
  ?>
  <access scope="document" order="allowFirst" authSystem="knb">
    <?php
     if ($acr) {
       views_bonus_eml_print_open_tag('allow');
          $access_string = "uid=$acr, o=lter, dc=ecoinformatics, dc=org";
          views_bonus_eml_print_attributed_line('principal',  $access_string);
          $access_string = 'all';
          views_bonus_eml_print_attributed_line('permission', $access_string);
       views_bonus_eml_print_close_tag('allow');
      }
    ?>
    <allow>
      <principal>public</principal>
      <permission>read</permission>
    </allow>
  </access>
  <?php
        // Data_file start
        unset($file_var_array);
        if ($dataset_node['dataset_datafiles'] && $dataset_node['dataset_datafiles'][0]['datafile']->nid) {
          foreach ($dataset_node['dataset_datafiles'] as $file_var_array) {

            // Collect all data_file values here to use in a conditions  
            $file_data_file         = $file_var_array['datafile']->field_data_file;
            $datafile_description   = $file_var_array['datafile']->field_datafile_description;
            $file_num_header_line   = $file_var_array['datafile']->field_num_header_line;
            $file_num_footer_lines  = $file_var_array['datafile']->field_num_footer_lines;
            $file_record_delimiter  = $file_var_array['datafile']->field_record_delimiter;
            $file_orientation       = $file_var_array['datafile']->field_orientation;
            $file_delimiter         = $file_var_array['datafile']->field_delimiter;
            $file_quote_character   = $file_var_array['datafile']->field_quote_character;
            $datafile_date          = $file_var_array['datafile']->field_beg_end_date;
            $file_instrumentation   = $file_var_array['datafile']->field_instrumentation;
            $file_methods           = $file_var_array['datafile']->field_methods;
            $file_quality           = $file_var_array['datafile']->field_quality;   
            $file_title             = $file_var_array['datafile']->title;

            views_bonus_eml_print_open_tag('dataTable');

            if ($file_data_file) {
              foreach ($file_data_file as $file_data) {
                views_bonus_eml_print_attributed_line('entityName', $file_data['filename']);
              }
            } else {
              views_bonus_eml_print_attributed_line('entityName', $file_title);
            }

            views_bonus_eml_print_value('entityDescription', $datafile_description);

            views_bonus_eml_print_open_tag('physical');
            if ($file_data_file) {
              foreach ($file_data_file as $file_data) {
                views_bonus_eml_print_attributed_line('objectName', $file_data['filename']);
             }
            } else {
              views_bonus_eml_print_attributed_line('objectName', $file_title);
            }
            views_bonus_eml_print_open_tag('dataFormat');
            // Here some tags are obligate: textFormat, attributeOrientation,
            // simpleDelimited, fieldDelimiter, complex
             views_bonus_eml_print_open_tag('textFormat');
               views_bonus_eml_print_value('numHeaderLines',       $file_num_header_line);
               views_bonus_eml_print_value('numFooterLines',       $file_num_footer_lines);
               views_bonus_eml_print_value('recordDelimiter',      $file_record_delimiter);
               views_bonus_eml_print_value('attributeOrientation', $file_orientation);
               views_bonus_eml_print_open_tag('simpleDelimited');                 
                 $file_delimiter[0]['value'] ? $file_delimiter = $file_delimiter[0]['value'] : $file_delimiter = ',';        
                 views_bonus_eml_print_attributed_line('fieldDelimiter',  $file_delimiter);
                 views_bonus_eml_print_value('quoteCharacter',     $file_quote_character);
               views_bonus_eml_print_close_tag('simpleDelimited');
             views_bonus_eml_print_close_tag('textFormat');
            views_bonus_eml_print_close_tag('dataFormat');
            if ($file_data_file && $file_data_file[0]['filepath']) {
             foreach ($file_data_file as $file_data) {
               views_bonus_eml_print_open_tag('distribution');
                 views_bonus_eml_print_attributed_line('url', $urlBase . $file_data['filepath']);
               views_bonus_eml_print_close_tag('distribution');
             }
            }
            views_bonus_eml_print_close_tag('physical');

            if ($file_var_array['datafile_sites'][0]['site_node']->nid || $datafile_date[0]['value']) {
               views_bonus_eml_print_open_tag('coverage');
                 views_bonus_eml_print_geographic_coverage($file_var_array['datafile_sites']);
                 views_bonus_eml_print_temporal_coverage($datafile_date);
                 // taxonomic coverage here
               views_bonus_eml_print_close_tag('coverage');
            }
            if ($file_methods[0]['value']) {
              views_bonus_eml_print_open_tag('methods');
                views_bonus_eml_print_open_tag('methodStep');
                  views_bonus_eml_print_open_tag('description');  
                     views_bonus_eml_print_open_tag('section');
                       views_bonus_eml_print_open_tag('para'); 
                          views_bonus_eml_print_value('literalLayout', $file_methods);
                       views_bonus_eml_print_close_tag('para');
                     views_bonus_eml_print_close_tag('section');
                  views_bonus_eml_print_close_tag('description');
                  if ($file_instrumentation[0]['value']) {
                    views_bonus_eml_print_value('instrumentation', $file_instrumentation);
                  }
                views_bonus_eml_print_close_tag('methodStep');
                if ($file_quality[0]['value']) {
                   views_bonus_eml_print_open_tag('qualityControl');
                      views_bonus_eml_print_open_tag('description');
                         views_bonus_eml_print_open_tag('para');
                             views_bonus_eml_print_value('literalLayout', $file_quality);
                         views_bonus_eml_print_close_tag('para');
                      views_bonus_eml_print_close_tag('description');
                   views_bonus_eml_print_close_tag('qualityControl');
                }
              views_bonus_eml_print_close_tag('methods');
            }

            // Variables start
            // Take variables here to use in conditions
            views_bonus_eml_print_open_tag('attributeList');

            foreach ($file_var_array['variables'] as $var_node) {
              if ($var_node->nid) {
                $var_title              = $var_node->title;
                $attribute_label        = $var_node->field_attribute_label;
                $var_definition         = $var_node->field_var_definition;
                $attribute_formatstring = $var_node->field_attribute_formatstring;
                $attribute_maximum      = $var_node->field_attribute_maximum;
                $attribute_minimum      = $var_node->field_attribute_minimum;
                $attribute_precision    = $var_node->field_attribute_precision;
                $attribute_unit         = $var_node->field_attribute_unit;
                $code_definitions       = $var_node->field_code_definition;
                $var_missingvalues      = $var_node->field_var_missingvalues;

                  views_bonus_eml_print_open_tag('attribute');
                    views_bonus_eml_print_attributed_line('attributeName',    $var_title);
                    views_bonus_eml_print_value('attributeLabel',      $attribute_label);
                    views_bonus_eml_print_value('attributeDefinition', $var_definition);
                    if ($attribute_formatstring[0]['value'] ||
                       $attribute_maximum[0]['value'] ||
                       $attribute_minimum[0]['value'] ||
                       $attribute_precision[0]['value'] ||
                       $attribute_unit[0]['value']) {
                    views_bonus_eml_print_open_tag('measurementScale');
                    if ($attribute_formatstring[0]['value']) {
                      views_bonus_eml_print_open_tag('datatime');
                       views_bonus_eml_print_value('formatstring',   $attribute_formatstring);
                      views_bonus_eml_print_close_tag('datatime');
                    }    
                  // ratio:     
                                               
                  // if ($attribute_maximum[0]['value'] ||
                  //     $attribute_minimum[0]['value'] ||
                  //     $attribute_precision[0]['value'] ||
                  //     $attribute_unit[0]['value']) {
                  //   views_bonus_eml_print_open_tag('ratio');
                  //   if ($attribute_unit[0]['value']) {
                  //     views_bonus_eml_print_open_tag('unit');
                  //       views_bonus_eml_print_value('customUnit', $attribute_unit);
                  //     views_bonus_eml_print_close_tag('unit');
                  //   }
                  //   if ($attribute_precision[0]['value']) {
                  //     views_bonus_eml_print_value('precision',      $attribute_precision);
                  //   }
                  //   if ($attribute_maximum[0]['value'] ||
                  //       $attribute_minimum[0]['value']) {
                  //     views_bonus_eml_print_open_tag('numericDomain');  
                  //       views_bonus_eml_print_value('numberType', $realNumber); 
                  //       views_bonus_eml_print_open_tag('bounds');
                  //         views_bonus_eml_print_value('maximum',    $attribute_maximum);
                  //         views_bonus_eml_print_value('minimum',    $attribute_minimum);
                  //       views_bonus_eml_print_close_tag('bounds');
                  //     views_bonus_eml_print_close_tag('numericDomain');
                  //   }
                  //   views_bonus_eml_print_close_tag('ratio');
                  // }         
                  // TODO: ask Inigo if he want 'numericDomain' always, even if it is empty. If not - use code just above this line.
                    if ($attribute_unit[0]['value']) {
                      views_bonus_eml_print_open_tag('ratio');
                        views_bonus_eml_print_open_tag('unit');
                          views_bonus_eml_print_value('customUnit', $attribute_unit);
                        views_bonus_eml_print_close_tag('unit');
                        if ($attribute_precision[0]['value']) {
                          views_bonus_eml_print_value('precision',      $attribute_precision);
                        }
                        views_bonus_eml_print_open_tag('numericDomain');
                          views_bonus_eml_print_value('numberType', $realNumber);
                          if ($attribute_maximum[0]['value'] ||
                          $attribute_minimum[0]['value']) {
                            views_bonus_eml_print_open_tag('bounds');
                            views_bonus_eml_print_value('maximum',    $attribute_maximum);
                            views_bonus_eml_print_value('minimum',    $attribute_minimum);
                            views_bonus_eml_print_close_tag('bounds');
                          }
                        views_bonus_eml_print_close_tag('numericDomain');
                      views_bonus_eml_print_close_tag('ratio');
                    }
                    if ($code_definitions[0]['value']) {
                     views_bonus_eml_print_open_tag('nominal');
                       views_bonus_eml_print_open_tag('nonNumericDomain');
                         foreach ($code_definitions as $code_definition) {      
                           views_bonus_eml_print_open_tag('enumeratedDomain');
                             if (preg_match("/(.+)=(.+)/", $code_definition['value'], $matches)) {     
                               views_bonus_eml_print_attributed_line('code',       $matches[1]);
                               views_bonus_eml_print_attributed_line('definition', $matches[2]);
                              }
                              else {
                                views_bonus_eml_print_attributed_line('codeDefinition', $code_definition['value']);
                              }
                           views_bonus_eml_print_close_tag('enumeratedDomain');
                         }
                       views_bonus_eml_print_close_tag('nonNumericDomain');
                     views_bonus_eml_print_close_tag('nominal');
                    }
                   views_bonus_eml_print_close_tag('measurementScale');
                 } // endif; if ($attribute_formatstring ||
                   //            $attribute_maximum || $attribute_minimum ||
                   //            $attribute_precision || $attribute_unit)

                 if ($var_missingvalues[0]['value']) {
                   views_bonus_eml_print_open_tag('missingValueCode');
                   foreach ($var_missingvalues as $var_missingvalue) {
                      if (preg_match("/(.+)=(.+)/", $var_missingvalue['value'], $matches)) {
                        views_bonus_eml_print_attributed_line('code',       $matches[1]);
                        views_bonus_eml_print_attributed_line('definition', $matches[2]);
                      }
                      else {
                        views_bonus_eml_print_attributed_line('missingValues', $var_missingvalue['value']);
                      }
                   }
                   views_bonus_eml_print_close_tag('missingValueCode');
                 }
                 views_bonus_eml_print_close_tag('attribute');
              }
            }
              views_bonus_eml_print_close_tag('attributeList');
            views_bonus_eml_print_close_tag('dataTable');
          }
        }
      views_bonus_eml_print_close_tag('dataset');
    views_bonus_eml_print_close_tag('eml:eml');

