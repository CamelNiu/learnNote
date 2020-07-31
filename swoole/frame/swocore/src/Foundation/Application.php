<?php
namespace src\Foundation;

use src\Server\Http\HttpServer;
use src\Container\Container;
use src\Routes\Route;

class Application extends Container
{
    protected const SWOSTAR_WELCOME = "
      _____                     _____     ___
     /  __/             ____   /  __/  __/  /__   ___ __    __  __
     \__ \  | | /| / / / __ \  \__ \  /_   ___/  /  _`  |  |  \/ /
     __/ /  | |/ |/ / / /_/ /  __/ /   /  /_    |  (_|  |  |   _/
    /___/   |__/\__/  \____/  /___/    \___/     \___/\_|  |__|
    ";

    protected $basePath = "";

    public function __construct($path = null)
    {
        if(!empty($path)){
            $this->setBasePath($path);
        }

        $this->registerBaseBindings();

        //$this->init();

        echo self::SWOSTAR_WELCOME."\n";
    }

    public function run()
    {
        $httpServer = new HttpServer($this);
        $httpServer->start();
    }

    // public function init()
    // {
    //     $this->bind('route',Route::getInstance());
    //     var_dump($this->bindings);
    //     //var_dump(Route::getInstance()->registerRoute()->getRoutes());
    // }

    public function registerBaseBindings()
    {
        self::setInstance($this);
        $binds = [
            // 标识  ， 对象
            //'index'       => (new \src\Index()),
            'httpRequest' => (new \src\Message\Http\HttpRequest()),
            'route'       => Route::getInstance(),
        ];
        foreach ($binds as $key => $value) {
            $this->bind($key, $value);
        }
        //var_dump($this->bindings);
    }

    public function setBasePath($path)
    {
        $this->basePath = \rtrim($path,"\/");
    }

    public function getBasePath()
    {
        return $this->basePath;
    }

}