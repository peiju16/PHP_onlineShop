<?php

require_once("inc/init.php");

if (!isset($_SESSION["user"])) {
    header("location:connection.php");
    exit(); // vous assurer que le code après n'est pas exécuté
}

$pseudo = $_SESSION["user"]["pseudo"];
$stmt = $pdo->query("SELECT * FROM members WHERE pseudo = '$pseudo'");
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt2 = $pdo->query("SELECT * FROM orders INNER JOIN members ON orders.id_member = members.id_member WHERE pseudo = '$pseudo'");


var_dump($user);


require_once("inc/header.php");
?>

<div class="col-md-12 mb-5">
    <h2 class="text-center">Hi
        <?= $user["first_name"] . " " . $user["name"]; ?> , welcome to your profile !
    </h2>
</div>

<div class="card col-md-4">
    <?php if ($user["sexe"] == "m") { ?>
        <img src="pictures/avatar_male.png" class="card-img-top" alt="profil de <?= $user["pseudo"]; ?>">
    <?php } else { ?>
        <img src="pictures/avatar_female.png" class="card-img-top" alt="profil de <?= $user["pseudo"]; ?>">
    <?php } ?>

    <div class="card-body">
        <h5 class="card-title">
            <?= $user["first_name"]; ?>
        </h5>
    </div>

    <ul class="list-group list-group-flush">
        <li class="list-group-item text-center">
            <?= $user["email"]; ?>
        </li>
        <li class="list-group-item text-center">
            <?= $user["address"]; ?>
        </li>
        <li class="list-group-item text-center">
            <?= $user["postal_code"]; ?>
        </li>
    </ul>
</div>

<div class="col-md-4">
    <ul class="list-group">
        <li class="list-group-item text-center">
            <h5>My orders</h5>
        </li>

    </ul>

    <ul class="list-group mt-5">
        <li class="list-group-item text-center">
            <h5>All my orders</h5>
        </li>


        <?php while ($UserOrder = $stmt2->fetch(PDO::FETCH_ASSOC)) { ?>

            <a href="order-details.php?action=orderDetails&id_order= <?= $UserOrder["id_order"]; ?>">
                <li class="list-group-item text-center">


                    <p>Order n°
                        <?= $UserOrder["id_order"]; ?> from the
                        <?= $UserOrder["date"]; ?>
                    </p>
                    <!-- // afficher toutes les commandes dans la page profile
                    // si une commande est in progress => badge orange
                    // sent badge vert
                    // delivered badger black -->

                    <?php if ($UserOrder["state"] == "in progress") {
                        echo "<p class='badge badge-warning'>" . $UserOrder['state'];
                    } elseif ($UserOrder["state"] == "sent") {
                        echo "<p class='badge badge-success'>" . $UserOrder['state'];
                    } else {
                        echo "<p class='badge badge-dark'>" . $UserOrder['state'];
                    } ?>

                    </p>


                <?php } ?>


            </li>
        </a>
    </ul>
</div>

<?php
require_once("inc/footer.php");
?>