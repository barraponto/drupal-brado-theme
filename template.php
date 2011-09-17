<?php

function brado_preprocess_field(&$variables, $hook) {
  if($variables['element']['#field_name'] == 'field_tags') {
    $clearfix = array_search('clearfix', $variables['classes_array']);
    if ($clearfix) {
      unset($variables['classes_array'][$clearfix]);
    }
  }
}

function brado_preprocess_node(&$vars) {
  if ($vars['type'] == 'personagem' && $vars['view_mode'] == 'full') {
    $vars['content']['field_foto']['#prefix'] = '<div class="fotos-e-fatos">';
    $vars['content']['field_fatos']['#suffix'] = '</div>';
  }
  if ($vars['is_front'] && isset($vars['content']['field_tags'])) {
    hide($vars['content']['field_tags']);
  }
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

function brado_pager($vars) {
  $tags = $vars['tags'];
  $element = $vars['element'];
  $parameters = $vars['parameters'];
  $quantity = $vars['quantity'];
  $pager_list = theme('pager_list', $vars);

  $links = array();
  $links['pager-first'] = theme('pager_first', array(
    'text' => (isset($tags[0]) ? $tags[0] : t('<<')),
    'element' => $element,
    'parameters' => $parameters
  ));
  $links['pager-previous'] = theme('pager_previous', array(
    'text' => (isset($tags[1]) ? $tags[1] : t('<')),
    'element' => $element,
    'interval' => 1,
    'parameters' => $parameters
  ));
  $links['pager-next'] = theme('pager_next', array(
    'text' => (isset($tags[3]) ? $tags[3] : t('>')),
    'element' => $element,
    'interval' => 1,
    'parameters' => $parameters
  ));
  $links['pager-last'] = theme('pager_last', array(
    'text' => (isset($tags[4]) ? $tags[4] : t('>>')),
    'element' => $element,
    'parameters' => $parameters
  ));
  $links = array_filter($links);
  $pager_links = theme('links', array(
    'links' => $links,
    'attributes' => array('class' => 'links pager pager-links')
  ));
    return "<div class='pager clearfix'>$pager_links</div>";
}
