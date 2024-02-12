<?php

    function montantTotalPanier() { 

        $total = 0;

        for($i=0; $i < count($_SESSION["panier"]["id_product"]); $i++) {
            $total += $_SESSION["panier"]["price"][$i] * $_SESSION["panier"]["quantity"][$i];
        }

        return $total;
    }

    function totalProduitsPanier() { 

        $quantity = 0;
        

        for($i=0; $i < count($_SESSION["panier"]["id_product"]); $i++) {
            
            $quantity +=  $_SESSION["panier"]["quantity"][$i];
        }

        return $quantity;
    }
    function create_session_panier() {

        // si la session panier elle existe pas je la créé si elle existe je fais rien

        if(!isset($_SESSION["panier"])) {
            $_SESSION["panier"]["id_product"] = array();
            $_SESSION["panier"]["quantity"] = array();
            $_SESSION["panier"]["price"] = array();
            $_SESSION["panier"]["title"] = array();
            $_SESSION["panier"]["photo"] = array();
            $_SESSION["panier"]["stock"] = array();
        }

    }

    function ajouter_produit_panier($id_product, $quantity, $price, $title, $photo, $stock) {

        create_session_panier();

        // si le produit est déjà en session (déjà dans le panier)
        // incrémenter la quantité pour ce produit
        $positionProduct = array_search($id_product, $_SESSION["panier"]["id_product"]);

        // je l'ai déja dans mon panier
        if($positionProduct !== false) {
            $_SESSION["panier"]["quantity"][$positionProduct] += $quantity;
        } else {

            // sinon
            // j'ajoute le produit au panier
    
            $_SESSION["panier"]["id_product"][] = $id_product;
            $_SESSION["panier"]["quantity"][] = $quantity;
            $_SESSION["panier"]["price"][] = $price;
            $_SESSION["panier"]["title"][] = $title;
            $_SESSION["panier"]["photo"][] = $photo;
            $_SESSION["panier"]["stock"][] = $stock;
            
        } 

    }

    function retirerProduitPanier($id_product) {

        $positionProduct = array_search($id_product, $_SESSION["panier"]["id_product"]);

        if($positionProduct !== false) {
    
            unset($_SESSION["panier"]["id_product"][$positionProduct]);
            unset($_SESSION["panier"]["quantity"][$positionProduct]);
            unset($_SESSION["panier"]["price"][$positionProduct]);
            unset($_SESSION["panier"]["title"][$positionProduct]);
            unset($_SESSION["panier"]["photo"][$positionProduct]);
            unset($_SESSION["panier"]["stock"][$positionProduct]);

            // va falloir remettre en ordre croissant les index de mes tableaux
            // array_values
            $_SESSION["panier"]["id_product"] = array_values($_SESSION["panier"]["id_product"]);
            $_SESSION["panier"]["quantity"] = array_values($_SESSION["panier"]["quantity"]);
            $_SESSION["panier"]["price"] = array_values($_SESSION["panier"]["price"]);
            $_SESSION["panier"]["title"] = array_values($_SESSION["panier"]["title"]);
            $_SESSION["panier"]["photo"] = array_values($_SESSION["panier"]["photo"]);
            $_SESSION["panier"]["stock"] = array_values($_SESSION["panier"]["stock"]);
        } 
    }

    function isUserConnected() {

        if(isset($_SESSION['user'])) {
            return true;
        } 

        return false;


    }


    function isUserAdminAndConnected() {
        if(isUserConnected() && $_SESSION["user"]["status"] == 1) {
            return true;
        }

        return false;
    }

?>