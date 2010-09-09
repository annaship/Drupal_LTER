awk "{print $4}" field_names_types.txt | grep -v ""text"," | grep -v ""number_float"," | grep -v ""number_integer"," | grep -v ""geo"," | grep -v ""filefield"," | grep -v ""ca_phone"," | grep -v ""email"," | grep -v ""date"," | grep -v ""link"," | grep -v  ""datetime"," > cct_fields_ref.txt

<?php               

// dataSetType:
  "field_dataset_abstract" => "abstract",
  "field_dataset_short_name" => "shortName",
  "field_dataset_id" => "field_dataset_id",
  "field_dataset_purpose" => "purpose",
  "field_dataset_add_info" => "additionalInfo",
"field_dataset_related_links" => "related_links",
  "field_dataset_maintenance" => "maintenance",
  "field_dataset_publication_date" => "pubDate",
  "field_beg_end_date" => "field_beg_end_date",
  "field_methods" => "methodStep",
  "field_instrumentation" => "instrumentation",
  "field_quality" => "qualityControl",

//dataset - "nodereference":
  "field_dataset_datafile_ref" => "data_file",
// "field_dataset_biblio_ref" => "biblio_ref",
  "field_dataset_owner_ref" => "owner",
  "field_dataset_contact_ref" => "contact",
"field_dataset_datamanager_ref" => "data_manager",
"field_dataset_fieldcrew_ref" => "field_crew",
"field_dataset_labcrew_ref" => "lab_crew",
  "field_dataset_ext_assoc_ref" => "ext_assoc",
  "field_dataset_site_ref" => "site",

// dataFileStructureType:
  "field_datafile_description"  => "entityDescription",
  "field_data_file"             => "field_data_file",
  "field_num_header_line"       => "numHeaderLines",
  "field_num_footer_lines"      => "numFooteLines",
  "field_orientation"           => "attributeOrientation",
  "field_quote_character"       => "field_quote_character",
  "field_delimiter"             => "fieldDelimiter",
  "field_record_delimiter"      => "field_record_delimiter",
"field_beg_end_date"            => "field_beg_end_date",
  "field_methods"               => "methodStep",
"field_instrumentation"         => "field_instrumentation",
  "field_quality"               => "qualityControl"

// file - "nodereference":
"field_datafile_variable_ref" => "field_datafile_variable_ref",
"field_datafile_site_ref"     => "field_datafile_site_ref",
// "field_dataset_referrer" - "nodereferrer"

// variableType:
  "field_attribute_label" => "attributeLabel",
"field_var_definition" => "definition",
  "field_var_missingvalues" => "missingValues",
  "field_attribute_unit" => "unit",
  "field_attribute_maximum" => "maximum",
  "field_attribute_minimum" => "minimum",
  "field_attribute_precision" => "precision",
  "field_attribute_formatstring" => "formatstring",
  "field_code_definition" => "codeDefinition"

// "field_attribute_assoc_datafile" => "assoc_datafile", // "nodereferrer"

// researchSiteType:
"field_research_site_image" => "field_research_site_image",
"field_research_site_pt_coords" => "field_research_site_pt_coords",
"field_research_site_elevation" => "field_research_site_elevation",
"field_research_site_landform" => "field_research_site_landform",
"field_research_site_geology" => "field_research_site_geology",
"field_research_site_soils" => "field_research_site_soils",
"field_research_site_hydrology" => "field_research_site_hydrology",
"field_research_site_vegetation" => "field_research_site_vegetation",
"field_research_site_climate" => "field_research_site_climate",
"field_research_site_history" => "field_research_site_history",
"field_research_site_siteid" => "field_research_site_siteid",


// personType:
"field_person_first_name" => "first_name",
"field_person_last_name" => "last_name",
"field_person_organization" => "organization",
"field_person_role" => "role",
"field_person_title" => "title",
"field_person_email" => "email",
"field_person_address" => "address",
"field_person_city" => "city",
"field_person_state" => "state",
"field_person_zipcode" => "zipcode",
"field_person_country" => "country",
"field_person_phone" => "phone",
"field_person_fax" => "fax",
"field_person_personid" => "personid",
"field_person_uid" => "uid",
"userreference" => 
"field_person_pubs" => "pubs",
// "nodereference"

// researchProjectType:
"field_project_description" => "field_project_description",
"field_research_project_invest" => "field_research_project_invest",
// "nodereference"
"field_research_project_data" => "field_research_project_data",
// "nodereference"
"field_research_project_sites" => "field_research_project_sites",
// "nodereference"
"field_research_project_funding" => "field_research_project_funding",



?>