<?php
session_start();

function loggedIn()
{
  return isset($_SESSION['userType']);
}

function isAdmin()
{
  return loggedIn() &&
    $_SESSION['userType'] == 'admin';
}

function isCustomer()
{
  return loggedIn() &&
    $_SESSION['userType'] == 'customer';
}

function admin_only()
{
  if (!isAdmin()) {
    header('location: login.php');
    die();
  }
}

function AnyNotAdmin()
{
  if (isAdmin()) {
    header('location: login.php');
    die();
  }
}

function customer_only()
{
  if (!isCustomer()) {
    header('location: login.php');
    die();
  }
}
