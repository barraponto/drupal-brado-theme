<?php

function brado_preprocess_page(&$vars) {
  $vars['breadcrumb'] = FALSE;
  $vars['primary_local_tasks'] = FALSE;
  $vars['secondary_local_tasks'] = FALSE;
  drupal_add_css('http://fonts.googleapis.com/css?family=Hammersmith+One', 'external');
}

function brado_form_search_block_form_alter(&$form, &$form_state) {
  $form['search_block_form']['#attributes']['placeholder'] = 'Pesquisa';
  $form['search_block_form']['#size'] = 25;
}
