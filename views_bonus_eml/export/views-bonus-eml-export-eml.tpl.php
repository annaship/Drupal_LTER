<?php
// $Id: views-bonus-eml-export-eml.tpl.php, v 2.0 11/09/10 ashipunova Exp $
/*
 * Template to display a view as an eml.
 */

/*
 * public functions and variables
 */

function views_bonus_eml_print_open_tag($tag) {
  print '<' . $tag . '>';
}

function views_bonus_eml_print_close_tag($tag) {
  print '</' . $tag . '>';
}

function views_bonus_eml_print_tag_line($label, $content) {
  if ($content) {
    print '<' . $label . '>' . views_bonus_eml_my_strip_tags($content) . '</' . $label . '>';
  }
}

function views_bonus_eml_print_value($tag, $content) {
  if ($content[0]['value']) {
    foreach ($content as $in_arr) {
        views_bonus_eml_print_tag_line($tag, views_bonus_eml_my_strip_tags($in_arr['value']));
    }
  }
}

function views_bonus_eml_print_attr_line($label, $content, $attribute_name, $attribute_value) {
  if ($content && $attribute_value) {
    print '<' . $label . ' ' . $attribute_name . '="' . $attribute_value . '">'
      . views_bonus_eml_my_strip_tags($content) . '</' . $label . '>';

  }
}

// printing without foreach
function views_bonus_eml_get_uniq_value($content) {
  if ($content[0]['value']) {
    return views_bonus_eml_my_strip_tags($content[0]['value']);
  }
}

function views_bonus_eml_print_person($person_tag, $content) {
  if ($content[0]->nid) {
    foreach ($content as $person_node) {
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
          views_bonus_eml_print_value('givenName',        $person_first_name);
          views_bonus_eml_print_value('surName',          $person_last_name);
        views_bonus_eml_print_close_tag('individualName');
        views_bonus_eml_print_value('organization',       $person_organization);
        views_bonus_eml_print_value('deliveryPoint',      $person_address);
        views_bonus_eml_print_value('city',               $person_city);
        views_bonus_eml_print_value('administrativeArea', $person_state);
        views_bonus_eml_print_value('postalCode',         $person_zipcode);
        views_bonus_eml_print_value('country',            $person_country);
        views_bonus_eml_print_attr_line('phone',
                        views_bonus_eml_get_uniq_value($person_phone),
                        'phonetype', 'voice');
        views_bonus_eml_print_attr_line('phone',
                        views_bonus_eml_get_uniq_value($person_fax),
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
      views_bonus_eml_print_close_tag($person_tag);
    }
  }
} // end of function "views_bonus_eml_print_person"


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
} // end of function "views_bonus_eml_print_temporal_coverage"


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
} // end of function views_bonus_eml_get_geo

// take research_site as geographicCoverage
function views_bonus_eml_print_geographic_coverage($content) {
//  if ($content[0]->nid) {
//    foreach ($content as $person_node) {
//  dpr($research_site);
  if ($content[0]->nid) {
    foreach ($content as $research_site_node) {
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

//            dpr($research_site_pt_coords);
            if (!empty($research_site_pt_coords) ||
                ($research_site_elevation[0]['value'])) {
              views_bonus_eml_print_open_tag('boundingCoordinates');
                //there is some parsing TODO here, need the longitude only
                views_bonus_eml_print_value('westBoundingCoordinate',  $research_site_pt_coords);
                views_bonus_eml_print_value('eastBoundingCoordinate',  $research_site_pt_coords);
                views_bonus_eml_print_value('northBoundingCoordinate', $research_site_pt_coords);
                views_bonus_eml_print_value('southBoundingCoordinate', $research_site_pt_coords);

                views_bonus_eml_print_open_tag('boundingAltitudes');
                  views_bonus_eml_print_value('altitudeMinimum',  $research_site_elevation);
                  views_bonus_eml_print_value('altitudeMaximum',  $research_site_elevation);
                views_bonus_eml_print_close_tag('boundingAltitudes');
              views_bonus_eml_print_close_tag('boundingCoordinates');
            }
          views_bonus_eml_print_close_tag('geographicCoverage');
        } // endif; check if values exist
    } // endforeach; research_site_nid
  } // endif; $research_site_nid[0]['nid']
} // end of function views_bonus_eml_print_geographic_coverage



//http://stackoverflow.com/questions/526556/how-to-flatten-a-multi-dimensional-array-to-simple-one-in-php

function flatten_array($array, $preserve_keys = 0, &$out = array()) {
    # Flatten a multidimensional array to one dimension, optionally preserving keys.
    #
    # $array - the array to flatten
    # $preserve_keys - 0 (default) to not preserve keys, 1 to preserve string keys only, 2 to preserve all keys
    # $out - internal use argument for recursion
    if ($array) {
      foreach($array as $key => $child)
          if(is_array($child))
              $out = flatten_array($child, $preserve_keys, $out);
          elseif($preserve_keys + is_string($key) > 1)
              $out[$key] = $child;
          else
              $out[] = $child;
      return $out;
    }
}

// Url for datafile urls, using Drupal variable
$urlBase = 'http://' . $_SERVER['HTTP_HOST'] . '/';

// public functions end

/*
 * 1) take all from db as an Obect?/Array?
 * 2) calculate vid version
 * 3) create a template
 * 4) populate data into the template
 */
//  unset ($dataset_node);
//  unset ($node);
  
  foreach ($themed_rows as $row) {
/*
 * dataset start
 */

  $ver_vid            = 0;
  $dataset_node       = Array();
  $node               = Array();
  $owner_nodes        = Array();
  $contact_nodes      = Array();
  $datamanager_nodes  = Array();
  $fieldcrew_nodes    = Array();
  $labcrew_nodes      = Array();
  $ext_assoc_nodes    = Array();
  $site_nodes         = Array();
  $datafile_nodes     = Array();

//   * 1) take all from db as an Obect?/Array?
foreach ($row as $row_nid) {
    $node = node_load($row_nid);
    $dataset_node[dataset] = $node;

//  refs
    $field_dataset_owner_ref_nid = $node->field_dataset_owner_ref;
    foreach ($field_dataset_owner_ref_nid as $v) {
      foreach ($v as $owner_nid) {
        $owner_nodes[] = node_load($owner_nid);
        }
     }
     $dataset_node[dataset_owners] = $owner_nodes;

    $field_dataset_contact_ref_nid = $node->field_dataset_contact_ref;
    foreach ($field_dataset_contact_ref_nid as $v) {
      foreach ($v as $contact_nid) {
        $contact_nodes[] = node_load($contact_nid);
        }
     }

     $dataset_node[dataset_contacts] = $contact_nodes;

    $field_dataset_datamanager_ref_nid = $node->field_dataset_datamanager_ref;
    foreach ($field_dataset_datamanager_ref_nid as $v) {
      foreach ($v as $datamanager_nid) {
        $datamanager_nodes[] = node_load($datamanager_nid);
        }
     }
     $dataset_node[dataset_datamanagers] = $datamanager_nodes;


    $field_dataset_fieldcrew_ref_nid = $node->field_dataset_fieldcrew_ref;
    foreach ($field_dataset_fieldcrew_ref_nid as $v) {
      foreach ($v as $fieldcrew_nid) {
        $fieldcrew_nodes[] = node_load($fieldcrew_nid);
        }
     }
     $dataset_node[dataset_fieldcrew] = $fieldcrew_nodes;

    $field_dataset_labcrew_ref_nid = $node->field_dataset_labcrew_ref;
    foreach ($field_dataset_labcrew_ref_nid as $v) {
      foreach ($v as $labcrew_nid) {
        $labcrew_nodes[] = node_load($labcrew_nid);
        }
     }
     $dataset_node[dataset_labcrew] = $labcrew_nodes;

    $field_dataset_ext_assoc_ref_nid = $node->field_dataset_ext_assoc_ref;
    if ($field_dataset_ext_assoc_ref_nid) {
      foreach ($field_dataset_ext_assoc_ref_nid as $v) {
        foreach ($v as $ext_assoc_nid) {
          $ext_assoc_nodes[] = node_load($ext_assoc_nid);
          }
       }
       $dataset_node[dataset_ext_assoc] = $ext_assoc_nodes;
    }

    if ($node->field_dataset_site_ref) {
      $field_dataset_site_ref_nid = $node->field_dataset_site_ref;
      foreach ($field_dataset_site_ref_nid as $v) {
        foreach ($v as $site_nid) {
          $site_nodes[] = node_load($site_nid);
          }
       }
       $dataset_node[dataset_site] = $site_nodes;
    }

//  datafile
    $field_dataset_datafile_ref_nid = $node->field_dataset_datafile_ref;
    foreach ($field_dataset_datafile_ref_nid as $v) {
      foreach ($v as $datafile_nid) {
        $variable_nodes = array();
        $site_nodes     = array();
        $datafile_node  = node_load($datafile_nid);
//      variables
        $field_datafile_variable_ref_nids = $datafile_node->field_datafile_variable_ref;
        foreach ($field_datafile_variable_ref_nids as $value) {
          foreach ($value as $var_nid) {
            $variable_nodes[] = node_load($var_nid);
          }
        }
//      sites
        $field_datafile_site_ref_nids = $datafile_node->field_datafile_site_ref;
        if ($field_datafile_site_ref_nids) {
          foreach ($field_datafile_site_ref_nids as $value) {
            foreach ($value as $site_nid) {
              $site_nodes[] = node_load($site_nid);
            }
          }
        }
        $datafile_nodes[] = array ('datafile'       => $datafile_node,
                                   'variables'      => $variable_nodes,
                                   'datafile_sites' => $site_nodes);
//        see file-var_str.txt
     }
    }
    $dataset_node[dataset_datafiles] = $datafile_nodes;
  }

//dpr($datafile_nodes);

/*
 * 1a) create dataset variables here
 */

$dataset_short_name       = $dataset_node[dataset]->field_dataset_short_name;
$dataset_title            = $dataset_node[dataset]->title;
$dataset_publication_date = $dataset_node[dataset]->field_dataset_publication_date;
$dataset_abstract         = $dataset_node[dataset]->field_dataset_abstract;
$dataset_add_info         = $dataset_node[dataset]->field_dataset_add_info;
$dataset_beg_end_date     = $dataset_node[dataset]->field_beg_end_date;
$dataset_purpose          = $dataset_node[dataset]->field_dataset_purpose;
$dataset_maintenance      = $dataset_node[dataset]->field_dataset_maintenance;
$dataset_instrumentation  = $dataset_node[dataset]->field_instrumentation;
$dataset_methods          = $dataset_node[dataset]->field_methods;
$dataset_quality          = $dataset_node[dataset]->field_quality;
$dataset_id               = $dataset_node[dataset]->field_dataset_id;
$dataset_related_links    = $dataset_node[dataset]->field_dataset_related_links;

  /* -----------------
   * 2) calculate vid version
   * ---------------------
   */
  $ver_vid += $dataset_node[dataset]->vid;

//  persons and sites vid
  
  $dataset_ref = array(
    'dataset_owners',
    'dataset_contacts',
    'dataset_datamanagers',
    'dataset_fieldcrew',
    'dataset_labcrew',
    'dataset_ext_assoc',
    'dataset_sites'
  );

  foreach ($dataset_ref as $ref) {
    if ($dataset_node[$ref][0]) {
      foreach ($dataset_node[$ref] as $person) {
        $ver_vid += $person->vid;
      }
    }
  }

// vid of datafiles + variables
 $flatten_files = flatten_array($dataset_node[dataset_datafiles]);
 if ($flatten_files) {
   foreach ($flatten_files as $object_value) {
     $ver_vid += $object_value->vid;
   }
 }
//  print "\$ver_vid = ".$ver_vid."\n";

  /*
   * 3) create a template
   */


  print '<?xml version="1.0" encoding="UTF-8" ?>';
  
  include_once 'config_eml.php';

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

      views_bonus_eml_print_value('shortName', $dataset_short_name);
      views_bonus_eml_print_tag_line('title', $dataset_title);

      // Person refs start
      views_bonus_eml_print_person('owner', $dataset_node[dataset_owners]);

      views_bonus_eml_print_open_tag('metadataProvider');
        views_bonus_eml_print_tag_line($metadata_provider_givenName,             '');
        views_bonus_eml_print_tag_line($metadata_provider_surname,               '');
        views_bonus_eml_print_tag_line($metadata_provider_organization,          '');
        views_bonus_eml_print_tag_line($metadata_provider_deliveryPoint,         '');
        views_bonus_eml_print_tag_line($metadata_provider_city,                  '');
        views_bonus_eml_print_tag_line($metadata_provider_administrativeArea,    '');
        views_bonus_eml_print_tag_line($metadata_provider_postalCode,            '');
        views_bonus_eml_print_tag_line($metadata_provider_country,               '');
        views_bonus_eml_print_tag_line($metadata_provider_phone,                 '');
        views_bonus_eml_print_tag_line($metadata_provider_fax,                   '');
        views_bonus_eml_print_tag_line($metadata_provider_role,                  '');
        views_bonus_eml_print_tag_line($metadata_provider_electronicMailAddress, '');
        views_bonus_eml_print_tag_line($metadata_provider_personid,              '');
      views_bonus_eml_print_close_tag('metadataProvider');

      if ($dataset_node[dataset_datamanagers][0]->nid) {
        views_bonus_eml_print_open_tag('associatedParty');
          views_bonus_eml_print_person('data_manager',  
                                       $dataset_node[dataset_datamanagers]);
        views_bonus_eml_print_close_tag('associatedParty');
      }
      views_bonus_eml_print_person('field_crew', $dataset_node[dataset_fieldcrew]);
      views_bonus_eml_print_person('labcrew', $dataset_node[dataset_labcrew]);
      views_bonus_eml_print_person('ext_assoc', $dataset_node[dataset_ext_assoc]);

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
      $dataset_datafile_path = $dataset_node[dataset_datafiles][0][datafile]->field_data_file[0]['filepath'];
      if ($dataset_datafile_path && !$dataset_node[dataset_datafiles][1]) {
        views_bonus_eml_print_open_tag('distribution');
          views_bonus_eml_print_tag_line('url', $urlBase . dirname($dataset_datafile_path));
        views_bonus_eml_print_close_tag('distribution');
      }

//      dpr($dataset_node[dataset_site]);
      if ($dataset_node[dataset_site][0]->nid || $dataset_beg_end_date[0]['value']) {
        views_bonus_eml_print_open_tag('coverage');
          views_bonus_eml_print_geographic_coverage($dataset_node[dataset_site]);
          views_bonus_eml_print_temporal_coverage($dataset_beg_end_date);
//          // taxonomicCoverage here
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

      views_bonus_eml_print_person('contact', $dataset_node[dataset_contacts]);

      // TODO: hardcode the publisher, specific for every given site
      // put it into config file,
      // add a description, what should be changed
      views_bonus_eml_print_open_tag('publisher');
        views_bonus_eml_print_tag_line($publisher_givenName,             '');
        views_bonus_eml_print_tag_line($publisher_surname,               '');
        views_bonus_eml_print_tag_line($publisher_organization,          '');
        views_bonus_eml_print_tag_line($publisher_deliveryPoint,         '');
        views_bonus_eml_print_tag_line($publisher_city,                  '');
        views_bonus_eml_print_tag_line($publisher_administrativeArea,    '');
        views_bonus_eml_print_tag_line($publisher_postalCode,            '');
        views_bonus_eml_print_tag_line($publisher_country,               '');
        views_bonus_eml_print_tag_line($publisher_phone,                 '');
        views_bonus_eml_print_tag_line($publisher_fax,                   '');
        views_bonus_eml_print_tag_line($publisher_role,                  '');
        views_bonus_eml_print_tag_line($publisher_electronicMailAddress, '');
        views_bonus_eml_print_tag_line($publisher_personid,              '');
      views_bonus_eml_print_close_tag('publisher');

      // see config_eml.php
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
      if ($dataset_node[dataset_datafiles] && $dataset_node[dataset_datafiles][0][datafile]->nid) {
        foreach ($dataset_node[dataset_datafiles] as $file_var_array) {

          // Collect all data_file values here to use in a conditions
          $file_data_file         = $file_var_array[datafile]->field_data_file;
          $datafile_description   = $file_var_array[datafile]->field_datafile_description;
          $file_num_header_line   = $file_var_array[datafile]->field_num_header_line;
          $file_num_footer_lines  = $file_var_array[datafile]->field_num_footer_lines;
          $file_record_delimiter  = $file_var_array[datafile]->field_record_delimiter;
          $file_orientation       = $file_var_array[datafile]->field_orientation;
          $file_delimiter         = $file_var_array[datafile]->field_delimiter;
          $file_quote_character   = $file_var_array[datafile]->field_quote_character;
          $datafile_date          = $file_var_array[datafile]->field_beg_end_date;
          $file_instrumentation   = $file_var_array[datafile]->field_instrumentation;
          $file_methods           = $file_var_array[datafile]->field_methods;
          $file_quality           = $file_var_array[datafile]->field_quality;

          views_bonus_eml_print_open_tag('dataTable');
            foreach ($file_data_file as $file_data) {
              views_bonus_eml_print_tag_line('entityName', $file_data['filename']);
            }
            views_bonus_eml_print_value('entityDescription', $datafile_description);

            views_bonus_eml_print_open_tag('physical');
              foreach ($file_data_file as $file_data) {
//                ??? the same as for entityName?
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
             if ($file_data_file && $file_data_file[0]['filepath']) {
               foreach ($file_data_file as $file_data) {
                   views_bonus_eml_print_open_tag('distribution');
                     views_bonus_eml_print_tag_line('url', $urlBase . $file_data['filepath']);
                   views_bonus_eml_print_close_tag('distribution');
               }
             }
            views_bonus_eml_print_close_tag('physical');

            if ($file_var_array[datafile_sites][0]->nid || $datafile_date[0]['value']) {
               views_bonus_eml_print_open_tag('coverage');
                 views_bonus_eml_print_geographic_coverage($file_var_array[datafile_sites]);
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
          
          foreach ($file_var_array[variables] as $var_node) {
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

              views_bonus_eml_print_open_tag('attributeList');
                views_bonus_eml_print_open_tag('attribute');
                  views_bonus_eml_print_value('attributeLabel',      $attribute_label);
                  views_bonus_eml_print_tag_line('attributeName',    $var_title);
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
                  if ($code_definitions[0]['value']) {
                   views_bonus_eml_print_open_tag('nominal');
                     views_bonus_eml_print_open_tag('nonNumericDomain');
                       foreach ($code_definitions as $code_definition) {
                         views_bonus_eml_print_open_tag('enumeratedDomain');
                           if (preg_match("/(.+)=(.+)/", $code_definition[value], $matches)) {
                             views_bonus_eml_print_tag_line('code',       $matches[1]);
                             views_bonus_eml_print_tag_line('definition', $matches[2]);
                            }
                            else {
                              views_bonus_eml_print_value('codeDefinition', $code_definition[value]);
                            }
                         views_bonus_eml_print_close_tag('enumeratedDomain');
                       }
//                           views_bonus_eml_print_value('codeDefinition', $code_definition);
                           // get host name from URL
//                            preg_match('@^(?:http://)?([^/]+)@i',
//                                "http://www.php.net/index.html", $matches);
//                           if (preg_match("/(.+)=(.+)/", $code_definition[0][value], $matches)) {
//                                echo "A match was found = ";
//                                print_r($matches);
//                                A match was found = Array
//                                  (
//                                      [0] => L=Larvae
//                                      [1] => L
//                                      [2] => Larvae
//                                  )
//
//                            } else {
//                                echo "A match was not found.";
//                            }
                     views_bonus_eml_print_close_tag('nonNumericDomain');
                   views_bonus_eml_print_close_tag('nominal');
                  }
                 views_bonus_eml_print_close_tag('measurementScale');
               } // endif; if ($attribute_formatstring ||
                 //            $attribute_maximum || $attribute_minimum ||
                 //            $attribute_precision || $attribute_unit)

               if ($var_missingvalues[0]['value']) {
                 views_bonus_eml_print_open_tag('missingValueCode');
                    if (preg_match("/(.+)=(.+)/", $var_missingvalues[0][value], $matches)) {
                      views_bonus_eml_print_tag_line('code',       $matches[1]);
                      views_bonus_eml_print_tag_line('definition', $matches[2]);
                    }

//                   views_bonus_eml_print_value('missingValues', $var_missingvalues);
                 views_bonus_eml_print_close_tag('missingValueCode');
               }
               views_bonus_eml_print_close_tag('attribute');
           views_bonus_eml_print_close_tag('attributeList');
            }
          }
          views_bonus_eml_print_close_tag('dataTable');
        }
      }
    views_bonus_eml_print_close_tag('eml:eml');
  views_bonus_eml_print_close_tag('dataset');
  }
?>
