<?php

?>
<div class="blog-panel-wrapper">
    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
        <div class="row">
            <div class="col-12 col-md-5 blog-image-wrapper">
                <?=get_the_post_thumbnail( $post->ID, 'feature' )?>
            </div>
            <div class="col-12 col-md-7 blog-content-wrapper">
                <a href="<?=get_permalink()?>" class="title"><?=the_title()?></a>
                <?=the_excerpt()?>
            </div>
        </div>
    </article>
</div>
