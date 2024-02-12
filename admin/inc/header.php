<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="inc/css/style.css">
    <title>Document</title>
</head>
<body>

    <div class="container-flud">

        <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-end">
            <a class="navbar-brand" href="index.php">
                <img src="https://getbootstrap.com/docs/4.4/assets/brand/bootstrap-solid.svg" width="30" height="30" class="d-inline-block align-top" alt="">
            Shopping Project
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- Si je ne suis pas connecté j'affiche les pages connexion/inscription -->

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="products.php">Management of products</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="orders.php">Management of orders</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Shop</a>
                    </li>

                    <!-- Si l'internaute est connecté j'affiche le bouton de déconnexion -->

                        <li class="nav-item">
                            <a class="nav-link font-italic" href="../connexion.php?action=deconnexion">
                                Disconnection
                            </a>
                        </li>

                    <form class="form-inline my-2 my-lg-0" method="get" action="products.php">
                        <input class="form-control mr-sm-2" type="search" name="key_word" placeholder="Enter a key word" aria-label="Search">
                        <button class="btn btn-dark my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </ul>
            </div>
        </nav>

        <main class="bg-light p-5">
            <div class="row col-md-10 mx-auto justify-content-center">
