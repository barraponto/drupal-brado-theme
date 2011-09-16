<?php

function brado_preprocess_node(&$vars) {
  $vars['content']['field_foto']['#prefix'] = '<div class="fotos-e-fatos">';
  $vars['content']['field_fatos']['#suffix'] = '</div>';
}

function brado_preprocess_page(&$vars) {
  $vars['breadcrumb'] = FALSE;
  $vars['primary_local_tasks'] = FALSE;
  $vars['secondary_local_tasks'] = FALSE;
  drupal_add_css('http://fonts.googleapis.com/css?family=Hammersmith+One', 'external');
}

function brado_process_page(&$vars) {
  if ($vars['is_front']) {
    $vars['title'] = NULL;
  }
  if (isset($vars['node']) && node_access('update',$vars['node'])) {
    $vars['title_suffix'] = l('Editar', 'node/' . $vars['node']->nid . '/edit');
  }
}

function brado_form_search_block_form_alter(&$form, &$form_state) {
  $form['search_block_form']['#attributes']['placeholder'] = 'Pesquisa';
  $form['search_block_form']['#size'] = 25;
}

function brado_field__field_banner($variables) {
  $output = '';

  // Render the label, if it's not hidden.
  if (!$variables['label_hidden']) {
    $output .= '<div class="field-label"' . $variables['title_attributes'] . '>' . $variables['label'] . ':&nbsp;</div>';
  }

  // Render the items.
  $output .= '<div class="field-items"' . $variables['content_attributes'] . '>';
  foreach ($variables['items'] as $delta => $item) {
    $classes = 'field-item ' . ($delta % 2 ? 'odd' : 'even');
    // Get the copyright attribution from the image title
    $attribution = $item['#item']['title'];
    // Unset the title
    $item['#item']['title'] = FALSE;
    // Wrap the copyright in markup and put it in the output
    $copyright = '<p class="copyright">' . $attribution . '</p>';
    $output .= '<div class="' . $classes . '"' . $variables['item_attributes'][$delta] . '>' . drupal_render($item) . $copyright  . '</div>';
  }
  $output .= '</div>';


  // Render the top-level DIV.
  $output = '<div class="' . $variables['classes'] . '"' . $variables['attributes'] . '>' . $output . '</div>';

  return $output;
}
