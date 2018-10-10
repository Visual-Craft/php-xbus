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
        $actor = new \XbusClient\Actor('http://test.test', 'theApiKey');
        $actor->emitItems("a.event.type", "item1", "item2");
    }
}

?>
