<?php
function clamp($min, $max, $current)
{
    return max($min, min($max, $current));
}
function countTrailingZero($x)
{
    $count = 0;
    $max = 3;
    $i = 0;
    while (($x & 1) == 0 && $i < $max) {
        $x = $x >> 1;
        $count++;
        $i++;
    }
    return $count;
}
function generateMap($bit)
{
    $timemap = [];
    for ($i = 0; $i < 16; $i++) {
        $n = $bit;
        $avaliableHours = countTrailingZero($n >> $i);
        if ($avaliableHours != 0) {
            $timemap[$i + 8] = clamp(0, min(24 - ($i + 8), 3), $avaliableHours);
        }
    }
    return $timemap;
}
?>