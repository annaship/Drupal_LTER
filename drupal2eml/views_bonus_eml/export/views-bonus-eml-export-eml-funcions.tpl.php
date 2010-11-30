<?php
// $Id: views-bonus-eml-export-eml-funcions.tpl.php, v 1.0 2010-11-29 ashipunova Exp $
// TODO add @file etc

/*
 * public functions and variables
 */

function prepare_settings() {     
  unset($last_settings);

  $default_setting = '';
  $last_settings   = array (
    'last_acronym'               => variable_get('eml_settings_acronym',                $default_setting),
    'last_language'              => variable_get('eml_settings_language',               $default_setting),
    'last_intellectual_rights'   => variable_get('eml_settings_intellectual_rights',    $default_setting),
    'last_data_policies'         => variable_get('eml_settings_data_policies',          $default_setting),
    'last_metadata_provider_ref' => variable_get('eml_settings_metadata_provider_ref',  $default_setting),
    'last_publisher_ref'         => variable_get('eml_settings_publisher_ref',          $default_setting),
  );

    return $last_settings;
}

// put allowed HTML tags here
function views_bonus_eml_my_strip_tags($content = '') {
  return strip_tags($content, '<p><h1><h2><h3><h4><h5><a><pre><para>');
}

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
//      print "\n\$content = ";
//      print_r($content);

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

      if (in_array($person_tag, $not_show_role)) {
        views_bonus_eml_print_open_tag($person_tag);
      } else {
        views_bonus_eml_print_open_tag('associatedParty');
      }
      if($person_last_name[0]['value']){
        views_bonus_eml_print_open_tag('individualName');
          views_bonus_eml_print_value('givenName',        $person_first_name);
          views_bonus_eml_print_value('surName',          $person_last_name);
        views_bonus_eml_print_close_tag('individualName');
      }
      if ($person_organization[0]['value']) {
        views_bonus_eml_print_value('organization',       $person_organization);
      }
      if ($person_address[0]['value'] ||
          $person_city[0]['value']    ||
          $person_country[0]['value']) {
        views_bonus_eml_print_open_tag('address');
          views_bonus_eml_print_value('deliveryPoint',      $person_address);
          views_bonus_eml_print_value('city',               $person_city);
          views_bonus_eml_print_value('administrativeArea', $person_state);
          views_bonus_eml_print_value('postalCode',         $person_zipcode);
          views_bonus_eml_print_value('country',            $person_country);
        views_bonus_eml_print_close_tag('address');
      }
      views_bonus_eml_print_attr_line('phone',
                      views_bonus_eml_get_uniq_value($person_phone),
                      'phonetype', 'voice');
      views_bonus_eml_print_attr_line('phone',
                      views_bonus_eml_get_uniq_value($person_fax),
                      'phonetype', 'fax');
      if ($person_email[0]['email']) {
        foreach($person_email as $email) {
          views_bonus_eml_print_tag_line('electronicMailAddress', $email['email']);
        }
      }

      views_bonus_eml_print_value('userId', $person_personid);
      if (in_array($person_tag, $not_show_role)) {
        views_bonus_eml_print_close_tag($person_tag);
      } else {
        views_bonus_eml_print_tag_line('role', $person_tag);
        views_bonus_eml_print_close_tag('associatedParty');
      }
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
function views_bonus_eml_collect_geographic_description($label, $content, $comma_flag = 1) {
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
} // end of function views_bonus_eml_collect_geographic_description

function views_bonus_eml_get_lon_geo_point($content) {
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
function views_bonus_eml_print_geographic_coverage($content) {
  if ($content[0]['site_node']->nid) {
    foreach ($content as $research_site_node) {
        $research_site_landform   = $research_site_node['site_node']->field_research_site_landform;
        $research_site_geology    = $research_site_node['site_node']->field_research_site_geology;
        $research_site_soils      = $research_site_node['site_node']->field_research_site_soils;
        $research_site_hydrology  = $research_site_node['site_node']->field_research_site_hydrology;
        $research_site_vegetation = $research_site_node['site_node']->field_research_site_vegetation;
        $research_site_climate    = $research_site_node['site_node']->field_research_site_climate;
        $research_site_history    = $research_site_node['site_node']->field_research_site_history;
        $research_site_siteid     = $research_site_node['site_node']->field_research_site_siteid;
        $research_site_elevation  = $research_site_node['site_node']->field_research_site_elevation;
        $research_site_longitude  = $research_site_node['longitude'];
        $research_site_latitude   = $research_site_node['latitude'];

//      not used for now:
//        $research_site_node['geo_point'] returns "POINT(55.71 19.31466668)"
//        if we'll need POINT go to views_bonus_eml_get_lon_geo_point and change it as needed,
//        then call:
//        views_bonus_eml_get_lon_geo_point($research_site_node['geo_point']);

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
          views_bonus_eml_print_open_tag('geographicCoverage');
            $geoDesc  = views_bonus_eml_collect_geographic_description('Landform',
                                                    $research_site_landform, 0);
            $geoDesc .= views_bonus_eml_collect_geographic_description('Geology',
                                                    $research_site_geology);
            $geoDesc .= views_bonus_eml_collect_geographic_description('Soils',
                                                    $research_site_soils);
            $geoDesc .= views_bonus_eml_collect_geographic_description('Hydrology',
                                                    $research_site_hydrology);
            $geoDesc .= views_bonus_eml_collect_geographic_description('Vegetation',
                                                    $research_site_vegetation);
            $geoDesc .= views_bonus_eml_collect_geographic_description('Climate',
                                                    $research_site_climate);
            $geoDesc .= views_bonus_eml_collect_geographic_description('History',
                                                    $research_site_history);
            $geoDesc .= views_bonus_eml_collect_geographic_description('siteid',
                                                    $research_site_siteid);
            views_bonus_eml_print_tag_line('geographicDescription', $geoDesc);

            if ($research_site_longitude || $research_site_latitude) {
              views_bonus_eml_print_open_tag('boundingCoordinates');
                views_bonus_eml_print_tag_line('westBoundingCoordinate',  $research_site_longitude);
                views_bonus_eml_print_tag_line('eastBoundingCoordinate',  $research_site_longitude);
                views_bonus_eml_print_tag_line('northBoundingCoordinate', $research_site_latitude);
                views_bonus_eml_print_tag_line('southBoundingCoordinate', $research_site_latitude);
//[11/10/10 12:17:22 PM] inigo: <northboundingcoordinate>=$latitude; <southboundingCoordinate>=$latitude;
//[11/10/10 12:17:50 PM] inigo: <westBoundiungCoordinate>=$longitude; <eastboundingCoordinate>=$longitude;
              if ($research_site_elevation[0]['value']) {
                  views_bonus_eml_print_open_tag('boundingAltitudes');
                    views_bonus_eml_print_value('altitudeMinimum',  $research_site_elevation);
                    views_bonus_eml_print_value('altitudeMaximum',  $research_site_elevation);
                  views_bonus_eml_print_close_tag('boundingAltitudes');
              }
              views_bonus_eml_print_close_tag('boundingCoordinates');
            }
          views_bonus_eml_print_close_tag('geographicCoverage');
        } // endif; check if values exist
    } // endforeach; research_site_nid
  } // endif; $research_site_nid[0]['nid']
} // end of function views_bonus_eml_print_geographic_coverage

function views_bonus_eml_get_geo($site_nid) {
  unset($geo_lon_lat_point);    
  $db_url = parse_url($GLOBALS['db_url']);
  if (preg_match("/\/(.+)/", $db_url['path'], $matches)) {
    $db_name = $matches[1];
  }

  $server   = $db_url['host'];
  $username = $db_url['user'];
  $password = $db_url['pass'];
  $database = $db_name;

  $con = mysql_connect($server, $username, $password);

  if (!$con) {
    die($errDbConn . mysql_error() . " :: " . mysql_errno());
  }

  $db_selected = mysql_select_db($database, $con);

// TODO: refactoring, {}, %
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

  function views_bonus_eml_get_site_information($content) {
    unset($site_nodes);
    foreach ($content as $value) {
      foreach ($value as $site_nid) {
        $site_node = node_load($site_nid);
        $dataset_geo_lon_lat_point = views_bonus_eml_get_geo($site_nid);
        $site_nodes[] = array('site_node' => $site_node,
                              'longitude' => $dataset_geo_lon_lat_point['longitude'],
                              'latitude'  => $dataset_geo_lon_lat_point['latitude'],
                              'geo_point' => $dataset_geo_lon_lat_point['geo_point']);
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