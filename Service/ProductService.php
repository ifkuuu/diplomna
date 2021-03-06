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
    const NUMBER_OF_NEWEST_ITEMS = 7;

    private $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function addProduct(string $name,
                               float $price,
                               array $quantities,
                               int $categoryId,
                               int $subCategoryId,
                               int $brandId,
                               int $genderId,
                               array $sizesIDs,
                               int $colourId,
                               string $description = null,
                               array $picturesPaths = null)
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

        // Insert images
        if ($picturesPaths !== null) {
            foreach ($picturesPaths as $picturePath) {

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
            }
        } else {
            $query = "INSERT INTO product_pictures (
		            product_id,
		            colour_id,
		            picture_path
		          ) VALUES (
		            ?,
		            ?,
		            DEFAULT 
	              )
	    ";

            $stmt = $this->db->prepare($query);
            $stmt->execute(
                [
                    $lastId,
                    $colourId,
                ]
            );
        }


        foreach ($sizesIDs as $key => $sizeId) {

            if ($quantities[$key] < 1) {
                $quantities[$key] = 1;
            }

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
                $quantities[$key],
                $price
            ]);
        }
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
                  WHERE pv.stock >= 1
                  AND p.deleted_on IS NULL
         ";
        $flag = 0;
        if (isset($_GET['gender'])) {
            $query .= "AND pv.gender_id = ? ";
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
        $obj = $stmt->fetchObject(Brand::class);
        if ($obj === false) {
            throw new \Exception("Такъв продукт не съществува!");
        }
        $product->setBrandInfo($obj);

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
	                  pv.discount_price as discountedPrice,
	                  pv.stock as stock
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
        $product->setStock($result[0]['stock']);

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

    public function search(string $searchText)
    {
        $query = "  SELECT 
                      pv.id as productVariantId,
                      pv.price as price,
                      pv.discount_price as discountedPrice,
                      prod.name as productName,
                      g.name as gender,
                      pp.picture_path as imageUrl,
                      b.name as brand
                    FROM products prod
                    JOIN product_variants pv on pv.product_id = prod.id
                    JOIN genders g on g.id = pv.gender_id
                    JOIN colours c on c.id = pv.colour_id
                    JOIN sizes s on s.id = pv.size_id
                    JOIN brands b on b.id = prod.brand_id
                    JOIN sub_categories sc on sc.id = prod.sub_category_id
                    JOIN product_pictures AS pp ON pp.product_id = prod.id
                    WHERE
                        prod.name like ?
                        OR
                        g.name like ?
                        OR
                        c.name like ?
                        OR
                        s.size like ?
                        OR
                        b.name like ?
                        OR
                        sc.name like ?
                        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([
           "%{$searchText}%",
           "%{$searchText}%",
           "%{$searchText}%",
           "%{$searchText}%",
           "%{$searchText}%",
           "%{$searchText}%"
        ]);

        $foundProducts = [];
        while ($product = $stmt->fetchObject(AllProductsViewData::class)) {
            $foundProducts[] = $product;
        }
        return $foundProducts;
    }

    public function updateProductStock(int $id, int $quantity)
    {
        $query = "
            UPDATE product_variants pv
            SET pv.stock = ?
            WHERE pv.id = ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([
            $quantity,
            $id
        ]);

        return true;
    }

    public function filterSizesByIdAndColour(int $productId, int $colourId)
    {
        $query = "
                  SELECT 
                      s.id, s.size as size
                  FROM 
                      sizes AS s
                  JOIN product_variants AS pv ON pv.size_id = s.id
                  JOIN products as p ON p.id = pv.product_id
                  JOIN colours as c ON c.id = pv.colour_id
                  WHERE p.id = (SELECT
									p.id
									FROM products as p
									JOIN product_variants as pv ON pv.product_id = p.id 
									WHERE pv.id = ?
									AND c.id = ?)
				  ORDER BY s.size
				 ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$productId, $colourId]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getVariantIdByColourAndSize(int $productVariantId, int $colourId, int $sizeId)
    {

        $query = "
                  SELECT
                      pv.id as id
                  FROM products AS p
                  JOIN product_variants AS pv ON p.id = pv.product_id
                  JOIN colours c on c.id = pv.colour_id
                  JOIN sizes s on s.id = pv.size_id
                  WHERE c.id = ?
                  AND s.id = ?
                  AND p.id = (
                              SELECT p.id
                              FROM products as p
                              JOIN product_variants as pv ON pv.product_id = p.id 
                              AND pv.id = ?
                              )
						  ";

        $stmt = $this->db->prepare($query);
        $stmt->execute(
            [
                $colourId,
                $sizeId,
                $productVariantId
            ]
        );

        $resultId = $stmt->fetch()[0];
        return $resultId;
    }

    public function getNewestProductsViewData()
    {
        // Custom function to replace only the last occurrence of a string.
        function str_lreplace($search, $replace, $subject)
        {
            $pos = strrpos($subject, $search);

            if($pos !== false)
            {
                $subject = substr_replace($subject, $replace, $pos, strlen($search));
            }

            return $subject;
        }

        $limit = self::NUMBER_OF_NEWEST_ITEMS;

        $query = "SELECT id 
                  FROM products 
                  ORDER BY id DESC 
                  LIMIT {$limit}";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $resultIDsStr = "(";
        while ($result = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $resultIDsStr .= intval($result['id']) . ", ";
        }

        $resultIDsStr = str_lreplace(', ', ')', $resultIDsStr);

        $query = "SELECT pv.id
                  FROM products as p
                  JOIN product_variants as pv ON pv.product_id = p.id
                  WHERE p.id IN {$resultIDsStr}
                  GROUP BY p.id
                  ORDER BY p.id DESC;
                  ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $newestProducts = [];
        while ($result = $stmt->fetch()) {
            $newestProducts[] = $this->getProductInfo($result['id']);
        }

        return $newestProducts;
    }
}
