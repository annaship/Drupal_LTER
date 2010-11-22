<?php
// // $Id: eml_config.views_default.inc, v 1.0 2010-11-22 ashipunova Exp $
// 
// /**
//  * Views default views implementation
//  */
// 
// /**
//  * Implementation of hook_default_view_views().
//  */
//   
//   function eml_config_views_default_views() {
//     $view = new view;
//     $view->name = 'eml_settings';
//     $view->description = 'EML settings';
//     $view->tag = '';
//     $view->view_php = '';
//     $view->base_table = 'node';
//     $view->is_cacheable = FALSE;
//     $view->api_version = 2;
//     $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */
//     $handler = $view->new_display('default', 'Defaults', 'default');
//     $handler->override_option('fields', array(
//       'field_acronym_value' => array(
//         'label' => 'Acronym',
//         'alter' => array(
//           'alter_text' => 0,
//           'text' => '',
//           'make_link' => 0,
//           'path' => '',
//           'link_class' => '',
//           'alt' => '',
//           'prefix' => '',
//           'suffix' => '',
//           'target' => '',
//           'help' => '',
//           'trim' => 0,
//           'max_length' => '',
//           'word_boundary' => 1,
//           'ellipsis' => 1,
//           'html' => 0,
//           'strip_tags' => 0,
//         ),
//         'empty' => '',
//         'hide_empty' => 0,
//         'empty_zero' => 0,
//         'link_to_node' => 0,
//         'label_type' => 'widget',
//         'format' => 'default',
//         'multiple' => array(
//           'group' => TRUE,
//           'multiple_number' => '',
//           'multiple_from' => '',
//           'multiple_reversed' => FALSE,
//         ),
//         'exclude' => 0,
//         'id' => 'field_acronym_value',
//         'table' => 'node_data_field_acronym',
//         'field' => 'field_acronym_value',
//         'relationship' => 'none',
//       ),
//       'field_language_value' => array(
//         'label' => 'Language',
//         'alter' => array(
//           'alter_text' => 0,
//           'text' => '',
//           'make_link' => 0,
//           'path' => '',
//           'link_class' => '',
//           'alt' => '',
//           'prefix' => '',
//           'suffix' => '',
//           'target' => '',
//           'help' => '',
//           'trim' => 0,
//           'max_length' => '',
//           'word_boundary' => 1,
//           'ellipsis' => 1,
//           'html' => 0,
//           'strip_tags' => 0,
//         ),
//         'empty' => '',
//         'hide_empty' => 0,
//         'empty_zero' => 0,
//         'link_to_node' => 0,
//         'label_type' => 'widget',
//         'format' => 'default',
//         'multiple' => array(
//           'group' => TRUE,
//           'multiple_number' => '',
//           'multiple_from' => '',
//           'multiple_reversed' => FALSE,
//         ),
//         'exclude' => 0,
//         'id' => 'field_language_value',
//         'table' => 'node_data_field_language',
//         'field' => 'field_language_value',
//         'relationship' => 'none',
//       ),
//       'field_data_policies_value' => array(
//         'label' => 'Data Policies',
//         'alter' => array(
//           'alter_text' => 0,
//           'text' => '',
//           'make_link' => 0,
//           'path' => '',
//           'link_class' => '',
//           'alt' => '',
//           'prefix' => '',
//           'suffix' => '',
//           'target' => '',
//           'help' => '',
//           'trim' => 0,
//           'max_length' => '',
//           'word_boundary' => 1,
//           'ellipsis' => 1,
//           'html' => 0,
//           'strip_tags' => 0,
//         ),
//         'empty' => '',
//         'hide_empty' => 0,
//         'empty_zero' => 0,
//         'link_to_node' => 0,
//         'label_type' => 'widget',
//         'format' => 'default',
//         'multiple' => array(
//           'group' => TRUE,
//           'multiple_number' => '',
//           'multiple_from' => '',
//           'multiple_reversed' => FALSE,
//         ),
//         'exclude' => 0,
//         'id' => 'field_data_policies_value',
//         'table' => 'node_data_field_data_policies',
//         'field' => 'field_data_policies_value',
//         'relationship' => 'none',
//       ),
//       'field_intellectual_rights_value' => array(
//         'label' => 'Intellectual Rights',
//         'alter' => array(
//           'alter_text' => 0,
//           'text' => '',
//           'make_link' => 0,
//           'path' => '',
//           'link_class' => '',
//           'alt' => '',
//           'prefix' => '',
//           'suffix' => '',
//           'target' => '',
//           'help' => '',
//           'trim' => 0,
//           'max_length' => '',
//           'word_boundary' => 1,
//           'ellipsis' => 1,
//           'html' => 0,
//           'strip_tags' => 0,
//         ),
//         'empty' => '',
//         'hide_empty' => 0,
//         'empty_zero' => 0,
//         'link_to_node' => 0,
//         'label_type' => 'widget',
//         'format' => 'default',
//         'multiple' => array(
//           'group' => TRUE,
//           'multiple_number' => '',
//           'multiple_from' => '',
//           'multiple_reversed' => FALSE,
//         ),
//         'exclude' => 0,
//         'id' => 'field_intellectual_rights_value',
//         'table' => 'node_data_field_intellectual_rights',
//         'field' => 'field_intellectual_rights_value',
//         'relationship' => 'none',
//       ),
//       'field_metadata_provider_ref_nid' => array(
//         'label' => 'Metadata Provider',
//         'alter' => array(
//           'alter_text' => 0,
//           'text' => '',
//           'make_link' => 0,
//           'path' => '',
//           'link_class' => '',
//           'alt' => '',
//           'prefix' => '',
//           'suffix' => '',
//           'target' => '',
//           'help' => '',
//           'trim' => 0,
//           'max_length' => '',
//           'word_boundary' => 1,
//           'ellipsis' => 1,
//           'html' => 0,
//           'strip_tags' => 0,
//         ),
//         'empty' => '',
//         'hide_empty' => 0,
//         'empty_zero' => 0,
//         'link_to_node' => 0,
//         'label_type' => 'widget',
//         'format' => 'full',
//         'multiple' => array(
//           'group' => TRUE,
//           'multiple_number' => '',
//           'multiple_from' => '',
//           'multiple_reversed' => FALSE,
//         ),
//         'exclude' => 0,
//         'id' => 'field_metadata_provider_ref_nid',
//         'table' => 'node_data_field_metadata_provider_ref',
//         'field' => 'field_metadata_provider_ref_nid',
//         'relationship' => 'none',
//       ),
//       'field_publisher_ref_nid' => array(
//         'label' => 'Publisher',
//         'alter' => array(
//           'alter_text' => 0,
//           'text' => '',
//           'make_link' => 0,
//           'path' => '',
//           'link_class' => '',
//           'alt' => '',
//           'prefix' => '',
//           'suffix' => '',
//           'target' => '',
//           'help' => '',
//           'trim' => 0,
//           'max_length' => '',
//           'word_boundary' => 1,
//           'ellipsis' => 1,
//           'html' => 0,
//           'strip_tags' => 0,
//         ),
//         'empty' => '',
//         'hide_empty' => 0,
//         'empty_zero' => 0,
//         'link_to_node' => 0,
//         'label_type' => 'widget',
//         'format' => 'full',
//         'multiple' => array(
//           'group' => TRUE,
//           'multiple_number' => '',
//           'multiple_from' => '',
//           'multiple_reversed' => FALSE,
//         ),
//         'exclude' => 0,
//         'id' => 'field_publisher_ref_nid',
//         'table' => 'node_data_field_publisher_ref',
//         'field' => 'field_publisher_ref_nid',
//         'relationship' => 'none',
//       ),
//     ));
//     $handler->override_option('filters', array(
//       'type' => array(
//         'operator' => 'in',
//         'value' => array(
//           'eml_settings' => 'eml_settings',
//         ),
//         'group' => '0',
//         'exposed' => FALSE,
//         'expose' => array(
//           'operator' => FALSE,
//           'label' => '',
//         ),
//         'id' => 'type',
//         'table' => 'node',
//         'field' => 'type',
//         'relationship' => 'none',
//       ),
//     ));
//     $handler->override_option('access', array(
//       'type' => 'none',
//     ));
//     $handler->override_option('cache', array(
//       'type' => 'none',
//     ));
//     $handler = $view->new_display('page', 'Page', 'page_1');
//     $handler->override_option('path', 'eml_settings');
//     $handler->override_option('menu', array(
//       'type' => 'none',
//       'title' => '',
//       'description' => '',
//       'weight' => 0,
//       'name' => 'navigation',
//     ));
//     $handler->override_option('tab_options', array(
//       'type' => 'none',
//       'title' => '',
//       'description' => '',
//       'weight' => 0,
//       'name' => 'navigation',
//     ));    
//                         
//     // Add view to list of views to provide.
//     $views[$view->name] = $view;
//   
//     // At the end, return array of default views.
//     return $views;
//   }
// 
?>