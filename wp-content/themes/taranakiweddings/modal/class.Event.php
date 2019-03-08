<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 2/14/2019
 * Time: 10:26 AM
 */
class Event extends TaranakiWeddingsBase
{
    public function getFeatureImage()
    {
        return $this->getPostMeta('event-feature-image');
    }
    public function getButton()
    {
        return '<a href="' . $this->getPostMeta('event-button-link') . '" class="btn btn-primary">' . $this->getPostMeta('event-button-label') . '</a>';
    }
}