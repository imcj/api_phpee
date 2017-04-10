<?php
require 'vendor/autoload.php';

$loop = React\EventLoop\Factory::create();
$socket = new React\Socket\Server(8080, $loop);

use React\Promise\Promise;
use React\Http\Response;

function match($regexp, $subject)
{

}

$http = new React\Http\Server($socket, function($request) {

    return new Promise(function($resolve, $reject) use ($request) {
        $path = $request->getUri()->getPath();
        // TODO: use mrjgreen/phroute
        preg_match('/^\/ip/', $path, $matches);
        if (count($matches) > 0) {
            $response = new Response(
                200,
                array('Content-Type' => 'text/html'),
                $request->remoteAddress
            );
            $resolve($response);
        }
    });
});
$http->on("error", function($error) {
    var_dump($error->message);
});

$loop->run();