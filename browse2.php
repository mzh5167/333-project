<?php
$page = "main";
require('./search-filter.php');
require 'html/document_before.php'; ?>

<!-- cards -->
<div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-4 g-4 mx-auto">
  <?php
  if ($error == 0) {
    foreach ($query as $card) { ?>
      <div class="col">
        <div class="card mb-3 shadow-lg" style="margin-top:1rem;">
          <div>
            <img src="images/<?php echo "$card[4]"; ?>" class="card-img-top" alt="..." style="height:15rem;object-fit:cover;">
          </div>
          <div class="card-body">
            <h4> <?php echo "$card[1]"; ?></h4>

            <h6 id=star-container>
              Rating:
              <?php
              $fill = bcdiv("$card[5]", "1");
              $outline = 5 - $fill;
              for ($i = 1; $i <= $fill; $i++) {
                echo "<i class='bi bi-star-fill' style='color:orange';></i>";
              }
              for ($i = 1; $i <= $outline; $i++) {
                echo "<i class='bi bi-star' style='color:orange';></i>";
              }
              ?>
            </h6>
            <h6> Type: <?php echo "$card[2]"; ?></h6>
            <h6>Price: <?php echo "$card[3]"; ?> BD</h6>
            <a class="btn btn-primary mb-1 " href="view.php?id=<?php echo "$card[0]"; ?>&rating=<?php echo "$card[5]"; ?>" role="button">View Place</a>
          </div>
        </div>
      </div>


    <?php
    }
    ?>

  <?php
  }

  // if user type misspelled keyword
  else if ($error == 1) { ?>
    <div class="container align-items-center text-center">
      <div class="img mx-auto" style="width: 25rem;">
        <img src="images/error.svg" alt="">
        <h5>Your search did not match </h5>
        <h6>Suggestions:</h6>
        <p>- Make sure that all words are spelled correcly</p>
        <p>- Try different keywords</p>
      </div>
    </div>
  <?php
  }
  ?>
</div>
<?php require 'html/document_after.php' ?>
<script src="./liveSearch.js"></script>