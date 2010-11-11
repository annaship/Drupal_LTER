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

  //Plum Island Ecosystems LTER

  //publisher
  $publisher_givenName              = '';
  $publisher_surname                = '';
  $publisher_organization           = 'Sevilleta LTER';
  $publisher_deliveryPoint          = 'Department of Biology, University of New Mexico, MSC30 2020 ';
  $publisher_city                   = 'Albuquerque';
  $publisher_administrativeArea     = 'New Mexico';
  $publisher_postalCode             = '87131';
  $publisher_country                = 'USA';
  $publisher_phone                  = '';
  $publisher_fax                    = '';
  $publisher_role                   = 'publisher';
  $publisher_electronicMailAddress 	= 'data-use@sevilleta.unm.edu';
  $publisher_personid               = '';

  //metadataProvider
  $metadata_provider_givenName              = '';
  $metadata_provider_surname                = '';
  $metadata_provider_organization           = 'Sevilleta LTER';
  $metadata_provider_deliveryPoint          = 'Department of Biology, University of New Mexico, MSC30 2020 ';
  $metadata_provider_city                   = 'Albuquerque';
  $metadata_provider_administrativeArea     = 'new Mexico';
  $metadata_provider_postalCode             = '87131';
  $metadata_provider_country                = 'USA';
  $metadata_provider_phone                  = '';
  $metadata_provider_fax                    = '';
  $metadata_provider_role                   = 'metadataProvider';
  $metadata_provider_electronicMailAddress 	= 'data-use@sevilleta.unm.edu';
  $metadata_provider_personid               = '';

?>
