<?php

namespace Service;


use Data\Brand;
use Data\Category;
use Data\Colour;
use Data\Gender;
use Data\Image;
use Data\Products\AllProductsViewData;
use Data\Products\Product;
use Data\Size;
use Data\SubCategory;

class ProductService implements ProductServiceInterface
{

    const ITEMS_PER_PAGE = 8;
    const RELATED_PRODUCTS_LIMIT = 10;

    private $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function addProduct(string $name,
                               float $price,
                               int $quantity,
                               int $categoryId,
                               int $subCategoryId,
                               int $brandId,
                               int $genderId,
                               int $sizeId,
                               int $colourId,
                               string $description = null,
                               string $picturePath = null)
    {

        $query = "INSERT INTO products (
		            name,
		            description,
		            category_id,
		            sub_category_id,
		            brand_id	
	            ) VALUES (
		            ?,
		            ?,
		            ?,
		            ?,
		            ?
                )
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute(
            [
                $name,
                $description,
                $categoryId,
                $subCategoryId,
                $brandId
            ]
        );

        $lastId = $this->db->lastInsertId();

        $query = "INSERT INTO product_pictures (
		            product_id,
		            colour_id,
		            picture_path
		          ) VALUES (
		            ?,
		            ?,
		            ?
	              )
	    ";

        $stmt = $this->db->prepare($query);
        $stmt->execute(
            [
                $lastId,
                $colourId,
                $picturePath
            ]
        );

        $query = "
            INSERT INTO product_variants (
                product_id, size_id, gender_id, colour_id, stock, price
            ) VALUES (
              ?, ?, ?, ?, ?, ?
            )
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([
            $lastId,
            $sizeId,
            $genderId,
            $colourId,
            $quantity,
            $price
        ]);
    }

    public function getAllProductsViewData()
    {

        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $perPage = self::ITEMS_PER_PAGE;
        $start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

        $query = "SELECT
                    SQL_CALC_FOUND_ROWS  
                    pv.id as productVariantId,
                    pv.price as price,
                    pv.discount_price as discountedPrice,
                    p.name as productName,
                    g.name as gender,
                    pp.picture_path as imageUrl,
                    b.name as brand
                  FROM product_variants AS pv
                  JOIN genders AS g ON g.id = pv.gender_id
                  JOIN products AS p ON p.id = pv.product_id
                  JOIN product_pictures AS pp ON pp.product_id = p.id
                  JOIN brands AS b ON b.id = p.brand_id 
         ";
        $flag = 0;
        if (isset($_GET['gender'])) {
            $query .= "WHERE pv.gender_id = ? ";
            $flag = 1;
        }
        if (isset($_GET['cat'])) {
            $query .= "AND p.category_id = ? ";
            $flag = 2;
        }
        if (isset($_GET['subCat'])) {
            $query .= "AND p.sub_category_id = ? ";
            $flag = 3;
        }
        $query .= "
                GROUP BY pv.id   
                LIMIT {$perPage} OFFSET {$start}";
        $stmt = $this->db->prepare($query);
        if ($flag === 1) {
            $stmt->execute([
                $_GET['gender']
            ]);
        } elseif ($flag === 2) {
            $stmt->execute([
                $_GET['gender'],
                $_GET['cat']
            ]);
        } elseif ($flag === 3) {
            $stmt->execute([
                $_GET['gender'],
                $_GET['cat'],
                $_GET['subCat']
            ]);
        } else {
            $stmt->execute();
        }


        /* ================================================================================================== */
        /* Ne moga da izpolzvam generatora zashtoto dannite mi trqbvat oshte 1 put za paginatora!!
            za tova she gi zapazvam v masiv, makar da e po-bavno */
        /* ================================================================================================== */

        /* while ($product = $stmt->fetchObject(AllProductsViewData::class)) {
               yield $product;
           }*/
        /* ================================================================================================== */


        $allProducts = [];
        while ($product = $stmt->fetchObject(AllProductsViewData::class)) {
            $allProducts[] = $product;
        }

        // namira broq na vsichkite produkti ot prednata zaqvka
        $query = "SELECT FOUND_ROWS() as total";
        $stmt = $this->db->query($query);
        $totalProducts = $stmt->fetch(\PDO::FETCH_ASSOC)['total'];
        $totalPages = ceil($totalProducts / $perPage);
        $allProducts[] = intval($totalPages);
        return $allProducts;
    }

    public function getProductInfo(int $id)
    {

        $product = new Product();

        $query = "SELECT 
                      b.id, b.name as brand
                  FROM 
                      brands AS b
                  JOIN products AS p ON p.brand_id = b.id
                  JOIN product_variants AS pv ON pv.product_id = p.id
                  WHERE pv.id = ?
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $product->setBrandInfo($stmt->fetchObject(Brand::class));

        $query = "SELECT 
                      b.id, b.name as category
                  FROM 
                      categories AS b
                  JOIN products AS p ON p.category_id = b.id
                  JOIN product_variants AS pv ON pv.product_id = p.id
                  WHERE pv.id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $product->setCategoryInfo($stmt->fetchObject(Category::class));


        $query = "SELECT 
                      b.id, b.name as subCategory
                  FROM 
                      sub_categories AS b
                  JOIN products AS p ON p.sub_category_id = b.id
                  JOIN product_variants AS pv ON pv.product_id = p.id
                  WHERE pv.id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $product->setSubCategoryInfo($stmt->fetchObject(SubCategory::class));

        $query = "SELECT 
                      g.id, g.name as gender
                  FROM 
                      genders AS g
                  JOIN product_variants AS pv ON pv.gender_id = g.id
                  WHERE pv.id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $product->setGenderInfo($stmt->fetchObject(Gender::class));

        $query = "SELECT 
                      c.id, c.name as colour
                  FROM 
                      colours AS c
                  JOIN product_variants AS pv ON pv.colour_id = c.id
                  WHERE pv.id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $product->setColourInfo($stmt->fetchObject(Colour::class));

        $query = "SELECT 
                      s.id, s.size as size
                  FROM 
                      sizes AS s
                  JOIN product_variants AS pv ON pv.size_id = s.id
                  WHERE pv.id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $product->setSizeInfo($stmt->fetchObject(Size::class));

        $query = "SELECT 
                      s.id, s.size as size
                  FROM 
                      sizes AS s
                  JOIN product_variants AS pv ON pv.size_id = s.id
                  JOIN products as p ON p.id = pv.product_id
                  WHERE p.id = (SELECT
									p.id
									FROM products as p
									JOIN product_variants as pv ON pv.product_id = p.id 
									WHERE pv.id = ?)
				  ORDER BY s.size";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $product->setAllSizes(function () use ($stmt) {
            while ($size = $stmt->fetchObject(Size::class)) {
                yield $size;
            }
        });


        // Getting all available colours for current product
        $query = "  SELECT c.id, c.name as colour
                    FROM colours c
                    JOIN product_variants pv ON pv.colour_id = c.id 
                    JOIN products p ON pv.product_id = p.id
                    WHERE p.id = (
                        SELECT p.id
                            FROM products p
                            JOIN product_variants pv ON p.id = pv.product_id
                            WHERE pv.id = ?
                    )
                    GROUP BY c.id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $product->setAllColours(function () use ($stmt) {
            while ($colour = $stmt->fetchObject(Colour::class)) {
                yield $colour;
            }
        });


        // Getting all images for current product
        $query = "SELECT 
                      pp.id, pp.picture_path as imageUrl
                  FROM 
                      product_pictures AS pp
                  JOIN products as p ON p.id = pp.product_id
                  JOIN product_variants AS pv ON pv.product_id = p.id
                  WHERE p.id = (
                          SELECT
								  p.id
						  FROM products as p
						  JOIN product_variants as pv ON pv.product_id = p.id 
						  WHERE pv.id = ?
				  )
				  GROUP BY pp.id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $flag = false;
            while ($image = $stmt->fetchObject(Image::class)) {
                while (!$flag) {
                    $product->setMainImage($image);
                    $flag = true;
                }
                $product->setImages($image);
            }

            //==============================================================================
        $query = "SELECT
                      pv.id as id,
	                  p.name as name,
	                  p.description as description,
	                  pv.price as price,
	                  pv.discount_price as discountedPrice
                  FROM products AS p
                  JOIN product_variants AS pv ON p.id = pv.product_id
                  WHERE pv.id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $product->setId($result[0]['id']);
        $product->setName($result[0]['name']);
        $product->setDescription($result[0]['description']);
        $product->setPrice($result[0]['price']);
        $product->setDiscountedPrice($result[0]['discountedPrice']);

        return $product;
    }

    public function getRelatedProducts(int $id)
    {
        $relatedProducts = [];
        $limit = self::RELATED_PRODUCTS_LIMIT;

        $query = "SELECT
                    pv.id
                FROM product_variants pv
                JOIN products p ON p.id = pv.product_id
                WHERE pv.gender_id = 
                    (
                        SELECT
                            g.id
                        FROM genders g
                        JOIN product_variants pv ON pv.gender_id = g.id
                        WHERE pv.id = ?
                    )
                AND p.sub_category_id =
                    (
                        SELECT
                            sc.id
                        FROM sub_categories sc
                        JOIN products p ON p.sub_category_id = sc.id
                        JOIN product_variants pv ON pv.product_id = p.id
                        WHERE pv.id = ?
                    )
                GROUP BY p.id
                LIMIT {$limit}";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$id, $id]);

        $relatedProductIds = [];
        while ($relatedId = $stmt->fetchAll(\PDO::FETCH_ASSOC)) {
            $relatedProductIds[] = $relatedId;
        }
        foreach ($relatedProductIds[0] as $relId) {
            $relatedProducts[] = $this->getProductInfo($relId['id']);
        }

        return $relatedProducts;
    }
}
