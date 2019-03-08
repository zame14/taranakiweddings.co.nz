<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2/8/2019
 * Time: 11:04 AM
 */
$vendor = new Vendor($post);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?=$vendor->displayTemplate()?>
    <div class="row project-navigation">
        <div class="col-xl-12">
            <?php
            $previous = $vendor->previous();
            $category = $vendor->getCategory();
            if($previous->id() <> "") {
                echo '<a href="' . $previous->link() . '" class="previous"></a>';
            }
            echo '<a href="' . $category->link() . '" class="listing"><span class="fa fa-th"></span></a>';
            $next = $vendor->next();
            if($next->id() <> "") {
                echo '<a href="' . $next->link() . '" class="next"></a>';
            }
            ?>
        </div>
    </div>
</article>