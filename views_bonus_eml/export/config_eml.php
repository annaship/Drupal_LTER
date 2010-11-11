<?php
/* 
 * Here goes an site specific information
 */

  // TODO: hardcode the pubPlace, specific for every given site
  // example: <pubPLace> Plum Island Ecosystems LTER </pubPlace>
  // for now taking automatically: variable_get('site_name', NULL);

  $views_bonus_eml_site_name = variable_get('site_name', NULL);

  // put allowed HTML tags here
  function views_bonus_eml_my_strip_tags($content = '') {
    return strip_tags($content, '<p><h1><h2><h3><h4><h5><a><pre><para>');
  }

  // Intellectual Rights
  $data_policies = '';
  $intellectual_rights = '';

  // TODO: create metadataProvider and publisher as a regular nodes
  // via dataset CCT form / eml2drupal script

  // metadataProvider
$metadata_provider_obj = (object) array(
  'nid'                       => 'fake_nid',
  'field_person_first_name'   => array ( array ('value' => '')),
  'field_person_last_name'    => array ( array ('value' => '')),
  'field_person_organization' => array ( array ('value' => 'Sevilleta LTER')),
  'field_person_address'      => array ( array ('value' => 'Department of Biology, University of New Mexico, MSC30 2020 ')),
  'field_person_city'         => array ( array ('value' => 'Albuquerque')),
  'field_person_state'        => array ( array ('value' => 'new Mexico')),
  'field_person_zipcode'      => array ( array ('value' => '87131')),
  'field_person_country'      => array ( array ('value' => 'USA')),
  'field_person_phone'        => array ( array ('value' => '')),
  'field_person_fax'          => array ( array ('value' => '')),
  'field_person_role'         => array ( array ('value' => 'metadataProvider')),
  'field_person_email' 	      => array ( array ('value' => 'data-use@sevilleta.unm.edu')),
  'field_person_address'      => array ( array ('value' => 'Department of Biology, University of New Mexico, MSC30 2020 ')),
  'field_person_personid'     => array ( array ('value' => '')),
);


  // publisher
$publisher_obj = (object) array(
  'nid'                       => 'fake_nid',
  'field_person_first_name'   => array ( array ('value' => '')),
  'field_person_last_name'    => array ( array ('value' => '')),
  'field_person_organization' => array ( array ('value' => 'Sevilleta LTER')),
  'field_person_address'      => array ( array ('value' => 'Department of Biology, University of New Mexico, MSC30 2020 ')),
  'field_person_city'         => array ( array ('value' => 'Albuquerque')),
  'field_person_state'        => array ( array ('value' => 'new Mexico')),
  'field_person_zipcode'      => array ( array ('value' => '87131')),
  'field_person_country'      => array ( array ('value' => 'USA')),
  'field_person_phone'        => array ( array ('value' => '')),
  'field_person_fax'          => array ( array ('value' => '')),
  'field_person_role'         => array ( array ('value' => 'metadataProvider')),
  'field_person_email' 	      => array ( array ('value' => 'data-use@sevilleta.unm.edu')),
  'field_person_address'      => array ( array ('value' => 'Department of Biology, University of New Mexico, MSC30 2020 ')),
  'field_person_personid'     => array ( array ('value' => '')),
);


$metadata_provider_arr = array ($metadata_provider_obj);
$publisher_arr         = array ($publisher_obj);

?>
