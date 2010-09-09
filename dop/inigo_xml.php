<?php 
* as print '<'.$label.' '.$id_name.'="'.$id_value.'">'.$content.'';
* */

function print_tag_line($label, $content) {
	print '<'.$label.'>'.$content.'';

}

function print_open_tag($tag) {
	print '<'.$tag.'>';

}

function print_close_tag($tag) {
	print '';

}

function print_values($field_arr, $node, $drupal_node_attr, $drupal_node_flag = 0) {
	
// if $drupal_node_flag == 1 print out Drupal node attributes - nid, type... 
if ($drupal_node_flag == 1) {
	
  print_node_attr($node, $drupal_node_attr);
$drupal_node_flag = 0;

}

// for every field name print out a tagged value 
foreach ($field_arr as $field_name => $tag_name) {
	print_open_tag($tag_name);
$field_value = $node->$field_name;
through_array($field_value);
print_close_tag($tag_name);

}
}

function through_array($double_arr) {
	foreach ($double_arr as $key => $value){ 
// take group tag $tag = $key;

// check if we'll go recursively
 if (is_array($value)) {
	
// print group tag
 if ($tag) {
	print_open_tag($tag);
$flag = 1;

}
// if not end value, go through array again through_array($value);

}else {
	
// print out taged value $key == "value" ? print $value : print_tag_line($key, $value);

// if tag is needed, than change the line above with "print_tag_line($key, $value);" 
}if ($flag == 1) {
	print_close_tag($tag);
$flag = 0;

}
}
}

function print_flat_ref_value($field_name, $tag_name, $node, $field_arr, $drupal_node_attr) {
	print_open_tag($tag_name);
  $field_value = $node->$field_name;
  foreach ($field_value as $key1 => $value1){ 
    foreach ($value1 as $key2 => $value2){ 
      $ref_node = node_load($value2);
      print_values($field_arr, $ref_node, $drupal_node_attr);
    }
  }
  print_close_tag($tag_name);
}

function print_node_attr($node, $drupal_node_attr) {
	$label = "drupal_node_attr";
  print_open_tag($label);
  foreach ($drupal_node_attr as $field_name => $tag_name) {
	  print_tag_line($field_name, $node->$field_name);
  }
  print_close_tag($label);
}

function print_user($ref_node) {
	$user_id = $ref_node->field_person_user;
  $user_nid = $user_id[0][uid];
  $user_node = user_load($user_nid);
  print_open_tag("user");
  foreach ($user_node as $key1 => $value1){ 
    print_tag_line($key1, $value1);
  }
  print_close_tag("user");
}
/* To change tag label change value in right coulmn */
 
// do not print out value of those: 
/* ISG actually, in the new content types, we use a few node titles */
 $drupal_node_attr = array( 
   "body" => "body", 
  "changed" => "changed", 
  "comment" => "comment", 
  "comment_count"	 => "comment_count", 
  "created" => "created", 
  "data" => "data", 
  "format" => "format", 
  "language" => "language", 
  "last_comment_name"	 => "last_comment_name", 
  "last_comment_timestamp" => "last_comment_timestamp", 
  "log" => "log", 
  "moderate" => "moderate", 
  "name" => "name", 
  "nid" => "nid", 
  "picture" => "picture", 
  "promote" => "promote", 
  "revision_timestamp" => "revision_timestamp", 
  "revision_uid" => "revision_uid", 
  "status" => "status", 
  "sticky" => "sticky", 
  "taxonomy"	 => "taxonomy", 
  "teaser" => "teaser", 
  "themekey_ui_theme"	 => "themekey_ui_theme", 
    "title" => "title", 
  "tnid" => "tnid", 
  "translate" => "translate", 
  "type" => "type", 
  "uid" => "uid", 
  "vid" => "vid" );

/* "user" */
 
/* ISG We do not use the user, but OK */
$drupal_user = array( 
  // "uid" => "uid", 
  "name"	 => "name", 
  // "pass" => "pass", 
  "mail"	 => "mail", 
  "mode"	 => "mode", 
  "sort"	 => "sort", 
  "threshold" => "threshold", 
  "theme" => "theme", 
  "signature" => "signature", 
  "signature_format" => "signature_format", 
  "created"	 => "created", 
  "access"	 => "access", 
  "login"	 => "login", 
  "status"	 => "status", 
  "timezone"	 => "timezone", 
  "language"	 => "language", 
  "picture"	 => "picture", 
  "init"	 => "init", 
  // "data" => "data", 
  "timezone_name" => "timezone_name" 
);

/* "data_set" */
 $data_set_field_arr = array( 
   "field_abstract" => "abstract", 
//ISG a textType (PATH eml/dataset/abstract) 
  "field_beg_end_date" => "field_beg_end_date", 
// ISG it breaks down in beginDate/calendarDate and endDate/calendarDate 
// (PATH eml/dataset/coverage/temporalCoverage/rangeOfDates/beginDate/calendarDate)
	"field_dataset_add_info" => "additionalInfo", 
//(PATH eml/dataset/additionalInfo)
	"field_dataset_id" => "field_dataset_id", 
// ISG complex, is used in more than one EML placeholder...
	"field_dataset_instrument" => "instrumentation",
// ISG a textType (PATH eml/dataset/methods/methodStep/instrumentation)
	"field_dataset_maintenance" => "maintenance",
//ISG a textType (PATH eml/dataset/maintenance)
	"field_dataset_methods" => "methodStep", 
// ISG a textType (PATH eml/dataset/methods/methodStep/description)
	"field_dataset_purpose" => "purpose",
//ISG a textType
	"field_dataset_quality" => "qualityControl",
// ISG textType (PATH eml/dataset/methods/qualityControl/description)
	"field_publication_date" => "pubDate", 
//ISG (PATH eml/dataset/pubDate)
	"field_short_name" => "shortName", 
// ISG (PATH eml/dataset/shortName) 
// "field_title" => "field_title" (ISG this was removed, using node->title for title of dataset 
// "field_dataset_assct_biblio" => "field_dataset_assct_biblio", (ISG not used) 
// "field_dataset_sevid" => "field_dataset_sevid", (ISG changed at content type ...) 
// "field_dataset_datamanager_ref", 
// 	"field_dataset_fieldcrew_ref", 
// "field_dataset_labcrew_ref", 
);

$data_set_field_ref_arr = array(
	"field_dataset_contact" => "contact", 
// ISG .. i changed the content type label too (added "ref", etc)
	"field_dataset_datafile_ref" => "data_file",
	"field_dataset_ext_assoc" => "ext_assoc", 
// ISG .. i changed the content type label too (added "ref", etc)
	"field_dataset_owner" => "owner", 
// ISG .. i changed the content type label too (added "ref", etc)
	"field_dataset_site_ref" => "site" 
// ISG .. there are now field managers, data managers, etc. );

/* "data_file" */
 
// "field_dataset_datafile_ref", 
	$data_file_field_arr = array(
	"field_datafile_date" => "field_datafile_date", 
//ISG changed ckkField, reusing previous file(PATH eml/dataset/dataTable/coverage/temporalCoverage)
	"field_datafile_description" => "entityDescription",
//ISG (PATH eml/dataset/dataTable/entityDescription)
	"field_datafile_name" => "entityName",
//ISG (PATH eml/dataset/dataTable/entityName (also objectName...re-used)
	"field_data_file" => "field_data_file",
// ISG (PATH eml/dataset/dataTable/physical/distribution/url)
	"field_delimiter" => "fieldDelimiter",
//ISG (PATH eml/dataset/dataTable/physical/dataFormat/textFormat/simpleDelimited/fieldDelimiter
	"field_method_description" => "methodStep",
// ISG : is a textType, but field changed names in CCT1.0 (PATH eml/dataset/dataTable/method...
	"field_num_footer_lines" => "numFooteLines",
//ISG (PATH eml/dataset/dataTable/physical/dataFormat/textFormat/numFooterLines)
	"field_num_header_line" => "numHeaderLines",
//ISG (PATH eml/dataset/dataTable/physical/dataFormat/textFormat/numHeaderLines)
	"field_orientation" => "attributeOrientation",
//ISG (PATH eml/dataset/dataTable/physical/dataFormat/textFormat/attributeOrientation)
	"field_quality_control" => "qualityControl",
// ISG...mmm.. CCk field should be reused..
	"field_quote_character" => "field_quote_character", 
// ISG (PATH eml/dataset/dataTable/physical/dataFormat/textFormat/simpleDelimited/QuoteCharacter)
	"field_record_delimiter" => "field_record_delimiter", 
//ISG (PATH eml/dataset/dataTable/physical/dataFormat/textFormat/recordDelimiter)
	"field_sampling_description" => "field_sampling_description" 
//ISG i think i changed this in the new CCTss.. (PATH eml/dataset/dataTable/methods... );

$data_file_field_ref_arr = array(
	"field_datafile_site_ref" => "field_datafile_site_ref",
	"field_datafile_variable_ref" => "field_datafile_variable_ref" );

/* "variable" */
 
//
	"field_datafile_variable_ref" $var_field_arr = array(
	"field_var_name" => "attributeName", 
//ISG (PATH eml/dataset/dataTable/attributeList/attribute/attributeName) 
// "field_attribute_assoc_datafile" => "field_attribute_assoc_datafile", Referrers
	"field_attribute_formatstring" => "formatstring",
//ISG (PATH eml/dataset/dataTable/attributeList/attribute/measurementScale/datatime/formatString)
	"field_attribute_label" => "attributeLabel",
//ISG (PATH eml/dataset/dataTable/attributeList/attribute/attributeLabel
	"field_attribute_maximum" => "maximum", 
//ISG (PATH eml/dataset/dataTable/attributeList/attribute/measurementScale/ratio/numericDomain/bounds/maximum)
	"field_attribute_minimum" => "minimum",
//ISG (PATH eml/dataset/dataTable/attributeList/attribute/measurementScale/ratio/numericDomain/bounds/minimum)
	"field_attribute_precision" => "precision",
//ISG (PATH eml/dataset/dataTable/attributeList/attribute/measurementScale/ratio/precision)
	"field_attribute_unit" => "unit", 
// ISG this is more complex (PATH eml/dataset/dataTable/attributeList/attribute/measurementScale/ratio/unit/standardUnit)
	"field_code_definition" => "codeDefinition", 
//ISG complex too...
//ISG (PATH eml/dataset/dataTable/attributeList/attribute/measurementScale/nominal/nonNumericDomain/enumeratedDomain/codeDefinition/code or definition)
	"field_var_definition" => "attributeDefinition", 
//ISG (PATH eml/dataset/dataTable/attributeList/attribute/attributeDefinition)
	"field_var_missingvalues" => "missingValues"
//this is complex too..
//ISG (PATH eml/dataset/dataTable/attributeList/attribute/missingValueCode/code or value) );

/* "research_site" */
 
/* ISG these are complex. most fields (climate, geology, history, landform, soils and vegetation) map into EML's
	"geographicDescription" tag. */
 $site_field_arr = array(
	"field_research_site_climate" => "field_research_site_climate",
	"field_research_site_elevation" => "elevation",
//maps into elevation/maximum and elevation/minimum
	"field_research_site_geology" => "field_research_site_geology",
	"field_research_site_history" => "field_research_site_history",
	"field_research_site_hydrology" => "field_research_site_hydrology",
	"field_research_site_landform" => "field_research_site_landform",
	"field_research_site_pt_coords" => "field_research_site_pt_coords", 
// "field_research_site_siteid" => "field_research_site_siteid", 
//no EML couterpart
	"field_research_site_soils" => "field_research_site_soils",
	"field_research_site_vegetation" => "field_research_site_vegetation" );

/*
	"person" */
 
// 	"field_dataset_datamanager_ref", 
// 	"field_dataset_fieldcrew_ref", 
// 	"field_dataset_labcrew_ref", 

$person_field_arr = array(
	"field_person_first_name" => "givenName",
	"field_person_last_name" => "surname",
	"field_person_title" => "field_person_title",
	"field_person_address" => "deliveryPoint",
	"field_person_city" => "city",
	"field_person_state" => "administrativeArea",
	"field_person_country" => "country",
	"field_person_zipcode" => "postalCode",
	"field_person_email" => "electronicMailAddress",
	"field_person_fax" => "fax", 
//EML
	"field_person_organization" => "organization",
	"field_person_personid" => "personid",
	"field_person_phone" => "phone",
//EML 
// 	"field_person_dataset" => "field_person_dataset", Referrers 
// 	"field_person_proj" => "field_person_proj", Referrers
	"field_person_role" => "role", 
);

$person_field_ref_arr = array(
	"field_person_user" => "field_person_user" );

/*
	"research_project" */
 $research_project_field_arr = array(
	"field_project_description" => "field_project_description" );

$research_project_field_ref_arr = array(
	"field_research_project_data" => "field_research_project_data",
	"field_research_project_invest" => "field_research_project_invest",
	"field_research_project_sites"  => "field_research_project_sites" );

print '';

$drupal_node_flag = 0;
?> 

$row): 

/* Dataset */
 
/* ISG EML calls for a specific order of appearance... dataset-title,creator(owner),metadataProvider,associatedParty(datamanager,fieldCrew,labCrew,extAssoc),pubDate,abstract,...) */
 print_open_tag("Dataset");

foreach ($row as $field => $content): $node = node_load($content);

// print out "direct" values print_values($data_set_field_arr, $node, $drupal_node_attr);

// TODO: for all "print_flat_ref_value" move label names, field names and array names into one "config" array in the beginning of the file. 
// go to refs and print its values and refs out print_flat_ref_value("field_dataset_contact", "contact", $node, $person_field_arr, $drupal_node_attr);

// print_flat_ref_value("field_dataset_datafile_ref", "data_file", $node, $data_file_field_arr, $drupal_node_attr);
$tag_name = "datafile_ref";
$field_name = "field_dataset_datafile_ref";
$field_arr = $data_file_field_arr;
print_open_tag($tag_name);
$field_value = $node->$field_name;
foreach ($field_value as $key1 => $value1){ foreach ($value1 as $key2 => $value2){ $ref_node = node_load($value2);
print_values($field_arr, $ref_node, $drupal_node_attr);
print_flat_ref_value("field_datafile_site_ref", "sites", $ref_node, $site_field_arr, $drupal_node_attr);
print_flat_ref_value("field_datafile_variable_ref", "variables", $ref_node, $var_field_arr, $drupal_node_attr);

}
}print_close_tag($tag_name);
print_flat_ref_value("field_dataset_ext_assoc", "ext_assoc", $node, $person_field_arr, $drupal_node_attr);
print_flat_ref_value("field_dataset_owner", "owner", $node, $person_field_arr, $drupal_node_attr);
print_flat_ref_value("field_dataset_site_ref", "site", $node, $site_field_arr, $drupal_node_attr);
endforeach;

//($row as $field => $content) print_close_tag("Dataset");
endforeach;

//($themed_rows as $count => $row) print_close_tag("eml:eml");
?>

?>