<?php
$_fp = fopen("input.txt", "r");
$n = fgets($_fp);

for($i = 0; $i < $n; $i++) {
	$str = $str2 = '';
    $s = fgets($_fp);
    $c = strlen($s);
    
    for($m = 0; $m < $c; $m++) { 
		if(!($m % 2))
            $str .= $s[$m];
        else
            $str2 .= $s[$m];
    }
	print($str.' '.$str2."\n");
}