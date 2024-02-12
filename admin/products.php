<?php

require_once("../inc/init.php");


// Suppression
if (isset($_GET['action']) && $_GET['action'] == "supprimer") {

    $id = $_GET["id_product"];

    $pdo->exec("DELETE FROM products WHERE id_product = '$id'");

    $content = "<div class='alert alert-success'>Produit supprimé en BDD</div>";

}

if (isset($_GET['action']) && $_GET['action'] == "modifier") {

    $id = $_GET["id_product"];

    $stmt = $pdo->query("SELECT * FROM products WHERE id_product = '$id'");
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    extract($product);


}

// Search

if (isset($_GET['key_word'])) {
    
    $keyWord = $_GET['key_word'];
    $stmt = $pdo->query("SELECT * FROM products WHERE title LIKE '%$keyWord%' OR description LIKE '%$keyWord%' ");

} else {

    $stmt = $pdo->query("SELECT * FROM products");

}


// ajout
if ($_POST) {

    if (!empty($_FILES["myPicture"]["name"])) {


        // nom pour la photo
        $pictureName = addslashes($_FILES["myPicture"]["name"]);

        // copie le chemin de la photo sur le serveur en BDD
        $pathPictureForDB = URL . "pictures/" . $pictureName;

        // dossier où copier l'image sur le serveur
        // /Applications/MAMP/htdocs/PHP_APFA_2024/pictures/NOM_IMAGE.extension
        $pathFolder = SITE_ROOT . "pictures/" . $pictureName;

        // copier l'image sur le serveur
        copy($_FILES["myPicture"]["tmp_name"], $pathFolder);
    }

    // ici on veut échapper tous les caractères spéciaux de nos champs
    // pour éviter des soucis lors de la requête (comme pare exemple avec l'apostrophe en français)
    foreach ($_POST as $key => $value) {
        $_POST[$key] = addslashes($value);
    }

    extract($_POST);

    if (isset($_POST["modifyProduct"])) {

        $query = "
        UPDATE products 
        SET reference = '$reference',
        category = '$category',
        title = '$title',
        description = '$description',
        color = '$color',
        size = '$size',
        public = '$public',
        price = '$price',
        stock = '$stock'
        ";

        if (isset($pathPictureForDB)) {
            $query .= ", picture = '$pathPictureForDB' ";
        }

        $query .= "WHERE id_product = '$id_product'";

        $count = $pdo->exec($query);

        if($count >= 1) {
            $content = "<div class='alert alert-success'>
                Votre produit a bien été modifié en BDD !
            </div>";
        }


    } else {

        $count = $pdo->exec("INSERT INTO products(reference, category, title, description, color, size, public, price, picture, stock)
        VALUES(
            '$reference',
            '$category',
            '$title',
            '$description',
            '$color',
            '$size',
            '$public',
            '$price',
            '$pathPictureForDB',
            '$stock'
        )");

        if ($count >= 1) {
                $content = "<div class='alert alert-success'>
            Votre produit a bien été ajouté en BDD
        </div>";
        }

    }

}



$id_product = isset($id_product) ? $id_product : "";
$reference = isset($reference) ? $reference : "";
$price = isset($price) ? $price : "";
$stock = isset($stock) ? $stock : "";
$category = isset($category) ? $category : "";
$public = isset($public) ? $public : "";
$size = isset($size) ? $size : "";
$picture = isset($picture) ? $picture : "";
$color = isset($color) ? $color : "";
$title = isset($title) ? $title : "";
$description = isset($description) ? $description : "";

require_once("inc/header.php");

?>

<?= $content; ?>
<!-- BODY -->

<h1 class="mb-5 text-center col-12">Welcome to the management of your products in your BackOffice</h1>


<!-- TABLE -->

<p class="text-center col-12">Your products in DB:</p>


<table class="table">
    <thead class="thead-dark">
        <tr>
            <?php for ($i = 0; $i < $stmt->columnCount(); $i++) { ?>
                <th scope="col">
                    <?= $stmt->getColumnMeta($i)["name"]; ?>
                </th>
            <?php } ?>
            <th scope="col"> Modifier </th>
            <th scope="col"> Supprimer </th>

        </tr>
    </thead>
    <tbody>
        <?php while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
                <td>
                    <?= $product["id_product"]; ?>
                </td>
                <td>
                    <?= $product["reference"]; ?>
                </td>
                <td>
                    <?= $product["category"]; ?>
                </td>
                <td>
                    <?= $product["title"]; ?>
                </td>
                <td>
                    <?= $product["description"]; ?>
                </td>
                <td>
                    <?= $product["color"]; ?>
                </td>
                <td>
                    <?= $product["size"]; ?>
                </td>
                <td>
                    <?= $product["public"]; ?>
                </td>
                <td> <img style="width:50px" src="<?= $product["picture"]; ?>"></td>
                <td>
                    <?= $product["price"]; ?>
                </td>
                <td>
                    <?= $product["stock"]; ?>
                </td>
                <td> <a href="?action=modifier&id_product=<?= $product["id_product"]; ?>#add_modify">Modifier</a> </td>
                <td> <a href="?action=supprimer&id_product=<?= $product["id_product"]; ?>#add_modify">Supprimer</a> </td>
            </tr>
        <?php } ?>
        </tr>

    </tbody>
</table>

<div class="row col-12">
</div>


<p id="add_modify">Add or Modify your products :</p>

<form action="" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id_product" value="<?= $id_product; ?>">
    <input type="hidden" name="prevPicture">
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="reference">Reference</label>
            <input type="text" class="form-control" id="reference" value="<?= $reference; ?>" name="reference">
        </div>
        <div class="form-group col-md-3">
            <label for="category">Category</label>
            <input type="text" class="form-control" id="category" value="<?= $category; ?>" name="category">
        </div>
        <div class="form-group col-md-3">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" value="<?= $title; ?>" name="title">
        </div>
        <div class="form-group col-md-3">
            <label for="color">Color</label>
            <input type="text" class="form-control" id="color" value="<?= $color; ?>" name="color">
        </div>
        <div class="form-group col-md-3">
            <label for="size">Size</label>
            <input type="text" class="form-control" id="size" value="<?= $size; ?>" name="size">
        </div>
        <div class="form-group col-md-3">
            <label for="price">Price</label>
            <input type="text" class="form-control" id="price" value="<?= $price; ?>" name="price">
        </div>
        <div class="form-group col-md-3">
            <label for="stock">Stock</label>
            <input type="text" class="form-control" id="stock" value="<?= $stock; ?>" name="stock">
        </div>
        <div class="w-100"></div>

        <!-- FAIRE VARIABLED LE SELECTED DES INPUTS -->

        <div class="form-group col-md-2">
            <label for="public_m">Public</label>
            <div class="custom-control custom-radio">
                <input type="radio" id="public_m" name="public" class="custom-control-input" value="m" checked="">
                <label class="custom-control-label" for="public_m">Male</label>
            </div>
        </div>
        <div class="form-group col-md-2">
            <label for="public_f" style="color:transparent">Public</label>
            <div class="custom-control custom-radio">
                <input type="radio" id="public_f" name="public" class="custom-control-input" value="f">
                <label class="custom-control-label" for="public_f">Female</label>
            </div>
        </div>

        <div class="custom-file mb-5">

            <input type="file" class="custom-file-input" id="myPicture" name="myPicture">
            <label class="custom-file-label" for="myPicture">Choose a picture</label>
            <?php if (isset($_GET["action"]) && $_GET["action"] == "modifier") { ?>
                <div>
                    <img width="50px" src="<?= $picture; ?>" alt="<?= $title; ?>">
                </div>
            <?php } ?>
        </div>
        <div class="form-group col-md-12">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" value="<?= $description; ?>">
        </div>

        <?php if (isset($_GET["action"]) && $_GET["action"] == "modifier") { ?>
            <button type="submit" class="btn btn-secondary" name="modifyProduct">Modify a product</button>
        <?php } else { ?>
            <button type="submit" class="btn btn-secondary" name="addProduct">Add a product</button>
        <?php } ?>

    </div>

</form>


<?php
require_once("inc/footer.php");
?>