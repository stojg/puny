<?php require 'partials/header.php'; ?>
  <?php if(is_array($posts)) { foreach($posts as $post) { ?>
  <?php require 'partials/post.php'; ?>
  <?php }} ?>
<?php require 'partials/footer.php'; ?>