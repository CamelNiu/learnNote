<?php
namespace src\Container;

use Closure;
use Exception;

class Container
{
    //容器是单例模式
    protected static $instance;
    //容器
    protected $bindings = [];
    protected $instances = [];
    //注册方法
    public function bind($abstract,$object)
    {
        $this->bindings[$abstract] = $object;
    }

    //解析
    public function make($abstract,$parameters = [])
    {
        return $this->resolve($abstract,$parameters);
    }

    //是否绑定
    public function has($abstract)
    {
        return isset($this->bindings[$abstract]);
    }

    public function resolve($abstract,$parameters = [])
    {
        if( isset($this->instances[$abstract]) ){
            return $this->instances[$abstract];
        }

        if(!$this->has($abstract)){
            throw new Exception('没有找到这个容器对象'.$abstract, 500);
        }

        $object = $this->bindings[$abstract];

        if( $object instanceof Closure ){
            return $object;
        }

        return $this->instances[$abstract] = (is_object($object)) ? $object : new $object(...$parameters);
    }

    // 获取单例对象
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    //设置对象
    public static function setInstance($container = null)
    {
        return static::$instance = $container;
    }


}