<?php
require_once("inc/init.php");

$stmt = $pdo->query("SELECT DISTINCT(category) FROM products");
// var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));


if (isset($_GET["category"])) {

    $category = $_GET["category"];
    $stmt2 = $pdo->query("SELECT * FROM products WHERE category = '$category'");


}


require_once("inc/header.php");
?>

<!-- Body content -->

<div class="col-md-3">
    <ul class="list-group">

        <?php while ($category = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <li class="list-group-item">
                <a class="text-dark" href="?category=<?= $category["category"]; ?>">
                    <?= $category["category"]; ?>
                </a>
            </li>
        <?php } ?>

    </ul>
</div>

<div class="row col-md-9">

    <?php if(isset($_GET["category"])) {

        while ($product = $stmt2->fetch(PDO::FETCH_ASSOC)) { ?>

            <div class="col-md-4 pr-2 pl-2 pb-2">
                <div class="card">
                    <?php if ($product['stock'] == 0) { ?>
                        <div class="badge badge-danger">Produit indisponible</div>
                    <?php } ?>
                    <!-- $product['stock'] == 0 ? 'unavailable' : ''; -->
                    <img src="<?= $product["picture"]; ?>" class="card-img-top" 
                        alt="<?= $product["description"]; ?>" style="<?= $product["stock"] <= 0 ? "opacity:0.5;" : "" ; ?>">
                    <div class="card-body">
                        <h5 class="card-title text-center">
                            <?= $product["title"]; ?>
                        </h5>
                        <p class="card-text text-center">
                            <?= $product["description"]; ?>
                        </p>
                        <a href="product_info.php?id_product=<?= $product["id_product"]; ?>"
                            class="btn btn-dark d-flex justify-content-center">See
                            product</a>
                    </div>
                </div>
            </div>

        <?php }
    } ?>

</div>

<?php
require_once("inc/footer.php");
?>