<?php

/**
 * [leaky php实现漏桶算法]
 * @Author   [NiuShao   <camel_niu@163.com> <qq:370574131>]
 * @DateTime 2020-06-26
 * @param    [type]     $contain            [int 桶的总容量]
 * @param    [type]     $addNum             [int 每次注入桶中的水量]
 * @param    [type]     $leakRate           [int 桶中漏水的速率,秒为单位。例如2/s,3/s]
 * @param    integer    &$water             [int 当前水量，默认为0]
 * @param    integer    &$preTime           [int 时间戳,记录的上次漏水时间]
 * @return   [type]                         [bool,返回可否继续注入true/false]
 */
function leaky($contain,$addNum,$leakRate,&$water=0,&$preTime=0)
{
    //参数赋值
    //首次进入默认当前水量为0
    $water = empty($water) ? 0 : $water;
    //首次进入默认上次漏水时间为当前时间
    $preTime = empty($water) ? time() : $preTime;
    $curTime = time();
    //上次结束到本次开始，流出去的水
    $leakWater = ($curTime-$preTime)*$leakRate;
    //上次结束时候的水量减去流出去的水，也就是本次初始水量
    $water = $water-$leakWater;
    //水量不可能为负，漏出大于进入则水量为0
    $water = ( $water>=0 ) ? $water : 0 ;
    //更新本次漏完水的时间
    $preTime = $curTime;
    //水小于总容量则可注入，否则不可注入
    if( ($water+$addNum) <= $contain ){
        $water += $addNum;
        return true;
    }else{
        return false;
    }

}

/**
 * 测试
 * @var integer
 */
for($i=0;$i<500;$i++){
    $res = leaky(50,1,5,$water,$timeStamp);
    var_dump($res);
    usleep(50000);
}

