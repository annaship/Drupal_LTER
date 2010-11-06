<?php
// $Id: views-bonus-eml-export-eml.tpl.php, v 1.0 9/23/10 11:29 AM ashipunova Exp $
/*
 * Template to display a view as an eml.
 */

// put allowed HTML tags here
function views_bonus_eml_my_strip_tags($content) {
  return strip_tags($content, '<p><h1><h2><h3><h4><h5><a><pre><para>');
}

function views_bonus_eml_print_tag_line($label, $content) {
  if ($content) {
    print '<' . $label . '>' . views_bonus_eml_my_strip_tags($content) . '</' . $label . '>';
  }
}

function views_bonus_eml_print_attr_line($label, $content, $attribute_name, $attribute_value) {
  if ($content && $attribute_value) {
    print '<' . $label . ' ' . $attribute_name . '="' . $attribute_value . '">'
      . views_bonus_eml_my_strip_tags($content) . '</' . $label . '>';

  }
}

function views_bonus_eml_print_open_tag($tag) {
  print '<' . $tag . '>';
}

function views_bonus_eml_print_close_tag($tag) {
  print '</' . $tag . '>';
}

function views_bonus_eml_print_value($tag, $content) {
  if ($content[0]['value']) {
    foreach ($content as $in_arr) {
        views_bonus_eml_print_tag_line($tag, views_bonus_eml_my_strip_tags($in_arr['value']));
    }
  }
}

// printing without foreach
function views_bonus_eml_get_uniq_value($content) {
  if ($content[0]['value']) {
    return views_bonus_eml_my_strip_tags($content[0]['value']);
  }
}

// Collect geo info into one string,
// only for the first time make $comma_flag = 0, to skip comma
function views_bonus_eml_get_geo($label, $content, $comma_flag = 1) {
  $geoDesc = '';
  if ($content[0]['value']) {
    foreach($content as $value) {
      if ($comma_flag == 1) {
        $geoDesc .= ', ' . $label . ': ' . $value['value'];
      }
      else {
        $geoDesc .= $label . ': ' . $value['value'];
      }
    }
  }
  return $geoDesc;
} // function views_bonus_eml_get_geo

function views_bonus_eml_print_person($person_tag, $ref_field_arr) {
  if ($ref_field_arr[0]['nid']) {
    foreach ($ref_field_arr as $value1) {
      foreach ($value1 as $value2) {
        $person_node = node_load($value2);
        
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
        $not_show_role        = array ('owner', 'creator', 'contact');

        views_bonus_eml_print_open_tag($person_tag);
          views_bonus_eml_print_open_tag('individualName');
            views_bonus_eml_print_value('givenName',          $person_first_name);
            views_bonus_eml_print_value('surName',            $person_last_name);
          views_bonus_eml_print_close_tag('individualName');
            views_bonus_eml_print_value('organization',       $person_organization);
            views_bonus_eml_print_value('deliveryPoint',      $person_address);
            views_bonus_eml_print_value('city',               $person_city);
            views_bonus_eml_print_value('administrativeArea', $person_state);
            views_bonus_eml_print_value('postalCode',         $person_zipcode);
            views_bonus_eml_print_value('country',            $person_country);
            views_bonus_eml_print_attr_line('phone', views_bonus_eml_get_uniq_value($person_phone),
                            'phonetype', 'voice');
            views_bonus_eml_print_attr_line('phone', views_bonus_eml_get_uniq_value($person_fax),
                            'phonetype', 'fax');
            if (!in_array($person_role, $not_show_role)) {
              views_bonus_eml_print_tag_line('role', $person_role);
            }
            if ($person_email[0]['email']) {
              foreach($person_email as $email) {
                views_bonus_eml_print_tag_line('electronicMailAddress', $email['email']);
              }
            }
            views_bonus_eml_print_value('personid', $person_personid);
          } // endforeach; inner cycle for $ref_field_arr ($value1 as $value2)
      views_bonus_eml_print_close_tag($person_tag);
    } // endforeach; ($ref_field_arr as $value1)
  } // endif; if ($ref_field_arr[0]['nid'])
} // function views_bonus_eml_print_person

function views_bonus_eml_print_temporal_coverage($beg_end_date) {
  if ($beg_end_date[0]['value']) {
    views_bonus_eml_print_open_tag('temporalCoverage');
    foreach($beg_end_date as $dataset_date) {
      $first_date  = $dataset_date['value'];
      $second_date = $dataset_date['value2'];
      if ($first_date == $second_date) {
         views_bonus_eml_print_open_tag('singleDateTime');
           views_bonus_eml_print_tag_line('calendarDate', $first_date);
         views_bonus_eml_print_close_tag('singleDateTime');
      }
      else {
        views_bonus_eml_print_open_tag('rangeOfDates');
          views_bonus_eml_print_open_tag('beginDate');
            views_bonus_eml_print_tag_line('calendarDate', $first_date);
          views_bonus_eml_print_close_tag('beginDate');
          views_bonus_eml_print_open_tag('endDate');
            views_bonus_eml_print_tag_line('calendarDate', $second_date);
          views_bonus_eml_print_close_tag('endDate');
        views_bonus_eml_print_close_tag('rangeOfDates');
      }
    }
    views_bonus_eml_print_close_tag('temporalCoverage');
  }
} // function views_bonus_eml_print_temporal_coverage

// take research_site as geographicCoverage
function views_bonus_eml_print_geographic_coverage($research_site_nid) {
  if ($research_site_nid[0]['nid']) {
    foreach ($research_site_nid as $value1) {
      foreach ($value1 as $value2) {
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
        if ($research_site_landform[0]['value']   || 
            $research_site_geology[0]['value']    ||
            $research_site_soils[0]['value']      || 
            $research_site_hydrology[0]['value']  ||
            $research_site_vegetation[0]['value'] || 
            $research_site_climate[0]['value']    ||
            $research_site_history[0]['value']    || 
            $research_site_siteid[0]['value']     ||
            !empty($research_site_pt_coords)      ||
            $research_site_elevation[0]['value']) {
          views_bonus_eml_print_open_tag('geographicCoverage');
            $geoDesc  = views_bonus_eml_get_geo('Landform',   $research_site_landform, 0);
            $geoDesc .= views_bonus_eml_get_geo('Geology',    $research_site_geology);
            $geoDesc .= views_bonus_eml_get_geo('Soils',      $research_site_soils);
            $geoDesc .= views_bonus_eml_get_geo('Hydrology',  $research_site_hydrology);
            $geoDesc .= views_bonus_eml_get_geo('Vegetation', $research_site_vegetation);
            $geoDesc .= views_bonus_eml_get_geo('Climate',    $research_site_climate);
            $geoDesc .= views_bonus_eml_get_geo('History',    $research_site_history);
            $geoDesc .= views_bonus_eml_get_geo('siteid',     $research_site_siteid);
            views_bonus_eml_print_tag_line('geographicDescription', $geoDesc);

            if (!empty($research_site_pt_coords) ||
                ($research_site_elevation[0]['value'])) {
              views_bonus_eml_print_open_tag('boundingCoordinates');
                //there is some parsing TODO here, need the longitude only
                views_bonus_eml_print_value('westBoundingCoordinate',   $research_site_pt_coords);   
                views_bonus_eml_print_value('eastBoundingCoordinate',   $research_site_pt_coords);
                views_bonus_eml_print_value('northBoundingCoordinate',  $research_site_pt_coords);   
                views_bonus_eml_print_value('southBoundingCoordinate',  $research_site_pt_coords);   

                views_bonus_eml_print_open_tag('boundingAltitudes'); 
                  views_bonus_eml_print_value('altitudeMinimum',  $research_site_elevation);
                  views_bonus_eml_print_value('altitudeMaximum',  $research_site_elevation);
                views_bonus_eml_print_close_tag('boundingAltitudes');
              views_bonus_eml_print_close_tag('boundingCoordinates');
            }
          views_bonus_eml_print_close_tag('geographicCoverage');
        } // endif; check if values exist
      } // endforeach; ($value1 as $value2) - inner cycle for research_site_nid
    } // endforeach; research_site_nid
  } // endif; $research_site_nid[0]['nid']
} // function views_bonus_eml_print_geographic_coverage


// Url for datafile urls, using Drupal variable
$urlBase = 'http://' . $_SERVER['HTTP_HOST'] . '/';

// ---------- end of config section ----------

print '<?xml version="1.0" encoding="UTF-8" ?>';

// TODO: move into config file
// $package_id = 'knb-lter-pie.3.6';

include_once 'config_eml.php';

// $themed_rows comes from eml view
  foreach ($themed_rows as $row) {
/* dataset start
*/

  $node = array();
  views_bonus_eml_print_open_tag('dataset');

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

    foreach ($row as $content) {
      $node = node_load($content);
      // collect all dataset values here to use in a conditions
      $dataset_short_name       = $node->field_dataset_short_name;
      $dataset_title            = $node->title;
      $dataset_owner_ref        = $node->field_dataset_owner_ref;
      $dataset_datamanager_ref  = $node->field_dataset_datamanager_ref;
      $dataset_fieldcrew_ref    = $node->field_dataset_fieldcrew_ref;
      $dataset_labcrew_ref      = $node->field_dataset_labcrew_ref;
      $dataset_ext_assoc_ref    = $node->field_dataset_ext_assoc_ref;
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

      // Take an attached file(s), a result used here and in DataTable
      $file_nid      = array();  // remove previous one
      $file_nid      = $node->field_dataset_datafile_ref;
      $file_node_arr = array();
      $file_data_arr = array();
      // Check if there is one
      if ($file_nid[0]['nid']) {
        foreach ($file_nid as $value1) {
          foreach ($value1 as $value2) {
            $file_node       = node_load($value2);
            dpr($file_node);
            
            $file_node_arr[] = $file_node;
            // Used only for dataset distribution; collected here to avoid
            //    one more foreach
            foreach($file_node->field_data_file as $file_data) {
              $file_data_arr[] = $file_data;
            }
          }
        }
      }

      views_bonus_eml_print_value('shortName', $dataset_short_name);
      views_bonus_eml_print_tag_line('title', $dataset_title);

      // Person refs start
      views_bonus_eml_print_person('owner', $dataset_owner_ref);

      // TODO: hardcode the metadataProvider, specific for every given site
      // put it into config file,
      // add a description, what should be changed

      views_bonus_eml_print_open_tag('metadataProvider');
        views_bonus_eml_print_tag_line('givenName',             '');
        views_bonus_eml_print_tag_line('surname',               '');
        views_bonus_eml_print_tag_line('organization',          '');
        views_bonus_eml_print_tag_line('deliveryPoint',         '');
        views_bonus_eml_print_tag_line('city',                  '');
        views_bonus_eml_print_tag_line('administrativeArea',    '');
        views_bonus_eml_print_tag_line('postalCode',            '');
        views_bonus_eml_print_tag_line('country',               '');
        views_bonus_eml_print_tag_line('phone',                 '');
        views_bonus_eml_print_tag_line('fax',                   '');
        views_bonus_eml_print_tag_line('role',                  '');
        views_bonus_eml_print_tag_line('electronicMailAddress', '');
        views_bonus_eml_print_tag_line('personid',              '');
      views_bonus_eml_print_close_tag('metadataProvider');

      if ($dataset_datamanager_ref[0]['nid']  || $dataset_fieldcrew_ref[0]['nid'] ||
          $dataset_labcrew_ref[0]['nid']      || $dataset_ext_assoc_ref[0]['nid']) {
        views_bonus_eml_print_open_tag('associatedParty');
          views_bonus_eml_print_person('data_manager',  $dataset_datamanager_ref);
        views_bonus_eml_print_close_tag('associatedParty');
        views_bonus_eml_print_person('field_crew',    $dataset_fieldcrew_ref);
          views_bonus_eml_print_person('labcrew',       $dataset_labcrew_ref);
          views_bonus_eml_print_person('ext_assoc',     $dataset_ext_assoc_ref);
      }

      views_bonus_eml_print_value('pubDate',  $dataset_publication_date);
      views_bonus_eml_print_value('abstract', $dataset_abstract);

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
          views_bonus_eml_print_close_tag('para');
        views_bonus_eml_print_close_tag('additionalInfo');
      }

      // TODO: hardcode the intellectualRights, specific for every given site
      // put it into config file,
      // add a description, what should be changed

      views_bonus_eml_print_open_tag('intellectualRights');
        views_bonus_eml_print_open_tag('section');
        views_bonus_eml_print_tag_line('title', 'Data Policies');
          views_bonus_eml_print_open_tag('para');
            views_bonus_eml_print_tag_line('literalLayout', $intellectual_rights);
          views_bonus_eml_print_close_tag('para');
        views_bonus_eml_print_close_tag('section');
      views_bonus_eml_print_close_tag('intellectualRights');

      // if there is one and only one file take path from it
      if ($file_data_arr[0]['filepath'] && !$file_data_arr[1]) {
        views_bonus_eml_print_open_tag('distribution');
          views_bonus_eml_print_tag_line('url', $urlBase . dirname($file_data_arr[0]['filepath']));
        views_bonus_eml_print_close_tag('distribution');
      }

      if ($dataset_site_ref[0]['nid'] || $dataset_beg_end_date[0]['value']) {
        views_bonus_eml_print_open_tag('coverage');
          views_bonus_eml_print_geographic_coverage($dataset_site_ref);
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

      views_bonus_eml_print_person('contact', $dataset_contact_ref);

      // TODO: hardcode the publisher, specific for every given site
      // put it into config file,
      // add a description, what should be changed
      views_bonus_eml_print_open_tag('publisher');
        views_bonus_eml_print_tag_line('givenName',             '');
        views_bonus_eml_print_tag_line('surname',               '');
        views_bonus_eml_print_tag_line('organization',          '');
        views_bonus_eml_print_tag_line('deliveryPoint',         '');
        views_bonus_eml_print_tag_line('city',                  '');
        views_bonus_eml_print_tag_line('administrativeArea',    '');
        views_bonus_eml_print_tag_line('postalCode',            '');
        views_bonus_eml_print_tag_line('country',               '');
        views_bonus_eml_print_tag_line('phone',                 '');
        views_bonus_eml_print_tag_line('fax',                   '');
        views_bonus_eml_print_tag_line('role',                  '');
        views_bonus_eml_print_tag_line('electronicMailAddress', '');
        views_bonus_eml_print_tag_line('personid',              '');
      views_bonus_eml_print_close_tag('publisher');

      // TODO: hardcode the pubPlace, specific for every given site
      // example: <pubPLace> Plum Island Ecosystems LTER </pubPlace>
      $views_bonus_eml_site_name = variable_get('site_name', NULL);
      views_bonus_eml_print_tag_line('pubPlace', $views_bonus_eml_site_name);

      if ($dataset_instrumentation[0]['value'] || 
          $dataset_methods[0]['value']         ||
          $dataset_quality[0]['value']) {
        views_bonus_eml_print_open_tag('methods');
        if ($dataset_instrumentation[0]['value'] || $dataset_methods[0]['value']) {
          views_bonus_eml_print_open_tag('methodStep');
            views_bonus_eml_print_value('instrumentation',  $dataset_instrumentation);
            views_bonus_eml_print_value('description',      $dataset_methods);
          views_bonus_eml_print_close_tag('methodStep');
        }

        if ($dataset_quality[0]['value']) {
          views_bonus_eml_print_open_tag('qualityControl');
            views_bonus_eml_print_value('description',      $dataset_quality);
          views_bonus_eml_print_close_tag('qualityControl');
        }
        views_bonus_eml_print_close_tag('methods');
      }

      views_bonus_eml_print_value('field_dataset_id', $dataset_id);
      views_bonus_eml_print_value('related_links',    $dataset_related_links);


      // Data_file start
      if ($file_node_arr) {
        foreach ($file_node_arr as $file_node) {

          // Collect all data_file values here to use in a conditions
          $file_data_file         = $file_node->field_data_file;
          $datafile_description   = $file_node->field_datafile_description;
          $file_num_header_line   = $file_node->field_num_header_line;
          $file_num_footer_lines  = $file_node->field_num_footer_lines;
          $file_record_delimiter  = $file_node->field_record_delimiter;
          $file_orientation       = $file_node->field_orientation;
          $file_delimiter         = $file_node->field_delimiter;
          $file_quote_character   = $file_node->field_quote_character;
          $datafile_site_ref      = $file_node->field_datafile_site_ref;
          $datafile_date          = $file_node->field_datafile_date;
          $file_instrumentation   = $file_node->field_instrumentation;
          $file_methods           = $file_node->field_methods;
          $file_quality           = $file_node->field_quality;

          views_bonus_eml_print_open_tag('dataTable');
            foreach ($file_data_file as $file_data) {
              views_bonus_eml_print_tag_line('entityName', $file_data['filename']);
            }
            views_bonus_eml_print_value('entityDescription', $datafile_description);
            views_bonus_eml_print_open_tag('physical');
              foreach ($file_data_file as $file_data) {
                views_bonus_eml_print_tag_line('objectName', $file_data['filename']);
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
                    views_bonus_eml_print_value('fieldDelimiter',     $file_delimiter);
                    views_bonus_eml_print_value('quoteCharacter',     $file_quote_character);
                  views_bonus_eml_print_close_tag('simpleDelimited');
                views_bonus_eml_print_close_tag('textFormat');
              views_bonus_eml_print_close_tag('dataFormat');
              if ($file_data_file[0]['filepath']) {
                foreach ($file_data_file as $file_data) {
                    views_bonus_eml_print_open_tag('distribution');
                      views_bonus_eml_print_tag_line('url', $urlBase . $file_data['filepath']);
                    views_bonus_eml_print_close_tag('distribution');
                }
              }
            views_bonus_eml_print_close_tag('physical');

            if ($datafile_site_ref[0]['nid'] || $datafile_date[0]['nid']) {
              views_bonus_eml_print_open_tag('coverage');
                views_bonus_eml_print_geographic_coverage($datafile_site_ref);
                views_bonus_eml_print_temporal_coverage($datafile_date);
                // taxonomic coverage here
              views_bonus_eml_print_close_tag('coverage');
            }


            if ($file_instrumentation[0]['value'] || 
                $file_methods[0]['value']         ||
                $quality[0]['value']) {
              views_bonus_eml_print_open_tag('method');
              if ($file_instrumentation[0]['value'] ||
                  $file_methods[0]['value']) {
                views_bonus_eml_print_open_tag('methodStep');
                  views_bonus_eml_print_value('instrumentation',  $file_instrumentation);
                  views_bonus_eml_print_value('description',      $file_methods);
                views_bonus_eml_print_close_tag('methodStep');
              }
              if ($file_quality[0]['value']) {
                views_bonus_eml_print_open_tag('qualityControl');
                  views_bonus_eml_print_value('description',      $file_quality);
                views_bonus_eml_print_close_tag('qualityControl');
              }
              views_bonus_eml_print_close_tag('method');
            }

            // Variables start
            // Take variables here to use in conditions
            $var_nid = $file_node->field_datafile_variable_ref;
            if ($var_nid[0]['nid']) {
              views_bonus_eml_print_open_tag('attributeList');
              foreach ($var_nid as $value1) {
                foreach ($value1 as $value2) {
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

                  views_bonus_eml_print_open_tag('attribute');
                    views_bonus_eml_print_tag_line('attributeName',    $var_title);
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
                    if ($attribute_maximum[0]['value'] ||
                        $attribute_minimum[0]['value'] ||
                        $attribute_precision[0]['value'] ||
                        $attribute_unit[0]['value']) {
                      views_bonus_eml_print_open_tag('ratio');
                      if ($attribute_maximum[0]['value'] ||
                          $attribute_minimum[0]['value']) {
                        views_bonus_eml_print_open_tag('numericDomain');
                          views_bonus_eml_print_open_tag('bounds');
                            views_bonus_eml_print_value('maximum',    $attribute_maximum);
                            views_bonus_eml_print_value('minimum',    $attribute_minimum);
                          views_bonus_eml_print_close_tag('bounds');
                        views_bonus_eml_print_close_tag('numericDomain');
                      }
                      if ($attribute_precision[0]['value']) {
                        views_bonus_eml_print_value('precision',      $attribute_precision);
                      }
                      if ($attribute_unit[0]['value']) {
                      views_bonus_eml_print_open_tag('unit');
                          views_bonus_eml_print_value('standardUnit', $attribute_unit);
                        views_bonus_eml_print_close_tag('unit');
                      }
                      views_bonus_eml_print_close_tag('ratio');
                     }
                     if ($code_definition[0]['value']) {
                      views_bonus_eml_print_open_tag('nominal');
                        views_bonus_eml_print_open_tag('nonNumericDomain');
                          views_bonus_eml_print_open_tag('enumeratedDomain');
                              views_bonus_eml_print_value('codeDefinition', $code_definition);
                          views_bonus_eml_print_close_tag('enumeratedDomain');
                        views_bonus_eml_print_close_tag('nonNumericDomain');
                      views_bonus_eml_print_close_tag('nominal');
                     }
                    views_bonus_eml_print_close_tag('measurementScale');
                  } // endif; if ($attribute_formatstring ||
                    //            $attribute_maximum || $attribute_minimum ||
                    //            $attribute_precision || $attribute_unit)

                  if ($var_missingvalues[0]['value']) {
                    views_bonus_eml_print_open_tag('missingValueCode');
                      views_bonus_eml_print_value('missingValues', $var_missingvalues);
                    views_bonus_eml_print_close_tag('missingValueCode');
                  }
                  views_bonus_eml_print_close_tag('attribute');
                } // endforeach; inner cycle by $value1
              } // endforeach;  ($var_nid as $value1)
              views_bonus_eml_print_close_tag('attributeList');
            } // endif; ($var_nid[0]['nid'])
          views_bonus_eml_print_close_tag('dataTable');
        } // endforeach; ($file_node_arr as $file_node)
      } // endif; if ($file_node_arr)
    } // endforeach; ($row as $field => $content)
    views_bonus_eml_print_close_tag('eml:eml');
} // endforeach; ($themed_rows as $count => $row)
views_bonus_eml_print_close_tag('dataset');
?>
