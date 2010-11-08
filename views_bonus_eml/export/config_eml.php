<?php
/* 
 * Here goes an site specific information
 */
  $views_bonus_eml_site_name = variable_get('site_name', NULL);
  $package_id = $views_bonus_eml_site_name . '.' . $ver_vid;

  // put allowed HTML tags here
  function views_bonus_eml_my_strip_tags($content) {
    return strip_tags($content, '<p><h1><h2><h3><h4><h5><a><pre><para>');
  }

  // Intellectual Rights
  $data_policies = '';
  $intellectual_rights = '';

  //Plum Island Ecosystems LTER

  //publisher
  $publisher_givenName              = '';
  $publisher_surname                = '';
  $publisher_organization           = '';
  $publisher_deliveryPoint          = '';
  $publisher_city                   = '';
  $publisher_administrativeArea     = '';
  $publisher_postalCode             = '';
  $publisher_country                = '';
  $publisher_phone                  = '';
  $publisher_fax                    = '';
  $publisher_role                   = 'publisher';
  $publisher_electronicMailAddress 	= '';
  $publisher_personid               = '';

  //metadataProvider
  $metadata_provider_givenName              = '';
  $metadata_provider_surname                = '';
  $metadata_provider_organization           = '';
  $metadata_provider_deliveryPoint          = '';
  $metadata_provider_city                   = '';
  $metadata_provider_administrativeArea     = '';
  $metadata_provider_postalCode             = '';
  $metadata_provider_country                = '';
  $metadata_provider_phone                  = '';
  $metadata_provider_fax                    = '';
  $metadata_provider_role                   = 'metadataProvider';
  $metadata_provider_electronicMailAddress 	= '';
  $metadata_provider_personid               = '';

?>
