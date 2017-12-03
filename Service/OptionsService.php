<?php

namespace Service;


use Data\Brand;
use Data\Category;
use Data\Colour;
use Data\Gender;
use Data\Size;
use Data\SubCategory;

class OptionsService implements OptionsServiceInterface
{

    private $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function getBrands()
    {
        $query = "
            SELECT 
                id, name AS brand
            FROM 
                brands
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        while ($brand = $stmt->fetchObject(Brand::class)) {
            yield $brand;
        }
    }

    public function getGenders()
    {
        $query = "
            SELECT 
                id, name AS gender
            FROM 
                genders
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $genders = [];
        while ($gender = $stmt->fetchObject(Gender::class)) {
            $genders[] = $gender;
        }
        return $genders;
    }

    public function getSizes()
    {
        $query = "
            SELECT 
                 id, size
            FROM 
                sizes
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        while ($size = $stmt->fetchObject(Size::class)) {
            yield $size;
        }
    }

    public function getCategories()
    {
        $query = "
            SELECT 
                id, name AS category
            FROM 
                categories
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $categories = [];
        while ($category = $stmt->fetchObject(Category::class)) {
           // yield $category;
            $categories[] = $category;
        }
        return $categories;
    }

    public function getSubCategories()
    {
        $query = "
            SELECT 
                id, name AS subCategory
            FROM 
                sub_categories
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $subCategories = [];
        while ($subCategory = $stmt->fetchObject(SubCategory::class)) {
            //yield $subCategory;
            $subCategories[] = $subCategory;
        }
        return $subCategories;
    }

    public function getColours()
    {
        $query = "
            SELECT 
                id, name AS colour
            FROM 
                colours
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        while ($colour = $stmt->fetchObject(Colour::class)) {
            yield $colour;
        }
    }
}
