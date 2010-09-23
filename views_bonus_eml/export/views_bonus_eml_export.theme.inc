<?php
// $Id: views_bonus_eml_export.theme.inc, v 1.0 9/23/10 11:29 AM ashipunova Exp $
// from: views_bonus_export.theme.inc,v 1.8 2010/06/16 14:47:51 neclimdul Exp $
/**
 * @file
 * Theme related functions for processing our output style plugins.
 *
 * Views bug: http://drupal.org/node/593336
 */

/**
 * Preprocess eml output template.
 */
// function template_preprocess_views_bonus_eml_export_eml(&$vars) {
  // _views_bonus_eml_export_shared_preprocess($vars);
// }
function template_preprocess_views_bonus_eml_export_eml(&$vars) {
  _views_bonus_eml_export_shared_preprocess($vars);

  foreach ($vars['themed_rows'] as $num => $row) {
    foreach ($row as $field => $content) {
      // Prevent double encoding of the ampersand. Look for the entities produced by check_plain().
      $content = preg_replace('/&(?!(amp|quot|#039|lt|gt);)/', '&amp;', $content);
      // Convert < and > to HTML entities.
      $content = str_replace(
        array('<', '>'),
        array('&lt;', '&gt;'),
        $content);
      $vars['themed_rows'][$num][$field] = $content;
    }
  }
}
