<?php
require_once("inc/init.php");

// si je clique sur une commande
// je vais accéder au détails de la commande
// tous les produits associés à la commande
// afficher le montant total de commande

if (isset($_GET["id_order"])) {
  
} else {
    header("location:profile.php");
    exit();
}

if (isset($_GET["action"]) && $_GET["action"] == "orderDetails") {
    $id_order = $_GET["id_order"];
    $stmt = $pdo->query("SELECT * FROM products INNER JOIN order_details ON order_details.id_product = products.id_product INNER JOIN orders ON orders.id_order = order_details.id_order WHERE orders.id_order = '$id_order'");
    $stmt2 = $pdo->query("SELECT * FROM orders WHERE id_order = '$id_order'");
    $order = $stmt2->fetch(PDO::FETCH_ASSOC);
}


require_once("inc/header.php");
?>


<table class="table my-5">
    <thead>
        <tr>
            <th scope="col">Title</th>
            <th scope="col">Quantity</th>
            <th scope="col">Price</th>
            <th scope="col">Photo</th>
            <th scope="col">State</th>
        </tr>
    </thead>
    <tbody>

        <?php while ($orderDetail = $stmt->fetch(PDO::FETCH_ASSOC)) {  ?>
            <tr>
                    <td>
                        <?= $orderDetail["title"]; ?>
                    </td>
                    <td>
                        <?= $orderDetail["quantity"]; ?>
                    </td>
                    <td>
                        <?= $orderDetail["price"];; ?>
                    </td>
                    <td> <img style="width:100px" src="<?= $orderDetail["picture"];; ?>"
                            alt="<?= $orderDetail["title"];; ?>"> </td>
                    <td> <?= $orderDetail["state"]; ?> </td>
            </tr>

         <?php } ?>

         <tr>

         <td colspan="5" style="text-align:right">Montant Total :
                    <?= $order["amount"]; ?> €
                </td>

         </tr>

                


    </tbody>
</table>



<?php
require_once("inc/footer.php");
?>