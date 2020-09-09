<?php

    /**
     * 四个部门以及部门人数
     * @var [type]
     */
    $arr = [
        'A' => 10,
        'B' => 7,
        'C' => 5,
        'D' => 4,
    ];

    $res = execOptimize($arr,10*12);

    print_r($res);

    /**
     * [execOptimize 执行按照月份为参数优化]
     * @Author   NiuShaoGang
     * @email    camel_niu@163.com
     * @qq       370574131
     * @wechat   CamelNiu
     * @DateTime 2020-08-17
     * @param    [type]
     * @param    [type]
     * @return   [type]
     */
    function execOptimize($arr,$monthNum)
    {
        for($i=0;$i<$monthNum;$i++){
            //优化一次的结果
            $arr = optimize($arr);
        }
        return $arr;
    }




    /**
     * [optimize 优化一次算法]
     * @Author   NiuShaoGang
     * @email    camel_niu@163.com
     * @qq       370574131
     * @wechat   CamelNiu
     * @DateTime 2020-08-17
     * @param    [type]
     * @return   [type]
     */
    function optimize($arr)
    {
        //最大值要减去的数
        $selNum = count($arr)-1;
        //获取最大值的key和value
        $maxValInfo = selMax($arr);
        $maxKey = $maxValInfo['k'];
        $maxVal = $maxValInfo['v'];
        $newArr = [];
        foreach($arr as $key => $val){
            if($key == $maxKey){
                $newArr[$key] = $val-$selNum;
            }else{
                $newArr[$key] = $val+1;
            }
        }
        return $newArr;
    }

    /**
     * [selMax 寻找数组中最大值算法]
     * @Author   NiuShaoGang
     * @email    camel_niu@163.com
     * @qq       370574131
     * @wechat   CamelNiu
     * @DateTime 2020-08-17
     * @param    [arr]
     * @return   [arr] k表示最大值的key,v表示最大值的value
     */
    function selMax($arr)
    {
        //假设最大值key为A
        $maxKey = 'A';
        foreach($arr as $key => $val){
            if($key == 'A') continue;
            if($val>$arr[$maxKey]){
                $maxKey = $key;
            }
        }
        return ['k'=>$maxKey,'v'=>$arr[$maxKey]];

    }
