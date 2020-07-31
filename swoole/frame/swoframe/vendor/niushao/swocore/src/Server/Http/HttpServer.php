<?php
namespace src\Server\Http;
use src\Server\Server;
use Swoole\Http\Server as SwooleServer;
use src\Message\Http\HttpRequest;


use Swoole\Http\Request as SwooleRequest;
use Swoole\Http\Response as SwooleResponse;

/**
 * http server
 */
class HttpServer extends Server
{

    /**
     * [createServer description]
     * @Author   [NiuShao                   <camel_niu@163.com> <qq:370574131>]
     * @DateTime [2020-07-23T10:35:19+0800]
     * @return   [type]                     [description]
     */
    public function createServer()
    {
        $this->swooleServer = new SwooleServer($this->host,$this->port);
    }

    /**
     * [initEvent description]
     * @Author   [NiuShao                   <camel_niu@163.com> <qq:370574131>]
     * @DateTime [2020-07-23T10:35:12+0800]
     * @return   [type]                     [description]
     */
    protected function initEvent()
    {
        $this->setEvent('sub',[
            'request' => 'onRequest',
        ]);
    }

    /**
     * [onRequest swoole，http事件独有的]
     * @Author   [NiuShao                   <camel_niu@163.com> <qq:370574131>]
     * @DateTime [2020-07-23T10:34:50+0800]
     * @param    [type]                     $request            [description]
     * @param    [type]                     $response           [description]
     * @return   [type]                                         [description]
     */
    public function onRequest(SwooleRequest $request, SwooleResponse $response)
    {
        $uri = $request->server['request_uri'];
        if ($uri == '/favicon.ico') {
            $response->status(404);
            $response->end('die');
            return;
        }

        $httpRequest = HttpRequest::init($request);
        dd($httpRequest->getMethod(), "Method");
        dd($httpRequest->getUriPath(), "UriPath");
        $response->end("<h1>success</h1>");

    }

}