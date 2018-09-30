<?php

define('BIGINT_BASE_LEN', 9);
define('BIGINT_BASE', pow(10, BIGINT_BASE_LEN));

function bigintParse (string $a) {
    $len = strlen($a);
    $mod = $len % BIGINT_BASE_LEN;
    $head = array();
    if ($mod > 0) {
        $head[] = (int) substr($a, 0, $mod);
    }
    if ($mod == $len) {
        $tail = array();
    } else {
        $tail = substr($a, $mod);
        $tail = str_split($tail, BIGINT_BASE_LEN);
        $tail = array_map(function ($x) { return (int) $x; }, $tail);
    }
    $result = array_merge($head, $tail);
    return array_reverse($result);
}

function bigintAdd (string $a, string $b) {
    $a = bigintParse($a);
    $b = bigintParse($b);
    if (count($a) >= count($b)) {
        $x = &$a;
        $y = &$b;
    } else {
        $x = &$b;
        $y = &$a;
    }
    $len = min(count($a), count($b));
    for ($i = 0; $i < $len - 1; $i++) {
        $x[$i] += $y[$i];
        $x[$i + 1] += intdiv($x[$i], BIGINT_BASE);
        $x[$i] %= BIGINT_BASE;
    }
    $x[$len - 1] += $y[$len - 1];
    $carry = intdiv($x[$len - 1], BIGINT_BASE);
    $x[$len - 1] %= BIGINT_BASE;
    if ($carry > 0) {
        if (!isset($x[$len])) {
            $x[$len] = 0;
        }
        $x[$len] += $carry;
    }
    $result = array($x[count($x) - 1]);
    for ($i = count($x) - 2; $i >= 0; $i--) {
        $result[] = sprintf('%0' . BIGINT_BASE_LEN . 'd', $x[$i]);
    }
    return join("", $result);
}