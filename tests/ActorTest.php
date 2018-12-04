<?php
/* phpcs:disable PEAR.Commenting,Generic.Commenting */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;


final class ActorTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $this->assertInstanceOf(
            \XbusClient\Actor::class,
            new \XbusClient\Actor('http://test.test', 'aname', 'theApiKey')
        );
    }

    public function testCanSend(): void
    {
        $mypost = function ($url, $headers):\Requests_Response {
            $this->assertEquals("http://test.test/sender/output", $url);
            $this->assertEquals("theApiKey", $headers["Xbus-Api-Key"]);
            $this->assertEquals("application/x-protobuf", $headers["Content-Type"]);

            $res = new \Requests_Response();
            $res->success = true;
            $res->status_code = 200;
            $res->headers = array(
                'Content-Type'=> 'text/plain'
            );
            $res->body = 'OK';
            return $res;
        };

        $actor = new \XbusClient\Actor('http://test.test', 'sender', 'theApiKey');
        $actor->setRequestPost($mypost);
        $actor->emitItems("a.event.type", "item1", "item2");
    }

    public function testCanHandleRequest(): void
    {
        $inputs = array(new \Xbus\ActorProcessRequest_Input());
        $processRequest = new \Xbus\ActorProcessRequest();
        $processRequest->setInputs($inputs);

        $input = fopen("php://memory", "rw");
        fwrite($input, $processRequest->serializeToString());
        fseek($input, 0);

        $setHeader = function ($h) {
            $this->assertEquals("Content-Type: application/x-protobuf", $h);
        };
        $setHttpCode = function ($code) {
            $this->assertFalse(true, "Should be called only on errors");
        };
        $output = fopen("php://memory", "rw");

        $actor = new \XbusClient\Actor('http://test.test', 'receiver', 'theApiKey');


        $handler = function ($processRequest): ?\Xbus\ActorProcessingState {
            return null;
        };

        $actor->handleRequest(
            "application/x-protobuf",
            $input, $setHeader, $setHttpCode, $output, $handler
        );
        fseek($output, 0);

        // Check output and header
        $state = new \Xbus\ActorProcessingState();
        $data = fread($output, 1024*1024*2);
        $state->mergeFromString($data);
        $this->assertEquals(
            \Xbus\ActorProcessingState_Status::SUCCESS,
            $state->getStatus(),
            "Error: " . Utils::printMessages($state->getMessages())
        );
    }

    public function testHandleRequestWithInvalidContentType(): void
    {
        $inputs = array(new \Xbus\ActorProcessRequest_Input());
        $processRequest = new \Xbus\ActorProcessRequest();
        $processRequest->setInputs($inputs);

        $input = fopen('php://memory', 'rwb');
        fwrite($input, $processRequest->serializeToString());
        fseek($input, 0);

        $setHeader = function ($h) {};
        $responseHttpCode = null;
        $setHttpCode = function ($code) use (&$responseHttpCode) {
            $responseHttpCode = $code;
        };
        $output = fopen('php://memory', 'rwb');

        $actor = new \XbusClient\Actor('http://test.test', 'receiver', 'theApiKey');

        $handler = function ($processRequest): ?\Xbus\ActorProcessingState {
            return null;
        };


        $actor->handleRequest(
            'text/html',
            $input, $setHeader, $setHttpCode, $output, $handler
        );


        fseek($output, 0);
        $responseBody = stream_get_contents($output);
        $this->assertEquals(400, $responseHttpCode, 'Unexpected response HTTP code');
        $this->assertEquals('Invalid request: invalid content type', $responseBody, 'Unexpected response body');
    }

    public function testHandleRequestLogging(): void
    {
        $logger = $this->getMockBuilder(\Psr\Log\LoggerInterface::class)->getMock();
        $logger
            ->expects($this->once())
            ->method('info')
            ->with($this->equalTo(\XbusClient\Actor::class . '::handleRequest: decoded the incoming message'))
        ;
        $logger->expects($this->never())->method('error');

        $actor = new \XbusClient\Actor('http://test.test', 'receiver', 'theApiKey');
        $actor->setLogger($logger);
        $actor->setRequestPost(function ($url, $headers): \Requests_Response {
            $res = new \Requests_Response();
            $res->success = true;
            $res->status_code = 200;
            $res->headers = array(
                'Content-Type'=> 'application/x-protobuf'
            );
            $res->body = 'OK';

            return $res;
        });
        $inputs = array(new \Xbus\ActorProcessRequest_Input());
        $processRequest = new \Xbus\ActorProcessRequest();
        $processRequest->setInputs($inputs);
        $input = fopen('php://memory', 'rw');
        fwrite($input, $processRequest->serializeToString());
        fseek($input, 0);
        $setHeader = function ($h) {
            $this->assertEquals('Content-Type: application/x-protobuf', $h);
        };
        $setHttpCode = function ($code) {

        };
        $output = fopen('php://memory', 'rw');
        $handler = function ($processRequest): ?\Xbus\ActorProcessingState {
            return null;
        };

        $actor->handleRequest(
            'application/x-protobuf',
            $input, $setHeader, $setHttpCode, $output, $handler
        );
    }

    public function testHandleRequestWithErrorLogging(): void
    {
        $exception = new \Exception('message');
        $logger = $this->getMockBuilder(\Psr\Log\LoggerInterface::class)->getMock();
        $logger
            ->expects($this->once())
            ->method('error')
            ->with(
                $this->equalTo(\XbusClient\Actor::class . '::handleRequest: caught an exception during processing request'),
                $this->equalTo(array(
                    'exception' => $exception,
                ))
            )
        ;

        $actor = new \XbusClient\Actor('http://test.test', 'receiver', 'theApiKey');
        $actor->setLogger($logger);
        $actor->setRequestPost(function ($url, $headers): \Requests_Response {
            $res = new \Requests_Response();
            $res->success = true;
            $res->status_code = 200;
            $res->headers = array(
                'Content-Type'=> 'application/x-protobuf'
            );
            $res->body = 'OK';

            return $res;
        });
        $inputs = array(new \Xbus\ActorProcessRequest_Input());
        $processRequest = new \Xbus\ActorProcessRequest();
        $processRequest->setInputs($inputs);
        $input = fopen('php://memory', 'rw');
        fwrite($input, $processRequest->serializeToString());
        fseek($input, 0);
        $setHeader = function ($h) {
            $this->assertEquals('Content-Type: application/x-protobuf', $h);
        };
        $setHttpCode = function ($code) {

        };
        $output = fopen('php://memory', 'rw');
        $handler = function ($processRequest) use ($exception): ?\Xbus\ActorProcessingState {
            throw $exception;
        };

        $actor->handleRequest(
            'application/x-protobuf',
            $input, $setHeader, $setHttpCode, $output, $handler
        );
    }
}

?>
