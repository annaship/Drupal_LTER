<?php
// $Id: views-bonus-eml-export-eml.tpl.php, v 1.0 9/23/10 11:29 AM ashipunova Exp $
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
}
//http://stackoverflow.com/questions/526556/how-to-flatten-a-multi-dimensional-array-to-simple-one-in-php

function flatten_array($array, $preserve_keys = 0, &$out = array()) {
    # Flatten a multidimensional array to one dimension, optionally preserving keys.
    #
    # $array - the array to flatten
    # $preserve_keys - 0 (default) to not preserve keys, 1 to preserve string keys only, 2 to preserve all keys
    # $out - internal use argument for recursion
    foreach($array as $key => $child)
        if(is_array($child))
            $out = flatten_array($child, $preserve_keys, $out);
        elseif($preserve_keys + is_string($key) > 1)
            $out[$key] = $child;
        else
            $out[] = $child;
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

//    owner
//    TODO repeat the same for all ref
    /*
     *   'field_dataset_datafile_ref',
  'field_dataset_owner_ref',
  'field_dataset_contact_ref',
  'field_dataset_datamanager_ref',
  'field_dataset_fieldcrew_ref',
  'field_dataset_labcrew_ref',
     */
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
    foreach ($field_dataset_ext_assoc_ref_nid as $v) {
      foreach ($v as $ext_assoc_nid) {
        $ext_assoc_nodes[] = node_load($ext_assoc_nid);
        }
     }
     $dataset_node[dataset_ext_assoc] = $ext_assoc_nodes;

    $field_dataset_site_ref_nid = $node->field_dataset_site_ref;
    foreach ($field_dataset_site_ref_nid as $v) {
      foreach ($v as $site_nid) {
        $site_nodes[] = node_load($site_nid);
        }
     }
     $dataset_node[dataset_site] = $site_nodes;

//  datafile
    $field_dataset_datafile_ref_nid = $node->field_dataset_datafile_ref;
    foreach ($field_dataset_datafile_ref_nid as $v) {
      foreach ($v as $datafile_nid) {
        $variable_nodes = array();
        $datafile_node  = node_load($datafile_nid);
        $field_datafile_variable_ref_nids = $datafile_node->field_datafile_variable_ref;
        foreach ($field_datafile_variable_ref_nids as $value) {
          foreach ($value as $var_nid) {
            $variable_nodes[] = node_load($var_nid);
          }
        }
        $datafile_nodes[] = array ($datafile_node, $variable_nodes);
//        see file-var_str.txt
     }
    }
    $dataset_node[dataset_datafiles] = $datafile_nodes;
  }
}

/*
 * 1a) create variables here. In case field names will changes,
 * that would be easier to change them in fewer place
 */

$dataset_short_name       = $dataset_node[dataset]->field_dataset_short_name;
$dataset_title            = $dataset_node[dataset]->title;
// $dataset_owner_ref        = $dataset_node[dataset]->field_dataset_owner_ref;
// $dataset_datamanager_ref  = $dataset_node[dataset]->field_dataset_datamanager_ref;
// $dataset_fieldcrew_ref    = $dataset_node[dataset]->field_dataset_fieldcrew_ref;
// $dataset_labcrew_ref      = $dataset_node[dataset]->field_dataset_labcrew_ref;
// $dataset_ext_assoc_ref    = $dataset_node[dataset]->field_dataset_ext_assoc_ref;
$dataset_publication_date = $dataset_node[dataset]->field_dataset_publication_date;
$dataset_abstract         = $dataset_node[dataset]->field_dataset_abstract;
$dataset_add_info         = $dataset_node[dataset]->field_dataset_add_info;
//$dataset_site_ref         = $dataset_node[dataset]->field_dataset_site_ref;
$dataset_beg_end_date     = $dataset_node[dataset]->field_beg_end_date;
$dataset_purpose          = $dataset_node[dataset]->field_dataset_purpose;
$dataset_maintenance      = $dataset_node[dataset]->field_dataset_maintenance;
//$dataset_contact_ref      = $dataset_node[dataset]->field_dataset_contact_ref;
$dataset_instrumentation  = $dataset_node[dataset]->field_instrumentation;
$dataset_methods          = $dataset_node[dataset]->field_methods;
$dataset_quality          = $dataset_node[dataset]->field_quality;
$dataset_id               = $dataset_node[dataset]->field_dataset_id;
$dataset_related_links    = $dataset_node[dataset]->field_dataset_related_links;

  /* -----------------
   * 2) calculate vid version
   * ---------------------
   */

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
//    dpr($dataset_node[$ref][0]);
    if ($dataset_node[$ref][0]) {
      foreach ($dataset_node[$ref] as $person) {
        $ver_vid += $person->vid;
      }
    }
  }

// vid of datafiles + variables
 $flatten_files = flatten_array($dataset_node[dataset_datafiles]);
 foreach ($flatten_files as $object_value) {
   $ver_vid += $object_value->vid;
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
      
      
    views_bonus_eml_print_close_tag('eml:eml');
  views_bonus_eml_print_close_tag('dataset');


?>