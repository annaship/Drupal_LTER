<?php
// $Id: views-bonus-eml-export-eml.tpl.php, v 1.0 9/23/10 11:29 AM ashipunova Exp $
/*
 * Template to display a view as an eml.
 */

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
  $datafile_nodes     = Array();


//   * 1) take all from db as an Obect?/Array?
foreach ($row as $row_nid) {
    $node = node_load($row_nid);
    $dataset_node[] = $node;

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
     $dataset_node[dataset_owner] = $owner_nodes;

    $field_dataset_contact_ref_nid = $node->field_dataset_contact_ref;
    foreach ($field_dataset_contact_ref_nid as $v) {
      foreach ($v as $contact_nid) {
        $contact_nodes[] = node_load($contact_nid);
        }
     }

     $dataset_node[dataset_contact] = $contact_nodes;

    $field_dataset_datamanager_ref_nid = $node->field_dataset_datamanager_ref;
    foreach ($field_dataset_datamanager_ref_nid as $v) {
      foreach ($v as $datamanager_nid) {
        $datamanager_nodes[] = node_load($datamanager_nid);
        }
     }
     $dataset_node[dataset_datamanager] = $datamanager_nodes;


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
    $dataset_node[dataset_datafile] = $datafile_nodes;
  }

  dpr($dataset_node);

  /*
   * HOWTO? flatten multidemensional array with repeted keys?
   * function flatten_array($array, $preserve_keys = 0, &$out = array()) {
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

   */

  /* -----------------
   * 2) calculate vid version
   * ---------------------
   */

  foreach ($dataset_node as $dataset) {
//  print "\$n->nid = ".$dataset->nid."\n";
//  print "\$n->vid = ".$dataset->vid."\n";
//  dpr($dataset);
    if (is_array($dataset) && ($dataset[0]->type == 'person')) {
      print "ARRAY\n";
//      dpr($dataset[0]->type);
    }
    else {
//      dpr($dataset);
    }
  }
//  $ver_vid += $n->vid;
//  print "\$n->vid = ".$ver_vid."\n";
//
//  $dataset_ref = array(
//  'field_dataset_datafile_ref',
//  'field_dataset_owner_ref',
//  'field_dataset_contact_ref',
//  'field_dataset_datamanager_ref',
//  'field_dataset_fieldcrew_ref',
//  'field_dataset_labcrew_ref',
//  );
//  foreach ($dataset_ref as $ref) {
//    $f_n = $n->$ref;
//    print "\$ref = ".$ref."\n";
//  //  dpr($f_n);
//    if ($f_n) {
//      foreach ($f_n as $f_n_a) {
//        foreach ($f_n_a as $f_nid) {
//          $f = node_load($f_nid);
//          print "\$f->type = ".$f->type."\n";
//          $ver_vid += $f->vid;
//          print "ref->vid = ".$f->vid."\n";
//          if ($ref == 'field_dataset_datafile_ref') {
//            $ref_var_n = $f->field_datafile_variable_ref;
//            if ($ref_var_n) {
//              print "HERE\n";
//              foreach ($ref_var_n as $var_n) {
//                $ref_var = node_load($var_n[nid]);
//                $ver_vid += $ref_var->vid;
//                print "\$ref_var->vid = ".$ref_var->vid."\n";
//              }
//            }
//          }
//        }
//      }
//    }
//    print "\$ver_vid = ".$ver_vid."\n";
//  }
}
?>