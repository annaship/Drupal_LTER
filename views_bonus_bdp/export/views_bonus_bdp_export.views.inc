<?php
// $Id: views_bonus_bdp_export.views.inc, v 1.0 9/23/10 11:29 AM ashipunova Exp $
// from: views_bonus_export.views.inc,v 1.9 2010/01/08 20:55:21 neclimdul Exp $
/**
 * @file
 * Views include file with views hooks.
 */

/**
 * Implementation of hook_views_plugins().
 */
function views_bonus_bdp_export_views_plugins() {
  $path = drupal_get_path('module', 'views_bonus_bdp_export');
  return array(
    'style' => array(
      'views_bonus_bdp_export' => array(
        // this isn't really a display but is necessary so the file can
        // be included.
        'no ui' => TRUE,
        'handler' => 'views_bonus_bdp_plugin_style_export',
        'path' => $path,
      ),
      'views_bdp' => array(
        'title' => t('BDP file'),
        'help' => t('Display the view as a bdp file.'),
        'path' => $path,
        'handler' => 'views_bonus_bdp_plugin_style_export_bdp',
        'parent' => 'views_bonus_bdp_export',
        'theme' => 'views_bonus_bdp_export_bdp',
        'theme file' => 'views_bonus_bdp_export.theme.inc',
        'uses row plugin' => FALSE,
        'uses fields' => TRUE,
        'uses options' => TRUE,
        'type' => 'feed',
        'export headers' => array('Content-Type: text/xml'),
        'export feed type' => 'bdp',
      ),
    ),
  );
}
