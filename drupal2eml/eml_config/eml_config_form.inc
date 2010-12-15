<?php

require_once('eml_config_form_submit.inc');

function eml_config_form($form_state) {
  $form = array();
  unset($last_settings);
  
  // $q = db_query('SELECT nid FROM node WHERE nid > 689;');           
  // while ($nid = db_result($q)) {                                                                               
  //   node_delete($nid);                                                                                         
  // }                                                                                                            
  // dpm(node_load(2890));                                                                                        
  
  // $last_settings = get_last_settings();
  $default_setting = '';
  $last_settings   = array (
    'last_acronym'             => variable_get('eml_settings_acronym', $default_setting),
    'last_language'            => variable_get('eml_settings_language', $default_setting),
    'last_intellectual_rights' => variable_get('eml_settings_intellectual_rights', $default_setting),
    // 'last_data_policies'       => variable_get('eml_settings_data_policies', $default_setting),
  );

  $form['acronym'] = array(
    '#type'  => 'textfield',
    '#title' => t('Site name acronym'),
    // '#required'  => TRUE,
    '#size'  => 3,
    '#maxlength' => 3,
    '#default_value' => variable_get('acronym', $last_settings['last_acronym']),
    // '#description' => t('Site name acronym'),
  );

  $form['language'] = array(
    '#type'  => 'textfield',
    '#title' => t('Language'),
    // '#required'  => TRUE,
    '#size'  => 15,
    '#maxlength' => 64,
    '#default_value' => variable_get('language', 'english'),
  );

  $form['intellectual_rights'] = array(
    '#type' => 'textarea',
    '#title' => t('Intellectual Rights'),
    '#default_value' => variable_get('intellectual_rights', $last_settings['last_intellectual_rights']),    
    '#cols' => 60,
    '#rows' => 5,
  );

  // $form['data_policies'] = array(
  //   '#type' => 'textarea',
  //   '#title' => t('Data Policies'),
  //   '#default_value' => variable_get('data_policies', $last_settings['last_data_policies']),    
  //   '#cols' => 60,
  //   '#rows' => 5,
  // );

  $form['persons'] = array(
    '#type' => 'fieldset',
    '#title' => t('Metadata Provider and Publisher'),
    '#tree' => TRUE,
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  $form = person_subform($form, 'metadataProvider');
  $form = person_subform($form, 'publisher');
  
  // $form_state['redirect'] = array('page1', 'id=' . $form_state['values']['index_search']);

  $form['submit'] = array (
    '#type' => 'submit',
    '#value' => t('Create'),
    );

  return $form;
}

function person_subform($form, $role) {
  $states = array(
    'AK' => t('Alaska'),
    'AL' => t('Alabama'),
    'AR' => t('Arkansas'),
    'AZ' => t('Arizona'),
    'CA' => t('California'),
    'CO' => t('Colorado'),
    'CT' => t('Connecticut'),
    'DC' => t('District Of Columbia'),
    'DE' => t('Delaware'),
    'FL' => t('Florida'),
    'GA' => t('Georgia'),
    'HI' => t('Hawaii'),
    'IA' => t('Iowa'),
    'ID' => t('Idaho'),
    'IL' => t('Illinois'),
    'IN' => t('Indiana'),
    'KS' => t('Kansas'),
    'KY' => t('Kentucky'),
    'LA' => t('Louisiana'),
    'MA' => t('Massachusetts'),
    'MD' => t('Maryland'),
    'ME' => t('Maine'),
    'MI' => t('Michigan'),
    'MN' => t('Minnesota'),
    'MO' => t('Missouri'),
    'MS' => t('Mississippi'),
    'MT' => t('Montana'),
    'NC' => t('North Carolina'),
    'ND' => t('North Dakota'),
    'NE' => t('Nebraska'),
    'NH' => t('New Hampshire'),
    'NJ' => t('New Jersey'),
    'NM' => t('New Mexico'),
    'NV' => t('Nevada'),
    'NY' => t('New York'),
    'OH' => t('Ohio'),
    'OK' => t('Oklahoma'),
    'OR' => t('Oregon'),
    'PA' => t('Pennsylvania'),
    'PR' => t('Puerto Rico'),
    'RI' => t('Rhode Island'),
    'SC' => t('South Carolina'),
    'SD' => t('South Dakota'),
    'TN' => t('Tennessee'),
    'TX' => t('Texas'),
    'UT' => t('Utah'),
    'VA' => t('Virginia'),
    'VT' => t('Vermont'),
    'WA' => t('Washington'),
    'WI' => t('Wisconsin'),
    'WV' => t('West Virginia'),
    'WY' => t('Wyoming'),
    'NA' => t('None'),
  );

 $country_list = array (
   'United States' => t('United States'),
   'Abkhazia' => t('Abkhazia'),
   'Afghanistan' => t('Afghanistan'),
   'Akrotiri and Dhekelia' => t('Akrotiri and Dhekelia'),
   'Åland' => t('Åland'),
   'Albania' => t('Albania'),
   'Algeria' => t('Algeria'),
   'American Samoa' => t('American Samoa'),
   'Andorra' => t('Andorra'),
   'Angola' => t('Angola'),
   'Anguilla' => t('Anguilla'),
   'Antigua and Barbuda' => t('Antigua and Barbuda'),
   'Argentina' => t('Argentina'),
   'Armenia' => t('Armenia'),
   'Aruba' => t('Aruba'),
   'Ascension Island' => t('Ascension Island'),
   'Australia' => t('Australia'),
   'Austria' => t('Austria'),
   'Azerbaijan' => t('Azerbaijan'),
   'Bahamas, The' => t('Bahamas, The'),
   'Bahrain' => t('Bahrain'),
   'Bangladesh' => t('Bangladesh'),
   'Barbados' => t('Barbados'),
   'Belarus' => t('Belarus'),
   'Belgium' => t('Belgium'),
   'Belize' => t('Belize'),
   'Benin' => t('Benin'),
   'Bermuda' => t('Bermuda'),
   'Bhutan' => t('Bhutan'),
   'Bolivia' => t('Bolivia'),
   'Bosnia' => t('Bosnia'),
   'Botswana' => t('Botswana'),
   'Brazil' => t('Brazil'),
   'Brunei' => t('Brunei'),
   'Bulgaria' => t('Bulgaria'),
   'Burkina Faso' => t('Burkina Faso'),
   'Burundi' => t('Burundi'),
   'Cambodia' => t('Cambodia'),
   'Cameroon' => t('Cameroon'),
   'Canada' => t('Canada'),
   'Cape Verde' => t('Cape Verde'),
   'Cayman Islands' => t('Cayman Islands'),
   'Central African Republic' => t('Central African Republic'),
   'Chad' => t('Chad'),
   'Chile' => t('Chile'),
   'China' => t('China'),
   'Christmas Island' => t('Christmas Island'),
   'Cocos (Keeling) Islands' => t('Cocos (Keeling) Islands'),
   'Colombia' => t('Colombia'),
   'Comoros' => t('Comoros'),
   'Congo (República)' => t('Congo (República)'),
   'Congo (República Democrática)' => t('Congo (República Democrática)'),
   'Cook Islands' => t('Cook Islands'),
   'Costa Rica' => t('Costa Rica'),
   'Côte d\'Ivoire' => t('Côte d\'Ivoire'),
   'Croatia' => t('Croatia'),
   'Cuba' => t('Cuba'),
   'Cyprus' => t('Cyprus'),
   'Czech Republic' => t('Czech Republic'),
   'Denmark' => t('Denmark'),
   'Djibouti' => t('Djibouti'),
   'Dominica' => t('Dominica'),
   'Dominican Republic' => t('Dominican Republic'),
   'East Timor' => t('East Timor'),
   'Ecuador' => t('Ecuador'),
   'Egypt' => t('Egypt'),
   'El Salvador' => t('El Salvador'),
   'Equatorial Guinea' => t('Equatorial Guinea'),
   'Eritrea' => t('Eritrea'),
   'Estonia' => t('Estonia'),
   'Ethiopia' => t('Ethiopia'),
   'Falkland Islands' => t('Falkland Islands'),
   'Faroe Islands' => t('Faroe Islands'),
   'Fiji' => t('Fiji'),
   'Finland' => t('Finland'),
   'France' => t('France'),
   'French Polynesia' => t('French Polynesia'),
   'Gabon' => t('Gabon'),
   'Gambia, The' => t('Gambia, The'),
   'Georgia' => t('Georgia'),
   'Germany' => t('Germany'),
   'Ghana' => t('Ghana'),
   'Gibraltar' => t('Gibraltar'),
   'Greece' => t('Greece'),
   'Greenland' => t('Greenland'),
   'Grenada' => t('Grenada'),
   'Guam' => t('Guam'),
   'Guatemala' => t('Guatemala'),
   'Guernsey' => t('Guernsey'),
   'Guinea' => t('Guinea'),
   'Guinea-Bissau' => t('Guinea-Bissau'),
   'Guyana' => t('Guyana'),
   'Haiti' => t('Haiti'),
   'Honduras' => t('Honduras'),
   'Hong Kong' => t('Hong Kong'),
   'Hungary' => t('Hungary'),
   'Iceland' => t('Iceland'),
   'India' => t('India'),
   'Indonesia' => t('Indonesia'),
   'Iran' => t('Iran'),
   'Iraq' => t('Iraq'),
   'Ireland' => t('Ireland'),
   'Isle of Man' => t('Isle of Man'),
   'Israel' => t('Israel'),
   'Italy' => t('Italy'),
   'Jamaica' => t('Jamaica'),
   'Japan' => t('Japan'),
   'Jersey' => t('Jersey'),
   'Jordan' => t('Jordan'),
   'Kazakhstan' => t('Kazakhstan'),
   'Kenya' => t('Kenya'),
   'Kiribati' => t('Kiribati'),
   'Korea, North' => t('Korea, North'),
   'Korea, South' => t('Korea, South'),
   'Kosovo' => t('Kosovo'),
   'Kuwait' => t('Kuwait'),
   'Kyrgyzstan' => t('Kyrgyzstan'),
   'Laos' => t('Laos'),
   'Latvia' => t('Latvia'),
   'Lebanon' => t('Lebanon'),
   'Lesotho' => t('Lesotho'),
   'Liberia' => t('Liberia'),
   'Libya' => t('Libya'),
   'Liechtenstein' => t('Liechtenstein'),
   'Lithuania' => t('Lithuania'),
   'Luxembourg' => t('Luxembourg'),
   'Macau' => t('Macau'),
   'Macedonia' => t('Macedonia'),
   'Madagascar' => t('Madagascar'),
   'Malawi' => t('Malawi'),
   'Malaysia' => t('Malaysia'),
   'Maldives' => t('Maldives'),
   'Mali' => t('Mali'),
   'Malta' => t('Malta'),
   'Marshall Islands' => t('Marshall Islands'),
   'Mauritania' => t('Mauritania'),
   'Mauritius' => t('Mauritius'),
   'Mayotte' => t('Mayotte'),
   'Mexico' => t('Mexico'),
   'Micronesia' => t('Micronesia'),
   'Moldova' => t('Moldova'),
   'Monaco' => t('Monaco'),
   'Mongolia' => t('Mongolia'),
   'Montenegro' => t('Montenegro'),
   'Montserrat' => t('Montserrat'),
   'Morocco' => t('Morocco'),
   'Mozambique' => t('Mozambique'),
   'Myanmar (Burma)' => t('Myanmar (Burma)'),
   'Nagorno-Karabakh' => t('Nagorno-Karabakh'),
   'Namibia' => t('Namibia'),
   'Nauru' => t('Nauru'),
   'Nepal' => t('Nepal'),
   'Netherlands' => t('Netherlands'),
   'Netherlands Antilles' => t('Netherlands Antilles'),
   'New Caledonia' => t('New Caledonia'),
   'New Zealand' => t('New Zealand'),
   'Nicaragua' => t('Nicaragua'),
   'Niger' => t('Niger'),
   'Nigeria' => t('Nigeria'),
   'Niue' => t('Niue'),
   'Norfolk Island' => t('Norfolk Island'),
   'Northern Cyprus' => t('Northern Cyprus'),
   'Northern Mariana Islands' => t('Northern Mariana Islands'),
   'Norway' => t('Norway'),
   'Oman' => t('Oman'),
   'Pakistan' => t('Pakistan'),
   'Palau' => t('Palau'),
   'Palestine' => t('Palestine'),
   'Panama' => t('Panama'),
   'Papua New Guinea' => t('Papua New Guinea'),
   'Paraguay' => t('Paraguay'),
   'Peru' => t('Peru'),
   'Philippines' => t('Philippines'),
   'Pitcairn Islands' => t('Pitcairn Islands'),
   'Poland' => t('Poland'),
   'Portugal' => t('Portugal'),
   'Puerto Rico' => t('Puerto Rico'),
   'Qatar' => t('Qatar'),
   'Romania' => t('Romania'),
   'Russia' => t('Russia'),
   'Rwanda' => t('Rwanda'),
   'Saint Barthélemy' => t('Saint Barthélemy'),
   'Saint Helena' => t('Saint Helena'),
   'Saint Kitts and Nevis' => t('Saint Kitts and Nevis'),
   'Saint Lucia' => t('Saint Lucia'),
   'Saint Martin' => t('Saint Martin'),
   'Saint Pierre and Miquelon' => t('Saint Pierre and Miquelon'),
   'Saint Vincent and the Grenadines' => t('Saint Vincent and the Grenadines'),
   'Samoa' => t('Samoa'),
   'San Marino' => t('San Marino'),
   'São Tomé and Príncipe São' => t('São Tomé and Príncipe São'),
   'Saudi Arabia' => t('Saudi Arabia'),
   'Senegal' => t('Senegal'),
   'Serbia' => t('Serbia'),
   'Seychelles' => t('Seychelles'),
   'Sierra Leone' => t('Sierra Leone'),
   'Singapore' => t('Singapore'),
   'Slovakia' => t('Slovakia'),
   'Slovenia' => t('Slovenia'),
   'Solomon Islands' => t('Solomon Islands'),
   'Somalia' => t('Somalia'),
   'Somaliland' => t('Somaliland'),
   'South Africa' => t('South Africa'),
   'South Ossetia' => t('South Ossetia'),
   'Spain' => t('Spain'),
   'Sri Lanka' => t('Sri Lanka'),
   'Sudan' => t('Sudan'),
   'Suriname' => t('Suriname'),
   'Svalbard' => t('Svalbard'),
   'Swaziland' => t('Swaziland'),
   'Sweden' => t('Sweden'),
   'Switzerland' => t('Switzerland'),
   'Syria' => t('Syria'),
   'Taiwan' => t('Taiwan'),
   'Tajikistan' => t('Tajikistan'),
   'Tanzania' => t('Tanzania'),
   'Thailand' => t('Thailand'),
   'Togo' => t('Togo'),
   'Tokelau' => t('Tokelau'),
   'Tonga' => t('Tonga'),
   'Transnistria' => t('Transnistria'),
   'Trinidad and Tobago' => t('Trinidad and Tobago'),
   'Tristan da Cunha' => t('Tristan da Cunha'),
   'Tunisia' => t('Tunisia'),
   'Turkey' => t('Turkey'),
   'Turkmenistan' => t('Turkmenistan'),
   'Turks and Caicos Islands' => t('Turks and Caicos Islands'),
   'Tuvalu' => t('Tuvalu'),
   'Uganda' => t('Uganda'),
   'Ukraine' => t('Ukraine'),
   'United Arab Emirates' => t('United Arab Emirates'),
   'United Kingdom' => t('United Kingdom'),
   'United States of America' => t('United States of America'),
   'Uruguay' => t('Uruguay'),
   'Uzbekistan' => t('Uzbekistan'),
   'Vanuatu' => t('Vanuatu'),
   'Vatican City' => t('Vatican City'),
   'Venezuela' => t('Venezuela'),
   'Vietnam' => t('Vietnam'),
   'Virgin Islands, British' => t('Virgin Islands, British'),
   'Virgin Islands, United States' => t('Virgin Islands, United States'),
   'Wallis and Futuna' => t('Wallis and Futuna'),
   'Western Sahara' => t('Western Sahara'),
   'Yemen' => t('Yemen'),
   'Zambia' => t('Zambia'),
   'Zimbabwe' => t('Zimbabwe'),
 );

  $mysql_connection = db_set_active();
  if (!$mysql_connection) {
    die($errDbConn . mysql_error() . " :: " . mysql_errno());
  }

  $sql = "SELECT nid FROM {content_type_person}
                          WHERE (field_person_role_value = '%s'
                            and nid = (SELECT max(nid) FROM {content_type_person}
                                        WHERE field_person_role_value = '%s'))";

// If Metadata Provider exists take the last one and use by default
  $person_role_value = 'Metadata Provider';
  $query = db_query($sql, $person_role_value, $person_role_value);
  $metadata_provider_nid = db_result($query);

 if ($metadata_provider_nid) {
    $persion_node = node_load($metadata_provider_nid);
  }    
  // If Publisher exists take the last one and use by default
  if ($role == 'publisher') {
    $person_role_value = 'Publisher';
    $query = db_query($sql, $person_role_value, $person_role_value);
    $publisher_nid = db_result($query);    
    
    if ($publisher_nid) {
      $persion_node = node_load($publisher_nid);
    }      
  }
  
  if ($persion_node) {
    $organization = $persion_node->field_person_organization[0]['value'];
    $address      = $persion_node->field_person_address[0]['value'];
    $city         = $persion_node->field_person_city[0]['value'];
    $state        = $persion_node->field_person_state[0]['value'];
    $zipcode      = $persion_node->field_person_zipcode[0]['value'];
    $country      = $persion_node->field_person_country[0]['value'];
    $phone        = $persion_node->field_person_phone[0]['value'];
    $fax          = $persion_node->field_person_fax[0]['value'];
    $email        = $persion_node->field_person_email[0]['email'];
  }
  else {
    $organization = '';
    $address      = '';
    $city         = '';
    $state        = '';
    $zipcode      = '';
    $country      = '';
    $phone        = '';
    $fax          = '';
    $email        = '';
    
  }
    // Commented fields are here in case we will need them
    // $first_name   = $persion_node->field_person_first_name[0]['value'];
    // $last_name    = $persion_node->field_person_last_name[0]['value'];
    // $personid     = $persion_node->field_person_personid[0]['value'];
  
  if ($role == 'publisher') {
    $role_title = 'Publisher';
  }
  elseif ($role == 'metadataProvider') {
    $role_title = 'Metadata Provider';
  }

  $form['persons'][$role] = array(
    '#type' => 'fieldset',
    '#title' => t($role_title),
    '#tree' => TRUE,
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  $form['persons'][$role]['organization'] = array (
    '#type'  => 'textfield',
    '#title' => t('organization'),
    '#default_value' => variable_get('organization', $organization),
    '#size'  => 60,
    '#maxlength' => 60,
    );

  $form['persons'][$role]['address'] = array (
    '#type'  => 'textfield',
    '#title' => t('address'),
    '#default_value' => variable_get('address', $address),
    '#size'  => 60,
    '#maxlength' => 100,
    );

  $form['persons'][$role]['city'] = array (
    '#type'  => 'textfield',
    '#title' => t('city'),
    '#default_value' => variable_get('city', $city),
    '#size'  => 60,
    '#maxlength' => 60,
    );

  $form['persons'][$role]['state'] = array(
    '#type' => 'select',
    '#title' => t('state'),
    '#default_value' => variable_get('state', $state),
    '#options' => $states,
  );

  $form['persons'][$role]['zipcode'] = array (
    '#type'  => 'textfield',
    '#title' => t('zipcode'),
    '#default_value' => variable_get('zipcode', $zipcode),
    '#size'  => 60,
    '#maxlength' => 60,
    );

  $form['persons'][$role]['country'] = array(
    '#type' => 'select',
    '#title' => t('country'),
    '#default_value' => variable_get('country', $country),
    '#options' => $country_list,
  );

  $form['persons'][$role]['phone'] = array (
    '#type'  => 'textfield',
    '#title' => t('phone'),
    '#default_value' => variable_get('phone', $phone),
    '#size'  => 60,
    '#maxlength' => 60,
    );

  $form['persons'][$role]['fax'] = array (
    '#type'  => 'textfield',
    '#title' => t('fax'),
    '#default_value' => variable_get('fax', $fax),
    '#size'  => 60,
    '#maxlength' => 60,
    );

  $form['persons'][$role]['role'] = array(
    '#type' => 'value',
    '#value' => $role_title,
  );

  $form['persons'][$role]['email'] = array (
    '#type'  => 'textfield',
    '#title' => t('email'),
    '#default_value' => variable_get('email', $email),
    // '#required'  => TRUE,
    '#size'  => 60,
    '#maxlength' => 60,
    );

  // Commented fields are here in case we will need them

  // $form['persons'][$role]['first_name'] = array (
  //   '#type'  => 'textfield',
  //   '#title' => t('first_name'),
  //   '#default_value' => variable_get('first_name', $first_name),
  //   '#size'  => 60,
  //   '#maxlength' => 60,
  //   );
  // 
  // $form['persons'][$role]['last_name'] = array (
  //   '#type'  => 'textfield',
  //   '#title' => t('last_name'),
  //   '#default_value' => variable_get('last_name', $last_name),
  //   '#size'  => 60,
  //   '#maxlength' => 60,
  //   );

  // $form['persons'][$role]['personid'] = array (
  //   '#type'  => 'textfield',
  //   '#title' => t('personid'),
  //   '#default_value' => variable_get('personid', $personid),
  //   '#size'  => 60,
  //   '#maxlength' => 60,
  //   );

  return $form;
}            
