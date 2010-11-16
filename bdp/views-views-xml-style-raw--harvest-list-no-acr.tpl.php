<?php
// $Id: views-views-xml-style-raw--harvest-list-no-acr.tpl.php,v 1.1.2.6 2010/06/07 03:27:07 allisterbeharry Exp $
/**
 * @file views-views-xml-style-raw--harvest-list-no-acr.tpl.php
 * Template for the Views XML style plugin using the raw schema + BDP
 *
 * Variables  
 * - $variables (see list of all variables from "print print_r(array_keys(get_defined_vars()), 1);")
 * - $view: The View object.
 * - $rows: Array of row objects as rendered by _views_xml_render_fields 
 *
 * @ingroup views_templates
 * @see views_views_xml_style--xml-test1.theme.inc
 */	         

//  this is the changed function template_preprocess_views_views_xml_style_raw from views_views_xml_style.theme.inc  

	$view = $variables["view"];
  $rows = $variables["rows"];
  $options = $variables["options"];  
  $base = $view->base_table;
  $root = $options['root_element'];
  $endroot = preg_replace("/\s+.*/", "", $root);
  $top_child_object = $options["top_child_object"];
  $end_top_child_object = preg_replace("/\s+.*/", "", $top_child_object);    
  $plaintext_output = $options["plaintext_output"];
  $content_type = ($options['content_type'] == 'default') ? 'text/xml' : $options['content_type'];
  $header = $options['header'];
  $xml =  "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
  if ($header) $xml.= $header."\n"; 
	$xml .= "<$root>\n";
  foreach($rows as $row) {
		$xml .= ($options['element_output'] == 'nested') ? "  <$top_child_object>\n": "  <$top_child_object\n";
	  foreach($row as $id => $object) {
		  if ($options['field_output'] == 'normal')  {
		    if ($object->label) 
		      $label = _views_xml_strip_illegal_xml_name_chars(check_plain(html_entity_decode(strip_tags($object->label))));
		    else  $label = _views_xml_strip_illegal_xml_name_chars(check_plain(html_entity_decode((strip_tags($id)))));
		    if (!$object->is_multiple) 
		      $content = ($plaintext_output ? check_plain(html_entity_decode(strip_tags($object->content))) : _views_xml_xmlEntities($object->content));
		    else {
		    	$content = array ();		   
		    	foreach($object->content as $n=>$oc) {
		    		$content[$n] = ($plaintext_output ? check_plain(html_entity_decode(strip_tags($oc))) : _views_xml_xmlEntities($oc));		    		
		    	}
		    }		    
		  }
		  elseif ($options['field_output'] == 'raw') {
		   $label = _views_xml_strip_illegal_xml_name_chars(check_plain(html_entity_decode(strip_tags($id))));
		   if (!$object->is_multiple) 
		      $content = ($plaintext_output ? check_plain(html_entity_decode(strip_tags($object->raw))) : _views_xml_xmlEntities($object->raw));
		    else {
		    	foreach($object->raw as $n=>$oc) $content[$n] = ($plaintext_output ? check_plain(html_entity_decode(strip_tags($oc))) : _views_xml_xmlEntities($oc));
		    }
		  }
		  $endlabel = preg_replace("/\s+.*/", "", $label);
		  if ($options['element_output'] == 'nested') {		  	
			  if (!is_array($content)) {                                                                                                       
			    if ($label == 'scope') {
			      $xml .= "    <docid>\n  ";
			    }       
			    elseif ($label == 'documentType') {
  			    $xml .= "    </docid>\n";
  			  }       
			    if ($label == 'identifier') {
			      $xml .= "  ";
			    }       
			    if ($label == 'revision') {
			      $xml .= "  ";
			    }       
			  	$xml .= "    <$label>".(($options['escape_as_CDATA'] == 'yes') ? "<![CDATA[$content]]>": $content)."</$endlabel>\n";           
			  	//_views_xml_debug_stop($xml);
			  }
			  else {
			  	foreach ($content as $c) {
		  	    $xml .= "    <$label>";
			      $xml .= "".(($options['escape_as_CDATA'] == 'yes') ? "<![CDATA[$c]]>": $c."");
			      $xml .= "</$endlabel>\n";			  		
			  	}			  	
			  }
		  }
		  elseif($options['element_output'] == 'attributes') {
		  	if (!is_array($content)) {
          $content = _views_xml_strip_illegal_xml_attribute_value_chars($content);
		      $xml .= " $label=\"$content\" ";
		  	}
		  	else {
			  	foreach ($content as $n=>$c) {         
            $c = _views_xml_strip_illegal_xml_attribute_value_chars($c);
            $label = _views_xml_strip_illegal_xml_name_chars($label);
		        $xml .= " $label$n=\"$c\" ";
			  	}			  			  		
		  	}
		  }
	  }

	  $xml .= ($options['element_output'] == 'nested') ? "  </$end_top_child_object>\n": "/>\n";
	}
	$xml .= "</$endroot>\n";
	$variables["xml"] = $xml;

// thsi is what actually should be in this file
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
      
