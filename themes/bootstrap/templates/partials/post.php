<div class="row">
    <div class="span8 offset2">
      <article>
        <header>
          <h1>
            <a href="<?php echo $app->urlFor('single_post', array('url'=>$post->basename())); ?>">
              <?php echo $post->getTitle(); ?>
            </a>
          </h1>
          <p>
            <time datetime="<?php echo $post->getDate('c'); ?>" pubdate="pubdate">
              <?php echo $post->getDate('M, j, Y '); ?>
            </time>
            <?php if(count($post->getCategories())) { echo ' &mdash; ';} ?>
            <?php foreach($post->getCategories() as $category) { ?>
            <a class='category' href="<? echo $app->urlFor('category', array('name'=>$category)); ?>">
              <?php echo $category; ?>
            </a>
            <?php } ?>
          </p>
          </header>
        <div>
          <?php echo $post->getContentHTML(); ?>
        </div>
          <div class="g-plusone" data-size="small" data-width="198" data-annotation="inline" data-href="<?php echo $app->urlFor('single_post', array('url'=>$post->basename())); ?>"></div>
      </article>
      <hr />
    </div>

  </div>

