<?php
$eventBase = new \EventBase;

$event2 = new Event($eventBase,-1,Event::PERSIST|Event::TIMEOUT,function(){
    echo "hello word event 02\n";
});

$event = new Event($eventBase,-1,Event::PERSIST|Event::TIMEOUT,function(){
    echo "hello word event\n";
});


$event->add(0.3);
$event2->add(0.2);

$eventBase->loop();

/*
Event       事件类
EventBase   事件库
Event::PERSIST 循环，持续执行
Event::TIMEOUT 失效时间，这里就是循环间隔时间
new Event 就是注册事件
$event->add添加已注册好的事件
$eventbase->loop() 就是事件库对事件执行操作
*/