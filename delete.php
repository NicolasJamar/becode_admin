<?php

require_once "connexion.php";

    var_dump($_POST);

if(isset($_POST["id"])) {
    $id = $_POST["id"];


    $q = $db->prepare("DELETE FROM students WHERE id = :id");
    $q->bindParam(":id", $id, PDO::PARAM_INT);
    $q->execute();

    header("location: index.php");
}





