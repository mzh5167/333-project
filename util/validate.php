<?php

/**
 * Checks whether a password is valid or not
 * 
 * @param string $password   the password to be validated
 * @param string &$message   the error message specifying the issue with the password
 */
function isValidPassword(string $password, string &$message = null): bool
{
  $message = null;
  if (strlen($password) < 8) {
    $message = "Password must be 8 characters or longer";
  } else if (!limitedToChars($password, 'a-z0-9\-_', 'password', $message)) {
  } else if (!preg_match("/[a-z]/i", $password)) {
    $message = "Password must contain at least one letter";
  } else if (!preg_match("/\d/i", $password)) {
    $message = "Password must contain at least one number";
  } else if (!preg_match('/^[a-z]/i', $password)) {
    $message = "Password must start with a letter";
  }
  return !isset($message);    // return true if there isn't an error message
  // return $message == "";
}


/**
 * Checks whether a name is valid or not
 * 
 * @param string $name       the name to be validated
 * @param string $field_name the name of the field to be displayed in the error message
 * @param string &$message   the error message specifying the issue with the name
 */
function isValidName(string $name, string $field_name = 'Name', string &$message = null): bool
{
  // echo strlen($name);
  if (strlen($name) < 3)
    $message = "$field_name cannot be shorter than 3 characters";
  else if (strlen($name) > 15)
    $message = "$field_name cannot be longer than 15 characters";
  else if (!limitedToChars($name, "a-z", $field_name, $message)) {
  }

  return !isset($message);
}


/**
 * Checks whether a phone number is valid or not
 * 
 * @param string $number     the phone number to be validated
 * @param string &$message   the error message specifying the issue with the name
 */
function isValidPhone(string $number, string &$message = null): bool
{
  if (!preg_match('/^(3\d|66)\d{6}$/', $number)) {
    $message = "Invalid phone number";
    return false;
  }
  return true;
}

function isValidEmail(string $email, string &$message = null) : bool
{
  if (!preg_match(
    '/^[a-zA-Z0-9]+(?:\.[a-zA-Z0-9]+)*@[a-zA-Z0-9]+(?:\.[a-zA-Z0-9]+)*$/',
    // '/^([a-z0-9_\-.])+@[[:alnum:]]+(\.[[:alnum:]]+)+$/',
    $email
  )) {
    $message = 'Invalid email';
    return false;
  }
  return true;
}


/**
 * Checks whether a given string is limited to the allowed characters.  This
 * function is intended to be used internally within `validate.php`
 * 
 * @param string $subject    The string to be checked
 * @param string $allowedCharacters
 * The allowed characters in regex-like format.  Note that the allowed
 * characters placed directly inside a regex with case insensitive matching
 * enabled
 * @param string &$message   The error message specifying the issue with the name
 */
function limitedToChars(string $subject, string $allowedCharacters, string $field_name, string &$message = null): bool
{
  if (preg_match_all("/[^$allowedCharacters]/i", $subject, $matches, PREG_SET_ORDER)) {
    // Build a string containing all unallowed characters present in subject
    $out = "";
    $count = 0;
    foreach ($matches as list($char)) {
      // If $char is not found in out
      if (strpos($out, $char) === false) {
        $out .= " " . $char;
        $count++;
      }
    }
    // Output message
    $message = ($count == 1) ?
      "Character " . htmlspecialchars($out) . " is not allowed" :
      "Characters " . htmlspecialchars($out) . " are not allowed";
    $message .= " in $field_name";
    return false;
  }

  return true;
}


// Name validator
function validateName(&$vName, &$error)
{
  $vName = trim($vName);
  if (!((strlen($vName) <= 30) && (preg_match("/^([a-z0-9]\s?){1,30}$/i", $vName)))) {
    $error = "Name: Invalid place name";
    return false;
  }
  return true;
}

// Description validator
function validateDesc(&$vDesc, &$error)
{
  $vDesc = trim($vDesc);
  if (strlen($vDesc) >= 200) {
    $error = "Description: The description is too long";
    return false;
  } else if (strlen($vDesc) <= 20) {
    $error = "Description: The description is too short";
    return false;
  }
  return true;
}

// Address validator
function validateAdrs($i, &$vAdrs, &$error)
{
  trim($vAdrs);
  switch ($i) {
    case 0:
      if (!preg_match("/^\d{3,4}$/", $vAdrs)) {
        $error = "Invalid Block No.";
        return false;
      }
      break;
    case 1:
      if (!preg_match("/^\d{1,4}$/", $vAdrs)) {
        $error = "Invalid Street/Road No.";
        return false;
      }
      break;
    case 2:
      if (!preg_match("/^\d{1,4}$/", $vAdrs)) {
        $error = "Invalid Building/House No.";
        return false;
      }
      break;
    case 3:
      if (!preg_match("/^\d{0,2}[a-z]?$/i", $vAdrs) && !empty($vAdrs)) {
        $error = "Invalid Flat No.";
        return false;
      }
  }
  return true;
}

// Location validator
function validateLoca(&$vLoca, &$error)
{
  $vLoca = trim($vLoca);
  if (!preg_match("/^(https:\/\/goo\.gl\/maps\/[a-zA-Z0-9]{17}\/?)$/", $vLoca)) {
    $error = "Location: Invalid location link";
    return false;
  }
  return true;
}

// Price validator
function validatePrice(&$vPrice, &$error)
{
  $vPrice = trim($vPrice);
  if (!preg_match("/^(\d{0,2}(\.\d{0,3})?)$/", $vPrice) && $vPrice != 0 && $vPrice != NULL) {
    $error = "Price: Invalid Price";
    return false;
  }
  return true;
}

// Category validator
function validateCate(&$vCate, &$error)
{
  if (!preg_match("/^(vr|gaming|billiard|room)$/", $vCate)) {
    $error = "Category: Please chose a category";
    return false;
  }
  return true;
}

// Image validator
function validateImg(&$keep, $pImg, &$vImg, $MAX, &$error)
{
  if ($vImg == NULL || $vImg['size'] == 0) {
    if ($pImg != NULL) {
      $keep = true;
      return true;
    }
    $error = " Please upload an image";
    return false;
  }
  if ($vImg['error'] != UPLOAD_ERR_OK) {
    if ($vImg['error'] == $MAX) $error = "you have exceeded maximum size <br>";
    $error .= "error: $vImg[error] <br>";
    $error .= "<br> file was not uploaded properly <br>";
  }
  $accepted_types = ["image/png", "image/gif", "image/jpeg", "image/pjpeg"];
  $type = mime_content_type($vImg['tmp_name']);
  if (!in_array($type, $accepted_types)) {
    $error .= "<br> Please upload an image not $type";
  }
  if (isset($error)) return false;
  else return true;
}
