<?php
require_once('modal/class.Base.php');
require_once('modal/class.Vendor.php');
require_once('modal/class.Directory.php');
require_once('modal/class.Shortlist.php');
require_once('modal/class.Event.php');
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
require_once(STYLESHEETPATH . '/includes/wordpress-tweaks.php');
// Load custom visual composer templates
loadVCTemplates();
add_action( 'wp_enqueue_scripts', 'p_enqueue_styles');
function p_enqueue_styles() {
    wp_enqueue_style( 'bootstrap-css', get_stylesheet_directory_uri() . '/css/bootstrap.min.css?' . filemtime(get_stylesheet_directory() . '/css/bootstrap.min.css'));
    wp_enqueue_style( 'font-awesome', get_stylesheet_directory_uri() . '/css/font-awesome.min.css?' . filemtime(get_stylesheet_directory() . '/css/font-awesome.css'));
    wp_enqueue_style( 'google_fonts', 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600|Great+Vibes|Source+Serif+Pro:400,600');
    wp_enqueue_style( 'slick', get_stylesheet_directory_uri() . '/slick-carousel/slick/slick.css');
    wp_enqueue_style( 'understrap-theme', get_stylesheet_directory_uri() . '/style.css?' . filemtime(get_stylesheet_directory() . '/style.css'));
    wp_enqueue_script('bootstrap-js', get_stylesheet_directory_uri() . '/js/bootstrap.min.js?' . filemtime(get_stylesheet_directory() . '/js/bootstrap.min.js'), array('jquery'));
    wp_enqueue_script( 'waypoint', get_stylesheet_directory_uri() . '/js/noframework.waypoints.min.js');
    wp_enqueue_script( 'slick', get_stylesheet_directory_uri() . '/slick-carousel/slick/slick.js');
    wp_enqueue_script('understap-theme', get_stylesheet_directory_uri() . '/js/theme.js?' . filemtime(get_stylesheet_directory() . '/js/theme.js'), array('jquery'));

}
function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

add_image_size( 'banner', 2000 );
add_image_size( 'feature', 600, 600, true );
add_image_size( 'single-gallery', 900, 600, true );
add_image_size( 'slider-gallery', '', 500, false );
add_image_size( 'full-blog', 1200, 800, true );

add_action('init', 'bfe_register_menus');
function bfe_register_menus() {
    register_nav_menus(
        Array(
            'footer-menu' => __('Footer Menu'),
            'secondary-footer-menu' => __('Secondary Footer Menu')
        )
    );
}
add_action('admin_init', 'my_general_section');
function my_general_section() {
    add_settings_section(
        'my_settings_section', // Section ID
        'Custom Website Settings', // Section Title
        'my_section_options_callback', // Callback
        'general' // What Page?  This makes the section show up on the General Settings Page
    );
    add_settings_field( // Option 2
        'email', // Option ID
        'Email', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed
        'my_settings_section', // Name of our section (General Settings)
        array( // The $args
            'email' // Should match Option ID
        )
    );
    add_settings_field( // Option 2
        'facebook', // Option ID
        'Facebook Link', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed
        'my_settings_section', // Name of our section (General Settings)
        array( // The $args
            'facebook' // Should match Option ID
        )
    );

    add_settings_field( // Option 2
        'instagram', // Option ID
        'Instagram Link', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed
        'my_settings_section', // Name of our section (General Settings)
        array( // The $args
            'instagram' // Should match Option ID
        )
    );

    add_settings_field( // Option 2
        'twitter', // Option ID
        'Twitter Link', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed
        'my_settings_section', // Name of our section (General Settings)
        array( // The $args
            'twitter' // Should match Option ID
        )
    );
    register_setting('general','email', 'esc_attr');
    register_setting('general','facebook', 'esc_attr');
    register_setting('general','instagram', 'esc_attr');
    register_setting('general','twitter', 'esc_attr');
}

function my_section_options_callback() { // Section Callback
    echo '';
}

function my_textbox_callback($args) {  // Textbox Callback
    $option = get_option($args[0]);
    echo '<input type="text" id="'. $args[0] .'" name="'. $args[0] .'" value="' . $option . '" />';
}
function socialMediaMenu() {
    $html = '
    <ul class="social-media">
        <li><a href="mailto:' . get_option('email') . '" class="btn btn-primary">Contact</a></li>';
    if(get_option('facebook')) {
        $html .= '<li><a href="' . get_option('facebook') . '" target="_blank" class="sm-button"><span class="fa fa-facebook"></span></a>';
    }
    if(get_option('twitter')) {
        $html .= '<li><a href="' . get_option('twitter') . '" target="_blank" class="sm-button"><span class="fa fa-twitter"></span></a>';
    }
    if(get_option('instagram')) {
        $html .= '<li><a href="' . get_option('instagram') . '" target="_blank" class="sm-button"><span class="fa fa-instagram"></span></a>';
    }
    $html .= '</ul>';

    return $html;
}
function breadcrumb($post_type = '') {
    global $post;
    $this_page = get_the_title($post->ID);
    ($post_type == '') ? $post_type = get_post_type($post->ID) : $post_type = 'blog';
    if($post_type == 'blog') {
        $this_page = 'Blog';
    }
    $html = '
    <div class="breadcrumb">
        <ul>
            <li><a href="' . get_page_link(19) . '">Home</a></li>';
            if($post_type == "directory") {
                $html .= '<li><a href="' . get_page_link(21) . '">Directory</a></li>';
            } elseif($post_type == "vendor") {
                $html .= '<li><a href="' . get_page_link(21) . '">Directory</a></li>';
                // get category
                $vendor = new Vendor($post->ID);
                $directory = $vendor->getCategory();
                $html .= '<li><a href="' . $directory->link() . '">' . $directory->getTitle() . '</a></li>';
            } elseif($post_type == "post") {

                $html .= '<li><a href="' . get_page_link(22) . '">Blog</a></li>';
            }
            $html .= '
            <li>' . $this_page . '</li>
        </ul>
    </div>';

    return $html;
}
function getImageID($image_url)
{
    global $wpdb;
    $sql = 'SELECT ID FROM ' . $wpdb->prefix . 'posts WHERE guid = "' . $image_url . '"';
    $result = $wpdb->get_results($sql);

    return $result[0]->ID;
}
function formatPhoneNumber($ph) {
    $ph = str_replace('(', '', $ph);
    $ph = str_replace(')', '', $ph);
    $ph = str_replace(' ', '', $ph);
    $ph = str_replace('+64', '0', $ph);

    return $ph;
}
function getShortlist($userid) {
    $shortlist_items = Array();
    $posts_array = get_posts([
        'post_type' => 'list',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby' => 'Title',
        'order' => 'ASC',
        'meta_query' => [
            [
                'key' => 'wpcf-shortlist-user-id',
                'value' => $userid,
            ]
        ]
    ]);
    foreach ($posts_array as $post) {
        $shortlist = new Shortlist($post);
        $shortlist_items[] = $shortlist;
    }
    return $shortlist_items;
}
function getShortlistByVendor($userid, $vendorid) {
    $shortlists = array();
    $posts_array = get_posts([
        'post_type' => 'list',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby' => 'Title',
        'order' => 'ASC',
        'meta_query' => [
            [
                'key' => 'wpcf-shortlist-user-id',
                'value' => $userid,
            ],
            [
                'key' => 'wpcf-shortlist-vendor-id',
                'value' => $vendorid,
            ]
        ]
    ]);
    foreach ($posts_array as $post) {
        $shortlist = new Shortlist($post);
        $shortlists[] = $shortlist;
    }
    return $shortlists;
}
function getEvents() {
    $events = Array();
    $posts_array = get_posts([
        'post_type' => 'event',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby' => 'ID',
        'order' => 'ASC'
    ]);
    foreach ($posts_array as $post) {
        $event = new Event($post);
        $events[] = $event;
    }
    return $events;
}
function getCategories() {
    $categories = Array();
    $posts_array = get_posts([
        'post_type' => 'directory',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    ]);
    foreach ($posts_array as $post) {
        $category = new DirectoryListing($post);
        $categories[] = $category;
    }
    return $categories;
}
function userLogin() {
    $html = '<div class="login">';
    if(is_user_logged_in()) {
        // check if user has listings added to their shortlist.
        $user = wp_get_current_user();
        $my_shortlist = count(getShortlist($user->id));
        if($my_shortlist > 0) {
            $html .= '<a href="' . wp_logout_url('/') . '" class="login-link">Logout</a><a href="' . get_page_link(133) . '" class="shortlist-link"><span class="fa fa-heart"></span><i>' . $my_shortlist . '</i></a>';
        } else {
            $html .= '<a href="' . wp_logout_url('/') . '" class="login-link">Logout</a><a href="javascript:;" class="shortlist-link"><span class="fa fa-heart-o"></span></a>';
        }
    } else {
        $html .= '<a href="' . get_page_link(107) . '" class="login-link">Login<span class="fa fa-heart-o"></span></a>';
    }
    $html .= '</div>';
    return $html;
}
/*
function likeButton($listingid) {
    $html = '';
    if(is_user_logged_in()) {
        // check if user has added this listing to their shortlist.
        $added_to_shortlist = false;
        $user = wp_get_current_user();
        foreach (getShortlist($user->id) as $shortlist) {
            if($shortlist->getVendor() == $listingid) {
                $added_to_shortlist = true;
                break;
            }
        }
        if($added_to_shortlist) {
            $html .= '<a href="javascript:;" onclick="removeListing(' . $listingid . ')"><span class="fa fa-heart"></span></a>';
        } else {
            $html .= '<a href="javascript:;" onclick="addListing(' . $listingid . ')"><span class="fa fa-heart-o"></span></a>';
        }

    } else {
        // user is not logged in.  Display empty heart and link to login page.
        $html .= '<a href="' . get_page_link(107) . '?listing=add"><span class="fa fa-heart-o"></span></a>';
    }

    return $html;
}
*/
function events_shortcode() {
    $i = 1;
    $html = '';
    foreach(getEvents() as $event) {
        if($i % 2 == 0) {
            // even
            $html .= '
            <div class="row event-wrapper align-items-center">
                <div class="col-12 col-sm-6 col-md-7">
                    <h3>' . $event->getTitle() . '</h3>
                    ' . $event->getContent() . '
                    ' . $event->getButton() . '
                </div>
                <div class="col-12 col-sm-6 col-md-5 image-wrapper1">
                    <img src="' . $event->getFeatureImage() . '" alt="" />
                </div>
            </div>';
        } else {
            //odd
            $html .= '
            <div class="row event-wrapper align-items-center">
                <div class="col-12 col-sm-6 col-md-5 image-wrapper2">
                    <img src="' . $event->getFeatureImage() . '" alt="" />
                </div>
                <div class="col-12 col-sm-6 col-md-7">
                    <h3>' . $event->getTitle() . '</h3>
                    ' . $event->getContent() . '
                    ' . $event->getButton() . '
                </div>
            </div>';
        }
        $i++;
    }

    return $html;
}
add_shortcode('events', 'events_shortcode');

function createListLink_shortcode() {
    // check if user logged in.  If logged in send them straigh to directory page.
    $id = 107;
    if(is_user_logged_in()) {
        $id = 21;
    }
    $html = '<a href="' . get_page_link($id) . '" class="btn btn-primary">Create your list</a>';

    return $html;
}
add_shortcode('create_list_link', 'createListLink_shortcode');

function likeButton_shortcode($atts) {
    $listingid = $atts['listingid'];
    $html = '';
    if(is_user_logged_in()) {
        // check if user has added this listing to their shortlist.
        $added_to_shortlist = false;
        $user = wp_get_current_user();
        foreach (getShortlist($user->id) as $shortlist) {
            if($shortlist->getVendor() == $listingid) {
                $added_to_shortlist = true;
                break;
            }
        }
        if($added_to_shortlist) {
            $html .= '<a href="javascript:;" onclick="removeListing(' . $listingid . ')"><span class="fa fa-heart"></span></a>';
        } else {
            $html .= '<a href="javascript:;" onclick="addListing(' . $listingid . ')"><span class="fa fa-heart-o"></span></a>';
        }

    } else {
        // user is not logged in.  Display empty heart and link to login page.
        $html .= '<a href="' . get_page_link(107) . '?listing=add"><span class="fa fa-heart-o"></span></a>';
    }

    return $html;
}
add_shortcode('like-button', 'likeButton_shortcode');

function awardWinner_shortcode($atts) {
    $html = '';
    $listingid = $atts['listingid'];
    // check if this listing is an award winner
    $vendor = new Vendor($listingid);
    if($vendor->hasAward()) {
        $html = '<img src="' . $vendor->getIndustryAwardLogo() . '" alt="" />';
    }

    return $html;
}
add_shortcode('award-winner', 'awardWinner_shortcode');

function blogGallerySmall_shortcode($atts) {
    $postid = $atts['postid'];
    $images = get_post_meta($postid, 'wpcf-blog-gallery-images');
    $html = '<ul>';
    foreach($images as $image) {
        $imageid = getImageID($image);
        $img = wp_get_attachment_image_src($imageid, 'feature');
        $html .= '<li><img src="' . $img[0] . '" alt="" /></li>';
    }
    $html .= '</ul>';

    return $html;
}
add_shortcode('blog-gallery-small', 'blogGallerySmall_shortcode');

function blogGalleryLarge_shortcode($atts) {
    $postid = $atts['postid'];
    $images = get_post_meta($postid, 'wpcf-blog-gallery-images');
    $html = '<div class="blog-large-image-wrapper">';
    foreach($images as $image) {
        $imageid = getImageID($image);
        $img = wp_get_attachment_image_src($imageid, 'full-blog');
        $html .= '<div><img src="' . $img[0] . '" alt="" /></div>';
    }
    $html .= '</div>';

    return $html;
}
add_shortcode('blog-gallery-large', 'blogGalleryLarge_shortcode');


function shortlist_shortcode() {
    $html = '';
    if(is_user_logged_in()) {
        $html = '<div class="row justify-content-center my-list-wrapper">';
        // user is logged in
        $user = wp_get_current_user();
        $my_list = getShortlist($user->id);
        if(count($my_list) > 0) {
            do_shortcode('[getShortlistFrom]');
            do_shortcode('[getShortlistTo]');
            // user has items in their list
            foreach($my_list as $shortlist) {
                $vendor = new Vendor($shortlist->getVendor());
                $imageid = getImageID($vendor->getFeatureImage());
                $img = wp_get_attachment_image_src($imageid, 'feature');
                $html .= '
                <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                    <div class="listing-panel">
                      <div class="image-wrapper"><img src="' . $img[0] . '" alt="' . $vendor->getTitle() . '" /></div>
                      <a href="' . $vendor->link() . '"><h3>' . $vendor->getTitle() . '</h3></a>
                      <div class="btn-wrapper"><a href="' . $vendor->link() . '" class="btn btn-secondary">View</a></div>
                      <div class="like-btn-wrapper like-id-' . $vendor->id() . '"><a href="' . get_page_link(133) . '" onclick="removeFromList(' . $vendor->id() . ')"><span class="fa fa-heart"></span></a></div>
                    </div>                
                </div>';
            }
        } else {
            // short list empty
            $html .= '
            <div class="col-xl-12">
                <p>You currently have 0 items added to your list.  Go to our <a href="' . get_page_link(21) . '">directory to browse our current listings.</a></p>
            </div>';
        }
        $html .= '</div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-5">
                <h1>It all starts here</h1>
                <h2>Email your list</h2>
                <p>Here is the email Taranaki Weddings would like to send to your shortlisted suppliers on your behalf. You can adjust this to suit your needs or send it as is. Once you are ready, just press send.</p>
            </div>
            <div class="col-12 col-md-6 col-lg-7 email-list-wrapper">' . do_shortcode('[contact-form-7 id="140" title="Shortlist"]') . '</div>
        </div>';
    } else {
        //user needs to be logged in to view their shortlist
        $html .= '
        <div class="row">
            <div class="col-xl-12">
                <p>Please <a href="' . get_page_link(107) . '">login</a> to view your shortlist.</p>
            </div>        
        </div>';
    }
    $html .= '</div>';


    return $html;
}
add_shortcode('shortlist', 'shortlist_shortcode');

function getShortlistFrom() {
    $user = wp_get_current_user();
    return $user->user_email;
}
add_shortcode('CF7_get_from_email', 'getShortlistFrom');

function displayUser_shortcode() {
    $user = wp_get_current_user();
    return $user->user_firstname . ' ' . $user->user_lastname;
}
add_shortcode('CF7_display_user', 'displayUser_shortcode');

function getShortlistTo() {
    $user = wp_get_current_user();
    $recipients = '';
    foreach(getShortlist($user->id) as $shortlist) {
        $vendor = new Vendor($shortlist->getVendor());
        if($recipients <> "") $recipients .= ',';
        $recipients .= $vendor->getEmail();
    }
    $recipients = 'aaron.zame@gmail.com,zame0314@hotmail.com';
    return $recipients;
}
add_shortcode('CF7_get_to_email', 'getShortlistTo');

add_filter('wpv_custom_inner_shortcodes', 'prefix_add_my_shortcodes');

function prefix_add_my_shortcodes($shortcodes) {
    $shortcodes[] = 'like-button';
    $shortcodes[] = 'award-winner';
    $shortcodes[] = 'blog-gallery-small';
    $shortcodes[] = 'blog-gallery-large';
    $shortcodes[] = 'categories-dropdown';
    return $shortcodes;
}

function categoryDropdown_shortcode() {
    $html = '
    <div class="js-wpt-field-items">
        <select class="form-control wpt-form-select form-select select category-select">';
        $html .= '<option class="wpt-form-option form-option option" value="">Select category...</option>';
        foreach(getCategories() as $category) {
            $html .= '<option class="wpt-form-option form-option option" value="' . $category->id() .'">' . $category->getTitle() .'</option>';
        }
        $html .= '
        </select>
    </div>';
    return $html;
}
add_shortcode('categories-dropdown', 'categoryDropdown_shortcode');

add_action('cred_submit_complete', 'add_to_mailing_list',10,4);
function add_to_mailing_list($post_id, $form_data)
{
    if ($form_data['id']==121) {
        if(isset($_POST['add_to_mailinglist']) && $_POST['add_to_mailinglist'] == 1) {
            //print_r($_POST);
            //print_r($form_data);
            $user = get_user_by( 'email', $_POST['user_email'] );
            // update user field
            update_user_meta($user->ID, 'wpcf-mailing-list', 1);
            // email admin
            $to = 'aaron.zame@gmail.com';
            $subject = 'New user registration';

            $message = 'Hi,
        
        The following user would like to be added to the Taranaki Weddings mailing list:
        
        First name: ' . $_POST['first_name'] . '
        Last name: ' . $_POST['last_name'] . '
        Email: ' . $_POST['user_email'];

            //send email
            wp_mail($to, $subject, $message);
            //exit;
        }

    }
}

if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == "add_listing") {
    // make sure user cannot add same listing twice
    $user = wp_get_current_user();
    $listingid = $_REQUEST['listingid'];
    $shortlist = getShortlistByVendor($user->id, $listingid);
    if(count($shortlist) <> 1) {
        // user adding a listing to their shortlist
        $postname = 'shortlist_' . strtotime("now");
        //create post object
        $my_post = array(
            'post_title' => wp_strip_all_tags($postname),
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => 'list',
            'post_author' => 1
        );
        $new_post_id = wp_insert_post($my_post);
        update_post_meta($new_post_id, 'wpcf-shortlist-user-id', $user->id);
        update_post_meta($new_post_id, 'wpcf-shortlist-vendor-id', $listingid);

    }
    //update listing page to show the the listing has been added to the users short list.
    $html = '<a href="javascript:;" onclick="removeListing(' . $listingid . ')"><span class="fa fa-heart"></span></a>';

    // also need to update the counter in the header
    $count = count(getShortlist($user->id));
    $html .= '|<span class="fa fa-heart"></span><i>' . $count . '</i>';
    echo $html;
    exit;
}
if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == "remove_listing") {
    $listingid = $_REQUEST['listingid'];
    $user = wp_get_current_user();
    $shortlists = getShortlistByVendor($user->id, $listingid);
    foreach($shortlists as $shortlist) {
        $my_post = array(
            'ID' => $shortlist->id(),
            'post_status' => 'draft'
        );
        wp_update_post( $my_post );
    }

        //update listing page to show the the listing has been removed from the users short list.
    $html = '<a href="javascript:;" onclick="addListing(' . $listingid . ')"><span class="fa fa-heart-o"></span></a>';
    $count = count(getShortlist($user->id));
    // also need to update the counter in the header
    if($count > 0) {
        $html .= '|<span class="fa fa-heart"></span>';
        $html .= '<i>' . $count . '</i>';
    } else {
        $html .= '|<span class="fa fa-heart-o"></span>';
    }
    echo $html;
    exit;
}

if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == "remove_from_list") {
    $listingid = $_REQUEST['listingid'];
    $user = wp_get_current_user();
    $shortlists = getShortlistByVendor($user->id, $listingid);
    foreach($shortlists as $shortlist) {
        $my_post = array(
            'ID' => $shortlist->id(),
            'post_status' => 'draft'
        );
        wp_update_post( $my_post );
    }

    echo 'removed';
    exit;
}