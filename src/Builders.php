<?php
/* phpcs:disable PEAR.Commenting,Generic.Commenting */


declare(strict_types=1);

namespace XbusClient;

final class Builders
{
    static function buildEventFromItems(
        string $eventType,
        ...$items
    ): \Xbus\Event {
        $ev = new \Xbus\Event();
        $ev->setType($eventType);
        $ev->setItemCount(count($items));
        $ev->setItems($items);
        return $ev;
    }


    static function buildEnvelopeFromItems(
        string $eventType,
        ...$items
    ): \Xbus\Envelope {
        $events = array(Builders::buildEventFromItems($eventType, ...$items));
        $env = new \Xbus\Envelope();
        $env->setEvents($events);
        return $env;
    }

    /**
     * Build a \Xbus\OutputRequest
     *
     * @param \Xbus\ProcessingContext $context  A ProcessingContext or null
     * @param string                  $output   The output name
     * @param \Xbus\Envelope          $envelope The fragment to send
     *
     * @return \Xbus\OutputRequest The output request
     */
    static function buildOutputRequest(
        ?\Xbus\ProcessingContext $context,
        string $output,
        \Xbus\Envelope &$envelope
    ): \Xbus\OutputRequest {
        $request = new \Xbus\OutputRequest();
        if ($context != null) {
            $request.setContext($context);
        }
        $request->setOutput($output);
        $request->setEnvelope($envelope);
        return $request;
    }
}
