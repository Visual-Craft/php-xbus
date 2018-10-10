<?php
/* phpcs:disable PEAR.Commenting,Generic.Commenting */


declare(strict_types=1);

namespace XbusClient;

/**
 * Actor
 */
final class Actor
{
    private $_url;
    private $_apiKey;

    public function __construct(string $url, string $apiKey)
    {
        $this->_url = $url;
        $this->_apiKey = $apiKey;
    }

    /**
     * Send an envelope fragment
     *
     * @param \Xbus\ProcessingContext $context  A ProcessingContext or null
     * @param string                  $output   The output name
     * @param \Xbus\Envelope          $envelope The fragment to send
     *
     * @return void
     */
    public function send(
        ?\Xbus\ProcessingContext $context,
        string $output,
        \Xbus\Envelope &$envelope
    ):void {
        $request = Builders::buildOutputRequest($context, $output, $envelope);

        $data = $request->serializeToString();

        $httpRequest = curl_init($this->_url);
        curl_setopt($httpRequest, CURLOPT_POST, 1);
        curl_setopt(
            $httpRequest, CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/x-protobuf',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($httpRequest, CURLOPT_POSTFIELDS, $data);
        curl_setopt($httpRequest, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($httpRequest);

        $errno = curl_errno($httpRequest);
        if ($errno != 0) {
            throw new \Exception(
                "Error sending envelope: curl error=" . curl_error($httpRequest)
            );

        }
        $status = curl_getinfo($httpRequest, CURLINFO_HTTP_CODE);
        curl_close($httpRequest);

        if ($status != 200) {
            throw new \Exception(
                "Error sending envelope: status=" . $status . ", body:" . $response
            );
        }
        $ack = new \Xbus\EnvelopeAck();
        $ack->mergeFromString($response);
        if ($ack->getStatus() == \Xbus\EnvelopeAck_ReceptionStatus::ERROR ) {
            throw new Exception(
                "Envelope was not accepted by the server. Reason: "
                . $ack->getReason()
            );
        }
    }

    function emitItems(
        string $eventType,
        ...$items
    ): void {
        $envelope = Builders::buildEnvelopeFromItems($eventType, ...$items);
        $this->send(null, "default", $envelope);
    }
}

?>
