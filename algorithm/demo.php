<?php

$arr = [1,6,3,8,9,5,3,1,6,5,8];

function insertSort($arr)
{
    // $len = count($arr);
    // for($i=1;$i<$len;$i++){
    //     $preIndex = $i-1;
    //     $current = $arr[$i];
    //     while ( $preIndex >=0 && $arr[$preIndex]>$current ) {
    //         $arr[$preIndex+1] = $arr[$preIndex];
    //         $preIndex--;
    //     }
    //     $arr[$preIndex+1] = $current;
    // }
    // return $arr;
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    $len = count($arr);
    for($i=1;$i<count($arr);$i++){

        for($j=$i-1;$j>=0;$j--){
            if($arr[$j]<$arr[$j+1]){
                $tmp = $arr[$j+1];
                $arr[$j+1] = $arr[$j];
                $arr[$j] = $tmp;
            }
        }

    }


    return $arr;

}

$res = insertSort($arr);

print_r($res);