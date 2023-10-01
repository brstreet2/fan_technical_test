<?php

function hitungJumlahPasang($input)
{
    $length      = array_count_values($input);
    $total_count = 0;

    foreach ($length as $count) {
        $pairs          = intval($count / 2);
        $total_count    += $pairs;
    }

    return $total_count;
}

echo "Soal: " . PHP_EOL;
echo "a. Input: [10 20 20 10 10 30 50 10 20]" . PHP_EOL;
echo "Output yang diharapkan: 3" . PHP_EOL . PHP_EOL;
echo "b. Input: [6 5 2 3 5 2 2 1 1 5 1 3 3 3 5]" . PHP_EOL;
echo "Output yang diharapkan: 6" . PHP_EOL . PHP_EOL;
echo "c. Input: [1 1 3 1 2 1 3 3 3 3]" . PHP_EOL;
echo "Output yang diharapkan: 4" . PHP_EOL . PHP_EOL;


echo "Jawaban: " . PHP_EOL;

$input_a    = [10, 20, 20, 10, 10, 30, 50, 10, 20];
$output_a   = hitungJumlahPasang($input_a);
$input_b    = [6, 5, 2, 3, 5, 2, 2, 1, 1, 5, 1, 3, 3, 3, 5];
$output_b   = hitungJumlahPasang($input_b);
$input_c    = [1, 1, 3, 1, 2, 1, 3, 3, 3, 3];
$output_c   = hitungJumlahPasang($input_c);

echo "a. " . $output_a . PHP_EOL . PHP_EOL;
echo "b. " . $output_b . PHP_EOL . PHP_EOL;
echo "c. " . $output_c . PHP_EOL . PHP_EOL;
