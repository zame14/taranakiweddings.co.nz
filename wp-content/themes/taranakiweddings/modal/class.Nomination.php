<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 3/6/2019
 * Time: 1:08 PM
 */
class Nomination extends TaranakiWeddingsBase
{
    public function getName()
    {
        return $this->getPostMeta('nomination-your-name');
    }
    public function getEmail()
    {
        return $this->getPostMeta('nomination-your-email');
    }
    public function getWeddingDate()
    {
        return $this->getPostMeta('nomination-wedding-date');
    }
    public function getPhone()
    {
        return $this->getPostMeta('nomination-your-phone');
    }
    public function getCategory()
    {
        return $this->getPostMeta('nomination-business-category');
    }
    public function getBusiness()
    {
        return $this->getPostMeta('nomination-business-to-nominate');
    }
    public function getWhyNominate()
    {
        return $this->getPostMeta('nomination-why-nominate');
    }
    public function getSupportingDoc()
    {
        return $this->getPostMeta('nomination-supporting-doc');
    }
    public function getYear()
    {
        return $this->getPostMeta('nomination-year');
    }
}