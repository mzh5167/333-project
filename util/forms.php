<?php

/**
 * Used in forms to pass a certain value into input, if such value exists
 */
function inject_value($value)
{
  if (isset($value))
    return "value='" . htmlspecialchars($value) . "'";
}
