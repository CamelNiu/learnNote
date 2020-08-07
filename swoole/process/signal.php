<?php

pcntl_signal(SIGTERM,function(){
        echo "success \n";
});





while(true){
    pcntl_signal_dispatch();
}