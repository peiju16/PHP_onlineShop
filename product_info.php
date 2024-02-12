<?php

    require_once("inc/init.php");

    if(isset($_GET["id_product"])) {
        $id_product = $_GET["id_product"];
        $stmt = $pdo->query("SELECT * FROM products WHERE id_product = '$id_product'");
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        header("location:index.php");
    }

    require_once("inc/header.php");

?>

<div class="card col-md-4">
    <img src="<?= $product["picture"]; ?>" class="card-img-top" alt="<?= $product["title"]; ?>" style="<?= $product["stock"] <= 0 ? "opacity:0.5;" : "" ; ?>">
    <div class="card-body">
        <h5 class="card-title"><?= $product["title"]; ?></h5>
        <p class="card-text"><?= $product["description"]; ?></p>
    </div>
</div>

<div class="col-md-4">
    <ul class="list-group">
        <li class="list-group-item">Category : <?= $product["category"]; ?></li>
        <li class="list-group-item">Color : <?= $product["color"]; ?></li>
        <li class="list-group-item">Size : <?= $product["size"]; ?></li>
        <li class="list-group-item">Price : <?= $product["price"]; ?>€</li>

        <form method="POST" action="cart.php">
            <input type="hidden" name="id_product" value="<?= $product["id_product"]; ?>">
            <input type="hidden" name="category" value="T-shirt">
            <li class="list-group-item">
                <p>Quantity :</p>
                <select name="quantity" class="custom-select" id="selectQuantity">
                    <option selected="" disabled>Choose Quantity</option>

                    <?php for($i = 1; $i < $product["stock"]; $i++) { ?>
                        <option value="<?= $i; ?>"><?= $i; ?></option>
                    <?php } ?>
                    
                </select>
            </li>

            <input name="add_product" type="submit" id="addToCart" class="btn btn-outline-secondary mt-5 w-100" value="Add to cart" disabled>

        </form>

    </ul>
</div>

<?php
require_once("inc/footer.php");
?>