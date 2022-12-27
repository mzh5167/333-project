<?php require 'html/document_before.php' ?>

<!-- Retrieve places information -->
<?php
require("connection.php");
if (isset($_GET['search'])) {
  $name = $_GET['place-name'];
  $places = $db->query("SELECT * FROM `places` WHERE UPPER(`name`) LIKE UPPER('%$name%')");
  $count = $db->query("SELECT COUNT(*) FROM `places` WHERE UPPER(`name`) LIKE UPPER('%$name%')")->fetchAll()[0][0];
} else $places = $db->query('SELECT `pid`,`name` FROM places');
?>

<!-- Nav bar -->
<ul class="nav nav-pills" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="places-tab" data-toggle="tab" data-target="#places" type="button" role="tab" aria-controls="places" aria-selected="true">Places</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="users-tab" data-toggle="tab" data-target="#users" type="button" role="tab" aria-controls="users" aria-selected="false">Users</button>
  </li>
</ul>

<hr style="border-top: 1px solid var(--gray-800)">

<!-- Places tab header -->
<div class="tab-content" id="myTabContent">
  <div class="p-3 tab-pane fade show active" id="places" role="tabpanel" aria-labelledby="places-tab">
    <div class="mb-3 d-flex justify-content-between">

      <!-- Add place button -->
      <form action="add-place.php" method="post">
        <button name="new" class="btn btn-primary">Add place</button>
      </form>

      <!-- Places search form -->
      <form class="my1" action="" method="get">
        <label class="sr-only" for="inlineFormInputGroupUsername">Username</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <label class="input-group-text" for="submit-search" role="button">
              <i class="bi bi-search"></i>
            </label>
          </div>
          <input type="text" name="place-name" class="form-control" id="inlineFormInputGroupUsername" placeholder="Search">
          <?php
          if (isset($_GET['search'])) {
            echo "<div class='input-group-append'>";
            echo "<a href='admin-index.php' class='input-group-text'><i class='bi bi-x-lg'></i></a>";
            echo "</div>";
          }
          ?>
        </div>
        <input type="submit" name="search" id="submit-search" class="d-none">
      </form>
    </div>

    <!-- Display each place -->
    <?php
    if (!isset($_GET['search']) || (isset($_GET['search']) && $count != 0)) {
      foreach ($places as $pid) { ?>
        <form action="add-place.php" method="post" class="d-flex justify-content-between border p-3 rounded-lg mb-3">
          <div class="mr-5">
            <?php echo $pid[0]; ?>
          </div>
          <div>
            <?php echo $pid[1]; ?>
          </div>
          <div class="ml-auto">
            <button name="edit" class="border-0 bg-transparent text-light bi bi-pencil-fill" value=<?php echo $pid[0]; ?>></button>
          </div>
          <div class="ml-4">
            <button name="delete" class="border-0 bg-transparent text-light bi bi-x-circle-fill" value="<?php echo $pid[0]; ?>"></button>
          </div>
        </form>
    <?php }
    } else echo "<div class='border p-3 rounded-lg mb-3'>There is no place with this name</div>" ?>
  </div>

  <!-- Users tab header -->
  <div class="py-4 px-3 tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
    <div class="mb-3 d-flex justify-content-end">
      <form class="my1" action="" method="get">
        <label class="sr-only" for="inlineFormInputGroupUsername">Username</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <i class="bi bi-search"></i>
            </div>
          </div>
          <input type="text" class="form-control" id="inlineFormInputGroupUsername" placeholder="Search">
        </div>
      </form>
    </div>
    <div class="d-flex justify-content-between border p-3 rounded-lg mb-3">
      <div class="mr-5">
        [user id]
      </div>
      <div>
        [user name]
      </div>
      <div class="ml-auto">
        <a href="#" class="text-light bi bi-x-circle-fill"></a>
      </div>
    </div>
    <div class="d-flex justify-content-between border p-3 rounded-lg mb-3">
      <div class="mr-5">
        [user id]
      </div>
      <div>
        [user name]
      </div>
      <div class="ml-auto">
        <a href="#" class="text-light bi bi-x-circle-fill"></a>
      </div>
    </div>
    <div class="d-flex justify-content-between border p-3 rounded-lg mb-3">
      <div class="mr-5">
        [user id]
      </div>
      <div>
        [user name]
      </div>
      <div class="ml-auto">
        <a href="#" class="text-light bi bi-x-circle-fill"></a>
      </div>
    </div>
  </div>
</div>

<?php require 'html/document_after.php' ?>