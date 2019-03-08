<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package understrap
 */
if(get_the_ID() == 107) {
    // login page
    if(isset($_REQUEST['cred_referrer_form_id'])) {
        echo '<p>Thank you for registering with Taranaki Weddings.  Please login below using your username and password you created.</p>';
    } elseif(isset($_REQUEST['listing']) && $_REQUEST['listing'] == "add") {
        echo '<p>Please login first to add a listing to your shortlist.</p>';
    }
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <!-- .entry-header -->
    <div class="entry-content">
        <?php the_content(); ?>
    </div><!-- .entry-content -->
</article><!-- #post-## -->