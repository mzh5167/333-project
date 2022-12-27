<?php
require('connection.php');
try {
  if (isset($_POST['input'])) {
    $input = $_POST['input'];

    $query = $db->query("SELECT * FROM places WHERE name LIKE '%{$input}%'");

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
