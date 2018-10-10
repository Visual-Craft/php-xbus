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
    private $_requestPost;

    public function __construct(string $url, string $apiKey)
    {
        $this->_url = $url;
        $this->_apiKey = $apiKey;
        $this->_request_post = function ($url, $headers) {
            \Requests::post($url, $headers);
        };
    }

    public function setRequestPost(callable $requestPost): void
    {
        $this->_requestPost = $requestPost;
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

        $headers = array(
            'Content-Type'=> 'application/x-protobuf',
            'Content-Length'=> strlen($data),
            'Xbus-Api-Key'=> $this->_apiKey
        );

        $response = call_user_func($this->_requestPost, $this->_url, $headers);

        if ($response->status_code != 200) {
            throw new \Exception(
                "Error sending envelope: status=" . $response->status_code
                . ", body:" . $response->body
            );
        }
        $ack = new \Xbus\EnvelopeAck();
        $ack->mergeFromString($response->body);
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

    function handleRequest(
        string $contentType,
        $input,
        callable $responseHeader,
        $response,
        $cb
    ) {
        if ($contentType != "application/x-protobuf") {
            throw Exception("Invalid content type: " . $contentType);
        }
        $processRequest = new \Xbus\ActorProcessRequest();
        $processRequest->mergeFromString(fread($input, 1024*1024*2));

        try {
            $state = $cb($processRequest);
            if ($state == null) {
                $state = new \Xbus\ActorProcessingState();
                $state->setStatus(\Xbus\ActorProcessingState_Status::SUCCESS);
            }
        } catch(Exception $e) {
            $state = new \Xbus\ActorProcessingState();
            $state->setStatus(\Xbus\ActorProcessingState_Status::ERROR);

            $message = new \Xbus\LogMessage();
            $message.setText($e);

            $state->setMessages(array($message));
        }
        $responseHeader("Content-Type: application/x-protobuf");

        fwrite($response, $state->serializeToString());
    }
}

?>
