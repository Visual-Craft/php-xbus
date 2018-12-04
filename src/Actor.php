<?php
/* phpcs:disable PEAR.Commenting,Generic.Commenting */


declare(strict_types=1);

namespace XbusClient;

use Psr\Log\LoggerInterface;

/**
 * Actor
 */
class Actor
{
    private $_url;
    private $_name;
    private $_apiKey;
    private $_requestPost;

    /**
     * @var LoggerInterface|null
     */
    private $_logger;

    public function __construct(string $url, string $name, string $apiKey)
    {
        $this->_url = $url;
        $this->_name = $name;
        $this->_apiKey = $apiKey;
        $this->_requestPost = function ($url, $headers, $data) {
            return \Requests::post($url, $headers, $data);
        };
    }

    public function setRequestPost(callable $requestPost): void
    {
        $this->_requestPost = $requestPost;
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->_logger = $logger;
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

        $response = call_user_func(
            $this->_requestPost,
            $this->_url . "/" . $this->_name . "/output",
            $headers,
            $data
        );

        if ($response->status_code != 200 || $response->body != "OK") {
            throw new \Exception(
                "Error sending envelope: status=" . $response->status_code
                . ", body:" . $response->body
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
        callable $responseCode,
        $response,
        $cb
    ) {
        if ($contentType != "application/x-protobuf") {
            call_user_func($responseCode, 400);
            fwrite($response, 'Invalid request: invalid content type');
            return;
        }
        $processRequest = new \Xbus\ActorProcessRequest();
        $processRequest->mergeFromString(fread($input, 1024*1024*2));

        if ($this->_logger !== null) {
            $this->_logger->info(__METHOD__ . ': decoded the incoming message');
        }

        if (count($processRequest->getInputs()) <1) {
            call_user_func($responseCode, 400);
            fwrite($response, "Invalid request: no input");
            return;
        }

        try {
            $state = call_user_func($cb, $processRequest);
            if ($state == null) {
                $state = new \Xbus\ActorProcessingState();
                $state->setStatus(\Xbus\ActorProcessingState_Status::SUCCESS);
            }
        } catch(\Exception $e) {
            if ($this->_logger !== null) {
                $this->_logger->error(__METHOD__ . ': caught an exception during processing request', array(
                    'exception' => $e,
                ));
            }

            $state = new \Xbus\ActorProcessingState();
            $state->setStatus(\Xbus\ActorProcessingState_Status::ERROR);

            $message = new \Xbus\LogMessage();
            $message->setText("Caught an exception: " . $e);
            $messages = array($message);

            $state->setMessages($messages);
        }
        call_user_func($responseHeader, "Content-Type: application/x-protobuf");

        fwrite($response, $state->serializeToString());
    }
}

?>
