<?php
$start = 500000;
$size = 200000;
$output = './test_files/data.txt';
$counter = 0;
$handle = fopen($output, "w");
while ($counter < $size) {
    $r = rand(15, 40);
    $rand_name = substr(str_shuffle(base64_encode(microtime()) . '   '), 0, $r);
    fwrite($handle, ' ' . $start + $counter . ' , ' . $rand_name . "\n");
    $counter++;
}

fclose($handle);
