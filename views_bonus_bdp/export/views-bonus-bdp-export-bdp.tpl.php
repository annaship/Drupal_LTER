<?php
// $Id: views-bonus-bdp-export-bdp.tpl.php, v 2.0 11/09/10 ashipunova Exp $
/*
 * Template to display a view as an bdp.
 */

include_once 'config_bdp.php';
/*
 * public functions and variables
 */

function views_bonus_bdp_print_open_tag($tag) {
  print '<' . $tag . '>';
}

function views_bonus_bdp_print_close_tag($tag) {
  print '</' . $tag . '>';
}

function views_bonus_bdp_print_tag_line($label, $content) {
  if ($content) {
    print '<' . $label . '>' . views_bonus_bdp_my_strip_tags($content) . '</' . $label . '>';
  }
}

function views_bonus_bdp_print_value($tag, $content) {
  if ($content[0]['value']) {
    foreach ($content as $in_arr) {
        views_bonus_bdp_print_tag_line($tag, views_bonus_bdp_my_strip_tags($in_arr['value']));
    }
  }
}

function views_bonus_bdp_print_attr_line($label, $content, $attribute_name, $attribute_value) {
  if ($content && $attribute_value) {
    print '<' . $label . ' ' . $attribute_name . '="' . $attribute_value . '">'
      . views_bonus_bdp_my_strip_tags($content) . '</' . $label . '>';

  }
}

// printing without foreach
function views_bonus_bdp_get_uniq_value($content) {
  if ($content[0]['value']) {
    return views_bonus_bdp_my_strip_tags($content[0]['value']);
  }
}

function views_bonus_bdp_print_person($person_tag, $content) {

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
      $person_personid      = $person_node->field_person_personid;
      $person_role_arr      = $person_node->field_person_role;
      $person_role          = $person_role_arr[0]['value'];
      $not_show_role        = array ('metadataProvider', 'creator', 'contact', 'publisher');

//      print "\n\$person_role = ";
//      print_r($person_role);
//      print "<br/>\n\$person_tag = ";
//      print_r($person_tag);
      if (in_array($person_tag, $not_show_role)) {
        views_bonus_bdp_print_open_tag($person_tag);
      } else {
        views_bonus_bdp_print_open_tag('associatedParty');
      }
      if($person_last_name[0][value]){
        views_bonus_bdp_print_open_tag('individualName');
          views_bonus_bdp_print_value('givenName',        $person_first_name);
          views_bonus_bdp_print_value('surName',          $person_last_name);
        views_bonus_bdp_print_close_tag('individualName');
      }
      if ($person_organization[0][value]) {
        views_bonus_bdp_print_value('organization',       $person_organization);
      }
      if ($person_address[0][value] ||
          $person_city[0][value]    ||
          $person_country[0][value]) {
        views_bonus_bdp_print_open_tag('address');
          views_bonus_bdp_print_value('deliveryPoint',      $person_address);
          views_bonus_bdp_print_value('city',               $person_city);
          views_bonus_bdp_print_value('administrativeArea', $person_state);
          views_bonus_bdp_print_value('postalCode',         $person_zipcode);
          views_bonus_bdp_print_value('country',            $person_country);
        views_bonus_bdp_print_close_tag('address');
      }
      views_bonus_bdp_print_attr_line('phone',
                      views_bonus_bdp_get_uniq_value($person_phone),
                      'phonetype', 'voice');
      views_bonus_bdp_print_attr_line('phone',
                      views_bonus_bdp_get_uniq_value($person_fax),
                      'phonetype', 'fax');
      if ($person_email[0]['email']) {
        foreach($person_email as $email) {
          views_bonus_bdp_print_tag_line('electronicMailAddress', $email['email']);
        }
      }

      views_bonus_bdp_print_value('userId', $person_personid);
      if (in_array($person_tag, $not_show_role)) {
        views_bonus_bdp_print_close_tag($person_tag);
      } else {
        views_bonus_bdp_print_tag_line('role', $person_tag);
        views_bonus_bdp_print_close_tag('associatedParty');
      }
    }
  }
} // end of function "views_bonus_bdp_print_person"


function views_bonus_bdp_print_temporal_coverage($beg_end_date) {
  if ($beg_end_date[0]['value']) {
    views_bonus_bdp_print_open_tag('temporalCoverage');
    foreach($beg_end_date as $dataset_date) {
      $first_date  = $dataset_date['value'];
      $second_date = $dataset_date['value2'];
      if ($first_date == $second_date) {
         views_bonus_bdp_print_open_tag('singleDateTime');
           views_bonus_bdp_print_tag_line('calendarDate', $first_date);
         views_bonus_bdp_print_close_tag('singleDateTime');
      }
      else {
        views_bonus_bdp_print_open_tag('rangeOfDates');
          views_bonus_bdp_print_open_tag('beginDate');
            views_bonus_bdp_print_tag_line('calendarDate', $first_date);
          views_bonus_bdp_print_close_tag('beginDate');
          views_bonus_bdp_print_open_tag('endDate');
            views_bonus_bdp_print_tag_line('calendarDate', $second_date);
          views_bonus_bdp_print_close_tag('endDate');
        views_bonus_bdp_print_close_tag('rangeOfDates');
      }
    }
    views_bonus_bdp_print_close_tag('temporalCoverage');
  }
} // end of function "views_bonus_bdp_print_temporal_coverage"


// Collect geo info into one string,
// only for the first time make $comma_flag = 0, to skip comma
function views_bonus_bdp_collect_geographic_description($label, $content, $comma_flag = 1) {
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
} // end of function views_bonus_bdp_collect_geographic_description

function views_bonus_bdp_get_lon_geo_point($content) {
  $matches = Array();
  if (preg_match("/\((\S+)\s(\S+)\)/", $content, $matches)) {
    $dataset_site_lon = $matches[1];
    $dataset_site_lat = $matches[2];
//     matches = Array
//(
//    [0] => (65.75 18.31466667)
//    [1] => 65.75
//    [2] => 18.31466667
//)
  }

//  return $dataset_site_lon;
}

// take research_site as geographicCoverage
function views_bonus_bdp_print_geographic_coverage($content) {
  if ($content[0][site_node]->nid) {
    foreach ($content as $research_site_node) {
        $research_site_landform   = $research_site_node[site_node]->field_research_site_landform;
        $research_site_geology    = $research_site_node[site_node]->field_research_site_geology;
        $research_site_soils      = $research_site_node[site_node]->field_research_site_soils;
        $research_site_hydrology  = $research_site_node[site_node]->field_research_site_hydrology;
        $research_site_vegetation = $research_site_node[site_node]->field_research_site_vegetation;
        $research_site_climate    = $research_site_node[site_node]->field_research_site_climate;
        $research_site_history    = $research_site_node[site_node]->field_research_site_history;
        $research_site_siteid     = $research_site_node[site_node]->field_research_site_siteid;
        $research_site_elevation  = $research_site_node[site_node]->field_research_site_elevation;
        $research_site_longitude  = $research_site_node[longitude];
        $research_site_latitude   = $research_site_node[latitude];

//      not used for now:
//        $research_site_node[geo_point] returns "POINT(55.71 19.31466668)"
//        if we'll need POINT go to views_bonus_bdp_get_lon_geo_point and change it as needed,
//        then call:
//        views_bonus_bdp_get_lon_geo_point($research_site_node[geo_point]);

        if ($research_site_landform[0]['value']   ||
            $research_site_geology[0]['value']    ||
            $research_site_soils[0]['value']      ||
            $research_site_hydrology[0]['value']  ||
            $research_site_vegetation[0]['value'] ||
            $research_site_climate[0]['value']    ||
            $research_site_history[0]['value']    ||
            $research_site_siteid[0]['value']     ||
            $research_site_longitude              ||
            $research_site_latitude               ||
            $research_site_elevation[0]['value']) {
          views_bonus_bdp_print_open_tag('geographicCoverage');
            $geoDesc  = views_bonus_bdp_collect_geographic_description('Landform',
                                                    $research_site_landform, 0);
            $geoDesc .= views_bonus_bdp_collect_geographic_description('Geology',
                                                    $research_site_geology);
            $geoDesc .= views_bonus_bdp_collect_geographic_description('Soils',
                                                    $research_site_soils);
            $geoDesc .= views_bonus_bdp_collect_geographic_description('Hydrology',
                                                    $research_site_hydrology);
            $geoDesc .= views_bonus_bdp_collect_geographic_description('Vegetation',
                                                    $research_site_vegetation);
            $geoDesc .= views_bonus_bdp_collect_geographic_description('Climate',
                                                    $research_site_climate);
            $geoDesc .= views_bonus_bdp_collect_geographic_description('History',
                                                    $research_site_history);
            $geoDesc .= views_bonus_bdp_collect_geographic_description('siteid',
                                                    $research_site_siteid);
            views_bonus_bdp_print_tag_line('geographicDescription', $geoDesc);

            if ($research_site_longitude || $research_site_latitude) {
              views_bonus_bdp_print_open_tag('boundingCoordinates');
                views_bonus_bdp_print_tag_line('westBoundingCoordinate',  $research_site_longitude);
                views_bonus_bdp_print_tag_line('eastBoundingCoordinate',  $research_site_longitude);
                views_bonus_bdp_print_tag_line('northBoundingCoordinate', $research_site_latitude);
                views_bonus_bdp_print_tag_line('southBoundingCoordinate', $research_site_latitude);
//[11/10/10 12:17:22 PM] inigo: <northboundingcoordinate>=$latitude; <southboundingCoordinate>=$latitude;
//[11/10/10 12:17:50 PM] inigo: <westBoundiungCoordinate>=$longitude; <eastboundingCoordinate>=$longitude;
              if ($research_site_elevation[0]['value']) {
                  views_bonus_bdp_print_open_tag('boundingAltitudes');
                    views_bonus_bdp_print_value('altitudeMinimum',  $research_site_elevation);
                    views_bonus_bdp_print_value('altitudeMaximum',  $research_site_elevation);
                  views_bonus_bdp_print_close_tag('boundingAltitudes');
              }
              views_bonus_bdp_print_close_tag('boundingCoordinates');
            }
          views_bonus_bdp_print_close_tag('geographicCoverage');
        } // endif; check if values exist
    } // endforeach; research_site_nid
  } // endif; $research_site_nid[0]['nid']
} // end of function views_bonus_bdp_print_geographic_coverage

function views_bonus_bdp_get_geo($site_nid) {
  unset($geo_lon_lat_point);
  $db_url = parse_url($GLOBALS[db_url]);
  if (preg_match("/\/(.+)/", $db_url[path], $matches)) {
    $db_name = $matches[1];
  }

  $server   = $db_url[host];
  $username = $db_url[user];
  $password = $db_url[pass];
  $database = $db_name;

  $con = mysql_connect($server, $username, $password);

  if (!$con) {
    die($errDbConn . mysql_error() . " :: " . mysql_errno());
  }

  $db_selected = mysql_select_db($database, $con);

  $db_query = ("SELECT X(field_research_site_pt_coords_geo) as longitude,
              Y(field_research_site_pt_coords_geo) as latitude,
              AsText(field_research_site_pt_coords_geo) as geo_point
              FROM $db_name.content_type_research_site
              WHERE vid=(SELECT max(vid)
                         FROM $db_name.content_type_research_site
                         WHERE nid = '$site_nid')");

  $result = mysql_query($db_query) or die(mysql_error());

  $geo_lon_lat_point = mysql_fetch_array($result);
  return $geo_lon_lat_point;
}

  function views_bonus_bdp_get_site_information($content) {
    unset($site_nodes);
    foreach ($content as $value) {
      foreach ($value as $site_nid) {
        $site_node = node_load($site_nid);
        $dataset_geo_lon_lat_point = views_bonus_bdp_get_geo($site_nid);
        $site_nodes[] = array('site_node' => $site_node,
                              'longitude' => $dataset_geo_lon_lat_point[longitude],
                              'latitude'  => $dataset_geo_lon_lat_point[latitude],
                              'geo_point' => $dataset_geo_lon_lat_point[geo_point]);
      }
    }
    return $site_nodes;
  }

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
//      return $out;
    }
  return $out;
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

  foreach ($themed_rows as $row) {

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

//   1) take all from db as an Array
foreach ($row as $row_nid) {
    $node = node_load($row_nid);
    $dataset_node[dataset] = $node;

//  refs
    $field_dataset_owner_ref_nid = $node->field_dataset_owner_ref;
    if ($field_dataset_owner_ref_nid) {
      foreach ($field_dataset_owner_ref_nid as $v) {
        foreach ($v as $owner_nid) {
          $owner_nodes[] = node_load($owner_nid);
        }
      }
    }
    $dataset_node[dataset_owners] = $owner_nodes;

    $field_dataset_contact_ref_nid = $node->field_dataset_contact_ref;
    if ($field_dataset_contact_ref_nid) {
      foreach ($field_dataset_contact_ref_nid as $v) {
        foreach ($v as $contact_nid) {
          $contact_nodes[] = node_load($contact_nid);
        }
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
    if ($field_dataset_fieldcrew_ref_nid) {
      foreach ($field_dataset_fieldcrew_ref_nid as $v) {
        foreach ($v as $fieldcrew_nid) {
          $fieldcrew_nodes[] = node_load($fieldcrew_nid);
        }
      }
    }
    $dataset_node[dataset_fieldcrew] = $fieldcrew_nodes;

    $field_dataset_labcrew_ref_nid = $node->field_dataset_labcrew_ref;
    if ($field_dataset_labcrew_ref_nid) {
      foreach ($field_dataset_labcrew_ref_nid as $v) {
        foreach ($v as $labcrew_nid) {
          $labcrew_nodes[] = node_load($labcrew_nid);
          }
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

    if ($node->field_dataset_site_ref[0][nid]) {
      $site_nodes = views_bonus_bdp_get_site_information($node->field_dataset_site_ref);
      $dataset_node[dataset_site] = $site_nodes;
    }

    $datafile_node  = Array();

//  datafile
    $field_dataset_datafile_ref_nid = $node->field_dataset_datafile_ref;
    if ($field_dataset_datafile_ref_nid) {
      foreach ($field_dataset_datafile_ref_nid as $v) {
        foreach ($v as $datafile_nid) {
          $variable_nodes       = Array();
          $datafile_site_nodes  = Array();
          $datafile_node        = node_load($datafile_nid);
  //      variables
          $field_datafile_variable_ref_nids = $datafile_node->field_datafile_variable_ref;
          if ($field_datafile_variable_ref_nids) {
            foreach ($field_datafile_variable_ref_nids as $value) {
              foreach ($value as $var_nid) {
                $variable_nodes[] = node_load($var_nid);
              }
            }
          }
  //      sites
          if ($datafile_node->field_datafile_site_ref[0][nid]) {
            $datafile_site_nodes = views_bonus_bdp_get_site_information($datafile_node->field_datafile_site_ref);
          }
  //      all file related data
          $datafile_nodes[] = array ('datafile'       => $datafile_node,
                                     'variables'      => $variable_nodes,
                                     'datafile_sites' => $datafile_site_nodes);
        }
      }
    }
    $dataset_node[dataset_datafiles] = $datafile_nodes;
  }

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

$views_bonus_bdp_site_name = variable_get('site_name', NULL);

  /* -----------------
   * 2) calculate vid version
   * ---------------------
   */
  $ver_vid = $dataset_node[dataset]->vid;

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
      foreach ($dataset_node[$ref] as $person_site) {
        $ver_vid += $person_site->vid;
      }
    }
  }

// vid of datafiles + variables + datafile_sites
 $flatten_files = flatten_array($dataset_node[dataset_datafiles]);
 if ($flatten_files) {
   foreach ($flatten_files as $object_value) {
     $ver_vid += $object_value->vid;
   }
 }

  /*
   * 3) create and populate a template
   */

  // $acr from config
  $package_id = 'knb-lter-' . $acr . '.' . $dataset_id[0][value]  . '.' . $ver_vid;

  print '<?xml version="1.0" encoding="UTF-8" ?>';

?>

  <bdp:bdp xmlns:bdp='bdp://ecoinformatics.org/bdp-2.0.1'
           xmlns:stmml='http://www.xml-cml.org/schema/stmml'
           xmlns:sw='bdp://ecoinformatics.org/software-2.0.1'
           xmlns:cit='bdp://ecoinformatics.org/literature-2.0.1'
           xmlns:ds='bdp://ecoinformatics.org/dataset-2.0.1'
           xmlns:prot='bdp://ecoinformatics.org/protocol-2.0.1'
           xmlns:doc='bdp://ecoinformatics.org/documentation-2.0.1'
           xmlns:res='bdp://ecoinformatics.org/resource-2.0.1'
           xmlns:xs='http://www.w3.org/2001/XMLSchema'
           xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'
           xsi:schemaLocation='bdp://ecoinformatics.org/bdp-2.0.1 bdp.xsd'
           packageId='<?php print($package_id)?>'
           system='knb'>

<?php

  /*
   * dataset start
   */


    views_bonus_bdp_print_open_tag('dataset');
      views_bonus_bdp_print_value('shortName', $dataset_short_name);
      views_bonus_bdp_print_tag_line('title', $dataset_title);

      // Person refs start
      views_bonus_bdp_print_person('creator', $dataset_node[dataset_owners]);
      // metadataProvider from config_bdp.php
      views_bonus_bdp_print_person('metadataProvider', $metadata_provider_arr);

      $associated_party_arr = array (
        'data manager'         => 'dataset_datamanagers',
        'field crew'           => 'dataset_fieldcrew',
        'labcrew'              => 'dataset_labcrew',
        'associate researcher' => 'dataset_ext_assoc',
      );

      if ($associated_party_arr) {
        foreach ($associated_party_arr as $key => $value) {
          if ($dataset_node[$value][0]->nid) {
              views_bonus_bdp_print_person($key, $dataset_node[$value]);
          }
        }
      }
      //pubDate
      views_bonus_bdp_print_value('pubDate',  $dataset_publication_date);

      //language -- <language>english</language>
      views_bonus_bdp_print_tag_line('language', $language);

//        print "\nURRA\n";
//        print_r($dataset_abstract[0][value]);
//        print "\nSTOPPP\n";


      if ($dataset_abstract[0]['value']) {
        views_bonus_bdp_print_open_tag('abstract');
         views_bonus_bdp_print_open_tag('para');
          views_bonus_bdp_print_value('literalLayout', $dataset_abstract);
         views_bonus_bdp_print_close_tag('para');
        views_bonus_bdp_print_close_tag('abstract');
      }


//      views_bonus_bdp_print_value('abstract', $dataset_abstract);

      // TODO: add if, depend of structure
      views_bonus_bdp_print_open_tag('keywordSet');
        // dpr($node->taxonomy);
        // views_bonus_bdp_print_value('keyword', node->taxonomy->term);
        // views_bonus_bdp_print_value('keywordThesaurus', node->taxonomy->vocabularyName);
      views_bonus_bdp_print_close_tag('keywordSet');

      if ($dataset_add_info[0]['value']) {
        views_bonus_bdp_print_open_tag('additionalInfo');
          views_bonus_bdp_print_open_tag('para');
             views_bonus_bdp_print_value('literalLayout', $dataset_add_info);
             views_bonus_bdp_print_value('related_links', $dataset_related_links);
          views_bonus_bdp_print_close_tag('para');
        views_bonus_bdp_print_close_tag('additionalInfo');
      }

      // $intellectual_rights from config file
      views_bonus_bdp_print_open_tag('intellectualRights');
        views_bonus_bdp_print_open_tag('section');
        views_bonus_bdp_print_tag_line('title', 'Data Policies');
          views_bonus_bdp_print_open_tag('para');
            views_bonus_bdp_print_tag_line('literalLayout', $intellectual_rights);
          views_bonus_bdp_print_close_tag('para');
        views_bonus_bdp_print_close_tag('section');
      views_bonus_bdp_print_close_tag('intellectualRights');

      // if there is one and only one file take path from it
      $dataset_datafile_path = $dataset_node[dataset_datafiles][0][datafile]->field_data_file[0]['filepath'];
      if ($dataset_datafile_path && !$dataset_node[dataset_datafiles][1]) {
        views_bonus_bdp_print_open_tag('distribution');
          views_bonus_bdp_print_tag_line('url', $urlBase . dirname($dataset_datafile_path));
        views_bonus_bdp_print_close_tag('distribution');
      }

      if ($dataset_node[dataset_site][0][site_node]->nid || $dataset_beg_end_date[0]['value']) {
        views_bonus_bdp_print_open_tag('coverage');
          views_bonus_bdp_print_geographic_coverage($dataset_node[dataset_site]);
          views_bonus_bdp_print_temporal_coverage($dataset_beg_end_date);
          // taxonomicCoverage here
        views_bonus_bdp_print_close_tag('coverage');
      }

      if ($dataset_purpose[0]['value']) {
        views_bonus_bdp_print_open_tag('purpose');
           views_bonus_bdp_print_open_tag('para');
              views_bonus_bdp_print_value('literalLayout', $dataset_purpose);
           views_bonus_bdp_print_close_tag('para');
        views_bonus_bdp_print_close_tag('purpose');
      }

      // maintenance log
      if ($dataset_maintenance[0]['value']) {
        views_bonus_bdp_print_open_tag('maintenance');
          views_bonus_bdp_print_open_tag('description');
             views_bonus_bdp_print_open_tag('para');
                views_bonus_bdp_print_value('literalLayout', $dataset_maintenance);
             views_bonus_bdp_print_close_tag('para');
          views_bonus_bdp_print_close_tag('description');
        views_bonus_bdp_print_close_tag('maintenance');
      }

      views_bonus_bdp_print_person('contact', $dataset_node[dataset_contacts]);
      //publisher, specific for every given site from config file,
      views_bonus_bdp_print_person('publisher', $publisher_arr);
      views_bonus_bdp_print_tag_line('pubPlace', $views_bonus_bdp_site_name);

      // methods section  !!! ISG comment added  1st, methods can be opened if this is true $dataset_methods[0]['value']
      // if we have instruments, but not a description, we need to ignore it all together: changed conditional.
      if ($dataset_methods[0]['value']) {
        views_bonus_bdp_print_open_tag('methods');
          views_bonus_bdp_print_open_tag('methodStep');
            views_bonus_bdp_print_open_tag('description');  // !!! ISG added more tags to the description (section/para/literalLayout)
               views_bonus_bdp_print_open_tag('section');
                 views_bonus_bdp_print_open_tag('para');    // !!! ISG in the future, we may need to parse HTML (like h1,h2,h3, and translate it to BDP markup)
                                                            //!!! if we could detect paragraphs, and translate them into <para>s, better...
                    views_bonus_bdp_print_value('literalLayout', $dataset_methods);
                 views_bonus_bdp_print_close_tag('para');
               views_bonus_bdp_print_close_tag('section');
            views_bonus_bdp_print_close_tag('description');
            if ($dataset_instrumentation[0]['value']) {
              views_bonus_bdp_print_value('instrumentation', $dataset_instrumentation);
            }
          views_bonus_bdp_print_close_tag('methodStep');
          if ($dataset_quality[0]['value']) {
             views_bonus_bdp_print_open_tag('qualityControl');
                views_bonus_bdp_print_open_tag('description');
                   views_bonus_bdp_print_open_tag('para');  //!!!ISG added structure
                       views_bonus_bdp_print_value('literalLayout', $dataset_quality);
                   views_bonus_bdp_print_close_tag('para');
                views_bonus_bdp_print_close_tag('description');
             views_bonus_bdp_print_close_tag('qualityControl');
          }
        views_bonus_bdp_print_close_tag('methods');
      }

      // project (from CCT research_project). !!! ISG

// access tag group - from config file, or from site variable, or... here is my take !!!
      
?>
<access scope="document" order="allowFirst" authSystem="knb">
  <?php
   if ($acr) {
     views_bonus_bdp_print_open_tag('allow');
        $access_string = "uid=$acr, o=lter, dc=ecoinformatics, dc=org";
        views_bonus_bdp_print_tag_line('principal',  $access_string);
        $access_string = 'all';
        views_bonus_bdp_print_tag_line('permission', $access_string);
     views_bonus_bdp_print_close_tag('allow');
    }
  ?>
  <allow>
    <principal>public</principal>
    <permission>read</permission>
  </allow>
</access>
<?php
      // Data_file start
      $file_var_array = Array();
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

          views_bonus_bdp_print_open_tag('dataTable');

          if ($file_data_file) {
            foreach ($file_data_file as $file_data) {
              views_bonus_bdp_print_tag_line('entityName', $file_data['filename']);
            }
          } else {
//??? there's no $file_data_file and $file_data['filepath']
            //!!! ISG to rescue BDP validity -- IM not sure how.. we can always make the field mandatory.
            views_bonus_bdp_print_tag_line('entityName', $file_data['filepath']);
          }

          views_bonus_bdp_print_value('entityDescription', $datafile_description);

          views_bonus_bdp_print_open_tag('physical');
          if ($file_data_file) {
            foreach ($file_data_file as $file_data) {
              views_bonus_bdp_print_tag_line('objectName', $file_data['filename']);
           }
          } else {
//??? there's no $file_data_file and $file_data['filepath']
          //!!! ISG to rescue BDP validity -- IM not sure how.. we can always make the field mandatory.
            views_bonus_bdp_print_tag_line('entityName', $file_data['filepath']);
          }
          views_bonus_bdp_print_open_tag('dataFormat');
          // Here some tags are obligate: textFormat, attributeOrientation,
          // simpleDelimited, fieldDelimiter, complex
           views_bonus_bdp_print_open_tag('textFormat');
             views_bonus_bdp_print_value('numHeaderLines',       $file_num_header_line);
             views_bonus_bdp_print_value('numFooterLines',       $file_num_footer_lines);
             views_bonus_bdp_print_value('recordDelimiter',      $file_record_delimiter);
             views_bonus_bdp_print_value('attributeOrientation', $file_orientation);
             views_bonus_bdp_print_open_tag('simpleDelimited');
             if ($file_delimiter[0][value]) {
               views_bonus_bdp_print_value('fieldDelimiter',     $file_delimiter);
             }
             else {
               $file_delimiter = ',';
               views_bonus_bdp_print_tag_line('fieldDelimiter',  $file_delimiter);
             }
               views_bonus_bdp_print_value('quoteCharacter',     $file_quote_character);
             views_bonus_bdp_print_close_tag('simpleDelimited');
           views_bonus_bdp_print_close_tag('textFormat');
          views_bonus_bdp_print_close_tag('dataFormat');
          if ($file_data_file && $file_data_file[0]['filepath']) {
           foreach ($file_data_file as $file_data) {
               views_bonus_bdp_print_open_tag('distribution');
                 views_bonus_bdp_print_tag_line('url', $urlBase . $file_data['filepath']);
               views_bonus_bdp_print_close_tag('distribution');
           }
          }
          views_bonus_bdp_print_close_tag('physical');

          if ($file_var_array[datafile_sites][0][site_node]->nid || $datafile_date[0]['value']) {
             views_bonus_bdp_print_open_tag('coverage');
               views_bonus_bdp_print_geographic_coverage($file_var_array[datafile_sites]);
               views_bonus_bdp_print_temporal_coverage($datafile_date);
               // taxonomic coverage here
             views_bonus_bdp_print_close_tag('coverage');
          }

// ??? change as dataset methods ???
// methods section  !!! ISG comment added  1st, methods can be opened if this is true $dataset_methods[0]['value']
// if we have instruments, but not a description, we need to ignore it all together: changed conditional.
          if ($file_instrumentation[0]['value'] ||
             $file_methods[0]['value']         ||
             $quality[0]['value']) {
           views_bonus_bdp_print_open_tag('method');
           if ($file_instrumentation[0]['value'] ||
               $file_methods[0]['value']) {
             views_bonus_bdp_print_open_tag('methodStep');
               views_bonus_bdp_print_value('instrumentation',  $file_instrumentation);
               views_bonus_bdp_print_value('description',      $file_methods);
             views_bonus_bdp_print_close_tag('methodStep');
           }
           if ($file_quality[0]['value']) {
             views_bonus_bdp_print_open_tag('qualityControl');
               views_bonus_bdp_print_value('description',      $file_quality);
             views_bonus_bdp_print_close_tag('qualityControl');
           }
           views_bonus_bdp_print_close_tag('method');
          }

          // Variables start
          // Take variables here to use in conditions
          views_bonus_bdp_print_open_tag('attributeList');

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

                views_bonus_bdp_print_open_tag('attribute');
                  views_bonus_bdp_print_tag_line('attributeName',    $var_title);
                  views_bonus_bdp_print_value('attributeLabel',      $attribute_label);
                  views_bonus_bdp_print_value('attributeDefinition', $var_definition);
               if ($attribute_formatstring[0]['value'] ||
                   $attribute_maximum[0]['value'] ||
                   $attribute_minimum[0]['value'] ||
                   $attribute_precision[0]['value'] ||
                   $attribute_unit[0]['value']) {
                 views_bonus_bdp_print_open_tag('measurementScale');
                 if ($attribute_formatstring[0]['value']) {
                   views_bonus_bdp_print_open_tag('datatime');
                     views_bonus_bdp_print_value('formatstring',   $attribute_formatstring);
                   views_bonus_bdp_print_close_tag('datatime');
                 }
                 if ($attribute_maximum[0]['value'] ||
                     $attribute_minimum[0]['value'] ||
                     $attribute_precision[0]['value'] ||
                     $attribute_unit[0]['value']) {
                   views_bonus_bdp_print_open_tag('ratio');
                   if ($attribute_maximum[0]['value'] ||
                       $attribute_minimum[0]['value']) {
                     views_bonus_bdp_print_open_tag('numericDomain');
                       views_bonus_bdp_print_open_tag('bounds');
                         views_bonus_bdp_print_value('maximum',    $attribute_maximum);
                         views_bonus_bdp_print_value('minimum',    $attribute_minimum);
                       views_bonus_bdp_print_close_tag('bounds');
                     views_bonus_bdp_print_close_tag('numericDomain');
                   }
                   if ($attribute_precision[0]['value']) {
                     views_bonus_bdp_print_value('precision',      $attribute_precision);
                   }
                   if ($attribute_unit[0]['value']) {
                     views_bonus_bdp_print_open_tag('unit');
                       views_bonus_bdp_print_value('standardUnit', $attribute_unit);
                     views_bonus_bdp_print_close_tag('unit');
                   }
                   views_bonus_bdp_print_close_tag('ratio');
                  }
                  if ($code_definitions[0]['value']) {
                   views_bonus_bdp_print_open_tag('nominal');
                     views_bonus_bdp_print_open_tag('nonNumericDomain');
                       foreach ($code_definitions as $code_definition) {
                         views_bonus_bdp_print_open_tag('enumeratedDomain');
                           if (preg_match("/(.+)=(.+)/", $code_definition[value], $matches)) {
                             views_bonus_bdp_print_tag_line('code',       $matches[1]);
                             views_bonus_bdp_print_tag_line('definition', $matches[2]);
                            }
                            else {
                              views_bonus_bdp_print_value('codeDefinition', $code_definition[value]);
                            }
                         views_bonus_bdp_print_close_tag('enumeratedDomain');
                       }
                     views_bonus_bdp_print_close_tag('nonNumericDomain');
                   views_bonus_bdp_print_close_tag('nominal');
                  }
                 views_bonus_bdp_print_close_tag('measurementScale');
               } // endif; if ($attribute_formatstring ||
                 //            $attribute_maximum || $attribute_minimum ||
                 //            $attribute_precision || $attribute_unit)

               if ($var_missingvalues[0]['value']) {
                 views_bonus_bdp_print_open_tag('missingValueCode');
                 foreach ($var_missingvalues as $var_missingvalue) {
                    if (preg_match("/(.+)=(.+)/", $var_missingvalue[value], $matches)) {
                      views_bonus_bdp_print_tag_line('code',       $matches[1]);
                      views_bonus_bdp_print_tag_line('definition', $matches[2]);
                    }
                    else {
                      views_bonus_bdp_print_tag_line('missingValues', $var_missingvalue[value]);
                    }
                 }
                 views_bonus_bdp_print_close_tag('missingValueCode');
               }
               views_bonus_bdp_print_close_tag('attribute');
            }
          }
            views_bonus_bdp_print_close_tag('attributeList');
          views_bonus_bdp_print_close_tag('dataTable');
        }
      }
    views_bonus_bdp_print_close_tag('dataset');
  views_bonus_bdp_print_close_tag('bdp:bdp');
  }
?>
