<h1>Draste!</h1>
<hr>
<form method="post" enctype="multipart/form-data">
    Product Name: <input type="text" name="name"><br>
    Product Price: <input type="text" name="price"><br>
    Product Quantity: <input type="text" name="quantity"><br>
    Brand:
    <select name="brand">
        <?php foreach ($brands as $brand): ?>
            <option value="<?= $brand->getId() ?>"><?php echo $brand->getBrand() ?></option>
        <?php endforeach; ?>
    </select>
    <br>
    Category:
    <select name="category">
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category->getId() ?>"><?php echo $category->getCategory() ?></option>
        <?php endforeach; ?>
    </select>
    <br>
    Sub-Category:
    <select name="subCategory">
        <?php foreach ($subCategories as $sCategory): ?>
            <option data-category-id="<?= $sCategory->getId() ?>" value="<?= $sCategory->getId() ?>"><?php echo $sCategory->getSubCategory() ?></option>
        <?php endforeach; ?>
    </select>
    <br>
    Gender:
    <select name="gender">
        <?php foreach ($genders as $gender): ?>
            <option value="<?= $gender->getId() ?>"><?php echo $gender->getGender() ?></option>
        <?php endforeach; ?>
    </select>
    <br>
    Size:
    <select name="size">
        <?php foreach ($sizes as $size): ?>
            <option value="<?= $size->getId() ?>"><?php echo $size->getSize() ?></option>
        <?php endforeach; ?>
    </select>
    <br>
    Colour:
    <select name="colour">
        <?php foreach ($colours as $colour): ?>
            <option value="<?= $colour->getId() ?>"><?php echo $colour->getColour() ?></option>
        <?php endforeach; ?>
    </select>
    <br>
    <input type="file" name="image"><br>
    <textarea name="description" placeholder="Добавете описание по желание" rows="10" cols="50"></textarea><br>
    <input type="submit" name="add" value="Добави продукт"><br>
</form>
<br>
<br>
<form method="post">
    <input type="submit" name="select" value="View All">
</form>
