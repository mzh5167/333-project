<?php
include('connection.php');
try {
  $error = 0;

  $sql = "SELECT p.pid,p.name,p.category,p.price,p.image,AVG(rating)
  FROM places p
   LEFT JOIN reservation r
    ON p.pid = r.pid
    GROUP BY p.pid;";

  $query = $db->prepare($sql);
  $query->execute();

  //if user click on apply button in filter
  if (isset($_POST['aplay'])) {
    $str_categ = "'gaming','vr','billiard','room'";
    $usr_categ = "";
    $min = $_POST['min'];
    $max = $_POST['max'];
    if ($min > $max) {
      $temp = $max;
      $max = $min;
      $min = $temp;
    }
    $num = "/^[1-9]{1}[0-9]{0,}$/";
    if (((preg_match($num, $min)) && (preg_match($num, $min)))) {
      //check if user checked on unchaked any category
      if (isset($_POST['categories'])) {
        foreach ($_POST['categories'] as $category) {

          $details = explode("#", $category);
          $name[] = $details[1];
        }
        foreach ($name as $n) {
          $usr_categ .= '\'' . $n . '\',';
        }
        $newString = "''";
        $str_categ = $usr_categ . $newString;
      } //end post category

      //query for filter
      $sql = "SELECT p.pid,p.name,p.category,p.price,p.image,AVG(rating)
      FROM places p
       LEFT JOIN reservation r
        ON p.pid = r.pid
        WHERE category IN ($str_categ) AND price>=? AND price<=?
        GROUP BY p.pid";
      $query = $db->prepare($sql);

      $query->execute(array($min, $max));
    }
  } //end apply-filter

  // livesearch
  if (isset($_POST['submit-search'])) {

    $pattern = '/^[a-zA-Z0-9_.-]{4,30}$/';

    if (preg_match($pattern, $_POST['search-val'])) {
      $searchValue = $_POST['search-val'];

      $sql = "SELECT p.pid,p.name,p.category,p.price,p.image,AVG(rating)
FROM places p
 LEFT JOIN reservation r
  ON p.pid = r.pid
  WHERE name = ?
  GROUP BY p.pid";

      $query = $db->prepare($sql);
      $query->bindParam(1, $searchValue);
      $query->execute();
    }
    if (!($query->rowCount() == 0)) {
      $error = 0;
    } else {
      $error = 1;
    }
  }


  //if user selected category from home
  if (isset($_GET['cateroy'])) {
    $cat = $_GET['cateroy'];
    $sql = "SELECT p.pid,p.name,p.category,p.price,p.image,AVG(rating)
        FROM places p
        LEFT JOIN reservation r
        ON p.pid = r.pid
        WHERE category = ?
        GROUP BY p.pid";


    $query = $db->prepare($sql);
    $query->bindParam(1, $cat);
    $query->execute();
  }
} // and try


catch (PDOException $e) {
  die($e->getMessage());
}
