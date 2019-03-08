<?php
vc_map( array(
    "name" => __("Home Banner"),
    "base" => "dn_home_banner",
    "category" => __('Content'),
    'icon' => 'icon-wpb-single-image',
    'description' => 'Banner for the home page',
    "params" => array(
        array(
            "type" => "attach_image",
            "heading" => __("Banner Images"),
            "param_name" => "image",
        )
    )
));
add_shortcode('dn_home_banner', 'homeBanner');
function homeBanner($atts)
{
    $args = shortcode_atts(array(
        'image' => ''
    ), $atts);
    $img = wp_get_attachment_image_src($args['image'], 'banner');
    $bannerImage = $img[0];

    $html = '
    <div class="banner-wrapper">
           <img src="' . $bannerImage . '" alt="' . get_bloginfo('name') . '" />
           <a href="javascript:;" class="down"><span class="fa fa-angle-down"></span></a>
    </div>';

    return $html;
}