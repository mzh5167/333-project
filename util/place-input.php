<?php
/* Handles validating the inputs in add_place.php */


require 'validate.php';

// Name input
function inputName(&$v, $iName, &$e)
{
    $sName = validateName($iName, $e);
    if ($v) $v = $sName;
    return $iName;
}

// Description input
function inputDesc(&$v, $iDesc, &$e)
{
    $sDesc = validateDesc($iDesc, $e);
    if ($v) $v = $sDesc;
    return $iDesc;
}

// Address input
function inputAdrs(&$v, $iAdrs, &$e)
{
    for ($i = 0; $i < 4; $i++) {
        if (empty($iAdrs[$i])) $field = NULL;
        else $field = $iAdrs[$i];
        $sAdrs = validateAdrs($i, $field, $fError);
        if (!$sAdrs) $e[$i] = $fError;
        else $iAdrs[$i] = $field;
        if ($v) $v = $sAdrs;
    }
    $block = $iAdrs[0];
    $street = $iAdrs[1];
    $building = $iAdrs[2];
    $flat = $iAdrs[3];
    $iAdrs = "Block $block, Road $street, Building $building";
    if ($flat != NULL) $iAdrs .= ", Flat $flat";
    if (isset($e)) {
        $error = "Address: ";
        for ($i = 0; $i < count($e); $i++) {
            $error .= $e[$i];
            if ($i < count($e) - 1) $error .= " , ";
        }
        $e = $error;
    }
    return $iAdrs;
}

// Location input
function inputLoca(&$v, $iLoca, &$e)
{
    $sLoca = validateLoca($iLoca, $e);
    if ($v) $v = $sLoca;
    return $iLoca;
}
// Price input
function inputPrice(&$v, $iPrice, &$e)
{
    $sPrice = validatePrice($iPrice, $e);
    if ($v) $v = $sPrice;
    return $iPrice;
}

// Category input
function inputCate(&$v, $iCate, &$e)
{
    $sCate = validateCate($iCate, $e);
    if ($v) $v = $sCate;
    return $iCate;
}

// Image input
function inputImg(&$v, &$k, $p, $iImg, $MAX_SIZE, &$e)
{
    $sImg = validateImg($k, $p, $iImg, $MAX_SIZE, $e);
    if ($k) return $p;
    else if ($iImg == NULL) return NULL;
    $images_dir = "images";
    $filenames = array_diff(scandir($images_dir), array('..', '.'));
    do {
        $nameID = uniqid();
    } while (in_array($nameID, $filenames));
    $ext = pathinfo($iImg['name'], PATHINFO_EXTENSION);
    $target = "$images_dir/$nameID.$ext";
    if ($sImg && $v) {
        if (!move_uploaded_file($iImg['tmp_name'], $target)) {
            $e .= "wasn't uploaded successfully ";
            $v = false;
        } else {
            if ($v) $v = $sImg;
        }
    }
    if (isset($e)) $e = "Image: $e";
    return "$nameID.$ext";
}
