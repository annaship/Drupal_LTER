<?php
// $Id: views-bonus-export-xml.tpl.php,v 1.2 2009/06/24 17:27:53 neclimdul Exp $
/**
 * @file views-view-table.tpl.php
 * Template to display a view as a table.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $rows: An array of row items. Each row is an array of content
 *   keyed by field ID.
 * - $header: an array of headers(labels) for fields.
 * - $themed_rows: a array of rows with themed fields.
 * @ingroup views_templates
 */

// Short tags act bad below in the html so we print it here.  

function print_tag_line($label, $content) {
    print '<'.$label.'>'.$content.'</'.$label.'>';
}
 
  

print '<?xml version="1.0" encoding="UTF-8" ?>';
?>

<eml:eml xmlns:eml="eml://ecoinformatics.org/eml-2.0.1" xmlns:stmml="http://www.xml-cml.org/schema/stmml" xmlns:sw="eml://ecoinformatics.org/software-2.0.1" xmlns:cit="eml://ecoinformatics.org/literature-2.0.1" xmlns:ds="eml://ecoinformatics.org/dataset-2.0.1" xmlns:prot="eml://ecoinformatics.org/protocol-2.0.1" xmlns:doc="eml://ecoinformatics.org/documentation-2.0.1" xmlns:res="eml://ecoinformatics.org/resource-2.0.1" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="eml://ecoinformatics.org/eml-2.0.1 eml.xsd" packageId="knb-lter-pie.3.6" system="knb">

<?php foreach ($themed_rows as $count => $row): ?>
  <Dataset>

<?php foreach ($row as $field => $content):
$label = $header[$field] ? $header[$field] : $field;      
$label = "DatasetNid";
?>
        
<?php print_tag_line($label, $content); ?>

<?php
// begin              
    $node = node_load($content);
    $type = $node->type;
    if($type == "data_set"):
      $datafiles = $node->field_dataset_datafile_ref;    
?>
<datafiles>
<?php     foreach ($datafiles as &$datafile):   

          // $tag = "datafile";
          // print '<'.$tag.'>';
?>
   <datafile>

<?php

        $datafile_nid = $datafile[nid];      
        $dd    = node_load($datafile_nid);
        $vars  = $dd->field_datafile_variable_ref;     
        $label = "DatafileNid";
?>                   

<?php print_tag_line($label, $dd->nid); ?>
    <variables>
<?php
        foreach ($vars as &$var):    
?>
   <my_name>

<?php
          unset($var_nid);
          $var_node = node_load($var[nid]);
          $var_nid  = $var[nid];
          $label   = "VarNid";
?>

<<?php print $label; ?>><?php print($var_nid); ?></<?php print $label; ?>>

<?php
          $maximum  = $var_node->field_attribute_maximum[0][value];   
          $label   = "maximum";
?>   

<<?php print $label; ?>><?php print($maximum); ?></<?php print $label; ?>>
</my_name>

<?php        endforeach;
        unset($dd);
?>


</variables>    
</datafile>
<?php //print '</'.$tag.'>'; ?>


<?php    endforeach; ?>
</datafiles>
<?php endif;
?>

<?php

 // end     

?>

<?php endforeach; ?>
  </Dataset>
<?php endforeach; ?>
</eml:eml>
