<?php
$handle = fopen("input.txt", "r");
$arr = array();
for ($arr_i = 0; $arr_i < 6; $arr_i++) {
    $arr_temp = fgets($handle);
    $arr[] = explode(" ", $arr_temp);
    array_walk($arr[$arr_i], 'intval');
}

$dimension = 3;
$excludedIndex = [3, 5];
$max = null;

for ($i = 0; $i < $dimension + 1; $i++) {
    for ($j = 0; $j < $dimension + 1; $j++) {

        $sum = $curIndex = 0;

        for ($k = $i; $k < $i + $dimension; $k++) {
            for ($m = $j; $m < $j + $dimension; $m++) {
                if (!in_array($curIndex, $excludedIndex)) {
                    $sum += $arr[$k][$m];
                }
                $curIndex++;

            }
        }

        if ($max === null || $sum > $max)
            $max = $sum;
    }
}
echo $max;