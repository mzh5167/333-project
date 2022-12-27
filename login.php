<?php

require "connection.php";
require "util/forms.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'] ?? "";
  $password = $_POST['password'] ?? "";

  $valid = true;
  if ($email == "") {
    $errs[] = "Missing email";
    $valid = false;
  }
  if ($password == "") {
    $errs[] = "Missing password";
    $valid = false;
  }
  if (!$valid)
    goto output_begin;

  try {
    $query = $db->prepare("SELECT `password`, `uid` AS id FROM `users` WHERE email=?");

    $status = $query->execute([
      $email
    ]);
    if ($query->rowCount() === 0) {
      // $error = "Email not found";
      $errs[] = "Invalid email or password";
      goto output_begin;
    }

    $row = $query->fetch();
    $hash = $row['password'];

    $flag = password_verify($password, $hash);

    if ($flag) {
      session_start();
      $_SESSION['userId'] = $row['id'];
      $_SESSION['userType'] = 'customer';
      header("location: ./");
    } else {
      $errs[] = "Invalid email or password";
      goto output_begin;
    }
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
    <h4 class="card-header">Login</h4>
    <div class="card-body">
      <div class="form-group row">
        <label class="col-md-3 col-form-label" for="email-input">Email</label>
        <div class="col-md-9">
          <input type="text" class="form-control" id="email-input" name="email" autocomplete="off" <?=
            inject_value($email) ?>>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-3 cold-form-label" for="password-input">Password</label>
        <div class="col-md-9">
          <input type="password" class="form-control" id="password-input" name="password">
        </div>
      </div>
      <div class="form-group">Don't have an account yet? <a href="./register.php">Sign up</a> </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">Sign in</button>
      </div>
    </div>
  </div>
</form>

<?php require 'html/document_after.php'; ?>
