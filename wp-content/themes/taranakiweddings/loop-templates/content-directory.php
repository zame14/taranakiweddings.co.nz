<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2/8/2019
 * Time: 10:37 AM
 */
$directory = new DirectoryListing($post);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <!-- .entry-header -->
    <div class="entry-content">
        <?=$directory->getContent()?>
        <?=do_shortcode('[wpv-view name="search-vendors"]')?>
    </div><!-- .entry-content -->
</article><!-- #post-## -->
