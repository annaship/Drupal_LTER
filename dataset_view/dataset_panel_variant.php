<?php
$handler = new stdClass;
$handler->disabled = FALSE; /* Edit this to true to make a default handler disabled initially */
$handler->api_version = 1;
$handler->name = 'node_view_panel_context';
$handler->task = 'node_view';
$handler->subtask = '';
$handler->handler = 'panel_context';
$handler->weight = 0;
$handler->conf = array(
  'title' => 'Dataset_from51',
  'no_blocks' => 0,
  'pipeline' => 'standard',
  'css_id' => '',
  'css' => '',
  'contexts' => array(),
  'relationships' => array(
    0 => array(
      'context' => 'argument_nid_1',
      'name' => 'node_from_noderef',
      'id' => 1,
      'identifier' => 'Owner Ref',
      'keyword' => 'ownerref',
      'relationship_settings' => array(
        'field_name' => 'field_dataset_owner_ref',
      ),
    ),
  ),
  'access' => array(
    'plugins' => array(
      0 => array(
        'name' => 'node_type',
        'settings' => array(
          'type' => array(
            'data_set' => 'data_set',
          ),
        ),
        'context' => 'argument_nid_1',
        'not' => FALSE,
      ),
    ),
    'logic' => 'and',
  ),
);
$display = new panels_display;
$display->layout = 'flexible';
$display->layout_settings = array(
  'items' => array(
    'canvas' => array(
      'type' => 'row',
      'contains' => 'column',
      'children' => array(
        0 => 'main',
      ),
      'parent' => NULL,
    ),
    'main' => array(
      'type' => 'column',
      'width' => 100,
      'width_type' => '%',
      'children' => array(
        0 => 'main-row',
        1 => 1,
      ),
      'parent' => 'canvas',
    ),
    'main-row' => array(
      'type' => 'row',
      'contains' => 'region',
      'children' => array(
        0 => 'center',
        1 => 'personnell',
      ),
      'parent' => 'main',
    ),
    'center' => array(
      'type' => 'region',
      'title' => 'Center',
      'width' => '50.04222058538135',
      'width_type' => '%',
      'parent' => 'main-row',
    ),
    'personnell' => array(
      'type' => 'region',
      'title' => 'Personnell',
      'width' => '49.95777941461865',
      'width_type' => '%',
      'parent' => 'main-row',
    ),
    1 => array(
      'type' => 'row',
      'contains' => 'region',
      'children' => array(
        0 => 'variable_info',
      ),
      'parent' => 'main',
    ),
    'variable_info' => array(
      'type' => 'region',
      'title' => 'Variable info',
      'width' => 100,
      'width_type' => '%',
      'parent' => '1',
    ),
  ),
);
$display->panel_settings = array(
  'style_settings' => array(
    'center' => NULL,
    'personnell' => NULL,
    'variable_info' => NULL,
    'default' => NULL,
  ),
  'style' => 'stylizer:test1',
  'personnell' => array(
    'style' => 'stylizer:test_small',
  ),
);
$display->cache = array();
$display->title = '';
$display->content = array();
$display->panels = array();
  $pane = new stdClass;
  $pane->pid = 'new-1';
  $pane->panel = 'center';
  $pane->type = 'content_field';
  $pane->subtype = 'field_dataset_abstract';
  $pane->shown = TRUE;
  $pane->access = array();
  $pane->configuration = array(
    'label' => 'above',
    'formatter' => 'default',
    'context' => 'argument_nid_1',
    'override_title' => 0,
    'override_title_text' => '',
  );
  $pane->cache = array();
  $pane->style = array(
    'settings' => NULL,
  );
  $pane->css = array();
  $pane->extras = array();
  $pane->position = 0;
  $display->content['new-1'] = $pane;
  $display->panels['center'][0] = 'new-1';
  $pane = new stdClass;
  $pane->pid = 'new-2';
  $pane->panel = 'center';
  $pane->type = 'node_title';
  $pane->subtype = 'node_title';
  $pane->shown = TRUE;
  $pane->access = array();
  $pane->configuration = array(
    'link' => 1,
    'context' => 'argument_nid_1',
    'override_title' => 0,
    'override_title_text' => '',
  );
  $pane->cache = array();
  $pane->style = array(
    'settings' => NULL,
  );
  $pane->css = array();
  $pane->extras = array();
  $pane->position = 1;
  $display->content['new-2'] = $pane;
  $display->panels['center'][1] = 'new-2';
  $pane = new stdClass;
  $pane->pid = 'new-3';
  $pane->panel = 'center';
  $pane->type = 'content_field';
  $pane->subtype = 'field_dataset_add_info';
  $pane->shown = TRUE;
  $pane->access = array();
  $pane->configuration = array(
    'label' => 'normal',
    'formatter' => 'default',
    'context' => 'argument_nid_1',
    'override_title' => 0,
    'override_title_text' => '',
  );
  $pane->cache = array();
  $pane->style = array(
    'settings' => NULL,
  );
  $pane->css = array();
  $pane->extras = array();
  $pane->position = 2;
  $display->content['new-3'] = $pane;
  $display->panels['center'][2] = 'new-3';
  $pane = new stdClass;
  $pane->pid = 'new-4';
  $pane->panel = 'center';
  $pane->type = 'content_field';
  $pane->subtype = 'field_dataset_datafile_ref';
  $pane->shown = TRUE;
  $pane->access = array();
  $pane->configuration = array(
    'label' => 'above',
    'formatter' => 'full',
    'context' => 'argument_nid_1',
    'override_title' => 0,
    'override_title_text' => '',
  );
  $pane->cache = array();
  $pane->style = array(
    'settings' => NULL,
  );
  $pane->css = array();
  $pane->extras = array();
  $pane->position = 3;
  $display->content['new-4'] = $pane;
  $display->panels['center'][3] = 'new-4';
  $pane = new stdClass;
  $pane->pid = 'new-5';
  $pane->panel = 'personnell';
  $pane->type = 'content_field';
  $pane->subtype = 'field_dataset_owner_ref';
  $pane->shown = TRUE;
  $pane->access = array();
  $pane->configuration = array(
    'label' => 'normal',
    'formatter' => 'full',
    'context' => 'argument_nid_1',
    'override_title' => 0,
    'override_title_text' => '',
  );
  $pane->cache = array();
  $pane->style = array(
    'settings' => NULL,
  );
  $pane->css = array();
  $pane->extras = array();
  $pane->position = 0;
  $display->content['new-5'] = $pane;
  $display->panels['personnell'][0] = 'new-5';
  $pane = new stdClass;
  $pane->pid = 'new-6';
  $pane->panel = 'personnell';
  $pane->type = 'content_field';
  $pane->subtype = 'field_dataset_contact_ref';
  $pane->shown = TRUE;
  $pane->access = array();
  $pane->configuration = array(
    'label' => 'normal',
    'formatter' => 'full',
    'context' => 'argument_nid_1',
    'override_title' => 0,
    'override_title_text' => '',
  );
  $pane->cache = array();
  $pane->style = array(
    'settings' => NULL,
  );
  $pane->css = array();
  $pane->extras = array();
  $pane->position = 1;
  $display->content['new-6'] = $pane;
  $display->panels['personnell'][1] = 'new-6';
  $pane = new stdClass;
  $pane->pid = 'new-7';
  $pane->panel = 'variable_info';
  $pane->type = 'views_panes';
  $pane->subtype = 'variable_info-panel_pane_1';
  $pane->shown = TRUE;
  $pane->access = array();
  $pane->configuration = array(
    'context' => array(
      0 => 'argument_nid_1',
    ),
  );
  $pane->cache = array();
  $pane->style = array(
    'settings' => NULL,
  );
  $pane->css = array();
  $pane->extras = array();
  $pane->position = 0;
  $display->content['new-7'] = $pane;
  $display->panels['variable_info'][0] = 'new-7';
$display->hide_title = PANELS_TITLE_FIXED;
$display->title_pane = '0';
$handler->conf['display'] = $display;
