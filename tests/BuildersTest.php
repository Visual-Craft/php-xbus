<?php
/* phpcs:disable PEAR.Commenting,Generic.Commenting */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;


final class Builders extends TestCase
{
    public function testBuildOutputRequest(): void
    {
        $envelope = \XbusClient\Builders::buildEnvelopeFromItems(
            "msg", "item1", "item2"
        );
        $request = \XbusClient\Builders::buildOutputRequest(
            null, "default", $envelope
        );

        $this->assertInstanceOf(
            \Xbus\OutputRequest::class,
            $request
        );

        $this->assertNull($request->getContext());

        $data = $request->serializeToString();

        $to = new \Xbus\OutputRequest();
        $to->mergeFromString($data);

        $this->assertEquals(
            "item1",
            $to
                ->getEnvelope()
                ->getEvents()[0]
                ->getItems()[0]
        );
        $this->assertEquals(
            "item2",
            $to
                ->getEnvelope()
                ->getEvents()[0]
                ->getItems()[1]
        );
    }
}

?>
