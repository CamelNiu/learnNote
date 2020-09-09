<?php



/**
 * [checkInviteCode 计算数据，返回结果]
 * @Author   NiuShaoGang
 * @email    camel_niu@163.com
 * @qq       370574131
 * @wechat   CamelNiu
 * @DateTime 2020-08-18
 * @param    [type]            $inviteCode [description]
 * @return   [type]                        [description]
 */
function checkInviteCode($inviteCode)
{
    //从序列号最后⼀位字符开始，逆向将奇数位所有元素
    $letInfo = selFirstInfo($inviteCode,'letter');
    //从序列号最后⼀位数字开始，逆向将偶数位所有元素
    $intInfo = selFirstInfo($inviteCode,'int');
    //计算奇数位元素
    $letRes = getRes($letInfo,'letter');
    //计算偶数位元素
    $intRes = getRes($intInfo,'int');

    //求和，除以10
    if( ($letRes+$intRes)%10 === 0 ){
        echo "ok";
    }else{
        echo "error";
    }


}

$inviteCode = "34i5m6n7ixjuaa88";
checkInviteCode($inviteCode);







/**
 * [getLetterNum 输入邀请码单元字符，返回对应的数值]
 * @Author   NiuShaoGang
 * @email    camel_niu@163.com
 * @qq       370574131
 * @wechat   CamelNiu
 * @DateTime 2020-08-18
 * @param    [type]            $str [description]
 * @return   [type]                 [description]
 */
function getLetterNum($str)
{
    if( preg_match('/^[0-9]$/', $str) ){
        return $str;
    }

    $letterInfo = [];
    $j = 1;
    for($i=ord('a');$i<=ord('z');$i++){
        $letterInfo[chr($i)] = $j;
        $j++;
    }
    $num = $letterInfo[$str]%9;
    return $num;
}

/**
 * [strReverse 邀请码检查长度，并且反转]
 * @Author   NiuShaoGang
 * @email    camel_niu@163.com
 * @qq       370574131
 * @wechat   CamelNiu
 * @DateTime 2020-08-18
 * @param    [type]            $inviteCode [description]
 * @return   [type]                        [description]
 */
function strReverse($inviteCode)
{
    //检验字符串长度
    $i = 0;
    $res = true;
    while ($res) {
        @$res = $inviteCode[$i];
        if(!$res) break;
        $i++;
    }

    if( ($i-1) != 15){
        throw new \Exception("位数不满足,必须16位",-1);
    }

    //将数组反转，数组的键设置为逆向序号
    $revStr = "";
    $k = 15;
    while ($k>=0) {
        $revStr .= $inviteCode[$k];
        $k--;

    }

    return $revStr;

}


/**
 * [selFirstInfo 根据最后一位数字/字符,奇数/偶数的条件,返回其对应的所有字符]
 * @Author   NiuShaoGang
 * @email    camel_niu@163.com
 * @qq       370574131
 * @wechat   CamelNiu
 * @DateTime 2020-08-18
 * @param    [type]            $inviteCode [description]
 * @param    string            $handle     [description]
 * @return   [type]                        [description]
 */
function selFirstInfo($inviteCode,$handle="int")
{
    $revStr = strReverse($inviteCode);
    $firstKey = 0;

    $res = true;
    while ($res) {
        @$res = $revStr[$firstKey];
        $reg = ($handle == "letter") ? "/^[a-z]$/" : "/^[0-9]$/" ;
        $pregRes = preg_match($reg,$res);
        if($pregRes) break;
        $firstKey++;
    }

    $i = $firstKey;

    $letData = [];

    while ($i<=15) {
        $tmp = 1-$firstKey;
        $newKey = $i+$tmp;

        switch ($handle) {
            case 'letter':
                    if($newKey%2 == 1){
                        $letData[] = ($revStr[$i]);
                    }
                break;

            case 'int':
                    if($newKey%2 === 0){
                        $letData[] = $revStr[$i];
                    }
                break;
        }

        $i++;
    }
    return $letData;
}

/**
 * [getRes 根据条件要求对奇数位/偶数位求和]
 * @Author   NiuShaoGang
 * @email    camel_niu@163.com
 * @qq       370574131
 * @wechat   CamelNiu
 * @DateTime 2020-08-18
 * @param    [type]            $arr    [description]
 * @param    string            $handle [description]
 * @return   [type]                    [description]
 */
function getRes($arr,$handle="letter")
{
    if($handle == 'letter'){
        $sumNum = 0;
        foreach($arr as $val){
            $num = getLetterNum($val);
            $sumNum += $num;
        }
        return $sumNum;
    }else{
        $sumNum = 0;
        foreach($arr as $val){
            $tmpNum = getLetterNum($val)*2;
            if($tmpNum>9){
                $tmpNum = $tmpNum-9;
            }
            $sumNum += $tmpNum;
        }
        return $sumNum;
    }
}



