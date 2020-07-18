<?php

require_once "./db.php";
$db = new DatabaseOperate();

$processNum = 2;

function task($i,$db){
    //5000

    for($j=0;$j<5;$j++){

        $sqlPre = "INSERT INTO big_data_test (`keys`) VALUES ";
        $sql = "";
        $tmp = "";
        for($a=0;$a<10000;$a++){
            $time = microtime(true);
            $keys = md5($i.$j.$a.$time);
            $tmp .= "('".$keys."'),";
        }

        $tmp = trim($tmp,',');

        $sql = $sqlPre.$tmp;

        $res = $db->getRows($sql);

        var_dump($res);


    }

}

for($i=0;$i<$processNum;$i++){
    $res = pcntl_fork();
    if($res>0){

    }elseif($res<0){

    }else{

            task($i,$db);

        exit;
    }
}


for ($i=0; $i < $processNum; $i++) {
    $status = 0;
    $son = pcntl_wait($status);
}


var_dump('finish');