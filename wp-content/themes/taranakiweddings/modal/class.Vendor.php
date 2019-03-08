<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 2/8/2019
 * Time: 11:08 AM
 */
class Vendor extends TaranakiWeddingsBase
{
    public function getEmail()
    {
        return $this->getPostMeta('email');
    }
    public function getFeatureImage()
    {
        return $this->getPostMeta('vendor-feature-image');
    }
    public function getWebsite()
    {
        return $this->getPostMeta('website-url');
    }
    public function getPhone()
    {
        return $this->getPostMeta('phone');
    }
    public function getAddress()
    {
        return $this->getPostMeta('address');
    }
    public function getFacebook()
    {
        return $this->getPostMeta('facebook-url');
    }
    public function getInstagram()
    {
        return $this->getPostMeta('instagram-url');
    }
    public function getTwitter()
    {
        return $this->getPostMeta('twitter-url');
    }
    public function getListingType()
    {
        return $this->getPostMeta('listing-type');
    }
    public function getGalleryImages()
    {
        $gallery = Array();
        $field = get_post_meta($this->id());
        foreach($field['wpcf-gallery-images'] as $image) {
            $gallery[] = $image;
        }
        return $gallery;
    }
    public function getAwardImages()
    {
        $gallery = Array();
        $field = get_post_meta($this->id());
        foreach($field['wpcf-award-images'] as $image) {
            $gallery[] = $image;
        }
        return $gallery;
    }
    public function getIndustryAwardLogo()
    {
        return $this->getPostMeta('industry-award-logo');
    }
    public function hasAward()
    {
        if($this->getPostMeta('industry-award-logo') <> ""){
            return true;
        } else {
            return false;
        }
    }
    function displayTemplate() {
        $html = '';
        if($this->getListingType() == 1) {
            // tier 1 listing
            $html = '
            <div class="row">
                <div class="col-12 col-md-6 col-lg-7">';
                foreach($this->getGalleryImages() as $images) {
                    $imageid = getImageID($images);
                    $img = wp_get_attachment_image_src($imageid, 'single-gallery');
                    $html .= '<div class="image-wrapper"><img src="' . $img[0] . '" alt="' . $this->getTitle() . '" /></div>';
                    break; // tier 1 make sure we just display one image
                }
                $html .= '
                </div>
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="vendor-details-box">
                        <div class="title">Details</div>
                        <ul>
                            <li><label>Phone:</label><a href="tel:' . formatPhoneNumber($this->getPhone()) . '">' . $this->getPhone() . '</a></li>
                            <li><label>Email:</label><a href="mailto:' . $this->getEmail() . '">' . $this->getEmail() . '</a></li>
                            <li><label>Website:</label><a href="' . $this->getWebsite() . '" target="_blank">' . $this->getWebsite() . '</a></li>
                            <li><label>Address</label>' . $this->getAddress() . '</li>
                        </ul>
                        <div class="map-wrapper">
                            <iframe frameborder="0" src="https://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=' . str_replace(",", "", str_replace(" ", "+", $this->getAddress())) . '&z=14&output=embed"></iframe>
                        </div>
                        <div class="like-btn-wrapper like-id-' . $this->id() . '">' . do_shortcode('[like-button listingid="' . $this->id() . '"]') . '</div>
                    </div>
                </div>
            </div>';
        } else {
            //tier 2 & 3
            $html = '
            <div class="row">
                <div class="col-xl-12">
                    <div class="gallery-wrapper">';
                    foreach ($this->getGalleryImages() as $images) {
                        $imageid = getImageID($images);
                        $img = wp_get_attachment_image_src($imageid, 'slider-gallery');
                        $html .= '<div><img src="' . $img[0] . '" alt="" /></div>';
                    }
                    $html .= '
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-7">
                    ' . $this->getContent() . '
                    <div class="awards-wrapper">
                        <ul>';
                        foreach ($this->getAwardImages() as $images) {
                            $html .= '<li><img src="' . $images . '" alt="" /></li>';
                        }
                        $html .= '
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="vendor-details-box">
                        <div class="title">Details</div>
                        <ul class="contact-dets">
                            <li><label>Phone:</label><a href="tel:' . formatPhoneNumber($this->getPhone()) . '">' . $this->getPhone() . '</a></li>
                            <li><label>Email:</label><a href="mailto:' . $this->getEmail() . '">' . $this->getEmail() . '</a></li>
                            <li><label>Website:</label><a href="' . $this->getWebsite() . '" target="_blank">' . $this->getWebsite() . '</a></li>
                            <li><label>Address</label>' . $this->getAddress() . '</li>
                        </ul>
                        ' . $this->socialMediaMenu() . '
                        <div class="map-wrapper">
                            <iframe frameborder="0" src="https://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=' . str_replace(",", "", str_replace(" ", "+", $this->getAddress())) . '&z=14&output=embed"></iframe>
                        </div>
                        <div class="like-btn-wrapper like-id-' . $this->id() . '">' . do_shortcode('[like-button listingid="' . $this->id() . '"]') . '</div>
                    </div>                
                </div>
            </div>';
        }
        return $html;
    }
    public function getCategory()
    {
        global $wpdb;
        // get the stories associated with this gallery
        $sql = 'SELECT parent_id FROM ' . $wpdb->prefix . 'toolset_associations WHERE child_id = ' . $this->Post->ID;
        $result = $wpdb->get_results($sql);

        return new DirectoryListing($result[0]->parent_id);
    }
    public function previous()
    {
        global $wpdb;
        $directory = $this->getCategory();
        $sql = '
        SELECT p.ID
        FROM ' . $wpdb->prefix . 'posts p
        INNER JOIN ' . $wpdb->prefix . 'toolset_associations ta
        ON p.ID = ta.child_id
        WHERE p.ID < ' . $this->Post->ID . '
        AND post_status="publish" 
        AND post_type="vendor" 
        AND ta.parent_id = ' . $directory->id() . '
        ORDER BY p.ID DESC
        LIMIT 1';
        $result = $wpdb->get_results($sql);

        $previd = $result[0]->ID;
        if($previd == "") {
            $sql1 = '
            SELECT p.ID 
            FROM ' . $wpdb->prefix . 'posts p
            INNER JOIN ' . $wpdb->prefix . 'toolset_associations ta
            ON p.ID = ta.child_id           
            WHERE post_status="publish" 
            AND post_type="vendor"
            AND ta.parent_id = ' . $directory->id() . '
            ORDER BY p.ID DESC
            LIMIT 1';
            $result1 = $wpdb->get_results($sql1);

            $previd = $result1[0]->ID;

        }

        return new Vendor($previd);
    }
    public function next()
    {
        global $wpdb;
        $directory = $this->getCategory();
        $sql = '
        SELECT p.ID 
        FROM ' . $wpdb->prefix . 'posts p
        INNER JOIN ' . $wpdb->prefix . 'toolset_associations ta
        ON p.ID = ta.child_id
        WHERE p.ID > ' . $this->Post->ID . '
        AND post_status="publish" 
        AND post_type="vendor" 
        AND ta.parent_id = ' . $directory->id() . '
        ORDER BY p.ID ASC
        LIMIT 1';
        $result = $wpdb->get_results($sql);

        $nextid = $result[0]->ID;
        if($nextid == "") {
            $sql1 = '
            SELECT p.ID 
            FROM ' . $wpdb->prefix . 'posts p
            INNER JOIN ' . $wpdb->prefix . 'toolset_associations ta
            ON p.ID = ta.child_id            
            WHERE post_status="publish" 
            AND post_type="vendor"
            AND ta.parent_id = ' . $directory->id() . '
            ORDER BY p.ID ASC
            LIMIT 1';
            $result1 = $wpdb->get_results($sql1);

            $nextid = $result1[0]->ID;

        }
        return new Vendor($nextid);
    }

    function socialMediaMenu()
    {
        $html = '<ul class="social-media">';
        if($this->getFacebook() <> "") {
            $html .= '<li><a href="' . $this->getFacebook() . '" target="_blank"><span class="fa fa-facebook"></span></a></li>';
        }
        if($this->getTwitter() <> "") {
            $html .= '<li><a href="' . $this->getTwitter() . '" target="_blank"><span class="fa fa-twitter"></span></a></li>';
        }
        if($this->getInstagram() <> "") {
            $html .= '<li><a href="' . $this->getInstagram() . '" target="_blank"><span class="fa fa-instagram"></span></a></li>';
        }
        $html .= '</ul>';

        return $html;
    }
}
