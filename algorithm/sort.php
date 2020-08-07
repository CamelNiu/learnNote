<?php


class sort
{



    public function __construct()
    {

    }

    public function main($arr = [])
    {

        $arr = range(1,36,3);
        shuffle($arr);

        print_r($arr);


        $arr2 = $this->sortSelect($arr);


        print_r($arr2);

        // $time1 = microtime(true);

        // $res = $this->sortQuick($arr);

        // $time2 = microtime(true);

        // var_dump($time2-$time1);

        // var_dump(reset($res));
        // var_dump(array_pop($res));



        // $time3 = microtime(true);

        // $resbub = $this->sortBubble($arr);

        // $time4 = microtime(true);

        // var_dump($time4-$time3);

        // var_dump(reset($resbub));
        // var_dump(array_pop($resbub));
    }


    public function sortSelect($arr)
    {
        $len = count($arr);
        if($len <=1){
            return $arr;
        }

        for($i=0;$i<$len-1;$i++){
            //假设$p是最小值得key
            $p = $i;
            for($j=$i+1;$j<$len;$j++){
                if( $arr[$j] < $arr[$p] ){
                    $p = $j;
                }
            }

            if( $p != $i ){
                $tmp = $arr[$p];
                $arr[$p] = $arr[$i];
                $arr[$i] = $tmp;
            }
        }

        return $arr;

    }

    public function sortBubble($arr)
    {
        if( count($arr)<=1 ){
            return $arr;
        }

        for($i=1;$i<count($arr);$i++){
            for($j=0;$j<count($arr)-$i;$j++){
                if($arr[$j]>$arr[$j+1]){
                    $tmp = $arr[$j];
                    $arr[$j] = $arr[$j+1];
                    $arr[$j+1] = $tmp;
                }
            }
        }

        return $arr;

    }

    /**
     * [sortQuick 快速排序]
     * @Author   [NiuShao                   <camel_niu@163.com> <qq:370574131>]
     * @DateTime [2020-08-03T19:09:14+0800]
     * @param    [type]                     $arr                [description]
     * @return   [type]                                         [description]
     */
    public function sortQuick($arr)
    {
        if( count($arr)<=1 ){
            return $arr;
        }

        $base = $arr[0];
        unset($arr[0]);
        $greatArr = [];
        $lessArr = [];
        foreach ($arr as $key => $value) {
            if($base<$value){
                $greatArr[] = $value;
            }elseif($base>$value){
                $lessArr[] = $value;
            }
        }
        $greatArr = $this->sortQuick($greatArr);
        $lessArr = $this->sortQuick($lessArr);


        $res = array_merge($lessArr,[$base],$greatArr);

        return $res;

    }

}



(new sort)->main();


