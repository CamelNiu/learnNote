<?php

pcntl_signal(SIGUSR2, function () {
    var_dump('signal');
}, false);


while (1) {
    pcntl_signal_dispatch();
}

