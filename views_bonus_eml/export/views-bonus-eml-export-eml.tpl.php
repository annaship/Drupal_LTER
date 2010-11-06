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

  $node = Array();
  $ver_vid = 0;
  $owner_nids = Array();
  $datafile_nids = Array();


//   * 1) take all from db as an Obect?/Array?
foreach ($row as $row_nid) {
    $node = node_load($row_nid);

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
        $owner_nids[] = $owner_nid;
        }
     }

//  datafile
    $field_dataset_datafile_ref_nid = $node->field_dataset_datafile_ref;
    foreach ($field_dataset_datafile_ref_nid as $v) {
      foreach ($v as $datafile_nid) {
        $datafile_nids[] = $datafile_nid;
        }
     }

//  sub: variables

    foreach ($datafile_nids as $datafile_nid) {
      $file_node = node_load($datafile_nid);
      $field_datafile_variable_ref_nids = $file_node->field_datafile_variable_ref;
      foreach ($field_datafile_variable_ref_nids as $value) {
        foreach ($value as $var_nid) {
          $variable_nids[] = $var_nid;
        }

      }
      dpr($variable_nids);
//      foreach ($field_dataset_owner_ref_nid as $v) {
//        foreach ($v as $owner_nid) {
//          $owner_nids[] = $owner_nid;
//          }
//       }
    }



  }


              $ref_var_n = $f->field_datafile_variable_ref;

//        dpr($datafile_nids);

// * 2) calculate vid version

  $ver_vid += $n->vid;
  print "\$n->vid = ".$ver_vid."\n";

  $dataset_ref = array(
  'field_dataset_datafile_ref',
  'field_dataset_owner_ref',
  'field_dataset_contact_ref',
  'field_dataset_datamanager_ref',
  'field_dataset_fieldcrew_ref',
  'field_dataset_labcrew_ref',
  );
  foreach ($dataset_ref as $ref) {
    $f_n = $n->$ref;
    print "\$ref = ".$ref."\n";
  //  dpr($f_n);
    if ($f_n) {
      foreach ($f_n as $f_n_a) {
        foreach ($f_n_a as $f_nid) {
          $f = node_load($f_nid);
          print "\$f->type = ".$f->type."\n";
          $ver_vid += $f->vid;
          print "ref->vid = ".$f->vid."\n";
          if ($ref == 'field_dataset_datafile_ref') {
            $ref_var_n = $f->field_datafile_variable_ref;
            if ($ref_var_n) {
              print "HERE\n";
              foreach ($ref_var_n as $var_n) {
                $ref_var = node_load($var_n[nid]);
                $ver_vid += $ref_var->vid;
                print "\$ref_var->vid = ".$ref_var->vid."\n";
              }
            }
          }
        }
      }
    }
    print "\$ver_vid = ".$ver_vid."\n";
}
  }
?>