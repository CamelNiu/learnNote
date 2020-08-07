<?php

$arr = range(0,50,3);


function binSearch($arr,$target)
{

    $min = 0;
    $max = count($arr)-1;

    while ($arr[$min]<=$arr[$max]) {
        $mid = floor( ($min+$max)/2 );

    }


}


binSearch($arr,39);