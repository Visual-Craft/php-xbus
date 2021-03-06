<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: xbus/xbus.proto

namespace Xbus;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Protobuf type <code>xbus.ActorProcessRequest.Input</code>
 */
class ActorProcessRequest_Input extends \Google\Protobuf\Internal\Message
{
    /**
     * <pre>
     * Name of the input
     * </pre>
     *
     * <code>string name = 1;</code>
     */
    private $name = '';
    /**
     * <pre>
     * True if no envelope to expect
     * </pre>
     *
     * <code>bool close = 2;</code>
     */
    private $close = false;
    /**
     * <pre>
     * First envelope fragment if available
     * </pre>
     *
     * <code>.xbus.Envelope envelope = 3;</code>
     */
    private $envelope = null;
    /**
     * <pre>
     * Envelope position
     * </pre>
     *
     * <code>.xbus.EnvelopePosition position = 4;</code>
     */
    private $position = null;

    public function __construct() {
        \GPBMetadata\Xbus\Xbus::initOnce();
        parent::__construct();
    }

    /**
     * <pre>
     * Name of the input
     * </pre>
     *
     * <code>string name = 1;</code>
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * <pre>
     * Name of the input
     * </pre>
     *
     * <code>string name = 1;</code>
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;
    }

    /**
     * <pre>
     * True if no envelope to expect
     * </pre>
     *
     * <code>bool close = 2;</code>
     */
    public function getClose()
    {
        return $this->close;
    }

    /**
     * <pre>
     * True if no envelope to expect
     * </pre>
     *
     * <code>bool close = 2;</code>
     */
    public function setClose($var)
    {
        GPBUtil::checkBool($var);
        $this->close = $var;
    }

    /**
     * <pre>
     * First envelope fragment if available
     * </pre>
     *
     * <code>.xbus.Envelope envelope = 3;</code>
     */
    public function getEnvelope()
    {
        return $this->envelope;
    }

    /**
     * <pre>
     * First envelope fragment if available
     * </pre>
     *
     * <code>.xbus.Envelope envelope = 3;</code>
     */
    public function setEnvelope(&$var)
    {
        GPBUtil::checkMessage($var, \Xbus\Envelope::class);
        $this->envelope = $var;
    }

    /**
     * <pre>
     * Envelope position
     * </pre>
     *
     * <code>.xbus.EnvelopePosition position = 4;</code>
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * <pre>
     * Envelope position
     * </pre>
     *
     * <code>.xbus.EnvelopePosition position = 4;</code>
     */
    public function setPosition(&$var)
    {
        GPBUtil::checkMessage($var, \Xbus\EnvelopePosition::class);
        $this->position = $var;
    }

}

