<?php

require_once("inc/init.php");



// deconnexion
if(isset($_GET["action"]) && $_GET["action"] == "disconnection") {
    unset($_SESSION["user"]);
}

if($_POST) {

    $pseudo = $_POST["pseudo"];
    $pwd = $_POST["pwd"];

    $stmt = $pdo->query("SELECT * FROM members WHERE pseudo = '$pseudo'");
    $infos = $stmt->fetch(PDO::FETCH_ASSOC);

    if(password_verify($pwd, $infos["password"])) {

        // créer ma sesssion user
        $_SESSION["user"]["pseudo"] = $infos["pseudo"];
        $_SESSION["user"]["first_name"] = $infos["first_name"];
        $_SESSION["user"]["name"] = $infos["name"];
        $_SESSION["user"]["city"] = $infos["city"];
        $_SESSION["user"]["postal_code"] = $infos["postal_code"];
        $_SESSION["user"]["sexe"] = $infos["sexe"];
        $_SESSION["user"]["email"] = $infos["email"];
        $_SESSION["user"]["address"] = $infos["address"];
        $_SESSION["user"]["status"] = $infos["status"];
        $_SESSION["user"]["id_member"] = $infos["id_member"];

        header("location:profile.php");

    } else {
        $content = "<div>
            Erreur de pseudo ou password !
        </div>"; 
    }



}

require_once("inc/header.php");
?>

<!-- Body content -->

<?= $content; ?>

<div class="col-md-12">
    <h3 class="text-center mb-5"> Get connected to access your profile !</h3>
</div>

<div class="col-md-5">
    <form method="POST" action="">
        <div class="form-group">
            <label for="pseudo">Pseudo:</label>
            <input type="text" name="pseudo" class="form-control" id="pseudo" aria-describedby="pseudo" placeholder="Enter your pseudo">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="pwd" class="form-control" id="password" placeholder="Enter your password">
        </div>
        <button type="submit" class="btn btn-dark">Connection</button>
    </form>
</div>


<?php
require_once("inc/footer.php");
?>