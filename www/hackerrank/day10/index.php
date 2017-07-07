<?php
$_fp = fopen("input.txt", "r");
$n = fgets($_fp);
$binaryN = '';
$prevRemainder = -1;
$countConsecutive = $maxCountConsecutive = 0;
while($n > 0) {
    $remainder = $n % 2;
    $n = $n / 2;
    $binaryN = $remainder.$binaryN;   
}


for($i = 0; $i < strlen($binaryN); $i++){
    if($binaryN[$i] == '1') {
        $countConsecutive++;
    } else {
        if($countConsecutive >= $maxCountConsecutive) 
            $maxCountConsecutive = $countConsecutive;
        $countConsecutive = 0;
    }
}

print($binaryN);
print($maxCountConsecutive);