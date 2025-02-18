<?php

require_once "connexion.php";


if(isset($_POST["id"])) {
    $id = strip_tags($_POST["id"]);


    $q = $db->prepare("DELETE FROM students WHERE id = :id");
    $q->bindParam(":id", $id, PDO::PARAM_INT);
    $q->execute();

    header("location: index.php");
}





