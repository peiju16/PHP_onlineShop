<?php
require_once("inc/init.php");
// unset($_SESSION);

// echo '<pre>';
// var_dump(
//     $_SESSION["panier"]
// );
// echo '</pre>';

if (isset($_POST["payer"])) {

    $error = false;

    for ($i = 0; $i < count($_SESSION["panier"]["id_product"]); $i++) {

        // récupérer les infos en BDD pour le produit dans le panier pour vérifier que j'ai encore du stock
        $id = $_SESSION["panier"]["id_product"][$i];
        $stmt = $pdo->query("SELECT * FROM products WHERE id_product = '$id'");
        $infos = $stmt->fetch(PDO::FETCH_ASSOC);


        // si je plus de stock pour un produit
        // je vais devoir l'enlever du panier
        if ($infos['stock'] <= 0) {
            $error = true;
            $content .= "<div class='alert alert-warning'>
                Le produit intitulé ' $infos[title] ' n'est plus disponible et a été retiré de votre panier
            </div>";
            // enlever le produit du panier

            retirerProduitPanier($id);

        } else {
            // sinon si j'ai encore du stock mais que
            // j'ai pas assez de stock par rapport à la quantité que je souhaite
            // faut que je mette à jour ma session panier avec la quantité max que je peux prendre

            if ($infos['stock'] < $_SESSION["panier"]["quantity"][$i]) {
                $error = true;

                $content .= "<div class='alert alert-warning'>
                    Les quantités sélectionnées pour le produit intitulé ' $infos[title] ' a été mise à jour dans votre panier!
                </div>";

                // je mets à jour le panier pour le produit de l'itération
                // avec le stock dispo actuellement
                $_SESSION["panier"]["quantity"][$i] = $infos['stock'];

            }

        }

    }

    if (!$error) {

        $totalAmount = montantTotalPanier();
        $idMember = $_SESSION["user"]["id_member"];
        $count = $pdo->exec("
        INSERT INTO orders(amount, date, state, id_member)
        VALUES( '$totalAmount', NOW(), 'sent', $idMember )");

        $idOrder = $pdo->lastInsertId();

        // je créé une commande
        // sinon j'affiche les messages d'erreur

        for ($i = 0; $i < count($_SESSION["panier"]["id_product"]); $i++) {

            $idProduct = $_SESSION["panier"]["id_product"][$i];
            $quantity = $_SESSION["panier"]["quantity"][$i];
            $price = $_SESSION["panier"]["price"][$i];

            $pdo->exec("INSERT INTO order_details(id_order, id_product, quantity, price)
            VALUES('$idOrder', '$idProduct', '$quantity', '$price' )");

            // mettre  à jour les quantités en BDD
            $pdo->exec("UPDATE products SET stock = stock - $quantity WHERE id_product = '$idProduct'");

        }

        if ($count >= 1) {
            $content = "<div class='alert alert-success'>
                Votre commande a bien été enregistrée avec le numéro de commande n° $idOrder
            </div>";

            unset($_SESSION["panier"]); // je vide le panier après confirmation
        }

    }


}


// Afficher le montant total à payer
// faudrait ajouter un bouton payer si je suis connecté
// gérer le paiement et vérifier si au moment du paiement, les produits sont encore dispo
// si un produit est plus dispo, faudra l'enlever du panier
// et le dire à l'internaute
// si un produit est encore dispo mais les quanités sont moindres faudra mettre à jour
// la quantité selectionnée pour ce produit (t'en veux 4, il est 2, faut mettre à jour le panier avec 2)
// si pas de soucis de stock au moment du paiement
// créer une commande et détails de commande en BDD


///
/// AJOUT D'UN PRODUIT DANS MON PANIER
///

if (isset($_POST["add_product"])) {

    // récupérer les infos du produit à ajouter au panier
    $stmt = $pdo->query("SELECT * FROM products WHERE id_product = '$_POST[id_product]'");
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // les ajouter à ma session
    ajouter_produit_panier($product["id_product"], $_POST["quantity"], $product["price"], $product["title"], $product["picture"], $product["stock"]);

    // echo '<pre>';
    // var_dump($_SESSION["panier"]);
    // echo '</pre>';

}

if (isset($_GET["action"]) && $_GET["action"] == "viderPanier") {

    unset($_SESSION["panier"]);
    $content = "<div class='alert alert-success'>
        Votre panier a été vidé!
    </div>";

}

if (isset($_GET["action"]) && $_GET["action"] == "suppression") {

    $id_product = $_GET['id_product'];
    retirerProduitPanier($id_product);

}


require_once("inc/header.php");
?>

<?= $content; ?>

<table class="table my-5">
    <thead>
        <tr>
            <th scope="col">Title</th>
            <th scope="col">Quantity</th>
            <th scope="col">Price</th>
            <th scope="col">Photo</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>

        <?php if (isset($_SESSION["panier"]) && count($_SESSION["panier"]["id_product"]) > 0) {

            for ($i = 0; $i < count($_SESSION["panier"]["id_product"]); $i++) { ?>

                <tr>
                    <td>
                        <?= $_SESSION["panier"]["title"][$i]; ?>
                    </td>
                    <td>
                        <?= $_SESSION["panier"]["quantity"][$i]; ?>
                    </td>
                    <td>
                        <?= $_SESSION["panier"]["price"][$i]; ?>
                    </td>
                    <td> <img style="width:100px" src="<?= $_SESSION["panier"]["photo"][$i]; ?>"
                            alt="<?= $_SESSION["panier"]["title"][$i]; ?>"> </td>
                    <td> <a class="badge-warning badge"
                            href="?action=suppression&id_product=<?= $_SESSION["panier"]["id_product"][$i]; ?>">Supprimer du
                            panier</a> </td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="5" style="text-align:right">Montant Total :
                    <?= montantTotalPanier(); ?> €
                </td>
            </tr>
        <?php } else { ?>
            <tr>
                <td colspan="3">Your cart is empty !</td>
            </tr>
        <?php } ?>


    </tbody>
</table>

<div class="col-md-12">
    <a class="badge badge-dark" href="index.php"> Go back to catalogue </a>
    <?php if (isset($_SESSION["panier"]) && count($_SESSION["panier"]["id_product"]) > 0) { ?>
        <a class="badge badge-danger" href="?action=viderPanier"> Vider le panier </a>
    <?php } ?>

</div>

<div class="d-flex justify-content-end col-md-12">
    <form action="" method="POST">
        <input type="submit" name="payer" value="Pay" class="btn btn-outline-secondary">
    </form>
</div>

<?php
require_once("inc/footer.php");
?>