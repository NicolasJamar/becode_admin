<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once "connexion.php";

// open the $_SESSION
session_start();


if(!empty($_POST)) {
    // 1. Check all the inputs exist
    // 2. We check also if the $_POST are not empty because we load the page, the form is empty
    if(isset($_POST["firstname"],$_POST["lastname"],$_POST["promo"])
        && !empty($_POST["firstname"]) && !empty($_POST["lastname"]) && !empty($_POST["promo"])) {

        $firstname = strip_tags($_POST["firstname"]);
        $lastname = strip_tags($_POST["lastname"]);
        $id_promo = (int) $_POST["promo"];

        //SQL part
        $q = $db->prepare("INSERT INTO students(firstname, lastname, ID_promo) VALUES(:firstname, :lastname, :id_promo)");

        // bindParam() accepte uniquement une variable qui est interprétée au moment de l'execute()
        $q->bindParam(":firstname", $firstname, PDO::PARAM_STR);
        $q->bindParam(":lastname", $lastname, PDO::PARAM_STR);
        $q->bindParam(":id_promo", $id_promo, PDO::PARAM_INT);

        // exexute return a boolean
        if(!$q->execute()) {
            die("form not sent to the db");
        }

        header("location: index.php");
        exit;

    }
}

// Request for promos
$q_promo = $db->prepare("SELECT * FROM promos");
$q_promo->execute();
$promos = $q_promo->fetchAll(PDO::FETCH_ASSOC);

// HTML
include "includes/header.php";

?>


<h1>Add Student</h1>

    <form method="post" action="">
        <div>
            <label for="firstname">Firstname :</label>
            <input type="text" name="firstname">
        </div>
        <div>
            <label for="lastname">Lastname :</label>
            <input type="text" name="lastname">
        </div>
        <div>
            <label for="promo">Promo :</label>
            <select name="promo">
                <?php foreach ($promos as $promo) : ?>
                    <option value="<?= $promo["ID"] ?>" selected><?= $promo["name"] ?></option>
                <?php endforeach;?>
            </select>
        </div>
        <button type="submit">Add Student</button>
    </form>



<?php
    include "includes/footer.php";
?>
