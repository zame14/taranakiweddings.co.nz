<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<section class="site" id="page">
    <section id="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 m-no-padding">
                    <div class="logo-wrapper">
                        <?=the_custom_logo()?>
                    </div>
                    <div id="tw-menu-wrapper">
                        <div class="main-nav wrapper-fluid wrapper-navbar" id="wrapper-navbar">
                            <nav class="site-navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
                                <?php
                                wp_nav_menu(
                                    array(
                                        'theme_location' => 'primary',
                                        'container_class' => 'collapse navbar-collapse navbar-responsive-collapse',
                                        'menu_class' => 'nav navbar-nav',
                                        'fallback_cb' => '',
                                        'menu_id' => 'main-menu'
                                    )
                                );
                                ?>
                            </nav>
                        </div>
                    </div>
                    <?=userLogin()?>
                </div>
            </div>
        </div>
    </section>
