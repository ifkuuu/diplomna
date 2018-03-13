<?php

namespace Service;


use Data\Brand;
use Data\Category;
use Data\City;
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
                 id,
                 size,
                 category_id AS mainCategory
                
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
                id,
                 name AS subCategory,
                 category_id AS mainCategory
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

    public function getAllCities()
    {
        $query = "SELECT
                        id,
                        city_name as name,
                        post_code as postCode
                    FROM cities
                  ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        while ($city = $stmt->fetchObject(City::class)) {
            yield $city;
        }
    }

    public function redactColour($name, $id)
    {
        $query = "
        UPDATE colours SET name = ? WHERE id = ?;
        ";
        $stmt = $this->db->prepare($query);
        if (!$stmt->execute([$name, $id,])) {
            throw new \Exception('Обновяванено не беше възможно!');
        }
        return true;
    }

    public function redactBrand($name, $id)
    {
        $query = "
        UPDATE brands SET name = ? WHERE id = ?;
        ";
        $stmt = $this->db->prepare($query);
        if (!$stmt->execute([$name, $id,])) {
            throw new \Exception('Обновяванено не беше възможно!');
        }
        return true;
    }

    public function redactCategory($name, $id)
    {
        $query = "
        UPDATE categories SET name = ? WHERE id = ?;
        ";
        $stmt = $this->db->prepare($query);
        if (!$stmt->execute([$name, $id,])) {
            throw new \Exception('Обновяванено не беше възможно!');
        }
        return true;
    }

    public function redactSize($name, $id)
    {
        $query = "
        UPDATE sizes SET size = ? WHERE id = ?;
        ";
        $stmt = $this->db->prepare($query);
        if (!$stmt->execute([$name, $id,])) {
            throw new \Exception('Обновяванено не беше възможно!');
        }
        return true;
    }

    public function redactSubCategory($name, $id)
    {
        $query = "
        UPDATE sub_categories SET name = ? WHERE id = ?;
        ";
        $stmt = $this->db->prepare($query);
        if (!$stmt->execute([$name, $id,])) {
            throw new \Exception('Обновяванено не беше възможно!');
        }
        return true;
    }

    public function addColour($name)
    {
        $query = "
            INSERT INTO colours (name) VALUES (?);
        ";
        $stmt = $this->db->prepare($query);
        if (!$stmt->execute([$name])) {
            throw new \Exception('Добавянето не беше възможно!');
        }
        return true;
    }

    public function addBrand($name)
    {
        $query = "
            INSERT INTO brands (name) VALUES (?);
        ";
        $stmt = $this->db->prepare($query);
        if (!$stmt->execute([$name])) {
            throw new \Exception('Добавянето не беше възможно!');
        }
        return true;
    }

    public function addCategory($name)
    {
        $query = "
            INSERT INTO categories (name) VALUES (?);
        ";
        $stmt = $this->db->prepare($query);
        if (!$stmt->execute([$name])) {
            throw new \Exception('Добавянето не беше възможно!');
        }
        return true;
    }

    public function addSubCategory($name, $parentCategoryID)
    {
        $query = "
            INSERT INTO sub_categories (name, category_id) VALUES (?, ?);
        ";
        $stmt = $this->db->prepare($query);
        if (!$stmt->execute([$name, $parentCategoryID])) {
            throw new \Exception('Добавянето не беше възможно!');
        }
        return true;
    }

    public function addSize($name, $parentCategoryId)
    {
        $query = "
            INSERT INTO sizes (size, category_id) VALUES (?, ?);
        ";
        $stmt = $this->db->prepare($query);
        if (!$stmt->execute([$name, $parentCategoryId])) {
            throw new \Exception('Добавянето не беше възможно!');
        }
        return true;
    }

}
