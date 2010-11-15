<?php
// $Id: views_bonus_eml_plugin_style_export_eml.inc, v 1.0 9/23/10 11:29 AM ashipunova Exp $
// from: views_bonus_plugin_style_export.inc,v 1.1 2010/01/07 22:56:47 neclimdul Exp $
/**
 * @file
 * Plugin include file for export style plugin.
 */

/**
 * Generalized style plugin for export plugins.
 *
 * @ingroup views_style_plugins
 */
class views_bonus_eml_plugin_style_export_eml extends views_bonus_eml_plugin_style_export {
  var $feed_text = 'EML';
  var $feed_file = 'view-%view.eml';

  /**
   * Initialize plugin.
   *
   * Set feed image for shared rendering later.
   */
  function init(&$view, &$display, $options = NULL) {
    parent::init($view, $display, $options = NULL);
    $this->feed_image = drupal_get_path('module', 'views_bonus_eml_export') . '/images/eml.png';
  }
}
