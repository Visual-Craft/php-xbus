# php-xbus

A PHP client for Xbus.

This client relies on the xbus-http gateway, and is limited to implementing
emitters, consumers and workers.

## Installation

```php
composer require orus-io/php-xbus dev-default
```

## Usage

### Emit a message

To emit a simple envelope with one events containing one or more items:

```php
<?php
$actor = new \XbusClient\Actor('http://test.test', 'emittername', 'theApiKey');
$actor->emitItems("a.event.type", "item1", "item2");
?>
```

### Receive a message

Receiving messages rely on the webhook feature of xbus-http. The client application
must provide a http endpoint, on which xbus-http will POST some data.

A typical implementation for the endpoint is:

```php
<?php
$actor = new \XbusClient\Actor('http://test.test', 'consumername', 'theApiKey');
$actor->handleRequest(
    $_SERVER['HTTP_CONTENT_TYPE'],  // <- The incoming request content type
    fopen('php://input', 'r'),  // <- The incoming request body (as a resource)
    'header',  // <- a callable that set a header on the response
    'http_response_code',  // <- a callable that sets the http response code
    fopen('php://output', 'w'), // The response body resource

    // The user-defined handler. This example one will print the incoming items
    function(\Xbus\ActorProcessRequest $request): ?\Xbus\ActorProcessingState {
        foreach($request->getInputs() as $input) {
            print "input: " . $input.getName();
            foreach($input->getEnvelope()->getEvents() as $event) {
                print "event: " . $event.getType();
                foreach($event->getItems() as $item) {
                    print "item: " . $item;
                }
            };
        };
    }
);
?>
```
