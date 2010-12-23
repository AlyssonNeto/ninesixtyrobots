<?php
// $Id: node.tpl.php,v 1.1 2009/05/22 15:17:31 jjeff Exp $
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
    <div class="submitted">
      <?php print $submitted; ?>
    </div>
  <?php endif; ?>

  <?php if ($content['field_tags']): ?>
    <div class="terms terms-inline"><?php print render($content['field_tags']); ?></div>
  <?php endif;?>

  </div>

  <div class="content"<?php print $content_attributes; ?>>
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