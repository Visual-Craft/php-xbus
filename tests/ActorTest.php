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
            new \XbusClient\Actor('http://test.test', 'theApiKey')
        );
    }

    public function testCanSend(): void
    {
        $mypost = function ($url, $headers):\Requests_Response {
            $this->assertEquals("http://test.test", $url);
            $this->assertEquals("theApiKey", $headers["Xbus-Api-Key"]);

            $ack = new \Xbus\EnvelopeAck();
            $ack->setStatus(\Xbus\EnvelopeAck_ReceptionStatus::ACCEPTED);

            $res = new \Requests_Response();
            $res->success = true;
            $res->status_code = 200;
            $res->headers = array(
                'Content-Type'=> 'application/x-protobuf'
            );
            $res->body = $ack->serializeToString();
            return $res;
        };

        $actor = new \XbusClient\Actor('http://test.test', 'theApiKey');
        $actor->setRequestPost($mypost);
        $actor->emitItems("a.event.type", "item1", "item2");
    }

    public function testCanHandleRequest(): void
    {

        $processRequest = new \Xbus\ActorProcessRequest();

        $input = fopen("php://memory", "rw");
        fwrite($input, $processRequest->serializeToString());
        fseek($input, 0);

        $setHeader = function ($h) {
            $this->assertEquals("Content-Type: application/x-protobuf", $h);
        };
        $output = fopen("php://memory", "rw");

        $actor = new \XbusClient\Actor('http://test.test', 'theApiKey');


        $handler = function ($processRequest): ?\Xbus\ActorProcessingState {
            return null;
        };

        $actor->handleRequest(
            "application/x-protobuf", $input, $setHeader, $output, $handler
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
}

?>
