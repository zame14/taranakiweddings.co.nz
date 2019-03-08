<?php
/**
 * The template for displaying all single posts.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header();
?>

<div class="wrapper" id="single-wrapper">

    <div class="container" id="content" tabindex="-1">

        <div class="row">

            <div class="col-xl-12">

                <main class="site-main" id="main">
                    <div class="page-title-wrapper">
                        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                        <?=breadcrumb()?>
                    </div>
                    <?php while ( have_posts() ) : the_post(); ?>

                        <?php get_template_part( 'loop-templates/content', 'single' ); ?>

                        <?php understrap_post_nav(); ?>

                        <?php
                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;
                        ?>

                    <?php endwhile; // end of the loop. ?>

                </main><!-- #main -->

            </div>

        </div><!-- .row -->

    </div><!-- #content -->

</div><!-- #single-wrapper -->

<?php get_footer(); ?>