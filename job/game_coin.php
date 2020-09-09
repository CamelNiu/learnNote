<?php

/**
 * [getGroup description]
 * @Author   NiuShaoGang
 * @email    camel_niu@163.com
 * @qq       370574131
 * @wechat   CamelNiu
 * @DateTime 2020-08-18
 * @param    [type]            $m [description]
 * @param    [type]            $n [description]
 * @return   [type]               [description]
 */
function getGroup($m,$n)
{
    if( ( ($n*1)>$m ) || ( $n*10<$m ) ) return 0;
    if( $n == $m ) return 1;

    $group = [];

    //假设1,2,5,10分的数量分别为a,b,c,d,四层循环列出所有可能，一个一个校检
    for($a=0;$a<$n;$a++){
        for($b=0;$b<$n;$b++){
            for($c=0;$c<$n;$c++){
                for($d=0;$d<$n;$d++){
                    if( (($a*1+$b*2+$c*5+$d*10)==$m) && ($a+$b+$c+$d)==$n  ){
                        $group[] = "a-[$a] b-[$b] c-[$c] d-[$d]";
                    }
                }
            }
        }
    }

    var_dump($group);
    return count($group);

}


$res = getGroup(200,90);

var_dump($res);