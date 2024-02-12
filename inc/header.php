<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>

<body>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">
                <img src="https://getbootstrap.com/docs/4.6/assets/brand/bootstrap-solid.svg" width="30" height="30" class="d-inline-block align-top" alt="">
                Bootstrap Online Shop
            </a> <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto flex justify-content-end" id="navBar">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Shop <span class="sr-only">(current)</span></a>
                    </li>
                        <?php if (!isUserConnected()) { ?>
                            <li class="nav-item">
                            <a class="nav-link" href="connection.php">Connection</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="registration.php">Registration</a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="profile.php">My profile</a>
                            </li>
                        <?php } ?>


                    <li class="nav-item position_relative">
                        <span class="number_elem_in_cart"><?= isset($_SESSION["panier"]) ? totalProduitsPanier() : "" ?></span>
                        <a class="nav-link" href="cart.php">My cart</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="connection.php?action=disconnection">Disconnection</a>
                    </li>

                    <?php if(isUserAdminAndConnected()) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="admin/index.php">BackOffice</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </nav>

        <main class="bg-light p-5">
            <div class="row col-md-10 mx-auto justify-content-center">