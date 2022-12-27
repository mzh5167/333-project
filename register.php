<?php

require "util/validate.php";
require "util/forms.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fname = $_POST["fname"] ?? "";
  $lname = $_POST["lname"] ?? "";
  $phone = $_POST["phone"] ?? "";
  $email = $_POST["email"] ?? "";
  $password = $_POST["password"] ?? "";

  // Input validation
  $valid = true;
  $valid = isValidName($fname, 'First Name', $errs[]) && $valid;
  $valid = isValidName($lname, 'Last Name', $errs[]) && $valid;
  $valid = isValidEmail($email, $errs[]) && $valid;
  $valid = isValidPhone($phone, $errs[]) && $valid;
  $valid = isValidPassword($password, $errs[]) && $valid;
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

    $query = $db->prepare("INSERT INTO `users`(fname, lname, phone, email, `password`)
      VALUES (?, ?, ?, ?, ?)");

    $query->execute([
      $fname,
      $lname,
      $phone,
      $email,
      password_hash($_POST["password"], PASSWORD_DEFAULT)
    ]);

    // Log user in
    session_start();
    $_SESSION['userId'] = $db->lastInsertId();
    $_SESSION['userType'] = 'customer';
    header("location: ./");
    die();
  } catch (PDOException $e) {
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
}

output_begin:
$db = null;

if (isset($error))
  echo $error;

?>

<?php require 'html/document_before.php'; ?>

<form action="" method="post" class="container" style="max-width: var(--breakpoint-md);">
  <div class="card">
    <h4 class="card-header">Register</h4>
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
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="pass-input">Password</label>
          <input type="password" class="form-control" id="pass-input" name="password">
        </div>
        <div class="form-group col-md-6">
          <label for="pass-conf">Confirm password</label>
          <input type="password" class="form-control" id="pass-conf">
        </div>
      </div>
      <div class="form-group">Already have an account? <a href="./login.php">Log in</a> </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">Sign in</button>
      </div>
    </div>
  </div>
</form>

<?php require 'html/document_after.php'; ?>
