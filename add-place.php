<?php
require('connection.php');
require('util/place-input.php');
$showStatus = false;
if (isset($_POST['new'])) $switch = NULL;
else $switch = "=";
if (isset($_POST['new']) || isset($_POST['new_f'])) {
  $actionf = "new_f";
  $action = "Add Place";
  $title = "added";
  $sql = $db->prepare("INSERT INTO places (`name`,`description`,`address`,`location`,`price`,`category`,`image`) VALUES (?,?,?,?,?,?,?)");
  $name = NULL;
  $desc = NULL;
  $adrs = NULL;
  $adrsFields = NULL;
  for ($i = 0; $i < 4; $i++) $adrsFields[$i] = NULL;
  $loca = NULL;
  $price = NULL;
  $cate = NULL;
  $img = NULL;
  $keepImg = false;
} else if (isset($_POST['edit'])) {
  $actionf = "edit_f";
  $action = "Update Details";
  $title = "updated";
  $pid = $_POST['edit'];
  $retreive = $db->query("SELECT `name`,`description`,`address`,`location`,`price`,`category`,`image` FROM places WHERE `pid`=$pid");
  $details = $retreive->fetch(PDO::FETCH_NUM);
  $sql = $db->prepare("UPDATE places SET `name`=?,`description`=?,`address`=?,`location`=?,`price`=?,`category`=?,`image`=? WHERE `pid`=$pid");
  $name = $details[0];
  $desc = $details[1];
  $adrs = $details[2];
  $addressFields = explode(" ", $adrs);
  for ($i = 1; $i < 8; $i += 3) $adrsFields[] = $addressFields[$i];
  if (isset($addressFields[10])) $adrsFields[] = $addressFields[$i];
  else $adrsFields[] = NULL;
  $loca = $details[3];
  $price = $details[4];
  $cate = $details[5];
  $img = $details[6];
  $keepImg = false;
} else if (isset($_POST['delete'])) {
  $pid = $_POST['delete'];
  $sql = "DELETE FROM places WHERE `pid`=$pid";
  $db->exec($sql);
  header("Location: admin-index.php");
  $action = "Delete Place";
}
echo "<title>$action</title>";
$valid = true;
$errs = NULL;
if ($_SERVER['REQUEST_METHOD'] === "POST" && (isset($_POST['new_f']) || isset($_POST['edit_f']))) {
  // Do error validation before the document itself
  if (isset($_POST['name'])) $name = inputName($valid, $_POST['name'], $errs[]);
  if (isset($_POST['desc'])) $desc = inputDesc($valid, $_POST['desc'], $errs[]);
  if (isset($_POST['adrs'])) $adrs = inputAdrs($valid, $_POST['adrs'], $errs[]);
  $addressFields = explode(" ", $adrs);
  for ($i = 1; $i < 8; $i += 3) $adrsFields[(($i + 2) / 3) - 1] = $addressFields[$i];
  if (isset($addressFields[10])) $adrsFields[3] = $addressFields[$i];
  else $adrsFields[3] = NULL;
  if (isset($_POST['loca'])) $loca = inputLoca($valid, $_POST['loca'], $errs[]);
  if (isset($_POST['price'])) $price = inputPrice($valid, $_POST['price'], $errs[]);
  if (isset($_POST['cate'])) $cate = inputCate($valid, $_POST['cate'], $errs[]);
  else inputCate($valid, NULL, $errs[]);
  if (isset($_FILES['img']) && $_POST['MAX_FILE_SIZE']) $img = inputImg($valid, $keepImg, $img, $_FILES['img'], $_POST['MAX_FILE_SIZE'], $errs[]);
  else inputImg($valid, $keepImg, $img, NULL, NULL, $errs[]);
}
if (isset($errs)) {
  $c = count($errs);
  for ($i = 0; $i < $c; $i++) if ($errs[$i] === NULL) unset($errs[$i]);
}
try {
  if ((isset($_POST['new_f']) || isset($_POST['edit_f'])) && $valid) {
    $sql->execute(array($name, $desc, $adrs, $loca, $price, $cate, $img));
    $showStatus = true;
  }
} catch (PDOException $e) {
  echo $e->getMessage();
}
if ($showStatus)
  $success = "$name has been successfully $title";
?>

<?php require 'html/document_before.php' ?>

    <!-- Form header -->
    <form method="post" enctype="multipart/form-data">
      <div class="card">
        <h4 class="card-header"><?php echo $action; ?></h4>
        <div class="card-body">


          <!-- Name input -->
          <div class="form-group row mt-5 mb-4">
            <label class="tag-label col-md-3 col-form-label" for="name-input">Name:</label>
            <div class="col-md-9">
              <input value<?php echo "$switch\"$name\""; ?> name="name" id="name-input" class="form-control" type="text" autocomplete="off">
            </div>
          </div>

          <!-- Description input -->
          <div class="form-group row mt-5 mb-4">
            <label class="tag-label col-md-3 col-form-label" for="desc-input">Description:</label>
            <div class="col-md-9">
              <textarea name="desc" id="desc-input" class="form-control" rows="4"><?php echo $desc; ?></textarea>
            </div>
          </div>

          <!-- Address input -->
          <div class="form-group row mt-5 mb-4">
            <label class="tag-label col-md-3 col-form-label">Address:</label>
            <div class="col-md-9 p-0 d-md-flex">

              <div class="col-md-3">
                <input value<?php echo "$switch\"$adrsFields[0]\""; ?> name="adrs[]" id="adrs-input" class="form-control" type="text" placeholder="Block No." autocomplete="off">
              </div>
              <div class="col-md-3">
                <input value<?php echo "$switch\"$adrsFields[1]\""; ?> name="adrs[]" id="adrs-input" class="form-control" type="text" placeholder="Street/Road No." autocomplete="off">
              </div>
              <div class="col-md-3">
                <input value<?php echo "$switch\"$adrsFields[2]\""; ?> name="adrs[]" id="adrs-input" class="form-control" type="text" placeholder="Building/House No." autocomplete="off">
              </div>
              <div class="col-md-3">
                <input value<?php echo "$switch\"$adrsFields[3]\""; ?> name="adrs[]" id="adrs-input" class="form-control" type="text" placeholder="Flat No. (optional)" autocomplete="off">
              </div>
            </div>
          </div>

          <!-- Location input -->
          <div class="form-group row mt-5 mb-4">
            <label class="tag-label col-md-3" for="loca-input">Location:</label>
            <div class="col-md-9">
              <input value<?php echo "$switch\"$loca\""; ?> name="loca" id="loca-input" class="form-control" type="text" autocomplete="off">
            </div>
          </div>

          <!-- Price input -->
          <div class="form-group row mt-5 mb-4">
            <label class="tag-label col-md-3" for="price-input">Price (B.D/hour)</label>
            <div class="col-md-9">
              <input value<?php echo "$switch\"$price\""; ?> name="price" id="price-input" class="form-control" type="text" autocomplete="off">
            </div>
          </div>

          <!-- Categories input -->
          <div class="form-group row mt-5 mb-4">
            <label class="tag-label col-md-3" for="cate-input">Categories</label>
            <div class="col-md-9">
              <select name="cate" class="form-control">
                <?php
                $categories = ['vr', 'gaming', 'billiard', 'room'];
                $displayCate = ['VR', 'Gaming', 'Billiard', 'Room'];
                if (!isset($cate)) echo "<option hidden disabled selected value> -- Choose a category -- </option>";
                for ($i = 0; $i < 4; $i++) {
                  echo "<option value=" . $categories[$i];
                  if ($categories[$i] == $cate) echo " selected";
                  echo ">" . $displayCate[$i] . "</option>";
                }
                ?>
              </select>
            </div>
          </div>

          <!-- Picture input -->
          <div class="form-group row mt-5 mb-4 row">

            <!-- Picture input header -->
            <label class="tag-label col-md-3" for="img-input">Picture:</label>
            <div class="input-group mb-3 col-md-9">

              <!-- MAX_FILE_SIZE must precede the file input field -->
              <input value="3000000" name="MAX_FILE_SIZE" type="hidden">
              <!-- File input display -->
              <div class="input-group pb-4">

                <label class="col-8 form-control" id="file-name-display" for="img-input" role="button">Chose file...</label>
                <label class="col-4 btn btn-light" for="img-input">Browse</label>
              </div>

              <!-- File input -->
              <input name="img" id="img-input" class="d-none file-input" type="file">
              <!-- End picture input -->
            </div>
          </div>

          <!-- Image container -->
          <div class="form-group image-container text-center">
            <img src<?php echo "$switch\"images/$img\""; ?> id="viewer" class="col-12 col-md-9 col-lg-6 d-none" alt="">
            <label class="col-12 col-md-9 col-lg-6 form-control border pt-4 pb-5 d-inline-block" id="no-image" for="img-input" role="button">Upload Image</label>
          </div>
          <?php if (isset($_POST['edit'])) echo "<input type='hidden' name='edit' value=$pid>"; ?>
          <!-- Action buttons -->
          <div class="form-group d-flex px-4 justify-content-between">
            <input type="submit" name=<?php echo $actionf; ?> class="btn btn-primary col-4" value=<?php echo $action; ?>></input>
            <a class="btn btn-secondary col-4" href="admin-index.php">Exit</a>
          </div>

          <!-- End form -->
        </div>
      </div>
    </form>



    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.min.js" integrity="sha384-i61gTtaoovXtAbKjo903+O55Jkn2+RtzHtvNez+yI49HAASvznhe9sZyjaSHTau9" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>

    <script>
      var imageVisibility = 0
      <?php if ($img != NULL || (isset($_POST['img']) && ($_POST['img']['size'] != 0))) echo "showImageContainer();"; ?>

      function setFilename(elem) {
        if (elem.files.length == 0) return
        if (imageVisibility == 0) showImageContainer()
        var fileName = elem.files[0].name
        // Change the text shown on the file-input-display
        $('#file-name-display').empty().append(fileName)
        // Get file from input
        file = $('#img-input')[0].files[0]
        // Create url for the file
        url = URL.createObjectURL(file)
        // Set image src to the url we created
        $('#viewer').attr('src', url)
      }

      function showImageContainer() {
        const iStyle = "col-12 col-md-9 col-lg-6 "
        const noiStyle = iStyle + "form-control border pt-4 pb-5 "

        // Remove no-image box and display inputed image
        if ($('#no-image').attr('class') == noiStyle + "d-inline-block") {
          $('#no-image').attr('class', "d-none")
          $('#viewer').attr('class', iStyle + "d-inline-block")
        }
        imageVisibility = 1
      }
      // On file-input change run setFilename function on the inputed value
      $(document).ready(() => {
        $('.file-input').change(e => {
          setFilename(e.target)

        })
      })
    </script>

<?php require 'html/document_after.php' ?>