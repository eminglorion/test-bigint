<?php

require_once 'lib.php';

$file = fopen('numbers', 'r');
$numbers = [];
while (($line = fgets($file)) !== false) {
    $line = trim($line);
    if (strlen($line) > 0) {
        $numbers[] = $line;
    }
}
fclose($file);
if (count($numbers) > 0) {
    $a = $numbers[0];
} else {
    $a = "0";
}
$len = count($numbers);
for ($i = 1; $i < $len; $i++) {
    $a = bigintAdd($a, $numbers[$i]);
}
print $a . "\n";
print substr($a, 0, 10) . "\n";