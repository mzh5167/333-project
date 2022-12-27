<?php
try {
  $db = new PDO('mysql:host=localhost;dbname=333_project_jaafar;charset=utf8', 'root', '');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die($e->getMessage());
}
