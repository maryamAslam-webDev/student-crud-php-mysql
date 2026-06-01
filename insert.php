<?php
include "db.php";
$editMode = false;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $fName = trim($_POST["fName"]);
    $age = trim($_POST["age"]);
    $class = trim($_POST["class"]);
    $phone = trim($_POST["phone"]);
    $address = trim($_POST["address"]);
    $email = trim($_POST["email"]);
    $gender = trim($_POST["gender"]);
    if (empty($name) || empty($fName) || empty($age) || empty($class) || empty($phone) || empty($address) || empty($gender)) {
        die("All fields required");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid Email");
    }
    if ($age < 5 || $age > 100) {
        die("Invalid age");
    }
    if (empty($_POST['id'])) {
        $stmt = $con->prepare("INSERT into students (name, fName, age, class, phone, address, email, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisssss", $name, $fName, $age, $class, $phone, $address, $email, $gender);
    } else {
        $stmt = $con->prepare("UPDATE students SET name=?, fName=?, age=?, class=?, phone=?, address=?, email=?, gender=? WHERE id=?");
        $stmt->bind_param("ssisssssi", $name, $fName, $age, $class, $phone, $address, $email, $gender, $_POST['id']);
    }
    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo $stmt->error;
    }
}
