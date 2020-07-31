<?php

use src\Console\Input;
use src\Foundation\Application;

if (!function_exists('app')) {

    /**
     * [app description]
     * @Author   [NiuShao                   <camel_niu@163.com> <qq:370574131>]
     * @DateTime [2020-07-27T17:47:56+0800]
     * @param    [type]                     $a                  [description]
     * @return   [type]                                         [description]
     */
    function app($a = null)
    {
        if (empty($a)) {
            return Application::getInstance();
        }
        return Application::getInstance()->make($a);
    }
}
if (!function_exists('dd')) {

    /**
     * [dd description]
     * @Author   [NiuShao                   <camel_niu@163.com> <qq:370574131>]
     * @DateTime [2020-07-27T17:47:53+0800]
     * @param    [type]                     $message            [description]
     * @param    [type]                     $description        [description]
     * @return   [type]                                         [description]
     */
    function dd($message, $description = null)
    {
        Input::info($message, $description);
    }
}