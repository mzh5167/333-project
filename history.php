<?php
session_start();
if (!isset($_SESSION['userId'])) {
  header('location:login.php');
}
?>

<?php require 'html/document_before.php'; ?>

<body>
  <div class="container mt-5">
    <?php
    require 'connection.php';

    try {
      $stmt = $db->prepare("SELECT * FROM reservation WHERE uid = ? ORDER BY date DESC");
      $stmt->bindValue(1, $_SESSION['userId']);
      $stmt->execute();
      $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
      $db->rollBack();
    }
    foreach ($r as $rev) {
      extract($rev);
    ?>
      <div class="row border rounded m-1">
        <div class="col-10">
          <h5>Place ID??name:
            <?php echo $pid ?>
          </h5>
          <h5>Date:
            <?php echo $date ?>
          </h5>
          <h5>Start Time:
            <?php echo $time ?>
            oclock
          </h5>
          <h5>Hours:
            <?php echo $hours ?>
            hr
          </h5>
        </div>
        <div class="col-2">
          <form action="rate.php" method="post" class="mt-4">
            <select class="form-select" name="rating">
              <?php
              for ($i = 5; $i >= 1; $i--) {
                $s = $i == $rating ? "selected" : "";
                echo "<option value='$i' $s>$i</option>";
              }
              ?>
            </select>
            <input type="hidden" name="rid" value="<?php echo $rid ?>">
            <input type="submit" value="<?php echo ($rating == null ? "Rate" : "Update"); ?>">
          </form>
        </div>
      </div>
    <?php } ?>
  </div>

</body>
<?php require 'html/document_after.php'; ?>
