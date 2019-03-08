<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>
<section id="footer">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 sm-no-padding">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'footer-menu',
                        'fallback_cb' => '',
                        'menu_id' => 'footer-menu'
                    )
                );
                ?>
            </div>
            <div class="col-xl-12"><?=socialMediaMenu()?></div>
        </div>
        <div class="row copyright">
            <div class="col-12 col-lg-6 col-left">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'secondary-footer-menu',
                        'fallback_cb' => '',
                        'menu_id' => 'secondary-footer-menu'
                    )
                );
                ?>
            </div>
            <div class="col-12 col-lg-6 col-right">
                <ul>
                    <li>Copyright <?=date('Y')?> GNL Consulting Group Limited</li>
                    <li>Website by <a href="http://tgmcreative.co.nz/" target="_blank">tgm</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
</div><!-- #page we need this extra closing tag here -->
<?php wp_footer(); ?>
</body>
</html>

