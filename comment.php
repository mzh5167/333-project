<?php
session_start();
require_once 'util/access.php';
customer_only();

if (!isset($_POST["pid"])) {
    header("location:history.php");
    die();
}
if (!isset($_POST["comment"])) {
    header("location:history.php");
    die();
}

require("connection.php");
try {
    $stmt = $db->prepare("INSERT INTO comments VALUES (null, ?, ?, ?)");
    $stmt->bindValue(1, $_POST['pid']);
    $stmt->bindValue(2, $_SESSION['userId']);
    $stmt->bindValue(3, htmlentities($_POST['comment']));
    $stmt->execute();
} catch (PDOException $ex) {
    $db->rollBack();
}

header("location:view.php?pid={$_POST['pid']}");
?>
