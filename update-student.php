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
        $q = $db->prepare("UPDATE students SET firstname= :firstname, lastname= :lastname, ID_pormo= :id_promo)");

        // bindParam() accepte uniquement une variable qui est interprétée au moment de l'execute()
        $q->bindParam(":firstname", $firstname, PDO::PARAM_STR);
        $q->bindParam(":lastname", $lastname, PDO::PARAM_STR);
        $q->bindParam(":id_promo", $id_promo, PDO::PARAM_INT);

        // exexute return a boolean
        if(!$q->execute()) {
            die("form not sent to the db");
        }

        header("location: student.php?id=$_GET[id]");
        exit;

    }
}

if(isset($_GET["id"])) {
    $id = $_GET["id"];

    $q = $db->prepare("SELECT * FROM students WHERE id = :id");
    $q->bindParam(":id", $id, PDO::PARAM_INT);
    $q->execute();
    $student = $q->fetch();
}

// Request for promos
$q_promo = $db->prepare("SELECT * FROM promos");
$q_promo->execute();
$promos = $q_promo->fetchAll(PDO::FETCH_ASSOC);

// HTML
include "includes/header.php";

?>


<h1>Update Student</h1>

    <form method="post" action="">
        <div>
            <label for="firstname">Firstname :</label>
            <input type="text" name="firstname" placeholder="<?= $student["firstname"] ?>">
        </div>
        <div>
            <label for="lastname">Lastname :</label>
            <input type="text" name="lastname" placeholder="<?= $student["lastname"] ?>">
        </div>
        <div>
            <label for="promo">Promo :</label>
            <select name="promo">
                <?php foreach ($promos as $promo) :
                    if($student["ID_promo"] === $promo["ID"]) : ?>
                        <option selected value="<?= $student["ID_promo"] ?>"><?= $promo["name"] ?></option>
                        <?php else : ?>
                        <option value="<?= $promo["ID"] ?>"><?= $promo["name"] ?></option>
                <?php
                    endif;
                endforeach;?>
            </select>
        </div>
        <button type="submit">Update Student</button>
    </form>



<?php
    include "includes/footer.php";
?>
