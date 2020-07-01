<?php



function leak($container,$rate,$addNum,&$water,&$preTime)
{
    $water = empty($water) ? 0 : $water;
    $preTime = empty($preTime) ? time() : $preTime;
    $nowTime = time();
    $water = $water-( ($nowTime-$preTime)*$rate );
    $water = ( $water>=0 ) ? $water : 0 ;
    $preTime = $nowTime;

    if( ($water+$addNum)<=$container ){
        $water = $water+$addNum;
        return true;
    }else{
        return false;
    }

}

$i=0;

while (true) {
    $i++;
    $res = leak(5,4,3,$water,$preTime);
    var_dump($res);
    var_dump($i);
    usleep(100000);
}
