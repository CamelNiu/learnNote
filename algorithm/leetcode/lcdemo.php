<?php

class Solution {

    /**
     * @param Integer[] $candidates
     * @param Integer $target
     * @return Integer[][]
     */
    function combinationSum($candidates, $target)
    {
        sort($candidates);
        $length = count($candidates);
        var_dump($length);
        if($length<=0) return false;
        $result = [];
        $tmpResult = [];

        function abc($candidates,$target,$)

    }


    /**
     * @param Integer[] $nums
     * @param Integer $target
     * @return Integer[]
     */
    function twoSum($nums, $target) {
        var_dump($target)
    }


}

$candidates = [2,4,5,7,1,8];
$target = 9;

$res = (new Solution)->combinationSum($candidates,$target);