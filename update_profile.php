<?php
session_start();

require "util/validate.php";
require "util/forms.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fname = $_POST["fname"] ?? "";
  $lname = $_POST["lname"] ?? "";
  $phone = $_POST["phone"] ?? "";
  $email = $_POST["email"] ?? "";

  // Input validation
  $valid = true;
  $valid = isValidName($fname, 'First Name', $errs[]) && $valid;
  $valid = isValidName($lname, 'Last Name', $errs[]) && $valid;
  $valid = isValidEmail($email, $errs[]) && $valid;
  $valid = isValidPhone($phone, $errs[]) && $valid;

  // Clear null inside array
  if (isset($errs)) {
    $c = count($errs);
    for ($i = 0; $i < $c; $i++)
      if ($errs[$i] === NULL)
        unset($errs[$i]);
  }
  // Skip SQL if invalid
  if (!$valid)
    goto output_begin;

  try {
    require "connection.php";

    $sql = <<<SQL
      UPDATE  `users`
      SET     fname = :fname,
              lname = :lname,
              phone = :phone,
              email = :email
      WHERE   `uid` = :uid
    SQL;

    $sql_args = [
      'fname' => $fname,
      'lname' => $lname,
      'phone' => $phone,
      'email' => $email,
      'uid' => $_SESSION['userId'],
    ];
    // var_dump($sql, $sql_args);
    // die();
    $query = $db->prepare($sql);
    $query->execute($sql_args);

    // TODO: add success message
  } catch (PDOException $e) {
    echo $sql, "<br>";
    /* PDOStatement::errorInfo() returns an array of error information about the
     * last operation.  Index 1 contains Driver specific error code.
     *
     * see: https://www.php.net/manual/en/pdostatement.errorinfo.php
     */
    $errCode = $query->errorInfo()[1];
    if ($errCode == 1062)
      $error = 'Email already exists';
    else
      die("Err $errCode: <br>" . $e->getMessage());
  }
} else {
  try {
    require 'connection.php';

    $q = $db->prepare(" SELECT * FROM `users` WHERE `uid` = ?");
    $q->execute([
      $_SESSION['userId']
    ]);
    $r = $q->fetch(PDO::FETCH_ASSOC);

    // var_dump($r);
    // die();
    extract($r);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

output_begin:
$db = null;

if (isset($error))
  echo $error;

?>

<?php require 'html/document_before.php'; ?>

<form action="" method="post" class="container" style="max-width: var(--breakpoint-md);">
  <div class="card">
    <h4 class="card-header">Update Profile</h4>
    <div class="card-body">
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="fname-input">First name</label>
          <input type="text" class="form-control" id="fname-input" name="fname" <?= inject_value($fname) ?>>
        </div>
        <div class="form-group col-md-6">
          <label for="lname-input">Last name</label>
          <input type="text" class="form-control" id="lname-input" name="lname" <?= inject_value($lname) ?>>
        </div>
      </div>
      <div class="form-group">
        <label for="email-input">E-mail</label>
        <input class="form-control" type="text" id="email-input" name="email" autocomplete="off" <?=
                                                                                                  inject_value($email) ?>>
      </div>
      <!-- <div class="form-group">
        <label for="bday-input">Birthday</label>
        <input class="form-control" type="text" id="bday-input" name="birthday">
      </div> -->
      <div class="form-group">
        <label for="phone-input">Phone number</label>
        <input class="form-control" type="text" id="phone-input" name="phone" <?= inject_value($phone) ?>>
      </div>
      <div class="form-group">Already have an account? <a href="./login.php">Log in</a> </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">Sign in</button>
      </div>
    </div>
  </div>
</form>

<?php require 'html/document_after.php'; ?>