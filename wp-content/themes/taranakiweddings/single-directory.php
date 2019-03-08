<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2/8/2019
 * Time: 10:40 AM
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
get_header();
?>
    <div class="wrapper" id="page-wrapper">
        <div id="content" class="container">
            <div class="row">
                <div class="col-xl-12">
                    <main class="site-main" id="main">
                        <div class="page-title-wrapper">
                            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                            <?=breadcrumb()?>
                        </div>
                        <?php while ( have_posts() ) : the_post(); ?>
                            <?php get_template_part( 'loop-templates/content', 'directory' ); ?>
                        <?php endwhile; // end of the loop. ?>
                    </main><!-- #main -->
                </div>
            </div><!-- .row -->
        </div><!-- #content -->
    </div><!-- #page-wrapper -->
<?php get_footer(); ?>