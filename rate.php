<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("location:login.php");
}
if (!isset($_POST["rid"])) {
    header("location:history.php");
}
if (!preg_match("/^[12345]$/", $_POST['rating'])) {
    header("location:history.php");
}
require 'connection.php';
try {
    $stmt = $db->prepare("UPDATE reservation SET rating = ? WHERE rid = ?");
    $stmt->bindValue(1, $_POST['rating']);
    $stmt->bindValue(2, $_POST['rid']);
    $stmt->execute();
} catch (PDOException $ex) {
    $db->rollBack();
}
header("location:history.php");
