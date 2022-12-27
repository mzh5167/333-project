<?php
require("util/reserve_logic.php");
require 'connection.php';
try {
  // general info
  $infostmt = $db->prepare("SELECT * FROM places WHERE pid=?");
  $infostmt->bindValue(1, $_GET['pid']);
  $infostmt->execute();
  $r = $infostmt->fetch(PDO::FETCH_ASSOC);
  if ($r == false) {
    die("PLACE NOT FOUND");
  }
  extract($r);

  // time slot stuff ??
  $map;
  $time = time();
  $stmt = $db->prepare('SELECT timeslot FROM availability WHERE pid = ? AND date = ?;');
  for ($i = 1; $i <= 5; $i++) {
    $stmt->bindValue(1, $_GET['pid']);
    $t = $time + 24 * 60 * 60 * $i;
    $sqldate = date("Y-m-d", $t);
    $stmt->bindValue(2, $sqldate);
    $stmt->execute();
    $f = $stmt->fetch(PDO::FETCH_ASSOC);
    $bit = $f == false ? 0 : $f['timeslot'];
    $timemap = generateMap($bit);
    $map[$sqldate] = $timemap;
  }
} catch (PDOException $ex) {
  var_dump($ex);
}


?>
<?php require 'html/document_before.php'; ?>

<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-12 col-md-4">
        <img src="images/<?php echo $image ?>" class="img-fluid img-thumbnail w-100">
      </div>
      <div class="col-12 col-md-8">
        <h1>
          <?php echo $name ?>
        </h1>
        <p>Rating: 3 out of 5</p>
        <div class="text-wrap text-break">
          <?php echo $description ?>
        </div>
        <h4>
          <?php echo $category ?>
        </h4>

        <div class="row">
          <div class="col-12 col-md-8">
            <form action="reserve.php" method="post">
              <h3>Date:</h3>
              <div class="btn-group-toggle row" data-toggle="buttons" id="dateSelector"></div>
              <h3>Start Time: </h3>
              <div class="btn-group-toggle row" data-toggle="buttons" id="hours"></div>
              <h3>Length: </h3>
              <div class="btn-group-toggle row" data-toggle="buttons" id="length"></div>
              <h3 class="mt-3" id="price">Price:
                <?php echo $price ?>BD
              </h3>
              <input type="hidden" name="pid" value="<?php echo $pid ?>">
              <button class="btn btn-secondary" id="submit" style="display: none;">Book now</button>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    let map = <?php print_r(json_encode($map)) ?>;
    const basePrice = <?php echo $price ?>;
    const dates = document.getElementById("dateSelector");
    const hours = document.getElementById("hours");
    const length = document.getElementById("length");
    const price = document.getElementById("price");
    const submit = document.getElementById("submit");

    function prettyTime(hours) {
      m = hours >= 12 ? "PM" : "AM";
      h = hours == 12 ? 12 : hours % 12;
      return `${h}${m}`;
    }

    function prettyDate(str) {
      return str.split("-")[2];
    }

    function dateHandle(d) {
      hours.innerHTML = "";
      length.innerHTML = "";
      submit.style.display = "none";
      price.innerHTML = `Price: ${basePrice}BD`;
      for (let x in map[d]) {
        hours.innerHTML += `<label class="btn btn-outline-secondary col-2"><input type="radio" name="start" value="${x}" id="${x}clock" onclick="timeHandle('${d}','${x}')">${prettyTime(x)}</label>`;
      }
    }

    function timeHandle(d, s) {
      length.innerHTML = "";
      submit.style.display = "none";
      price.innerHTML = `Price: ${basePrice}BD`;
      let h = map[d][s];
      for (let i = 1; i <= h; i++) {
        length.innerHTML += `<label class="btn btn-outline-secondary col-2"><input type="radio" name="length" value="${i}" id="${i}hr" onclick="priceHandle('${i}')">${i}hr</label>`;
      }
    }

    function priceHandle(h) {
      price.innerHTML = `Price: ${basePrice * h}BD`;
      submit.style.display = "block";
    }

    function main() {
      dates.innerHTML = "";
      for (let x in map) {
        dates.innerHTML += `<label class="btn btn-outline-secondary col-2"><input type="radio" name="date" value="${x}" onclick="dateHandle('${x}')">${prettyDate(x)}</label>`;
      }
    }
    main();
  </script>
</body>
<?php require 'html/document_after.php'; ?>
