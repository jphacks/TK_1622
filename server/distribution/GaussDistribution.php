<?php

//平均と分散入れたら値を返してくれる
function generate_norm($average = 0.0, $variance = 1.0) {
    static $z1, $z2, $mt_max, $ready = true;
    if ($mt_max === null) {
        $mt_max = mt_getrandmax();
    }
    $ready = !$ready;
    if ($ready) {
        return $z2 * $variance + $average;
    }
    $u1 = mt_rand(1, $mt_max - 1) / $mt_max;
    $u2 = mt_rand(1, $mt_max - 1) / $mt_max;
    $v1 = sqrt(-2 * log($u1));
    $v2 = 2 * M_PI * $u2;
    $z1 = $v1 * cos($v2);
    $z2 = $v1 * sin($v2);
    return (float)$z1 * $variance + $average;
}
