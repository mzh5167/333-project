<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <!-- <link rel="stylesheet" href="./custom.css"> -->
  <!-- <link rel="stylesheet" href="./bootstrap.min.css"> -->
  <link rel="stylesheet" href="./overrides.css">


  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

  <title>Hello, world!</title>
</head>

<body>
  <header style="height:4.4rem">
    <!-- Navbar -->
    <?php require 'nav.php' ?>
  </header>

  <!-- Error message -->
  <?php if (isset($valid) && !$valid && !empty($errs)) : ?>
    <div class="px-3 py-1">
      <div class="alert alert-danger border" role="alert">
        <h4 class="alert-heading"> Error </h4>
        <hr class="my-2">
        <?= join(" <br> ", $errs) ?>
      </div>
    </div>
  <?php elseif (isset($success)) : ?>
    <div class="px-3 py-1">
      <div class="alert alert-danger border" role="alert">
        <h4 class="alert-heading"> Error </h4>
        <hr class="my-2">
        <?= $success ?>
      </div>
    </div>
  <?php endif ?>

  <main class="container py-3">