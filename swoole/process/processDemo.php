<?php



class ProcessDemo
{
    public function main()
    {
        $this->mutiProcess();
    }

    public function mutiProcess()
    {

        $processNum = 200;

        for($n = 1;$n<=$processNum;$n++){
            $process = new \Swoole\Process([$this,'execProcess']);
            $pid = $process->start();
        }

        for($n=$processNum;$n>=0;$n--){
            $status = \Swoole\Process::wait(true);
        }

    }

    public function execProcess()
    {
        while (true) {
            $data = $this->get("http://www.niushao.net/getipinfo?ip=119.123.132.182");
            echo ($data);
        }
    }


    public function get($url)
    {        //初始化
        $ch = curl_init();
        //设置选项，包括URL
        //$url = $url.'?'.http_bulid_query($data);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        //打印获得的数据
        return $output;
    }


}


( new ProcessDemo() ) ->main();