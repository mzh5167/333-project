<?php
require('connection.php');
try {
  if (isset($_POST['input'])) {
    $input = $_POST['input'];

    $sql = "SELECT * FROM places WHERE name LIKE ?;";
    $query = $db->prepare($sql);
    $query->bindValue(1, "%$input%");

    $query->execute();

    if ($query->rowCount() > 0) {
      foreach ($query as $value) {
        echo "<button type='button' class='list-group-item list-group-item-action dropdown-item'>$value[1]</button>";
      }
    } else {
      echo "<p class='list-group-item borded-1'>No matching key word found :(</p>";
    }
  }
} // and try

catch (PDOException $e) {
  die($e->getMessage());
}
