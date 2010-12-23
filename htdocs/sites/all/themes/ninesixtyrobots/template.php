<?php
// $Id: template.php,v 1.1.4.8 2009/08/12 23:26:02 add1sun Exp $

/**
 * Implmentation of hook_theme().
 */
function ninesixtyrobots_theme() {
  return array(
    // Add our own function to override the default node form for story.
    'story_node_form' => array(
      'variables' => array('form' => NULL),
    ),
  );
}

/**
 * Custom function to pull the Published check box out and make it obvious.
 */
function ninesixtyrobots_story_node_form($form) {
  $published = drupal_render($form['options']['status']);
  $buttons = drupal_render($form['buttons']);
  // Make sure we also render the rest of the form, not just our custom stuff.
  $everything_else = drupal_render($form);
  
  return $everything_else . $published . $buttons;  
}

/**
 * Add custom PHPTemplate variables into the node template.
 */
function ninesixtyrobots_preprocess_node(&$vars) {
  // Add the .post class to all nodes.
  $vars['classes_array'][] = 'post';

  // Grab the node object.
  $node = $vars['node'];
  // Make individual variables for the parts of the date.
  $vars['date_day'] = format_date($node->created, 'custom', 'j');
  $vars['date_month'] = format_date($node->created, 'custom', 'M');
  $vars['date_year'] = format_date($node->created, 'custom', 'Y');

  // Add an additional wrapper around the links.
  $vars['content']['links']['#prefix'] = '<div class="postinfo">';
  $vars['content']['links']['#suffix'] = '</div>';

  // Change the theme function used for rendering the list of tags.
  $vars['content']['field_tags']['#theme'] = 'links';
}

/**
 * Add custom PHPTemplate variable into the page template
 */
function ninesixtyrobots_preprocess_page(&$vars) {
  // Create a $footer_message variable.
  $vars['footer_message'] = t('Lullabot loves you.');

  // Check if the theme is using Twitter.
  $use_twitter = theme_get_setting('use_twitter');
  if (is_null($use_twitter)) {
    $use_twitter = 1;
  }

  // If the theme uses Twitter pull it in and display it in the slogan.
  if ($use_twitter) {
    if ($cache = cache_get('ninesixtyrobots_tweets')) {
      $data = $cache->data;
    }
    else {
      $query = theme_get_setting('twitter_search_term');
      if (is_null($query)) {
        $query = 'lullabot';
      }
      $query = drupal_encode_path($query);

      $response = drupal_http_request('http://search.twitter.com/search.json?q=' . $query);
      if ($response->code == 200) {
        $data = json_decode($response->data);
        // Set a 5 minute cache on retrieving tweets.
        // Note if this isn't updating on your site *run cron*.
        cache_set('ninesixtyrobots_tweets', $data, 'cache', 300);
      }
    }
    $tweet = $data->results[array_rand($data->results)];
    // Create the actual variable finally.
    $vars['site_slogan'] = check_plain(html_entity_decode($tweet->text));
  }
}

/**
 * Override the breadcrumb to allow for a theme delimiter setting.
 */
function ninesixtyrobots_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];

  if (!empty($breadcrumb)) {
    // Provide a navigational heading to give context for breadcrumb links to
    // screen-reader users. Make the heading invisible with .element-invisible.
    $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';

    $breadcrumb[] = drupal_get_title();
    $delimiter = theme_get_setting('breadcrumb_delimiter');
    if (is_null($delimiter)) {
      $delimiter = ' » ';
    }
    return '<div class="breadcrumb">'. implode($delimiter, $breadcrumb) .'</div>';
    return $output;
  }
}

/**
 * Preprocess function for theme_username().
 */
function ninesixtyrobots_preprocess_username(&$variables) {
  // Ensure that the full user object is loaded.
  $account = user_load($variables['account']->uid);

  // See if it has a real_name field and add that as the name instead.
  if (isset($account->field_profile_real_name[LANGUAGE_NONE][0]['safe_value'])) {
    $variables['name'] = $account->field_profile_real_name[LANGUAGE_NONE][0]['safe_value'];
  }
}

/**
 * Override the search box to add our pretty graphic instead of the button.
 */
function ninesixtyrobots_form_search_block_form_alter(&$form, &$form_state) {
  $form['actions']['submit']['#type'] = 'image_button';
  $form['actions']['submit']['#src'] = drupal_get_path('theme', 'ninesixtyrobots') . '/images/search.png';
  $form['actions']['submit']['#attributes']['class'][] = 'btn';
}