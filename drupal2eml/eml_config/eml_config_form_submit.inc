<?php
// not used for now, validation is going in DB
function eml_config_form_validate ($form_id, &$form_state) {
  // $toast = $form_state['values']['toast'];
  //
  // if (!$toast) {
  //   form_set_error('toast error', t('You must like toast!'));
  // }
}

function eml_config_form_submit($form_id, &$form_state) {
  // date_default_timezone_set('America/New_York');
  $acronym             = $form_state['values']['acronym'];
  $language            = $form_state['values']['language'];
  $intellectual_rights = $form_state['values']['intellectual_rights'];
  // $data_policies       = $form_state['values']['data_policies'];
  
  $metadata_provider_settings = array(
    'organization' => $form_state['values']['persons']['metadataProvider']['organization'],
    'address'      => $form_state['values']['persons']['metadataProvider']['address'],
    'city'         => $form_state['values']['persons']['metadataProvider']['city'],
    'state'        => $form_state['values']['persons']['metadataProvider']['state'],
    'zipcode'      => $form_state['values']['persons']['metadataProvider']['zipcode'],
    'country'      => $form_state['values']['persons']['metadataProvider']['country'],
    'phone'        => $form_state['values']['persons']['metadataProvider']['phone'],
    'fax'          => $form_state['values']['persons']['metadataProvider']['fax'],
    'role'         => $form_state['values']['persons']['metadataProvider']['role'],
    'email'        => $form_state['values']['persons']['metadataProvider']['email'],
  );

  $metadata_provider_node_id = person_node_create($metadata_provider_settings);

  $publisher_settings = array(
    'organization' => $form_state['values']['persons']['publisher']['organization'],
    'address'      => $form_state['values']['persons']['publisher']['address'],
    'city'         => $form_state['values']['persons']['publisher']['city'],
    'state'        => $form_state['values']['persons']['publisher']['state'],
    'zipcode'      => $form_state['values']['persons']['publisher']['zipcode'],
    'country'      => $form_state['values']['persons']['publisher']['country'],
    'phone'        => $form_state['values']['persons']['publisher']['phone'],
    'fax'          => $form_state['values']['persons']['publisher']['fax'],
    'role'         => $form_state['values']['persons']['publisher']['role'],
    'email'        => $form_state['values']['persons']['publisher']['email'],
  );

  $publisher_node_id = person_node_create($publisher_settings);
                 
  variable_set('eml_settings_acronym', $acronym);   
  variable_set('eml_settings_language', $language);
  variable_set('eml_settings_intellectual_rights', $intellectual_rights);
  // variable_set('eml_settings_data_policies', $data_policies);
  variable_set('eml_settings_metadata_provider_ref', $metadata_provider_node_id);
  variable_set('eml_settings_publisher_ref', $publisher_node_id);
   
  drupal_set_message(t('Your EML settings have been saved.'));
  // drupal_set_message(t('Metadata Provider\'s email is ') . $metadata_provider_settings['email']);

}

function person_node_create($person_settings) {

  global $user;

  $uid = $user->uid;
  $node = new StdClass();
  $node->type = "person";
  $node->uid = $uid;
  $node->field_person_organization = Array (0 => Array ('value' => $person_settings['organization']));
  $node->field_person_address = Array (0 => Array ('value' => $person_settings['address']));
  $node->field_person_city = Array (0 => Array ('value' => $person_settings['city']));
  $node->field_person_state = Array (0 => Array ('value' => $person_settings['state']));
  $node->field_person_zipcode = Array (0 => Array ('value' => $person_settings['zipcode']));
  $node->field_person_country = Array (0 => Array ('value' => $person_settings['country']));
  $node->field_person_phone = Array (0 => Array ('value' => $person_settings['phone']));
  $node->field_person_fax = Array (0 => Array ('value' => $person_settings['fax']));
  $node->field_person_role = Array (0 => Array ('value' => $person_settings['role']));
  $node->field_person_email = Array (0 => Array ('email' => $person_settings['email']));

  // Commented fields are here in case we will need them
  // $node->field_person_title = Array (0 => Array ('value' => ''));
  // $node->field_person_first_name = Array (0 => Array ('value' => ''));
  // $node->field_person_last_name = Array (0 => Array ('value' => ''));
  // $node->field_person_personid = Array (0 => Array ('value' => $personid));

  node_save($node);

  return $node->nid;
}
