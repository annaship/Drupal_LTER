$content['type']  = array (
  'name' => 'Eml Settings',
  'type' => 'eml_settings',
  'description' => 'The site specific EML settings. The very last one will be used in all Drupal2EML results.',
  'title_label' => 'Title',
  'body_label' => '',
  'min_word_count' => '0',
  'help' => '',
  'node_options' => 
  array (
    'status' => true,
    'revision' => true,
    'promote' => false,
    'sticky' => false,
  ),
  'language_content_type' => '0',
  'upload' => '0',
  'old_type' => 'eml_settings',
  'orig_type' => '',
  'module' => 'node',
  'custom' => '1',
  'modified' => '1',
  'locked' => '0',
  'content_profile_use' => 0,
  'comment' => '0',
  'comment_default_mode' => '4',
  'comment_default_order' => '1',
  'comment_default_per_page' => '50',
  'comment_controls' => '3',
  'comment_anonymous' => 0,
  'comment_subject_field' => '1',
  'comment_preview' => '1',
  'comment_form_location' => '0',
  'ant' => '1',
  'ant_pattern' => 'The Site EML Settings',
  'ant_php' => 0,
);
$content['groups']  = array (
  0 => 
  array (
    'label' => 'Metadata Provider and Publisher',
    'group_type' => 'standard',
    'settings' => 
    array (
      'form' => 
      array (
        'style' => 'fieldset_collapsible',
        'description' => '',
      ),
      'display' => 
      array (
        'description' => '',
        'teaser' => 
        array (
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'full' => 
        array (
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        4 => 
        array (
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'token' => 
        array (
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'label' => 'above',
      ),
    ),
    'weight' => '1',
    'group_name' => 'group_metadata_provider_and_publ',
  ),
);
$content['fields']  = array (
  0 => 
  array (
    'label' => 'Acronym',
    'field_name' => 'field_acronym',
    'type' => 'text',
    'widget_type' => 'text_textfield',
    'change' => 'Change basic information',
    'weight' => '-3',
    'rows' => 5,
    'size' => '3',
    'description' => '',
    'default_value' => 
    array (
      0 => 
      array (
        'value' => '',
        '_error_element' => 'default_value_widget][field_acronym][0][value',
      ),
    ),
    'default_value_php' => '',
    'default_value_widget' => NULL,
    'group' => false,
    'required' => 0,
    'multiple' => '0',
    'text_processing' => '0',
    'max_length' => '3',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'op' => 'Save field settings',
    'module' => 'text',
    'widget_module' => 'text',
    'columns' => 
    array (
      'value' => 
      array (
        'type' => 'varchar',
        'length' => '3',
        'not null' => false,
        'sortable' => true,
        'views' => true,
      ),
    ),
    'display_settings' => 
    array (
      'label' => 
      array (
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      4 => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      2 => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      3 => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
  ),
  1 => 
  array (
    'label' => 'Language',
    'field_name' => 'field_language',
    'type' => 'text',
    'widget_type' => 'text_textfield',
    'change' => 'Change basic information',
    'weight' => '-2',
    'rows' => 5,
    'size' => '60',
    'description' => '',
    'default_value' => 
    array (
      0 => 
      array (
        'value' => 'english',
        '_error_element' => 'default_value_widget][field_language][0][value',
      ),
    ),
    'default_value_php' => '',
    'default_value_widget' => 
    array (
      'field_language' => 
      array (
        0 => 
        array (
          'value' => 'english',
          '_error_element' => 'default_value_widget][field_language][0][value',
        ),
      ),
    ),
    'group' => false,
    'required' => 0,
    'multiple' => '0',
    'text_processing' => '0',
    'max_length' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'op' => 'Save field settings',
    'module' => 'text',
    'widget_module' => 'text',
    'columns' => 
    array (
      'value' => 
      array (
        'type' => 'text',
        'size' => 'big',
        'not null' => false,
        'sortable' => true,
        'views' => true,
      ),
    ),
    'display_settings' => 
    array (
      'weight' => '-2',
      'parent' => '',
      'label' => 
      array (
        'format' => 'above',
      ),
      'teaser' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      4 => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      2 => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      3 => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
  ),
  2 => 
  array (
    'label' => 'Intellectual Rights',
    'field_name' => 'field_intellectual_rights',
    'type' => 'text',
    'widget_type' => 'text_textarea',
    'change' => 'Change basic information',
    'weight' => '-1',
    'rows' => '5',
    'size' => 60,
    'description' => '',
    'default_value' => 
    array (
      0 => 
      array (
        'value' => '',
        '_error_element' => 'default_value_widget][field_intellectual_rights][0][value',
      ),
    ),
    'default_value_php' => '',
    'default_value_widget' => 
    array (
      'field_intellectual_rights' => 
      array (
        0 => 
        array (
          'value' => '',
          '_error_element' => 'default_value_widget][field_intellectual_rights][0][value',
        ),
      ),
    ),
    'group' => false,
    'required' => 0,
    'multiple' => '0',
    'text_processing' => '0',
    'max_length' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'op' => 'Save field settings',
    'module' => 'text',
    'widget_module' => 'text',
    'columns' => 
    array (
      'value' => 
      array (
        'type' => 'text',
        'size' => 'big',
        'not null' => false,
        'sortable' => true,
        'views' => true,
      ),
    ),
    'display_settings' => 
    array (
      'weight' => '-1',
      'parent' => '',
      'label' => 
      array (
        'format' => 'above',
      ),
      'teaser' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      4 => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      2 => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      3 => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
  ),
  3 => 
  array (
    'label' => 'Data Policies',
    'field_name' => 'field_data_policies',
    'type' => 'text',
    'widget_type' => 'text_textarea',
    'change' => 'Change basic information',
    'weight' => 0,
    'rows' => '5',
    'size' => 60,
    'description' => '',
    'default_value' => 
    array (
      0 => 
      array (
        'value' => '',
        '_error_element' => 'default_value_widget][field_data_policies][0][value',
      ),
    ),
    'default_value_php' => '',
    'default_value_widget' => 
    array (
      'field_data_policies' => 
      array (
        0 => 
        array (
          'value' => '',
          '_error_element' => 'default_value_widget][field_data_policies][0][value',
        ),
      ),
    ),
    'group' => false,
    'required' => 0,
    'multiple' => '0',
    'text_processing' => '0',
    'max_length' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'op' => 'Save field settings',
    'module' => 'text',
    'widget_module' => 'text',
    'columns' => 
    array (
      'value' => 
      array (
        'type' => 'text',
        'size' => 'big',
        'not null' => false,
        'sortable' => true,
        'views' => true,
      ),
    ),
    'display_settings' => 
    array (
      'weight' => 0,
      'parent' => '',
      'label' => 
      array (
        'format' => 'above',
      ),
      'teaser' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      4 => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      2 => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      3 => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
  ),
  4 => 
  array (
    'label' => 'Metadata Provider',
    'field_name' => 'field_metadata_provider_ref',
    'type' => 'nodereference',
    'widget_type' => 'noderefcreate_autocomplete',
    'change' => 'Change basic information',
    'weight' => '38',
    'autocomplete_match' => 'contains',
    'description' => '',
    'default_value' => 
    array (
    ),
    'default_value_php' => '$query = db_query(\'SELECT nid FROM content_type_person 
                      WHERE field_person_role_value = "Metadata Provider" 
                        and nid = (SELECT max(nid) FROM content_type_person 
                                    WHERE field_person_role_value = "Metadata Provider")\');
$metadata_provider_nid = db_result($query);  
return array(
  0 => array(\'nid\' => $metadata_provider_nid),
);',
    'default_value_widget' => 
    array (
      'field_metadata_provider_ref' => 
      array (
        0 => 
        array (
          'nid' => 
          array (
            'nid' => ' [nid:724]',
            '_error_element' => 'default_value_widget][field_metadata_provider_ref][0][nid][nid',
          ),
          '_error_element' => 'default_value_widget][field_metadata_provider_ref][0][nid][nid',
        ),
      ),
    ),
    'group' => 'group_metadata_provider_and_publ',
    'required' => 1,
    'multiple' => '0',
    'referenceable_types' => 
    array (
      'person' => 'person',
      'biblio' => 0,
      'blog' => 0,
      'data_file' => 0,
      'data_set' => 0,
      'eml_settings' => 0,
      'forum' => 0,
      'page' => 0,
      'poll' => 0,
      'profile' => 0,
      'research_site' => 0,
      'story' => 0,
      'variable' => 0,
    ),
    'advanced_view' => '--',
    'advanced_view_args' => '',
    'show_add_link' => 1,
    'op' => 'Save field settings',
    'module' => 'nodereference',
    'widget_module' => 'noderefcreate',
    'columns' => 
    array (
      'nid' => 
      array (
        'type' => 'int',
        'unsigned' => true,
        'not null' => false,
        'index' => true,
      ),
    ),
    'display_settings' => 
    array (
      'weight' => '38',
      'parent' => 'group_metadata_provider_and_publ',
      'label' => 
      array (
        'format' => 'above',
      ),
      'teaser' => 
      array (
        'format' => 'full',
        'exclude' => 0,
      ),
      'full' => 
      array (
        'format' => 'full',
        'exclude' => 0,
      ),
      4 => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      2 => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      3 => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
  ),
  5 => 
  array (
    'label' => 'Publisher',
    'field_name' => 'field_publisher_ref',
    'type' => 'nodereference',
    'widget_type' => 'nodereference_autocomplete',
    'change' => 'Change basic information',
    'weight' => '40',
    'autocomplete_match' => 'contains',
    'size' => '60',
    'description' => '',
    'default_value' => 
    array (
    ),
    'default_value_php' => '$query = db_query(\'SELECT nid FROM content_type_person 
                      WHERE field_person_role_value = "Publisher" 
                        and nid = (SELECT max(nid) FROM content_type_person 
                                    WHERE field_person_role_value = "Publisher")\');
$publisher_nid = db_result($query);    
return array(
  0 => array(\'nid\' => $publisher_nid),
);',
    'default_value_widget' => 
    array (
      'field_publisher_ref' => 
      array (
        0 => 
        array (
          'nid' => 
          array (
            'nid' => ' [nid:725]',
            '_error_element' => 'default_value_widget][field_publisher_ref][0][nid][nid',
          ),
          '_error_element' => 'default_value_widget][field_publisher_ref][0][nid][nid',
        ),
      ),
    ),
    'group' => 'group_metadata_provider_and_publ',
    'required' => 0,
    'multiple' => '0',
    'referenceable_types' => 
    array (
      'person' => 'person',
      'biblio' => 0,
      'blog' => 0,
      'data_file' => 0,
      'data_set' => 0,
      'eml_settings' => 0,
      'forum' => 0,
      'page' => 0,
      'poll' => 0,
      'profile' => 0,
      'research_site' => 0,
      'story' => 0,
      'variable' => 0,
    ),
    'advanced_view' => '--',
    'advanced_view_args' => '',
    'show_add_link' => 1,
    'op' => 'Save field settings',
    'module' => 'nodereference',
    'widget_module' => 'nodereference',
    'columns' => 
    array (
      'nid' => 
      array (
        'type' => 'int',
        'unsigned' => true,
        'not null' => false,
        'index' => true,
      ),
    ),
    'display_settings' => 
    array (
      'label' => 
      array (
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      4 => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      2 => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      3 => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
  ),
);
$content['extra']  = array (
  'title' => '-5',
  'revision_information' => '3',
  'author' => '2',
  'options' => '4',
  'comment_settings' => '5',
  'menu' => '-4',
  'path' => '6',
);
