<?php
// $Id: views-views-xml-style-raw--xml-test1.tpl.php,v 1.1.2.6 2010/06/07 03:27:07 allisterbeharry Exp $
/**
 * @file views-views-xml-style-raw--xml-test1.tpl.php
 * Template for the Views XML style plugin using the raw schema
 *
 * Variables
 * - $view: The View object.
 * - $rows: Array of row objects as rendered by _views_xml_render_fields 
 *
 * @ingroup views_templates
 * @see views_views_xml_style--xml-test1.theme.inc
 */	         

  $string = $xml;
  $pattern = '/(<scope>)/i';
  $replacement = "<docid>\n      $1";

  $string = preg_replace($pattern, $replacement, $string);
  $pattern = '/(<documentType>)/i';
  $replacement = "</docid>\n    $1";

  $string = preg_replace($pattern, $replacement, $string);
  $pattern = '/(<identifier>)/i';
  $replacement = "  $1";

  $string = preg_replace($pattern, $replacement, $string);
  $pattern = '/(<revision>)/i';
  $replacement = "  $1";
  $xml = preg_replace($pattern, $replacement, $string);

  if ($view->override_path) {       // inside live preview
      print htmlspecialchars($xml);
    }
    else if ($options['using_views_api_mode']) {     // We're in Views API mode.
      print $xml;
    }
    else {
      drupal_set_header("Content-Type: $content_type; charset=utf-8");
      print $xml;   
      exit;
    }
      
