<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 2/11/2019
 * Time: 12:37 PM
 */
class Shortlist extends TaranakiWeddingsBase
{
    public function getUser()
    {
        return $this->getPostMeta('shortlist-user-id');
    }
    public function getVendor()
    {
        return $this->getPostMeta('shortlist-vendor-id');
    }
}