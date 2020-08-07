<?php

require "./init.php";

//$res = email::send('camel_niu@163.com','hahaha','niushaogang');

class coinNotify
{
    private $baseCoin = ['USDT','BTC','ETH'];
    private $tradeCoin = ['EOS','XPR','ETH','BTC'];
    private $url = "http://172.104.88.48:10082/";

    private $tradePairsAll = [
        'eosusdt',
        // 'btcusdt',
        // 'ethusdt',
        // 'xrpusdt',
        // 'bchusdt',
        // 'atomusdt',
        // 'bsvusdt',
    ];

    public function main()
    {

        while (true) {
            // sleep(30*60);
            // for($i=0;$i<=500;$i++){
                $this->run();
//            }
        }
    }

    private function run()
    {
        // $coinPairsAll = $this->getCoinPairsAll();
        // foreach($coinPairsAll as $val){
        foreach($this->tradePairsAll as $val){
            $val = strtolower($val);
            $this->execData($val);
        }
    }

    private function execData($val)
    {
        $url = $this->url."?symbol=".$val;
        $res = curl::get($url);
        $res = json_decode($res,true);

        $resStatus = isset($res['status']) ? $res['status'] : false;

        if($resStatus != "ok") return;
        $coinInfo = [];
        $coinInfo['bid_price'] = isset($res['tick']['bid'][0]) ? $res['tick']['bid'][0] : null;
        $coinInfo['ask_price'] = isset($res['tick']['ask'][0]) ? $res['tick']['ask'][0] : null;
        $coinInfo['cur_price'] = isset($res['tick']['close']) ? $res['tick']['close'] : null;
        $coinInfo['trade_pair'] = $val;

        var_dump($coinInfo);

        //if(empty($coinInfo)) return;

        $title=$val." Current Price";
        //$content = printf("Eos Price is %s",$coinInfo['cur_price']);
        $content = $val." is ".$coinInfo['cur_price'].".\nPlease Buy It";
        // $res = email::send('870266089@qq.com',$title,$content);
        // if($res == 'success'){
        //     log::WL('success','mailLog');

        // }else{
        //     log::WL('fail','mailLogError');
        // }
        // $res = email::send('370574131@qq.com',$title,$content);
        //var_dump($res);

    }

    private function getCoinPairsAll()
    {
        $coinPairsAll = [];
        foreach($this->baseCoin as $val){
            foreach($this->tradeCoin as $v){
                if($val == $v) continue;
                $coinPairsAll[] = strtolower(trim($v.$val));
            }
        }
        return $coinPairsAll;

    }


}


(new coinNotify)->main();