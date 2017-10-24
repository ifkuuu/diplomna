<?php

namespace Service;


interface OptionsServiceInterface
{
    public function getBrands();

    public function getGenders();

    public function getSizes();

    public function getCategories();

    public function getSubCategories();

    public function getColours();

}