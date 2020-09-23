<?php

class Input
{
    /**
     * [info describe...]
     * @Author NiuShaoGang
     * @Email  camel_niu@163.com
     * @Time   2020/9/23 21:28
     * @param $message
     * @param null $description
     */
    public static function info($message, $description = null)
    {
        echo "======>>> ".$description." start\n";
        if (\is_array($message)) {
            echo \var_export($message, true);
        } else if (\is_string($message)) {
            echo $message."\n";
        } else {
            var_dump($message);
        }
        echo  "======>>> ".$description." end\n";
    }
}
