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
}

?>
