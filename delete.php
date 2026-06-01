<?php
include "db.php";
if (isset($_GET['id'])) {
    $id = $_GET["id"];
    $stmt = $con->prepare("DELETE FROM students WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: index.php");
}
