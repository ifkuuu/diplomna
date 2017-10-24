<?php

namespace Data;


class SubCategory
{
    private $id;

    private $subCategory;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSubCategory()
    {
        return $this->subCategory;
    }
}