<?php
// $Id: theme-settings.php,v 1.1.4.2 2009/08/12 23:29:56 add1sun Exp $

/**
 * Implements hook_form_FORM_ID_alter().
 */
function ninesixtyrobots_form_system_theme_settings_alter(&$form, $form_state) {
  $defaults = array(
    'breadcrumb_delimiter' => ' » ',
    'use_twitter' => 1,
    'twitter_search_term' => 'lullabot',
  );
  $settings = array_merge($defaults, $saved_settings);
  
  $form['breadcrumb_delimiter'] = array(
    '#type' => 'textfield',
    '#title' => t('Breadcrumb delimiter'),
    '#size' => 4,
    '#default_value' => theme_get_setting('breadcrumb_delimiter'),
    '#description' => t("Don't forget spaces at either end... if you're into that sort of thing."),
  );
  $form['use_twitter'] = array(
    '#type' => 'checkbox',
    '#title' => t('Use Twitter for site slogan'),
    '#default_value' => theme_get_setting('use_twitter'),
    '#description' => t("Choose a random status update using the search term below."),
  );
  $form['twitter_search_term'] = array(
    '#type' => 'textfield',
    '#title' => t('Twitter search term'),
    '#default_value' => theme_get_setting('twitter_search_term'),
    '#description' => t("Pull a random tweet from search.twitter.com using this search query."),
  );
}