$view = new view;
$view->name = 'eml_view15';
$view->description = 'eml_view';
$view->tag = '';
$view->view_php = '';
$view->base_table = 'node';
$view->is_cacheable = FALSE;
$view->api_version = 2;
$view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */
$handler = $view->new_display('default', 'Defaults', 'default');
$handler->override_option('fields', array(
  'nid' => array(
    'label' => '',
    'alter' => array(
      'alter_text' => 0,
      'text' => '',
      'make_link' => 0,
      'path' => '',
      'link_class' => '',
      'alt' => '',
      'prefix' => '',
      'suffix' => '',
      'target' => '',
      'help' => '',
      'trim' => 0,
      'max_length' => '',
      'word_boundary' => 1,
      'ellipsis' => 1,
      'html' => 0,
      'strip_tags' => 0,
    ),
    'empty' => '',
    'hide_empty' => 0,
    'empty_zero' => 0,
    'link_to_node' => 0,
    'exclude' => 0,
    'id' => 'nid',
    'table' => 'node',
    'field' => 'nid',
    'override' => array(
      'button' => 'Override',
    ),
    'relationship' => 'none',
  ),
));
$handler->override_option('arguments', array(
  'nid' => array(
    'default_action' => 'ignore',
    'style_plugin' => 'default_summary',
    'style_options' => array(),
    'wildcard' => 'all',
    'wildcard_substitution' => 'All',
    'title' => '',
    'breadcrumb' => '',
    'default_argument_type' => 'fixed',
    'default_argument' => '',
    'validate_type' => 'none',
    'validate_fail' => 'ignore',
    'break_phrase' => 0,
    'not' => 0,
    'id' => 'nid',
    'table' => 'node',
    'field' => 'nid',
    'validate_user_argument_type' => 'uid',
    'validate_user_roles' => array(
      '2' => 0,
      '3' => 0,
    ),
    'relationship' => 'none',
    'default_options_div_prefix' => '',
    'default_argument_fixed' => '',
    'default_argument_user' => 0,
    'default_argument_php' => '',
    'validate_argument_node_type' => array(
      'biblio' => 0,
      'data_file' => 0,
      'data_set' => 0,
      'page' => 0,
      'person' => 0,
      'research_site' => 0,
      'slide' => 0,
      'story' => 0,
      'variable' => 0,
    ),
    'validate_argument_node_access' => 0,
    'validate_argument_nid_type' => 'nid',
    'validate_argument_vocabulary' => array(
      '5' => 0,
    ),
    'validate_argument_type' => 'tid',
    'validate_argument_transform' => 0,
    'validate_user_restrict_roles' => 0,
    'validate_argument_php' => '',
  ),
));
$handler->override_option('filters', array(
  'type' => array(
    'operator' => 'in',
    'value' => array(
      'data_set' => 'data_set',
    ),
    'group' => '0',
    'exposed' => FALSE,
    'expose' => array(
      'operator' => FALSE,
      'label' => '',
    ),
    'id' => 'type',
    'table' => 'node',
    'field' => 'type',
    'relationship' => 'none',
  ),
));
$handler->override_option('access', array(
  'type' => 'none',
));
$handler->override_option('cache', array(
  'type' => 'none',
));
$handler->override_option('items_per_page', 15);
$handler = $view->new_display('feed', 'Feed', 'feed_1');
$handler->override_option('style_plugin', 'views_eml');
$handler->override_option('style_options', array(
  'mission_description' => FALSE,
  'description' => '',
));
$handler->override_option('row_plugin', '');
$handler->override_option('path', 'eml_view15');
$handler->override_option('menu', array(
  'type' => 'none',
  'title' => '',
  'description' => '',
  'weight' => 0,
  'name' => 'navigation',
));
$handler->override_option('tab_options', array(
  'type' => 'none',
  'title' => '',
  'description' => '',
  'weight' => 0,
  'name' => 'navigation',
));
$handler->override_option('displays', array());
$handler->override_option('sitename_title', FALSE);
