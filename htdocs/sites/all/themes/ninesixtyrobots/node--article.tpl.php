<?php
// $Id: node-story.tpl.php,v 1.1 2009/05/22 15:17:31 jjeff Exp $
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <?php print $user_picture; ?>

  <?php print render($title_prefix); ?>
  <?php if (!$page): ?>
    <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
  <?php endif; ?>
  <?php print render($title_suffix); ?>

  <div class="meta post-info">
  <?php if ($display_submitted): ?>
    <span class="submitted">
      Posted by: <?php print $submitted; ?>
    </span>
  <?php endif; ?>

  <?php if ($content['field_tags']): ?>
    | Filed under: <span class="terms terms-inline"><?php print render($content['field_tags']); ?></span>
  <?php endif;?>

  </div>

  <div class="content"<?php print $content_attributes; ?>>
    <div class="dateblock">
      <span class="month"><?php print $date_month ?></span>
      <span class="day"><?php print $date_day ?></span>
      <span class="year"><?php print $date_year ?></span>
    </div>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
      print render($content);
    ?>
  </div>

  <?php $links = render($content['links']); ?>
  <?php if ($links): ?>
    <div class="postmeta"><?php print $links; ?></div>
  <?php endif; ?>

  <?php print render($content['comments']); ?>

</div>