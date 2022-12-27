<?php
session_start();
if (!isset($_SESSION['userId'])) {
  header('location:login.php');
}
require 'html/document_before.php';
require("connection.php");
try {
  $stmt = $db->prepare("SELECT * FROM reservation r 
            INNER JOIN places p 
            on r.pid = p.pid 
            WHERE uid = ?
            ORDER BY rid DESC");
  $stmt->bindValue(1, $_SESSION['userId']);
  $stmt->execute();
  $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
  $db->rollBack();
}
?>

<body>
  <div class="container mt-5">
    <div class="container my-5">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a href="./home.php" class="nav-link">Home /</a>
        </li>
        <li class="nav-item">
          <p class="nav-link"> My History</p>
        </li>
      </ul>

      <?php foreach ($r as $rev) {
        extract($rev);
      ?>
        <div class="card">
          <h5 class="card-header">Reservation ID: #<?php echo $rid; ?></h5>
          <div class="card-body">
            <a href="view.php?pid=<?php echo $pid ?>">
              <h5 class="card-title"><?php echo $name ?></h5>
            </a>
            <p class="card-text">Date: <?php echo $date ?></p>
            <p class="card-text">Start time: <?php echo $time ?>:00</p>
            <p class="card-text">Number of hours: <?php echo $hours ?>hr</p>
            <form action="rate.php" method="post">
              <?php
              if ($date < date("Y-m-d")) {
                $msg = $rating == null ? "Rate" : "Update Rating";
                // echo "<a href='addcomment.php?pid=$pid' class='btn btn-primary'>Add Comment</button></a>";
                echo "<input type='hidden' name='rid' value='$rid'>";
                echo "<select class='form-select m-auto' name='rating'>";
                for ($i = 5; $i != 0; $i--) {
                  $selected = $i == $rating ? "selected" : "";
                  echo "<option $selected >$i </option>";
                }
                echo "</select>";
                echo "<button class='btn btn-primary' type='submit' $dis>$msg</button>";
              }
              ?>
            </form>
          </div>
        </div>
        <br>
      <?php
      }
      ?>
    </div>
  </div>
  </div>
</body>

<?php require("html/document_after.php") ?>
