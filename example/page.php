<?php
/* phpcs:disable PEAR.Commenting,Generic.Commenting */

require __DIR__ . '/../vendor/autoload.php';

$actor = new \XbusClient\Actor('http://test.test', 'theApiKey');

$actor->handleRequest(
    $_SERVER['HTTP_CONTENT_TYPE'],  // <- The incoming request content type
    fopen('php://input', 'r'),  // <- The incoming request body (as a resource)
    'header',  // <- a callable that set a header on the response
    'http_response_code',  // <- a callable that sets the http response code
    fopen('php://output', 'w'), // The response body resource
    // The user-defined handler. This example one will print the incoming items
    function (\Xbus\ActorProcessRequest $request): ?\Xbus\ActorProcessingState {
        $event = $request->getInputs()[0]->getEnvelope()->getEvents()[0];
        $items = $event->getItems();

        $actor = new \XbusClient\Actor('http://localhost:8911', 'theApiKey');

        $actor->emitItems($event->getType(), ...$items);
    }
);

?>
