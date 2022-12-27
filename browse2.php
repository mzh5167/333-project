<?php include('search-filter.php') ?>

<?php require 'html/document_before.php' ?>

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

            <h6><i class="bi bi-star-fill" style="color:orange;"></i> Rating: <?php echo bcdiv("$card[5]", "1"); ?></h6>
            <h6> Type: <?php echo "$card[2]"; ?></h6>
            <h6>Price: <?php echo "$card[3]"; ?> BD</h6>
            <a class="btn btn-primary mb-1 " href="view.php?id=<?php echo "$card[0]"; ?>&rating=<?php echo "$card[5]"; ?>" role="button">View Place</a>
          </div>
        </div>
      </div>
  <?php
    }
  }
  // if user type misspelled keyword
  else {
    include("./not-found.php");
  }
  ?>
</div>

<?php require 'html/document_after.php' ?>